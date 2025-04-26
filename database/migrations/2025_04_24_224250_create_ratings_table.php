<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('value')->check('value BETWEEN 1 AND 5');
            $table->timestamps();
            $table->unique(['book_id', 'user_id']); // One rating per user per book
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};