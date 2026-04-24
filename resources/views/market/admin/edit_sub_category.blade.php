<!DOCTYPE html>
<html lang="en">
@section('title')
Edit Sub Category
@endsection
<!-- Start top links -->
@include('admin.includes.headlinks')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <style>
        .strdngr {
            color: red;
        }
    </style>
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
                            <h1 class="m-0">Edit Sub Category</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Edit Sub Category</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div><!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Sub Category</h3>
                                    <div class="card-tools">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- form start -->
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    @include('admin.includes.success')
                                    <form action="{{ route('market.update_sub_category', $sub_category->sub_cat_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="row">
            <!-- Category -->
            <div class="col-md-3">
                <label><b>Category </b><span class="strdngr">*</span></label>
                <select name="cat_id" class="form-control select2" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $sub_category->cat_id == $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                    @endforeach
                </select>
                @error('cat_id')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- Sub Category Name -->
            <div class="col-md-3">
                <label><b>Sub Category Name </b><span class="strdngr">*</span></label>
                <input type="text" name="sub_cat_name" class="form-control" placeholder="Enter Sub Category Name" value="{{ old('sub_cat_name', $sub_category->sub_cat_name) }}" required>
                @error('sub_cat_name')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- URL -->
            <div class="col-md-3">
                <label><b>URL </b><span class="strdngr">*</span></label>
                <input type="text" name="sub_cat_url" class="form-control" placeholder="army-belt" value="{{ old('sub_cat_url', $sub_category->sub_cat_url) }}" required>
                @error('sub_cat_url')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- Feature Image -->
            <div class="col-md-2">
                <label><b>Feature Image </b></label>
                
                <input type="file" name="feature_image" class="form-control" accept="image/*">
                @error('feature_image')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-1">
                
                @if($sub_category->feature_image)
                    <div class="mb-2">
                        <img src="/{{ $sub_category->feature_image }}" alt="Current Sub Category Image" style="max-width: 80px; max-height: 80px;">
                        <p>Current Image</p>
                    </div>
                @endif
                
            </div>

                                            <!-- Meta Fields -->
                                            <div class="col-md-12 mt-3">
                                                <label><b>Meta Title </b><span class="strdngr">*</span> <small>(45-70 chars)</small></label>
                                                <input type="text" id="sub_category_meta_title" name="meta_title" placeholder="Meta Title" class="form-control" maxlength="70"
                                                       value="{{ old('meta_title', $sub_category->meta_title) }}" required>
                                                <small id="sub_category_meta_title_count" class="text-muted">0 / 70 characters</small>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <label><b>Meta Description </b><span class="strdngr">*</span> <small>(70-155 chars)</small></label>
                                                <textarea id="sub_category_meta_description" name="meta_description" placeholder="Meta Description" class="form-control" rows="3" maxlength="155" required>{{ old('meta_description', $sub_category->meta_description) }}</textarea>
                                                <small id="sub_category_meta_description_count" class="text-muted">0 / 155 characters</small>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <label><b>Meta Keywords </b><span class="strdngr">*</span></label>
                                                <input type="text" name="meta_keywords" class="form-control" placeholder="Meta Keywords"
                                                       value="{{ old('meta_keywords', $sub_category->meta_keywords) }}" required>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <label><b>Schema </b><span class="strdngr">*</span></label>
                                                <textarea id="product_schema" name="page_schema" placeholder="Schema" class="form-control" rows="6" required>{{ old('page_schema', $sub_category->page_schema) }}</textarea>
                                            </div>

                                            <!-- Dynamic FAQs -->
                                            <div class="col-md-12 mt-4">
                                                <label><b>Product FAQs</b></label>
                                                <div id="faq_wrapper">
                                                    @forelse($faqs as $faq)
                                                        <div class="faq_item row mb-2">
                                                            <div class="col-md-5">
                                                                <input type="text" name="faq_question[]" class="form-control"
                                                                       value="{{ old('faq_question.' . $loop->index, $faq->question) }}" placeholder="FAQ Question">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" name="faq_answer[]" class="form-control"
                                                                       value="{{ old('faq_answer.' . $loop->index, $faq->answer) }}" placeholder="FAQ Answer">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="button" class="btn btn-danger removeFaq"><i class="fa fa-trash"></i></button>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="faq_item row mb-2">
                                                            <div class="col-md-5">
                                                                <input type="text" name="faq_question[]" class="form-control" placeholder="FAQ Question">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" name="faq_answer[]" class="form-control" placeholder="FAQ Answer">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="button" class="btn btn-danger removeFaq"><i class="fa fa-trash"></i></button>
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                </div>
                                                <button type="button" class="btn btn-success mt-2" id="addFaq">+ Add FAQ</button>
                                            </div>

        </div>
    </div>
    <div class="card-footer text-center">
        <a href="{{ route('market.add_sub_category') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-primary">Update Sub Category</button>
    </div>
</form>
                                </div><!-- /.card -->
                            </div><!--/.col (left) -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateCount(inputId, counterId, maxLength) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);

        function update() {
            counter.textContent = input.value.length + " / " + maxLength + " characters";
        }

        input.addEventListener("input", update);
        update(); // initialize count on page load
    }

    // ---------- Sub Category Fields ----------
    updateCount("sub_category_meta_title", "sub_category_meta_title_count", 70);
    updateCount("sub_category_meta_description", "sub_category_meta_description_count", 155);


$(document).ready(function () {

    $("#addFaq").click(function () {
        $("#faq_wrapper").append(`
            <div class="faq_item row mb-2">
                <div class="col-md-5">
                    <input type="text" name="faq_question[]" class="form-control" placeholder="FAQ Question">
                </div>
                <div class="col-md-6">
                    <input type="text" name="faq_answer[]" class="form-control" placeholder="FAQ Answer">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger removeFaq"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        `);
    });

    $(document).on("click", ".removeFaq", function () {
        $(this).closest('.faq_item').remove();
    });

});
</script>
        @include('admin.includes.version')
    </div><!-- /.wrapper -->

    @include('admin.includes.footer_links')
</body>

</html>