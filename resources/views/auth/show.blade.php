<!DOCTYPE html>
<html>
<head>
    <title>{{ $book->title }} - Bookstore</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#f4f4f4;
            padding:20px;
            color:#333;
        }
        .book-card {
            background-color:white;
            max-width:800px;
            margin: auto;
            padding:20px;
            border-radius:8px;
            box-shadow:0 2px 5px rgba(0,0,0,0.2);
        }
        img {
            float:left;
            margin-right:20px;
            width:200px;
            border-radius:6px;
        }
        h1 {
            color:#2c3e50;
        }
        p {
            margin:5px 0;
        }
        .buy-btn {
            padding:10px 15px;
            background:#27ae60;
            color:white;
            border:none;
            border-radius:6px;
            cursor:pointer;
            margin-top:15px;
        }
        .buy-btn:hover {
            background:#2ecc71;
        }
        .clear {
            clear:both;
        }
        .review-section {
            margin-top:30px;
        }
        .review-card {
            background:#ecf0f1;
            padding:10px;
            border-radius:5px;
            margin-bottom:10px;
        }
        textarea, input[type="number"] {
            width:100%;
            padding:8px;
            margin-bottom:8px;
            border-radius:4px;
            border:1px solid #ccc;
        }
        .review-btn {
            background:#3498db;
            color:white;
            padding:8px 12px;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }
        .review-btn:hover {
            background:#2980b9;
        }
        .alert {
            padding:10px;
            border-radius:5px;
            margin-bottom:10px;
        }
        .alert-success {
            background:#d4edda;
            color:#155724;
        }
        .alert-error {
            background:#f8d7da;
            color:#721c24;
        }
    </style>
</head>
<body>
<div class="book-card">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <img src="{{ asset('images/books/' . $book->cover_image) }}" alt="{{ $book->title }} cover">

    <h1>{{ $book->title }}</h1>
    <p><strong>Author:</strong> {{ $book->author }}</p>
    <p><strong>Publishing Year:</strong> {{ $book->year }}</p>
    <p><strong>Genre:</strong> {{ $book->genre }}</p>
    <p><strong>Language:</strong> {{ $book->language }}</p>
    <p><strong>Publisher:</strong> {{ $book->publisher }}</p>
    <p><strong>Price:</strong> ${{ $book->price }}</p>
    <p><strong>Stock:</strong> {{ $book->stock > 0 ? $book->stock : 'Out of stock' }}</p>
    <p><strong>Description:</strong> {{ $book->description }}</p>

    {{-- Buy button --}}
    @if($book->stock > 0)
        <form action="{{ route('books.buy', $book->id) }}" method="POST">
            @csrf
            <button type="submit" class="buy-btn">Buy This Book</button>
        </form>
    @else
        <p style="color:red;"><strong>Currently unavailable.</strong></p>
    @endif

    <div class="clear"></div>

    {{-- Reviews --}}
    <div class="review-section">
        <h2>Reviews</h2>

        @forelse($book->reviews as $review)
            <div class="review-card">
                <p>
                    <strong>{{ $review->user->name ?? 'Anonymous' }}:</strong>
                    {{ $review->comment }}
                </p>
                <p>Rating: {{ $review->rating }}/5</p>
            </div>
        @empty
            <p>No reviews yet.</p>
        @endforelse

        {{-- Add review --}}
        @if(session('user_id'))
            <h3>Add a review</h3>
            <form action="{{ route('reviews.store', $book->id) }}" method="POST">
                @csrf
                <input type="number" name="rating" min="1" max="5" required>
                <textarea name="comment" placeholder="Write your review..." required></textarea>
                <button type="submit" class="review-btn">Submit Review</button>
            </form>
        @else
            <p><a href="/login">Login</a> to add a review.</p>
        @endif
    </div>
</div>
</body>
</html>
