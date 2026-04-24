<!DOCTYPE html>
<html lang="en">
@section('title')
Add Product
@endsection
<!-- Start top links -->
@include('admin.includes.headlinks')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <style>
      .strdngr {
        color: red;
      }
    </style>
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
              <h1 class="m-0"> Add Product</h1>
            </div><!-- /.col -->
            <div class="col-sm-6"></div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <div class="card card-primary card-outline card-outline-tabs">
                
                <div class="card-body">
                  
                      
                      @include('admin.includes.success')
                      
                    
                        <!-- Add Product Form -->
                        <form action="{{ route('market.save_product') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="row">
            <!-- Category -->
            <div class="col-md-4">
                <label><b>Category </b><span class="strdngr">*</span></label>
                <select name="cat_id" id="cat_id" class="form-control select2" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('cat_id') == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                    @endforeach
                </select>
                @error('cat_id')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- Sub Category -->
<div class="col-md-4">
    <label><b>Sub Category </b></label>
    <select name="sub_cat_id" id="sub_cat_id" class="form-control select2">
        <option value="">Select Sub Category</option>
        <!--  ←  ONLY the placeholder is rendered on the server  -->
    </select>
    @error('sub_cat_id')
        <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>
            
            <!-- Product Name -->
<div class="col-md-4">
    <label><b>Product Name </b><span class="strdngr">*</span></label>
    <input type="text" id="product_name" name="name" class="form-control"
           placeholder="Enter Product Name" value="{{ old('name') }}" required>
    @error('name')
    <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>
            <!-- Price -->
            <div class="col-md-2">
                <label><b>Price </b><span class="strdngr">*</span></label>
                <input type="number" name="price" class="form-control" placeholder="Enter Price" value="{{ old('price') }}" step="0.01" required>
                @error('price')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- Price -->
            <div class="col-md-2">
                <label><b>Delivery Charges </b><span class="strdngr">*</span></label>
                <input type="number" name="delivery_charges" class="form-control" placeholder="Enter Delivery Charges" value="{{ old('delivery_charges', 150) }}" step="0.01" required>
                @error('delivery_charges')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- Feature Picture -->
            <div class="col-md-4">
                <label><b>Feature Picture </b><span class="strdngr">*</span></label>
                <input type="file" name="pic" class="form-control" required>
                @error('pic')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- Additional Picture 1 -->
            <div class="col-md-4">
                <label><b>Picture 1 </b></label>
                <input type="file" name="pic1" class="form-control">
                @error('pic1')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- Additional Picture 2 -->
            <div class="col-md-4">
                <label><b>Picture 2 </b></label>
                <input type="file" name="pic2" class="form-control">
                @error('pic2')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- Additional Picture 3 -->
            <div class="col-md-4">
                <label><b>Picture 3 </b></label>
                <input type="file" name="pic3" class="form-control">
                @error('pic3')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-4">
    <label><b>URL (Slug) </b><span class="strdngr">*</span></label>
    <input type="text" id="product_slug" name="slug" class="form-control"
           placeholder="product-slug" value="{{ old('slug') }}" required>
    @error('slug')
    <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="col-md-3 mt-3">
    <label><b>Cutting Price </b></label>
    <input type="number" id="cutting_price" name="cutting_price" class="form-control"
           placeholder="Cutting Price" value="{{ old('cutting_price') }}">
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
           value="{{ old('product_ratting') }}"
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
           placeholder="Ratting Count" value="{{ old('ratting_count') }}">
    @error('ratting_count')
    <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="col-md-2 mt-3">
    <label><b>Stock Sold </b></label>
    <input type="number" id="stock_sold" name="stock_sold" class="form-control"
           placeholder="Stock Sold" value="{{ old('stock_sold') }}">
    @error('stock_sold')
    <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="col-md-2 mt-3">
    <label><b>Stock Left </b></label>
    <input type="number" id="stock_left" name="stock_left" class="form-control"
           placeholder="Stock Left" value="{{ old('stock_left') }}">
    @error('stock_left')
    <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>

            <!-- Detail -->
            <div class="col-md-12 mt-3">
                <label><b>Detail </b><span class="strdngr">*</span></label>
                <textarea name="detail" class="form-control textarea" placeholder="Enter Product Details" required>{{ old('detail') }}</textarea>
                @error('detail')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="col-md-12">
    <label><b>Meta Title </b><span class="strdngr">* </span><small>(45-70 characters)</small></label>
    <input type="text" id="product_meta_title" name="meta_title" class="form-control"
        placeholder="Meta Title" value="{{ old('meta_title') }}" required maxlength="70">
    <small id="meta_title_count" class="text-muted">0 / 70 characters</small>

    @error('meta_title')
    <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="col-md-12 mt-3">
    <label><b>Meta Description </b><span class="strdngr">* </span><small>(70-155 characters)</small></label>
    <textarea id="product_meta_description" name="meta_description" class="form-control"
        placeholder="Meta Description" required maxlength="155" rows="3">{{ old('meta_description') }}</textarea>
    <small id="meta_description_count" class="text-muted">0 / 155 characters</small>

    @error('meta_description')
    <p class="help-block text-danger">{{ $message }}</p>
    @enderror
</div>

