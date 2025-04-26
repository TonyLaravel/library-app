<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ManageBookController extends Controller
{
    public function index()
    {
        return Inertia::render('ManageBooks/Index', [
            'books' => Book::orderBy('title')->paginate(15),
        ]);
    }

    public function create()
    {
        return Inertia::render('ManageBooks/Form', ['book' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Book::create($data);

        return redirect()->route('manage.books.index')
            ->with('flash', 'Book added!');
    }

    public function edit(Book $book)
    {
        $data = $book->toArray();
        $data['publication_date'] = optional($book->publication_date)->format('Y-m-d');
        return Inertia::render('ManageBooks/Form', [
            'book' => $data,
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $data = $this->validateData($request);
        $book->update($data);

        return back()->with('flash', 'Book updated!');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return back()->with('flash', 'Book removed!');
    }
    protected function validateData(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'cover_image' => 'nullable|url|max:255',
            'slug' => 'required|string|max:255|unique:books,slug,' . $request->id,
            'publisher' => 'nullable|string|max:255',
            'publication_date' => 'nullable|date',
            'category' => 'required|string|max:255',
            'isbn' => 'required|string|max:30',
            'page_count' => 'nullable|integer|min:1',
            'featured' => 'boolean',
        ]);
    }
}
