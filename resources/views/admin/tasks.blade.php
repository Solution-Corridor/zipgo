<!DOCTYPE html>
<html lang="en">
@section('title')
    Tasks - Admin
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
                            <h1 class="m-0">Tasks</h1>
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
                            @include('includes.success')
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                                href="#custom-tabs-four-home" role="tab"
                                                aria-controls="custom-tabs-four-home" aria-selected="true">
                                                <i class="fa fa-list"></i> List Tasks
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                                href="#custom-tabs-four-profile" role="tab"
                                                aria-controls="custom-tabs-four-profile" aria-selected="false">
                                                <i class="fa fa-plus"></i> Add New Task
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">

                                        <!-- LIST TAB -->
                                        <div class="tab-pane fade show active" id="custom-tabs-four-home"
                                            role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                                            

                                            <div class="card card-primary">
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Task Name</th>
                                                            <th>Duration (sec)</th>
                                                            <th>File</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($tasks as $task)
                                                        <tr>
                                                            <td>{{ $task->id }}</td>
                                                            <td>{{ $task->name }}</td>
                                                            <td>{{ $task->duration }} sec</td>
                                                            <td>
                                                                @php
                                                                    $ext = pathinfo($task->file_path, PATHINFO_EXTENSION);
                                                                    $imageExts = ['jpg', 'jpeg', 'png', 'gif'];
                                                                @endphp
                                                                @if(in_array(strtolower($ext), $imageExts))
                                                                    <a href="/{{$task->file_path}}" target="_blank">
                                                                        <img src="/{{$task->file_path}}" width="50" height="50" style="object-fit: cover;">
                                                                    </a>
                                                                @else
                                                                    <a href="/{{$task->file_path}}" target="_blank" class="btn btn-sm btn-default">
                                                                        <i class="fa fa-file-video-o"></i> View
                                                                    </a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-info btn-xs">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>

                                                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-xs"
                                                                        onclick="return confirm('Delete this task?');">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- ADD FORM TAB -->
                                        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                            aria-labelledby="custom-tabs-four-profile-tab">

                                            <div class="card card-primary">
                                                <form name="TaskForm" action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="container-fluid">

                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label>Task Name <code>*</code></label>
                                                                <input type="text" name="name" class="form-control"
                                                                    placeholder="e.g. Watch Video, Click Photo"
                                                                    value="{{ old('name') }}" required>
                                                                @error('name')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Duration (seconds) <code>*</code></label>
                                                                <input type="number" name="duration" class="form-control"
                                                                    min="1" required value="{{ old('duration') }}" placeholder="15">
                                                                @error('duration')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            

                                                            <div class="col-md-3">
                                                                <label>Upload File (image/video/gif) <code>*</code></label>
                                                                <input type="file" name="file" class="form-control-file" required accept="image/*,video/*,.gif">
                                                                @error('file')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-footer text-center mt-4">
                                                        <a href="/admin/dashboard" class="btn btn-danger">Cancel</a>
                                                        <button type="submit" class="btn btn-primary">
                                                            Create Task
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        @include('admin.includes.version')
        <!-- ./wrapper -->

        <!-- Footer links -->
        @include('admin.includes.footer_links')

</body>

</html>