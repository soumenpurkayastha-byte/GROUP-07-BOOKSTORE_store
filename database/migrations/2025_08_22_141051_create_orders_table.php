public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('user_tables')->onDelete('cascade'); // user who bought
        $table->foreignId('book_id')->constrained('books')->onDelete('cascade'); // which book
        $table->integer('quantity')->default(1);
        $table->decimal('total_price', 8, 2);
        $table->timestamps();
    });
}
