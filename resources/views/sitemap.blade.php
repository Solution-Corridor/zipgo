<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

@foreach ($services as $service)
<url>
    <loc>{{ url('service/' . $service->slug) }}</loc>
    <lastmod>{{ \Carbon\Carbon::parse($service->date)->toAtomString() }}</lastmod>
    <priority>0.80</priority>
</url>
@endforeach

@foreach ($products as $product)
<url>
    <loc>{{ url('product/' . $product->slug) }}</loc>
    <lastmod>{{ \Carbon\Carbon::parse($product->updated_at)->toAtomString() }}</lastmod>
    <priority>0.80</priority>
</url>
@endforeach

@foreach ($blogs as $blog)
<url>
    <loc>{{ url('blog/' . $blog->slug) }}</loc>
    <lastmod>{{ \Carbon\Carbon::parse($blog->date)->toAtomString() }}</lastmod>
    <priority>0.80</priority>
</url>
@endforeach

<!-- static pages  -->

<!-- Static Pages -->
<url>
    <loc>{{ url('/') }}</loc>
    <lastmod>{{ \Carbon\Carbon::now()->toAtomString() }}</lastmod>
    <priority>1.00</priority>
</url>
<url>
    <loc>{{ url('/about') }}</loc>
    <lastmod>{{ \Carbon\Carbon::now()->toAtomString() }}</lastmod>
    <priority>0.80</priority>
</url>
<url>
    <loc>{{ url('/service') }}</loc>
    <lastmod>{{ \Carbon\Carbon::now()->toAtomString() }}</lastmod>
    <priority>0.80</priority>
</url>
<url>
    <loc>{{ url('/products') }}</loc>
    <lastmod>{{ \Carbon\Carbon::now()->toAtomString() }}</lastmod>
    <priority>0.80</priority>
</url>
<url>
    <loc>{{ url('/blog') }}</loc>
    <lastmod>{{ \Carbon\Carbon::now()->toAtomString() }}</lastmod>
    <priority>0.80</priority>
</url>
<url>
    <loc>{{ url('/contact') }}</loc>
    <lastmod>{{ \Carbon\Carbon::now()->toAtomString() }}</lastmod>
    <priority>0.60</priority>
</url>

</urlset>
