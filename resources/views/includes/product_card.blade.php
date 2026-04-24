<div class="product-card">
  <div class="product-image">
    <a href="/product/{{ $p->slug }}">
      <img src="/uploads/market/products/{{ $p->pic }}" 
           onerror="this.onerror=null; this.src='/assets/images/main.jpg';" 
           alt="{{ $p->name }}" 
           title="{{ $p->name }}">
    </a>
  </div>

  <div class="product-content">
    <div class="badges">
      @if ($p->category_name)
        <span class="badge badge-category">{{ $p->category_name }}</span>
      @endif
      @if ($p->sub_category_name)
        <span class="badge badge-subcategory">{{ $p->sub_category_name }}</span>
      @endif
    </div>
    <h3><a href="/product/{{ $p->slug }}" class="product-title">{{ $p->name }}</a></h3>
    <p class="product-price">Rs. {{ number_format($p->price) }}</p>
    <a href="{{ route('market.buynow', $p->product_id) }}" class="btn-buy">Buy Now</a>
    <a href="{{ route('market.addtocart', $p->product_id) }}" class="btn-cart">Add to Cart</a>
  </div>
</div>