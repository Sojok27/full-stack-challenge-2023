<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponseController as Response;

class UserController extends Controller
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
        $users = User::paginate(15);
        $roles = Role::all();
        $usersJson = json_encode($users);
        return view("user/index", compact('users', 'roles', 'usersJson'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'exists:roles,name'
        ]);
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
        $role = Role::Where('name', $request->role)->first();
        $validator = $this->validator($request->post());
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $user =  new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $status = $user->save();
        $user->roles()->attach($role);
        return back()->with("status", "User added succesfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $user =  User::where('id', intval($request->id))->get()->first();
        // dd($user->email, $request->email, $user->email == $request->email);
        $rules = [];
        $rules[] = ['name' => 'required|string|max:255'];
        if($user->email != $request->email) {
            $rules['email'] = 'required|string|email|max:255|unique:users';
        }
        if($request->password) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }
        $validator = Validator::make($request->post(), $rules);
        if($user)
        if ($validator->fails()) {
            return back()
            ->withErrors($validator)
            ->withInput();
        }
        if($request->name)$user->name = $request->name;
        if($request->email)$user->email = $request->email;
        if($request->password)$user->password = bcrypt($request->password);
        if($request->is_banned)$user->is_banned = $request->is_banned == "on" ? 1 : 0;
        $status = $user->save();
        return back()->with("status", "User updated succesfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        //
        $user =  User::where('id', intval($id))->delete();
        return back()->with("status", "User deleted succesfully");
    }
    
}
