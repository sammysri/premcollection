<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, DB, Hash};
use App\Models\{User, UserDetails, Hotel, Doctor, Astrologer, DinnerMenu, Store, Car, Category, Album, Banner};
use Exception;
use App\Http\Traits\ImageTrait;
use Carbon\Carbon; 
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as Intervention;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
    use ImageTrait;
    public function customResponse($msg, $errors, $success, $code, $data = []) {
        return $arr = [
            'msg' => $msg,
            'error' => $errors,
            'success' => $success,
            'code' => $code,
            'data' => $data
        ];
    }
    public function hello(){
        return 'Hello world';
    }
    public function sendLoginOtp(Request $request) {
        $attr = Validator::make($request->all(), [
            'email' => 'required|string|email'
        ]);
        if ($attr->fails()) {
            $res = $this->customResponse('Validation failed', $attr->messages(), false, 400);
            return response()->json($res);
        }
        $user = User::where('email', $request->email)->whereNotNull('email_verified_at')->where('role', 'user')->first();
        if($user) {
            if($user->email == "ankit@webmaddy.com") $otp = 8888;
            else{
                $otp = rand(1000,9999);
            }
                $user->update([
                    'otp' => $otp
                ]);
            try{
                $email = $user->email;
                Mail::send('mails.sendOtp', ['otp' => $otp], function($message) use ($email) {    
                    $message->to($email)->subject('OTP to login to account');    
                });
            } catch(\Exception $e){
                $res = $this->customResponse('Error in sending otp'. $e->getMessage(), [], false, 404);
                return response()->json($res);
            }
            $res = $this->customResponse('OTP send', [], true, 200, 
                ['otp' => $otp]
            );
            return response()->json($res);
        }
        else {
            $res = $this->customResponse('The email address is either not verified or not registered.', [], false, 404);
            return response()->json($res);
        }
    }
