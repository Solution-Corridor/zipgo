<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Open Graph / Social Media -->
    <meta property="og:title" content="{{ $categoryData->meta_title }}">
    <meta property="og:description" content="{{ $categoryData->meta_description }}">

    @include('market.website.includes.header_links')
    <title>{{ $categoryData->meta_title ?? $categoryData->category_name }} - Feature Desk</title>
    <meta name="description" content="{{ $categoryData->meta_description }}" />
    <meta name="keywords" content="{{ $categoryData->meta_keywords }}" />

    @if(!empty($categoryData->page_schema))
            {!! $categoryData->page_schema !!}
    @else
    @endif


</head>

<body>
    <!-- Navbar Start -->
    @include('market.website.includes.navbar')
    <!-- Navbar End -->


    {{-- ====================== BREADCRUMBS + PAGE TITLE ====================== --}}
<section class="bg-light border-bottom" style="margin-top:70px; padding: 15px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-8">

                {{-- Breadcrumb --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}" class="text-decoration-none text-muted">
                                <i class="fas fa-home me-1"></i> Home
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('/categories') }}" class="text-decoration-none text-muted">
                                Categories
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-success" aria-current="page">
                            {{ $categoryData->category_name }}
                        </li>
                    </ol>
                </nav>

            </div>
            
        </div>

        {{-- Page Title / H1 --}}
        <div class="mt-3">
            <h1 class="h3 mb-0 fw-bold text-dark">
                {{ $categoryData->category_name }}
            </h1>
            @if(!empty($categoryData->meta_description))
                <p class="text-muted mt-2 mb-0 main-p">{{ $categoryData->meta_description }}</p>
            @endif
        </div>
    </div>
</section>
{{-- ====================== END BREADCRUMBS + TITLE ====================== --}}

    <!-- Subcategories and Products Section -->
    <section class="services-area-twoo pbb-70" style="padding-bottom: 5px;">
        <div class="container">
            <!-- Subcategories Section -->
            @if ($sub_categories->isNotEmpty())
            <style>
                /* Section */
                .category-section {
                    max-width: 1280px;
                    margin: 0 auto;
                    padding: 20px;
                }

                /* Header (Category + View All) */
                .category-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                }

                .category-header h2 {
                    font-size: 24px;
                    font-weight: 600;
                    color: #222;
                }

                .view-all-btn {
                    background: #28a745;
                    color: #fff;
                    border: none;
                    padding: 8px 20px;
                    border-radius: 8px;
                    font-size: 14px;
                    cursor: pointer;
                    transition: background 0.2s;
                }

                .view-all-btn:hover {
                    background: #218838;
                }

                /* Carousel Container */
                .carousel-wrapper {
                    position: relative;
                    overflow: hidden;
                    border-radius: 12px;
                }

                .carousel-track {
                    display: flex;
                    gap: 24px;
                    padding: 10px 0;
                    scroll-behavior: smooth;
                    overflow-x: auto;
                    scrollbar-width: none;
                    /* Firefox */
                }

                .carousel-track::-webkit-scrollbar {
                    display: none;
                    /* Chrome/Safari */
                }

                /* Category Item */
                .category-item {
                    flex: 0 0 auto;
                    width: 140px;
                    text-align: center;
                    cursor: pointer;
                    transition: transform 0.2s;
                }

                .category-item:hover {
                    transform: translateY(-4px);
                }

                .category-img {
                    width: 120px;
                    height: 120px;
                    overflow: hidden;
                    border-radius: 10px;
                    margin: 0 auto 12px;
                    border: 4px solid #fff;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                }

                .category-img img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .category-item h2 {
                    font-size: 14px;
                    color: #333;
                    font-weight: 500;
                }

                /* Navigation Arrows */
                .carousel-nav {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    width: 40px;
                    height: 40px;
                    background: rgba(255, 255, 255, 0.9);
                    border: none;
                    border-radius: 50%;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 20px;
                    color: #333;
                    cursor: pointer;
                    z-index: 10;
                    transition: opacity 0.3s, background 0.3s;
                }

                .carousel-nav:hover {
                    background: #fff;
                }

                .carousel-nav.disabled {
                    opacity: 0.3;
                    cursor: not-allowed;
                }

                .carousel-prev {
                    left: 10px;
                }

                .carousel-next {
                    right: 10px;
                }

                /* Responsive */
                @media (max-width: 768px) {
                    .category-item {
                        width: 110px;
                    }

                    .category-img {
                        width: 90px;
                        height: 90px;
                    }

                    .carousel-track {
                        gap: 16px;
                    }
                    .main-p { display: none; }

                    /* Hide arrows on very small screens if you want */
                    /* .carousel-nav { display: none; } */
                }
            </style>

            <section class="category-section">
                
                <div class="carousel-wrapper">
                    <button class="carousel-nav carousel-prev disabled" aria-label="Previous">&#8249;</button>
                    <button class="carousel-nav carousel-next" aria-label="Next">&#8250;</button>

                    <div class="carousel-track" id="carouselTrack">
                        @foreach ($sub_categories as $sub_cat)
                        <div class="category-item">
                            <a href="{{ url('/' . $categoryData->url . '/' . $sub_cat->sub_cat_url) }}">
                                <div class="category-img">
                                    <img src="/{{ $sub_cat->feature_image }}"
                                        onerror="this.onerror=null; this.src='/assets/images/main.jpg';"
                                        alt="{{ $sub_cat->sub_cat_name }}"
                                        title="{{ $sub_cat->sub_cat_name }}">
                                </div>
                                <h2>{{ $sub_cat->sub_cat_name }}</h2>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Auto-scroll + Arrow navigation script -->
            <script>
                const track = document.getElementById('carouselTrack');
                const prevBtn = document.querySelector('.carousel-prev');
                const nextBtn = document.querySelector('.carousel-next');

                // Amount to scroll when clicking arrows (approx 3 items visible)
                const scrollAmount = track.offsetWidth * 0.75; // adjust if needed

                // Update button states
                function updateButtons() {
                    prevBtn.classList.toggle('disabled', track.scrollLeft <= 0);
                    nextBtn.classList.toggle('disabled', 
                        track.scrollLeft + track.clientWidth >= track.scrollWidth - 10); // small tolerance
                }

                // Arrow click handlers
                prevBtn.addEventListener('click', () => {
                    if (track.scrollLeft > 0) {
                        track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                    }
                });

                nextBtn.addEventListener('click', () => {
                    if (track.scrollLeft + track.clientWidth < track.scrollWidth) {
                        track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    }
                });

                // Listen to scroll to update button states
                track.addEventListener('scroll', updateButtons);

                // Initial check
                updateButtons();

                // Your existing auto-scroll (kept unchanged)
                let scrollAmountAuto = 0;
                const scrollStep = 180; // adjust speed
                setInterval(() => {
                    if (scrollAmountAuto >= track.scrollWidth / 2) scrollAmountAuto = 0;
                    track.scrollTo({
                        left: scrollAmountAuto,
                        behavior: 'smooth'
                    });
                    scrollAmountAuto += scrollStep;
                }, 4000);
            </script>
            @endif

        </div>
    </section>

    <section class="container-fluid">
        <div class="products-grid-sm">
            @foreach ($products as $p)
            @include('market.website.includes.product_card_small')
            @endforeach
        </div>
    </section>

    <!-- Footer -->
    @include('market.website.includes.footer')
    @include('market.website.includes.footer_links')
</body>

</html>