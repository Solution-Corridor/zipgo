{{-- resources/views/admin/blogs/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">
@section('title')
Add Blog
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
              <h1 class="m-0">Add New Blog</h1>
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

                  <form action="{{ route('blogs.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Title <span class="text-danger">*</span></label>
                          <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Blog Title">
                          @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Slug (optional - auto generated from title)</label>
                          <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="Blog Slug">
                          @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Short Description (max 1000 chars)</label>
                          <textarea name="short_description" rows="3" class="form-control @error('short_description') is-invalid @enderror" placeholder="Short Description">{{ old('short_description') }}</textarea>
                          @error('short_description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Content (Detail) <span class="text-danger">*</span></label>
                          <textarea name="detail" rows="10" class="form-control @error('detail') is-invalid @enderror" placeholder="Blog Content" required>{{ old('detail') }}</textarea>
                          @error('detail')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-7">
                        <div class="form-group">
                          <label>Keywords (comma separated)</label>
                          <input type="text" name="keywords" class="form-control @error('keywords') is-invalid @enderror" value="{{ old('keywords') }}" placeholder="Keywords">
                          @error('keywords')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Featured Picture <span class="text-danger">*</span></label>
                          <input type="file" name="picture" class="form-control-file @error('picture') is-invalid @enderror" accept="image/*" required>
                          @error('picture')<span class="invalid-feedback">{{ $message }}</span>@enderror
                          <small class="form-text text-muted">JPEG, PNG, JPG, GIF up to 2MB</small>
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label> &nbsp;</label>
                          <div class="custom-control custom-switch custom-switch-on-success">
                            <input type="checkbox" name="is_commentable" class="custom-control-input" id="commentableSwitch" {{ old('is_commentable') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="commentableSwitch">Allow Comments</label>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Page Schema (JSON-LD)</label>
                          <textarea name="page_schema" rows="5" class="form-control @error('page_schema') is-invalid @enderror" placeholder="Page Schema">{{ old('page_schema') }}</textarea>
                          @error('page_schema')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                      </div>

                      <div class="col-md-12" align="center">
                        <button type="submit" class="btn btn-primary">Publish Blog</button>
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