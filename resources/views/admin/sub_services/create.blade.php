<!DOCTYPE html>
<html lang="en">
@section('title')
Add New Sub Service
@endsection
@include('admin.includes.headlinks')
<style>
  .toggle-switch {
    position: relative;
    display: inline-block;
    width: 55px;
    height: 28px;
  }

  .toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    background-color: #ccc;
    border-radius: 34px;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    transition: 0.4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    border-radius: 50%;
    transition: 0.4s;
  }

  .toggle-switch input:checked+.slider {
    background-color: #28a745;
  }

  .toggle-switch input:checked+.slider:before {
    transform: translateX(26px);
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    @include('admin.includes.navbar')
    @include('admin.includes.sidebar')

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Add New Sub Service</h1>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header bg-light">Sub Service Details</div>
                <div class="card-body">
                  @include('admin.includes.success')
                  <form action="{{ route('sub-services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Parent Service <code>*</code></label>
                          <select name="service_id" class="form-control select2" required>
                            <option value="">-- Select Service --</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                              {{ $service->name }}
                            </option>
                            @endforeach
                          </select>
                          @error('service_id')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Sub Service Name <code>*</code></label>
                          <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                          @error('name')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Slug / URL <code>*</code></label>
                          <input type="text" name="slug" id="slug" class="form-control" required value="{{ old('slug') }}">
                          <small class="text-muted">Auto‑generated from name – you can edit.</small>
                          @error('slug')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Price (Rs.) <code>*</code></label>
                          <input type="number" step="0.01" name="price" class="form-control" required value="{{ old('price', 0) }}">
                          @error('price')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Image (optional) <small>Max 2MB, jpeg,png,jpg,svg</small></label>
                          <input type="file" name="image" class="form-control">
                          @error('image')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="d-block">Active Status</label>
                          <label class="toggle-switch">
                            <input type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <span class="slider"></span>
                          </label>
                          <span id="toggleText" class="ms-2">Off</span>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group mb-3">
                          <label class="form-label d-block">Show on Top</label>
                          <label class="toggle-switch">
                            <input type="checkbox" name="is_priority" id="is_priority" value="1" {{ old('is_priority') ? 'checked' : '' }}>
                            <span class="slider"></span>
                          </label>
                          <span id="priorityText" class="ms-2">Off</span>
                          <small class="text-muted d-block">Turn ON to show this sub‑service on top</small>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Description</label>
                          <textarea name="description" id="myTextarea" class="form-control" placeholder="Full description...">{{ old('description') }}</textarea>
                          @error('description')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                      </div>
                    </div>

                    <div class="card-footer text-center">
                      <a href="{{ route('sub-services.index') }}" class="btn btn-danger">Cancel</a>
                      <button type="submit" class="btn btn-primary">Add Sub Service</button>
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
    // Auto-slug from name
    document.getElementById('name').addEventListener('blur', function() {
      let name = this.value;
      let slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
      document.getElementById('slug').value = slug;
    });

    // TinyMCE for description (if you want, same as your service)
    tinymce.init({
      selector: '#myTextarea',
      plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
      menubar: 'file edit view insert format tools table help',
      toolbar: 'undo redo | bold italic underline | fontfamily fontsize | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | removeformat | image media',
      height: 300,
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    });

    // Toggle switch text
    document.addEventListener("DOMContentLoaded", function() {
      const toggle = document.getElementById('isActive');
      const text = document.getElementById('toggleText');
      if (toggle) {
        function updateText() {
          text.textContent = toggle.checked ? 'On' : 'Off';
        }
        toggle.addEventListener('change', updateText);
        updateText();
      }
    });

    const priorityToggle = document.getElementById('is_priority');
    const priorityText = document.getElementById('priorityText');
    if (priorityToggle) {
      priorityToggle.addEventListener('change', function() {
        priorityText.textContent = this.checked ? 'On' : 'Off';
      });
    }
  </script>
</body>

</html>