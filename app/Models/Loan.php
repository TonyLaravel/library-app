<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'book_id', 
        'user_id', 
        'due_at', 
        'returned_at'
    ];

    public function book() 
    {
        return $this->belongsTo(Book::class); 
    }
    public function user() 
    {
        return $this->belongsTo(User::class); 
    }
    public function scopeActive($q)  
    { 
        $q->whereNull('returned_at'); 
    }
    public function scopeOverdue($q) 
    { 
        $q->active()->where('due_at', '<', now()); 
    }
}

