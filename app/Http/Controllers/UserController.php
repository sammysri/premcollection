<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function postLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        // if (Auth::attempt( array_merge($credentials, ['role' => 'admin']) )) {
        if (Auth::attempt( $credentials )) {
            // dd(auth()->user()->role);
            if(in_array(auth()->user()->role, ['admin', 'superadmin'])) {
                $request->session()->regenerate(); 
                return redirect()->intended('dashboard');
            }
            else {
                Auth::logout();    
                $request->session()->invalidate();    
                $request->session()->regenerateToken();    
                return back()->withErrors([
                    'email' => 'Role not found.',
                ])->onlyInput('email');
            }
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();    
        $request->session()->invalidate();    
        $request->session()->regenerateToken();    
        return redirect('/login');
    }

    
    public function getChangePassword(Request $request)
    {  
        $title="Change password";
        return view('users.change_password', compact('title'));
    }
    
    public function postChangePassword(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'current_password' => ['required','string','min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->password);
        if($currentPasswordStatus){

            User::findOrFail(Auth::user()->id)->update([
                'password' => Hash::make($request->password),
            ]);
            return back()->withErrors([
                'password_error' => 'Password Updated Successfully',
            ]);

        }else{
            return back()->withErrors([
                'password_error' => 'Current Password does not match with Old Password',
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->route()->getPrefix();
        $role = $type == '/admin' ? 'admin' : 'user';
        $users = User::orderBy('id', 'desc')->where('role', $role)->get();
        return view('users.list', compact('users', 'type'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->route()->getPrefix();
        $T = $type == '/admin' ? 'Admin' : 'User';
        $title = "Create $T";
        $user = null;
        return view('users.form', compact('title', 'user', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        $type = $request->route()->getPrefix();
        try{
            //return $request->all();
            $credentials = $request->validate([
                'name' => ['required'],
                'email' => ['required', 'unique:users', 'email'],
                'password' => 'required|min:8'
            ]);
            $role = $type == '/admin' ? 'admin' : 'user';
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $role
            ]);

            if($user) {
                DB::commit();
                return redirect($type.'/management/'.$user->id);
            }
     
            return back()->withErrors([
                'user_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            
            return back()->withErrors([
                'user_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $user = User::findOrFail($id);
        $type = $request->route()->getPrefix();
        $T = $type == '/admin' ? 'Admin' : 'User';
        $title = "Edit $T";
        return view('users.form', compact('title', 'user', 'type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        $user = User::findOrFail($id);
        $type = $request->route()->getPrefix();
        $T = $type == '/admin' ? 'Admin' : 'User';
        $title = "Edit $T";
        return view('users.form', compact('title', 'user', 'type'));
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $type = $request->route()->getPrefix();
            $user = User::findOrFail($id);
            $credentials = $request->validate([
                'name' => ['required'],
                'email' => 'required|email|unique:users,email,'.$user->id,
                'reset_password' => 'sometimes',
                'password' => 'required_with:reset_password,on',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            if( $request->reset_password && $request->reset_password == 1 ) $user->password = bcrypt($request->password);

            if($user->save()) {
                DB::commit();
                return back()->withErrors([
                    'user_error' => 'Saved successfully.',
                ])->withInput();
            }
     
            return back()->withErrors([
                'user_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            return back()->withErrors([
                'user_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $user = User::findOrFail($id);
        $user->delete();
        return redirect('user/management');
    }


}
