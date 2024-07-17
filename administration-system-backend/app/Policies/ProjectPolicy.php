<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{

     /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return  $user->role->permissions->contains('name','projects-read');
    }
   

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return  $user->role->permissions->contains('name','projects-create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        return  $user->role->permissions->contains('name','projects-update');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return  $user->role->permissions->contains('name','projects-delete');

    }

   
}
