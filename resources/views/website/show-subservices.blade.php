<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $service->name }} - Sub Services</title>
  @include('includes.header_links')
  <style>
    /* Same white background, clean cards */
    body {
      background: #f5f7fb;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    .subservices-page {
      max-width: 1280px;
      margin: 0 auto;
      padding: 2rem 1.5rem;
    }

    .page-title {
      margin-top: 2.6rem;
      margin-bottom: 2rem;
    }

    .page-title h1 {
      font-size: 1.8rem;
      font-weight: 600;
      color: #1f2937;
      margin: 0;
    }

    .page-title p {
      color: #6b7280;
      margin-top: 0.25rem;
    }

    /* Grid layout */
    .subservices-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
      gap: 1.5rem;
    }

    /* Card style */
    .subservice-card {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      padding: 1.25rem;
      transition: 0.2s;
      border: 1px solid #eef2f6;
      display: flex;
      flex-direction: column;
    }

    .subservice-card:hover {
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      transform: translateY(-2px);
    }

    /* Image area – similar to avatar */
    .card-image {
      width: 100%;
      height: 160px;
      background: #eef2ff;
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .card-image .no-image {
      font-size: 48px;
      color: #9ca3af;
    }

    .subservice-name {
      font-size: 1.2rem;
      font-weight: 600;
      color: #111827;
      margin-bottom: 0.5rem;
    }

    .subservice-price {
      font-size: 1.2rem;
      font-weight: 700;
      color: #131A29;
      margin: 0.5rem 0;
    }

    .subservice-description {
      font-size: 0.85rem;
      color: #4b5563;
      line-height: 1.4;
      margin-bottom: 1rem;
      flex-grow: 1;
    }

    .info-row {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.85rem;
      color: #374151;
      margin-bottom: 0.5rem;
    }

    .info-row i {
      width: 20px;
      color: #131A29;
    }

    .btn-view {
      display: block;
      background: #131A29;
      color: white;
      text-align: center;
      padding: 0.6rem;
      border-radius: 40px;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.85rem;
      transition: 0.2s;
      margin-top: 0.75rem;
    }

    .btn-view:hover {
      background: #0f1625;
    }

    .empty-state {
      text-align: center;
      padding: 3rem;
      background: white;
      border-radius: 16px;
      color: #6c757d;
    }

    .back-link {
      display: inline-block;
      margin-top: 2rem;
      color: #131A29;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  @include('includes.navbar')

  <div class="subservices-page">
    <div class="page-title">
      <h1>{{ $service->name }} – Sub Services</h1>
      <p>Explore detailed services offered under {{ $service->name }}</p>
    </div>

    @if($subServices->count() > 0)
    <div class="subservices-grid">
      @foreach ($subServices as $sub)
      <div class="subservice-card">
        <!-- Image -->
        <div class="card-image">
          @if($sub->image && file_exists(public_path($sub->image)))
          <img src="/{{ $sub->image }}" alt="{{ $sub->name }}">
          @else
          <div class="no-image">📦</div>
          @endif
        </div>

        <!-- Name -->
        <div class="subservice-name">{{ $sub->name }}</div>

        <!-- Price -->
        <div class="subservice-price">Rs. {{ number_format($sub->price) }}</div>

        <!-- Description (truncated) -->
        <div class="subservice-description">
          {{ Str::limit($sub->description, 80) }}
        </div>

        <!-- Optional: extra info (like service category) -->
        <div class="info-row">
          <i class="fas fa-tag"></i>
          <span>Main Service: {{ $service->name }}</span>
        </div>

        <!-- View details button (if you have a dedicated route for sub-service details) -->
        <a href="" class="btn-view">View Details →</a>
      </div>
      @endforeach
    </div>
    @else
    <div class="empty-state">
      <span style="font-size: 3rem;">📭</span>
      <h3 style="margin: 1rem 0 0.5rem;">No Sub‑Services Found</h3>
      <p>There are no sub‑services available under {{ $service->name }} at the moment.</p>
    </div>
    @endif

    <!-- Optional back link -->
    <a href="{{ url('/services') }}" class="back-link">← Back to all services</a>
  </div>

  @include('includes.footer')
  @include('includes.footer_links')
</body>

</html>