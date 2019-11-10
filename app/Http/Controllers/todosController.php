<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo; // trait

class todosController extends Controller
{
    public function index() {

        $todos = Todo::all();

        return view('todos.index', ['todos' => $todos]);
        // return view('todos')->with('todos', $todos);
        // return view('todos', compact('todos'));

    }

    public function show(Todo $todo) {

        return view('todos.show')->with('todo', $todo);

    }

    public function create() {
        return view('todos.create');
    }

    public function store(Request $request) {

        // return $request->all();
        // return $request->input('todoTitle');
        // $request->todoTitle;

        // $request->validate([
        //     'todoTitle' => 'required|min:6',
        //     'todoDescription' => 'required'
        // ]);

        $this->validate($request, [
            'todoTitle' => 'required',
            'todoDescription' => 'required'
        ]);

        $todo = new Todo();

        $todo->title = $request->todoTitle;
        $todo->description = $request->todoDescription;
        $todo->save();

        $request->session()->flash('success', 'Todo created successfully');

        return redirect('/todos');

    }

    public function edit(Todo $todo) {

        return view('todos.edit')->with('todo', $todo);

    }

    public function update(Request $request, Todo $todo) {

        $this->validate($request, [
            'todoTitle' => 'required',
            'todoDescription' => 'required'
        ]);

        $todo->title = $request->get('todoTitle');
        $todo->description = $request->get('todoDescription');

        $todo->save();

        $request->session()->flash('success', 'Todo updated successfully');

        return redirect('/todos');
    }

    public function destroy(Todo $todo) {

        $todo->delete();

        session()->flash('success', 'Todo deleted successfully');

        return redirect('/todos');
    }

    public function complete(Todo $todo) {

        $todo->completed = true;

        $todo->save();

        session()->flash('success', 'Todo completed successfully');

        return redirect('/todos');
    }
}
