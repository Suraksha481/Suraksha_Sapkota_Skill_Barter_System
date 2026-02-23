<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;

class TeacherResourcesController extends Controller
{
    /**
     * Display teacher's resources
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $resources = $user->resources()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('teacher.resources.index', compact('resources'));
    }

    /**
     * Show create resource form
     */
    public function create()
    {
        return view('teacher.resources.create');
    }

    /**
     * Store a newly created resource
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,txt|max:10240',
            'category' => 'nullable|string|max:100',
        ]);

        $uploaded = $request->file('file');
        if (! $uploaded) {
            return back()->with('error', 'No file uploaded.');
        }

        $filePath = $uploaded->store('resources', 'public');

        // Fallback filename if original not available
        $originalName = $uploaded->getClientOriginalName() ?? basename($filePath);

        Resource::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'file_path' => $filePath,
            'filename' => $originalName,
            'mime' => $uploaded->getClientMimeType() ?? null,
            'size' => $uploaded->getSize() ?? null,
        ]);

        return redirect()->route('teacher.resources.index')
            ->with('success', 'Resource uploaded successfully!');
    }

    /**
     * Delete a resource
     */
    public function destroy(Resource $resource)
    {
        $this->authorize('delete', $resource);

        $resource->delete();

        return redirect()->route('teacher.resources.index')
            ->with('success', 'Resource deleted successfully!');
    }
}
