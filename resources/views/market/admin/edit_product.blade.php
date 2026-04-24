<!DOCTYPE html>
<html lang="en">
@section('title')
Edit Product
@endsection
@include('admin.includes.headlinks')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <style>
        .strdngr { color: red; }
    </style>

    @include('admin.includes.navbar')
    @include('admin.includes.sidebar')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Product</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-body">
                                @include('admin.includes.success')

                                <form action="{{ route('market.update_product', $product->product_id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="card-body">
                                        <div class="row">

                                            <!-- Category -->
                                            <div class="col-md-4">
                                                <label><b>Category </b><span class="strdngr">*</span></label>
                                                <select name="cat_id" id="cat_id" class="form-control select2" required>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}" {{ old('cat_id', $product->cat_id) == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('cat_id') <p class="help-block text-danger">{{ $message }}</p> @enderror
                                            </div>

                                            <!-- Sub Category -->
                                            <div class="col-md-4">
                                                <label><b>Sub Category </b></label>
                                                <select name="sub_cat_id" id="sub_cat_id" class="form-control select2">
                                                    <option value="">Select Sub Category</option>
                                                </select>
                                                @error('sub_cat_id') <p class="help-block text-danger">{{ $message }}</p> @enderror
                                            </div>

                                            <!-- Product Name -->
                                            <div class="col-md-4">
                                                <label><b>Product Name </b><span class="strdngr">*</span></label>
                                                <input type="text" id="product_name" name="name" class="form-control"
                                                       placeholder="Enter Product Name" value="{{ old('name', $product->name) }}" required>
                                                @error('name') <p class="help-block text-danger">{{ $message }}</p> @enderror
                                            </div>

                                            <!-- Price & Delivery Charges -->
                                            <div class="col-md-2">
                                                <label><b>Price </b><span class="strdngr">*</span></label>
                                                <input type="number" name="price" class="form-control" step="0.01"
                                                       value="{{ old('price', $product->price) }}" required>
                                                @error('price') <p class="help-block text-danger">{{ $message }}</p> @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <label><b>Delivery Charges </b><span class="strdngr">*</span></label>
                                                <input type="number" name="delivery_charges" class="form-control" step="0.01"
                                                       value="{{ old('delivery_charges', $product->delivery_charges) }}" required>
                                                @error('delivery_charges') <p class="help-block text-danger">{{ $message }}</p> @enderror
                                            </div>

                                            <!-- Images -->
                                            <div class="col-md-4">
                                                <label><b>Feature Picture </b></label>
                                                <input type="file" name="pic" class="form-control">
                                                @if($product->pic)
                                                    <img src="/uploads/market/products/{{ $product->pic }}" class="mt-2 img-thumbnail" style="width:80px;height:80px;">
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <label><b>Picture 1 </b></label>
                                                <input type="file" name="pic1" class="form-control">
                                                @if($product->pic1)
                                                    <img src="/uploads/market/products/{{ $product->pic1 }}" class="mt-2 img-thumbnail" style="width:80px;height:80px;">
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <label><b>Picture 2 </b></label>
                                                <input type="file" name="pic2" class="form-control">
                                                @if($product->pic2)
                                                    <img src="/uploads/market/products/{{ $product->pic2 }}" class="mt-2 img-thumbnail" style="width:80px;height:80px;">
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <label><b>Picture 3 </b></label>
                                                <input type="file" name="pic3" class="form-control">
                                                @if($product->pic3)
                                                    <img src="/uploads/market/products/{{ $product->pic3 }}" class="mt-2 img-thumbnail" style="width:80px;height:80px;">
                                                @endif
                                            </div>

                                            <!-- Slug -->
                                            <div class="col-md-4">
                                                <label><b>URL (Slug) </b><span class="strdngr">*</span></label>
                                                <input type="text" id="product_slug" name="slug" class="form-control"
                                                       value="{{ old('slug', $product->slug) }}" required>
                                                @error('slug') <p class="help-block text-danger">{{ $message }}</p> @enderror
                                            </div>

                                            <div class="col-md-3 mt-3">
    <label><b>Cutting Price </b></label>
    <input type="number"
       step="1"
       min="0"
       id="cutting_price"
       name="cutting_price"
       class="form-control"
       placeholder="Cutting Price"
       value="{{ old('cutting_price', (int) $product->cutting_price) }}">
    @error('cutting_price')
    <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="col-md-3 mt-3">
    <label><b>Ratting </b></label>
    <input type="number" 
           id="product_ratting" 
           name="product_ratting" 
           class="form-control"
           placeholder="Product Ratting" 
           value="{{ old('product_ratting', $product->product_ratting) }}"
           step="0.1"   
           min="0" 
           max="5">     
    @error('product_ratting')
    <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>


