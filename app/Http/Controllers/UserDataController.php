<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Monolog\Handler\RollbarHandler;

class UserDataController extends Controller
{
    public function index(){
        // Role::
        $roles = Role::all();
        $users = User::all();
        return view('userdata',compact('roles','users'));
    }

    public function store(Request $request){
        // dd($request->all());
        $request->validate([
            'name' => ['bail','required','min:3','string'],
            'email'=>['bail','required'],
            'phone'=>['bail','required','unique','numeric','digits:10'],
            'role'=>['bail','required'],
            'image'=>['bail','required'],
        ]);
        $image_path = '';
        if($request->hasFile('image')){
            $image_path = 
                $request->image->store('user/images', 'public');
            $validated['image'] = $image_path;
        }
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'desc' => $request->input('desc'),
            'role' => $request->input('role'),
            'image' => $image_path,
        ]);
        $usersdata = User::with('roledata')->get()->toArray();
        return response()->json(['message'=>'done','userdata'=>$usersdata]);
    }
}
