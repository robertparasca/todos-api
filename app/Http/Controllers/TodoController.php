<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request) {
        return Todo::all();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'description' => 'required|max:255',
            'completed' => 'required|boolean'
        ]);

        $newTodo = new Todo();

        $newTodo->description = $validated['description'];
        $newTodo->completed = $validated['completed'];

        $newTodo->save();

        return response()->json($newTodo);
    }

    public function update(Request $request, $id) {
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json(['errors' => 'Todo not found'], 404);
        }

        $validated = $request->validate([
            'description' => 'required|max:255',
            'completed' => 'required|boolean'
        ]);
        $todo->description = $validated['description'];
        $todo->completed = $validated['completed'];

        $todo->save();

        return response()->json($todo);
    }

    public function delete($id) {
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json(['errors' => 'Todo not found'], 404);
        }

        Todo::destroy([$id]);

        return response()->json(['data' => 'Successfully deleted']);
    }
}