<div class="col-md-2 mt-3">
    <label><b>Ratting Count </b></label>
    <input type="number" id="ratting_count" name="ratting_count" class="form-control"
           placeholder="Ratting Count" value="{{ old('ratting_count', $product->ratting_count) }}">
    @error('ratting_count')
    <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="col-md-2 mt-3">
    <label><b>Stock Sold </b></label>
    <input type="number" id="stock_sold" name="stock_sold" class="form-control"
           placeholder="Stock Sold" value="{{ old('stock_sold', $product->stock_sold) }}">
    @error('stock_sold')
    <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="col-md-2 mt-3">
    <label><b>Stock Left </b></label>
    <input type="number" id="stock_left" name="stock_left" class="form-control"
           placeholder="Stock Left" value="{{ old('stock_left', $product->stock_left) }}">
    @error('stock_left')
    <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>

                                            <!-- Detail -->
                                            <div class="col-md-12">
                                                <label><b>Detail </b><span class="strdngr">*</span></label>
                                                <textarea name="detail" class="form-control textarea" required>{{ old('detail', $product->detail) }}</textarea>
                                                @error('detail') <p class="help-block text-danger">{{ $message }}</p> @enderror
                                            </div>

                                            <!-- Meta Fields -->
                                            <div class="col-md-12 mt-3">
                                                <label><b>Meta Title </b><span class="strdngr">*</span> <small>(45-70 chars)</small></label>
                                                <input type="text" id="product_meta_title" name="meta_title" placeholder="Meta Title" class="form-control" maxlength="70"
                                                       value="{{ old('meta_title', $product->meta_title) }}" required>
                                                <small id="meta_title_count" class="text-muted">0 / 70 characters</small>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <label><b>Meta Description </b><span class="strdngr">*</span> <small>(70-155 chars)</small></label>
                                                <textarea id="product_meta_description" name="meta_description" placeholder="Meta Description" class="form-control" rows="3" maxlength="155" required>{{ old('meta_description', $product->meta_description) }}</textarea>
                                                <small id="meta_description_count" class="text-muted">0 / 155 characters</small>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <label><b>Meta Keywords </b><span class="strdngr">*</span></label>
                                                <input type="text" name="meta_keywords" class="form-control" placeholder="Meta Keywords"
                                                       value="{{ old('meta_keywords', $product->meta_keywords) }}" required>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <label><b>Schema </b></label>
                                                <textarea id="product_schema" name="page_schema" placeholder="Schema" class="form-control" rows="6">{{ old('page_schema', $product->page_schema) }}</textarea>
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
                                        <a href="{{ route('market.products') }}" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update Product</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- All Your Existing + New Scripts Below -->
    <script>
    $(document).ready(function () {

        // Initialize Select2
        $('#cat_id, #sub_cat_id').select2({ width: '100%' });

        // Populate subcategories on load
        const currentCatId = '{{ old('cat_id', $product->cat_id) }}';
        const currentSubCatId = '{{ old('sub_cat_id', $product->sub_cat_id) }}';

        function populateSubCategories(catId, selectedId = null) {
            $('#sub_cat_id').empty().append('<option value="">Select Sub Category</option>');
            if (!catId) return;

            $.get('/get-sub-categories/' + catId, function(data) {
                $.each(data, function(i, sub) {
                    const selected = (sub.sub_cat_id == selectedId) ? 'selected' : '';
                    $('#sub_cat_id').append(`<option value="${sub.sub_cat_id}" ${selected}>${sub.sub_cat_name}</option>`);
                });
                $('#sub_cat_id').trigger('change.select2');
            });
        }

        if (currentCatId) {
            $('#cat_id').val(currentCatId).trigger('change.select2');
            populateSubCategories(currentCatId, currentSubCatId);
        }

        $('#cat_id').on('change', function() {
            populateSubCategories($(this).val());
        });

        // FAQ Add/Remove
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

        // Slug Auto-generate (same as add page)
        const $nameInput = $('#product_name');
        const $slugInput = $('#product_slug');

        function generateSlug(str) {
            return str.toLowerCase().trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        $nameInput.on('blur', function () {
            if (!$slugInput.data('manually-edited') && $nameInput.val()) {
                $slugInput.val(generateSlug($nameInput.val()));
            }
        });

        $slugInput.on('keydown', function() {
            $(this).data('manually-edited', true);
        });

        // Character counters
        function updateCount(id, counterId, min, max) {
            const input = document.getElementById(id);
            const counter = document.getElementById(counterId);
            const update = () => {
                const len = input.value.length;
                counter.textContent = len + " / " + max + " characters";
                counter.style.color = (len >= min && len <= max) ? "green" : "red";
            };
            input.addEventListener('input', update);
            update(); // initial
        }

        updateCount("product_meta_title", "meta_title_count", 45, 70);
        updateCount("product_meta_description", "meta_description_count", 70, 155);
    });
    </script>

    @include('admin.includes.footer_links')
</div>
</body>
</html>