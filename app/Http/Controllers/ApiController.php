<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, DB, Hash};
use App\Models\{User, Hotel, Doctor, Astrologer, DinnerMenu};
use Exception;

class ApiController extends Controller
{
    public function customResponse($msg, $errors, $success, $code, $data = []) {
        return $arr = [
            'msg' => $msg,
            'error' => $errors,
            'success' => $success,
            'code' => $code,
            'data' => $data
        ];
    }
    public function apiLogin(Request $request) {
        $attr = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);
        if ($attr->fails()) {
            $res = $this->customResponse('Validation failed', $attr->messages(), false, 400);
            return response()->json($res);
        }
        $user = User::where('email', $request->email)->where('role', 'user')->first();
        if($user) {
            if(Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Sanc')->plainTextToken;
                $res = $this->customResponse('Login successful', [], true, 200, 
                    ['token' => $token]
                );
                return response()->json($res);
            }
            else {
                $res = $this->customResponse('Password mismatch', [], false, 400);
                return response()->json($res);
            }
        }
        else {
            $res = $this->customResponse('Email Address is not Registered', [], false, 404);
            return response()->json($res);
        }
    }

    public function getAllHotels(Request $request) {
        $hotels = Hotel::select('id','name','image', 'price_text')->orderBy('id', 'desc')->get();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['hotels' => $hotels]
        );
        return response()->json($res);
    }

    public function getAllDoctors(Request $request) {
        $doctors = Doctor::select('id','name', 'degree','image', 'experience')->orderBy('id', 'desc')->with('categories')->get();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['doctors' => $doctors]
        );
        return response()->json($res);
    }

    public function getAllAstrologers(Request $request) {
        $astrologers = Astrologer::select('id','name','image', 'experience')->orderBy('id', 'desc')->get();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['astrologers' => $astrologers]
        );
        return response()->json($res);
    }

    public function getAllDinnerMenu(Request $request) {
        $dinnerMenus = DinnerMenu::select('id','name','image')->orderBy('id', 'desc')->get();
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['dinner_menus' => $dinnerMenus]
        );
        return response()->json($res);
    }

    public function getLogout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        //return $request->user()->tokens()->delete();
        $res = $this->customResponse('Logout!', [], false, 200, 
            []
        );
        return response()->json($res);
    }

}