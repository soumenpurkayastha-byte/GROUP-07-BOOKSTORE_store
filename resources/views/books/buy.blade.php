<!DOCTYPE html>
<html>
<head>
    <title>Buy {{ $book->title }} - Bookstore</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px 40px;
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar .brand a {
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .navbar .brand a:hover {
            color: #f7ff00;
        }

        .navbar .nav-buttons a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .navbar .nav-buttons a:hover {
            color: #f7ff00;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 10px;
                padding: 10px 20px;
            }

            .navbar .nav-buttons a {
                margin-left: 0;
            }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        /* Buy container and book preview */
        .buy-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            min-height: 600px;
        }

        .book-preview {
            background: linear-gradient(45deg, #f093fb 0%, #f5576c 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .book-cover {
            width: 250px;
            height: 350px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .book-cover:hover {
            transform: scale(1.05) rotate(2deg);
        }

        .book-info {
            text-align: center;
            color: white;
        }

        .book-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .book-author {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .book-price {
            font-size: 2rem;
            font-weight: bold;
            color: #fff700;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        /* Purchase panel */
        .purchase-panel {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .purchase-title {
            font-size: 2rem;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }

        .quantity-section {
            margin-bottom: 30px;
        }

        .quantity-label {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
            display: block;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .quantity-btn {
            background: #667eea;
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn:hover {
            background: #5a67d8;
            transform: scale(1.1);
        }

        .quantity-btn:disabled {
            background: #cbd5e0;
            cursor: not-allowed;
            transform: none;
        }

        .quantity-display {
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            width: 80px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .total-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            border-left: 5px solid #667eea;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .total-row.final {
            border-top: 2px solid #667eea;
            padding-top: 15px;
            font-size: 1.3rem;
            font-weight: bold;
            color: #667eea;
        }

        .purchase-btn {
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 18px 40px;
            border-radius: 50px;
            font-size: 1.3rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .purchase-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .purchase-btn:disabled {
            background: #cbd5e0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .stock-info {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #e6fffa;
            border-radius: 10px;
            border: 1px solid #38b2ac;
        }

        .stock-info.low-stock {
            background: #fed7d7;
            border-color: #e53e3e;
        }

        .stock-info.out-of-stock {
            background: #fed7d7;
            border-color: #e53e3e;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .feature-item {
            background: #f7fafc;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .feature-icon {
            font-size: 2rem;
            color: #667eea;
            margin-bottom: 10px;
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .buy-container {
                grid-template-columns: 1fr;
            }

            .book-preview {
                padding: 30px 20px;
            }

            .purchase-panel {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="brand">
            <a href="{{ url('/books') }}">📚 Bookstore</a>
        </div>
        <div class="nav-buttons">
            @if(Route::has('dashboard'))
                <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            @endif

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h1><i class="fas fa-shopping-cart"></i> Complete Your Purchase</h1>
            <p>Secure and Fast Book Ordering</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="buy-container">
            <div class="book-preview">
                <img src="{{ asset('images/books/' . $book->cover_image) }}" alt="{{ $book->title }}" class="book-cover">
                <div class="book-info">
                    <div class="book-title">{{ $book->title }}</div>
                    <div class="book-author">by {{ $book->author }}</div>
                    <div class="book-price">${{ number_format($book->price, 2) }}</div>
                </div>
            </div>

            <div class="purchase-panel">
                <h2 class="purchase-title">Order Details</h2>

                <form method="POST" action="{{ route('books.purchase', $book->id) }}" id="purchaseForm">
                    @csrf

                    @if($book->stock > 0)
                        <div class="stock-info {{ $book->stock <= 5 ? 'low-stock' : '' }}">
                            @if($book->stock <= 5)
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Only {{ $book->stock }} left in stock!</strong>
                            @else
                                <i class="fas fa-check-circle"></i>
                                <strong>{{ $book->stock }} books available</strong>
                            @endif
                        </div>

                        <div class="quantity-section">
                            <label class="quantity-label">
                                <i class="fas fa-shopping-basket"></i> Quantity:
                            </label>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn" id="decreaseBtn" onclick="changeQuantity(-1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <div class="quantity-display" id="quantityDisplay">1</div>
                                <button type="button" class="quantity-btn" id="increaseBtn" onclick="changeQuantity(1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <input type="hidden" name="quantity" id="quantityInput" value="1">
                        </div>

                        <div class="features-grid">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-shipping-fast"></i></div>
                                <div>Fast Delivery</div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-undo"></i></div>
                                <div>Easy Returns</div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                                <div>Secure Payment</div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-medal"></i></div>
                                <div>Quality Assured</div>
                            </div>
                        </div>

                        <div class="total-section">
                            <div class="total-row">
                                <span>Unit Price:</span>
                                <span id="unitPrice">${{ number_format($book->price, 2) }}</span>
                            </div>
                            <div class="total-row">
                                <span>Quantity:</span>
                                <span id="totalQuantity">1</span>
                            </div>
                            <div class="total-row">
                                <span>Subtotal:</span>
                                <span id="subtotal">${{ number_format($book->price, 2) }}</span>
                            </div>
                            <div class="total-row">
                                <span>Shipping:</span>
                                <span id="shipping">Free</span>
                            </div>
                            <div class="total-row final">
                                <span>Total Amount:</span>
                                <span id="totalAmount">${{ number_format($book->price, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="purchase-btn" id="purchaseButton">
                            <i class="fas fa-credit-card"></i> Purchase Now
                        </button>
                    @else
                        <div class="stock-info out-of-stock">
                            <i class="fas fa-times-circle"></i>
                            <strong>Sorry, this book is currently out of stock</strong>
                        </div>
                        <button type="button" class="purchase-btn" disabled>
                            <i class="fas fa-ban"></i> Out of Stock
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <script>
        const bookPrice = {{ $book->price }};
        const maxStock = {{ $book->stock }};
        let currentQuantity = 1;

        function changeQuantity(change) {
            const newQuantity = currentQuantity + change;

            if (newQuantity >= 1 && newQuantity <= maxStock) {
                currentQuantity = newQuantity;
                updateDisplay();
            }
        }

        function updateDisplay() {
            // Update quantity display
            document.getElementById('quantityDisplay').textContent = currentQuantity;
            document.getElementById('quantityInput').value = currentQuantity;
            document.getElementById('totalQuantity').textContent = currentQuantity;

            // Update pricing
            const subtotal = bookPrice * currentQuantity;
            document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('totalAmount').textContent = '$' + subtotal.toFixed(2);

            // Update button states
            document.getElementById('decreaseBtn').disabled = currentQuantity <= 1;
            document.getElementById('increaseBtn').disabled = currentQuantity >= maxStock;
        }

        // Initialize display
        updateDisplay();

        // Add purchase confirmation
        document.getElementById('purchaseForm').addEventListener('submit', function(e) {
            const confirmPurchase = confirm(`Are you sure you want to purchase ${currentQuantity} copy(ies) of "{{ $book->title }}" for $${(bookPrice * currentQuantity).toFixed(2)}?`);

            if (!confirmPurchase) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
