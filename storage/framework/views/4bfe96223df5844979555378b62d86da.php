<!doctype html>
<html lang="en">

<head>
    <?php echo $__env->make('market.website.includes.header_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <title><?php echo e($product[0]->meta_title ?? $product[0]->name); ?> | Feature Desk</title>
    <meta name="description" content="<?php echo e($product[0]->meta_description ?? ''); ?>">
    <meta name="keywords" content="<?php echo e($product[0]->meta_keywords ?? ''); ?>">

    <meta property="og:title" content="<?php echo e($product[0]->meta_title ?? $product[0]->name); ?>">
    <meta property="og:description" content="<?php echo e($product[0]->meta_description ?? ''); ?>">

    <!-- Schema.org Structured Data (Product) -->
    <?php if(!empty($product[0]->page_schema)): ?>
    <?php echo $product[0]->page_schema; ?>

    <?php else: ?>
    <!-- Optional: Fallback basic Product schema if none provided -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "<?php echo e(addslashes($product[0]->name)); ?>",
    "image": [
        <?php
            $images = [];
            $baseUrl = env('APP_URL') . '/uploads/market/products/';

            if ($product[0]->pic)  $images[] = $baseUrl . $product[0]->pic;
            if ($product[0]->pic1) $images[] = $baseUrl . $product[0]->pic1;
            if ($product[0]->pic2) $images[] = $baseUrl . $product[0]->pic2;
            if ($product[0]->pic3) $images[] = $baseUrl . $product[0]->pic3;

            echo $images ? '"' . implode('",' . PHP_EOL . '        "', $images) . '"' : '';
        ?>
    ],
    "description": "<?php echo e(addslashes(strip_tags($product[0]->meta_description ?? ''))); ?>",
    "sku": "<?php echo e($product[0]->product_id ?? ''); ?>",
    "url": "<?php echo e(request()->fullUrl()); ?>",
    "offers": {
        "@type": "Offer",
        "priceCurrency": "PKR",
        "price": "<?php echo e($product[0]->price ?? '0'); ?>",
        "priceValidUntil": "<?php echo e(now()->addYear()->format('Y-m-d')); ?>",
        "availability": "https://schema.org/InStock",
        "url": "<?php echo e(request()->fullUrl()); ?>",
        "seller": {
            "@type": "Organization",
            "name": "Feature Desk"
        }
    },
    "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "<?php echo e($product[0]->product_ratting); ?>",  
    "reviewCount": "<?php echo e($product[0]->ratting_count); ?>"     
}
}
</script>
    <?php endif; ?>

    <style>
        /* ------------------------------------------------------------------ */
        /*  Base & Utility                                                    */
        /* ------------------------------------------------------------------ */
        :root {
            --primary: #3498db;
            --success: #27ae60;
            --danger: #e74c3c;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-500: #95a5a6;
            --gray-700: #555;
            --gray-900: #2c3e50;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 1200px;
        }

        /* ------------------------------------------------------------------ */
        /*  Product Gallery - SIMPLE FLEX FIX                                 */
        /* ------------------------------------------------------------------ */
        .product-gallery {
            margin-bottom: 2rem;
            width: 100%;
        }

        .featured-image-container {
            width: 100%;
            min-height: 450px;
            border-radius: .75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
            background: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border: 1px solid #eee;
        }

        .featured-image {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            display: block;
            transition: transform .3s ease;
        }

        .featured-image:hover {
            transform: scale(1.05);
        }

        .thumbnail-gallery {
            display: flex;
            gap: .75rem;
            margin-top: 1rem;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .thumbnail-container {
            width: 80px;
            height: 80px;
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: .5rem;
            overflow: hidden;
            transition: all .2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gray-100);
            flex-shrink: 0;
        }

        .thumbnail-container:hover,
        .thumbnail-container.active {
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .thumbnail-image {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            display: block;
        }

        /* ------------------------------------------------------------------ */
        /*  Product Info & Cart                                               */
        /* ------------------------------------------------------------------ */
        .product-info .badge {
            font-size: .85rem;
            padding: .35rem .75rem;
            border-radius: 1.5rem;
        }

        .price-box {
            display: flex;
            align-items: baseline;
            gap: .75rem;
            flex-wrap: wrap;
        }

        .price-current {
            font-size: 2rem;
            font-weight: 700;
            color: var(--danger);
        }

        .price-old {
            font-size: 1.2rem;
            color: var(--gray-500);
            text-decoration: line-through;
        }

        .stock-info {
            font-size: .95rem;
            margin-top: .5rem;
        }

        .stock-info.in-stock {
            color: var(--success);
        }

        .stock-info.low-stock {
            color: #e67e22;
        }

        .stock-info.out-stock {
            color: var(--danger);
        }

        .qty-selector {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin: 1rem 0;
        }

        .qty-btn {
            width: 38px;
            height: 38px;
            background: var(--gray-200);
            border: 1px solid #ddd;
            border-radius: .5rem;
            font-weight: bold;
            cursor: pointer;
            transition: background .2s;
        }

        .qty-btn:hover {
            background: #dee2e6;
        }

        .qty-input {
            width: 60px;
            height: 38px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: .5rem;
        }

        .cart-actions {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        .btn-cart,
        .btn-buy {
            flex: 1;
            min-width: 140px;
            padding: .75rem 1rem;
            font-weight: 600;
            text-align: center;
            border-radius: .5rem;
            transition: all .3s;
            border: none;
        }

        .btn-cart {
            background: var(--primary);
            color: #fff;
        }

        .btn-cart:hover {
            background: #2980b9;
        }

        .btn-buy {
            background: var(--success);
            color: #fff;
        }

        .btn-buy:hover {
            background: #219653;
        }

        .extra-info {
            margin-top: 1.5rem;
            font-size: .9rem;
            color: var(--gray-700);
            line-height: 1.6;
        }

        /* ------------------------------------------------------------------ */
        /*  Layout – Desktop (≥992px) - USING FLEX                            */
        /* ------------------------------------------------------------------ */
        @media (min-width: 992px) {
            .product-layout {
                display: flex;
                flex-direction: row;
                gap: 2rem;
                align-items: flex-start;
            }

            .gallery-col {
                flex: 1;
                max-width: 50%;
            }

            .info-col {
                flex: 1;
                max-width: 50%;
            }
        }

        /* ------------------------------------------------------------------ */
        /*  Layout – Mobile (<992px)                                          */
        /* ------------------------------------------------------------------ */
        @media (max-width: 991px) {
            .product-layout {
                display: flex;
                flex-direction: column;
            }

            .gallery-col,
            .info-col {
                max-width: 100%;
                width: 100%;
            }

            .featured-image-container {
                min-height: 350px;
            }

            .thumbnail-container {
                width: 70px;
                height: 70px;
            }

            .price-current {
                font-size: 1.75rem;
            }
        }

        /* ------------------------------------------------------------------ */
        /*  Debug styles - REMOVE AFTER FIX                                   */
        /* ------------------------------------------------------------------ */
        .featured-image-container {
            background: #f8f9fa !important;
        }

        .featured-image {
            /* border: 2px solid #3498db !important; */
        }

        /* ------------------------------------------------------------------ */
        /*  Latest Products (bottom)                                          */
        /* ------------------------------------------------------------------ */
        .latest-products .row {
            --bs-gutter-x: 1rem;
        }

        .latest-products h3 {
            font-weight: 600;
            color: var(--gray-900);
        }
    </style>
</head>

<body>
    <?php echo $__env->make('market.website.includes.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <style>
        .product_title {
    display: none;
}
        @media (max-width: 768px) {
            .breadcrumb_section {
                display: none;
            } 
            .product_section{
               margin-top:70px; padding: 15px 0; 
            }   
            .product_title{
            display: block !important;
        }        
        }
        
    </style>
    <section class="bg-light border-bottom breadcrumb_section" style="margin-top:70px; padding: 15px 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-8">

                    
                    <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0 bg-transparent p-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(url('/')); ?>" class="text-decoration-none text-muted">
                <i class="fas fa-home me-1"></i> Home
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="<?php echo e(url('/categories')); ?>" class="text-decoration-none text-muted">
                Categories
            </a>
        </li>

        <?php if(!empty($product[0]->category_url)): ?>
            <li class="breadcrumb-item">
                <a href="<?php echo e(url('/' . $product[0]->category_url)); ?>" class="text-decoration-none text-muted">
                    <?php echo e($product[0]->category_name); ?>

                </a>
            </li>
        <?php endif; ?>

        <?php if(!empty($product[0]->sub_category_url)): ?>
            <li class="breadcrumb-item">
                <a href="<?php echo e(url('/' . $product[0]->category_url . '/' . $product[0]->sub_category_url)); ?>" class="text-decoration-none text-muted">
                    <?php echo e($product[0]->sub_category_name); ?>

                </a>
            </li>
        <?php endif; ?>

        <li class="breadcrumb-item active text-success" aria-current="page">
            <?php echo e($product[0]->name); ?>

        </li>
    </ol>
</nav>


                </div>

            </div>

            
            <div class="mt-3">
                <h1 class="h3 mb-0 fw-bold text-dark">
                    <?php echo e($product[0]->name ?? ''); ?>

                </h1>
                <?php if(!empty($product[0]->meta_description)): ?>
                <p class="text-muted mt-2 mb-0"><?php echo e($product[0]->meta_description); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    

    <!-- ==================== PRODUCT DETAIL ==================== -->
    <section class="py-2 product_section">
        <div class="container">
            <div class="product-layout">

                <!-- ==== GALLERY ==== -->
                <div class="gallery-col">
                    <div class="product-gallery">
                        <div class="featured-image-container text-center">
                            <!-- TEST: First try with a direct absolute path -->
                            <img class="featured-image"
                                src="<?php echo e(url('/uploads/market/products/' . $product[0]->pic)); ?>"
                                onerror="
                    console.log('Image error:', this.src);
                    this.onerror=null; 
                    this.src='/assets/images/favicon.png';"
                                alt="<?php echo e($product[0]->name ?? 'Product'); ?>"
                                title="<?php echo e($product[0]->name ?? 'Product'); ?>"
                                style="max-width: 100%; height: auto;">
                            
                        </div>

                        <!-- Rest of your thumbnail code remains the same -->
                        <div class="thumbnail-gallery">
                            <?php
                            $imgs = [$product[0]->pic ?? null, $product[0]->pic1 ?? null,
                            $product[0]->pic2 ?? null, $product[0]->pic3 ?? null];
                            $activeSet = false;
                            ?>
                            <?php $__currentLoopData = $imgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($img): ?>
                            <div class="thumbnail-container <?php echo e(!$activeSet ? 'active' : ''); ?>"
                                data-image="<?php echo e(url('/uploads/market/products/' . $img)); ?>">
                                <img class="thumbnail-image"
                                    src="<?php echo e(url('/uploads/market/products/' . $img)); ?>"
                                    alt="<?php echo e($product[0]->name ?? 'Product'); ?> - <?php echo e($i+1); ?>"
                                    title="<?php echo e($product[0]->name ?? 'Product'); ?> - <?php echo e($i+1); ?>"
                                    onerror="this.style.display='none'">
                            </div>
                            <?php $activeSet = true; ?>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!$activeSet): ?>
                            <div class="thumbnail-container active" data-image="/assets/images/favicon.png">
                                <img class="thumbnail-image" src="/assets/images/favicon.png" alt="Dummy" title="Dummy Image">
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- rating + feedback  -->
                     <!-- rating + feedback -->

                     <style>
                        .star {
    transition: all 0.2s ease;
}
.star:hover {
    transform: scale(1.15);
}
                     </style>
<div class="rating-feedback-section mt-4 pt-4 border-top">
    <h5 class="mb-3 fw-semibold">
        <i class="fas fa-star text-warning me-2"></i> 
        Rate this Product
    </h5>

    <!-- Star Rating Input -->
    <div class="mb-4">
        <div class="d-flex align-items-center gap-1" id="starRating">
            <?php for($i = 1; $i <= 5; $i++): ?>
                <i class="fa-regular fa-star fa-2x text-warning star" 
                   data-value="<?php echo e($i); ?>" 
                   style="cursor: pointer;"></i>
            <?php endfor; ?>
        </div>
        <input type="hidden" name="rating" id="selectedRating" value="0">
        <small class="text-muted" id="ratingText"></small>
    </div>

    <!-- Feedback / Review Section -->
<div class="mb-4">
    <label for="reviewer_name" class="form-label fw-medium">Your Name</label>
    <input type="text" 
           class="form-control" 
           id="reviewer_name" 
           placeholder="Enter your name (optional)"
           maxlength="100">
</div>

<!-- Feedback / Review Textarea -->
<div class="mb-3">
    <label for="feedback" class="form-label fw-medium">Your Feedback (Optional)</label>
    <textarea class="form-control" 
              id="feedback" 
              rows="4" 
              placeholder="What did you like or dislike about this product? How was the quality?"></textarea>
</div>

    <!-- Submit Button -->
    <button type="button" class="btn btn-primary px-4" id="submitReviewBtn">
        <i class="fas fa-paper-plane me-2"></i> Submit Rating & Feedback
    </button>

    <div id="reviewMessage" class="mt-3"></div>
</div>
                     
                </div>


                <!-- ==== INFO + CART ==== -->
                <div class="info-col">
                         <div class="h4 mb-0 me-2 product_title fw-bold"><?php echo e($product[0]->name ?? ''); ?></div>
                    <!-- ====== DYNAMIC RATING & REVIEW SECTION ====== -->
                    <div class="d-flex align-items-center mb-3">
                                               
                        <!-- Star Rating + Score -->
                        <div class="me-3">
                            <?php
                            $rating = $product[0]->product_ratting ?? 4.8;
                            $fullStars = floor($rating);
                            $hasHalfStar = ($rating - $fullStars) >= 0.5;
                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);

                            // Dynamic positive feedback % (realistic formula)
                            $positiveFeedback = round(80 + ($rating - 3.5) * 40); // 3.5 → ~80%, 5.0 → ~100%
                            $positiveFeedback = min(99, max(80, $positiveFeedback)); // clamp between 80–99%
                            ?>

                            <span class="text-warning fs-5">
                                <?php for($i = 1; $i <= $fullStars; $i++): ?>
                                    <i class="fa-solid fa-star"></i>
                                    <?php endfor; ?>
                                    <?php if($hasHalfStar): ?>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <?php endif; ?>
                                    <?php for($i = 1; $i <= $emptyStars; $i++): ?>
                                        <i class="fa-regular fa-star"></i>
                                        <?php endfor; ?>
                            </span>
                            <strong class="ms-1" style="font-size: 1.4rem; color: #2c3e50;">
                                <?php echo e(number_format($rating, 1)); ?>

                            </strong>
                        </div>

                        <!-- Review Count + Link -->
                        <div class="text-muted" style="font-size: 0.95rem;">
                            <a target="_blank" href="/product/<?php echo e($product[0]->slug); ?>/reviews" class="text-primary text-decoration-none fw-medium">
                                <strong><?php echo e(number_format($product[0]->ratting_count ?? 0)); ?></strong> reviews
                            </a>
                        </div>
                    </div>

                    <!-- Dynamic Positive Feedback (Now changes per product!) -->
                    <div class="mb-3 text-success small">
                        <i class="fas fa-check-circle"></i>
                        <strong><?php echo e($positiveFeedback); ?>% positive feedback</strong> from buyers
                    </div>

                    <!-- Badges -->
                    <div class="product-info mb-3">
                        <span class="badge bg-primary me-2"><?php echo e($product[0]->category_name ?? ''); ?></span>
                        <span class="badge bg-primary me-2"><?php echo e($product[0]->sub_category_name ?? ''); ?></span>
                        <span class="badge bg-primary"><?php echo e($product[0]->quality_name ?? ''); ?></span>
                    </div>

                    <!-- Price -->
                    <div class="price-box mb-3">
                        <div class="price-current">
                            Rs. <?php echo e(number_format($product[0]->price ?? 0)); ?>

                        </div>
                        <?php if($product[0]->cutting_price ?? 0): ?>
                        <div class="price-old">
                            Rs. <?php echo e(number_format($product[0]->cutting_price, 0)); ?>

                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Stock Info (using your filled fake data) -->
                    <?php
                    $sold = $product[0]->stock_sold ?? 842;
                    $left = $product[0]->stock_left ?? 18;
                    $totalStock = $sold + $left;
                    $stockClass = $left > 10 ? 'in-stock' : ($left > 0 ? 'low-stock' : 'out-stock');
                    $stockText = $left > 10 ? 'In Stock' : ($left > 0 ? "Only $left left – order soon!" : 'Out of Stock');
                    ?>
                    <div class="stock-info <?php echo e($stockClass); ?> mb-3">
                        <strong><?php echo e($stockText); ?></strong>
                        <div class="text-muted small mt-1">
                            <?php echo e(number_format($sold)); ?> sold this month
                        </div>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="qty-selector mb-4">
                        <button type="button" class="qty-btn minus">-</button>
                        <input type="number" class="qty-input" value="1" min="1" max="<?php echo e($left > 0 ? $left : 1); ?>">
                        <button type="button" class="qty-btn plus">+</button>
                    </div>

                    <!-- Action Buttons -->
                    
<p style="font-size: 1.0rem; margin-bottom: 0; font-weight: 700; color:#F2AD0C;">
    <?php if(auth()->guard()->check()): ?>
    Balance: Rs. <?php echo e(number_format(Auth::user()->balance, 0)); ?>

    <?php endif; ?>
</p>
<div class="cart-actions">
    <!-- <a href="#" 
       class="btn-buy" 
       id="whatsappOrderBtn" 
       style="display: <?php echo e($left <= 0 ? 'none' : 'block'); ?>; text-decoration: none;" 
       <?php echo e($left <= 0 ? 'onclick="return false;"' : ''); ?>>
        WHATSAPP ORDER
    </a> -->
    
    <button class="btn-cart" id="buyNowBtn"
        data-buy-url="<?php echo e(route('market.buynow', $product[0]->product_id)); ?>"
        <?php echo e($left <= 0 ? 'disabled' : ''); ?>>
        Buy Now
    </button>
</div>
 <p class="extra-info">
    <i class="fas fa-info-circle me-1"></i>
    Note: Delivery times may vary based on your location and current stock levels. Please contact us via WhatsApp for the most accurate delivery estimates and any urgent inquiries.
</p>
<!-- If you want to show a disabled version when out of stock (optional) -->
<div id="outOfStockMsg" class="text-danger mt-2" style="display: <?php echo e($left <= 0 ? 'block' : 'none'); ?>;">
    Out of Stock – Contact via WhatsApp for restock alerts
</div>

                    

                    <!-- Description -->
                    <div class="article-content mt-4">
                        <?php echo $product[0]->detail ?? ''; ?>

                    </div>
                    
                
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== LATEST PRODUCTS ==================== -->
    <section class="latest-products py-5 --gray-100">
        <div class="containerrrrr">
            <h3 class="text-center mb-4">Latest Products</h3>
            <div id="products-container" class="products-grid-sm">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('market.website.includes.product_card_small', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>


    <?php echo $__env->make('market.website.includes.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('market.website.includes.footer_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- ==================== JS ==================== -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            /* ---- Thumbnail Switch ---- */
            const thumbnails = document.querySelectorAll('.thumbnail-container');
            const featuredImg = document.querySelector('.featured-image');

            thumbnails.forEach(t => {
                t.addEventListener('click', () => {
                    thumbnails.forEach(x => x.classList.remove('active'));
                    t.classList.add('active');
                    featuredImg.src = t.dataset.image;
                });
            });

            /* ---- Quantity Selector ---- */
            const qtyInput = document.querySelector('.qty-input');
            const minusBtn = document.querySelector('.qty-btn.minus');
            const plusBtn = document.querySelector('.qty-btn.plus');
            const maxStock = <?php echo json_encode($stock ?? 12, 15, 512) ?>;

            const clampQty = () => {
                let val = parseInt(qtyInput.value) || 1;
                if (val < 1) val = 1;
                if (val > maxStock) val = maxStock;
                qtyInput.value = val;
            };

            minusBtn.addEventListener('click', () => {
                if (parseInt(qtyInput.value) > 1) qtyInput.value--;
                clampQty();
            });

            plusBtn.addEventListener('click', () => {
                if (parseInt(qtyInput.value) < maxStock) qtyInput.value++;
                clampQty();
            });

            qtyInput.addEventListener('change', clampQty);

            /* ---- Buy Now – Real Redirect ---- */
            document.getElementById('buyNowBtn')?.addEventListener('click', function() {
                if (this.disabled) return;

                const qty = qtyInput.value;
                let url = this.dataset.buyUrl;

                const separator = url.includes('?') ? '&' : '?';
                url += separator + 'qty=' + qty;

                window.location.href = url;
            });


            /* ---- WhatsApp Order Button ---- */
const whatsappBtn = document.getElementById('whatsappOrderBtn');
if (whatsappBtn) {
    const phoneNumber = '+447412803448'; // Change if needed (no + , no spaces/dashes)
    const productName = '<?php echo e(addslashes($product[0]->name)); ?>';
    const productPrice = '<?php echo e($product[0]->price ?? 0); ?>';
    const productUrl = '<?php echo e(request()->fullUrl()); ?>';

    function updateWhatsAppLink() {
        const qty = qtyInput.value;
        const messageLines = [
            `Hi! I'm interested in ordering:`,
            ``,
            `Product: *${productName}*`,
            `Price: Rs. *${productPrice}*`,
            `Quantity: *${qty}*`,
            `Total: Rs. *${(productPrice * qty).toLocaleString()}*`,
            ``,
            `Link: ${productUrl}`,
            ``,
            `Please confirm availability and payment/delivery details. Thanks!`
        ];
        const message = messageLines.join('\n');
        const encodedMessage = encodeURIComponent(message);
        const waLink = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
        whatsappBtn.href = waLink;
    }

    // Initial set
    updateWhatsAppLink();

    // Update when quantity changes
    minusBtn.addEventListener('click', updateWhatsAppLink);
    plusBtn.addEventListener('click', updateWhatsAppLink);
    qtyInput.addEventListener('change', updateWhatsAppLink);
}


// ====================== STAR RATING + FEEDBACK ======================
const stars = document.querySelectorAll('#starRating .star');
const selectedRatingInput = document.getElementById('selectedRating');
const ratingText = document.getElementById('ratingText');
const submitBtn = document.getElementById('submitReviewBtn');
const reviewMessage = document.getElementById('reviewMessage');
const feedbackTextarea = document.getElementById('feedback');
const reviewerNameInput = document.getElementById('reviewer_name');   // ← Correct reference

let currentRating = 0;

// Hover & Click on Stars
stars.forEach(star => {
    star.addEventListener('mouseover', () => {
        const value = parseInt(star.dataset.value);
        highlightStars(value);
    });

    star.addEventListener('mouseout', () => {
        highlightStars(currentRating);
    });

    star.addEventListener('click', () => {
        currentRating = parseInt(star.dataset.value);
        selectedRatingInput.value = currentRating;
        highlightStars(currentRating);
        updateRatingText(currentRating);
    });
});

function highlightStars(rating) {
    stars.forEach(star => {
        const value = parseInt(star.dataset.value);
        if (value <= rating) {
            star.classList.remove('fa-regular');
            star.classList.add('fa-solid');
        } else {
            star.classList.remove('fa-solid');
            star.classList.add('fa-regular');
        }
    });
}

function updateRatingText(rating) {
    const texts = {
        1: "Very Poor",
        2: "Poor",
        3: "Average",
        4: "Good",
        5: "Excellent"
    };
    ratingText.textContent = rating > 0 ? texts[rating] + ` (${rating}/5)` : '';
}

// Submit Review
submitBtn.addEventListener('click', function() {
    const rating = parseInt(selectedRatingInput.value);
    const feedback = feedbackTextarea.value.trim();
    const reviewerName = reviewerNameInput.value.trim();   // ← Correct way

    if (rating === 0) {
        reviewMessage.innerHTML = `<div class="alert alert-danger">Please select at least 1 star rating.</div>`;
        return;
    }

    // Disable button while submitting
    submitBtn.disabled = true;
    submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span> Submitting...`;

    // Send via AJAX
    fetch('<?php echo e(route("market.submit.review")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
            product_id: <?php echo e($product[0]->product_id); ?>,
            rating: rating,
            reviewer_name: reviewerName,
            review: feedback
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            reviewMessage.innerHTML = `<div class="alert alert-success">Thank you! Your review has been submitted successfully.</div>`;
            
            // Reset form after success
            setTimeout(() => {
                selectedRatingInput.value = 0;
                currentRating = 0;
                highlightStars(0);
                ratingText.textContent = '';
                feedbackTextarea.value = '';
                reviewerNameInput.value = '';        // ← Now correctly cleared
                reviewMessage.innerHTML = '';
            }, 2500);
        } else {
            reviewMessage.innerHTML = `<div class="alert alert-danger">${data.message || 'Something went wrong.'}</div>`;
        }
    })
    .catch(err => {
        reviewMessage.innerHTML = `<div class="alert alert-danger">Failed to submit review. Please try again.</div>`;
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = `<i class="fas fa-paper-plane me-2"></i> Submit Rating & Feedback`;
    });
});

            
        });
    </script>
</body>

</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/market/website/product_detail.blade.php ENDPATH**/ ?>