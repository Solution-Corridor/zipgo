<!DOCTYPE html>
<html lang="en">
@section('title')
Edit Service
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
              <h1 class="m-0">Edit Service: {{ $service->name }}</h1>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header bg-light">Edit Service</div>
                <div class="card-body">
                  @include('admin.includes.success')
                  <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label>Service Name <code>*</code></label>
                          <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $service->name) }}" required>
                        </div>
                        @error('name')<p class="text-danger">{{ $message }}</p>@enderror
                      </div>

                      <div class="col-md-5">
                        <div class="form-group">
                          <label>Slug <code>*</code></label>
                          <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $service->slug) }}" required>
                        </div>
                        @error('slug')<p class="text-danger">{{ $message }}</p>@enderror
                      </div>

                      {{-- PRIORITY NUMBER FIELD (replaces toggle) --}}
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Priority Order</label>
                          <input type="number" name="is_priority" id="is_priority" class="form-control"
                                 min="1" step="1" value="{{ old('is_priority', $service->is_priority) }}">
                          <small class="text-muted">Lower number = higher position (1 = first). Leave empty to place after all prioritized services.</small>
                        </div>
                        @error('is_priority')<p class="text-danger">{{ $message }}</p>@enderror
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Price (Rs.) <code>*</code></label>
                          <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $service->price) }}" required>
                        </div>
                        @error('price')<p class="text-danger">{{ $message }}</p>@enderror
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Current Image</label>
                          <input type="file" name="picture" class="form-control" accept="image/*"><br> 
                          @if($service->pic)
                            <img src="/{{ $service->pic }}" width="80" height="80" style="object-fit: cover;">
                          @else
                            No image
                          @endif
                          <small>Leave empty to keep current image. Max 2MB.</small>
                        </div>
                        @error('picture')<p class="text-danger">{{ $message }}</p>@enderror
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Service Detail</label>
                          <textarea name="detail" id="myTextarea" class="form-control">{{ old('detail', $service->detail) }}</textarea>
                        </div>
                        @error('detail')<p class="text-danger">{{ $message }}</p>@enderror
                      </div>
                    </div>

                    <div class="card-footer text-center">
                      <a href="{{ route('services.index') }}" class="btn btn-danger">Cancel</a>
                      <button type="submit" class="btn btn-primary">Update Service</button>
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

  <script>
    // Auto-slug from service name
    document.getElementById('name').addEventListener('blur', function() {
      let name = this.value;
      let slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
      document.getElementById('slug').value = slug;
    });

    // TinyMCE
    tinymce.init({
      selector: '#myTextarea',
      plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
      menubar: 'file edit view insert format tools table help',
      toolbar: 'undo redo | bold italic underline | fontfamily fontsize | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | removeformat | image media',
      height: 400,
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    });
  </script>
</body>
</html>