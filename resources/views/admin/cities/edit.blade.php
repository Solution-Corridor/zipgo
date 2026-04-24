<!DOCTYPE html>
<html lang="en">
@section('title')
Edit City
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
                        <h1 class="m-0">Edit City: {{ $city->name }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">Edit City Details</div>
                            <div class="card-body">
                                @include('admin.includes.success')
                                <form action="{{ route('cities.update', $city->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City Name <code>*</code></label>
                                                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $city->name) }}">
                                            </div>
                                            @error('name')<p class="text-danger">{{ $message }}</p>@enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Slug <code>*</code></label>
                                                <input type="text" name="slug" id="slug" class="form-control" required value="{{ old('slug', $city->slug) }}">
                                            </div>
                                            @error('slug')<p class="text-danger">{{ $message }}</p>@enderror
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Current Image</label><br>
                                                @if($city->pic)
                                                    <img src="/{{ $city->pic }}" width="80" height="80" style="object-fit: cover;">
                                                @else
                                                    No image
                                                @endif
                                                <input type="file" name="pic" class="form-control mt-2" accept="image/*">
                                                <small>Leave empty to keep current image. Max 2MB.</small>
                                            </div>
                                            @error('pic')<p class="text-danger">{{ $message }}</p>@enderror
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>City Detail <code>*</code></label>
                                                <textarea name="detail" id="myTextarea" class="form-control">{{ old('detail', $city->detail) }}</textarea>
                                            </div>
                                            @error('detail')<p class="text-danger">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div class="card-footer text-center">
                                        <a href="{{ route('cities.index') }}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update City</button>
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
    document.getElementById('name').addEventListener('blur', function(){
        let name = this.value;
        let slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        document.getElementById('slug').value = slug;
    });

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