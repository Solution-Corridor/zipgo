<?php
// app/Http/Controllers/CityController.php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CityController extends Controller
{
  // List all cities
  public function index()
  {
    $cities = City::orderBy('name', 'asc')->get();
    return view('admin.cities.index', compact('cities'));
  }

  // Show create form
  public function create()
  {
    return view('admin.cities.create');
  }

  // Store new city
  public function store(Request $request)
  {
    $request->validate([
      'name'    => 'required|string|max:255',
      'slug'    => 'required|string|unique:cities,slug',
      'pic'     => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
      'detail'  => 'required|string',
    ]);

    $picPath = null;
    if ($request->hasFile('pic')) {
      $file = $request->file('pic');
      $filename = time() . '_' . $file->getClientOriginalName();
      $picPath = 'uploads/cities/' . $filename;
      $file->move(public_path('uploads/cities'), $filename);
    }

    City::create([
      'name'   => $request->name,
      'slug'   => $request->slug,
      'pic'    => $picPath,
      'detail' => $request->detail,
    ]);

    return redirect()->route('cities.index')
      ->with('success', 'City created successfully.');
  }

  // Show edit form
  public function edit($id)
  {
    $city = City::findOrFail($id);
    return view('admin.cities.edit', compact('city'));
  }

  // Update city
  public function update(Request $request, $id)
  {
    $city = City::findOrFail($id);

    $request->validate([
      'name'    => 'required|string|max:255',
      'slug'    => 'required|string|unique:cities,slug,' . $city->id,
      'pic'     => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
      'detail'  => 'required|string',
    ]);

    $data = [
      'name'   => $request->name,
      'slug'   => $request->slug,
      'detail' => $request->detail,
    ];

    if ($request->hasFile('pic')) {
      // Delete old image
      if ($city->pic && file_exists(public_path($city->pic))) {
        unlink(public_path($city->pic));
      }
      $file = $request->file('pic');
      $filename = time() . '_' . $file->getClientOriginalName();
      $picPath = 'uploads/cities/' . $filename;
      $file->move(public_path('uploads/cities'), $filename);
      $data['pic'] = $picPath;
    }

    $city->update($data);

    return redirect()->route('cities.index')
      ->with('success', 'City updated successfully.');
  }

  // Delete city
  public function destroy($id)
  {
    $city = City::findOrFail($id);
    if ($city->pic && file_exists(public_path($city->pic))) {
      unlink(public_path($city->pic));
    }
    $city->delete();

    return redirect()->route('cities.index')
      ->with('success', 'City deleted successfully.');
  }

  // Toggle active status (AJAX)
  public function toggleActive($id)
  {
    $city = City::findOrFail($id);
    $city->is_active = !$city->is_active;
    $city->save();

    if (request()->ajax()) {
      return response()->json(['success' => true, 'is_active' => $city->is_active]);
    }

<<<<<<< HEAD
    // Show edit form
    public function edit($id)
    {
        $city = City::findOrFail($id);
        return view('admin.cities.edit', compact('city'));
    }

    // Update city
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'slug'    => 'required|string|unique:cities,slug,' . $city->id,
            'pic'     => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'detail'  => 'nullable|string',
        ]);

        $data = [
            'name'   => $request->name,
            'slug'   => $request->slug,
            'detail' => $request->detail,
        ];

        if ($request->hasFile('pic')) {
            // Delete old image
            if ($city->pic && file_exists(public_path($city->pic))) {
                unlink(public_path($city->pic));
            }
            $file = $request->file('pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $picPath = 'uploads/cities/' . $filename;
            $file->move(public_path('uploads/cities'), $filename);
            $data['pic'] = $picPath;
        }

        $city->update($data);

        return redirect()->route('cities.index')
            ->with('success', 'City updated successfully.');
    }

    // Delete city
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        if ($city->pic && file_exists(public_path($city->pic))) {
            unlink(public_path($city->pic));
        }
        $city->delete();

        return redirect()->route('cities.index')
            ->with('success', 'City deleted successfully.');
    }

     // Toggle active status (AJAX)
    public function toggleActive($id)
    {
        $city = City::findOrFail($id);
        $city->is_active = !$city->is_active;
        $city->save();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'is_active' => $city->is_active]);
        }

        return redirect()->back()->with('success', 'Status updated.');
    }
}
=======
    return redirect()->back()->with('success', 'Status updated.');
  }
}
>>>>>>> 9289589 (blog)
