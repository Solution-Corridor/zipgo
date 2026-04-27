<!DOCTYPE html>
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
  <!-- Simple inline styles – you can replace with your own CSS -->
  <style>
    .header {
      padding: 1.5rem 2rem;
      border-bottom: 1px solid #e5e7eb;
      background: #f9fafb;
    }

    .header-content {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .header-img {
      width: 64px;
      height: 64px;
      border-radius: 9999px;
      object-fit: cover;
      background: #e5e7eb;
    }

    .city-bg {
      background-size: cover;
      background-position: center;
    }

    h1 {
      font-size: 1.875rem;
      font-weight: 700;
      margin-bottom: 0.25rem;
    }

    .subtitle {
      color: #6b7280;
    }

    .table-wrapper {
      overflow-x: auto;
      padding: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th {
      text-align: left;
      padding: 0.75rem 1.5rem;
      background-color: #f9fafb;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #4b5563;
      border-bottom: 1px solid #e5e7eb;
    }

    td {
      padding: 1rem 1.5rem;
      border-bottom: 1px solid #f0f0f0;
      vertical-align: top;
    }

    .expert-info {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .expert-avatar {
      width: 40px;
      height: 40px;
      border-radius: 9999px;
      background: #d1d5db;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      color: #4b5563;
      overflow: hidden;
    }

    .expert-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .expert-name {
      font-weight: 500;
      color: #111827;
    }

    .expert-bio {
      font-size: 0.875rem;
      color: #6b7280;
      max-width: 250px;
    }

    .rating {
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }

    .star {
      color: #fbbf24;
      font-weight: bold;
    }

    .btn-link {
      color: #4f46e5;
      text-decoration: none;
      font-weight: 500;
    }

    .btn-link:hover {
      color: #4338ca;
      text-decoration: underline;
    }

    .empty-state {
      text-align: center;
      padding: 3rem 2rem;
    }

    .empty-icon {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .back-link {
      display: inline-block;
      margin-top: 1rem;
      margin-left: 2rem;
      margin-bottom: 1rem;
      color: #4f46e5;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    footer {
      text-align: center;
      padding: 1rem;
      font-size: 0.75rem;
      color: #9ca3af;
      border-top: 1px solid #e5e7eb;
    }
  </style>
</head>

<body>
  <div class="container">
    @isset($service)
    {{-- Service Header --}}
    <div class="header">
      <div class="header-content">
        @if($service->pic)
        <img src="{{ $service->pic }}" alt="{{ $service->name }}" class="header-img">
        @else
        <div class="header-img" style="background: #e5e7eb; display: flex; align-items: center; justify-content: center;">📌</div>
        @endif
        <div>
          <h1>{{ $service->name }} Experts</h1>
          <p class="subtitle">Top professionals offering {{ $service->name }} services</p>
        </div>
      </div>
    </div>
    @php $experts = $service->experts ?? collect(); @endphp
    @endisset

    @isset($city)
    {{-- City Header --}}
    <div class="header">
      <div class="header-content">
        @if($city->pic)
        <div class="header-img city-bg" style="background-image: url('{{ $city->pic }}');"></div>
        @else
        <div class="header-img" style="background: #e5e7eb; display: flex; align-items: center; justify-content: center;">🏙️</div>
        @endif
        <div>
          <h1>Experts in {{ $city->name }}</h1>
          <p class="subtitle">Qualified professionals located in {{ $city->name }}</p>
        </div>
      </div>
    </div>
    @php $experts = $city->experts ?? collect(); @endphp
    @endisset

    <div class="table-wrapper">
      @if($experts && $experts->count() > 0)
      <table>
        <thead>
          <tr>
            <th>Expert</th>
            <th>Contact</th>
            <th>Experience</th>
            <th>Rating</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($experts as $expert)
          <tr>
            <td>
              <div class="expert-info">
                <div class="expert-avatar">
                  @if($expert->image)
                  <img src="{{ $expert->image }}" alt="{{ $expert->name }}">
                  @else
                  {{ strtoupper(substr($expert->name, 0, 1)) }}
                  @endif
                </div>
                <div>
                  <div class="expert-name">{{ $expert->name }}</div>
                  @if($expert->bio)
                  <div class="expert-bio">{{ Str::limit($expert->bio, 60) }}</div>
                  @endif
                </div>
              </div>
            </td>
            <td>
              <div>{{ $expert->email ?? '—' }}</div>
              <div class="expert-bio">{{ $expert->phone ?? '—' }}</div>
            </td>
            <td>
              {{ $expert->experience_years ?? 'N/A' }} years
            </td>
            <td>
              <div class="rating">
                <span>{{ number_format($expert->rating ?? 0, 1) }}</span>
                <span class="star">★</span>
              </div>
            </td>
            <td>
              <a href="/expert/{{ $expert->slug ?? $expert->id }}" class="btn-link">View Profile →</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <div class="empty-state">
        <div class="empty-icon">🔍</div>
        <h3 style="margin-bottom: 0.5rem;">No experts found</h3>
        <p style="color: #6b7280;">
          @isset($service)
          No professionals currently listed for {{ $service->name }}.
          @else
          No experts available in {{ $city->name }} at the moment.
          @endisset
        </p>
      </div>
      @endif
    </div>

    <div>
      <a href="javascript:history.back()" class="back-link">← Back</a>
    </div>

    <footer>
      &copy; {{ date('Y') }} Expert Directory. All rights reserved.
    </footer>
  </div>
</body>

</html>