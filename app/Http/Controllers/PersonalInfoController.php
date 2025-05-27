<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePersonalInfoRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PersonalInfoController extends Controller
{
    public function __construct()
    {
        // Middleware 'auth' já deve proteger estas rotas.
    }

    /**
     * Mostra o formulário de edição de informações pessoais.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Garante que o perfil exista ou cria um novo.
        $profile = $user->profile()->firstOrCreate(
            ['user_id' => $user->id]
        );

        return view('personal_info.edit', compact('user', 'profile'));
    }

    /**
     * Atualiza as informações pessoais e o perfil do usuário.
     *
     * @param  \App\Http\Requests\UpdatePersonalInfoRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    

    public function update(UpdatePersonalInfoRequest $request)
    {
        // A validação já foi feita pelo FormRequest.
        $validatedData = $request->validated();

        /** @var \App\Models\User $user */
        $user = $request->user(); // $request->user() é uma forma comum de obter o usuário autenticado.

        // 1. Atualizar dados do modelo User (Nome e Email)
        $userDataToUpdate = [
            'name' => $validatedData['name'],
        ];
        if (isset($validatedData['email']) && $user->email !== $validatedData['email']) {
            $userDataToUpdate['email'] = $validatedData['email'];
            $userDataToUpdate['email_verified_at'] = null;
        }
        $user->update($userDataToUpdate);

        // 2. Preparar dados para o modelo UserProfile
        $profileData = [
            // ... (outros campos) ...
            'cep' => $validatedData['cep'] ?? null,
            'street_name' => $validatedData['street_name'] ?? null,
            'street_number' => $validatedData['street_number'] ?? null,
            'address_complement' => $validatedData['address_complement'] ?? null,
            'bairro' => $validatedData['bairro'] ?? null,
            'city' => $validatedData['city'] ?? null,
            'state' => $validatedData['state'] ?? null,
            'date_of_birth' => $validatedData['date_of_birth'] ?? null,
            'nationality' => $validatedData['nationality'] ?? null,
            'marital_status' => $validatedData['marital_status'] ?? null,
            'about_me' => $validatedData['about_me'] ?? null,
        ];

        // Trata os social_links (mantendo a lógica anterior)
        if (isset($validatedData['social_links'])) {
            $links = is_string($validatedData['social_links']) ? explode(',', $validatedData['social_links']) : $validatedData['social_links'];
            $profileData['social_links'] = array_filter(array_map('trim', $links));
        } else {
            $profileData['social_links'] = null;
        }


        // 3. Tratar upload da foto (mantendo a lógica anterior)
        if ($request->hasFile('photo')) {
            if ($user->profile && $user->profile->photo_path) {
                Storage::disk('public')->delete($user->profile->photo_path);
            }
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
            $profileData['photo_path'] = $photoPath;
        }

        // 4. Atualizar ou criar o perfil do usuário (agora inclui os novos campos)
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id], // Condição para encontrar
            $profileData              // Valores para atualizar ou criar
        );

        return redirect()->route('personal_info.edit')->with('success', 'Dados pessoais atualizados com sucesso!');
    }

    public function show()// Ou pode chamar de index() se preferir
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Garante que o perfil exista ou cria um novo para o usuário
        $profile = $user->profile()->firstOrCreate(
            ['user_id' => $user->id]
        );

        return view('personal_info.showInfoPessoal', compact('user', 'profile'));
    }
}
