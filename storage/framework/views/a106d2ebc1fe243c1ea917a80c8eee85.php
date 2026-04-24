            <?php
            $countBlogs = DB::table('blogs')->count();
            $countProducts = DB::table('mk_products')->count();
            $countCategories = DB::table('mk_categories')->count();
            $countSubCategories = DB::table('mk_sub_categories')->count();
            ?>
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- Blogs -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="nav-icon fab fa-blogger"></i></span>
                                <a href="<?php echo e(route('market.add_blogs')); ?>">
                                    <div class="info-box-content">
                                        <span class="info-box-text">Blogs</span>
                                        <span class="info-box-number"><?php echo e($countBlogs); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Products -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="nav-icon fas fa-shopping-cart"></i></span>
                                <a href="<?php echo e(route('market.add_products')); ?>">
                                    <div class="info-box-content">
                                        <span class="info-box-text">Products</span>
                                        <span class="info-box-number"><?php echo e($countProducts); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary elevation-1"><i class="nav-icon fas fa-list"></i></span>
                                <a href="<?php echo e(route('market.add_category')); ?>">
                                    <div class="info-box-content">
                                        <span class="info-box-text">Categories</span>
                                        <span class="info-box-number"><?php echo e($countCategories); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Sub Categories -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-secondary elevation-1"><i class="nav-icon fas fa-sitemap"></i></span>
                                <a href="<?php echo e(route('market.add_sub_category')); ?>">
                                    <div class="info-box-content">
                                        <span class="info-box-text">Sub Categories</span>
                                        <span class="info-box-number"><?php echo e($countSubCategories); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content --><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/market/admin/dashboard.blade.php ENDPATH**/ ?>