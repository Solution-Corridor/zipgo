{{-- resources/views/includes/expert-cards.blade.php --}}
<style>
  .expert-section {
    padding: 2rem 1rem;
    max-width: 1400px;
    margin: 0 auto;
  }

  .section-title {
    text-align: center;
    font-size: 1.8rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 2rem;
  }

  .experts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.5rem;
  }

  .expert-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #eef2f6;
    transition: 0.3s;
  }

  .expert-card:hover {
    transform: translateY(-5px);
  }

  .expert-img-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
  }

  .expert-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .service-badge {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background: rgba(0,0,0,0.7);
    color: #fff;
    font-size: 0.7rem;
    padding: 3px 8px;
    border-radius: 20px;
  }

  .expert-info {
    padding: 1rem;
  }

  .expert-name {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 4px;
  }

  .meta-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.8rem;
    margin: 4px 0;
  }

  .rating {
    color: #f59e0b;
  }

  .experience {
    background: #f1f5f9;
    padding: 2px 6px;
    border-radius: 20px;
    font-size: 0.7rem;
  }

  .location {
    font-size: 0.75rem;
    margin-bottom: 8px;
    color: #475569;
  }

  .button-group {
    display: flex;
    gap: 6px;
  }

  .btn {
    flex: 1;
    text-align: center;
    padding: 6px 0;
    border-radius: 30px;
    font-size: 0.75rem;
    text-decoration: none;
    color: #fff;
  }

  .btn-call { background: #10b981; }
  .btn-whatsapp { background: #25D366; }
  .btn-profile { background: #1e293b; }

  /* MOBILE FIX */
  @media (max-width: 768px) {
    .experts-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 0.7rem;
    }

    .expert-card {
      border-radius: 12px;
    }

    .expert-img-wrapper {
      aspect-ratio: 1 / 0.75; /* shorter image */
    }

    .expert-info {
      padding: 0.6rem;
    }

    .expert-name {
      font-size: 0.9rem;
      line-height: 1.2;
    }

    .meta-row {
      flex-direction: row;
      font-size: 0.7rem;
      margin: 2px 0;
    }

    .location {
      font-size: 0.65rem;
      margin-bottom: 5px;
    }

    .expert-info > * {
      margin-bottom: 3px;
    }

    .btn {
      padding: 4px 0;
      font-size: 0.65rem;
    }
  }

  @media (max-width: 480px) {
    .expert-section {
      padding: 1rem;
    }

    .expert-name {
      font-size: 0.8rem;
    }

    .btn span {
      display: none;
    }

    .btn i {
      font-size: 0.9rem;
    }

    .rating span {
      display: none;
    }
  }
</style>

<section class="expert-section">
  <h2 class="section-title">Meet Our Experts</h2>

  <div class="experts-grid">

    <!-- Card 1 -->
    <div class="expert-card">
      <div class="expert-img-wrapper">
        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="expert-img">
        <span class="service-badge"><i class="fas fa-heartbeat"></i> Cardiologist</span>
      </div>
      <div class="expert-info">
        <div class="expert-name">Dr. Ahmed Raza</div>
        <div class="meta-row">
          <div class="rating"><i class="fas fa-star"></i> 4.8</div>
          <div class="experience">12 yrs</div>
        </div>
        <div class="location"><i class="fas fa-map-marker-alt"></i> Lahore</div>
        <div class="button-group">
          <a href="#" class="btn btn-call"><i class="fas fa-phone"></i> <span>Call</span></a>
          <a href="#" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> <span>WhatsApp</span></a>
          <a href="/expert/1" class="btn btn-profile"><i class="fas fa-user"></i> <span>Profile</span></a>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="expert-card">
      <div class="expert-img-wrapper">
        <img src="https://randomuser.me/api/portraits/men/22.jpg" class="expert-img">
        <span class="service-badge"><i class="fas fa-wrench"></i> Plumber</span>
      </div>
      <div class="expert-info">
        <div class="expert-name">Muhammad Ali</div>
        <div class="meta-row">
          <div class="rating"><i class="fas fa-star"></i> 4.6</div>
          <div class="experience">8 yrs</div>
        </div>
        <div class="location"><i class="fas fa-map-marker-alt"></i> Karachi</div>
        <div class="button-group">
          <a href="#" class="btn btn-call"><i class="fas fa-phone"></i> <span>Call</span></a>
          <a href="#" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> <span>WhatsApp</span></a>
          <a href="/expert/2" class="btn btn-profile"><i class="fas fa-user"></i> <span>Profile</span></a>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="expert-card">
      <div class="expert-img-wrapper">
        <img src="https://randomuser.me/api/portraits/men/45.jpg" class="expert-img">
        <span class="service-badge"><i class="fas fa-wind"></i> AC Tech</span>
      </div>
      <div class="expert-info">
        <div class="expert-name">Usman Chaudhry</div>
        <div class="meta-row">
          <div class="rating"><i class="fas fa-star"></i> 4.5</div>
          <div class="experience">6 yrs</div>
        </div>
        <div class="location"><i class="fas fa-map-marker-alt"></i> Rawalpindi</div>
        <div class="button-group">
          <a href="#" class="btn btn-call"><i class="fas fa-phone"></i> <span>Call</span></a>
          <a href="#" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> <span>WhatsApp</span></a>
          <a href="/expert/3" class="btn btn-profile"><i class="fas fa-user"></i> <span>Profile</span></a>
        </div>
      </div>
    </div>

    <!-- Card 4 -->
    <div class="expert-card">
      <div class="expert-img-wrapper">
        <img src="https://randomuser.me/api/portraits/men/67.jpg" class="expert-img">
        <span class="service-badge"><i class="fas fa-bolt"></i> Electrician</span>
      </div>
      <div class="expert-info">
        <div class="expert-name">Bilal Farooq</div>
        <div class="meta-row">
          <div class="rating"><i class="fas fa-star"></i> 5.0</div>
          <div class="experience">10 yrs</div>
        </div>
        <div class="location"><i class="fas fa-map-marker-alt"></i> Islamabad</div>
        <div class="button-group">
          <a href="#" class="btn btn-call"><i class="fas fa-phone"></i> <span>Call</span></a>
          <a href="#" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> <span>WhatsApp</span></a>
          <a href="/expert/4" class="btn btn-profile"><i class="fas fa-user"></i> <span>Profile</span></a>
        </div>
      </div>
    </div>

  </div>
</section>