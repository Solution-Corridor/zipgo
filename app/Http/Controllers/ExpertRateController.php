<?php

namespace App\Http\Controllers;

use App\Models\ExpertRate;
use App\Models\ExpertDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ExpertRateController extends Controller
{
    private function getCurrentExpert()
    {
        $expert = ExpertDetail::where('user_id', Auth::id())->first();
        if (!$expert) {
            abort(403, 'You are not registered as an expert.');
        }
        return $expert;
    }

    public function index()
    {
        $expert = $this->getCurrentExpert();
        $rates = $expert->rates()->latest()->get();
        return view('expert.expert_rates', compact('rates'));
    }

    public function store(Request $request)
    {
        $expert = $this->getCurrentExpert();

        $request->validate([
            'service_name' => 'required|string|max:100',
            'rate'         => 'required|numeric|min:0',
            'description'  => 'nullable|string|max:500',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['service_name', 'rate', 'description']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/expert-rates'), $filename);
            $data['image'] = $filename;
        }

        $expert->rates()->create($data);

        return redirect()->route('expert.rates')
            ->with('success', 'Service rate added successfully.');
    }

    public function update(Request $request, ExpertRate $rate)
    {
        $expert = $this->getCurrentExpert();

        if ($rate->expert_id !== $expert->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'service_name' => 'required|string|max:100',
            'rate'         => 'required|numeric|min:0',
            'description'  => 'nullable|string|max:500',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['service_name', 'rate', 'description']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($rate->image && file_exists(public_path('uploads/expert-rates/' . $rate->image))) {
                unlink(public_path('uploads/expert-rates/' . $rate->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/expert-rates'), $filename);
            $data['image'] = $filename;
        }

        $rate->update($data);

        return redirect()->route('expert.rates')
            ->with('success', 'Service rate updated.');
    }

    public function destroy(ExpertRate $rate)
    {
        $expert = $this->getCurrentExpert();

        if ($rate->expert_id !== $expert->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image file
        if ($rate->image && file_exists(public_path('uploads/expert-rates/' . $rate->image))) {
            unlink(public_path('uploads/expert-rates/' . $rate->image));
        }

        $rate->delete();

        return redirect()->route('expert.rates')
            ->with('success', 'Service rate deleted.');
    }
}