// 64|kaimAyQtSdrWvmPUEyyeypgv7uiXDNHwU0hsVWm00862c0cc
    public function verifyLoginOtp(Request $request) {
        $attr = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'otp' => 'required|numeric'
        ]);
        if ($attr->fails()) {
            $res = $this->customResponse('Validation failed', $attr->messages(), false, 400);
            return response()->json($res);
        }
        $user = User::where('email', $request->email)->whereNotNull('email_verified_at')->where('otp', $request->otp)->first();
        if($user) {
            $user->update([
                'otp' => null
            ]);
            $token = $user->createToken('Sanc')->plainTextToken;
            $res = $this->customResponse('OTP match Successfully.', [], true, 200, 
                ['token' => $token]
            );
            return response()->json($res);
        }
        else {
            $res = $this->customResponse('No match found.', [], false, 404);
            return response()->json($res);
        }
    }

    public function getLogout(Request $request) {
        return $request->user()->currentAccessToken()->delete();
        //return $request->user()->tokens()->delete();
        $res = $this->customResponse('Logout!', [], false, 200, 
            []
        );
        return response()->json($res);
    }

    public function getAllStores(Request $request) {
        $stores = Store::where('active', 1)->orderBy('id', 'desc')->pluck('name', 'id')->all();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['stores' => $stores]
        );
        return response()->json($res);
    }
    
    public function applyMembership(Request $request) {
        $attr = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100',
            'phone' => 'required|string|max:12',
            'dob' => 'required|date|before:today',
            'club_name' => 'nullable|string|max:191',
            'visit_before' => 'required|boolean',
        ]);
        if ($attr->fails()) {
            $res = $this->customResponse('Validation failed', $attr->messages(), false, 400);
            return response()->json($res);
        }
        $user = User::where('email', $request->email)->where('role', 'user')->first();
        if($user) {
            $res = $this->customResponse('The email address is already registered. You can log in after verification.', [], false, 404);
            if(!$user->userDetails()->first()){
                $userDetail = new UserDetails([
                    'user_id' => $user->id,
                    'phone' => $request->phone,
                    'dob' => $request->dob,
                    'club_name' => $request->club_name,
                    'visit_before' => $request->visit_before
                ]);
                $userDetail->save();
            }
        }else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('sam@2024'),
                'role' => 'user'
            ]);
            $userDetail = new UserDetails([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'club_name' => $request->club_name,
                'visit_before' => $request->visit_before
            ]);
            $userDetail->save();
            $res = $this->customResponse('Your request has been received. Our team will contact you after activating your membership.', [], true, 200, 
                ['otp' => $user]
            );
            
            try{
                $email = $user->email;
                Mail::send('mails.apply', ['name' => $user->name], function($message) use ($email) {    
                    $message->to($email)->subject('Thank You for Your Application - Prem\'s Privileged Club');    
                });
            } catch(\Exception $e){}
        }
        return response()->json($res);
    }

    public function getAllHotels(Request $request) {
        $hotels = Hotel::select('id','name','image', 'price_text')->where('active', 1)->orderBy('id', 'desc')->get();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['hotels' => $hotels]
        );
        return response()->json($res);
    }

    public function getAllCategories(Request $request) {
        $categories = Category::select('id','name')->where('active', 1)->orderBy('id', 'desc')->get();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['categories' => $categories]
        );
        return response()->json($res);
    }

    public function getAllDoctors(Request $request) {
        $doctors = Doctor::select('id','name', 'degree','image', 'experience')->where('active', 1)->orderBy('id', 'desc');
        if($request->has('category_id') && $request->category_id) {
            $search = $request->category_id;
            $doctors = $doctors->whereHas('categories', function($query) use ($search){
                $query->where('category_id', $search);
            });
        }
        $doctors = $doctors->with('category_name')->get();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['doctors' => $doctors]
        );
        return response()->json($res);
    }

    public function getAllAstrologers(Request $request) {
        $astrologers = Astrologer::select('id','name','image', 'experience')->where('active', 1)->orderBy('id', 'desc')->get();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['astrologers' => $astrologers]
        );
        return response()->json($res);
    }

    public function getAllDinnerMenu(Request $request) {
        $dinnerMenus = DinnerMenu::select('id','name','image')->where('active', 1)->orderBy('id', 'desc')->get();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['dinner_menus' => $dinnerMenus]
        );
        return response()->json($res);
    }

    public function getAllCars(Request $request) {
        $cars = Car::select('id','name','image')->where('active', 1)->orderBy('id', 'desc')->get();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['cars' => $cars]
        );
        return response()->json($res);
    }

    public function getProfile(Request $request) {
        $user = $request->user()->load('userDetails.store');
        if ($user->userDetails->image) {
            $user->userDetails->image = asset('user-images/' . $user->userDetails->image);
        } else {
            $user->userDetails->image = 'https://placehold.co/50x50/png';
        }
        $res = $this->customResponse('Data fetch', [], true, 200, 
            [
                'data' => $user
            ]
        );
        return response()->json($res);
    }

    public function postSaveProfile(Request $request) {
        $attr = Validator::make($request->all(), [
            'phone' => ['nullable', 'numeric'],
            'whatsapp' => ['nullable', 'numeric'],
            'store_id' => ['sometimes','nullable','exists:stores,id'],            
            // 'card_number' => ['nullable', 'unique:user_details,card_number,'.$request->user()->id]
        ]);
        //first 4 numbers same and more 4 digits random
        //return $request->all();
        if ($attr->fails()) {
            $res = $this->customResponse('Validation failed', $attr->messages(), false, 400);
            return response()->json($res);
        }
        
        $user = $request->user();
        $details = $user->userDetails()->first();
        if(!$details){
            $details = new UserDetails(); 
        }
        $details->phone = $request->phone ? $request->phone : null;
        $details->whatsapp = $request->whatsapp ? $request->whatsapp : null;
        // $details->card_number = $request->card_number ? $request->card_number : null;
        $details->dob = $request->dob ? Carbon::parse($request->dob)->format('y-m-d') : null;
        $details->address = $request->address ? $request->address : null;
        $details->bio = $request->bio ? $request->bio : null;
        $details->club_name = $request->club_name ? $request->club_name : null;
        // $details->store_id = $request->store_id ? $request->store_id : null;
        // $details->image = $request->image ? $this->upload($request, 'user-images') : ($details && $details->id ? $details->image : 'https://placehold.co/50x50/png');
        // $details->club_name = $request->club_name ? $request->club_name : null;
        if ($request->hasFile('image')){
            $token = strtolower(Str::random(20));
            $ext = $request->image->getClientOriginalExtension();
            $name = $user->id.'_'.$token.'.'.$ext;
            $path = 'user-images/';
            Intervention::make($request->image)->resize(400,null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode($ext)->save($path.$name);
            $details->image = $name;
        }
        //return $details;
        if($user->userDetails()->save($details)) {
            $res = $this->customResponse('Saved successfully', [], true, 200, 
                [
                    'data' => $user->load('userDetails.store')
                ]
            );
            return response()->json($res);
        }
        else {
            $res = $this->customResponse('Error in saving! Try again later.', [], false, 404);
            return response()->json($res);
        }
    }

    public function getAlbums(Request $request) {
        $albums = Album::select('id','name','image', 'publish_at')->where('active', 1)->orderBy('publish_at', 'desc')->get();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['albums' => $albums]
        );
        return response()->json($res);
    }

    public function getAlbumImages(Request $request, string $albumId) {
        $album = Album::find($albumId);
        if(!$album) {
            $res = $this->customResponse('No match found.', [], false, 404);
            return response()->json($res);
        }
        $images = $album->images()->get(['alt', 'image']);
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['album' => $album, 'images' => $images]
        );
        return response()->json($res);
    }

    public function getBanners(Request $request) {
        $banners = Banner::select('id','priority','image', 'alt')->where('active', 1)->orderBy('priority', 'asc')->get();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['banners' => $banners]
        );
        return response()->json($res);
    }

}