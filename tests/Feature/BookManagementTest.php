<?php

namespace Tests\Feature;

use App\Models\{Book, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_librarian_can_create_edit_and_delete_a_book(): void
    {
        $librarian = User::factory()->create(['role' => 'Librarian']);

        // create 
        $this->actingAs($librarian)
            ->post('/manage/books', [
                'title' => 'Test Book',
                'author' => 'Jane Doe',
                'slug' => 'test-book',
                'category' => 'horror',
                'isbn' => '1234567',
            ])
            ->assertRedirect('/manage/books');

        $book = Book::first();
        $this->assertEquals('Test Book', $book->title);

        // update
        $this->from('/manage/books')           
        ->put("/manage/books/{$book->id}", [
            'title' => 'Test Book2',
            'author' => 'Jane Doe2',
            'slug' => 'test-book2',
            'category' => 'horror2',
            'isbn' => '12345678',
        ]) ->assertRedirect('/manage/books');

        $this->assertEquals('Test Book2', $book->fresh()->title);

        // delete 
        $this->delete("/manage/books/{$book->id}")
            ->assertRedirect('/manage/books');

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
    public function test_customer_cannot_manage_books(): void
    {
        $customer = User::factory()->create(['role' => 'Customer']);
        $book = Book::factory()->create();

        $this->actingAs($customer)->post('/manage/books')
            ->assertForbidden();

        $this->actingAs($customer)->put("/manage/books/{$book->id}")
            ->assertForbidden();

        $this->actingAs($customer)->delete("/manage/books/{$book->id}")
            ->assertForbidden();
    }
}
