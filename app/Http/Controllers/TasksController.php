<?php
// app/Http/Controllers/TasksController.php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TasksController extends Controller
{
    /**
     * Display a listing of the tasks and the create form.
     */
    public function tasks()
    {
        $tasks = Task::latest()->get();
        return view('admin.tasks', compact('tasks'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'duration'  => 'required|integer|min:1',
            'file'      => 'required|file|mimes:jpeg,png,jpg,gif,mp4,avi,mov,mkv|max:40480', 
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Define upload path
            $uploadPath = public_path('uploads/tasks');
            
            // Create directory if it doesn't exist
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            // Move file to uploads/tasks
            $file->move($uploadPath, $fileName);
            
            // Store relative path in database
            $filePath = 'uploads/tasks/' . $fileName;
        }

        Task::create([
            'name'      => $request->name,
            'duration'  => $request->duration,
            'file_path' => $filePath,
        ]);

        return redirect()->route('tasks')->with('success', 'Task created successfully.');
    }

    
    public function edit(Task $task)
    {
        return view('admin.edit_task', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'duration'  => 'required|integer|min:1',
            'price'     => 'required|numeric|min:0',
            'file'      => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,avi,mov,mkv|max:20480',
        ]);

        $data = $request->only(['name', 'duration', 'price']);

        // Handle file upload if present
        if ($request->hasFile('file')) {
            // Delete old file
            $oldFilePath = public_path($task->file_path);
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }

            // Upload new file
            $file = $request->file('file');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/tasks');
            
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            $file->move($uploadPath, $fileName);
            $data['file_path'] = 'uploads/tasks/' . $fileName;
        }

        $task->update($data);

        return redirect()->route('tasks')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        // Delete associated file
        $filePath = public_path($task->file_path);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        
        $task->delete();

        return redirect()->route('tasks')->with('success', 'Task deleted successfully.');
    }
}