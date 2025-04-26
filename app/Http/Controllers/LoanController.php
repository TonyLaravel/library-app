<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\RedirectResponse;

class LoanController extends Controller
{
    public function store(Book $book): RedirectResponse
    {
        $this->authorize('create', [Loan::class, $book]);

        $book->activeLoan()->delete();

        Loan::create([
            'book_id' => $book->id,
            'user_id' => auth()->id(),
            'due_at'  => now()->addDays(5),
        ]);

        return back()->with('flash', 'Book checked out! Due in 5 days.');
    }

    public function return(Loan $loan): RedirectResponse
    {
        $this->authorize('update', $loan);

        $loan->update(['returned_at' => now()]);

        return back()->with('flash', 'Book returned, thank you!');
    }
}
