<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Auth\Events\Validated;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::orderBy("status", "asc")->get();

        return view("todo", compact("todos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string|max:255"
        ]);

        Todo::create([
            "title" => $request->title,
            "status" => false
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $todo = Todo::findOrFail($id);
        
        // Flip the boolean status (if true make it false, if false make it true)
        $todo->status = !$todo->status;
        $todo->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Todo::findOrFail($id)->delete();
        
        return redirect()->back();
    }
}
