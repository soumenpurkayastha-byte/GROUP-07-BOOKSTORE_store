<!DOCTYPE html>
<html>
<head>
    <title>Marketplace - Buy from Other Users</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .nav-links {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .nav-links a {
            background: white;
            color: #667eea;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .filters {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .filter-row {
            display: flex;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-group label {
            font-weight: bold;
            color: #374151;
        }

        .filter-group input, .filter-group select {
            padding: 10px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 16px;
        }

        .filter-group input:focus, .filter-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .filter-btn {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 20px;
        }

        .listings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .listing-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .listing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .listing-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(45deg, #f093fb 0%, #f5576c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            position: relative;
        }

        .listing-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .condition-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .condition-new {
            background: #10b981;
            color: white;
        }

        .condition-like-new {
            background: #3b82f6;
            color: white;
        }

        .condition-used {
            background: #f59e0b;
            color: white;
        }

        .listing-content {
            padding: 20px;
        }

        .listing-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .listing-author {
            color: #6b7280;
            margin-bottom: 10px;
        }

        .listing-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #059669;
            margin-bottom: 12px;
        }

        .listing-description {
            color: #4b5563;
            font-size: 0.9rem;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .listing-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .view-btn {
            width: 100%;
            background: #667eea;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }

        .view-btn:hover {
            background: #5a67d8;
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
        }

        .empty-icon {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .nav-links {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-store"></i> Book Marketplace</h1>
            <p>Buy books from other users in the community</p>
            
            <div class="nav-links">
                <a href="{{ route('books.index') }}"><i class="fas fa-book"></i> Official Store</a>
                <a href="{{ route('sell.create') }}"><i class="fas fa-plus"></i> Sell a Book</a>
                <a href="{{ route('sell.my-listings') }}"><i class="fas fa-list"></i> My Listings</a>
                @if(!session('user_id'))
                    <a href="/login"><i class="fas fa-sign-in-alt"></i> Login</a>
                @else
                    <a href="{{ route('profile.show') }}"><i class="fas fa-user"></i> Profile</a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-weight: bold;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-weight: bold;">
                {{ session('error') }}
            </div>
        @endif

        <div class="filters">
            <form method="GET" action="{{ route('sell.index') }}">
                <div class="filter-row">
                    <div class="filter-group">
                        <label>Search Books</label>
                        <input type="text" name="search" placeholder="Title, author, or description..." value="{{ $search }}" style="width: 300px;">
                    </div>
                    
                    <div class="filter-group">
                        <label>Condition</label>
                        <select name="condition">
                            <option value="all" {{ $condition == 'all' ? 'selected' : '' }}>All Conditions</option>
                            <option value="new" {{ $condition == 'new' ? 'selected' : '' }}>New</option>
                            <option value="like-new" {{ $condition == 'like-new' ? 'selected' : '' }}>Like New</option>
                            <option value="used" {{ $condition == 'used' ? 'selected' : '' }}>Used</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label>Sort By</label>
                        <select name="sort">
                            <option value="created_at" {{ $sort == 'created_at' ? 'selected' : '' }}>Newest First</option>
                            <option value="price" {{ $sort == 'price' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="title" {{ $sort == 'title' ? 'selected' : '' }}>Title A-Z</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="filter-btn">
                    <i class="fas fa-search"></i> Apply Filters
                </button>
            </form>
        </div>

        @if($listings->count() > 0)
            <div class="listings-grid">
                @foreach($listings as $listing)
                    <div class="listing-card">
                        <div class="listing-image">
                            @if($listing->photo)
                                <img src="{{ asset('images/listings/' . $listing->photo) }}" alt="{{ $listing->title }}">
                            @else
                                <i class="fas fa-book"></i>
                            @endif
                            <span class="condition-badge condition-{{ $listing->condition }}">
                                {{ ucwords(str_replace('-', ' ', $listing->condition)) }}
                            </span>
                        </div>
                        
                        <div class="listing-content">
                            <div class="listing-title">{{ $listing->title }}</div>
                            <div class="listing-author">by {{ $listing->author }}</div>
                            <div class="listing-price">${{ number_format($listing->price, 2) }}</div>
                            <div class="listing-description">
                                {{ Str::limit($listing->description, 100) }}
                            </div>
                            
                            <div class="listing-meta">
                                <span><i class="fas fa-user"></i> {{ $listing->user->name }}</span>
                                <span><i class="fas fa-clock"></i> {{ $listing->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <a href="{{ route('sell.show', $listing->id) }}" class="view-btn">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{ $listings->links() }}
        @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-search"></i></div>
                <h2>No listings found</h2>
                <p>Try adjusting your search filters or be the first to sell a book!</p>
                <a href="{{ route('sell.create') }}" class="view-btn" style="max-width: 200px; margin: 20px auto; display: block;">
                    <i class="fas fa-plus"></i> Create First Listing
                </a>
            </div>
        @endif
    </div>
</body>
</html>