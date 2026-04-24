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
                      <div class="card card-primary">
                        <!-- Product Table -->
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>Sr#</th>
                              <th>Picture</th>
                              <th>Name</th>
                              <th>Price</th>
                              <th>Category</th>
                              <th>Sub Category</th>
                              <th>Created At</th>
                              <th>SEO</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td><?php echo e($product->product_id); ?></td>
                              <td>
                                <a target="_blank" href="/product/<?php echo e($product->slug); ?>">
                                  <img src="/uploads/market/products/<?php echo e($product->pic); ?>" alt="<?php echo e($product->name); ?>" style="width: 50px; height: 50px;">
                                </a>
                              </td>
                              <td>
                                <a target="_blank" href="/product/<?php echo e($product->slug); ?>">
                                  <?php echo e($product->name); ?>

                                </a>
                              </td>
                              <td><?php echo e(number_format($product->price)); ?></td>
                              <td>
                                <a target="_blank" href="/<?php echo e($product->category_url); ?>">
                                <?php echo e($product->category_name); ?>

                                </a>
                              </td>
                              <td>
                                <a target="_blank" href="/<?php echo e($product->category_url); ?>/<?php echo e($product->sub_category_url); ?>">
                                <?php echo e($product->sub_category_name); ?>

                                </a>
                              </td>
                              <td><?php echo e(\Carbon\Carbon::parse($product->created_at)->format('d-m-Y')); ?></td>

                              <td>
        <?php
            $titleCount = strlen($product->meta_title ?? '');
            $descriptionCount = strlen($product->meta_description ?? '');
        ?>

        
        <?php if(!empty($product->meta_title)): ?>
            <i class="fa fa-check-circle text-success"></i> 
            Title (<?php echo e($titleCount); ?> characters)
        <?php else: ?>
            <i class="fa fa-times-circle text-danger"></i> 
            Title (0 characters)
        <?php endif; ?>
        <br>

        
        <?php if(!empty($product->meta_description)): ?>
            <i class="fa fa-check-circle text-success"></i> 
            Description (<?php echo e($descriptionCount); ?> characters)
        <?php else: ?>
            <i class="fa fa-times-circle text-danger"></i> 
            Description (0 characters)
        <?php endif; ?>
        <br>

        
        <?php if(!empty($product->page_schema)): ?>
            <i class="fa fa-check-circle text-success"></i> Schema
        <?php else: ?>
            <i class="fa fa-times-circle text-danger"></i> Schema
        <?php endif; ?>
        <br>

        
        <?php if(!empty($product->meta_keywords)): ?>
            <i class="fa fa-check-circle text-success"></i> Keywords
        <?php else: ?>
            <i class="fa fa-times-circle text-danger"></i> Keywords
        <?php endif; ?>
    </td>

                              <td>
                                <a href="<?php echo e(route('market.edit_product', $product->product_id)); ?>" class="btn btn-xs btn-primary">
                                  <i class="fa fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('market.delete_product', $product->product_id)); ?>" method="POST" style="display:inline-block;">
                                  <?php echo csrf_field(); ?>
                                  <?php echo method_field('DELETE'); ?>
                                  <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this product?');"><i class="fa fa-trash"></i></button>
                                </form>
                              </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>
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
    
    <!------ Start Footer links -->
    <?php echo $__env->make('admin.includes.footer_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!------ end Footer links -->
  </div>
  <!-- ./wrapper -->
</body>
</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/market/admin/all_products.blade.php ENDPATH**/ ?>