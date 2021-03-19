<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function update(User $user, Post $post)
    {
        return $this->checkUser($user, $post);
    }

    public function delete(User $user, Post $post)
    {
        return $this->checkUser($user, $post);
    }

    private function checkUser(User $user, Post $post) {
        return $user->id === $post->user_id;
    }
}