<script>
    function updateCount(id, counterId, min, max) {
        let input = document.getElementById(id);
        let counter = document.getElementById(counterId);

        input.addEventListener('input', function () {
            let length = input.value.length;
            counter.textContent = length + " / " + max + " characters";

            if (length < min || length > max) {
                counter.style.color = "red";
            } else {
                counter.style.color = "green";
            }
        });
    }

    // Meta Title: 50–60
    updateCount("product_meta_title", "meta_title_count", 45, 70);

    // Meta Description: 150–160
    updateCount("product_meta_description", "meta_description_count", 70, 155);
</script>

            
            <div class="col-md-12 mt-3">
                <label><b>Meta Keywords </b><span class="strdngr">*</span></label>
                <input type="text" id="product_meta_keywords" name="meta_keywords" class="form-control"
                    placeholder="Meta Keywords" value="{{ old('meta_keywords') }}" required>
                @error('meta_keywords')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="col-md-12 mt-3">
                <label><b>Schema </b></label>
                <textarea id="product_schema" name="page_schema" class="form-control"
                    placeholder="Schema" rows="4">{{ old('page_schema') }}</textarea>
                @error('page_schema')
                <p class="help-block text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-12 mt-3">
    <label><b>Product FAQs</b></label>

    <div id="faq_wrapper">

        <!-- default FAQ item -->
        <div class="faq_item row mb-2">
            <div class="col-md-5">
                <input type="text" name="faq_question[]" class="form-control" placeholder="FAQ Question">
            </div>
            <div class="col-md-6">
                <input type="text" name="faq_answer[]" class="form-control" placeholder="FAQ Answer">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger removeFaq"><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>

    </div>

    <button type="button" class="btn btn-success mt-2" id="addFaq">+ Add FAQ</button>
</div>

        </div>
    </div>
    <div class="card-footer text-center">
        <a href="/dashboard" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </div>
</form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!------ Start Footer -->
    @include('admin.includes.version')
    <!------ end Footer -->
    <!-- JavaScript for Dynamic Dropdowns -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        $("#addFaq").click(function () {
            $("#faq_wrapper").append(`
                <div class="faq_item row mb-2">
                    <div class="col-md-5">
                        <input type="text" name="faq_question[]" class="form-control" placeholder="FAQ Question">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="faq_answer[]" class="form-control" placeholder="FAQ Answer">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger removeFaq">X</button>
                    </div>
                </div>
            `);
        });

        $(document).on("click", ".removeFaq", function () {
            $(this).closest('.faq_item').remove();
        });

    });
</script>

<script>
    $(document).ready(function () {

        // Initialize Select2
        $('#cat_id, #sub_cat_id').select2({ width: '100%' });

        const oldCatId = '{{ old('cat_id') }}';
        const oldSubCatId = '{{ old('sub_cat_id') }}';

        function populateSubCategories(catId, preselectSubCatId = null) {
    var $subCat = $('#sub_cat_id');
    $subCat.empty().append('<option value="">Select Sub Category</option>');

    if (!catId) {
        $subCat.trigger('change.select2');
        return;
    }

    var url = '{{ url("get-sub-categories") }}/' + catId;

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $.each(data, function (i, sub) {
                var selected = (String(sub.sub_cat_id) === String(preselectSubCatId)) ? 'selected' : '';
                $subCat.append('<option value="' + sub.sub_cat_id + '" ' + selected + '>' + sub.sub_cat_name + '</option>');
            });

            $subCat.trigger('change.select2');
        },
        error: function (xhr) {
            console.error(xhr);
            alert('Failed to load sub categories');
        }
    });
}

        if (oldCatId) {
            $('#cat_id').val(oldCatId).trigger('change.select2');
            populateSubCategories(oldCatId, oldSubCatId);
        }

        $('#cat_id').on('change', function () {
            populateSubCategories($(this).val());
        });
    });
</script>

<script>
    $(document).ready(function () {

        // -------------------------------------------------
        // 7. Auto-generate slug when Product Name loses focus
        // -------------------------------------------------
        const $nameInput = $('#product_name');
        const $slugInput = $('#product_slug');

        // Helper: convert string → URL-safe slug
        function generateSlug(str) {
            return str
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')   // remove special chars
                .replace(/\s+/g, '-')           // spaces → dashes
                .replace(/-+/g, '-')            // collapse multiple dashes
                .replace(/^-+|-+$/g, '');       // trim dashes from start/end
        }

        // On blur (focus out) → generate slug **only if slug field is empty or unchanged**
        $nameInput.on('blur', function () {
            const name = $(this).val().trim();

            // If name is empty, do nothing
            if (!name) {
                $slugInput.val('');
                return;
            }

            // If slug is already filled and user hasn't edited it, generate it
            const currentSlug = $slugInput.val().trim();
            if (currentSlug === '' || currentSlug === generateSlug($nameInput.data('previousName') || '')) {
                const slug = generateSlug(name);
                $slugInput.val(slug);
            }

            // Remember the name we used to generate the slug
            $nameInput.data('previousName', name);
        });

        // Optional: Update slug on every keypress (live preview) – comment out if you only want on blur
        /*
        
        */
        $nameInput.on('input', function () {
            const name = $(this).val();
            if (name) {
                $slugInput.val(generateSlug(name));
            }
        });

        // Preserve old slug on page load (in case of validation error)
        @if(old('slug'))
            $slugInput.val('{{ old('slug') }}');
        @endif
    });
</script>
    <!------ Start Footer links -->
    @include('admin.includes.footer_links')
    <!------ end Footer links -->
  </div>
  <!-- ./wrapper -->
</body>
</html>