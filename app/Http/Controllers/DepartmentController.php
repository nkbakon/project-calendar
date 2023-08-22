<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    
    public function index()
    {        
        return view('departments.index');
    }

    public function create()
    {
        return view('departments.create');
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function destroy(Request $request)
    {
        $department = Department::find($request->data_id);
        if($department)
        {
            $department->delete();
            return redirect()->route('departments.index')->with('delete', 'Department deleted successfully.');
        }
        else
        {
            return redirect()->route('departments.index')->with('delete', 'No Department found!.');
        }    
    }
}