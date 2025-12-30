<!DOCTYPE html>
<html>
<head>
    <title>Sell Your Book - Bookstore</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .back-btn {
            margin-bottom: 20px;
        }

        .back-btn a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .back-btn a:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .form-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h1 {
            font-size: 2.5rem;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            color: #374151;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .required {
            color: #ef4444;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 100%;
        }

        .file-input {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            background: #f9fafb;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 120px;
            flex-direction: column;
            gap: 10px;
        }

        .file-input-label:hover {
            border-color: #667eea;
            background: #f0f4ff;
            color: #667eea;
        }

        .file-input-label i {
            font-size: 2rem;
        }

        .preview-container {
            margin-top: 15px;
            text-align: center;
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .condition-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 10px;
        }

        .condition-option {
            position: relative;
        }

        .condition-option input[type="radio"] {
            position: absolute;
            left: -9999px;
        }

        .condition-label {
            display: block;
            padding: 15px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .condition-option input[type="radio"]:checked + .condition-label {
            border-color: #667eea;
            background: #f0f4ff;
            color: #667eea;
        }

        .submit-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 18px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        .help-text {
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .condition-options {
                grid-template-columns: 1fr;
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

        <div class="form-container">
            <div class="form-header">
                <h1><i class="fas fa-plus-circle"></i> Sell Your Book</h1>
                <p>Create a listing to sell your book to other users</p>
            </div>

            @if($errors->any())
                <div style="background: #fee2e2; border: 1px solid #fecaca; padding: 15px; border-radius: 10px; margin-bottom: 25px;">
                    <ul style="margin: 0; padding-left: 20px; color: #b91c1c;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('sell.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="title">Book Title <span class="required">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                        <div class="help-text">Enter the full title of the book</div>
                    </div>

                    <div class="form-group">
                        <label for="author">Author <span class="required">*</span></label>
                        <input type="text" id="author" name="author" value="{{ old('author') }}" required>
                        <div class="help-text">Author's full name</div>
                    </div>

                    <div class="form-group">
                        <label for="price">Price ($) <span class="required">*</span></label>
                        <input type="number" id="price" name="price" min="0.01" max="9999.99" step="0.01" value="{{ old('price') }}" required>
                        <div class="help-text">Set your selling price</div>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity <span class="required">*</span></label>
                        <input type="number" id="quantity" name="quantity" min="1" max="100" value="{{ old('quantity', 1) }}" required>
                        <div class="help-text">How many copies do you have?</div>
                    </div>

                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <input type="text" id="genre" name="genre" value="{{ old('genre') }}" placeholder="e.g., Fiction, Science, Biography">
                        <div class="help-text">Optional: Book category or genre</div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Book Condition <span class="required">*</span></label>
                    <div class="condition-options">
                        <div class="condition-option">
                            <input type="radio" id="new" name="condition" value="new" {{ old('condition') == 'new' ? 'checked' : '' }} required>
                            <label for="new" class="condition-label">
                                <i class="fas fa-star" style="color: #10b981; margin-bottom: 8px; font-size: 1.5rem;"></i>
                                <div><strong>New</strong></div>
                                <small>Never read, perfect condition</small>
                            </label>
                        </div>
                        <div class="condition-option">
                            <input type="radio" id="like-new" name="condition" value="like-new" {{ old('condition') == 'like-new' ? 'checked' : '' }} required>
                            <label for="like-new" class="condition-label">
                                <i class="fas fa-gem" style="color: #3b82f6; margin-bottom: 8px; font-size: 1.5rem;"></i>
                                <div><strong>Like New</strong></div>
                                <small>Minimal wear, excellent condition</small>
                            </label>
                        </div>
                        <div class="condition-option">
                            <input type="radio" id="used" name="condition" value="used" {{ old('condition') == 'used' ? 'checked' : '' }} required>
                            <label for="used" class="condition-label">
                                <i class="fas fa-book-open" style="color: #f59e0b; margin-bottom: 8px; font-size: 1.5rem;"></i>
                                <div><strong>Used</strong></div>
                                <small>Shows normal wear, readable</small>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description <span class="required">*</span></label>
                    <textarea id="description" name="description" required placeholder="Describe the book's condition, any highlights/markings, why you're selling it, etc.">{{ old('description') }}</textarea>
                    <div class="help-text">Provide details about the book's condition and any other relevant information</div>
                </div>

                <div class="form-group">
                    <label>Book Photo</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="photo" name="photo" class="file-input" accept="image/*" onchange="previewImage(this)">
                        <label for="photo" class="file-input-label">
                            <i class="fas fa-camera"></i>
                            <div><strong>Click to upload a photo</strong></div>
                            <small>JPG, PNG, GIF up to 2MB</small>
                        </label>
                    </div>
                    <div id="preview-container" class="preview-container" style="display: none;">
                        <img id="preview-image" class="preview-image" alt="Preview">
                    </div>
                    <div class="help-text">Optional: A photo helps buyers see the book's condition</div>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-plus"></i> Create Listing
                </button>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            const label = document.querySelector('.file-input-label');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                    label.innerHTML = '<i class="fas fa-check"></i><div><strong>Photo selected!</strong></div><small>Click to change</small>';
                    label.style.borderColor = '#10b981';
                    label.style.color = '#10b981';
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
