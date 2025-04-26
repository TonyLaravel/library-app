<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LoanPolicy
{
    /** customers can create a loan only if the book is free */
    public function create(User $user, Book $book): bool
    {
        return $book->is_available;
    }

    /** only librarians can mark returned */
    public function update(User $user, Loan $loan): bool
    {
        return $user->isLibrarian();
    }
}
