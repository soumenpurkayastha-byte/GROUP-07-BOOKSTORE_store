<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ei function run hobe jokhon amra migration up korbo
    public function up(): void
    {
        // ekhane user_tables namer table create kortesi
        Schema::create('user_tables', function (Blueprint $table) {
            $table->id(); // auto increment primary key id
            $table->string('name'); // ekhane user er nam thakbe
            $table->string('email')->unique(); // email column, unique hobe
            $table->string('password'); // password store korar jonno
            $table->boolean('is_seller')->default(false); // jodi seller hoy taile true, default false
            $table->timestamps(); // created_at and updated_at column automatically add hobe
        });
    }

    // ei function run hobe jokhon amra migration rollback korbo
    public function down(): void
    {
        // ekhane user_tables table delete korbo jodi exist kore
        Schema::dropIfExists('user_tables');
    }
};
