<!doctype html>
<html lang="en">

<head>
    @include('market.website.includes.header_links')

    <title>Feature Desk Blogs</title>
    <meta name="description" content="Feature Desk offers the best online shopping experience in Pakistan with huge discounts, flash sales, and genuine products. Shop now and save big!" />
    <meta name="keywords" content="Feature Desk, online shopping pakistan, discounts pakistan, flash sale, cheap products, best deals pakistan, ecommerce pakistan" />

    <style>
        /* Breadcrumb Banner */
        .inner-banner {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('https://images.unsplash.com/photo-1542838132-9c9b8baf6c35?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80') center/cover no-repeat;
            padding: 120px 0 90px;
            color: #fff;
            text-align: center;
            position: relative;
        }

        .inner-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(40, 167, 69, 0.25);
        }

        .inner-title h3 {
            font-size: 52px;
            font-weight: 800;
            margin-bottom: 15px;
            text-shadow: 0 3px 15px rgba(0, 0, 0, 0.6);
            letter-spacing: 1px;
        }

        .inner-title ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 12px;
            font-size: 17px;
            font-weight: 500;
        }

        .inner-title ul li a {
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
        }

        .inner-title ul li a:hover {
            color: #28a745;
        }

        .bx-chevrons-right {
            font-size: 20px;
            vertical-align: middle;
        }

        @media (max-width: 992px) {
            .inner-title h3 {
                font-size: 42px;
            }
        }

        @media (max-width: 768px) {
            .inner-banner {
                padding: 90px 0;
            }

            .inner-title h3 {
                font-size: 36px;
            }
        }

        /* Blog Card Styles */
        .blog-imgm {
            position: relative;
            width: 100%;
        }

        .blog-imgm img {
            display: block;
            transition: transform 0.3s ease;
        }

        .blog-imgm:hover img {
            transform: scale(1.05);
        }
    </style>
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
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}" class="text-decoration-none text-muted">
                                    <i class="fas fa-home me-1"></i> Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-success" aria-current="page">
                                Blogs
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="mt-3">
                <h1 class="h3 mb-0 fw-bold text-dark">
                    Let’s Check Some Latest Blog
                </h1>
                <p class="text-muted mt-2 mb-0">Stay informed with our latest insights on interior design trends, furniture tips, and plywood innovations to inspire your next project.</p>
            </div>
        </div>
    </section>
    {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}

    <!-- Blog Section -->
    <div class="blog-area pt-10 pb-10">
        <div class="container">

            <!-- Blog Cards Container -->
            <div class="row pt-45" id="blogs-container">
                @include('market.website.blogs-partial')
            </div>

            <!-- Load More Button -->
            <div class="row mt-2 mb-3">
                <div class="col-12 text-center">
                    @if($blogs->hasMorePages())
                    <button id="load-more-btn" 
                            class="btn btn-success px-5 py-3 fw-bold"
                            data-next="{{ $blogs->nextPageUrl() }}">
                        Load More Blogs
                    </button>
                    @endif

                    <div id="loading" class="d-none mt-3">
                        <span class="spinner-border spinner-border-sm text-success me-2" role="status"></span>
                        Loading more blogs...
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('market.website.includes.footer')

    @include('market.website.includes.footer_links')

    <!-- jQuery + Load More Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {

        $('#load-more-btn').on('click', function() {
            var btn = $(this);
            var nextUrl = btn.data('next');
            var loading = $('#loading');

            if (!nextUrl) return;

            btn.addClass('d-none');
            loading.removeClass('d-none');

            $.ajax({
                url: nextUrl,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.html) {
                        $('#blogs-container').append(response.html);
                    }

                    if (response.next_page_url) {
                        btn.data('next', response.next_page_url);
                        btn.removeClass('d-none');
                    } else {
                        btn.remove(); // Remove button when no more blogs
                    }

                    loading.addClass('d-none');
                },
                error: function() {
                    alert('Something went wrong while loading more blogs. Please try again.');
                    loading.addClass('d-none');
                    btn.removeClass('d-none');
                }
            });
        });

    });
    </script>
</body>

</html>