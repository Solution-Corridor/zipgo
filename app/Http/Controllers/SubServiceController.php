<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SubService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SubServiceController extends Controller
{
  public function index()
  {
    $subServices = SubService::with('service')->orderBy('id', 'desc')->get();
    return view('admin.sub_services.index', compact('subServices'));
  }

  public function create()
  {
    $services = Service::orderBy('name')->get();
    return view('admin.sub_services.create', compact('services'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'service_id'  => 'required|exists:services,id',
      'name'        => 'required|string|max:255',
      'slug'        => 'required|string|unique:sub_services,slug',
      'price'       => 'required|numeric|min:0',
      'description' => 'nullable|string',
      'image'       => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
      'is_active'   => 'nullable|boolean',
    ]);

    $is_active = $request->has('is_active') ? 1 : 0;
    $is_priority = $request->has('is_priority') ? 1 : 0;

    // Handle image upload (same as ServiceController)
    $imagePath = null;
    if ($request->hasFile('image')) {
      $file = $request->file('image');
      $filename = time() . '_' . $file->getClientOriginalName();
      $file->move(public_path('uploads/sub-services'), $filename);
      $imagePath = 'uploads/sub-services/' . $filename;
    }

    SubService::create([
      'service_id'  => $request->service_id,
      'name'        => $request->name,
      'slug'        => $request->slug,
      'price'       => $request->price,
      'description' => $request->description,
      'image'       => $imagePath,
      'is_active'   => $is_active,
      'is_priority' => $is_priority,
    ]);

    return redirect()->route('sub-services.index')
      ->with('success', 'Sub Service created successfully.');
  }

  public function edit(SubService $subService)
  {
    $services = Service::orderBy('name')->get();
    return view('admin.sub_services.edit', compact('subService', 'services'));
  }

  public function update(Request $request, SubService $subService)
  {
    $request->validate([
      'service_id'  => 'required|exists:services,id',
      'name'        => 'required|string|max:255',
      'slug'        => 'required|string|unique:sub_services,slug,' . $subService->id,
      'price'       => 'required|numeric|min:0',
      'description' => 'nullable|string',
      'image'       => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
      'is_active'   => 'nullable|boolean',
    ]);

    $is_active = $request->has('is_active') ? 1 : 0;
    $data['is_priority'] = $request->has('is_priority') ? 1 : 0;

    $data = [
      'service_id'  => $request->service_id,
      'name'        => $request->name,
      'slug'        => $request->slug,
      'price'       => $request->price,
      'description' => $request->description,
      'is_active'   => $is_active,
    ];

    // Handle image update
    if ($request->hasFile('image')) {
      // Delete old image if exists
      if ($subService->image && file_exists(public_path($subService->image))) {
        unlink(public_path($subService->image));
      }

      $file = $request->file('image');
      $filename = time() . '_' . $file->getClientOriginalName();
      $file->move(public_path('uploads/sub-services'), $filename);
      $data['image'] = 'uploads/sub-services/' . $filename;
    }

    $subService->update($data);

    return redirect()->route('sub-services.index')
      ->with('success', 'Sub Service updated successfully.');
  }

  public function destroy(SubService $subService)
  {
    // Delete image file
    if ($subService->image && file_exists(public_path($subService->image))) {
      unlink(public_path($subService->image));
    }
    $subService->delete();

    return redirect()->route('sub-services.index')
      ->with('success', 'Sub Service deleted successfully.');
  }

  public function togglePriority(Request $request)
  {
    $subService = SubService::findOrFail($request->id);
    $subService->is_priority = $request->is_priority;
    $subService->save();

    return response()->json([
      'success' => true,
      'message' => 'Priority updated successfully'
    ]);
  }
}
