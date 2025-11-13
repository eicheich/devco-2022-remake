<?php

namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $updates = Update::latest()->paginate(10);
        return view('updates.index', compact('updates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('updates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'version' => 'nullable|string|max:50',
        ]);

        Update::create($request->all());

        return redirect()->route('updates.index')->with('success', 'Update created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Update $update)
    {
        return view('updates.show', compact('update'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Update $update)
    {
        return view('updates.edit', compact('update'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Update $update)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'version' => 'nullable|string|max:50',
        ]);

        $update->update($request->all());

        return redirect()->route('updates.index')->with('success', 'Update updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Update $update)
    {
        $update->delete();
        return redirect()->route('updates.index')->with('success', 'Update deleted successfully!');
    }
}
