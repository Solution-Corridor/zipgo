<?php
// app/Http/Controllers/ServiceController.php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    // Display list of services
    public function index()
    {
        $services = Service::orderBy('id', 'desc')->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    // Show form to create a new service
    public function create()
    {
        return view('admin.services.create');
    }

    // Store a new service
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'slug'      => 'required|string|unique:services,slug',
            'price'     => 'required|numeric|min:0',
            'detail'    => 'nullable|string',
            'picture'   => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        // Handle image upload
        $picPath = null;
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/services'), $filename);
            $picPath = 'uploads/services/' . $filename;
        }

        Service::create([
            'name'   => $request->name,
            'slug'   => $request->slug,
            'pic'    => $picPath,
            'price'  => $request->price,
            'detail' => $request->detail,
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Service created successfully.');
    }

    // Show form to edit a service
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    // Update the service
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'slug'      => 'required|string|unique:services,slug,' . $service->id,
            'price'     => 'required|numeric|min:0',
            'detail'    => 'nullable|string',
            'picture'   => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $data = [
            'name'   => $request->name,
            'slug'   => $request->slug,
            'price'  => $request->price,
            'detail' => $request->detail,
        ];

        // Handle image update
        if ($request->hasFile('picture')) {
            // Delete old image
            if ($service->pic && file_exists(public_path($service->pic))) {
                unlink(public_path($service->pic));
            }
            $file = $request->file('picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/services'), $filename);
            $data['pic'] = 'uploads/services/' . $filename;
        }

        $service->update($data);

        return redirect()->route('services.index')
            ->with('success', 'Service updated successfully.');
    }

    // Delete the service
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        // Delete image
        if ($service->pic && file_exists(public_path($service->pic))) {
            unlink(public_path($service->pic));
        }
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service deleted successfully.');
    }

    // Toggle active status (AJAX or simple POST)
public function toggleActive($id)
{
    $service = Service::findOrFail($id);
    $service->is_active = !$service->is_active;
    $service->save();

    // If you want JSON response for AJAX:
    if (request()->ajax()) {
        return response()->json(['success' => true, 'is_active' => $service->is_active]);
    }

    // Or redirect back
    return redirect()->back()->with('success', 'Status updated.');
}

}