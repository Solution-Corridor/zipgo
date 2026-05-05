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

    /* 6-column grid */
    .subservices-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 1rem;
    }

    /* Card – just the image container, no extra padding */
    .subservice-card {
      background: transparent;
      border-radius: 12px;
      transition: all 0.2s ease;
    }

    .subservice-card:hover {
      transform: translateY(-2px);
    }

    /* Image container with overlay text (everything on image) */
    .card-image {
      position: relative;
      width: 100%;
      aspect-ratio: 1 / 1; /* square, adjust if needed */
      background: #f1f5f9;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
      border: 1px solid #e9eef3;
    }

    .card-image img {
      width: 100%;
      height: 100%;
      object-fit: contain;
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

    /* Overlay – shows name, price, description */
    .image-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(to top, rgba(0,0,0,0.85), rgba(0,0,0,0.4) 60%, transparent);
      color: white;
      padding: 0.6rem 0.5rem 0.5rem;
      text-align: left;
      backdrop-filter: blur(3px);
    }

    .overlay-name {
      font-weight: 700;
      font-size: 0.85rem;
      margin-bottom: 0.2rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .overlay-price {
      font-weight: 600;
      font-size: 0.75rem;
      opacity: 0.95;
      margin-bottom: 0.2rem;
    }

    .overlay-description {
      font-size: 0.65rem;
      opacity: 0.85;
      line-height: 1.3;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    /* No extra buttons or rows */
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

    @media (max-width: 1100px) {
      .subservices-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 700px) {
      .subservices-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
      .subservices-grid { grid-template-columns: 1fr; }
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
            <div class="overlay-description">{{ Str::limit($sub->description, 60) }}</div>
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