<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MarketWelcome extends Controller
{
    public function recharge()
    {
        return view('market.website.recharge');
    }
    public function fill_data()
    {
        $updated = DB::table('mk_products')
            ->where(function ($query) {
                $query->whereNull('stock_sold')
                    ->orWhereNull('stock_left');
            })
            ->update([
                'stock_sold' => DB::raw('FLOOR(87 + RAND() * (1240 - 87 + 1))'),   // 87 to 1240
                'stock_left' => DB::raw('FLOOR(8 + RAND() * (180 - 8 + 1))')        // 8 to 180
            ]);

        return response()->json([
            'success'      => true,
            'message'      => "Successfully filled stock_sold (87–1240) and stock_left (8–180) for {$updated} products",
            'updated_rows' => $updated
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = [];

        if ($query) {
            $products = DB::table('mk_products')
                ->leftJoin('mk_categories', 'mk_products.cat_id', '=', 'mk_categories.id')
                ->leftJoin('mk_sub_categories', 'mk_products.sub_cat_id', '=', 'mk_sub_categories.sub_cat_id')
                ->where(function ($q) use ($query) {
                    $q->where('mk_products.name', 'LIKE', "%{$query}%")
                        ->orWhere('mk_categories.category_name', 'LIKE', "%{$query}%")
                        ->orWhere('mk_sub_categories.sub_cat_name', 'LIKE', "%{$query}%");
                })
                ->select(
                    'mk_products.*',
                    'mk_categories.category_name as category_name',
                    'mk_sub_categories.sub_cat_name as sub_category_name'
                )
                ->paginate(12);
        }

        return view('market.website.search', compact('products', 'query'));
    }

    public function index()
    {
        $products = DB::table('mk_products')
            ->leftJoin('mk_categories', 'mk_products.cat_id', '=', 'mk_categories.id')
            ->leftJoin('mk_sub_categories', 'mk_products.sub_cat_id', '=', 'mk_sub_categories.sub_cat_id')
            ->select(
                'mk_products.*',
                'mk_categories.category_name as category_name',
                'mk_sub_categories.sub_cat_name as sub_category_name'
            )
            ->orderByRaw('RAND()')
            ->limit(20)
            ->get();

        $categories = DB::table('mk_categories')->get();

        return view('market.website.index', compact('products', 'categories'));
    }

    public function categories()
    {
        $categories = DB::table('mk_categories')->get();

        $products = $this->queryProducts()
            ->limit(self::PER_PAGE)
            ->get();

        return view('market.website.categories', [
            'categories' => $categories,
            'products' => $products
        ]);
    }

    /** Page size */
    const PER_PAGE = 40;

    /** Initial page */
    public function products()
    {
        $products = $this->queryProducts()
            ->limit(self::PER_PAGE)
            ->get();

        return view('market.website.products', [
            'products' => $products,
            'page'     => 1,               // current page (for JS)
            'hasMore'  => $this->hasMore(1), // true if there are >12 rows
        ]);
    }

    public function best_selling()
    {
        $products = $this->queryProducts()
            ->where('mk_products.stock_sold', '>', 1000)
            ->reorder()                     // clear any default ordering
            ->orderByRaw('RAND()')          // reliable random ordering
            ->limit(self::PER_PAGE)
            ->get();

        return view('market.website.best_selling', [
            'products' => $products,
            'page'     => 1,
            'hasMore'  => $this->hasMore(1),
        ]);
    }



    public function five_stars()
    {
        $products = $this->queryProducts()
            ->whereIn('product_ratting', [5, 5.0])
            ->reorder()                     // clear any default ordering
            ->orderByRaw('RAND()')          // reliable random ordering
            ->limit(self::PER_PAGE)
            ->get();

        return view('market.website.five_stars', [
            'products' => $products,
            'page'     => 1,
            'hasMore'  => $this->hasMore(1),
        ]);
    }



    public function new_products()
    {
        $tenDaysAgo = Carbon::now()->subDays(20);

        $products = $this->queryProducts()
            ->where('mk_products.created_at', '>=', $tenDaysAgo)
            ->reorder()               // remove old orderings
            ->inRandomOrder()         // works fine if no other order exists
            ->limit(self::PER_PAGE)
            ->get();

        return view('market.website.new_products', [
            'products' => $products,
            'page'     => 1,
            'hasMore'  => $this->hasMore(1),
        ]);
    }



    public function loadMoreProducts()
    {
        $page = (int) request('page', 1);
        $next = $page + 1;

        $products = $this->queryProducts()
            ->forPage($next, self::PER_PAGE)
            ->get();

        $hasMore = $this->hasMore($next);

        // Render each product card individually
        $html = '';
        $html = '';
        foreach ($products as $p) {
            $cardHtml = view('market.website.includes.product_card_small', ['p' => $p])->render();
            $html .= '<div class="col-md-2">' . $cardHtml . '</div>';
        }

        return response()->json([
            'html'     => $html,
            'hasMore'  => $hasMore,
            'nextPage' => $hasMore ? $next : null,
        ]);
    }


    /** Re-usable query */
    private function queryProducts()
    {
        return DB::table('mk_products')
            ->leftJoin('mk_categories', 'mk_products.cat_id', '=', 'mk_categories.id')
            ->leftJoin('mk_sub_categories', 'mk_products.sub_cat_id', '=', 'mk_sub_categories.sub_cat_id')
            ->select(
                'mk_products.*',
                'mk_categories.category_name as category_name',
                'mk_sub_categories.sub_cat_name as sub_category_name'
            )
            ->orderBy('mk_products.product_id'); // <-- important for consistent pagination
    }

    /** Helper: are there more rows after the given page? */
    private function hasMore(int $page): bool
    {
        $offset = $page * self::PER_PAGE;
        return DB::table('mk_products')
            ->offset($offset)
            ->limit(1)
            ->exists();
    }



    public function product_detail($slug)
    {
        // Fetch the product with related category, subcategory, and quality names
        $product = DB::table('mk_products')
            ->leftJoin('mk_categories', 'mk_products.cat_id', '=', 'mk_categories.id')
            ->leftJoin('mk_sub_categories', 'mk_products.sub_cat_id', '=', 'mk_sub_categories.sub_cat_id')
            ->where('mk_products.slug', '=', $slug)
            ->select(
                'mk_products.*',
                'mk_categories.category_name as category_name',
                'mk_categories.url as category_url',
                'mk_sub_categories.sub_cat_name as sub_category_name',
                'mk_sub_categories.sub_cat_url as sub_category_url'
            )
            ->get();
        // Fetch the latest 10 products (unchanged)
        $products = DB::table('mk_products')
            ->where('product_id', '!=', $product->first()->product_id ?? 0)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('market.website.product_detail', [
            'product' => $product,
            'products' => $products
        ]);
    }


public function submitReview(Request $request)
{
    $request->validate([
        'product_id'    => 'required|exists:mk_products,product_id',
        'rating'        => 'required|integer|min:1|max:5',
        'reviewer_name' => 'nullable|string|max:100',
        'review'        => 'nullable|string|max:1000',
    ]);

    $productId = $request->product_id;
    $rating    = (int) $request->rating;
    $review    = $request->review;
    $name      = $request->reviewer_name;

    // Get logged-in user ID (null for guests)
    $userId = auth()->check() ? auth()->id() : null;

    // Auto-fill name if user is logged in and didn't provide one
    if ($userId && empty($name)) {
        $name = auth()->user()->name ?? 'Verified Buyer';
    }

    // Prevent duplicate reviews from the same logged-in user
    if ($userId) {
        $existing = DB::table('mk_product_reviews')
                    ->where('product_id', $productId)
                    ->where('user_id', $userId)
                    ->exists();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product.'
            ]);
        }
    }

    // Insert the review using DB facade
    DB::table('mk_product_reviews')->insert([
        'product_id'    => $productId,
        'user_id'       => $userId,
        'reviewer_name' => $name ?? 'Anonymous',
        'rating'        => $rating,
        'review'        => $review,
        'approved'      => 1,                    // Change to 0 if you want manual approval
        'created_at'    => now(),
        'updated_at'    => now(),
    ]);

    // === Recalculate and update product rating & count ===
    $stats = DB::table('mk_product_reviews')
                ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as review_count')
                ->where('product_id', $productId)
                ->where('approved', 1)
                ->first();

    $newAvgRating = $stats->avg_rating ? round($stats->avg_rating, 1) : 0;
    $newReviewCount = $stats->review_count ?? 0;

    DB::table('mk_products')
        ->where('product_id', $productId)
        ->update([
            'product_ratting' => $newAvgRating,
            'ratting_count'   => $newReviewCount,
            'updated_at'      => now(),
        ]);

    return response()->json([
        'success' => true,
        'message' => 'Thank you! Your review has been submitted successfully.'
    ]);
}

    public function product_reviews($slug)
    {
        // Fetch the product with related category, subcategory, and quality names
        $product = DB::table('mk_products')
            ->leftJoin('mk_categories', 'mk_products.cat_id', '=', 'mk_categories.id')
            ->leftJoin('mk_sub_categories', 'mk_products.sub_cat_id', '=', 'mk_sub_categories.sub_cat_id')
            ->where('mk_products.slug', '=', $slug)
            ->select(
                'mk_products.*',
                'mk_categories.category_name as category_name',
                'mk_sub_categories.sub_cat_name as sub_category_name'
            )
            ->get();
        // Fetch the latest 10 products (unchanged)
        $products = DB::table('mk_products')
            ->where('product_id', '!=', $product->first()->product_id ?? 0)
            ->orderByDesc('product_id')
            ->limit(5)
            ->get();

        return view('market.website.product_reviews', [
            'product' => $product,
            'products' => $products
        ]);
    }

    public function contact()
    {
        return view('market.website.contact_us');
    }

    public function help_center()
    {
        return view('market.website.help_center');
    }

    public function shopping_info()
    {
        return view('market.website.shopping_info');
    }

    public function returns_refunds()
    {
        return view('market.website.returns_refunds');
    }

    public function faqs()
    {
        return view('market.website.faqs');
    }

    public function track_order()
    {
        return view('market.website.track_order');
    }

    // In your OrderController.php
    public function trackOrder(Request $request)
    {
        $searchQuery = $request->input('search_query');

        // Search in mk_orders table by id or phone
        $orders = DB::table('mk_orders')
            ->leftJoin('mk_products', 'mk_orders.product_id', '=', 'mk_products.product_id')
            ->where('mk_orders.id', $searchQuery)
            ->orWhere('mk_orders.phone', $searchQuery)
            ->select(
                'mk_orders.id',
                'mk_orders.created_at',
                'mk_orders.product_id',
                'mk_products.name as product_name',
                'mk_orders.total_price',
                'mk_orders.status'
            )
            ->orderBy('mk_orders.id', 'desc')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No orders found with the provided information.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Orders found successfully.',
            'orders' => $orders
        ]);
    }

    public function careers()
    {
        return view('market.website.career');
    }

    public function privacy_policy()
    {
        return view('market.website.privacy_policy');
    }

    public function term_of_services()
    {
        return view('market.website.term_of_services');
    }

    public function cookie_policy()
    {
        return view('market.website.cookie_policy');
    }

    public function buynow($id)
    {
        $product = DB::table('mk_products')
            ->where('product_id', $id)
            ->first();

        if (!$product) {
            abort(404, 'Product not found');
        }

        return view('market.website.buy_now', compact('product'));
    }

    public function orderNow(Request $request)
    {
        // Validate input
        $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'quantity'  => 'required|integer|min:1',
            'address'   => 'required|string',
            'product_id' => 'required|integer',
            'total_price' => 'required|numeric',
        ]);
        // Auth user balance check
        $userBalance = DB::table('users')
            ->where('id', Auth::id())
            ->value('balance');
        if ($userBalance < $request->total_price) {
            return redirect()->route('market.recharge')->with('error', 'Insufficient balance to place the order. Please recharge your account.');
        } else {
            // Deduct the order amount from user's balance
            DB::table('users')
                ->where('id', Auth::id())
                ->decrement('balance', $request->total_price);
        }


        // Insert into DB
        DB::table('mk_orders')->insert([
            'name'        => $request->name,
            'phone'       => $request->phone,
            'user_id'     => Auth::id() ?? 0, // Use authenticated user ID or 0 for guests
            'product_id'  => $request->product_id,
            'quantity'    => $request->quantity,
            'total_price' => $request->total_price,
            'address'     => $request->address,
            'status'     => 'Pending',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // 1. Insert transaction record (deduction)
        DB::table('transactions')->insert([
            'user_id'    => Auth::id(),
            'amount'     => $request->total_price,
            'trx_type'   => 'place_order',
            'detail'     => "Order Placed for Product {$request->product_id}",
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // 2. Insert notification record
        DB::table('notifications')->insert([
            'id'              => (string) Str::uuid(),
            'type'            => 'App\Notifications\PlanUpgradeSuccess',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id'   => Auth::id(),
            'data'            => json_encode([
                'title'   => 'Order Placed Successfully!',
                'message' => "Your order has been placed and amount deducted",
                'amount'  => number_format($request->total_price, 2),

            ]),
            'read_at'     => null,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);


        return redirect()
            ->back()
            // ->route('market.product.detail', $product->slug)
            ->with('success', 'Order Placed Successfully!');
    }

    public function about()
    {
        return view('market.website.about');
    }

    public function blogs(Request $request)
    {
        $blogs = DB::table('blogs')
            ->where('is_commentable', 1)
            ->orderBy('created_at', 'desc')
            ->select('blog_id', 'slug', 'picture', 'title', 'detail', 'short_description', 'created_at')
            ->paginate(6);

        if ($request->ajax()) {
            // Return only the HTML of the new blog cards (no full layout)
            $html = view('market.website.blogs-partial', compact('blogs'))->render();

            return response()->json([
                'html'          => $html,
                'next_page_url' => $blogs->nextPageUrl(),   // Important for "Load More"
                'current_page'  => $blogs->currentPage(),
                'last_page'     => $blogs->lastPage(),
            ]);
        }

        return view('market.website.blog', compact('blogs'));
    }

    public function blog_detail($slug)
    {
        // Fetch single blog by slug
        $blog = DB::table('blogs')
            ->where('slug', $slug)
            ->first();

        if (!$blog) {
            abort(404, 'Blog not found');
        }

        // Fetch related comments
        $comments = DB::table('blog_comments')
            ->where('blog_id', $blog->blog_id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Recent blogs (for sidebar)
        $recent_blogs = DB::table('blogs')
            ->where('blog_id', '!=', $blog->blog_id)   // exclude current blog
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('market.website.blog_detail', [
            'blog'         => $blog,
            'comments'     => $comments,
            'recent_blogs' => $recent_blogs,
        ]);
    }

    public function store_comment(Request $request)
    {
        $validated = $request->validate([
            'blog_id' => 'required|integer|exists:blogs,blog_id',
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $blog = DB::table('blogs')
            ->where('blog_id', $validated['blog_id'])
            ->first();

        if (!$blog || $blog->is_commentable != 1) {
            return back()->with('error', 'Sorry, commenting is not allowed on this post.');
        }

        DB::table('blog_comments')->insert([
            'blog_id'    => $validated['blog_id'],
            'name'       => strip_tags($validated['name']),
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'comment'    => strip_tags($validated['comment']),
            'created_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Your comment has been submitted successfully!')
            ->withFragment('comments');   // Scroll back to comments section
    }


    public function category($category)
    {
        // Fetch the category by slug
        $categoryData = DB::table('mk_categories')->where('url', $category)->first();
        
        // Check if category exists
        if (!$categoryData) {
            abort(404, 'Category not found');
        }

        
        $sub_categories = DB::table('mk_sub_categories')->where('cat_id', $categoryData->id)->get();

        
        // Fetch products associated with this category, paginated


        $products = DB::table('mk_products')
            ->leftJoin('mk_categories', 'mk_products.cat_id', '=', 'mk_categories.id')
            ->leftJoin('mk_sub_categories', 'mk_products.sub_cat_id', '=', 'mk_sub_categories.sub_cat_id')
            ->select(
                'mk_products.*',
                'mk_categories.category_name as category_name',
                'mk_sub_categories.sub_cat_name as sub_category_name'
            )
            ->where('mk_products.cat_id', $categoryData->id)
            ->paginate(12);

        // Return the view with category and products data
        return view('market.website.category', compact('categoryData', 'products', 'sub_categories'));
    }

    public function subCategory($category, $sub_category)
    {
        // Fetch the category by slug
        $categoryData = DB::table('mk_categories')->where('url', $category)->first();

        // Fetch the sub-category by slug and ensure it belongs to the category
        $subCategoryData = DB::table('mk_sub_categories')
            ->where('sub_cat_url', $sub_category)
            ->where('cat_id', $categoryData ? $categoryData->id : null)
            ->first();

        // Check if category and sub-category exist
        if (!$categoryData || !$subCategoryData) {
            abort(404, 'Category or Sub-category not found');
        }

        // Fetch products associated with this sub-category, paginated

        $products = DB::table('mk_products')
            ->leftJoin('mk_categories', 'mk_products.cat_id', '=', 'mk_categories.id')
            ->leftJoin('mk_sub_categories', 'mk_products.sub_cat_id', '=', 'mk_sub_categories.sub_cat_id')
            ->select(
                'mk_products.*',
                'mk_categories.category_name as category_name',
                'mk_sub_categories.sub_cat_name as sub_category_name'
            )
            ->where('mk_products.cat_id', $categoryData->id)
            ->where('mk_products.sub_cat_id', $subCategoryData->sub_cat_id)
            ->paginate(12);

        // Return the view with category, sub-category, and products data
        return view('market.website.sub_category', compact('categoryData', 'subCategoryData', 'products'));
    }

    public function quality($category, $sub_category, $quality)
    {
        // Fetch the category by slug
        $categoryData = DB::table('mk_categories')->where('url', $category)->first();

        // Fetch the sub-category by slug and ensure it belongs to the category
        $subCategoryData = DB::table('mk_sub_categories')
            ->where('sub_cat_url', $sub_category)
            ->where('cat_id', $categoryData ? $categoryData->id : null)
            ->first();

        // Fetch the quality by slug and ensure it belongs to the sub-category
        $qualityData = DB::table('mk_qualities')
            ->where('quality_url', $quality)
            ->where('sub_cat_id', $subCategoryData ? $subCategoryData->sub_cat_id : null)
            ->first();

        // Check if category, sub-category, and quality exist
        if (!$categoryData || !$subCategoryData || !$qualityData) {
            abort(404, 'Category, Sub-category, or Quality not found');
        }

        // Fetch products associated with this quality, paginated

        $products = DB::table('mk_products')
            ->leftJoin('mk_categories', 'mk_products.cat_id', '=', 'mk_categories.id')
            ->leftJoin('mk_sub_categories', 'mk_products.sub_cat_id', '=', 'mk_sub_categories.sub_cat_id')
            ->leftJoin('mk_qualities', 'mk_products.quality_id', '=', 'mk_qualities.quality_id')
            ->select(
                'mk_products.*',
                'mk_categories.category_name as category_name',
                'mk_sub_categories.sub_cat_name as sub_category_name',
                'mk_qualities.quality_name as quality_name'
            )
            ->where('mk_products.cat_id', $categoryData->id)
            ->where('mk_products.sub_cat_id', $subCategoryData->sub_cat_id)
            ->where('mk_products.quality_id', $qualityData->quality_id)
            ->paginate(12);

        // Return the view with category, sub-category, quality, and products data
        return view('market.website.quality', compact('categoryData', 'subCategoryData', 'qualityData', 'products'));
    }


    // ====================================ADMIN============================
    public function dashboard()
    {
        $countProducts = DB::table('mk_products')->count();
        $countCategories = DB::table('mk_categories')->count();
        return view('market.admin.dashboard', [
            'countProducts' => $countProducts,
            'countCategories' => $countCategories,
        ]);
    }

    // =================================== BLOGS ===================================
    public function add_blogs()
    {
        $blogs = DB::table('blogs')->get();
        return view('market.admin.add_blogs', compact('blogs'));
    }

    public function edit_blog($blog_id)
    {
        $blogs = DB::table('blogs')
            ->where('blog_id', '=', $blog_id)
            ->get();
        $blogs = json_decode($blogs, true);
        return view('market.admin.edit_blogs', ['blogs' => $blogs]);
    }

    public function blogs_list()
    {
        $blog_list = DB::table('blogs')
            ->select('*')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('market.admin.blog_list', compact('blog_list'));
    }

    public function delete_blog($blog_id)
    {
        $delete = DB::delete('DELETE FROM blogs WHERE blog_id  = ?', [$blog_id]);

        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {

            return back()->with('error', 'Data Not Deleted, Technical Error');
        }
    }

    // =================================== PRODUCTS ===================================

    public function getSubCategories($cat_id)
    {
        $sub_categories = DB::table('mk_sub_categories')
            ->where('cat_id', $cat_id)
            ->select('sub_cat_id', 'sub_cat_name')
            ->get();
        return response()->json($sub_categories);
    }

    public function all_products()
    {
        // Fetch products with their category, sub-category, and quality names
        $products = DB::table('mk_products')
            ->join('mk_categories', 'mk_products.cat_id', '=', 'mk_categories.id')
            ->leftJoin('mk_sub_categories', 'mk_products.sub_cat_id', '=', 'mk_sub_categories.sub_cat_id')
            ->select(
                'mk_products.*',
                'mk_categories.category_name as category_name',
                'mk_categories.url as category_url',
                'mk_sub_categories.sub_cat_name as sub_category_name',
                'mk_sub_categories.sub_cat_url as sub_category_url'
            )
            ->get();

        return view('market.admin.all_products', [
            'products' => $products,
        ]);
    }

    public function add_product()
    {
        // Fetch products with their category, sub-category, and quality names
        $products = DB::table('mk_products')
            ->join('mk_categories', 'mk_products.cat_id', '=', 'mk_categories.id')
            ->leftJoin('mk_sub_categories', 'mk_products.sub_cat_id', '=', 'mk_sub_categories.sub_cat_id')
            ->select(
                'mk_products.*',
                'mk_categories.category_name as category_name',
                'mk_sub_categories.sub_cat_name as sub_category_name'
            )
            ->get();

        // Fetch categories for the form dropdown
        $categories = DB::table('mk_categories')->get();
        // Fetch sub-categories and qualities (initially all, filtered via JavaScript)
        $sub_categories = DB::table('mk_sub_categories')->get();

        return view('market.admin.add_product', [
            'products' => $products,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
        ]);
    }



    public function edit_product($id)
    {
        // Fetch the product by ID
        $product = DB::table('mk_products')
            ->where('product_id', $id)
            ->first();

        // Fetch categories, sub-categories, and qualities for the form
        $categories = DB::table('mk_categories')->get();
        $sub_categories = DB::table('mk_sub_categories')->get();

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        $faqs = DB::table('mk_product_faqs')
            ->where('product_id', $id)
            ->orderBy('id')           // optional: keep order consistent
            ->get();

        return view('market.admin.edit_product', [
            'product' => $product,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'faqs' => $faqs
        ]);
    }

    // ===================================CATEGORIES ===================================

    public function add_category()
    {
        $categories = DB::table('mk_categories')
            ->leftJoin('mk_products', 'mk_categories.id', '=', 'mk_products.cat_id')
            ->select('mk_categories.*', DB::raw('COUNT(mk_products.product_id) as product_count'))
            ->groupBy('mk_categories.id', 'mk_categories.category_name', 'mk_categories.feature_image', 'mk_categories.url', 'mk_categories.meta_title', 'mk_categories.meta_description', 'mk_categories.meta_keywords', 'mk_categories.page_schema', 'mk_categories.created_at', 'mk_categories.updated_at')
            ->get();

        return view('market.admin.add_category', [
            'categories' => $categories
        ]);
    }

    public function edit_category($id)
    {
        // Retrieve the category by ID using Query Builder
        $category = DB::table('mk_categories')->where('id', $id)->first();

        // Check if the category exists
        if (!$category) {
            return back()->with('error', 'Category not found.');
        }

        $faqs = DB::table('mk_category_faqs')
            ->where('category_id', $id)
            ->orderBy('id')           // optional: keep order consistent
            ->get();

        // Load the edit category page with the category data
        return view('market.admin.edit_category', [
            'category' => $category,
            'faqs' => $faqs
        ]);
    }

    // ===================================SUB CATEGORIES ===================================

    public function add_sub_category()
    {
        $sub_categories = DB::table('mk_sub_categories')
            ->join('mk_categories', 'mk_sub_categories.cat_id', '=', 'mk_categories.id')
            ->leftJoin('mk_products', 'mk_sub_categories.sub_cat_id', '=', 'mk_products.sub_cat_id')
            ->select(
                'mk_sub_categories.sub_cat_id',
                'mk_sub_categories.cat_id',
                'mk_sub_categories.sub_cat_name',
                'mk_sub_categories.sub_cat_url',
                'mk_sub_categories.feature_image',
                'mk_sub_categories.created_at',
                'mk_sub_categories.meta_title',
                'mk_sub_categories.meta_description',
                'mk_sub_categories.page_schema',
                'mk_sub_categories.meta_keywords',
                'mk_categories.category_name as parent_category_name',
                'mk_categories.url as category_url',
                DB::raw('COUNT(mk_products.product_id) as product_count')
            )
            ->groupBy(
                'mk_sub_categories.sub_cat_id',
                'mk_sub_categories.cat_id',
                'mk_sub_categories.sub_cat_name',
                'mk_sub_categories.sub_cat_url',
                'mk_sub_categories.feature_image',
                'mk_sub_categories.created_at',
                'mk_sub_categories.meta_title',
                'mk_sub_categories.meta_description',
                'mk_sub_categories.page_schema',
                'mk_sub_categories.meta_keywords',
                'mk_sub_categories.updated_at',
                'mk_categories.category_name',
                'mk_categories.url'
            )
            ->get();

        $categories = DB::table('mk_categories')->get();

        return view('market.admin.add_sub_category', [
            'sub_categories' => $sub_categories,
            'categories' => $categories
        ]);
    }

    public function edit_sub_category($sub_cat_id)
    {
        // Fetch the sub-category by ID
        $sub_category = DB::table('mk_sub_categories')->where('sub_cat_id', $sub_cat_id)->first();

        // Fetch categories for the form dropdown
        $categories = DB::table('mk_categories')->get();

        if (!$sub_category) {
            return back()->with('error', 'Sub-category not found.');
        }

        $faqs = DB::table('mk_sub_category_faqs')
            ->where('sub_cat_id', $sub_cat_id)
            ->orderBy('id')           // optional: keep order consistent
            ->get();

        return view('market.admin.edit_sub_category', [
            'sub_category' => $sub_category,
            'categories' => $categories,
            'faqs' => $faqs
        ]);
    }


    // ===================================QUALITIES ===================================

    public function add_quality()
    {
        // Fetch qualities with their sub-category, parent category names, and product counts
        $qualities = DB::table('mk_qualities')
            ->join('mk_sub_categories', 'mk_qualities.sub_cat_id', '=', 'mk_sub_categories.sub_cat_id')
            ->join('mk_categories', 'mk_sub_categories.cat_id', '=', 'mk_categories.id')
            ->leftJoin('mk_products', 'mk_qualities.quality_id', '=', 'mk_products.quality_id')
            ->select(
                'mk_qualities.quality_id',
                'mk_qualities.sub_cat_id',
                'mk_qualities.quality_name',
                'mk_qualities.quality_url',
                'mk_qualities.created_at',
                'mk_sub_categories.sub_cat_name as sub_category_name',
                'mk_sub_categories.sub_cat_url as sub_category_url',
                'mk_categories.category_name as parent_category_name',
                'mk_categories.url as category_url',
                DB::raw('COUNT(mk_products.product_id) as product_count')
            )
            ->groupBy(
                'mk_qualities.quality_id',
                'mk_qualities.sub_cat_id',
                'mk_qualities.quality_name',
                'mk_qualities.quality_url',
                'mk_qualities.created_at',
                'mk_sub_categories.sub_cat_name',
                'mk_sub_categories.sub_cat_url',
                'mk_categories.category_name',
                'mk_categories.url'
            )
            ->get();

        // Fetch sub-categories for the form dropdown
        $sub_categories = DB::table('mk_sub_categories')
            ->join('mk_categories', 'mk_sub_categories.cat_id', '=', 'mk_categories.id')
            ->select(
                'mk_sub_categories.sub_cat_id',
                'mk_sub_categories.sub_cat_name',
                'mk_categories.category_name'
            )
            ->get();

        return view('market.admin.add_quality', [
            'qualities' => $qualities,
            'sub_categories' => $sub_categories
        ]);
    }

    public function edit_quality($quality_id)
    {
        // Fetch the quality by ID
        $quality = DB::table('mk_qualities')
            ->where('quality_id', $quality_id)
            ->first();

        // Fetch sub-categories for the form dropdown
        $sub_categories = DB::table('mk_sub_categories')
            ->join('mk_categories', 'mk_sub_categories.cat_id', '=', 'mk_categories.id')
            ->select('mk_sub_categories.sub_cat_id', 'mk_sub_categories.sub_cat_name', 'mk_categories.category_name')
            ->get();

        if (!$quality) {
            return back()->with('error', 'Quality not found.');
        }

        return view('market.admin.edit_quality', [
            'quality' => $quality,
            'sub_categories' => $sub_categories
        ]);
    }

    // ===================================CONTACT US ===================================
    public function contact_us()
    {

        $msgs = DB::select('SELECT * FROM mk_contact');
        return view('market.admin.contact', [
            'msgs' => $msgs
        ]);
    }

    public function orders()
    {
        $orders = DB::table('mk_orders')
            ->leftJoin('mk_products', 'mk_orders.product_id', '=', 'mk_products.product_id')
            ->leftJoin('users', 'mk_orders.user_id', '=', 'users.id')
            ->select(
                'mk_orders.*',
                'mk_products.name as product_name',
                'mk_products.price',
                'mk_products.delivery_charges',
                'mk_products.slug as product_slug',
                'users.username',
                'users.id as user_id'
            )
            ->get();

        return view('market.admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        DB::table('mk_orders')
            ->where('id', $id)
            ->update(['status' => $request->status]);

        return back()->with('success', 'Order Status Updated.');
    }
}
