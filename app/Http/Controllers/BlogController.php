<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

  public function add()
  {
    return view('admin.blogs.add');
  }

  public function blogs_list()
  {
    $blogs = Blog::orderBy('blog_id', 'desc')->paginate(15);
    return view('admin.blogs.manage_blog', compact('blogs'));
  }

  public function save(Request $request)
  {
    // Convert checkbox to proper 1/0 before validation
    $request->merge([
      'is_commentable' => $request->has('is_commentable') ? 1 : 0
    ]);

    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'slug' => 'nullable|string|max:255|unique:blogs,slug',
      'detail' => 'required|string',
      'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'keywords' => 'nullable|string|max:500',
      'short_description' => 'nullable|string|max:1000',
      'page_schema' => 'nullable|string',
      'is_commentable' => 'required|in:0,1', // now expects 0 or 1
    ]);

    if (empty($validated['slug'])) {
      $validated['slug'] = Str::slug($validated['title']);
    }

    if ($request->hasFile('picture')) {
      $file = $request->file('picture');
      $filename = time() . '_' . $file->getClientOriginalName();
      $destination = public_path('uploads/blogs'); // Creates /uploads/blogs
      $file->move($destination, $filename);
      $validated['picture'] = 'blogs/' . $filename; // store relative path
    }

    Blog::create($validated);

    return redirect()->route('blogs.list')
      ->with('success', 'Blog created successfully.');
  }

  public function edit(Blog $blog)
  {
    return view('admin.blogs.edit', compact('blog'));
  }

  public function update(Request $request, Blog $blog)
  {
    // Convert checkbox to proper 1/0 before validation
    $request->merge([
      'is_commentable' => $request->has('is_commentable') ? 1 : 0
    ]);

    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $blog->blog_id . ',blog_id',
      'detail' => 'required|string',
      'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'keywords' => 'nullable|string|max:500',
      'short_description' => 'nullable|string|max:1000',
      'page_schema' => 'nullable|string',
      'is_commentable' => 'required|in:0,1',
    ]);

    if (empty($validated['slug'])) {
      $validated['slug'] = Str::slug($validated['title']);
    }

    if ($request->hasFile('picture')) {
      // Delete old image from public folder
      if ($blog->picture && file_exists(public_path($blog->picture))) {
        unlink(public_path($blog->picture));
      }

      $file = $request->file('picture');
      $filename = time() . '_' . $file->getClientOriginalName();
      $destination = public_path('uploads/blogs');
      $file->move($destination, $filename);
      $validated['picture'] = 'uploads/blogs/' . $filename;
    }

    $blog->update($validated);

    return redirect()->route('blogs.list')
      ->with('success', 'Blog updated successfully.');
  }

  public function destroy(Blog $blog)
  {
    if ($blog->picture && file_exists(public_path($blog->picture))) {
      unlink(public_path($blog->picture));
    }
    $blog->delete();

    return redirect()->route('blogs.list')
      ->with('success', 'Blog deleted successfully.');
  }

  public function toggleCommentable(Blog $blog)
  {
    $blog->is_commentable = !$blog->is_commentable;
    $blog->save();

    return response()->json(['success' => true, 'is_commentable' => $blog->is_commentable]);
  }
}
