<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->query('sort_by', 'title');
        $sortDir = $request->query('sort_dir', 'asc');

        $query = Book::where('featured', true)
        ->withAvg('ratings', 'value')
        ->withCount('ratings');

        if (in_array($sortBy, ['title', 'author', 'available'])) {
            $query->orderBy($sortBy, in_array($sortDir, ['asc', 'desc']) ? $sortDir : 'asc');
        } else {
            $query->orderBy('title', 'asc');
        }

        $books = $query->get(['id', 'title', 'author', 'description', 'cover_image', 'slug', 'available']);

        return Inertia::render('Home', [
            'featuredBooks' => $books,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir,
        ]);
    }
}