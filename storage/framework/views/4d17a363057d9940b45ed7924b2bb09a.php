<!DOCTYPE html>
<html lang="en">
<?php $__env->startSection('title'); ?>
Add Product
<?php $__env->stopSection(); ?>
<!-- Start top links -->
<?php echo $__env->make('admin.includes.headlinks', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <style>
      .strdngr {
        color: red;
      }
    </style>
    <!-- Start navbar -->
    <?php echo $__env->make('admin.includes.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- end navbar -->

    <!-- Start Sidebar -->
    <?php echo $__env->make('admin.includes.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                  
                      
                      <?php echo $__env->make('admin.includes.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                      
                    
                        <!-- Add Product Form -->
                        <form action="<?php echo e(route('market.save_product')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="card-body">
        <div class="row">
            <!-- Category -->
            <div class="col-md-4">
                <label><b>Category </b><span class="strdngr">*</span></label>
                <select name="cat_id" id="cat_id" class="form-control select2" required>
                    <option value="">Select Category</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat->id); ?>" <?php echo e(old('cat_id') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->category_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['cat_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="help-block text-danger"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Sub Category -->
<div class="col-md-4">
    <label><b>Sub Category </b></label>
    <select name="sub_cat_id" id="sub_cat_id" class="form-control select2">
        <option value="">Select Sub Category</option>
        <!--  ←  ONLY the placeholder is rendered on the server  -->
    </select>
    <?php $__errorArgs = ['sub_cat_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="help-block text-danger"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
            
            <!-- Product Name -->
<div class="col-md-4">
    <label><b>Product Name </b><span class="strdngr">*</span></label>
    <input type="text" id="product_name" name="name" class="form-control"
           placeholder="Enter Product Name" value="<?php echo e(old('name')); ?>" required>
    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <p class="help-block text-danger"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
            <!-- Price -->
            <div class="col-md-2">
                <label><b>Price </b><span class="strdngr">*</span></label>
                <input type="number" name="price" class="form-control" placeholder="Enter Price" value="<?php echo e(old('price')); ?>" step="0.01" required>
                <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="help-block text-danger"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Price -->
            <div class="col-md-2">
                <label><b>Delivery Charges </b><span class="strdngr">*</span></label>
                <input type="number" name="delivery_charges" class="form-control" placeholder="Enter Delivery Charges" value="<?php echo e(old('delivery_charges', 150)); ?>" step="0.01" required>
                <?php $__errorArgs = ['delivery_charges'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="help-block text-danger"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Feature Picture -->
            <div class="col-md-4">
                <label><b>Feature Picture </b><span class="strdngr">*</span></label>
                <input type="file" name="pic" class="form-control" required>
                <?php $__errorArgs = ['pic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="help-block text-danger"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Additional Picture 1 -->
            <div class="col-md-4">
                <label><b>Picture 1 </b></label>
                <input type="file" name="pic1" class="form-control">
                <?php $__errorArgs = ['pic1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="help-block text-danger"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Additional Picture 2 -->
            <div class="col-md-4">
                <label><b>Picture 2 </b></label>
                <input type="file" name="pic2" class="form-control">
                <?php $__errorArgs = ['pic2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="help-block text-danger"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Additional Picture 3 -->
            <div class="col-md-4">
                <label><b>Picture 3 </b></label>
                <input type="file" name="pic3" class="form-control">
                <?php $__errorArgs = ['pic3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="help-block text-danger"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-md-4">
    <label><b>URL (Slug) </b><span class="strdngr">*</span></label>
    <input type="text" id="product_slug" name="slug" class="form-control"
           placeholder="product-slug" value="<?php echo e(old('slug')); ?>" required>
    <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <p class="help-block text-danger"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="col-md-3 mt-3">
    <label><b>Cutting Price </b></label>
    <input type="number" id="cutting_price" name="cutting_price" class="form-control"
           placeholder="Cutting Price" value="<?php echo e(old('cutting_price')); ?>">
    <?php $__errorArgs = ['cutting_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <p class="help-block text-danger"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="col-md-3 mt-3">
    <label><b>Ratting </b></label>
    <input type="number" 
           id="product_ratting" 
           name="product_ratting" 
           class="form-control"
           placeholder="Product Ratting" 
           value="<?php echo e(old('product_ratting')); ?>"
           step="0.1"   
           min="0" 
           max="5">     
    <?php $__errorArgs = ['product_ratting'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <p class="help-block text-danger"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div class="col-md-2 mt-3">
    <label><b>Ratting Count </b></label>
    <input type="number" id="ratting_count" name="ratting_count" class="form-control"
           placeholder="Ratting Count" value="<?php echo e(old('ratting_count')); ?>">
    <?php $__errorArgs = ['ratting_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <p class="help-block text-danger"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="col-md-2 mt-3">
    <label><b>Stock Sold </b></label>
    <input type="number" id="stock_sold" name="stock_sold" class="form-control"
           placeholder="Stock Sold" value="<?php echo e(old('stock_sold')); ?>">
    <?php $__errorArgs = ['stock_sold'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <p class="help-block text-danger"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="col-md-2 mt-3">
    <label><b>Stock Left </b></label>
    <input type="number" id="stock_left" name="stock_left" class="form-control"
           placeholder="Stock Left" value="<?php echo e(old('stock_left')); ?>">
    <?php $__errorArgs = ['stock_left'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <p class="help-block text-danger"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

            <!-- Detail -->
            <div class="col-md-12 mt-3">
                <label><b>Detail </b><span class="strdngr">*</span></label>
                <textarea name="detail" class="form-control textarea" placeholder="Enter Product Details" required><?php echo e(old('detail')); ?></textarea>
                <?php $__errorArgs = ['detail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="help-block text-danger"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <div class="col-md-12">
    <label><b>Meta Title </b><span class="strdngr">* </span><small>(45-70 characters)</small></label>
    <input type="text" id="product_meta_title" name="meta_title" class="form-control"
        placeholder="Meta Title" value="<?php echo e(old('meta_title')); ?>" required maxlength="70">
    <small id="meta_title_count" class="text-muted">0 / 70 characters</small>

    <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <p class="help-block text-danger"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="col-md-12 mt-3">
    <label><b>Meta Description </b><span class="strdngr">* </span><small>(70-155 characters)</small></label>
    <textarea id="product_meta_description" name="meta_description" class="form-control"
        placeholder="Meta Description" required maxlength="155" rows="3"><?php echo e(old('meta_description')); ?></textarea>
    <small id="meta_description_count" class="text-muted">0 / 155 characters</small>

    <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <p class="help-block text-danger"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                    placeholder="Meta Keywords" value="<?php echo e(old('meta_keywords')); ?>" required>
                <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="help-block text-danger"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <div class="col-md-12 mt-3">
                <label><b>Schema </b></label>
                <textarea id="product_schema" name="page_schema" class="form-control"
                    placeholder="Schema" rows="4"><?php echo e(old('page_schema')); ?></textarea>
                <?php $__errorArgs = ['page_schema'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="help-block text-danger"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
    <?php echo $__env->make('admin.includes.version', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

        const oldCatId = '<?php echo e(old('cat_id')); ?>';
        const oldSubCatId = '<?php echo e(old('sub_cat_id')); ?>';

        function populateSubCategories(catId, preselectSubCatId = null) {
    var $subCat = $('#sub_cat_id');
    $subCat.empty().append('<option value="">Select Sub Category</option>');

    if (!catId) {
        $subCat.trigger('change.select2');
        return;
    }

    var url = '<?php echo e(url("get-sub-categories")); ?>/' + catId;

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
        <?php if(old('slug')): ?>
            $slugInput.val('<?php echo e(old('slug')); ?>');
        <?php endif; ?>
    });
</script>
    <!------ Start Footer links -->
    <?php echo $__env->make('admin.includes.footer_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!------ end Footer links -->
  </div>
  <!-- ./wrapper -->
</body>
</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/market/admin/add_product.blade.php ENDPATH**/ ?>