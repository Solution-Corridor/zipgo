<!doctype html>
<html lang="en">

<head>
    @include('market.website.includes.header_links')
    <title>HTML Sitemap - Feature Desk</title>
    <style>
        .sitemap-container {
            padding: 30px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .sitemap-section {
            margin-bottom: 40px;
        }
        
        .sitemap-section h3 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        
        .sitemap-list {
            list-style: none;
            padding: 0;
        }
        
        .sitemap-list li {
            margin-bottom: 8px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        
        .sitemap-list li:last-child {
            border-bottom: none;
        }
        
        .sitemap-list a {
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sitemap-list a:hover {
            color: #007bff;
        }
        
        .sitemap-list i {
            color: #28a745;
            font-size: 14px;
        }
        
        .page-header {
            background: #f8f9fa;
            padding: 20px 0;
            margin-bottom: 30px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .page-header h1 {
            color: #333;
            margin: 0;
            font-size: 2rem;
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    @include('market.website.includes.navbar')
    <!-- Navbar End -->

    <div class="page-header">
        <div class="container">
            <h1>Site Map</h1>
        </div>
    </div>

    <div class="container sitemap-container">
        <div class="row">
            <!-- Main Pages -->
            <div class="col-md-12 sitemap-section">
                <h3>Main Pages</h3>
                <ul class="sitemap-list">
                    <li>
                        <a href="{{ url('/') }}">
                            <i class="fa fa-check-circle"></i>
                            Feature Desk Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/products') }}">
                            <i class="fa fa-check-circle"></i>
                            All Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/quick-selling') }}">
                            <i class="fa fa-check-circle"></i>
                            Quick Selling
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/high-rated') }}">
                            <i class="fa fa-check-circle"></i>
                            High Rated Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/categories') }}">
                            <i class="fa fa-check-circle"></i>
                            Categories
                        </a>
                    </li>
                </ul>
            </div>


            <!-- Blogs -->
            <div class="col-md-12 sitemap-section">
                <h3>Blogs ({{ count($blogs) }})</h3>
                <ul class="sitemap-list">
                    @foreach ($blogs as $blog)
                    <li>
                        <a href="{{ url('/blog/'.$blog->slug) }}">
                            <i class="fa fa-check-circle"></i>
                            {{ ucwords($blog->title) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

                        

            <!-- Categories -->
            <div class="col-md-12 sitemap-section">
                <h3>Categories ({{ count($categories) }})</h3>
                <ul class="sitemap-list">
                    @foreach ($categories as $category)
                    <li>
                        <a href="{{ url('/'.$category->url) }}">
                            <i class="fa fa-check-circle"></i>
                            {{ ucwords($category->category_name) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Sub Categories -->
            <div class="col-md-12 sitemap-section">
                <h3>Sub Categories ({{ count($sub_categories) }})</h3>
                <ul class="sitemap-list">
                    @foreach ($sub_categories as $sub_category)
                    <li>
                        <a href="{{ url('/'.$sub_category->category_url.'/'.$sub_category->sub_cat_url) }}">
                            <i class="fa fa-check-circle"></i>
                            {{ ucwords($sub_category->sub_cat_name) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Products -->
            <div class="col-md-12 sitemap-section">
                <h3>Products ({{ count($products) }})</h3>
                <ul class="sitemap-list">
                    @foreach ($products as $product)
                    <li>
                        <a href="{{ url('/product/'.$product->slug) }}">
                            <i class="fa fa-check-circle"></i>
                            {{ ucwords($product->name) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Product Reviews -->
            <div class="col-md-12 sitemap-section">
                <h3>Product Reviews ({{ count($products) }})</h3>
                <ul class="sitemap-list">
                    @foreach ($products as $product)
                    <li>
                        <a href="{{ url('/product/'.$product->slug.'/reviews') }}">
                            <i class="fa fa-check-circle"></i>
                            {{ ucwords($product->name) }} Reviews
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('market.website.includes.footer')
    @include('market.website.includes.footer_links')
</body>

</html>