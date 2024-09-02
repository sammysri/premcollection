<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, UserDetails, UserBookingService, Hotel, Doctor, Astrologer, DinnerMenu, Car};
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ImageTrait;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
    use ImageTrait;
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
            //return $request->has('active') ? ($request->active == '1' ? 1 : 0) : 0;
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
                'active' => $request->has('active') ? ($request->active == '1' ? 1 : 0) : 0,
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
            $user->active = $request->has('active') ? ($request->active == 1 ? 1 : 0) : 0;
            if($request->filled('active')){
                $user->email_verified_at = Carbon::now();
                $user->active = $request->active;
            }else{
                $user->email_verified_at = null;
                $user->active = $request->active;
            }

            if($user->save()) {
                DB::commit();
                
            
                try{
                    $email = $request->email;
                    Mail::send('mails.confirm', ['name' => $request->name], function($message) use ($email) {    
                        $message->to($email)->subject('Access Prem\'s Privileged Club Membership via Mobile App');    
                    });
                } catch(\Exception $e){}
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

    public function getuserDetails(string $id)
    {
        $user = User::findOrFail($id);
        $details = $user->userDetails()->first();
        $stores = Store::orderBy('name', 'asc')->pluck( 'name', 'id')->all();
        $title = 'Details of '.$user->name;
        return view('users.details', compact('title', 'user', 'details', 'stores'));
    }
    public function postUserDetails(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $details = $user->userDetails()->first();
            $cValidation = $details && $details->id ? 'unique:user_details,card_number,'.$details->id : 'unique:user_details,card_number';
            $credentials = $request->validate([
                'phone' => ['nullable', 'numeric'],
                'whatsapp' => ['nullable', 'numeric'],
                'store_id' => ['sometimes','nullable','exists:stores,id'],            
                'card_number' => ['nullable', $cValidation]
                //'card_number' => 'nullable|unique:user_details,card_number'.$details && $details->id ? ','.$details->id : '',
            ]);
            if($details) {

            }
            else {
                $details = new UserDetails(); 
            }
            $details->phone = $request->phone ? $request->phone : null;
            $details->whatsapp = $request->whatsapp ? $request->whatsapp : null;
            $details->card_number = $request->card_number ? $request->card_number : null;
            $details->dob = $request->dob ? Carbon::parse($request->dob)->format('y-m-d') : null;
            $details->address = $request->address ? $request->address : null;
            $details->bio = $request->bio ? $request->bio : null;
            $details->club_name = $request->club_name ? $request->club_name : null;
            $details->store_id = $request->store_id ? $request->store_id : null;
            $details->image = $request->image ? $this->upload($request, 'user-images') : ($details && $details->id ? $details->image : 'https://placehold.co/50x50/png');
            $details->club_name = $request->club_name ? $request->club_name : null;
            //return $details;
            if($user->userDetails()->save($details)) {
                return redirect('/user-details/'.$id);
            }
    
            return back()->withErrors([
                'details_error' => 'Error in saving record.',
            ])->withInput();
            
        }catch(\Exception $e){
            DB::rollback();
            
            return back()->withErrors([
                'details_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    public function getBookedServices(Request $request)
    {
        $bookedServices = UserBookingService::orderBy('id', 'desc')->with('user')->paginate(10);
        // return $bookedServices->items();
        $_bookedServices = [];
        foreach ($bookedServices->items() as $service) {
            $serviceId = $service->service_id;
            $serviceType = $service->service_type;

            if (str_contains($serviceType, 'Hotel')) {
                $_service = Hotel::find($serviceId, ['name', 'image']);
                array_push($_bookedServices, [
                    'id' => $service->id,
                    'user_id' => $service->user->id,
                    'user_name' => $service->user->name,
                    'booked_on' => Carbon::parse($service->created_at)->format('d-m-Y'),
                    'status' => $service->status,
                    'extra_data' => json_decode($service->extra_data),
                    'service' => $_service,
                    'service_type' => 'Hotel',
                ]);
            } elseif (str_contains( $serviceType, 'Doctor')) {
                $_service = Doctor::find($serviceId, ['name', 'image']);
                array_push($_bookedServices, [
                    'id' => $service->id,
                    'user_id' => $service->user->id,
                    'user_name' => $service->user->name,
                    'booked_on' => Carbon::parse($service->created_at)->format('d-m-Y'),
                    'status' => $service->status,
                    'extra_data' => json_decode($service->extra_data),
                    'service' => $_service,
                    'service_type' => 'Doctor',
                ]);
            } elseif (str_contains( $serviceType, 'Astrologer')) {
                $_service = Astrologer::find($serviceId, ['name', 'image']);
                array_push($_bookedServices, [
                    'id' => $service->id,
                    'user_id' => $service->user->id,
                    'user_name' => $service->user->name,
                    'booked_on' => Carbon::parse($service->created_at)->format('d-m-Y'),
                    'status' => $service->status,
                    'extra_data' => json_decode($service->extra_data),
                    'service' => $_service,
                    'service_type' => 'Astrologer',
                ]);
            } elseif (str_contains( $serviceType, 'DinnerMenu')) {
                $_service = DinnerMenu::find($serviceId, ['name', 'image']);
                array_push($_bookedServices, [
                    'id' => $service->id,
                    'user_id' => $service->user->id,
                    'user_name' => $service->user->name,
                    'booked_on' => Carbon::parse($service->created_at)->format('d-m-Y'),
                    'status' => $service->status,
                    'extra_data' => json_decode($service->extra_data),
                    'service' => $_service,
                    'service_type' => 'DinnerMenu',
                ]);
            } elseif (str_contains( $serviceType, 'Car')) {
                $_service = Car::find($serviceId, ['name', 'image']);
                array_push($_bookedServices, [
                    'id' => $service->id,
                    'user_id' => $service->user->id,
                    'user_name' => $service->user->name,
                    'booked_on' => Carbon::parse($service->created_at)->format('d-m-Y'),
                    'status' => $service->status,
                    'extra_data' => json_decode($service->extra_data),
                    'service' => $_service,
                    'service_type' => 'Car',
                ]);
            } else {
                array_push($_bookedServices, [
                    'id' => $service->id,
                    'user_id' => $service->user->id,
                    'user_name' => $service->user->name,
                    'booked_on' => Carbon::parse($service->created_at)->format('d-m-Y'),
                    'status' => $service->status,
                    'extra_data' => json_decode($service->extra_data),
                    'service' => null,
                    'service_type' => null,
                ]);
            }
        }
        // return $_bookedServices;
        $title = 'All Booking Request';
        return view('users.booking_request', compact('title', '_bookedServices'));
    }

    public function updateBookedService(Request $request, string $id)
    {
        try {
            $bookedService = UserBookingService::findOrFail($id);
            $credentials = $request->validate([
                'status' => ['required']
            ]);
            
            $bookedService->status = $request->status;
            if($bookedService->save()) {
                return redirect()->back();
            }
    
            return back()->withErrors([
                'details_error' => 'Error in saving record.',
            ])->withInput();
            
        }catch(\Exception $e){
            DB::rollback();
            
            return back()->withErrors([
                'details_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

}
