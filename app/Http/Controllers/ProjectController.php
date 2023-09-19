<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProjectController extends Controller
{
    
    public function index()
    {        
        return view('projects.index');
    }

    public function create()
    {
        return view('projects.create');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function destroy(Request $request)
    {
        $project = Project::find($request->data_id);
        if($project)
        {
            $documents = json_decode($project->documents);
            foreach ($documents as $document) {
                $filenameWithoutExtension = pathinfo(basename($document), PATHINFO_FILENAME);
                Cloudinary::destroy($filenameWithoutExtension);
            }
            $project->delete();
            return redirect()->route('projects.index')->with('delete', 'Project deleted successfully.');
        }
        else
        {
            return redirect()->route('projects.index')->with('delete', 'No Project found!.');
        }    
    }

    public function view(Project $project)
    {
        return view('projects.view', compact('project'));
    }
    
}