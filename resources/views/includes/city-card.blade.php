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
    text-align: center !important;
    color: #4a5568;
    font-size: 0.9rem;
    margin-top: 0.5rem;
  }

  .city-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
    margin-top: 1.8rem;
  }

  @media (min-width: 1024px) {
    .city-grid {
      grid-template-columns: repeat(6, 1fr);
      gap: 1rem;
    }
  }

  .city-card {
    background: #fff;
    border-radius: 1.2rem;
    overflow: hidden;
    border: 1px solid #e9edf2;
    cursor: pointer;
    transition: 0.3s;
  }

  .city-card:hover {
    transform: translateY(-4px);
  }

  .city-card-media {
    height: 110px;
    background-size: cover;
    background-position: center;
  }

  .city-card-content {
    padding: 0.7rem;
  }

  .city-name {
    font-size: 0.95rem;
    font-weight: 700;
    text-align: center;
    color: #0f172a;
  }

  @media (max-width: 640px) {
    .city-name {
      font-size: 0.85rem;
    }
  }
</style>

<section class="container my-5">
  <div class="mb-4 section-title" align="center">
    <h2>Top Cities</h2>
    <p align="center">Find The Best Services in Your City</p>
  </div>

  <div class="city-grid">

    @foreach ($cities as $city)
    <a href="/city/{{ $city->slug }}">
      <div class="city-card">
        <div class="city-card-media" style="background-image: url('{{ $city->img }}');"></div>
        <div class="city-card-content">
          <div class="city-name">{{ $city->name }}</div>
        </div>
      </div>
    </a>
    @endforeach

  </div>
</section>