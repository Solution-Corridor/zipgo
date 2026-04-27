@php
$cities = App\Models\City::where('is_active', 1)
->whereIn('slug', [
'karachi',
'lahore',
'faisalabad',
'rawalpindi',
'gujranwala',
'peshawar'
])
->get();
@endphp

<style>
  .section-title p {
    text-align: center;
  }

  .section-title p {
    color: #4a5568;
    font-size: 0.9rem;
    margin-top: 0.5rem;
  }

  /* GRID: Desktop 6 cards in one row, Mobile 2 cards per row (3 rows) */
  .city-grid {
    display: grid;
    gap: 1.25rem;
    margin-top: 1.8rem;
  }

  /* default mobile: 2 columns */
  .city-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  /* tablet+ desktop: 6 columns */
  @media (min-width: 1024px) {
    .city-grid {
      grid-template-columns: repeat(6, 1fr);
      gap: 1rem;
    }
  }

  /* small mobile fine-tune */
  @media (max-width: 640px) {
    .city-grid {
      gap: 1rem;
    }
  }

  /* small card design */
  .city-card {
    background: #ffffff;
    border-radius: 1.2rem;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
    transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
    border: 1px solid #e9edf2;
    cursor: pointer;
  }

  .city-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 30px -12px rgba(0, 0, 0, 0.15);
    border-color: #cbd5e6;
  }

  /* image area with actual photography */
  .city-card-media {
    height: 120px;
    position: relative;
    background-size: cover;
    background-position: center 50%;
    display: flex;
    align-items: flex-end;
    justify-content: flex-start;
    padding: 0.6rem;
    transition: transform 0.2s ease;
  }

  .city-card:hover .city-card-media {
    transform: scale(1.02);
  }

  /* card content compact */
  .city-card-content {
    padding: 0.8rem 0.85rem 1rem 0.85rem;
  }

  .city-name {
    font-size: 1rem;
    font-weight: 700;
    text-align: center;
    color: #0f172a;
    margin-bottom: 0.1rem;
  }

  /* responsive text adjustments */
  @media (max-width: 640px) {
    .city-card-content {
      padding: 0.7rem;
    }

    .city-name {
      font-size: 0.9rem;
    }
  }
</style>
<!-- CITIES -->
<section class="container my-5">
  <div class="mb-4 section-title" align="center">
    <h2 class="fs-4">Top Cities</h2>
    <p>Find The Best Services in Your City</p>
  </div>
  <div class="city-grid">
    @foreach ($cities as $city)
    <a href="{{ $city->slug }}">
      <div class="city-card">
        <div class="city-card-media" style="background-image: url('{{ $city->pic }}');">
        </div>
        <div class="city-card-content">
          <div class="city-name">{{ $city->name }}</div>
        </div>
      </div>
    </a>
    @endforeach
  </div>
</section>