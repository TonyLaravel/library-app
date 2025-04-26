<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $response = Http::get('https://openlibrary.org/search.json', [
            'q' => 'subject:fiction',
            'limit' => 100,
            'fields' => 'key,title,author_name,first_publish_year,publisher,isbn,cover_i,subject,number_of_pages_median,first_sentence',
        ]);

        if ($response->failed()) {
            $this->command->error('Failed to fetch books from Open Library API.');
            return;
        }

        $books = $response->json()['docs'];
        $createdBooks = [];

        foreach ($books as $bookData) {
            if (empty($bookData['isbn']) || !is_array($bookData['isbn']) || empty($bookData['isbn'][0])) {
                continue;
            }

            // Clean and select first sentence for description
            $description = 'No description available.';
            if (!empty($bookData['first_sentence'])) {
                $sentence = is_array($bookData['first_sentence']) 
                    ? reset($bookData['first_sentence']) // Take first element
                    : $bookData['first_sentence'];
                $description = trim($sentence);
                // Limit to 255 characters to fit database field
                $description = Str::limit($description, 255, '...');
            }

            $book = [
                'title' => $bookData['title'] ?? 'Unknown Title',
                'author' => !empty($bookData['author_name']) ? implode(', ', $bookData['author_name']) : 'Unknown Author',
                'description' => $description,
                'cover_image' => !empty($bookData['cover_i']) ? "https://covers.openlibrary.org/b/id/{$bookData['cover_i']}-M.jpg" : null,
                'publisher' => !empty($bookData['publisher']) ? substr($bookData['publisher'][0], 0, 255) : null,
                'publication_date' => !empty($bookData['first_publish_year']) ? "{$bookData['first_publish_year']}-01-01" : null,
                'category' => !empty($bookData['subject']) ? implode(', ', array_slice($bookData['subject'], 0, 3)) : 'Fiction',
                'isbn' => $bookData['isbn'][0],
                'page_count' => $bookData['number_of_pages_median'] ?? null,
                'available' => true,
                'featured' => false,
            ];

            $baseSlug = Str::slug($book['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Book::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $book['slug'] = $slug;

            try {
                $createdBooks[] = Book::create($book);
            } catch (\Illuminate\Database\QueryException $e) {
                if (str_contains($e->getMessage(), 'books_isbn_unique')) {
                    $this->command->warn("Skipped book '{$book['title']}' due to duplicate ISBN: {$book['isbn']}");
                } else {
                    $this->command->error("Error creating book '{$book['title']}': {$e->getMessage()}");
                }
            }
        }

        // Randomly select 9 books to mark as featured
        $randomBooks = collect($createdBooks)->random(min(9, count($createdBooks)));
        foreach ($randomBooks as $book) {
            $book->update(['featured' => true]);
        }

        $this->command->info('Books generated.');
    }
}