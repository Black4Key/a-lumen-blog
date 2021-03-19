<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory()->count(3)->create();
        $userIds = $users->map(function ($user) {
            return $user->id;
        })->toArray();
        
        $posts = collect();
        foreach (range(0, count($userIds)*5) as $number) {
            $post = Post::factory()->create(['user_id' => $userIds[array_rand($userIds)]]);
            $posts->add($post);
        }
        
        $postIds = $posts->map(function ($post) {
            return $post->id;
        })->toArray();

        foreach (range(0, count($postIds)*5) as $number) {
            Comment::factory()->create(['user_id' => $userIds[array_rand($userIds)], 'post_id' => $postIds[array_rand($postIds)]]);
        }
        
    }
}
