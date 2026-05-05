<!DOCTYPE html>
<html lang="en">
@section('title')
Manage Services
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
              <h1 class="m-0">Manage Services</h1>
            </div>
            <div class="col-sm-6 text-right">
              <a href="{{ route('services.create') }}" class="btn btn-primary">+ Add New Service</a>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header bg-light">All Services</div>
                <div class="card-body">
                  @include('admin.includes.success')

                  <table class="table table-bordered table-striped example1" id="example1">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Price (Rs.)</th>
                        <th>Status</th>
                        <th>Show on Top</th>   {{-- column header kept as original --}}
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($services as $service)
                      <tr>
                        <td>{{ $service->id }}</td>
                        <td><img src="/{{ $service->pic }}" width="60"></td>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->slug }}</td>
                        <td>{{ number_format($service->price) }}</td>
                        <td>
                          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox"
                              class="custom-control-input toggle-status"
                              id="serviceSwitch{{ $service->id }}"
                              data-id="{{ $service->id }}"
                              {{ $service->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label" for="serviceSwitch{{ $service->id }}"></label>
                          </div>
                        </td>
                        <td>
                          {{-- Display is_priority number only (no editing) --}}
                          @if($service->is_priority)
                            <span class="badge badge-info">{{ $service->is_priority }}</span>
                            <small class="text-muted d-block">(lower = higher)</small>
                          @else
                            <span class="text-muted">—</span>
                          @endif
                        </td>
                        <td>
                          <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-warning">Edit</a>
                          <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                          </form>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="8" class="text-center">No services found.</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
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

  {{-- Only status toggle script – is_priority is read-only --}}
  <script>
    $(document).ready(function() {
      $('.toggle-status').click(function() {
        var btn = $(this);
        var id = btn.data('id');
        $.ajax({
          url: '/services/' + id + '/toggle-active',
          type: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            _method: 'POST'
          },
          success: function(response) {
            if (response.success) {
              if (response.is_active) {
                btn.prop('checked', true);
              } else {
                btn.prop('checked', false);
              }
            }
          },
          error: function() {
            alert('Error toggling status');
          }
        });
      });
    });
  </script>
</body>
</html>