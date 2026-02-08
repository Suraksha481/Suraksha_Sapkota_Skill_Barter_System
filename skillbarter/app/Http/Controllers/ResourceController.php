<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResourceModel;

class ResourceController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240'
        ]);

        $path = $request->file('file')->store('uploads');

        ResourceModel::create([
            'filename' => $request->file('file')->getClientOriginalName(),
            'path' => $path,
        ]);

        return back()->with('success', 'File uploaded!');
    }

    public function serve(ResourceModel $resource)
    {
        return response()->download(storage_path("app/".$resource->path));
    }
}
