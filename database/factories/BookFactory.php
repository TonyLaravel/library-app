<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    /** @var string */
    protected $model = Book::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(1);

        return [
            'title' => $title,
            'author' => fake()->name(),
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(),
            'cover_image' => null,
            'publisher' => fake()->company(),
            'publication_date' => fake()->date(),
            'category' => fake()->randomElement(['Fiction', 'History', 'Sci-Fi', 'Horror']),
            'isbn' => fake()->isbn13(),
            'page_count' => fake()->numberBetween(120, 600),
            'available' => true,
        ];
    }

}
