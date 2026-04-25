<!DOCTYPE html>
<html lang="en">
@section('title')
Add City
@endsection
<!-- Start top links -->
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
                        <h1 class="m-0">Add New City</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">City Details</div>
                            <div class="card-body">
                                @include('admin.includes.success')
                                <form action="{{ route('cities.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City Name <code>*</code></label>
                                                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                                            </div>
                                            @error('name')<p class="text-danger">{{ $message }}</p>@enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Slug / URL <code>*</code></label>
                                                <input type="text" name="slug" id="slug" class="form-control" required value="{{ old('slug') }}">
                                                <small class="text-muted">Auto‑generated from city name – you can edit.</small>
                                            </div>
                                            @error('slug')<p class="text-danger">{{ $message }}</p>@enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City Image <code>*</code> <small>Max 2MB, jpeg,png,jpg,svg</small></label>
                                                <input type="file" name="pic" class="form-control" required>
                                            </div>
                                            @error('pic')<p class="text-danger">{{ $message }}</p>@enderror
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>City Detail / Description</label>
                                                <textarea name="detail" id="myTextarea" class="form-control" placeholder="Full description...">{{ old('detail') }}</textarea>
                                            </div>
                                            @error('detail')<p class="text-danger">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div class="card-footer text-center">
                                        <a href="{{ route('cities.index') }}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Add City</button>
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
    // Auto-slug from city name
    document.getElementById('name').addEventListener('blur', function(){
        let name = this.value;
        let slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        document.getElementById('slug').value = slug;
    });

    // TinyMCE for detail
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