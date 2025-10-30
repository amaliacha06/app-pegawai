<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartemensController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::latest()->paginate(10);
        return view('departements.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        Department::create($request->only(['nama_departemen']));

        return redirect()->route('departments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $department = Department::findOrFail($id);
        return view('departements.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $department = Department::findOrFail($id);
        return view('departements.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->only(['nama_departemen']));

        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('departments.index');
    }
}