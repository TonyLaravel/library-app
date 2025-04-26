<?php

namespace Tests\Feature;

use App\Models\{Book, Comment, Rating, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_leave_comment_and_rating(): void
    {
        $user = User::factory()->create(['role' => 'Customer']);
        $book = Book::factory()->create();

        // comment
        $this->actingAs($user)->post("/books/{$book->slug}/comments", [
            'content' => 'Fantastic read!',
        ])->assertRedirect("/books/{$book->slug}");

        $this->assertDatabaseHas(Comment::class, [
            'book_id' => $book->id,
            'user_id' => $user->id,
            'content' => 'Fantastic read!',
        ]);

        // rating
        $this->actingAs($user)->post("/books/{$book->slug}/ratings", [
            'value' => 4,
        ])->assertRedirect("/books/{$book->slug}");

        $this->assertDatabaseHas(Rating::class, [
            'book_id' => $book->id,
            'user_id' => $user->id,
            'value'   => 4,
        ]);
    }

    public function test_librarian_can_leave_comment_and_rating(): void
    {
        $user = User::factory()->create(['role' => 'Librarian']);
        $book = Book::factory()->create();

        // comment
        $this->actingAs($user)->post("/books/{$book->slug}/comments", [
            'content' => 'Fantastic read!',
        ])->assertRedirect("/books/{$book->slug}");

        $this->assertDatabaseHas(Comment::class, [
            'book_id' => $book->id,
            'user_id' => $user->id,
            'content' => 'Fantastic read!',
        ]);

        // rating
        $this->actingAs($user)->post("/books/{$book->slug}/ratings", [
            'value' => 4,
        ])->assertRedirect("/books/{$book->slug}");

        $this->assertDatabaseHas(Rating::class, [
            'book_id' => $book->id,
            'user_id' => $user->id,
            'value'   => 4,
        ]);
    }

    public function test_guest_cannot_leave_comment_or_rating(): void
    {
        $book = Book::factory()->create();

        $this->post("/books/{$book->slug}/comments", [
                'content' => 'Blocked',
            ])
            ->assertRedirect('/login');

        $this->post("/books/{$book->slug}/ratings", [
                'value' => 5,
            ])
            ->assertRedirect('/login');
    }
}
