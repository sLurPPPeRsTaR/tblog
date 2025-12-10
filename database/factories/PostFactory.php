<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(rand(3, 8)),
            'excerpt' => fake()->text(200),
            'content' => fake()->paragraphs(rand(3, 10), true),
            'user_id' => User::factory(),
            'image' => null,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'updated_at' => fn(array $attributes) => $attributes['created_at'],
        ];
    }

    /**
     * Indicate that the post has an image.
     */
    public function withImage(): static
    {
        return $this->state(fn (array $attributes) => [
            'image' => 'posts/dummy-' . fake()->uuid() . '.jpg',
        ]);
    }
}

