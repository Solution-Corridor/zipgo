<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $expert->full_name }} - Expert Profile | ZipGo</title>
  <meta name="description" content="Profile of {{ $expert->full_name }}, a verified ZipGo expert. View experience, specialties, service rates, and contact information. Book appointments with confidence.">
  @include('includes.header_links')
  <style>
    /* Expert Detail Page Styles */
    .expert-profile {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1rem;
    }

    .profile-card {
      background: white;
      border-radius: 32px;
      overflow: hidden;
      box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
      border: 1px solid #eef2f6;
    }

    .profile-header {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      padding: 2rem;
      background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
      border-bottom: 1px solid #eef2f6;
    }

    .profile-image {
      flex-shrink: 0;
    }

    .profile-image img {
      width: 180px;
      height: 180px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid white;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .profile-info {
      flex: 1;
    }

    .expert-name {
      font-size: 2rem;
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 0.5rem;
    }

    .expert-badge {
      display: inline-block;
      background: #eef2ff;
      color: #2563eb;
      padding: 0.25rem 1rem;
      border-radius: 40px;
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .expert-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin: 1rem 0;
    }

    .meta-item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      background: #f1f5f9;
      padding: 0.3rem 0.8rem;
      border-radius: 40px;
      font-size: 0.85rem;
      color: #1e293b;
    }

    .meta-item i {
      color: #3b82f6;
    }

    .rating-large {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1.2rem;
      color: #f59e0b;
    }

    .rating-large span {
      color: #334155;
      font-weight: 600;
      margin-left: 0.25rem;
    }

    .contact-buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-top: 1.5rem;
    }

    .btn-contact {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 0.6rem 1.2rem;
      border-radius: 50px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s;
    }

    .btn-call {
      background: #10b981;
      color: white;
    }

    .btn-whatsapp {
      background: #25D366;
      color: white;
    }

    .btn-message {
      background: #3b82f6;
      color: white;
    }

    .btn-contact:hover {
      transform: translateY(-2px);
      filter: brightness(0.95);
    }

    .profile-details {
      padding: 2rem;
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 2rem;
    }

    .detail-section {
      margin-bottom: 2rem;
    }

    .detail-section h3 {
      font-size: 1.3rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: #0f172a;
    }

    .detail-section p {
      line-height: 1.6;
      color: #334155;
    }

    /* Service Rate Card Styles */
    .service-rates-grid {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      margin-top: 1rem;
    }

    .rate-card {
      background: #ffffff;
      border: 1px solid #eef2f6;
      border-radius: 20px;
      padding: 1rem;
      display: flex;
      gap: 1rem;
      transition: all 0.2s ease;
      box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .rate-card:hover {
      border-color: #cbd5e1;
      box-shadow: 0 6px 14px rgba(0,0,0,0.05);
    }

    .rate-image {
      width: 80px;
      height: 80px;
      flex-shrink: 0;
      border-radius: 16px;
      overflow: hidden;
      background: #f1f5f9;
    }

    .rate-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .rate-details {
      flex: 1;
    }

    .rate-title {
      font-weight: 800;
      font-size: 1.1rem;
      color: #0f172a;
      display: flex;
      flex-wrap: wrap;
      align-items: baseline;
      gap: 0.75rem;
      margin-bottom: 0.3rem;
    }

    .rate-price {
      background: #dbeafe;
      color: #1e40af;
      padding: 0.2rem 0.7rem;
      border-radius: 40px;
      font-size: 0.8rem;
      font-weight: 700;
    }

    .rate-desc {
      font-size: 0.85rem;
      color: #475569;
      line-height: 1.4;
      margin-top: 0.3rem;
    }

    .info-list {
      list-style: none;
      padding: 0;
    }

    .info-list li {
      display: flex;
      justify-content: space-between;
      padding: 0.75rem 0;
      border-bottom: 1px solid #eef2f6;
    }

    .info-list li strong {
      color: #0f172a;
    }

    .sidebar-card {
      background: #f8fafc;
      border-radius: 24px;
      padding: 1.5rem;
      border: 1px solid #eef2f6;
      margin-bottom: 1.5rem;
    }

    .sidebar-card h4 {
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    .service-list {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }

    .service-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-size: 0.9rem;
    }

    .service-item i {
      width: 24px;
      color: #3b82f6;
    }

    .back-link {
      display: inline-block;
      margin-top: 2rem;
      color: #4f46e5;
      text-decoration: none;
    }

    @media (max-width: 768px) {
      .profile-header {
        flex-direction: column;
        text-align: center;
      }

      .profile-image img {
        width: 140px;
        height: 140px;
      }

      .contact-buttons {
        justify-content: center;
      }

      .profile-details {
        grid-template-columns: 1fr;
      }

      .expert-name {
        font-size: 1.5rem;
      }

      .rate-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .rate-image {
        width: 100px;
        height: 100px;
      }
    }
  </style>
</head>

<body>
  @include('includes.navbar')

  <div class="expert-profile mt-5">
    <div class="profile-card">
      <!-- Header -->
      <div class="profile-header">
        <div class="profile-image">
          <img src="/{{$expert['selfie_image']}}" alt="{{ $expert->full_name }}">
        </div>
        <div class="profile-info">
          <div class="expert-name">{{ $expert->full_name }}</div>
          <div class="expert-badge"><i class="fas fa-heartbeat"></i> {{ $expert['service']['name'] ?? 'Service' }}</div>
          <div class="expert-meta">
            <!-- <div class="meta-item"><i class="fas fa-calendar-alt"></i> 12 years experience</div> -->
            <div class="meta-item"><i class="fas fa-map-marker-alt"></i> {{ $expert['user']['city']['name'] ?? 'Unknown' }}</div>
            <div class="rating-large">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
              <span>4.8 (124 reviews)</span>
            </div>
          </div>
          <div class="contact-buttons">
            <a href="tel:{{ $expert['user']['phone'] }}" class="btn-contact btn-call"><i class="fas fa-phone-alt"></i> Call Now</a>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $expert['user']['whatsapp']) }}" class="btn-contact btn-whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a>            
          </div>
        </div>
      </div>

      <!-- Details -->
      <div class="profile-details">
        <div class="left-column">
          <div class="detail-section">
            <h3><i class="fas fa-user-circle"></i> About {{ $expert->full_name }}</h3>
            <p>{{ $expert->bio ?? 'No bio available.' }}</p>
          </div>

          <!-- NEW: Detailed Service Rates Section with Images -->
          <div class="detail-section">
            <h3><i class="fas fa-hand-holding-usd"></i> Service Rates & Packages</h3>
            <div class="service-rates-grid">
              @foreach($expert->rates as $rate)              
              
              <div class="rate-card">
                <div class="rate-image">
                  <img src="/uploads/expert-rates/{{ $rate->image }}" alt="{{ $rate->name }}">
                </div>
                <div class="rate-details">
                  <div class="rate-title">
                    {{ $rate->name }}
                    <span class="rate-price">Rs. {{ number_format($rate->rate, 0) }}</span>
                  </div>
                  <div class="rate-desc">
                    {{ $rate->description ?? 'No description available.' }}
                  </div>
                </div>
              </div>
               @endforeach


            </div>
          </div>

          <div class="detail-section">
            <h3><i class="fas fa-star"></i> Customer Reviews</h3>
            <div style="margin-bottom: 1rem;">
              <div style="display: flex; gap: 0.5rem; align-items: center;">
                <i class="fas fa-star" style="color:#f59e0b;"></i><i class="fas fa-star" style="color:#f59e0b;"></i><i class="fas fa-star" style="color:#f59e0b;"></i><i class="fas fa-star" style="color:#f59e0b;"></i><i class="fas fa-star" style="color:#f59e0b;"></i>
                <span>“Excellent service! Highly recommend.”</span>
              </div>
              <small style="color:#6c757d;">– Maria Khan, 2 weeks ago</small>
            </div>
            <div>
              <div style="display: flex; gap: 0.5rem; align-items: center;">
                <i class="fas fa-star" style="color:#f59e0b;"></i><i class="fas fa-star" style="color:#f59e0b;"></i><i class="fas fa-star" style="color:#f59e0b;"></i><i class="fas fa-star" style="color:#f59e0b;"></i><i class="far fa-star"></i>
                <span>“Very professional and on time.”</span>
              </div>
              <small style="color:#6c757d;">– Ali Raza, 1 month ago</small>
            </div>
          </div>
        </div>

        <!-- Right Sidebar (unchanged but kept consistent) -->
        <div class="right-column">
          <div class="sidebar-card">
            <h4><i class="fas fa-id-card"></i> Verification & Info</h4>
            <ul class="info-list">
              <li><strong>NIC Verified:</strong> ✅ Yes</li>
              <li><strong>Profile Status:</strong> Active</li>
              <li><strong>Member Since:</strong> {{ $expert->created_at->format('F Y') }}</li>
              <li><strong>Response Rate:</strong> 98%</li>
            </ul>
          </div>         
          
        </div>
      </div>
    </div>
  </div>

  @include('includes.footer')
  @include('includes.footer_links')
</body>

</html>