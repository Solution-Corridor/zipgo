<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
  <meta property="og:title" content="Categories : Feature Desk">
  <meta property="og:description" content="Explore all shopping categories at Feature Desk - Pakistan's trusted online marketplace.">

  @include('market.website.includes.header_links')
  
  <title>Categories : Feature Desk</title>
  <meta name="description" content="Explore all shopping categories at Feature Desk - Pakistan's trusted online marketplace." />
  <meta name="keywords" content="Feature Desk, categories, online shopping Pakistan, Feature Desk" />

  <style>
    .categories-section {
      padding: 60px 0 80px;
      background: #f8f9fa;
    }

    .categories-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
      gap: 25px;
      padding: 20px 0;
    }

    .category-item {
      text-align: center;
      transition: all 0.3s ease;
    }

    .category-item a {
      text-decoration: none;
      color: inherit;
      display: block;
    }

    .category-box {
      background: white;
      border-radius: 16px;
      padding: 20px 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
      transition: all 0.4s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .category-item:hover .category-box {
      transform: translateY(-8px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }

    .category-item img {
      width: 110px;
      height: 110px;
      object-fit: contain;
    }

    

    .category-name {
      margin-top: 14px;
      font-size: 15px;
      font-weight: 600;
      color: #333;
      line-height: 1.3;
    }

    /* Responsive Adjustments */
    @media (max-width: 576px) {
      .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 18px;
      }
      
      .category-item img {
        width: 80px;
        height: 80px;
      }
    }

    @media (min-width: 577px) and (max-width: 768px) {
      .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
      }
    }

    @media (min-width: 992px) {
      .categories-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 30px;
      }
    }
  </style>
</head>

<body>

  @include('market.website.includes.navbar')

  <!-- Breadcrumbs + Page Title -->
  <section class="bg-light border-bottom" style="margin-top:70px; padding: 20px 0;">
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
              <li class="breadcrumb-item active text-success" aria-current="page">Categories</li>
            </ol>
          </nav>
        </div>
      </div>

      <div class="mt-4">
        <h1 class="h3 mb-0 fw-bold text-dark">Shop by Category</h1>
        <p class="text-muted mt-2 mb-0">Explore all shopping categories at Feature Desk - Pakistan's trusted online marketplace</p>
      </div>
    </div>
  </section>

  <!-- Categories Grid -->
  <section class="categories-section">
    <div class="container">
      <div class="categories-grid">
        @foreach ($categories as $cat)
          <div class="category-item">
            <a href="{{ $cat->url ?? '#' }}">
              <div class="category-box">
                <img src="/{{ $cat->feature_image ?? '' }}"
                     onerror="this.onerror=null; this.src='/assets/images/favicon.png';"
                     alt="{{ $cat->category_name }}"
                     title="{{ $cat->category_name }}">
                <h5 class="category-name">{{ $cat->category_name }}</h5>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  @include('market.website.includes.footer')
  @include('market.website.includes.footer_links')

</body>
</html>