<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     * Este método é para a listagem geral de projetos (ex: um painel admin).
     * Para a listagem de projetos do próprio usuário (ProjectController@index),
     * a lógica de filtragem pelo user_id já acontece no controller.
     * Se não há uma listagem geral de projetos de outros usuários, pode retornar false.
     */
    public function viewAny(User $user): bool
    {
        return true; // Ou false, dependendo se há uma rota que liste todos os projetos
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        // Usuário pode ver o projeto se for o dono OU se o projeto for público.
        if ($project->public) {
            return true;
        }
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Qualquer usuário autenticado pode criar um projeto.
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        // Apenas o dono do projeto pode atualizá-lo.
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
       // Apenas o dono do projeto pode deletá-lo.
       return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        // Apenas o dono do projeto pode restaurá-lo (se usar SoftDeletes).
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        // Apenas o dono do projeto pode deletá-lo permanentemente (se usar SoftDeletes).
        return $user->id === $project->user_id;
    }
}
