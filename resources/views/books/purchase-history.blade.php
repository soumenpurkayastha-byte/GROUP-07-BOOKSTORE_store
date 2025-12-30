<!DOCTYPE html>
<html>
<head>
    <title>My Purchase History - Bookstore</title>
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

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
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

        .stat-label {
            color: #6b7280;
            font-size: 1rem;
        }

        .orders-section {
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

        .order-card {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .order-card:hover {
            border-color: #667eea;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
        }

        .order-header {
            background: #f8fafc;
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-id {
            font-weight: bold;
            color: #667eea;
            font-size: 1.1rem;
        }

        .order-date {
            color: #6b7280;
        }

        .order-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            background: #10b981;
            color: white;
        }

        .order-body {
            padding: 20px;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .book-cover {
            width: 80px;
            height: 100px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }

        .book-info {
            flex: 1;
        }

        .book-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .book-author {
            color: #6b7280;
            margin-bottom: 10px;
        }

        .order-details {
            display: flex;
            gap: 30px;
            font-size: 0.95rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .detail-label {
            color: #6b7280;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            color: #1f2937;
            font-weight: bold;
        }

        .order-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: flex-end;
        }

        .total-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
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
        }

        .btn-review {
            background: #10b981;
            color: white;
        }

        .btn-review:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .btn-reorder {
            background: #667eea;
            color: white;
        }

        .btn-reorder:hover {
            background: #5a67d8;
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

        .empty-title {
            font-size: 1.5rem;
            color: #6b7280;
            margin-bottom: 15px;
        }

        .empty-text {
            color: #9ca3af;
            margin-bottom: 30px;
        }

        .shop-now-btn {
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

        .shop-now-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .back-btn {
            margin-bottom: 20px;
        }

        .back-btn a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s ease;
        }

        .back-btn a:hover {
            color: #5a67d8;
        }

        @media (max-width: 768px) {
            .order-body {
                flex-direction: column;
                text-align: center;
            }
            
            .order-details {
                justify-content: center;
                flex-wrap: wrap;
                gap: 20px;
            }
            
            .order-actions {
                align-items: center;
                flex-direction: row;
                justify-content: center;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="back-btn">
            <a href="{{ route('books.index') }}">
                <i class="fas fa-arrow-left"></i> Back to Books
            </a>
        </div>

        <div class="header">
            <h1><i class="fas fa-history"></i> My Purchase History</h1>
            <p>Track all your book orders and purchases</p>
        </div>

        @if($orders->count() > 0)
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
                    <div class="stat-number">{{ $orders->total() }}</div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-book"></i></div>
                    <div class="stat-number">{{ $orders->sum('quantity') }}</div>
                    <div class="stat-label">Books Purchased</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                    <div class="stat-number">${{ number_format($orders->sum('total_price'), 2) }}</div>
                    <div class="stat-label">Total Spent</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-calendar"></i></div>
                    <div class="stat-number">{{ $orders->first()->created_at->format('M Y') }}</div>
                    <div class="stat-label">Customer Since</div>
                </div>
            </div>

            <div class="orders-section">
                <h2 class="section-title">
                    <i class="fas fa-list"></i> Recent Orders
                </h2>

                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <span class="order-id">Order #{{ $order->id }}</span>
                                <span class="order-date"> • {{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <span class="order-status">Completed</span>
                        </div>
                        
                        <div class="order-body">
                            <img src="{{ asset('images/books/' . $order->book->cover_image) }}" 
                                 alt="{{ $order->book->title }}" class="book-cover">
                            
                            <div class="book-info">
                                <div class="book-title">{{ $order->book->title }}</div>
                                <div class="book-author">by {{ $order->book->author }}</div>
                                
                                <div class="order-details">
                                    <div class="detail-item">
                                        <span class="detail-label">Quantity</span>
                                        <span class="detail-value">{{ $order->quantity }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Unit Price</span>
                                        <span class="detail-value">${{ number_format($order->book->price, 2) }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Order Time</span>
                                        <span class="detail-value">{{ $order->created_at->format('h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="order-actions">
                                <div class="total-price">${{ number_format($order->total_price, 2) }}</div>
                                <a href="{{ route('books.show', $order->book->id) }}" class="action-btn btn-review">
                                    <i class="fas fa-star"></i> Review
                                </a>
                                <a href="{{ route('books.buy', $order->book->id) }}" class="action-btn btn-reorder">
                                    <i class="fas fa-redo"></i> Buy Again
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{ $orders->links() }}
            </div>
        @else
            <div class="orders-section">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h2 class="empty-title">No Orders Yet</h2>
                    <p class="empty-text">You haven't made any purchases yet. Start exploring our amazing collection of books!</p>
                    <a href="{{ route('books.index') }}" class="shop-now-btn">
                        <i class="fas fa-book"></i> Start Shopping
                    </a>
                </div>
            </div>
        @endif
    </div>
</body>
</html>