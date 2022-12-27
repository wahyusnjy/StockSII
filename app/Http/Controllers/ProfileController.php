<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::find($id);
        return view('profile.index',compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $users = User::find($id);
        return view('profile.edit',compact('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request, [
			'name' => 'required|string|min:2',
			'email' => 'required|string|email|max:255|unique:suppliers',
		]);

        $input = $request->except('_token','password');

        $user = User::findOrFail($id);

        if($request->password) {
            if(!$user->password == NULL){

            Auth::user()->password = Hash::make($request->password);
            }
        }

        $input['image'] = $user->image;
        if ($request->hasFile('image')){
            if (!$user->image == NULL){
                if(file_exists(public_path($user->image))){
                    unlink(public_path($user->image));
                }
                // unlink(public_path($produk->image));
            }
            $input['image'] = '/upload/users/'.Str::slug(Auth::user()->name, '-').strtotime('now').'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/upload/users/'), $input['image']);
        }

        $user->update($input);

		return redirect()->route('show.profile',Auth::user()->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
