<!DOCTYPE html>
<html lang="en">
@section('title')
    Edit Task - Admin
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
        <!-- end Sidebar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Task: {{ $task->name }}</h1>
                        </div>
                        <div class="col-sm-6"></div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Task</h3>
                                </div>
                                <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Task Name <code>*</code></label>
                                                    <input type="text" name="name" class="form-control" value="{{ old('name', $task->name) }}" required>
                                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Duration (seconds) <code>*</code></label>
                                                    <input type="number" name="duration" class="form-control" min="1" value="{{ old('duration', $task->duration) }}" required>
                                                    @error('duration') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Price (Rs) <code>*</code></label>
                                                    <input type="number" name="price" step="0.01" class="form-control" min="0" value="{{ old('price', $task->price) }}" required>
                                                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Current File</label><br>
                                                    @php
                                                        $ext = pathinfo($task->file_path, PATHINFO_EXTENSION);
                                                        $imageExts = ['jpg', 'jpeg', 'png', 'gif'];
                                                    @endphp
                                                    @if(in_array(strtolower($ext), $imageExts))
                                                        <a href="/{{$task->file_path}}" target="_blank">
                                                            <img src="/{{$task->file_path}}" width="100" style="object-fit: cover;">
                                                        </a>
                                                    @else
                                                        <a href="/{{$task->file_path}}" target="_blank" class="btn btn-sm btn-default">
                                                            <i class="fa fa-file-video-o"></i> View current video/gif
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label>Replace File (leave empty to keep current)</label>
                                                    <input type="file" name="file" class="form-control-file" accept="image/*,video/*,.gif">
                                                    @error('file') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('tasks') }}" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update Task</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        @include('admin.includes.version')
    </div>

    <!-- Footer links -->
    @include('admin.includes.footer_links')
</body>
</html>