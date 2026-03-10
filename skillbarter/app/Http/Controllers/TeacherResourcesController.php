<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

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
        $user = auth()->user();

    if (!$user->canTeach()) {
        abort(403, 'Only approved teachers can upload resources.');
    }
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

        // Build payload only with columns that actually exist in DB
        $data = ['user_id' => $user->id, 'file_path' => $filePath, 'filename' => $originalName, 'mime' => $uploaded->getClientMimeType() ?? null, 'size' => $uploaded->getSize() ?? null];

        if (Schema::hasColumn('resources', 'title')) {
            $data['title'] = $request->input('title');
        }
        if (Schema::hasColumn('resources', 'description')) {
            $data['description'] = $request->input('description');
        }
        if (Schema::hasColumn('resources', 'category')) {
            $data['category'] = $request->input('category');
        }

        try {
            Resource::create($data);
        } catch (\Exception $e) {
            Log::error('Resource upload failed: '.$e->getMessage());
            return back()->with('error', 'Failed to save resource. Please check server logs.');
        }

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

    /**
     * Download a resource if the current user is allowed to view it.
     */
    public function download(Resource $resource)
    {
        $user = auth()->user();
        $teacher = $resource->user;

        // owner always allowed
        if ($user && $user->id === $teacher->id) {
            return response()->download(storage_path('app/public/'.$resource->file_path), $resource->filename);
        }

        // only a student with an accepted request may download
        if ($user && $user->isStudent()) {
            $accepted = \App\Models\RequestModel::where('responder_id', $teacher->id)
                ->where('requester_id', $user->id)
                ->where('status', 'accepted')
                ->exists();

            if ($accepted) {
                return response()->download(storage_path('app/public/'.$resource->file_path), $resource->filename);
            }
        }

        abort(403);
    }
}
