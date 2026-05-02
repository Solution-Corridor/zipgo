<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    @isset($service)
    {{ $service->name }} Experts
    @else
    {{ $city->name }} Experts
    @endisset
  </title>
  @include('includes.header_links')
  <style>
    /* Simple white background, no gradients */
    body {
      background: #f5f7fb;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    .experts-page {
      max-width: 1280px;
      margin: 0 auto;
      padding: 2rem 1.5rem;
    }

    /* Simple page title */
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

    /* Card grid */
    .experts-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 1.5rem;
    }

    /* Simple white card */
    .expert-card {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      padding: 1.25rem;
      transition: 0.2s;
      border: 1px solid #eef2f6;
    }

    .expert-card:hover {
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      transform: translateY(-2px);
    }

    .card-avatar {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: #eef2ff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      font-weight: 600;
      color: #4f46e5;
      margin: 0 auto 1rem;
      overflow: hidden;
    }

    .card-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .expert-name {
      text-align: center;
      font-size: 1.2rem;
      font-weight: 600;
      color: #111827;
      margin-bottom: 0.25rem;
    }

    .expert-nic {
      text-align: center;
      font-size: 0.8rem;
      color: #6c757d;
      margin-bottom: 1rem;
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
      color: #4f46e5;
    }

    .meta-row {
      display: flex;
      justify-content: space-between;
      margin: 1rem 0;
      font-size: 0.85rem;
      border-top: 1px solid #edf2f7;
      padding-top: 0.75rem;
    }

    .rating {
      display: flex;
      align-items: center;
      gap: 4px;
      color: #f59e0b;
    }

    .btn-view {
      display: block;
      background: #4f46e5;
      color: white;
      text-align: center;
      padding: 0.5rem;
      border-radius: 40px;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.85rem;
      transition: 0.2s;
    }

    .btn-view:hover {
      background: #4338ca;
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
      color: #4f46e5;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  @include('includes.navbar')

  <div class="experts-page">
    @isset($service)
    @php $experts = $service->experts ?? collect(); @endphp
    <div class="page-title">
      <h1>{{ $service->name }} Experts</h1>
      <p>Verified professionals offering {{ $service->name }} services</p>
    </div>
    @endisset

    @isset($city)
    @php
    // $experts is already passed from controller for city
    @endphp
    <div class="page-title">
      <h1>Experts in {{ $city->name }}</h1>
      <p>Local trusted experts available in {{ $city->name }}</p>
    </div>
    @endisset

    @if(isset($experts) && $experts->count() > 0)
      <!-- Experts Section -->
  <section class="container-fluid">
    <div class="products-grid-sm">
      <section class="expert-section">
        <div class="experts-grid">
          @foreach ($experts as $expert)
          @include('includes.experts_card')
          @endforeach
        </div>
      </section>
    </div>
  </section>
    @else
    <div class="empty-state">
      <span style="font-size: 3rem;">🔍</span>
      <h3 style="margin: 1rem 0 0.5rem;">No experts found</h3>
      <p>
        @isset($service)
        No professionals currently listed for {{ $service->name }}.
        @else
        No experts available in {{ $city->name }} at the moment.
        @endisset
      </p>
    </div>
    @endif
  </div>

  @include('includes.footer')
  @include('includes.footer_links')
</body>

</html>