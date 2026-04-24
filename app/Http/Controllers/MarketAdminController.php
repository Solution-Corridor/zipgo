<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App;
use Session;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use App\Http\Controllers\AdminController;


class MarketAdminController extends Controller
{

    // ==================================BLOGS===================================
public function save_blogs(Request $req)
{
    $req->validate([
        'title'             => 'required|string|max:60',
        'picture'           => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        'detail'            => 'required|string',
        'url'               => 'required|string|unique:blogs,slug',   // url becomes slug
        'keywords'          => 'required|string|max:500',
        'short_description' => 'required|string|min:110|max:160',
        'page_schema'       => 'nullable|string',
        'is_commentable'    => 'nullable',
    ]);

    // File Upload
    $pictureName = null;
    if ($req->hasFile('picture')) {
        $file = $req->file('picture');
        $pictureName = time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/market/blogs'), $pictureName);
    }

    // Prepare data exactly matching your DB table
    $data = [
        'title'             => $req->title,
        'picture'           => $pictureName,
        'detail'            => $req->detail,
        'slug'              => $req->url,                    // Form 'url' → DB 'slug'
        'keywords'          => $req->keywords,
        'short_description' => $req->short_description,
        'page_schema'       => $req->page_schema,
        'is_commentable'    => $req->has('is_commentable') ? 1 : 0,
        'created_at'        => now(),
        'updated_at'        => now(),
    ];

    $insert = DB::table('blogs')->insert($data);

    if ($insert) {
        return back()->with('success', 'Blog added successfully!');
    } else {
        return back()->with('error', 'Failed to save blog. Please try again.');
    }
}

public function update_blogs(Request $req)
{
    $req->validate([
        'title'             => 'required|string|max:60',
        'slug'              => 'required|string|unique:blogs,slug,' . $req->blog_id . ',blog_id',
        'detail'            => 'required|string',
        'pic'               => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        'keywords'          => 'nullable|string|max:500',
        'short_description' => 'nullable|string|min:110|max:160',
        'page_schema'       => 'nullable|string',
        'is_commentable'    => 'nullable',
    ]);

    $id = $req->blog_id;
    $oldPicture = $req->hidden_pic;

    // Handle File Upload
    $pictureName = $oldPicture;   // Keep old image by default

    if ($req->hasFile('pic')) {
        // Delete old image if exists
        if ($oldPicture && File::exists(public_path('uploads/market/blogs/' . $oldPicture))) {
            File::delete(public_path('uploads/market/blogs/' . $oldPicture));
        }

        $file = $req->file('pic');
        $pictureName = time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/market/blogs'), $pictureName);
    }

    // Prepare data exactly matching your DB table
    $data = [
        'title'             => $req->title,
        'slug'              => $req->slug,
        'picture'           => $pictureName,
        'detail'            => $req->detail,
        'keywords'          => $req->keywords,
        'short_description' => $req->short_description,
        'page_schema'       => $req->page_schema,
        'is_commentable'    => $req->has('is_commentable') ? 1 : 0,
        'updated_at'        => now(),
    ];

    $update = DB::table('blogs')
                ->where('blog_id', $id)
                ->update($data);

    if ($update) {
        return back()->with('success', 'Blog updated successfully!');
    } else {
        return back()->with('error', 'Failed to update blog.');
    }
}

    

    

    // ===================================PRODUCTS===================================

