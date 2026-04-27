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

    <!-- Karachi -->
    <a href="/city/karachi">
      <div class="city-card">
        <div class="city-card-media" style="background-image:url('https://images.unsplash.com/photo-1580651315530-69c8e0026377');"></div>
        <div class="city-card-content">
          <div class="city-name">Karachi</div>
        </div>
      </div>
    </a>

    <!-- Lahore -->
    <a href="/city/lahore">
      <div class="city-card">
        <div class="city-card-media" style="background-image:url('https://images.unsplash.com/photo-1580130732478-4e339fb6836f');"></div>
        <div class="city-card-content">
          <div class="city-name">Lahore</div>
        </div>
      </div>
    </a>

    <!-- Faisalabad -->
    <a href="/city/faisalabad">
      <div class="city-card">
        <div class="city-card-media" style="background-image:url('https://images.unsplash.com/photo-1593642634367-d91a135587b5');"></div>
        <div class="city-card-content">
          <div class="city-name">Faisalabad</div>
        </div>
      </div>
    </a>

    <!-- Rawalpindi -->
    <a href="/city/rawalpindi">
      <div class="city-card">
        <div class="city-card-media" style="background-image:url('https://images.unsplash.com/photo-1564501049412-61c2a3083791');"></div>
        <div class="city-card-content">
          <div class="city-name">Rawalpindi</div>
        </div>
      </div>
    </a>

    <!-- Gujranwala -->
    <a href="/city/gujranwala">
      <div class="city-card">
        <div class="city-card-media" style="background-image:url('https://images.unsplash.com/photo-1505761671935-60b3a7427bad');"></div>
        <div class="city-card-content">
          <div class="city-name">Gujranwala</div>
        </div>
      </div>
    </a>

    <!-- Peshawar -->
    <a href="/city/peshawar">
      <div class="city-card">
        <div class="city-card-media" style="background-image:url('https://images.unsplash.com/photo-1578926375605-eaf7559b1458');"></div>
        <div class="city-card-content">
          <div class="city-name">Peshawar</div>
        </div>
      </div>
    </a>

  </div>
</section>