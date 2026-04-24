<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
<meta property="og:title" content="5 Star Rated Products on Feature Desk | Feature Desk">
<meta property="og:description" content="Discover 5 star rated products on Feature Desk. Shop top-reviewed, trusted, and highly rated items with confidence.">

  @include('market.website.includes.header_links')
  <title>5 Star Rated Products on Feature Desk | Feature Desk</title>
  <meta name="description" content="Discover 5 star rated products on Feature Desk. Shop top-reviewed, trusted, and highly rated items with confidence.">
  <meta name="keywords" content="Feature Desk, Feature Desk, buy products online...">

  <style>
    /* … your existing styles … */
    .load-more-wrapper {
      text-align: center;
      margin-top: 30px;
    }

    .btn-load-more {
      display: inline-block;
      padding: 12px 30px;
      font-size: 16px;
    }

    .spinner {
      display: none;
    }
    @media (max-width: 768px) {
        .main-p { display: none; }
    }

    /* Breadcrumb Banner */
  </style>
</head>

<body style=" background-color: #FFFFFF;">
  @include('market.website.includes.navbar')

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
                            <li class="breadcrumb-item active text-success" aria-current="page">
                                    5 Star Rating
                            </li>
                        </ol>
                    </nav>

                </div>

            </div>

            {{-- Page Title / H1 --}}
            <div class="mt-3">
                <h1 class="h3 mb-0 fw-bold text-dark">
                    5 Star Rating
                </h1>
                <p class="text-muted mt-2 mb-0 main-p">Discover 5 star rated products on Feature Desk. Shop top-reviewed, trusted, and highly rated items with confidence.</p>
            </div>
        </div>
    </section>
    {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}

  <!-- Products Section -->
  @if ($products->count() > 0)
  <section class="container-fluid my-4">
    <div id="products-container" class="products-grid-sm" style="margin-top: 20px;">
      @foreach ($products as $p)
      @include('market.website.includes.product_card_small')
      @endforeach
    </div>
  </section>
  @endif








  @include('market.website.includes.footer')
  @include('market.website.includes.footer_links')
</body>

</html>