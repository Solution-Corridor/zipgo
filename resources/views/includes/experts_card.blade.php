<div class="d-flex justify-content-center align-items-center">
  <div class="product-card-sm p-2" style="margin-bottom: 15px;">
    <div class="product-image-sm" style="text-align: center; object-fit: contain;">
      <a href="">
        <img src="/uploads/{{ $expert->selfie_image }}"
          onerror="this.onerror=null; this.src='/assets/images/favicon.png';"
          alt="{{ $expert->user->name ?? 'Expert' }}"
          title="{{ $expert->user->name ?? 'Expert' }}">
      </a>
    </div>

    <div class="product-content-sm">
      <h3 class="title-sm">
        <a href="">
          {{ Str::limit($expert->user->name ?? 'Unknown', 32) }}
        </a>
      </h3>
    </div>
  </div>
</div>