<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class PersonalInfoController extends Controller
{
    // Mostrar formulário de edição
    public function edit()
    {
        $user = Auth::user();
        $profile = UserProfile::firstOrNew(['user_id' => $user->id]);

        return view('personal_info.edit', compact('user', 'profile'));
    }

    // Atualizar dados pessoais
    public function update(Request $request)
{
    $user = $request->user();

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'email' => 'nullable|email|max:255',
        'social_links' => 'nullable|string',
        'photo' => 'nullable|image|max:2048', // validação da imagem (até 2MB)
    ]);

    // Atualiza o nome do usuário
    $user->name = $data['name'];
    if (!empty($data['email'])) {
        $user->email = $data['email'];
    }
    $user->save();

    // Atualiza os dados do perfil
    $profile = $user->profile ?? new UserProfile(['user_id' => $user->id]);

    if (isset($data['social_links'])) {
        $data['social_links'] = array_map('trim', explode(',', $data['social_links']));
    }

    // Remove campos que não pertencem ao profile
    unset($data['name'], $data['email'], $data['photo']);

    $profile->fill($data);

    // Tratar upload da foto
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('profile_photos', 'public');
        $profile->photo_path = $photoPath;
    }

    $profile->save();

    return redirect()->route('home')->with('success', 'Dados pessoais atualizados com sucesso!');
}



}
