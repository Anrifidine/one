<?php
// Dans app/Policies/PostPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->is_admin == 1;
    }

    public function update(User $user, Post $post)
    {
        return $user->is_admin == 1 || $user->id == $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
        return $user->is_admin == 1 || $user->id == $post->user_id;
    }
}
