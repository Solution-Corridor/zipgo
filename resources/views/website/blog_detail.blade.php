<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $blog->title }} | ZipGo Blog</title>
  <meta name="description" content="{{ $blog->short_description }}">
  <meta name="keywords" content="{{ $blog->keywords }}">
  @if($blog->page_schema)
  {!! $blog->page_schema !!}
  @endif
  @include('includes.header_links')
  <style>
    body {
      background: #f5f7fb;
      font-family: 'Segoe UI', system-ui, sans-serif;
    }

    .blog-detail-container {
      max-width: 1380px;
      margin: 2rem auto;
      padding: 0 1.5rem;
      display: grid;
      grid-template-columns: 1fr 320px;
      gap: 2rem;
    }

    /* Left Column – Blog Post */
    .blog-post {
      /* background: white; */
      /* border-radius: 24px; */
      padding: 2rem;
      /* box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); */
    }

    .blog-header h1 {
      font-size: 2rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 0.5rem;
    }

    .blog-date {
      color: #6b7280;
      font-size: 0.85rem;
      margin-bottom: 1.5rem;
    }

    .blog-featured-img {
      width: 100%;
      max-height: 400px;
      object-fit: cover;
      border-radius: 16px;
      margin: 1rem 0 1.5rem;
    }

    .blog-body {
      font-size: 1.05rem;
      line-height: 1.7;
      color: #1f2937;
    }

    .blog-body img {
      max-width: 100%;
      height: auto;
      border-radius: 12px;
      margin: 1.5rem 0;
    }

    .blog-body h2,
    .blog-body h3 {
      margin-top: 1.8rem;
      margin-bottom: 1rem;
    }

    /* Right Sidebar */
    .sidebar {
      position: sticky;
      top: 80px;
      align-self: start;
    }

    .recent-blogs-card {
      background: white;
      border-radius: 20px;
      padding: 1.5rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .recent-blogs-card h3 {
      font-size: 1.3rem;
      font-weight: 600;
      margin-bottom: 1.2rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid #eef2f6;
    }

    .recent-blog-item {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.2rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #f0f0f0;
    }

    .recent-blog-item:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }

    .recent-blog-img {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 12px;
      flex-shrink: 0;
    }

    .recent-blog-info {
      flex: 1;
    }

    .recent-blog-title {
      font-weight: 600;
      font-size: 0.9rem;
      color: #111827;
      text-decoration: none;
      line-height: 1.3;
    }

    .recent-blog-title:hover {
      color: #4f46e5;
      text-decoration: underline;
    }

    .recent-blog-date {
      font-size: 0.7rem;
      color: #9ca3af;
      margin-top: 4px;
    }

    .comments-section {
      margin-top: 2rem;
      padding-top: 1.5rem;
      border-top: 1px solid #e5e7eb;
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
      border: none;
      cursor: pointer;
    }

    .btn-read:hover {
      background: #4338ca;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .blog-detail-container {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }

      .sidebar {
        position: static;
      }
    }

    @media (max-width: 640px) {
      .blog-post {
        padding: 1.2rem;
      }

      .blog-header h1 {
        font-size: 1.6rem;
      }
    }
  </style>
</head>

<body>
  @include('includes.navbar')

  <div class="blog-detail-container">
    <!-- LEFT COLUMN: Blog Post -->
    <div class="blog-post mt-5">
      <div class="blog-header">
        <h1>{{ $blog->title }}</h1>
        <div class="blog-date">
          📅 Published on {{ $blog->created_at->format('F d, Y') }}
        </div>
      </div>

      @if($blog->picture)
      <img src="{{ asset('uploads/'.$blog->picture) }}" class="blog-featured-img" alt="{{ $blog->title }}">
      @endif

      <div class="blog-body">
        {!! $blog->detail !!}
      </div>

      @if($blog->is_commentable)
      <div class="comments-section">
        <h3>💬 Leave a Comment</h3>
        <p class="text-muted">We'd love to hear your thoughts.</p>
        <form action="#" method="POST">
          <textarea rows="4" style="width: 100%; padding: 0.75rem; border-radius: 12px; border: 1px solid #ddd; margin-bottom: 1rem;" placeholder="Write your comment..."></textarea>
          <button type="submit" class="btn-read">Post Comment</button>
        </form>
      </div>
      @endif

    </div>

    <!-- RIGHT COLUMN: Recent Blogs Sidebar -->
    <aside class="sidebar">
      <div class="recent-blogs-card">
        <h3>Recent Posts</h3>
        @if(isset($recentBlogs) && $recentBlogs->count())
        @foreach($recentBlogs as $recent)
        <div class="recent-blog-item">
          @if($recent->picture)
          <img src="{{ asset('uploads/'.$recent->picture) }}" class="recent-blog-img" alt="{{ $recent->title }}">
          @else
          <div class="recent-blog-img" style="background: #eef2f6; display: flex; align-items: center; justify-content: center;">📄</div>
          @endif
          <div class="recent-blog-info">
            <a href="/blog/{{ $recent->slug }}" class="recent-blog-title">{{ $recent->title }}</a>
            <div class="recent-blog-date">{{ $recent->created_at->format('M d, Y') }}</div>
          </div>
        </div>
        @endforeach
        @else
        <p class="text-muted">No other posts yet.</p>
        @endif
      </div>
    </aside>
  </div>

  @include('includes.footer')
  @include('includes.footer_links')
</body>

</html>