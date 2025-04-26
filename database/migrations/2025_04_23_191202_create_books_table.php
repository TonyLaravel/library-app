<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('publisher')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('category');
            $table->string('isbn')->unique();
            $table->integer('page_count')->nullable();
            $table->boolean('available')->default(true);
            $table->boolean('featured')->default(false);
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};