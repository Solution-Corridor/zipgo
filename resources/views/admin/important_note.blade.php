<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Important Note - Admin</title>
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
                        <h1 class="m-0">Important Note</h1>
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
                                <h3 class="card-title">System-wide Important Message</h3>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('important_note') }}" method="POST">
                                    @csrf
                                    @method('POST') <!-- since we use match get/post -->

                                    <div class="form-group">
                                        <label for="message">Message <small>(leave empty to remove note)</small></label>
                                        <textarea 
                                            name="message" 
                                            id="message" 
                                            class="form-control @error('message') is-invalid @enderror" 
                                            rows="8" 
                                            placeholder="Write important note here... (supports basic HTML if you allow it later)"
                                        >{{ old('message', $note->message ?? '') }}</textarea>

                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mt-4 text-center">
                                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary px-5">
                                            Save Note
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