    public function save_product(Request $req)
    {
        // Custom validation
        $req->validate([
            'cat_id' => 'required|exists:mk_categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'delivery_charges' => 'required|numeric|min:0',
            'pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'pic1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'pic2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'pic3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'cutting_price' => 'nullable|numeric|gte:price',
            'product_ratting' => 'nullable|numeric|between:0,5',
            'ratting_count' => 'nullable|numeric|min:0',
            'stock_sold' => 'nullable|numeric|min:0',
            'stock_left' => 'nullable|numeric|min:0',
            'detail' => 'required|string',
            'slug' => 'required|unique:mk_products,slug',
            'meta_title' => 'required|string|min:45|max:70',
            'meta_description' => 'required|string|min:70|max:155',
            'meta_keywords' => 'required|string',
            'page_schema' => 'nullable|string',
        ]);

        // Check if product already exists
        $existing = DB::table('mk_products')->where([
            ['name', $req->name],
            ['cat_id', $req->cat_id],
        ])->exists();

        if ($existing) {
            return back()->withErrors(['name' => 'This product already exists with the selected category.'])->withInput();
        }

        // Generate unique slug
        $slug = $req->slug;
        $originalSlug = $slug;
        $count = 1;

        while (DB::table('mk_products')->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // ------------------------------
        // Handle picture uploads
        // ------------------------------
        $picNames = [];

        if ($req->hasFile('pic')) {
            $file = $req->file('pic');
            $picNames['pic'] = time() . rand(1, 99) . '.' . $file->extension();
            $file->move(public_path('uploads/market/products'), $picNames['pic']);
        }

        $optionalPics = ['pic1', 'pic2', 'pic3'];
        foreach ($optionalPics as $field) {
            if ($req->hasFile($field)) {
                $file = $req->file($field);
                $picNames[$field] = time() . rand(1, 99) . '_' . $field . '.' . $file->extension();
                $file->move(public_path('uploads/market/products'), $picNames[$field]);
            }
        }

        // ------------------------------
        // Insert Product
        // ------------------------------
        $product_id = DB::table('mk_products')->insertGetId([
            'cat_id' => $req->cat_id,
            'sub_cat_id' => $req->sub_cat_id,
            'name' => $req->name,
            'slug' => $slug,
            'price' => $req->price,
            'delivery_charges' => $req->delivery_charges,
            'pic' => $picNames['pic'] ?? null,
            'pic1' => $picNames['pic1'] ?? null,
            'pic2' => $picNames['pic2'] ?? null,
            'pic3' => $picNames['pic3'] ?? null,
            'cutting_price' => $req->cutting_price,
            'product_ratting' => $req->product_ratting,
            'ratting_count' => $req->ratting_count,
            'stock_sold' => $req->stock_sold,
            'stock_left' => $req->stock_left,
            'detail' => $req->detail,
            'meta_title' => $req->meta_title,
            'meta_description' => $req->meta_description,
            'meta_keywords' => $req->meta_keywords,
            'page_schema' => $req->page_schema,
            'created_at' => now(),
        ]);

        // ------------------------------
        // Insert FAQs
        // ------------------------------
        if ($req->faq_question && is_array($req->faq_question)) {
            foreach ($req->faq_question as $index => $question) {
                if ($question != "") {
                    DB::table('mk_product_faqs')->insert([
                        'product_id' => $product_id,
                        'question' => $question,
                        'answer' => $req->faq_answer[$index] ?? '',
                        'created_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('market.add_products')
            ->with('success', 'Product saved successfully with FAQs.');
    }


    public function update_product(Request $req, $id)
    {
        // Validate main product fields
        $req->validate([
            'cat_id' => 'required|exists:mk_categories,id',
            'sub_cat_id' => 'nullable|exists:mk_sub_categories,sub_cat_id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'delivery_charges' => 'required|numeric|min:0',
            'pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'pic1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'pic2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'pic3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'cutting_price' => 'nullable|numeric|gte:price',
            'product_ratting' => 'nullable|numeric|between:0,5',
            'ratting_count' => 'nullable|numeric|min:0',
            'stock_sold' => 'nullable|numeric|min:0',
            'stock_left' => 'nullable|numeric|min:0',
            'detail' => 'required|string',
            'slug' => ['required', 'max:255', 'regex:/^[a-zA-Z0-9_-]+$/'],
            'meta_title' => 'required|string|min:45|max:70',
            'meta_description' => 'required|string|min:70|max:155',
            'meta_keywords' => 'required|string',
            'page_schema' => 'nullable|string',
            'faq_question.*' => 'nullable|string|max:255',
            'faq_answer.*' => 'nullable|string',
            'faq_id.*' => 'nullable|integer',
        ]);

        // Check duplicate product
        $existing = DB::table('mk_products')
            ->where('name', $req->name)
            ->where('cat_id', $req->cat_id)
            ->where('product_id', '!=', $id)
            ->exists();
        if ($existing) {
            return back()->withErrors(['name' => 'This product already exists in this category.'])->withInput();
        }

        // Get existing product
        $product = DB::table('mk_products')->where('product_id', $id)->first();

        // Prepare update data
        $data = [
            'cat_id' => $req->cat_id,
            'sub_cat_id' => $req->sub_cat_id,
            'name' => $req->name,
            'slug' => Str::slug($req->name),
            'price' => $req->price,
            'delivery_charges' => $req->delivery_charges,
            'cutting_price' => $req->cutting_price,
            'product_ratting' => $req->product_ratting,
            'ratting_count' => $req->ratting_count,
            'stock_sold' => $req->stock_sold,
            'stock_left' => $req->stock_left,
            'detail' => $req->detail,
            'meta_title' => $req->meta_title,
            'meta_description' => $req->meta_description,
            'meta_keywords' => $req->meta_keywords,
            'page_schema' => $req->page_schema,
            'updated_at' => now(),
        ];

        // Handle images
        $picFields = ['pic', 'pic1', 'pic2', 'pic3'];
        foreach ($picFields as $picField) {
            if ($req->hasFile($picField)) {
                if ($product->$picField && File::exists(public_path('uploads/market/products/' . $product->$picField))) {
                    File::delete(public_path('uploads/market/products/' . $product->$picField));
                }
                $pic = $req->file($picField);
                $data[$picField] = time() . rand(1, 99) . '_' . $picField . '.' . $pic->extension();
                $pic->move(public_path('uploads/market/products'), $data[$picField]);
            }
        }

        // Ensure slug uniqueness
        $slug = $req->slug;
        $originalSlug = $slug;
        $count = 1;
        while (DB::table('mk_products')->where('slug', $slug)->where('product_id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        $data['slug'] = $slug;

        // Update product
        DB::table('mk_products')->where('product_id', $id)->update($data);

        // Handle FAQs
        $existingFaqIds = DB::table('mk_product_faqs')->where('product_id', $id)->pluck('id')->toArray();
        $formFaqIds = $req->faq_id ?? [];

        // Delete removed FAQs
        $deleteIds = array_diff($existingFaqIds, $formFaqIds);
        if (!empty($deleteIds)) {
            DB::table('mk_product_faqs')->whereIn('id', $deleteIds)->delete();
        }

        // Update existing or insert new FAQs
        $faqQuestions = $req->faq_question ?? [];
        $faqAnswers = $req->faq_answer ?? [];
        foreach ($faqQuestions as $index => $question) {
            $answer = $faqAnswers[$index] ?? null;
            $faqId = $formFaqIds[$index] ?? null;

            if (!empty($question) && !empty($answer)) {
                if ($faqId) {
                    // Update existing
                    DB::table('mk_product_faqs')->where('id', $faqId)->update([
                        'question' => $question,
                        'answer' => $answer,
                        'updated_at' => now(),
                    ]);
                } else {
                    // Insert new
                    DB::table('mk_product_faqs')->insert([
                        'product_id' => $id,
                        'question' => $question,
                        'answer' => $answer,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully.');
    }


    public function delete_product($id)
    {
        // Check if product exists
        $product = DB::table('mk_products')->where('product_id', $id)->first();

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        // Delete FAQs associated with this product
        DB::table('mk_product_faqs')->where('product_id', $id)->delete();

        // Delete the product
        $deleted = DB::table('mk_products')->where('product_id', $id)->delete();

        if ($deleted) {
            return back()->with('success', 'Product and related FAQs deleted successfully.');
        } else {
            return back()->with('error', 'Data not deleted, technical error occurred.');
        }
    }

    // ===================================CATEGORIES===================================

    public function save_category(Request $req)
    {
        // Validate the input fields
        $validation = $req->validate([
            'category_name' => 'required|string|max:255|unique:mk_categories,category_name',
            'url' => 'required|max:255|unique:mk_categories,url',
            'feature_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'meta_title' => 'required|string|min:45|max:70',
            'meta_description' => 'required|string|min:70|max:155',
            'meta_keywords' => 'required|string',
            'page_schema' => 'required|string',
            // Optional FAQs validation
            'faq_question.*' => 'nullable|string|max:255',
            'faq_answer.*' => 'nullable|string|max:1000',
        ]);

        if ($validation) {
            // Handle the image upload
            $imagePath = null;
            if ($req->hasFile('feature_image')) {
                $adminController = new AdminController();
                $imagePath = $adminController->processImage($req->file('feature_image'));
            }

            // Prepare the data to be inserted
            $categoryData = [
                'category_name' => $req->get('category_name'),
                'url' => $req->get('url'),
                'feature_image' => $imagePath,
                'meta_title' => $req->meta_title,
                'meta_description' => $req->meta_description,
                'meta_keywords' => $req->meta_keywords,
                'page_schema' => $req->page_schema,
            ];

            // Insert the category and get the inserted ID
            $categoryId = DB::table('mk_categories')->insertGetId($categoryData);

            if ($categoryId) {
                // Save FAQs if provided
                if ($req->has('faq_question') && is_array($req->faq_question)) {
                    foreach ($req->faq_question as $index => $question) {
                        $answer = $req->faq_answer[$index] ?? null;
                        if ($question && $answer) {
                            DB::table('mk_category_faqs')->insert([
                                'category_id' => $categoryId,
                                'question' => $question,
                                'answer' => $answer,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }
                    }
                }

                return back()->with('success', 'Category saved successfully.');
            } else {
                return back()->with('error', 'Data not saved, technical error occurred.');
            }
        } else {
            return back()->withInput()->withErrors($validation);
        }
    }

    public function update_category(Request $request, $categoryId)
    {
        // Validate input
        $request->validate([
            'category_name' => 'required|string|max:255|unique:mk_categories,category_name,' . $categoryId,
            'url' => 'required|max:255|unique:mk_categories,url,' . $categoryId,
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'required|string|min:45|max:70',
            'meta_description' => 'required|string|min:70|max:155',
            'meta_keywords' => 'required|string',
            'page_schema' => 'required|string',
            'faq_question.*' => 'nullable|string|max:255',
            'faq_answer.*' => 'nullable|string|max:1000',
            'faq_id.*' => 'nullable|integer',
        ]);

        // Find the category
        $category = DB::table('mk_categories')->where('id', $categoryId)->first();
        if (!$category) {
            return back()->with('error', 'Category not found.');
        }

        // Handle image
        $imagePath = null;
        if ($request->hasFile('feature_image')) {
            $adminController = new AdminController();
            $imagePath = $adminController->processImage($request->file('feature_image'));
        }

        // Update category
        $data = [
            'category_name' => $request->category_name,
            'url' => $request->url,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'page_schema' => $request->page_schema,
            'updated_at' => now(),
        ];
        if ($imagePath) $data['feature_image'] = $imagePath;

        DB::table('mk_categories')->where('id', $categoryId)->update($data);

        // Handle FAQs
        $existingFaqIds = DB::table('mk_category_faqs')
            ->where('category_id', $categoryId)
            ->pluck('id')
            ->toArray();

        $formFaqIds = $request->faq_id ?? [];

        // Delete removed FAQs
        $deleteIds = array_diff($existingFaqIds, $formFaqIds);
        if (!empty($deleteIds)) {
            DB::table('mk_category_faqs')->whereIn('id', $deleteIds)->delete();
        }

        // Update existing FAQs or insert new ones
        if ($request->faq_question && $request->faq_answer) {
            foreach ($request->faq_question as $index => $question) {
                $answer = $request->faq_answer[$index] ?? null;
                $faqId = $formFaqIds[$index] ?? null;

                if (!empty($question) && !empty($answer)) {
                    if ($faqId) {
                        // Update existing
                        DB::table('mk_category_faqs')
                            ->where('id', $faqId)
                            ->update([
                                'question' => $question,
                                'answer' => $answer,
                                'updated_at' => now(),
                            ]);
                    } else {
                        // Insert new
                        DB::table('mk_category_faqs')->insert([
                            'category_id' => $categoryId,
                            'question' => $question,
                            'answer' => $answer,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        return redirect()->route('market.edit_category', $categoryId)
            ->with('success', 'Category and FAQs updated successfully.');
    }


    public function delete_category($categoryId)
    {
        // Find the category by ID using Query Builder
        $category = DB::table('mk_categories')->where('id', $categoryId)->first();

        // Check if the category exists
        if (!$category) {
            return back()->with('error', 'Category not found.');
        }

        // Delete the FAQs associated with this category
        DB::table('mk_category_faqs')->where('category_id', $categoryId)->delete();

        // Delete the category
        DB::table('mk_categories')->where('id', $categoryId)->delete();

        // Redirect back with success message
        return back()->with('success', 'Category and related FAQs deleted successfully.');
    }

    // ===================================SUB CATEGORIES===================================

    public function save_sub_category(Request $req)
    {
        // Validate the input fields
        $req->validate([
            'cat_id' => 'required|exists:mk_categories,id',
            'sub_cat_name' => 'required|string|max:500|unique:mk_sub_categories,sub_cat_name',
            'sub_cat_url' => 'required|string|max:500|unique:mk_sub_categories,sub_cat_url',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'required|string|min:45|max:70',
            'meta_description' => 'required|string|min:70|max:155',
            'meta_keywords' => 'required|string',
            'page_schema' => 'required|string',
            'faq_question.*' => 'nullable|string',
            'faq_answer.*' => 'nullable|string',
        ]);

        // Handle feature image upload
        $imagePath = null;
        if ($req->hasFile('feature_image')) {
            $adminController = new AdminController();
            $imagePath = $adminController->processImage($req->file('feature_image'));
        }

        // Insert sub category
        $subCategoryId = DB::table('mk_sub_categories')->insertGetId([
            'cat_id' => $req->cat_id,
            'sub_cat_name' => $req->sub_cat_name,
            'sub_cat_url' => $req->sub_cat_url,
            'feature_image' => $imagePath,
            'meta_title' => $req->meta_title,
            'meta_description' => $req->meta_description,
            'meta_keywords' => $req->meta_keywords,
            'page_schema' => $req->page_schema,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Save FAQs if provided
        if ($req->faq_question && $req->faq_answer) {
            $faqs = [];
            foreach ($req->faq_question as $index => $question) {
                if (!empty($question) && !empty($req->faq_answer[$index])) {
                    $faqs[] = [
                        'sub_cat_id' => $subCategoryId,
                        'question' => $question,
                        'answer' => $req->faq_answer[$index],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            if (!empty($faqs)) {
                DB::table('mk_sub_category_faqs')->insert($faqs);
            }
        }

        return back()->with('success', 'Sub Category saved successfully.');
    }


    public function delete_sub_category($sub_cat_id)
    {
        // Delete all FAQs for this sub-category
        DB::table('mk_sub_category_faqs')->where('sub_cat_id', $sub_cat_id)->delete();

        // Delete the sub-category
        $delete = DB::table('mk_sub_categories')->where('sub_cat_id', $sub_cat_id)->delete();

        if ($delete) {
            return redirect()->route('market.add_sub_category')->with('success', 'Sub Category and its FAQs deleted successfully.');
        }

        return back()->with('error', 'Data not deleted, technical error occurred.');
    }

    public function update_sub_category(Request $req, $sub_cat_id)
    {
        // ✅ Validate input
        $req->validate([
            'cat_id' => 'required|exists:mk_categories,id',
            'sub_cat_name' => 'required|string|max:500|unique:mk_sub_categories,sub_cat_name,' . $sub_cat_id . ',sub_cat_id',
            'sub_cat_url' => 'required|string|max:500|unique:mk_sub_categories,sub_cat_url,' . $sub_cat_id . ',sub_cat_id',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'required|string|min:45|max:70',
            'meta_description' => 'required|string|min:70|max:155',
            'meta_keywords' => 'required|string',
            'page_schema' => 'required|string',
            'faq_question.*' => 'nullable|string',
            'faq_answer.*' => 'nullable|string',
            'faq_id.*' => 'nullable|integer',
        ]);

        // Handle image
        $imagePath = null;
        if ($req->hasFile('feature_image')) {
            $adminController = new AdminController();
            $imagePath = $adminController->processImage($req->file('feature_image'));
        }

        // Update sub-category
        $data = [
            'cat_id' => $req->cat_id,
            'sub_cat_name' => $req->sub_cat_name,
            'sub_cat_url' => $req->sub_cat_url,
            'meta_title' => $req->meta_title,
            'meta_description' => $req->meta_description,
            'meta_keywords' => $req->meta_keywords,
            'page_schema' => $req->page_schema,
            'updated_at' => now(),
        ];
        if ($imagePath) $data['feature_image'] = $imagePath;

        DB::table('mk_sub_categories')->where('sub_cat_id', $sub_cat_id)->update($data);

        // Handle FAQs
        $existingFaqIds = DB::table('mk_sub_category_faqs')
            ->where('sub_cat_id', $sub_cat_id)
            ->pluck('id')
            ->toArray();

        $formFaqIds = $req->faq_id ?? [];

        // 1️⃣ Delete FAQs removed from form
        $deleteIds = array_diff($existingFaqIds, $formFaqIds);
        if (!empty($deleteIds)) {
            DB::table('mk_sub_category_faqs')->whereIn('id', $deleteIds)->delete();
        }

        // 2️⃣ Update existing FAQs and add new ones
        if ($req->faq_question && $req->faq_answer) {
            foreach ($req->faq_question as $index => $question) {
                $answer = $req->faq_answer[$index];
                $faqId = $formFaqIds[$index] ?? null;

                if (!empty($question) && !empty($answer)) {
                    if ($faqId) {
                        // Update existing
                        DB::table('mk_sub_category_faqs')
                            ->where('id', $faqId)
                            ->update([
                                'question' => $question,
                                'answer' => $answer,
                                'updated_at' => now(),
                            ]);
                    } else {
                        // Insert new
                        DB::table('mk_sub_category_faqs')->insert([
                            'sub_cat_id' => $sub_cat_id,
                            'question' => $question,
                            'answer' => $answer,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        return redirect()
            ->route('market.add_sub_category')
            ->with('success', 'Sub Category updated successfully.');
    }


    // ===================================QUALITIES===================================

    public function save_quality(Request $req)
    {
        // Validate the input fields
        $req->validate([
            'sub_cat_id' => 'required|exists:mk_sub_categories,sub_cat_id',
            'quality_name' => 'required|string|max:500',
        ]);

        $slug = Str::slug($req->quality_name);

        // Check if slug already exists for same sub_cat_id
        $exists = DB::table('mk_qualities')
            ->where('sub_cat_id', $req->sub_cat_id)
            ->where('quality_url', $slug)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This quality URL already exists in the selected sub-category.');
        }

        // Prepare the data to be inserted
        $data = [
            'sub_cat_id' => $req->sub_cat_id,
            'quality_name' => $req->quality_name,
            'quality_url' => $slug,
            'created_at' => now(),
        ];

        // Insert the data into the qualities table
        $insert = DB::table('mk_qualities')->insert($data);

        // Check if the insert was successful
        if ($insert) {
            return redirect()->route('market.add_quality')->with('success', 'Quality saved successfully.');
        }

        return back()->with('error', 'Data not saved, technical error occurred.');
    }

    public function update_quality(Request $req, $quality_id)
    {
        // Validate the input fields
        $req->validate([
            'sub_cat_id' => 'required|exists:mk_sub_categories,sub_cat_id',
            'quality_name' => 'required|string|max:500|unique:mk_qualities,quality_name,' . $quality_id . ',quality_id',
            'quality_url' => 'required|string|max:500|unique:mk_qualities,quality_url,' . $quality_id . ',quality_id',
        ]);

        // Prepare the data to be updated
        $data = [
            'sub_cat_id' => $req->sub_cat_id,
            'quality_name' => $req->quality_name,
            'quality_url' => $req->quality_url,
        ];

        // Update the quality
        $update = DB::table('mk_qualities')->where('quality_id', $quality_id)->update($data);

        if ($update) {
            return redirect()->route('market.add_quality')->with('success', 'Quality updated successfully.');
        }

        return back()->with('error', 'Data not updated, technical error occurred.');
    }

    public function delete_quality($quality_id)
    {
        // Delete the quality
        $delete = DB::table('mk_qualities')->where('quality_id', $quality_id)->delete();

        if ($delete) {
            return redirect()->route('market.add_quality')->with('success', 'Quality deleted successfully.');
        }

        return back()->with('error', 'Data not deleted, technical error occurred.');
    }

    public function contactUs(Request $req)
    {

        $validation = $req->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if (!$validation) {
            return back()->withInput()->withErrors($validation);
        }

        $data = array(
            "name" => $req->get('name'),
            "email" => $req->get('email'),
            "phone" => $req->get('phone'),
            "subject" => $req->get('subject'),
            "message" => $req->get('message')
        );

        $insert = DB::table('mk_contact')->insert($data);

        if ($insert) {
            return back()->with('success', 'Message sent successfully');
        } else {
            return back()->withInput()->with('error', 'Message not saved, technical error');
        }
    }






















































    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:subscribers,email']);
        DB::table('subscribers')->insert(['email' => $request->email, 'created_at' => now()]);
        return redirect()->back()->with('success', 'Subscribed successfully!');
    }





    public function destroy($productId)
    {
        // Find the product by ID using Query Builder
        $product = DB::table('products')->where('id', $productId)->first();

        // Check if the product exists
        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        // Delete the product
        DB::table('products')->where('id', $productId)->delete();

        // Redirect back with success message
        return back()->with('success', 'Product deleted successfully.');
    }



    //==========save_blogs...........




    public function save_services(request $req)
    {


        $validation = $req->validate([
            'title' => 'required',
            'pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'detail' => 'required'

        ]);

        if ($validation) {
            $slug = $req->get('title');
            $slug = str_replace(' ', '-', $slug); // Replaces all spaces with hyphens.
            $slug = preg_replace('/[^A-Za-z0-9\-]?/', '', $slug); // Removes special chars.
            $slug = preg_replace('/-+/', '-', $slug); // Replaces multiple hyphens with single one.

            $pic = $req->file('pic');
            $pic = time() . rand(1, 99) . '.' . $req->pic->extension();
            //move file
            $req->pic->move(public_path('uploads/services'), $pic);


            $data = array(
                "title" => $req->get('title'),
                "slug" => strtolower($slug),
                "detail" => $req->get('detail'),
                "pic" => $pic,

            );


            $insert = DB::table('services')->insert($data);

            if ($insert) {
                return back()->with('success', 'Saved Successfully');
            } else {
                return back()->with('error', 'Data Not Saved, Technical Error');
            }
        } else {

            return back()->withInput()->withErrors($validation);
        }
    }


















    //=========update_blogs========


    function update_service(Request $req)
    {
        $validation = $req->validate([
            'title' => 'required',
            'pic' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'detail' => 'required',
        ]);

        if ($validation) {
            $service_id = $req->get('service_id');
            $pic = $req->file('pic');
            $pic_name = '';

            if ($pic) { // Check if a file was uploaded
                $pic_name = time() . '.' . $pic->extension(); // Generate a unique filename based on current time and file extension

                // Move the uploaded file to a specific directory
                $pic->move(public_path('uploads/services'), $pic_name);
            } else {
                // If no file was uploaded, use the value from the hidden input field
                $pic_name = $req->get('hidden_pic');
            }

            $updateData = [
                "title" => $req->get('title'),
                "pic" => $pic_name,
                "detail" => $req->get('detail'),
            ];

            $update = DB::table('services')->where('service_id', $service_id)->update($updateData);

            if ($update) {
                return back()->with('success', 'Updated Successfully');
            } else {
                return back()->with('error', 'Data Not Updated, Technical Error');
            }
        } else {
            return back()->withInput()->withErrors($validation);
        }
    }












    public function sendEmail(Request $request)
    {
        $recipients = $request->input('recipients');
        $subject = $request->input('subject');
        $messageContent = $request->input('message');

        // Check if the "sendAll" checkbox is checked
        if ($request->has('sendAll')) {
            // Send email to all email addresses from the users table
            $allEmails = DB::table('users')->pluck('email')->toArray();

            foreach ($allEmails as $recipient) {
                Mail::send([], [], function ($message) use ($recipient, $subject, $messageContent) {
                    $message->from('secure@botaex.com', 'BotaEx');
                    $message->to($recipient);
                    $message->subject($subject);
                    $message->html($messageContent); // Set email body as HTML
                });
            }
        } elseif (!empty($recipients)) {
            // Send email to selected recipients
            foreach ($recipients as $recipient) {
                Mail::send([], [], function ($message) use ($recipient, $subject, $messageContent) {
                    $message->from('secure@botaex.com', 'BotaEx');
                    $message->to($recipient);
                    $message->subject($subject);
                    $message->html($messageContent); // Set email body as HTML
                });
            }
        }

        return redirect('/email_system')->with('success', 'Email(s) sent successfully');
    }



    public function emailSystem()
    {
        $subscribers = DB::table('subscribers')->get();

        return view('admin.email_system', [
            'subscribers' => $subscribers
        ]);
    }


    public function editUser($id)
    {
        // Find the promotion by its ID
        $user = DB::table('users')->where('id', $id)->first();

        // Check if the promotion exists
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        return view('/admin.edit_user', [
            'users' => $user
        ]);
    }


    function update_user(Request $req)
    {
        $id = $req->get('id');

        $validation = $req->validate([
            'name' => 'required',
            'phone' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'country' => 'required',
            'pic' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the allowed image types and size
        ]);

        if ($validation) {
            $name = $req->get('name');
            $phone = $req->get('phone');
            $email = $req->get('email');
            $country = $req->get('country');
            $special_note = $req->get('special_note');

            $user = DB::table('users')->where('id', $id)->first();

            $pic_name = $user->pic;

            $pic = $req->file('pic');
            if (isset($pic)) {
                // Delete old profile picture
                if ($user->pic) {
                    $oldPicPath = public_path('uploads/user/' . $user->pic);
                    if (file_exists($oldPicPath)) {
                        unlink($oldPicPath);
                    }
                }

                // Move and store the new profile picture
                $pic_name = time() . '.' . $pic->extension();
                $pic->move(public_path('uploads/user'), $pic_name);
            }

            $update = DB::table('users')->where('id', $id)->update([
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'country' => $country,
                'pic' => $pic_name,
                'special_note' => $special_note,
            ]);

            if ($update) {
                return back()->with('success', 'Updated Successfully');
            } else {
                return back()->with('error', 'Data Not Updated, Technical Error');
            }
        } else {
            return back()->withInput()->withErrors($validation);
        }
    }


    public function activateUser($id)
    {
        $affectedRows = DB::table('users')
            ->where('id', $id)
            ->update(['status' => 1]);

        if ($affectedRows > 0) {
            return redirect()->back()->with('success', 'User activated successfully.');
        }

        return redirect()->back()->with('error', 'User not found or could not be activated.');
    }

    public function suspendUser($id)
    {
        $affectedRows = DB::table('users')
            ->where('id', $id)
            ->update(['status' => 2]);

        if ($affectedRows > 0) {
            return redirect()->back()->with('success', 'User suspended successfully.');
        }

        return redirect()->back()->with('error', 'User not found or could not be suspended.');
    }

    public function updateIsViewed(Request $request)
    {
        // Validate the request
        $request->validate([
            'id' => 'required|exists:notifications,id',
        ]);

        // Update the is_viewed field using the Query Builder
        DB::table('notifications')
            ->where('id', $request->id)
            ->update(['is_viewed' => true]);

        // You can also perform additional logic if needed

        return response()->json(['success' => true]);
    }


    public function changePassword(Request $request)
    {
        // Validate the form data
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        // Check if the current password matches the authenticated user's password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return redirect()->back()->with('error', 'The current password is incorrect.');
        }

        // Update the user's password
        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }

    public function updateProfile(Request $request)
    {
        // Validate the form data
        $request->validate([
            'id' => 'required',
        ]);

        $id = $request->input('id');

        // Fetch the user from the database
        $user = DB::table('users')->where('id', $id)->first();

        // Update the user profile in the database
        DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'country' => $request->input('country'),
                'gender' => $request->input('gender'),

                // Other fields...
            ]);

        // Handle profile picture upload
        if ($request->hasFile('pic')) {
            // Delete old profile picture if exists
            if ($user->pic && file_exists(public_path('/profile/' . $user->pic))) {
                unlink(public_path('/profile/' . $user->pic));
            }

            $image = $request->file('pic');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/profile/'), $imageName);

            // Save the profile picture to the user
            DB::table('users')
                ->where('id', $id)
                ->update(['pic' => $imageName]);
        }

        return back()->with('success', 'Profile updated successfully');
    }

    public function deleteUser($id)
    {
        // Delete the account with the given ID
        DB::table('users')->where('id', $id)->delete();
        return back()->with('success', 'User deleted successfully');
    }

    public function deleteUserSelf($id)
    {
        // Delete the account with the given ID
        DB::table('users')->where('id', $id)->delete();
        return redirect('/login')->with('success', 'User deleted successfully');
    }


    public function saveRegister(request $req)
    {


        $validation = $req->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        if ($validation) {

            $verificationToken = Str::random(40);
            $otp = rand(100000, 999999);
            $ref_code = strtoupper(Str::random(3)) . random_int(100, 999);

            $data = array(
                "ref_code" => $ref_code,
                "ref_by" => $req->get('ref_by'),
                "name" => $req->get('name'),
                "email" => $req->get('email'),
                "password" => Hash::make($req->get('password')),
                "status" => 0,
                "level" => 1,
                'verification_token' => $verificationToken,
                'otp' => $otp
            );


            $insert = DB::table('users')->insert($data);


            Mail::send('emails.email_verification', [
                'verificationToken' => $verificationToken,
                'otp' => $otp,
            ], function ($message) use ($req) {
                $message->from('secure@botaex.com', 'BotaEx');
                $message->to($req->get('email'));
                $message->subject('Verify Email Address');
            });

            if ($insert) {
                return redirect('/verify/' . $verificationToken)->with('success', 'Enter OTP Received in Email');
            } else {
                return back()->withInput()->with('error', 'Data Not Saved, Technical Error');
            }
        } else {
            return back()->withInput()->withErrors($validation);
        }
    }
}
