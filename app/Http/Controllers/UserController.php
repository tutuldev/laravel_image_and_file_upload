<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();

        return view('file-upload',compact('users'));

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
        // $file = $request->file('photo');
        // // dd($file);
        // $request->validate([
        //     // 'photo'=> 'required|mimes:png,jpg,jpeg|max:3000|dimensions:min_width:100,min_height:100,max_width:1000,max_height:1000'
        //       'photo'=> 'required|mimes:png,jpg,jpeg|max:3000'
        // ]);
        // // $path = $request->file('photo')->store('image','public');
        // // $path = $request->photo->store('image','local');

        // // $fileName =$file->getClientOriginalName();
        // $fileName =time().'_'.$file->getClientOriginalName();
        // $path = $request->photo->storeAs('image',$fileName,'public');

        // return redirect()->route('user.index')->with('status','User Image Upload Successfully.');

        $request->validate([
              'photo'=> 'required|mimes:png,jpg,jpeg|max:3000'
        ]);
        // $file = $request->file('photo');
        // $extension= $file->getClientOriginalExtension();
        // $extension= $file->extension();
        // $extension= $file->hashName();
        // $extension= $file->getClientMimeType();
        // $extension= $file->getSize();

        // using store method 
        // $file = $request->file('photo');
        // $path = $request->photo->store('image','public');
        // User::create([
        //     'file_name'=>$path,

        // ]);

        // using move method
        $file = $request->file('photo');
        $file->move(public_path('uploads'), $file->getClientOriginalName());  //create this file manualy
        User::create([
            'file_name'=>$file->getClientOriginalName(),

        ]);
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
        $user = User::find($id);

        return view('file-update',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if($request->hasFile('photo')){
            $image_path = public_path('storage/') . $user->file_name;

            if(file_exists($image_path)){
                @unlink($image_path);
            }

            $path = $request->photo->store('image','public');
            $user->file_name = $path;
            $user->save();
            return redirect()->route('user.index')->with('status','User Image Updated Successfully.');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user= User::find($id);
        $user->delete();
        $image_path = public_path('storage/'). $user->file_name;
        // return $image_path;
        if(file_exists($image_path)){
            @unlink($image_path);
        }
         return redirect()->route('user.index')->with('status','User Image Delete Successfully.');
    }
}
