{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

@foreach ($blogs as $blog)
    <url>
        <loc>{{ url('/blog/'.$blog->slug) }}</loc>
        <lastmod>{{ date('Y-m-d', strtotime($blog->created_at)) }}</lastmod>
    </url>
    @endforeach

@foreach ($categories as $category)
    <url>
        <loc>{{ url('/'.$category->url) }}</loc>
        <lastmod>{{ date('Y-m-d', strtotime($category->created_at)) }}</lastmod>
    </url>
    @endforeach
    
    @foreach ($sub_categories as $sub_category)
    <url>
        <loc>{{ url('/'.$sub_category->category_url.'/'.$sub_category->sub_cat_url) }}</loc>
        <lastmod>{{ date('Y-m-d', strtotime($sub_category->created_at)) }}</lastmod>
    </url>
    @endforeach

    @foreach ($products as $product)
    <url>
        <loc>{{ url('/product/'.$product->slug) }}</loc>
        <lastmod>{{ date('Y-m-d', strtotime($product->created_at)) }}</lastmod>
    </url>
    @endforeach

    @foreach ($products as $product)
    <url>
        <loc>{{ url('/product/'.$product->slug.'/reviews') }}</loc>
        <lastmod>{{ date('Y-m-d', strtotime($product->created_at)) }}</lastmod>
    </url>
    @endforeach

    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </url>

    <url>
        <loc>{{ url('/products') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </url>

    <url>
        <loc>{{ url('/quick-selling') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </url>

    <url>
        <loc>{{ url('/high-rated') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </url>

    <url>
        <loc>{{ url('/categories') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </url>

</urlset>
