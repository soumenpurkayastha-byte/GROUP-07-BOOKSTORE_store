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
    Schema::table('books', function (Blueprint $table) {
        $table->string('genre')->nullable();
        $table->integer('stock')->default(0);
        $table->string('publisher')->nullable();
        $table->year('year')->nullable();
        $table->string('language')->nullable();
        $table->float('rating')->default(0); // average rating
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('books', function (Blueprint $table) {
        $table->dropColumn(['genre', 'stock', 'publisher', 'year', 'language', 'rating']);
    });
}
};
