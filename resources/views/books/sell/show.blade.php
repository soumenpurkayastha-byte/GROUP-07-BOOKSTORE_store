<!DOCTYPE html>
<html>
<head>
    <title>{{ $listing->title }} - User Marketplace</title>
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
            max-width: 1000px;
            margin: 0 auto;
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

        .listing-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            min-height: 600px;
        }

        .image-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }

        .book-image {
            max-width: 100%;
            max-height: 400px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }

        .no-image {
            color: white;
            font-size: 6rem;
            opacity: 0.7;
        }

        .condition-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            color: white;
        }

        .condition-new { background: #10b981; }
        .condition-like-new { background: #3b82f6; }
        .condition-used { background: #f59e0b; }

        .details-section {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .book-header {
            margin-bottom: 30px;
        }

        .book-title {
            font-size: 2.2rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .book-author {
            font-size: 1.3rem;
            color: #6b7280;
            margin-bottom: 20px;
        }

        .book-price {
            font-size: 2.5rem;
            font-weight: bold;
            color: #059669;
            margin-bottom: 20px;
        }

        .book-info {
            margin-bottom: 30px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-label {
            font-weight: bold;
            color: #374151;
        }

        .info-value {
            color: #6b7280;
        }

        .description {
            background: #f9fafb;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }

        .description h4 {
            margin-bottom: 10px;
            color: #374151;
        }

        .description p {
            line-height: 1.6;
            color: #4b5563;
            margin: 0;
        }

        .seller-info {
            background: #f0f9ff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            border: 1px solid #e0f2fe;
        }

        .seller-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .seller-avatar {
            width: 40px;
            height: 40px;
            background: #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .contact-actions {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .contact-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .contact-btn.secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .contact-btn.secondary:hover {
            background: #667eea;
            color: white;
        }

        .warning-note {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .warning-note p {
            margin: 0;
            color: #92400e;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .listing-container {
                grid-template-columns: 1fr;
            }
            
            .image-section {
                min-height: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="back-btn">
            <a href="{{ route('sell.index') }}">
                <i class="fas fa-arrow-left"></i> Back to Marketplace
            </a>
        </div>

        <div class="listing-container">
            <div class="image-section">
                @if($listing->photo)
                    <img src="{{ asset('images/listings/' . $listing->photo) }}" alt="{{ $listing->title }}" class="book-image">
                @else
                    <div class="no-image">
                        <i class="fas fa-book"></i>
                    </div>
                @endif
                
                <div class="condition-badge condition-{{ $listing->condition }}">
                    {{ ucwords(str_replace('-', ' ', $listing->condition)) }}
                </div>
            </div>

            <div class="details-section">
                <div>
                    <div class="book-header">
                        <h1 class="book-title">{{ $listing->title }}</h1>
                        <div class="book-author">by {{ $listing->author }}</div>
                        <div class="book-price">${{ number_format($listing->price, 2) }}</div>
                    </div>

                    <div class="book-info">
                        <div class="info-row">
                            <span class="info-label">Condition</span>
                            <span class="info-value">{{ ucwords(str_replace('-', ' ', $listing->condition)) }}</span>
                        </div>
                        @if($listing->genre)
                            <div class="info-row">
                                <span class="info-label">Genre</span>
                                <span class="info-value">{{ $listing->genre }}</span>
                            </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label">Quantity Available</span>
                            <span class="info-value">{{ $listing->quantity }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Listed</span>
                            <span class="info-value">{{ $listing->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <div class="description">
                        <h4><i class="fas fa-info-circle"></i> Description</h4>
                        <p>{{ $listing->description }}</p>
                    </div>

                    <div class="seller-info">
                        <div class="seller-header">
                            <div class="seller-avatar">
                                {{ strtoupper(substr($listing->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: bold; color: #1f2937;">{{ $listing->user->name }}</div>
                                <div style="color: #6b7280; font-size: 0.9rem;">Seller</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-actions">
                    @if(session('user_id'))
                        @if(session('user_id') != $listing->user_id)
                            <button class="contact-btn" onclick="contactSeller()">
                                <i class="fas fa-comments"></i> Contact Seller
                            </button>
                            
                            <button class="contact-btn secondary" onclick="reportListing()">
                                <i class="fas fa-flag"></i> Report Listing
                            </button>
                        @else
                            <div style="text-align: center; padding: 20px; background: #f3f4f6; border-radius: 10px; color: #6b7280;">
                                <i class="fas fa-user-check"></i> This is your listing
                            </div>
                            <a href="{{ route('sell.my-listings') }}" class="contact-btn">
                                <i class="fas fa-edit"></i> Manage My Listings
                            </a>
                        @endif
                    @else
                        <a href="/login" class="contact-btn">
                            <i class="fas fa-sign-in-alt"></i> Login to Contact Seller
                        </a>
                    @endif

                    <div class="warning-note">
                        <p><i class="fas fa-shield-alt"></i> <strong>Safety Tip:</strong> Meet in a public place for exchanges and inspect the book before payment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function contactSeller() {
            alert('Contact feature coming soon! For now, you can meet the seller through our messaging system or arrange a meeting in a public place.');
        }
        
        function reportListing() {
            if(confirm('Report this listing as inappropriate or spam?')) {
                alert('Thank you for your report. We will review this listing shortly.');
            }
        }
    </script>
</body>
</html>