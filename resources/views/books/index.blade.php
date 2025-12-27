<!DOCTYPE html>
<html>
<head>
    <title>Bookstore</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#f4f4f4;
            padding: 20px;
            color: #333;
        }

        /* Top Navigation */
        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            flex-wrap: wrap;
        }

        .nav-links {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .nav-links a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        h1 { color:#2c3e50; margin-bottom: 20px; text-align:center; }

        /* Search & Sort */
        .search-sort {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 25px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .search-sort input[type="text"] {
            padding: 10px 15px;
            width: 350px;
            border-radius: 25px;
            border: 2px solid #e1e8ed;
            font-size: 16px;
        }

        .search-sort select {
            padding: 10px 15px;
            border-radius: 25px;
            border: 1px solid #ccc;
        }

        .search-sort input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
        }

        /* Book Items */
        .book-item {
            background-color: white;
            margin-bottom: 25px;
            padding: 20px;
            list-style: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            display: flex;
            gap: 20px;
            position: relative;
            transition: transform 0.3s ease;
        }

        .book-item:hover { transform: translateY(-5px); }

        .book-item.user-listing { border-left: 4px solid #f59e0b; background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%); }
        .book-item.official-book { border-left: 4px solid #10b981; }

        .book-source-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-official { background: #d1fae5; color: #065f46; }
        .badge-user { background: #fef3c7; color: #92400e; }

        .condition-info { display: inline-block; padding: 3px 8px; border-radius: 10px; font-size: 0.8rem; font-weight: bold; margin-left: 10px; }
        .condition-new { background: #d1fae5; color: #065f46; }
        .condition-like-new { background: #dbeafe; color: #1e40af; }
        .condition-used { background: #fef3c7; color: #92400e; }

        .seller-info { color: #6b7280; font-size: 0.9rem; margin-top: 5px; }

        .book-image img { width:120px; height:160px; object-fit:cover; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15); }

        .book-content { flex:1; }
        .book-title { font-size:1.4rem; font-weight:bold; color:#2c3e50; margin-bottom:5px; }
        .book-author { color:#7f8c8d; margin-bottom:5px; }
        .book-price { font-size:1.3rem; font-weight:bold; color:#27ae60; margin-bottom:10px; }
        .book-description { color:#5a5a5a; line-height:1.5; margin-bottom:10px; }

        .book-actions {
            display:flex;
            flex-direction: column;
            gap:10px;
            align-items: center;
            justify-content: center;
            min-width: 140px;
        }

        .buy-btn, .contact-btn, .view-btn {
            padding:10px 20px;
            border-radius:25px;
            text-align:center;
            text-decoration:none;
            font-weight:bold;
            display:flex;
            align-items:center;
            gap:5px;
            transition: all 0.3s ease;
        }

        .buy-btn { background: linear-gradient(45deg, #667eea, #764ba2); color:white; }
        .buy-btn:hover { transform: translateY(-2px); box-shadow:0 8px 20px rgba(102,126,234,0.4); }
        .buy-btn:disabled { background:#cbd5e0; cursor:not-allowed; transform:none; box-shadow:none; }

        .contact-btn { background: linear-gradient(45deg, #f59e0b, #d97706); color:white; }
        .contact-btn:hover { transform: translateY(-2px); box-shadow:0 8px 20px rgba(245,158,11,0.4); }

        .view-btn { border:2px solid #667eea; color:#667eea; background:transparent; }
        .view-btn:hover { background:#667eea; color:white; }

        .stock-status {
            padding: 5px 12px;
            border-radius: 15px;
            font-size:0.85rem;
            font-weight:bold;
            margin-bottom:10px;
        }

        .in-stock { background:#d4edda; color:#155724; }
        .low-stock { background:#fff3cd; color:#856404; }
        .out-of-stock { background:#f8d7da; color:#721c24; }

        @media (max-width:768px) {
            .book-item { flex-direction: column; text-align:center; }
            .book-actions { flex-direction:row; justify-content:center; min-width:auto; width:100%; }
            .top-nav { flex-direction: column; gap:15px; }
            .search-sort input[type="text"] { width:100%; max-width:300px; }
        }
    </style>
</head>
<body>

<div class="top-nav">
    <div class="nav-links">
        <a href="{{ route('sell.index') }}"><i class="fas fa-tag"></i> Sell</a>
        <a href="{{ route('recommendations') }}"><i class="fas fa-thumbs-up"></i> Recommendations</a>
        @if(session('user_id'))
            <a href="{{ route('profile.show') }}"><i class="fas fa-user"></i> My Profile</a>
            <a href="{{ route('books.purchase-history') }}"><i class="fas fa-history"></i> My Orders</a>
            <a href="{{ route('books.best-sellers') }}"><i class="fas fa-chart-line"></i> Best Sellers</a>
            <a href="/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        @else
            <a href="/login"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="/signup"><i class="fas fa-user-plus"></i> Sign Up</a>
        @endif
    </div>
</div>

<h1>Books Collection</h1>

<form method="GET" action="{{ route('books.index') }}" class="search-sort">
    <input type="text" name="search" placeholder="Search by title or author" value="{{ $search ?? '' }}">
    <select name="sort" onchange="this.form.submit()">
        <option value="title" {{ ($sort ?? '')=='title' ? 'selected' : '' }}>Sort by Title</option>
        <option value="author" {{ ($sort ?? '')=='author' ? 'selected' : '' }}>Sort by Author</option>
        <option value="price" {{ ($sort ?? '')=='price' ? 'selected' : '' }}>Sort by Price</option>
    </select>
</form>

<ul>
@foreach ($allBooks as $book)
<li class="book-item {{ $book->is_user_listing ? 'user-listing' : 'official-book' }}">
    <div class="book-source-badge {{ $book->is_user_listing ? 'badge-user' : 'badge-official' }}">
        {{ $book->is_user_listing ? 'User Sale' : 'Official' }}
    </div>

    <div class="book-image">
        <img src="{{ asset($book->is_user_listing ? 'images/listings/'.$book->cover_image : 'images/books/'.$book->cover_image) }}">
    </div>

    <div class="book-content">
        <div class="book-title">{{ $book->title }}</div>
        <div class="book-author">
            by {{ $book->author }}
            @if($book->is_user_listing)
                <span class="condition-info condition-{{ $book->condition }}">
                    {{ ucwords(str_replace('-', ' ', $book->condition)) }}
                </span>
            @endif
        </div>
        <div class="book-price">${{ number_format($book->price,2) }}</div>
        @if($book->is_user_listing)
            <div class="seller-info">Sold by {{ $book->seller_name }}</div>
        @endif
        <div class="book-description">{{ Str::limit($book->description,150) }}</div>
    </div>

    <div class="book-actions">
        @if($book->stock > 0)
            <span class="stock-status {{ $book->stock <=5 ? 'low-stock' : 'in-stock' }}">
                {{ $book->stock <=5 ? 'Only '.$book->stock.' left' : 'In Stock ('.$book->stock.')' }}
            </span>

            <a href="{{ $book->is_user_listing ? route('sell.show',$book->listing_id) : route('books.buy',$book->id) }}" class="{{ $book->is_user_listing ? 'contact-btn' : 'buy-btn' }}">
                <i class="{{ $book->is_user_listing ? 'fas fa-comments' : 'fas fa-shopping-cart' }}"></i>
                {{ $book->is_user_listing ? 'Contact Seller' : 'Buy Now' }}
            </a>
        @else
            <span class="stock-status out-of-stock">Out of Stock</span>
            <button class="buy-btn" disabled><i class="fas fa-ban"></i> Unavailable</button>
        @endif

        <a href="{{ $book->is_user_listing ? route('sell.show',$book->listing_id) : route('books.show',$book->id) }}" class="view-btn">
            <i class="fas fa-eye"></i> View Details
        </a>
    </div>
</li>
@endforeach
</ul>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
