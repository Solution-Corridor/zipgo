@foreach ($blogs as $iblog)
    <div class="col-lg-4 col-md-6">
        <div class="blog-card">
            <!-- Blog Image -->
            <div class="blog-imgm" style="height: 200px; overflow: hidden;">
                <a href="{{ url('/blog/' . $iblog->slug) }}">
                    <img src="{{ asset('uploads/market/blogs/' . $iblog->picture) }}"
                         alt="{{ $iblog->title }}"
                         title="{{ $iblog->title }}"
                         style="width: 100%; height: 100%; object-fit: cover;"
                         onerror="this.onerror=null; this.src='/assets/images/logo.png';">
                </a>
            </div>

            <!-- Blog Content -->
            <div class="content">
                <h3>
                    <a href="{{ url('/blog/' . $iblog->slug) }}">
                        {{ $iblog->title }}
                    </a>
                </h3>

                <p>
                    {!! strlen(strip_tags($iblog->detail ?? '')) > 127 
                        ? substr(strip_tags($iblog->detail), 0, 127) . '...' 
                        : strip_tags($iblog->detail ?? '') !!}
                </p>

                <a href="{{ url('/blog/' . $iblog->slug) }}" class="read-btn">
                    Read More <i class="bx bx-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
@endforeach