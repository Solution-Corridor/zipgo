<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.my_complaints', compact('complaints'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject'    => 'required|string|max:120',
            'detail'     => 'required|string|min:10',
            'screenshot' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:5120',
        ]);

        $userId = Auth::id();

        if (Complaint::where('user_id', $userId)->where('status', 'pending')->exists()) {
            return redirect()->route('my_complaints')
                ->with('error', 'You already have a pending complaint.');
        }

        $screenshotPath = null;

        if ($request->hasFile('screenshot')) {
            $file = $request->file('screenshot');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/complaints'), $filename);
            $screenshotPath = 'uploads/complaints/' . $filename;
        }

        Complaint::create([
            'user_id'    => $userId,
            'subject'    => $validated['subject'],
            'detail'     => $validated['detail'],
            'screenshot' => $screenshotPath,
            'status'     => 'pending',
        ]);

        return redirect()->route('my_complaints')
            ->with('success', 'Complaint submitted successfully.');
    }

    public function show(Complaint $complaint)
    {
        $this->authorize('view', $complaint);
        return view('user.complaint_show', compact('complaint'));
    }

    public function complaints()
    {
        $pending = Complaint::with('user')->where('status', 'pending')->latest()->paginate(20);
        $others = Complaint::with('user')->where('status', '!=', 'pending')->latest()->paginate(20);

        return view('admin.complaints', compact('pending', 'others'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status'      => 'required|in:pending,in_progress,resolved,rejected,not_valid',
            'admin_reply' => 'nullable|string|max:2000',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:5120',
        ]);

        $updateData = [
            'status'      => $validated['status'],
            'admin_reply' => $validated['admin_reply'] ?? null,
        ];

        if ($request->hasFile('attachment')) {
            if ($complaint->attachments) {
                @unlink(public_path($complaint->attachments));
            }

            $file = $request->file('attachment');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/complaints'), $filename);
            $updateData['attachments'] = 'uploads/complaints/' . $filename;
        }

        if ($validated['status'] === 'resolved' && $complaint->status !== 'resolved') {
            $updateData['resolved_at'] = now();
        }

        $complaint->update($updateData);

        return back()->with('success', 'Complaint updated successfully.');
    }

    public function destroy(Complaint $complaint)
    {
        if ($complaint->screenshot) @unlink(public_path($complaint->screenshot));
        if ($complaint->attachments) @unlink(public_path($complaint->attachments));

        $complaint->delete();

        return back()->with('success', 'Complaint deleted successfully.');
    }
}