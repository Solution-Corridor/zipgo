{{-- resources/views/admin/blogs/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
@section('title')
Manage Blogs
@endsection
@include('admin.includes.headlinks')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    @include('admin.includes.navbar')
    @include('admin.includes.sidebar')

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Manage Blogs</h1>
            </div>
            <div class="col-sm-6 text-right">
              <a href="{{ route('blogs.add') }}" class="btn btn-primary">+ Add New Blog</a>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header bg-light">All Blogs</div>
                <div class="card-body">
                  @include('admin.includes.success')

                  <table class="table table-bordered table-striped example1" id="example1">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Picture</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Commentable</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($blogs as $blog)
                      <tr>
                        <td>{{ $blog->blog_id }}</td>
                        <td>
                          @if($blog->picture)
                          <img src="{{ asset('uploads/'.$blog->picture) }}" width="60" height="60" style="object-fit: cover;">
                          @else
                          <img src="/assets/images/favicon.png" width="60">
                          @endif
                        </td>
                        <td><a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->title }}</a></td>
                        <td>{{ Str::limit($blog->slug, 50) }} </td>
                        <td>
                          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox"
                              class="custom-control-input toggle-blog-commentable"
                              id="blogSwitch{{ $blog->blog_id }}"
                              data-id="{{ $blog->blog_id }}"
                              {{ $blog->is_commentable ? 'checked' : '' }}>
                            <label class="custom-control-label" for="blogSwitch{{ $blog->blog_id }}"></label>
                          </div>
                        </td>
                        <td>
                          <a href="{{ route('blogs.edit', $blog->blog_id) }}" class="btn btn-sm btn-warning">Edit</a>
                          <form action="{{ route('blogs.destroy', $blog->blog_id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this blog?')">Delete</button>
                          </form>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="6" class="text-center">No blogs found.</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>

                  {{ $blogs->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    @include('admin.includes.version')
  </div>
  @include('admin.includes.footer_links')

  <script>
    $(document).ready(function() {
      $('.toggle-blog-commentable').on('change', function() {
        var checkbox = $(this);
        var id = checkbox.data('id');
        var originalState = checkbox.prop('checked');

        $.ajax({
          url: '/toggle_commentable/' + id,
          type: 'POST',
          data: {
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            if (!response.success) {
              checkbox.prop('checked', originalState);
              alert('Failed to update status');
            }
          },
          error: function() {
            checkbox.prop('checked', originalState);
            alert('Error toggling commentable status');
          }
        });
      });
    });
  </script>
</body>

</html>