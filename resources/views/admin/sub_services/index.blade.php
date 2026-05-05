<!DOCTYPE html>
<html lang="en">
@section('title')
Manage Sub Services
@endsection
<!-- Start top links -->
@include('admin.includes.headlinks')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Start navbar -->
    @include('admin.includes.navbar')
    <!-- end navbar -->

    <!-- Start Sidebar -->
    @include('admin.includes.sidebar')
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Manage Sub Services</h1>
            </div>
            <div class="col-sm-6 text-right">
              <a href="{{ route('sub-services.create') }}" class="btn btn-primary">+ Add New Sub Service</a>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header bg-light">All Sub Services</div>
                <div class="card-body">
                  @include('admin.includes.success')

                  <table class="table table-bordered table-striped example1" id="example1">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Parent Service</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Price (Rs.)</th>
                        <th>Status</th>
                        <th>Show on Top</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($subServices as $sub)
                      <tr>
                        <td>{{ $sub->id }}</td>
                        <td>
                          @if($sub->image)
                          <img src="/{{ $sub->image }}" width="60" height="60" style="object-fit: cover;">
                          @else
                          <span>No Image</span>
                          @endif
                        </td>
                        <td>{{ $sub->service->name ?? '-' }}</td>
                        <td>{{ $sub->name }}</td>
                        <td>{{ $sub->slug }}</td>
                        <td>{{ number_format($sub->price) }}</td>
                        <td>
                          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox"
                              class="custom-control-input toggle-status"
                              id="subSwitch{{ $sub->id }}"
                              data-id="{{ $sub->id }}"
                              {{ $sub->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label" for="subSwitch{{ $sub->id }}"></label>
                          </div>
                        </td>
                        <td>
                          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox"
                              class="custom-control-input toggle-priority"
                              id="prioritySwitch{{ $sub->id }}"
                              data-id="{{ $sub->id }}"
                              {{ $sub->is_priority ? 'checked' : '' }}>
                            <label class="custom-control-label" for="prioritySwitch{{ $sub->id }}"></label>
                          </div>
                        </td>
                        <td>
                          <a href="{{ route('sub-services.edit', $sub->id) }}" class="btn btn-sm btn-warning">Edit</a>
                          <form action="{{ route('sub-services.destroy', $sub->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                          </form>
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="8" class="text-center">No sub services found.</td>
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
    <!------ end Footer -->

  </div>
  <!-- ./wrapper -->
  <!------ Start Footer links-->
  @include('admin.includes.footer_links')
  <!------ end Footer links -->

  <script>
    $(document).ready(function() {
      $('.toggle-status').click(function() {
        var btn = $(this);
        var id = btn.data('id');
        $.ajax({
          url: '/sub-services/' + id + '/toggle-active',
          type: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            _method: 'POST'
          },
          success: function(response) {
            if (response.success) {
              btn.prop('checked', response.is_active);
            }
          },
          error: function() {
            alert('Error toggling status');
          }
        });
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.toggle-priority').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
          let subId = this.getAttribute('data-id');
          let status = this.checked ? 1 : 0;
          fetch("{{ route('sub-services.togglePriority') }}", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
              },
              body: JSON.stringify({
                id: subId,
                is_priority: status
              })
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                console.log('Priority updated');
              }
            })
            .catch(error => {
              alert('Something went wrong!');
            });
        });
      });
    });
  </script>
</body>

</html>