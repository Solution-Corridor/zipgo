<div class="expert-card">
  <div class="expert-img-wrapper">
    <img src="/{{$expert['selfie_image']}}" class="expert-img">

    <span class="service-badge">
      <i class="fas fa-briefcase"></i>
      {{ $expert['service']['name'] ?? 'Service' }}
    </span>
  </div>

  <div class="expert-info">
    <div class="expert-name">
      {{ $expert['full_name'] ?? 'N/A' }}
    </div>

    <div class="meta-row">
      <div class="rating">
        <i class="fas fa-star"></i> 4.8
      </div>
      <div class="experience">
        &nbsp;
      </div>
    </div>

    <div class="location">
      <i class="fas fa-map-marker-alt"></i>
      {{ $expert['user']['city']['name'] ?? 'Unknown' }}
    </div>

    <div class="button-group">
      <a href="tel:{{ $expert['user']['phone'] }}" class="btn btn-call">
        <i class="fas fa-phone"></i> <span>Call</span>
      </a>

      <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $expert['user']['whatsapp']) }}" target="_blank" class="btn btn-whatsapp">
        <i class="fab fa-whatsapp"></i> <span>WhatsApp</span>
      </a>

      <a href="{{ url('expert/'.$expert['id']) }}" class="btn btn-profile">
        <i class="fas fa-user"></i> <span>Profile</span>
      </a>
    </div>
  </div>
</div>