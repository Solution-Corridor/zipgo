<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog - Feature Desk</title>
  <meta name="description" content="Read latest articles, tips, and news from Feature Desk">
  @include('includes.header_links')
  <style>
    .blog-page {
      max-width: 1280px;
      margin: 0 auto;
      padding: 2rem 1.5rem;
    }

    .page-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .page-header h1 {
      font-size: 2rem;
      font-weight: 700;
      color: #1f2937;
    }

    .page-header p {
      color: #6b7280;
    }

    .blogs-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 1.8rem;
    }

    .blog-card {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      overflow: hidden;
      transition: transform 0.2s, box-shadow 0.2s;
      border: 1px solid #eef2f6;
    }

    .blog-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .blog-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .blog-content {
      padding: 1.2rem;
    }

    .blog-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: #111827;
      margin-bottom: 0.5rem;
    }

    .blog-excerpt {
      font-size: 0.9rem;
      color: #4b5563;
      line-height: 1.5;
      margin-bottom: 1rem;
    }

    .blog-meta {
      font-size: 0.75rem;
      color: #9ca3af;
      margin-bottom: 1rem;
    }

    .btn-read {
      display: inline-block;
      background: #4f46e5;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 40px;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.85rem;
      transition: background 0.2s;
    }

    .btn-read:hover {
      background: #4338ca;
    }

    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 2.5rem;
    }

    .empty-state {
      text-align: center;
      padding: 3rem;
      background: white;
      border-radius: 16px;
      color: #6c757d;
    }
  </style>
</head>

<body>
  @include('includes.navbar')

  <div class="blog-page mt-5">
    <div class="page-header">
      <h1>Our Blog</h1>
      <p>Insights, tips, and updates from Feature Desk</p>
    </div>

    @if($blogs->count())
    <div class="blogs-grid">
      @foreach($blogs as $blog)
      <div class="blog-card">
        @if($blog->picture)
        <img src="{{ asset('uploads/'.$blog->picture) }}" class="blog-img" alt="{{ $blog->title }}">
        @endif
        <div class="blog-content">
          <div class="blog-title">{{ $blog->title }}</div>
          <div class="blog-excerpt">
            {{ Str::limit($blog->short_description ?? strip_tags($blog->detail), 120) }}
          </div>
          <div class="blog-meta">
            📅 {{ $blog->created_at->format('M d, Y') }}
          </div>
          <a href="/blog/{{ $blog->slug }}" class="btn-read">Read More →</a>
        </div>
      </div>
      @endforeach
    </div>
    <div class="pagination">
      {{ $blogs->links() }}
    </div>
    @endif
  </div>

  @include('includes.footer')
  @include('includes.footer_links')
</body>

</html>