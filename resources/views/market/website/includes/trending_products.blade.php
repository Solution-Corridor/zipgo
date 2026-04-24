@php
$trending_products = DB::table('mk_products')
    ->limit(5)
    ->inRandomOrder()
    ->get();
@endphp

<section class="container-fluid my-4">
  <div class="products-grid-sm" style="margin-top: 80px;">
    @foreach ($trending_products as $tp)

    <div class="d-flex justify-content-center align-items-center">
      <div class="product-card-sm p-2" style="margin-bottom: 15px;">
        <div class="product-image-sm">
          <a href="/product/{{ $tp->slug }}">
            <img src="/uploads/market/products/{{ $tp->pic }}"
              onerror="this.onerror=null; this.src='/assets/images/main.jpg';"
              alt="{{ $tp->name }}"
              title="{{ $tp->name }}">
          </a>
        </div>

        <div class="product-content-sm">
          <h3 class="title-sm">
            <a href="/product/{{ $tp->slug }}">
              {{ Str::limit($tp->name, 32) }}
            </a>
          </h3>

          <div style="margin-bottom: -15px;">
            <p class="price-sm">
              <small>Rs.</small> {{ number_format($tp->price) }}
              &nbsp;<del class="del-sm">
                {{ isset($tp->cutting_price) ? number_format($tp->cutting_price) : '999' }}
              </del>
              &nbsp;<small class="soldout text-success" style="font-weight: 600;">
                {{ number_format($tp->stock_sold ?? 12) }} Sold
              </small>
            </p>
            <p class="actions-sm"><i class="fa-brands fa-opencart"></i></p>
          </div>

          <div style="clear: both;">
            @if (!is_null($tp->stock_left) && $tp->stock_left < 10)
              <div class="left-product">
              Only {{ number_format($tp->stock_left) }} Left
          </div><br>
          @elseif (is_null($tp->stock_left))
          <div class="left-product">
            Only 9 Left
          </div><br>
          @endif

          <div class="review-sm">
            @php
            $fullStars = floor($tp->product_ratting ?? 4); // full stars
            $halfStar = ($tp->product_ratting - $fullStars) >= 0.5 ? 1 : 0; // half star if needed
            $emptyStars = 5 - $fullStars - $halfStar; // remaining empty stars
            @endphp

            {{-- Full stars --}}
            @for ($i = 0; $i < $fullStars; $i++)
              <i class="fa-solid fa-star"></i>
              @endfor

              {{-- Half star if any --}}
              @if ($halfStar)
              <i class="fa-solid fa-star-half-stroke"></i>
              @endif

              {{-- Empty stars --}}
              @for ($i = 0; $i < $emptyStars; $i++)
                <i class="fa-regular fa-star"></i>
                @endfor

                {{-- Rating number and review count --}}
                <strong>{{ $tp->product_ratting }}</strong>
                <span class="text-muted">
                  <a href="/product/{{ $tp->slug }}/reviews">
                    ({{ $tp->ratting_count }} Reviews)
                  </a>
                </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  </div>
</section>