<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Open Graph / Social Media -->
    <meta property="og:title" content="{{ $subCategoryData->meta_title }}">
    <meta property="og:description" content="{{ $subCategoryData->meta_description }}">

    @include('market.website.includes.header_links')

    <title>{{ $subCategoryData->meta_title ?? $subCategoryData->sub_cat_name }} - Feature Desk</title>
    <meta name="description" content="{{ $subCategoryData->meta_description }}" />
    <meta name="keywords" content="{{ $subCategoryData->meta_keywords }}" />

    @if(!empty($subCategoryData->page_schema))
    {!! $subCategoryData->page_schema !!}
    @else
    @endif

</head>



<body style="background-color: #FFFFFF; height: auto;">
    <!-- Navbar Start -->
    @include('market.website.includes.navbar')
    <!-- Navbar End -->

    <style>
        @media (max-width: 768px) {
            .main-p {
                display: none;
            }
        }
    </style>
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
                            <li class="breadcrumb-item">
                                <a href="{{ url('/' . $categoryData->url) }}" class="text-decoration-none text-muted">
                                    {{ $categoryData->category_name }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-success" aria-current="page">
                                {{ $subCategoryData->sub_cat_name }}
                            </li>
                        </ol>
                    </nav>

                </div>

            </div>

            {{-- Page Title / H1 --}}
            <div class="mt-3">
                <h1 class="h3 mb-0 fw-bold text-dark">
                    {{ $subCategoryData->sub_cat_name }}
                </h1>
                @if(!empty($subCategoryData->meta_description))
                <p class="text-muted mt-2 mb-0 main-p">{{ $subCategoryData->meta_description }}</p>
                @endif
            </div>
        </div>
    </section>
    {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}

    <!-- Products Section -->
    <section class="container-fluid" style="margin-top: 10px;">
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