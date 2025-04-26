<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use App\Models\Rating;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $books = Book::query()
        ->search($request->query('search'))
        ->withActiveLoan()
        ->withRatingStats()
        ->paginate(12);

        return Inertia::render('Books', [
            'books' => $books,         
            'search' => $search ?? '',
        ]);
    }

    public function show($slug)
    {
        $book = Book::where('slug', $slug)
            ->with(['comments.user', 'ratings', 'activeLoan'])
            ->firstOrFail();

        $averageRating = $book->ratings->avg('value') ?: 0;
        $ratingCount = $book->ratings->count();

        $userRating = auth()->check()
               ? $book->ratings()
               ->where('user_id', auth()->id())
               ->value('value')           // returns int|null
        : null;

        return Inertia::render('Book', [
            'book' => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'description' => $book->description,
                'cover_image' => $book->cover_image,
                'slug' => $book->slug,
                'is_available' => $book->is_available,
                'active_loan_id' => optional($book->activeLoan)->id,
                'publisher' => $book->publisher,
                'publication_date' => $book->publication_date ? Carbon::parse($book->publication_date)->format('F j, Y') : null,
                'category' => $book->category,
                'isbn' => $book->isbn,
                'page_count' => $book->page_count,
                'comments' => $book->comments->map(fn($comment) => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user_name' => $comment->user->name,
                    'created_at' => $comment->created_at->format('F j, Y'),
                ]),
                'average_rating' => round($averageRating, 1),
                'rating_count' => $ratingCount,
                'user_rating'      => $userRating,
            ],
        ]);
    }

    public function storeComment(Request $request, $slug)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $book = Book::where('slug', $slug)->firstOrFail();

        Comment::create([
            'book_id' => $book->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('books.show', $slug);
    }

    public function storeRating(Request $request, $slug)
    {
        $request->validate([
            'value' => 'required|integer|between:1,5',
        ]);

        $book = Book::where('slug', $slug)->firstOrFail();

        Rating::updateOrCreate(
            ['book_id' => $book->id, 'user_id' => Auth::id()],
            ['value' => $request->value]
        );

        return redirect()->route('books.show', $slug);
    }
}