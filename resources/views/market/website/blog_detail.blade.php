<!DOCTYPE html>
<html lang="en">
<head>
    @include('market.website.includes.header_links')
    <title>{{ $blog->title }} - Feature Desk</title>
    <meta name="description" content="{{ $blog->short_description ?? '' }}">
    <meta name="keywords" content="{{ $blog->keywords ?? '' }}">
    <!-- Optional: Add schema if available -->
    @if(!empty($blog->page_schema))
        {!! $blog->page_schema !!}
    @endif
</head>
<body>

    <!-- Navbar -->
    @include('market.website.includes.navbar')

    {{-- ====================== BREADCRUMBS + PAGE TITLE ====================== --}}
    <section class="bg-light border-bottom" style="margin-top:70px; padding: 15px 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}" class="text-decoration-none text-muted">
                                    <i class="fas fa-home me-1"></i> Home
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('blogs') }}" class="text-decoration-none text-muted">
                                    <i class="fas fa-blog me-1"></i> Blogs
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-success" aria-current="page">
                                {{ Str::limit($blog->title, 60) }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="mt-3">
                <h1 class="h3 mb-0 fw-bold text-dark">{{ $blog->title }}</h1>
                <p class="text-muted mt-2 mb-0">
                    {{ $blog->short_description ?? 'Be part of the world’s fastest growing e-commerce platform.' }}
                </p>
            </div>
        </div>
    </section>
    {{-- ====================== END BREADCRUMBS ====================== --}}

    <!-- Blog Content -->
    <div class="container-fluid py-6">
        <div class="container py-5">
            <div class="row g-4">

                <!-- ==================== MAIN CONTENT ==================== -->
                <div class="col-lg-8">

                    <div class="mb-5">
                        <!-- Feature Image -->
                        <img class="img-fluid w-100 mb-5 rounded" 
                             src="{{ asset('uploads/market/blogs/' . $blog->picture) }}" 
                             alt="{{ $blog->title }}"
                             title="{{ $blog->title }}"
                             onerror="this.onerror=null; this.src='/assets/images/logo.png';"
                             style="object-fit: cover;">
                        
                        <!-- Blog Body -->
                        <div class="blog-content lead">
                            {!! $blog->detail !!}
                        </div>
                    </div>

                    <!-- ==================== COMMENTS SECTION ==================== -->
                    <div class="mt-5" id="comments">
                        <h3 class="mb-4 border-bottom pb-3">
                            Comments 
                            <span class="badge bg-secondary">{{ $comments->count() }}</span>
                        </h3>

                        @if($comments->isEmpty())
                            <p class="text-muted">No comments yet. Be the first to share your thoughts!</p>
                        @else
                            @foreach($comments as $comment)
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $comment->name }}</strong>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                            </small>
                                        </div>
                                        <p class="mt-2 mb-0">{{ $comment->comment }}</p>
                                        
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Add Comment Form -->
                        @if($blog->is_commentable == 1)
                            <div class="mt-5">
                                <h4 class="mb-3">Leave a Comment</h4>
                                <form action="{{ route('blog.comment.store') }}" method="POST">
    @csrf
    <input type="hidden" name="blog_id" value="{{ $blog->blog_id }}">

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Your Name <span class="text-danger">*</span></label>
            <input 
                type="text" 
                name="name" 
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Enter your full name"
                value="{{ old('name') }}" 
                required
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input 
                type="email" 
                name="email" 
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Enter your email address"
                value="{{ old('email') }}" 
                required
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Phone <span class="text-danger">*</span></label>
            <input 
                type="text" 
                name="phone" 
                class="form-control"
                placeholder="Enter your phone number"
                value="{{ old('phone') }}" 
                required
            >
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Your Comment <span class="text-danger">*</span></label>
        <textarea 
            name="comment" 
            rows="5" 
            class="form-control @error('comment') is-invalid @enderror"
            placeholder="Write your comment here..."
            required
        >{{ old('comment') }}</textarea>
        @error('comment')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Post Comment</button>
</form>
                            </div>
                        @else
                            <div class="alert alert-info mt-4">
                                Comments are disabled for this blog post.
                            </div>
                        @endif
                    </div>

                </div>

                <!-- ==================== SIDEBAR ==================== -->
                <div class="col-lg-4">

                    <!-- Recent Posts -->
                    <div class="mb-5">
                        <h3 class="mb-4">Recent Posts</h3>
                        <div class="list-group">

                            @foreach($recent_blogs as $recent)
                                <div class="list-group-item border-0 p-0 mb-3">
                                    <div class="d-flex">
                                        <img src="{{ asset('uploads/market/blogs/' . $recent->picture) }}" 
                                             class="me-3 rounded" 
                                             style="width: 70px; height: 70px; object-fit: cover;"
                                             alt="{{ $recent->title }}"
                                             title="{{ $recent->title }}"
                                             onerror="this.src='/assets/images/logo.png';">

                                        <div class="flex-fill">
                                            <a href="{{ url('/blog/' . $recent->slug) }}" 
                                               class="text-dark fw-medium text-decoration-none">
                                                {{ Str::limit($recent->title, 65) }}
                                            </a>
                                            <small class="text-muted d-block mt-1">
                                                {{ \Carbon\Carbon::parse($recent->created_at)->format('d M Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if($recent_blogs->isEmpty())
                                <p class="text-muted">No recent posts available.</p>
                            @endif
                        </div>
                    </div>

                    <!-- You can add more widgets here later (e.g., Categories, Popular Posts, Newsletter) -->

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('market.website.includes.footer')
    @include('market.website.includes.footer_links')

</body>
</html>