<?php

namespace App\Policies;

use App\Models\Education;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EducationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Permite que o usuário veja sua própria lista.
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Education $education): bool
    {
        // Apenas o proprietário pode visualizar (se houver uma página de detalhes).
        return $user->id === $education->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Qualquer usuário autenticado pode criar.
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Education $education): bool
    {
        // Apenas o proprietário pode atualizar.
        return $user->id === $education->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Education $education): bool
    {
        // Apenas o proprietário pode deletar.
        return $user->id === $education->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Education $education): bool
    {
        return $user->id === $education->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Education $education): bool
    {
        return $user->id === $education->user_id;
    }
}
