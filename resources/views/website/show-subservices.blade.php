<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $service->name }} - Sub Services</title>
  @include('includes.header_links')
<style>
    body {
      background: #f8fafc;
      font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    }

    .subservices-page {
      max-width: 1400px;
      margin: 0 auto;
      padding: 2rem 1.5rem;
    }

    .page-title {
      margin-bottom: 1.8rem;
    }

    .page-title h1 {
      font-size: 1.6rem;
      font-weight: 600;
      color: #0f172a;
      margin: 0;
    }

    .page-title p {
      color: #475569;
      margin-top: 0.2rem;
      font-size: 0.9rem;
    }

    /* Grid system */
    .subservices-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 1rem;
    }

    /* Tablets: 3 columns */
    @media (max-width: 992px) {
      .subservices-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    /* Mobile & small devices: always 3 columns */
    @media (max-width: 768px) {
      .subservices-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 0.7rem;
      }
    }

    /* Very small phones: reduce gap & font sizes */
    @media (max-width: 480px) {
      .subservices-grid {
        gap: 0.5rem;
      }
    }

    /* Card */
    .subservice-card {
      background: transparent;
      border-radius: 12px;
      transition: all 0.2s ease;
    }

    .subservice-card:hover {
      transform: translateY(-2px);
    }

    /* Image container */
    .card-image {
      position: relative;
      width: 100%;
      aspect-ratio: 1 / 1;
      background: #f1f5f9;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
      border: 1px solid #e9eef3;
    }

    .card-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .card-image .no-image {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      height: 100%;
      font-size: 32px;
      color: #94a3b8;
      background: #f1f5f9;
    }

    /* Overlay – only at bottom, no blur, gradient is semi‑transparent */
    .image-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 60%, transparent 100%);
      color: white;
      padding: 0.5rem 0.4rem 0.3rem;
      text-align: left;
      /* No backdrop-filter to keep image clear */
    }

    .overlay-name {
      font-weight: 700;
      font-size: 0.8rem;
      margin-bottom: 0.1rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .overlay-price {
      font-weight: 600;
      font-size: 0.7rem;
      opacity: 0.95;
      margin-bottom: 0.1rem;
    }

    .overlay-description {
      font-size: 0.6rem;
      opacity: 0.85;
      line-height: 1.2;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    /* Reduce fonts further on very small screens */
    @media (max-width: 480px) {
      .overlay-name {
        font-size: 0.7rem;
      }
      .overlay-price {
        font-size: 0.6rem;
      }
      .overlay-description {
        font-size: 0.5rem;
        -webkit-line-clamp: 1; /* only one line on tiny phones */
      }
      .image-overlay {
        padding: 0.3rem 0.3rem 0.2rem;
      }
    }

    .back-link {
      display: inline-block;
      margin-top: 2rem;
      font-size: 0.85rem;
      color: #475569;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
      color: #0f172a;
    }
  </style>
</head>

<body>
  @include('includes.navbar')

  <div class="subservices-page mt-5">
    <div class="page-title">
      <h1>{{ $service->name }} – Sub Services</h1>
      <p>Explore detailed services offered under {{ $service->name }}</p>
    </div>

    @if($subServices->count() > 0)
    <div class="subservices-grid">
      @foreach ($subServices as $sub)
      <div class="subservice-card">
        <div class="card-image">
          @if($sub->image && file_exists(public_path($sub->image)))
            <img src="/{{ $sub->image }}" alt="{{ $sub->name }}">
          @else
            <div class="no-image">📦</div>
          @endif
          <div class="image-overlay">
            <div class="overlay-name">{{ $sub->name }}</div>
            <div class="overlay-price">Rs. {{ number_format($sub->price) }}</div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="empty-state" style="text-align:center; padding:2rem; background:white; border-radius:16px;">
      <span style="font-size: 2rem;">📭</span>
      <h3 style="margin: 0.5rem 0; font-size:1.2rem;">No Sub‑Services Found</h3>
      <p style="font-size:0.85rem;">There are no sub‑services available under {{ $service->name }} at the moment.</p>
    </div>
    @endif

    <a href="{{ url('/services') }}" class="back-link">← Back to all services</a>
  </div>

  @include('includes.footer')
  @include('includes.footer_links')
</body>

</html>