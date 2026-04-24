<div class="col-lg-4 col-md-6 mb-4">
        <div class="product-card">
            <a href="/product/{{ $p->slug }}" class="product-image-link">
                <img src="/{{ $p->pic }}" alt="{{ $p->name }}" title="{{ $p->name }}" class="product-image" onerror="this.src='/assets/images/favicon.png';">
            </a>
            <div class="product-content">
                <h3 class="product-title">
                    <a href="/product/{{ $p->slug }}">{{ Str::limit($p->name, 30) }}</a>
                </h3>
                <a href="https://wa.me/+923467454565?text=Can%20I%20get%20more%20details%20on%20this%20*{{ urlencode($p->name) }}*%0A%0AClick%20the%20link%20to%20view%3A%20{{ urlencode(url('/product/' . $p->slug)) }}" class="btn-buy-now">Buy Now</a>                
            </div>
        </div>
    </div>