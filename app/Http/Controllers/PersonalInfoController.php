<?php

namespace App\Http\Controllers;

// Remova Illuminate\Http\Request se não for mais usado diretamente
use App\Http\Requests\UpdatePersonalInfoRequest; // Adicionado
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\User; // Para type hinting e operações
use Illuminate\Support\Facades\Storage; // Para deletar foto antiga

class PersonalInfoController extends Controller
{
    public function __construct()
    {
        // As rotas para este controller já devem estar protegidas pelo middleware 'auth'
        // em routes/web.php
    }

    // Mostrar formulário de edição
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Garante que o perfil exista ou cria um novo para o usuário
        // O método firstOrCreate é mais idiomático aqui.
        $profile = $user->profile()->firstOrCreate(
            ['user_id' => $user->id] // Condição para encontrar
            // Não precisa passar dados para criar aqui, pois serão preenchidos no formulário
        );

        return view('personal_info.edit', compact('user', 'profile'));
    }

    // Atualizar dados pessoais
    public function update(UpdatePersonalInfoRequest $request) // Alterado para UpdatePersonalInfoRequest
    {
        // A autorização (Auth::check()) e a validação já foram feitas pelo FormRequest.
        $validatedData = $request->validated();

        /** @var \App\Models\User $user */
        $user = Auth::user(); // Ou $request->user();

        // 1. Atualizar dados do modelo User
        $userDataToUpdate = [
            'name' => $validatedData['name'],
        ];
        // Apenas atualiza o email se ele foi realmente alterado e é diferente do atual
        if (isset($validatedData['email']) && $user->email !== $validatedData['email']) {
            $userDataToUpdate['email'] = $validatedData['email'];
            $userDataToUpdate['email_verified_at'] = null; // Invalida verificação de e-mail
            // Considere reenviar o e-mail de verificação aqui se a lógica for necessária
            // $user->sendEmailVerificationNotification();
        }
        $user->update($userDataToUpdate);


        // 2. Preparar dados para o modelo UserProfile
        $profileData = [
            'phone' => $validatedData['phone'] ?? null,
            'city' => $validatedData['city'] ?? null,
            'state' => $validatedData['state'] ?? null,
            // O e-mail do UserProfile pode ser redundante se for sempre o mesmo do User.
            // Se decidir mantê-lo, certifique-se de que está sincronizado.
            // 'email' => $validatedData['email'], // Removido para evitar redundância, use $user->email
        ];

        // Converte a string de social_links em array
        if (isset($validatedData['social_links']) && is_string($validatedData['social_links'])) {
            $profileData['social_links'] = array_filter(array_map('trim', explode(',', $validatedData['social_links'])));
        } elseif (isset($validatedData['social_links']) && is_array($validatedData['social_links'])) {
            $profileData['social_links'] = array_filter(array_map('trim', $validatedData['social_links']));
        } else {
            $profileData['social_links'] = null; // Garante que seja null se não enviado ou vazio
        }


        // 3. Tratar upload da foto
        if ($request->hasFile('photo')) {
            // Deletar foto antiga se existir
            if ($user->profile && $user->profile->photo_path) {
                Storage::disk('public')->delete($user->profile->photo_path);
            }
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
            $profileData['photo_path'] = $photoPath;
        }

        // 4. Atualizar ou criar o perfil do usuário
        // Usar updateOrCreate para lidar tanto com a criação (se o perfil não existir)
        // quanto com a atualização (se já existir).
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id], // Condições para encontrar o registro
            $profileData  // Valores para atualizar ou criar
        );

        return redirect()->route('personal_info.edit')->with('success', 'Dados pessoais atualizados com sucesso!');
        // Ou redirecionar para 'home' se preferir:
        // return redirect()->route('home')->with('success', 'Dados pessoais atualizados com sucesso!');
    }
}
