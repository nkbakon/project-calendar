<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {        
        return view('todo.index');
    }

    public function create()
    {
        return view('todo.create');
    }

    public function edit(Todo $todo)
    {
        return view('todo.edit', compact('todo'));
    }

    public function destroy(Request $request)
    {
        $todo = Todo::find($request->data_id);
        if($todo)
        {
            $todo->delete();
            return redirect()->route('todo.index')->with('delete', 'To do deleted successfully.');
        }
        else
        {
            return redirect()->route('todo.index')->with('delete', 'No To do found!.');
        }    
    }
}
