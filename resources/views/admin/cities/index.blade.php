<!DOCTYPE html>
<html lang="en">
@section('title')
Manage Cities
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
                        <h1 class="m-0">Manage Cities</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('cities.create') }}" class="btn btn-primary">+ Add New City</a>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">All Cities</div>
                            <div class="card-body">
                                @include('admin.includes.success')

                                <table class="table table-bordered table-striped example1" id="example1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>City Name</th>
                                            <th>Slug</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cities as $city)
                                        <tr>
                                            <td>{{ $city->id }}</td>
                                            <td>
                                                @if($city->pic)
                                                    <img src="/{{ $city->pic }}" width="60" height="60" style="object-fit: cover;">
                                                @else
                                                    <img src="/assets/images/favicon.png" width="60">
                                                @endif
                                            </td>
                                            <td>{{ $city->name }}</td>
                                            <td>{{ $city->slug }}</td>
                                            <td>
                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox"
                                                           class="custom-control-input toggle-city-status"
                                                           id="citySwitch{{ $city->id }}"
                                                           data-id="{{ $city->id }}"
                                                           {{ $city->is_active ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="citySwitch{{ $city->id }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('cities.destroy', $city->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this city?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="6" class="text-center">No cities found.</td></tr>
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

<!-- AJAX Toggle Script -->
<script>
$(document).ready(function() {
    $('.toggle-city-status').on('change', function() {
        var checkbox = $(this);
        var id = checkbox.data('id');
        var originalState = checkbox.prop('checked');

        $.ajax({
            url: '/cities/' + id + '/toggle-active',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'POST'
            },
            success: function(response) {
                if (!response.success) {
                    checkbox.prop('checked', originalState);
                    alert('Failed to update status');
                }
            },
            error: function() {
                checkbox.prop('checked', originalState);
                alert('Error toggling status');
            }
        });
    });
});
</script>
</body>
</html>