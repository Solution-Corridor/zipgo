
    <div class="d-flex justify-content-center align-items-center">
        <div class="product-card-sm p-2" style="margin-bottom: 15px;">
            <div class="product-image-sm" style="text-align: center; object-fit: contain;">
                <a href="/product/<?php echo e($p->slug); ?>">
                    <img src="/uploads/market/products/<?php echo e($p->pic); ?>"
                         onerror="this.onerror=null; this.src='/assets/images/favicon.png';"
                         alt="<?php echo e($p->name); ?>"
                         title="<?php echo e($p->name); ?>">
                </a>
            </div>

            <div class="product-content-sm">
                <h3 class="title-sm">
                    <a href="/product/<?php echo e($p->slug); ?>">
                        <?php echo e(Str::limit($p->name, 32)); ?>

                    </a>
                </h3>

                <div style="margin-bottom: -15px;">
                    <p class="price-sm">
                        <small>Rs.</small> <?php echo e(number_format($p->price)); ?>

                    </p>
                    <p class="actions-sm"><a href="/product/<?php echo e($p->slug); ?>">Order Now</a></p>
                </div>

                
            </div>
        </div>
    </div><?php /**PATH E:\xampp\htdocs\zipGo\resources\views/includes/product_card_small.blade.php ENDPATH**/ ?>