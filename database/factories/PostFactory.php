<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'user_id' => User::factory(),
            'guid' => (string) Str::uuid(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 999999),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(8, true),
            'tags' => fake()->randomElements([
                'arte',
                'cultura',
                'literatura',
                'cinema',
                'musica',
                'teatro',
                'design',
                'fotografia',
                'historia',
                'critica',
            ], fake()->numberBetween(2, 5)),
            'publish_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'lang' => fake()->randomElement(['pt', 'en', 'es']),
            'visibility' => fake()->randomElement([1, 2]),
        ];
    }
}
