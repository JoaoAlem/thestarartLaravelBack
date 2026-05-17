<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->first() ?? User::factory()->create([
            'email' => 'test@example.com',
        ]);

        Post::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
                'lang' => 'pt',
            ]);

        Post::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
                'lang' => 'en',
            ]);

        Post::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
                'lang' => 'es',
            ]);
    }
}
