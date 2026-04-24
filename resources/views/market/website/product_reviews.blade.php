<!doctype html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Open Graph / Social Media -->
    <meta property="og:title" content="{{ $product[0]->name }} - Customer Reviews | Feature Desk">
    <meta property="og:description" content="Read genuine customer reviews for {{ $product[0]->name }}. {{ $product[0]->ratting_count ?? 'Thousands' }} verified buyers rated this product.">

    @include('market.website.includes.header_links')
    <title>{{ $product[0]->name }} - Customer Reviews | Feature Desk</title>
    <meta name="description" content="Read genuine customer reviews for {{ $product[0]->name }}. {{ $product[0]->ratting_count ?? 'Thousands' }} verified buyers rated this product.">

    <style>
        :root {
            --primary: #e91e63;
            --success: #27ae60;
            --warning: #f39c12;
            --gray-100: #f8f9fa;
            --gray-300: #dee2e6;
            --gray-600: #6c757d;
            --gray-800: #343a40;
        }

        .reviews-header {
            border-bottom: 1px solid var(--gray-300);
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }

        .overall-rating {
            background: var(--gray-100);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
        }

        .big-rating {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--gray-800);
        }

        .star-lg {
            font-size: 1.8rem;
            color: #f39c12;
        }

        .rating-bars {
            margin: 1.5rem 0;
        }

        .rating-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 8px 0;
            font-size: 0.95rem;
        }

        .rating-bar .label {
            width: 40px;
            text-align: right;
        }

        .progress {
            flex: 1;
            height: 8px;
            background: var(--gray-300);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--warning);
            border-radius: 4px;
            transition: width 0.6s ease;
        }

        .review-card {
            border: 1px solid var(--gray-300);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            background: #fff;
        }

        .review-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 0.75rem;
        }

        .reviewer-avatar {
            width: 48px;
            height: 48px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .reviewer-name {
            font-weight: 600;
            color: var(--gray-800);
        }

        .verified-badge {
            background: var(--success);
            color: white;
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .review-date {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .helpful-btn {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .helpful-btn i {
            color: var(--success);
        }

        .review-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .stars {
            font-size: 0.9rem
        }

        .myp {
            font-size: 1rem;
            color: var(--gray-800);
        }

        .mybtn {
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .big-rating {
                font-size: 2.8rem;
            }

            .overall-rating {
                padding: 1rem;
            }

            .review-title {
                font-size: 0.8rem;
            }

            .review-date {
                color: var(--gray-600);
                font-size: 0.6rem;
            }

            .verified-badge {
                font-size: 0.5rem;
                padding: 2px 8px;
                border-radius: 20px;
                float: right;
            }

            .stars {
                font-size: 0.6rem
            }

            .reviewer-name {
                font-weight: 600;
                font-size: 0.9rem;
            }

            .reviewer-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .myp {
                font-size: 0.8rem;
            }

            .mybtn {
                font-size: 0.8rem;
            }

            .review-card {
                border-radius: 10px;
                padding: 0.7rem;
                margin-bottom: 1rem;
            }

            .review-header {
                display: flex;
                align-items: center;
                gap: 5px;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>

<body>
    @include('market.website.includes.navbar')

    <!-- ==================== PRODUCT REVIEWS PAGE ==================== -->
    <section class="py-5" style="margin-top: 30px;">
        <div class="container">
            <div class="row">
                <!-- Back to Product -->
                <div class="col-12 mb-4">
                    <a href="{{ url()->previous() }}" class="text-decoration-none text-muted">
                        ← Back to {{ $product[0]->name }}
                    </a>
                </div>

                <div class="col-lg-3">
                    <!-- Overall Rating Summary -->
                    <div class="overall-rating">
                        @php
                        $rating = $product[0]->product_ratting ?? 4.6;
                        $totalReviews = $product[0]->ratting_count ?? 1247;
                        $fiveStar = rand(45, 60);
                        $fourStar = rand(20, 30);
                        $threeStar = rand(8, 15);
                        $twoStar = rand(2, 6);
                        $oneStar = 100 - ($fiveStar + $fourStar + $threeStar + $twoStar);
                        @endphp

                        <div class="big-rating">{{ number_format($rating, 1) }}</div>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa{{ $i <= $rating ? 's' : 'r' }} fa-star star-lg {{ $i <= $rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                        </div>
                        <div class="text-muted">Based on <strong>{{ number_format($totalReviews) }}</strong> reviews</div>

                        <div class="rating-bars mt-4">
                            @foreach([5 => $fiveStar, 4 => $fourStar, 3 => $threeStar, 2 => $twoStar, 1 => $oneStar] as $star => $percent)
                            <div class="rating-bar">
                                <span class="label">{{ $star }} ★</span>
                                <div class="progress">
                                    <div class="progress-fill" style="width: {{ $percent }}%"></div>
                                </div>
                                <span class="text-muted">{{ $percent }}%</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <h1 class="mb-4 review-title">Customer Reviews for {{ $product[0]->name }}</h1>

                    <!-- Sample Reviews (You can loop real ones later) -->
                    @php
                    $fakeReviews = [
                    ['name' => 'Ahmed Khan', 'rating' => 5, 'date' => '2 days ago', 'text' => 'Amazing quality! Exactly as described. Fast delivery and well packed. Highly recommended!', 'helpful' => 42],
                    ['name' => 'Saba Ali', 'rating' => 4, 'date' => '1 week ago', 'text' => 'Good product, works perfectly. Only issue was slight delay in shipping but seller was responsive.', 'helpful' => 18],
                    ['name' => 'Usman R.', 'rating' => 5, 'date' => '3 weeks ago', 'text' => 'Best purchase ever! Super fast charging and great build quality. Will buy again.', 'helpful' => 89],
                    ['name' => 'Fatima Noor', 'rating' => 5, 'date' => '1 month ago', 'text' => 'My kids love it! Very durable and safe material. Worth every penny.', 'helpful' => 67],
                    ['name' => 'Bilal Shah', 'rating' => 4, 'date' => '2 months ago', 'text' => 'Nice product, good value for money. Could have better instructions but overall satisfied.', 'helpful' => 12],
                    ];
                    @endphp

                    @foreach($fakeReviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <div class="reviewer-avatar">{{ strtoupper(substr($review['name'], 0, 1)) }}</div>
                            <div>
                                <div class="reviewer-name">{{ $review['name'] }}</div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa{{ $i <= $review['rating'] ? 's' : 'r' }} fa-star text-warning"></i>
                                            @endfor
                                    </div>
                                    <span class="verified-badge">Verified Purchase</span>
                                </div>
                            </div>
                            <div class="ms-auto text-end">
                                <div class="review-date">{{ $review['date'] }}</div>
                            </div>
                        </div>

                        <p class="myp mt-3 mb-2">{{ $review['text'] }}</p>

                        <div class="helpful-btn">
                            <i class="fas fa-thumbs-up"></i> Helpful ({{ $review['helpful'] }})
                        </div>
                    </div>
                    @endforeach

                    <!-- Load More Button -->
                    <div class="text-center mt-4">
                        <button class="mybtn btn btn-outline-primary px-5">Load More Reviews</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('market.website.includes.footer')
    @include('market.website.includes.footer_links')
</body>

</html>