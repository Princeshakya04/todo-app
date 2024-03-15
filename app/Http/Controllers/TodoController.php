<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Http\Requests\TodoRequest;

class TodoController extends Controller
{
    public function index()
    {
        $todoList = Todo::all();
        return view('todos.index', [
            'todoList' => $todoList
        ]);
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(TodoRequest $request)
    {
        if (Todo::where('title', $request->title)->exists()) {
            $request->session()->flash('alert-danger', 'A todo with the same title already exists');
            return to_route('todos.create');
        }

        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => 0
        ]);

        $request->session()->flash('alert-success', 'Todo is created successfully');

        return \to_route('todos.index');
    }

    public function show($id)
    {
        $todo = Todo::find($id);
        if (! $todo ) {
            request()->session()->flash('error', 'Unable to locate the Todo');
            return to_route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }
        return view('todos.show', ['todo' => $todo]);
    }

    public function edit($id)
    {
        $todo = Todo::find($id);
        if (! $todo ) {
            request()->session()->flash('error', 'Unable to locate the Todo');
            return to_route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }
        return view('todos.edit', ['todo' => $todo]);
    }

    public function update(TodoRequest $request)
    {
        $todo = Todo::find($request->todo_id);
        if (! $todo ) {
            request()->session()->flash('error', 'Unable to locate the Todo');
            return to_route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }

        if (Todo::where('title', $request->title)->where('id', '!=', $todo->id)->exists()) {
            $request->session()->flash('alert-danger', 'A todo with the same title already exists');
            return to_route('todos.edit', ['id' => $todo->id])->withErrors([
                'error' => 'A todo with the same title already exists'
            ]);
        }    

        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->is_completed
        ]);
        $request->session()->flash('alert-info', 'Todo Updated Successfully');
        return to_route('todos.index');
    }

    public function destroy(Request $request)
    {
        $todo = Todo::find($request->todo_id);
        if (! $todo ) {
            request()->session()->flash('error', 'Unable to locate the Todo');
            return to_route('todos.index')->withErrors([
                'error' => 'Unable to locate the Todo'
            ]);
        }

        $todo->delete();
        $request->session()->flash('alert-success', 'Todo Delete Successfully');
        return to_route('todos.index');
    }
}
