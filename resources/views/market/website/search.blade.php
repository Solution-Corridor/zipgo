<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
<meta property="og:title" content="Feature Desk Products | Feature Desk - Buy & Sell Online">
<meta property="og:description" content="Explore Feature Desk – your trusted online marketplace for quality products. From furniture and interiors to daily essentials, buy and sell with ease.">

    @include('market.website.includes.header_links')

    <title>Feature Desk Products | Feature Desk - Buy & Sell Online</title>
    <meta name="description" content="Explore Feature Desk – your trusted online marketplace for quality products. From furniture and interiors to daily essentials, buy and sell with ease." />
    <meta name="keywords" content="Feature Desk, Feature Desk, online marketplace, buy products online, sell products online, shopping in Pakistan, furniture, interiors, daily essentials, quality products" />

</head>



<body style="background-color: #ffffff;">
    <!-- Navbar Start -->
    @include('market.website.includes.navbar')
    <!-- Navbar End -->

    <!-- Products Section -->
    <section class="services-area-twoo ptt-100 pbb-70" style="padding-top: 20px; padding-bottom: 5px; margin-top: 80px;">
        <div class="container-fluid">
            @if (!empty($products))
            <div class="products-grid-sm">
                @foreach ($products as $p)
                @include('market.website.includes.product_card_small')
                @endforeach
            </div>
            @else
            <p class="text-danger text-center w-100">No result found</p>
            @endif
        </div>
    </section>

    <!-- Footer -->
    @include('market.website.includes.footer')
    @include('market.website.includes.footer_links')

</body>

</html>