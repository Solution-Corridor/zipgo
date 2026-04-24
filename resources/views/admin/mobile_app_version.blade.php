<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile App Version - Admin</title>
    @include('admin.includes.headlinks')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

    @include('admin.includes.navbar')
    @include('admin.includes.sidebar')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Mobile App Version</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        @include('includes.success')

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Mobile App Version</h3>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('mobile_app_version') }}" method="POST">
                                    @csrf
                                    @method('POST') <!-- since we use match get/post -->

                                    <div class="form-group">
                                        <label for="version">Version </label>
                                        <input type="text" 
                                            name="version" 
                                            id="version" 
                                            class="form-control @error('version') is-invalid @enderror" 
                                            rows="8" 
                                            placeholder="3.1.1"
                                        value="{{ old('version', $version->version ?? '') }}">

                                        @error('version')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mt-4 text-center">
                                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary px-5">
                                            Save Version
                                        </button>
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