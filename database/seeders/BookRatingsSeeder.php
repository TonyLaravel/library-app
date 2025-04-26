<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Book, User, Rating};   
use Illuminate\Support\Collection;

class BookRatingsSeeder extends Seeder
{
    /**
     * Seed every book with a random set of 3-15 ratings.
     */
    public function run(): void
    {
        $users = User::where('role', 'Customer')->pluck('id');   // only customers rate
        
        if ($users->isEmpty()) {
            $this->command->warn('No customers found skipping ratings.');
            return;
        }

        Book::all()->each(function (Book $book) use ($users) {
            // pick a random subset of users for this book
            $raterIds = $users->shuffle()->take(rand(3, 15));

            foreach ($raterIds as $userId) {
                Rating::updateOrCreate(
                    ['book_id' => $book->id, 'user_id' => $userId],
                    ['value'   => rand(1, 5)]
                );
            }
        });

        $this->command->info('Random ratings generated for all books');
    }
}
