<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('books', function (Blueprint $table) {
        $table->id();                       // Primary key - book ID
        $table->string('title');            // Book title
        $table->string('author');           // Author name
        $table->text('description')->nullable(); // Description (optional)
        $table->decimal('price', 8, 2);     // Price with 2 decimal places
        $table->string('cover_image')->nullable(); // Cover image filename (optional)
        $table->timestamps();               // created_at and updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
