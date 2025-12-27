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
        h1 { color:#2c3e50; }
        p { margin:5px 0; }
        .buy-btn {
            padding:10px 15px;
            background:#27ae60;
            color:white;
            border:none;
            border-radius:6px;
            cursor:pointer;
            margin-top:15px;
        }
        .buy-btn:hover { background:#2ecc71; }
        .clear { clear:both; }

        /* Review & rating styles */
        .review-form, .reviews-list {
            background: #fff;
            padding: 15px;
            border-radius:6px;
            margin-top:20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .review-form textarea {
            width:100%;
            padding:8px;
            margin-top:5px;
            border-radius:4px;
            border:1px solid #ccc;
        }
        .review-form button {
            padding:8px 12px;
            background:#2980b9;
            color:#fff;
            border:none;
            border-radius:4px;
            cursor:pointer;
            margin-top:10px;
        }
        .review-form button:hover { background:#3498db; }

        .single-review {
            border-bottom:1px solid #eee;
            padding:10px 0;
        }
        .single-review:last-child { border-bottom:none; }

        .star-rating { display: inline-block; }
        .star {
            font-size: 25px;
            color: #ccc;
            cursor: pointer;
        }
        .star.filled { color: #f39c12; }
    </style>
</head>
<body>
    <div class="book-card">
        <img src="{{ asset('images/books/' . $book->cover_image) }}" alt="{{ $book->title }} cover">

        <h1>{{ $book->title }}</h1>
        <p><strong>Author:</strong> {{ $book->author }}</p>
        <p><strong>Publishing Year:</strong> {{ $book->year }}</p>
        <p><strong>Genre:</strong> {{ $book->genre }}</p>
        <p><strong>Price:</strong> ${{ $book->price }}</p>
        <p><strong>Description:</strong> {{ $book->description }}</p>

        {{-- Wikipedia Section --}}
        <div style="background:#f9f9f9; padding:10px; border-radius:6px; margin-top:15px;">
            <strong>Know more : </strong>
            <a href="{{ $wikiPageUrl }}" target="_blank" style="color:#2980b9; text-decoration:none;">Wikipedia</a>
        </div>



        <div class="clear"></div>

        <p><strong>Average Rating:</strong> {{ round($book->averageRating(), 1) }} / 5 ({{ $book->reviewsCount() }} reviews)</p>

        @if(session('success'))
            <div style="color: green">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="color: red">{{ session('error') }}</div>
        @endif

        @if(session()->has('user_id'))
            @php
                $userId = session('user_id');
                $userReview = $book->reviews()->where('user_id', $userId)->first();
                $currentRating = $userReview ? $userReview->rating : 0;
                $formTitle = $userReview ? 'Update Your Review' : 'Submit Your Review';
                $buttonText = $userReview ? 'Update Review' : 'Submit Review';
            @endphp

            <div class="review-form">
                <h3>{{ $formTitle }}</h3>
                <form action="{{ route('reviews.store', $book->id) }}" method="POST" id="reviewForm">
                    @csrf
                    <label>Rating:</label>
                    <div class="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $currentRating ? 'filled' : '' }}" data-value="{{ $i }}">&#9733;</span>
                        @endfor
                        <input type="hidden" name="rating" id="rating" value="{{ $currentRating }}">
                    </div>

                    <br><br>
                    <label>Comment:</label>
                    <textarea name="comment" id="comment" rows="4" placeholder="Write your review...">{{ $userReview->comment ?? '' }}</textarea>

                    <br><br>
                    <button type="submit">{{ $buttonText }}</button>
                </form>
            </div>

            <script>
                const stars = document.querySelectorAll('.star-rating .star');
                const ratingInput = document.getElementById('rating');

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');
                        ratingInput.value = value;

                        stars.forEach(s => {
                            if (s.getAttribute('data-value') <= value) {
                                s.classList.add('filled');
                            } else {
                                s.classList.remove('filled');
                            }
                        });
                    });
                });
            </script>
        @else
            <p><a href="{{ route('login') }}">Login</a> to submit a review.</p>
        @endif

        <div class="reviews-list">
            <h3>All Reviews:</h3>
            @forelse($book->reviews as $review)
                <div class="single-review">
                    <strong>{{ $review->user->name }}</strong>
                    <span class="star-rating">
                        @for($i=1; $i<=5; $i++)
                            <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">&#9733;</span>
                        @endfor
                    </span>
                    <p>{{ $review->comment }}</p>
                    <small>Reviewed on: {{ $review->created_at->format('M d, Y') }}</small>
                </div>
            @empty
                <p>No reviews yet for this book.</p>
            @endforelse
        </div>
    </div>
</body>
</html>
