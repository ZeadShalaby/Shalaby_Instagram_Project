<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function show(User $user, Post $post){
        return $user->id == $post->user_id || in_array($post->user_id, $user->following()->where(['accepted' => 1])->pluck('to_user_id')->toArray());
    }
    public function delete(User $user, Post $post){
        return $user->id ==$post->user_id;
    }
    public function update(User $user, Post $post){
        return $user->id ==$post->user_id;
    }
    public function edit(User $user, Post $post){
        return $user->id ==$post->user_id;
    }

    public function show_friend(User $user, $user_id)
    {
        return $user->following()->where(['accepted' => 1, 'to_user_id' => $user_id])->count();
    }

}
