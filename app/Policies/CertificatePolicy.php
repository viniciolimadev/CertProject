<?php

namespace App\Policies;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CertificatePolicy
{
    /**
     * Determine whether the user can view any models.
     * Geralmente usado para verificar se o usuário pode acessar a página de listagem.
     */
    public function viewAny(User $user): bool
    {
        return true; // Qualquer usuário logado pode ver sua própria lista de certificados.
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Certificate $certificate): bool
    {
        // Somente o proprietário do certificado pode visualizá-lo.
        return $user->id === $certificate->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Qualquer usuário logado pode criar um certificado.
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * (Você precisaria de um método 'edit' e 'update' no controller e um UpdateCertificateRequest)
     */
    public function update(User $user, Certificate $certificate): bool
    {
        // Somente o proprietário do certificado pode atualizá-lo.
        return $user->id === $certificate->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Certificate $certificate): bool
    {
       // Somente o proprietário do certificado pode deletá-lo.
       return $user->id === $certificate->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     * (Aplicável se você usar SoftDeletes no modelo Certificate)
     */
    public function restore(User $user, Certificate $certificate): bool
    {
        return $user->id === $certificate->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * (Aplicável se você usar SoftDeletes no modelo Certificate)
     */
    public function forceDelete(User $user, Certificate $certificate): bool
    {
        return $user->id === $certificate->user_id;
    }
}
