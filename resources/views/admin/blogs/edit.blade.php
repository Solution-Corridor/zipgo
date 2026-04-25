{{-- resources/views/admin/blogs/edit.blade.php --}}
<!DOCTYPE html>
<html lang="en">
@section('title')
Edit Blog
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
              <h1 class="m-0">Edit Blog: {{ $blog->title }}</h1>
            </div>
            <div class="col-sm-6 text-right">
              <a href="{{ route('blogs.list') }}" class="btn btn-secondary">Back to List</a>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  @include('admin.includes.success')

                  <form action="{{ route('blogs.update', $blog->blog_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Title <span class="text-danger">*</span></label>
                          <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $blog->title) }}" required>
                          @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Slug</label>
                          <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $blog->slug) }}">
                          @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Short Description</label>
                          <textarea name="short_description" rows="3" class="form-control @error('short_description') is-invalid @enderror">{{ old('short_description', $blog->short_description) }}</textarea>
                          @error('short_description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Content (Detail) <span class="text-danger">*</span></label>
                          <textarea name="detail" rows="10" class="form-control @error('detail') is-invalid @enderror" required>{{ old('detail', $blog->detail) }}</textarea>
                          @error('detail')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Keywords</label>
                          <input type="text" name="keywords" class="form-control @error('keywords') is-invalid @enderror" value="{{ old('keywords', $blog->keywords) }}">
                          @error('keywords')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-7">
                        <div class="form-group">
                          <label>Page Schema</label>
                          <textarea name="page_schema" rows="5" class="form-control @error('page_schema') is-invalid @enderror">{{ old('page_schema', $blog->page_schema) }}</textarea>
                          @error('page_schema')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Current Picture</label><br>
                          @if($blog->picture)
                          <img src="{{ asset('uploads/'.$blog->picture) }}" width="150" class="mb-2"><br>
                          @else
                          <span class="text-muted">No picture uploaded</span>
                          @endif
                          <label>Change Picture (optional)</label>
                          <input type="file" name="picture" class="form-control-file @error('picture') is-invalid @enderror" accept="image/*">
                          @error('picture')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <div class="custom-control custom-switch custom-switch-on-success">
                            <input type="checkbox" name="is_commentable" class="custom-control-input" id="commentableSwitch" {{ old('is_commentable', $blog->is_commentable) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="commentableSwitch">Allow Comments</label>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12" align="center">
                        <button type="submit" class="btn btn-primary">Update Blog</button>
                      </div>
                    </div>
                  </form>
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
</body>

</html>