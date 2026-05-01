<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Results for "{{ $query }}" - ZipGo</title>
  <meta name="description" content="Search results for {{ $query }} on ZipGo">
  @include('includes.header_links')
  <style>
    .search-page {
      max-width: 1280px;
      margin: 0 auto;
      padding: 2rem 1.5rem;
    }

    .page-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .page-header h1 {
      font-size: 2rem;
      font-weight: 700;
      color: #1f2937;
    }

    .page-header p {
      color: #6b7280;
      font-size: 1rem;
    }

    .search-section {
      margin-bottom: 2.5rem;
    }

    .section-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: #111827;
      border-left: 4px solid #4f46e5;
      padding-left: 1rem;
      margin-bottom: 1.5rem;
    }

    .results-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 1.5rem;
    }

    .result-card {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      padding: 1.2rem;
      transition: transform 0.2s, box-shadow 0.2s;
      border: 1px solid #eef2f6;
      text-decoration: none;
      color: inherit;
      display: block;
    }

    .result-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .result-icon {
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }

    .result-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: #111827;
      margin-bottom: 0.25rem;
    }

    .result-sub {
      font-size: 0.85rem;
      color: #6b7280;
    }

    .empty-state {
      text-align: center;
      padding: 3rem;
      background: white;
      border-radius: 16px;
      color: #6c757d;
    }

    .badge-count {
      background: #eef2ff;
      color: #4f46e5;
      border-radius: 30px;
      padding: 0.2rem 0.7rem;
      font-size: 0.75rem;
      font-weight: 500;
      display: inline-block;
      margin-left: 0.75rem;
    }
  </style>
</head>

<body>
  @include('includes.navbar')

  <div class="search-page mt-5">
    <div class="page-header">
      <h1>Search Results for “{{ $query }}”</h1>
      <p>We found matches in cities, services, and experts</p>
    </div>

    @if($cities->count() || $services->count() || $experts->count())
      {{-- Cities --}}
      @if($cities->count())
      <div class="search-section">
        <div class="section-title">
          📍 Cities <span class="badge-count">{{ $cities->count() }}</span>
        </div>
        <div class="results-grid">
          @foreach($cities as $city)
          <a href="/city/{{ $city->slug }}" class="result-card">
            <div class="result-icon">🏙️</div>
            <div class="result-title">{{ $city->name }}</div>
            <div class="result-sub">Explore services in this city</div>
          </a>
          @endforeach
        </div>
      </div>
      @endif

      {{-- Services --}}
      @if($services->count())
      <div class="search-section">
        <div class="section-title">
          🔧 Services <span class="badge-count">{{ $services->count() }}</span>
        </div>
        <div class="results-grid">
          @foreach($services as $service)
          <a href="/service/{{ $service->slug }}" class="result-card">
            <div class="result-icon">🛠️</div>
            <div class="result-title">{{ $service->name }}</div>
            <div class="result-sub">View details & providers</div>
          </a>
          @endforeach
        </div>
      </div>
      @endif

      {{-- Experts --}}
      @if($experts->count())
      <div class="search-section">
        <div class="section-title">
          👤 Experts <span class="badge-count">{{ $experts->count() }}</span>
        </div>
        <div class="results-grid">
          @foreach($experts as $expert)
          <a href="/expert/{{ $expert->id }}" class="result-card">
            <div class="result-icon">⭐</div>
            <div class="result-title">{{ $expert->name }}</div>
            <div class="result-sub">Professional expert</div>
          </a>
          @endforeach
        </div>
      </div>
      @endif
    @else
      <div class="empty-state">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
        <h3>No results found</h3>
        <p>We couldn't find anything matching “{{ $query }}”.<br>Try different keywords or browse our categories.</p>
        <a href="/" style="display: inline-block; margin-top: 1rem; background: #4f46e5; color: white; padding: 0.5rem 1.2rem; border-radius: 40px; text-decoration: none;">Go to Homepage</a>
      </div>
    @endif
  </div>

  @include('includes.footer')
  @include('includes.footer_links')
</body>

</html>