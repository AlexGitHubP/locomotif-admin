<?php

namespace Locomotif\Admin\Controller;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Locomotif\Admin\Models\Users;
use Hash;

class UsersController extends Controller
{

	public function __construct()
    {
        $this->middleware('authgate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Users::all();
        return view('admin::users')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin::create_user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Users::create(['name' => $request->name,'email' => $request->email, 'password' => Hash::make($request->password)]);
        return redirect('/admin/users/'.$user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Users $user)
    {
       return view('admin::show_user')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Users $user)
    {
        return view('admin::edit_user')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Users $user)
    {
     
        $user->name = $request->name;
        $user->email = $request->email; 
        //try to do this with 'laravel code'
        if ($request->password==NULL) {
            array_filter($request->all());        
        }
        else{
            $user->password = Hash::make($request->password);    
        }
        $user->save();
        $request->session()->flash('message', 'Successfully modified the user!');
        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Users $user)
    {
        $user->delete();
        return redirect('/admin/users');
    }
}

