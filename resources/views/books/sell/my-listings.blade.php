<!DOCTYPE html>
<html>
<head>
    <title>My Listings - Bookstore</title>
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            border-top: 4px solid #667eea;
        }

        .stat-icon {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .listings-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 1.8rem;
            color: #1f2937;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .listings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .listing-card {
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .listing-card:hover {
            border-color: #667eea;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
        }

        .listing-image {
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

        .status-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
            color: white;
        }

        .status-active { background: #10b981; }
        .status-pending { background: #f59e0b; }
        .status-sold { background: #ef4444; }

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
            font-size: 1.4rem;
            font-weight: bold;
            color: #059669;
            margin-bottom: 15px;
        }

        .listing-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .listing-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            flex: 1;
            text-align: center;
            min-width: 100px;
        }

        .btn-view {
            background: #667eea;
            color: white;
        }

        .btn-view:hover {
            background: #5a67d8;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .create-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .create-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        @media (max-width: 768px) {
            .listings-grid {
                grid-template-columns: 1fr;
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
            <h1><i class="fas fa-list-alt"></i> My Book Listings</h1>
            <p>Manage your book sales and track your listings</p>
            
            <div class="nav-links">
                <a href="{{ route('sell.index') }}"><i class="fas fa-store"></i> Marketplace</a>
                <a href="{{ route('sell.create') }}"><i class="fas fa-plus"></i> Add New Listing</a>
                <a href="{{ route('books.index') }}"><i class="fas fa-book"></i> Official Store</a>
            </div>
        </div>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-weight: bold;">
                {{ session('success') }}
            </div>
        @endif

        @if($listings->count() > 0)
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-list"></i></div>
                    <div class="stat-number">{{ $listings->total() }}</div>
                    <div>Total Listings</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-number">{{ $listings->where('status', 'active')->count() }}</div>
                    <div>Active</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                    <div class="stat-number">${{ number_format($listings->sum('price'), 2) }}</div>
                    <div>Total Value</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                    <div class="stat-number">{{ $listings->where('status', 'pending')->count() }}</div>
                    <div>Pending</div>
                </div>
            </div>

            <div class="listings-section">
                <h2 class="section-title">
                    <i class="fas fa-books"></i> Your Listings
                </h2>

                <div class="listings-grid">
                    @foreach($listings as $listing)
                        <div class="listing-card">
                            <div class="listing-image">
                                @if($listing->photo)
                                    <img src="{{ asset('images/listings/' . $listing->photo) }}" alt="{{ $listing->title }}">
                                @else
                                    <i class="fas fa-book"></i>
                                @endif
                                <span class="status-badge status-{{ $listing->status }}">
                                    {{ ucfirst($listing->status) }}
                                </span>
                            </div>
                            
                            <div class="listing-content">
                                <div class="listing-title">{{ $listing->title }}</div>
                                <div class="listing-author">by {{ $listing->author }}</div>
                                <div class="listing-price">${{ number_format($listing->price, 2) }}</div>
                                
                                <div class="listing-meta">
                                    <span><i class="fas fa-tag"></i> {{ ucwords(str_replace('-', ' ', $listing->condition)) }}</span>
                                    <span><i class="fas fa-calendar"></i> {{ $listing->created_at->format('M d') }}</span>
                                </div>
                                
                                <div class="listing-actions">
                                    <a href="{{ route('sell.show', $listing->id) }}" class="action-btn btn-view">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    
                                    <form method="POST" action="{{ route('sell.destroy', $listing->id) }}" style="flex: 1;" onsubmit="return confirm('Are you sure you want to delete this listing?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete" style="width: 100%;">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{ $listings->links() }}
            </div>
        @else
            <div class="listings-section">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h2>No listings yet</h2>
                    <p>Start selling your books to other users in the community!</p>
                    <a href="{{ route('sell.create') }}" class="create-btn">
                        <i class="fas fa-plus"></i> Create Your First Listing
                    </a>
                </div>
            </div>
        @endif
    </div>
</body>
</html>