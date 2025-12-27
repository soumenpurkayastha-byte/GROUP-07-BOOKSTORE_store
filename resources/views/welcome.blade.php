<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookstore Recommendations</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f5f6f8;
            padding: 30px;
            color: #2c3e50;
        }

        h1 {
            margin-bottom: 25px;
        }

        h2 {
            margin-bottom: 12px;
            font-size: 20px;
        }

        .section {
            margin-bottom: 35px;
        }

        .card {
            background: #ffffff;
            padding: 14px 16px;
            border-radius: 6px;
            margin-bottom: 10px;
            border: 1px solid #e0e0e0;
        }

        .card strong {
            display: block;
            margin-bottom: 4px;
        }

        .empty {
            color: #777;
            font-size: 14px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #ffffff;
            background-color: #2c3e50;
            padding: 8px 14px;
            border-radius: 4px;
            font-size: 14px;
        }

        .back-link:hover {
            background-color: #1f2d3a;
        }
    </style>
</head>
<body>

<h1>Bookstore Recommendations</h1>

<div class="section">
    <h2>Most Commented Books___</h2>

    @forelse($mostCommented as $book)
        <div class="card">
            <strong>{{ $book->title }}</strong>
            Reviews: {{ $book->reviews_count }}
        </div>
    @empty
        <p class="empty">No data available</p>
    @endforelse
</div>

<div class="section">
    <h2>Highest Rated Books</h2>

    @forelse($highestRated as $book)
        <div class="card">
            <strong>{{ $book->title }}</strong>
            Rating: {{ $book->rating }}
        </div>
    @empty
        <p class="empty">No data available</p>
    @endforelse
</div>

<div class="section">
    <h2>Top Buyers</h2>

    @forelse($topBuyers as $buyer)
        <div class="card">
            {{ $buyer->name }} — {{ $buyer->total_books }} books bought
        </div>
    @empty
        <p class="empty">No data available</p>
    @endforelse
</div>

<div class="section">
    <h2>Top Sellers</h2>

    @forelse($topSellers as $seller)
        <div class="card">
            {{ $seller->name }} — {{ $seller->total_listed }} books listed
        </div>
    @empty
        <p class="empty">No data available</p>
    @endforelse
</div>

<a href="/books" class="back-link">Browse All Books</a>

</body>
</html>
