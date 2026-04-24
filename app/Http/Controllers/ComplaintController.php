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
            'subject' => 'required|string|max:120',
            'detail'  => 'required|string|min:10',
            'screenshot' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:5120',
        ]);

        $userId = Auth::id();

        // Check if user already has a pending complaint
        $hasPendingComplaint = Complaint::where('user_id', $userId)
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingComplaint) {
            return redirect()
                ->route('my_complaints')
                ->with('error', 'You already have a pending complaint. Please wait until it is resolved.');
        }

        // Check if user has a recently resolved complaint within the last 24 hours
        $lastResolvedComplaint = Complaint::where('user_id', $userId)
            ->where('status', 'resolved')
            ->latest('resolved_at')
            ->first();

        if ($lastResolvedComplaint && $lastResolvedComplaint->resolved_at->diffInHours(now()) < 24) {
            return redirect()
                ->route('my_complaints')
                ->with('error', 'You can only submit a new complaint after 24 hours from your last resolved complaint.');
        }

        if ($request->hasFile('screenshot')) {

            // Store the new file and get the path
            $file = $request->file('screenshot');

            // Option 1: Simple filename (recommended for most cases)
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->move(public_path('uploads/complaints'), $filename);
            // → then $path would be full server path → you usually want relative path
        }

        Complaint::create([
            'user_id' => $userId,
            'subject' => $validated['subject'],
            'detail'  => $validated['detail'],
            'screenshot' => isset($path) ? 'uploads/complaints/' . $filename : null,
            'status'  => 'pending',
        ]);

        return redirect()
            ->route('my_complaints')
            ->with('success', 'Your complaint has been submitted successfully. We will review it soon.');
    }


    // Optional: show single complaint detail
    public function show(Complaint $complaint)
    {
        $this->authorize('view', $complaint); // if using policies later

        return view('user.complaint_show', compact('complaint'));
    }

    public function update(Request $request)
    {
        $complaintId = $request->input('id');
        $complaint   = Complaint::findOrFail($complaintId);

        $validated = $request->validate([
            'status'      => 'required|in:pending,in_progress,resolved,rejected,not_valid',
            'admin_reply' => 'nullable|string|max:2000',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:5120',
        ]);

        $updateData = [
            'status'      => $validated['status'],
            'admin_reply' => $validated['admin_reply'] ?? null,
        ];

        // ✅ Handle single file upload
        if ($request->hasFile('attachment')) {

            // Delete old file if exists
            if ($complaint->attachments) {
                $oldPath = public_path('uploads/complaints/' . $complaint->attachments);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file = $request->file('attachment');

            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/complaints'), $filename);

            // Save single filename
            $updateData['attachments'] = 'uploads/complaints/' . $filename;
        }

        // ✅ Auto resolved timestamp
        if ($validated['status'] === 'resolved' && $complaint->status !== 'resolved') {
            $updateData['resolved_at'] = now();
        }

        $complaint->update($updateData);

        return back()->with('success', 'Complaint #' . $complaint->id . ' updated successfully.');
    }



    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);

        // Optional: Delete any associated files (screenshot, attachments) from storage
        if ($complaint->screenshot && file_exists(public_path($complaint->screenshot))) {
            unlink(public_path($complaint->screenshot));
        }
        if ($complaint->attachments && file_exists(public_path($complaint->attachments))) {
            unlink(public_path($complaint->attachments));
        }

        $complaint->delete();

        return redirect()->back()->with('success', 'Complaint deleted successfully.');
    }
}
