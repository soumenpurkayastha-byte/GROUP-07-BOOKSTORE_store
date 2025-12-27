<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Sellers</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Navbar */
        .navbar {
            background-color: #2c3e50;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
        }

        .navbar a {
            color: #ecf0f1;
            margin-left: 1rem;
            font-weight: bold;
        }

        .navbar a:hover {
            color: #f39c12;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        h1 {
            text-align: center;
            margin-bottom: 2rem;
            color: #2c3e50;
        }

        /* Grid */
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
        }

        .col {
            flex: 1 1 calc(33% - 1.5rem);
            max-width: calc(33% - 1.5rem);
            box-sizing: border-box;
        }

        @media (max-width: 900px) {
            .col {
                flex: 1 1 calc(50% - 1.5rem);
                max-width: calc(50% - 1.5rem);
            }
        }

        @media (max-width: 600px) {
            .col {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }

        /* Card */
        .card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .card-body {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #34495e;
        }

        .card-text {
            margin: 0.3rem 0;
            font-size: 0.95rem;
        }

        /* Button */
        .btn {
            margin-top: auto;
            padding: 0.6rem 1rem;
            text-align: center;
            background-color: #f39c12;
            color: #fff;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.2s;
        }

        .btn:hover {
            background-color: #e67e22;
        }

        /* No best sellers message */
        p {
            text-align: center;
            font-size: 1rem;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="brand"><a href="{{ url('/books') }}">📚 Bookstore</a></div>
        <div class="nav-links">
            @if(session('user_id'))
                <a href="{{ route('profile.show') }}">Profile</a>
                <a href="{{ route('logout') }}">Logout</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('signup') }}">Signup</a>
            @endif
        </div>
    </div>

    <!-- Content -->
    <div class="container">
        <h1>📈 Best Sellers</h1>

        @if($books->isEmpty())
            <p>No best sellers found yet.</p>
        @else
            <div class="row">
                @foreach($books as $book)
                <div class="col">
                    <div class="card">
                        <img src="{{ $book->is_user_listing ? asset('images/listings/' . $book->cover_image) : asset('images/books/' . $book->cover_image) }}"
                                alt="{{ $book->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text"><strong>Author:</strong> {{ $book->author }}</p>
                            <p class="card-text"><strong>Price:</strong> ${{ number_format($book->price, 2) }}</p>
                            <p class="card-text"><strong>Total Sold:</strong> {{ $book->total_sold ?? 0 }}</p>
                            <p class="card-text"><strong>Rank:</strong> {{ $book->rank ?? '-' }}</p>

                            @if(!$book->is_user_listing)
                                <p class="card-text"><strong>Rating:</strong> {{ number_format($book->averageRating(), 1) ?? 'N/A' }}</p>
                            @endif

                            @if(isset($book->seller_name))
                                <p class="card-text"><strong>Seller:</strong> {{ $book->seller_name }}</p>
                            @endif

                            <a href="{{ $book->is_user_listing ? route('sell.show', $book->listing_id) : route('books.show', $book->id) }}"
                                class="btn">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
