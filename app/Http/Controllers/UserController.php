<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('file-upload');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file('photo');
        // dd($file);
        $request->validate([
            // 'photo'=> 'required|mimes:png,jpg,jpeg|max:3000|dimensions:min_width:100,min_height:100,max_width:1000,max_height:1000'
              'photo'=> 'required|mimes:png,jpg,jpeg|max:3000'
        ]);
        // $path = $request->file('photo')->store('image','public');
        $path = $request->photo->store('image','local');
        return redirect()->route('user.index')->with('status','User Image Upload Successfully.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
