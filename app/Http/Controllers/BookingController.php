<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator};
use App\Models\{Hotel, Doctor, Astrologer, DinnerMenu, Car, UserBookingService};
use Carbon\Carbon; 

class BookingController extends Controller
{
    protected $model;
    public function customResponse($msg, $errors, $success, $code, $data = []) {
        return $arr = [
            'msg' => $msg,
            'error' => $errors,
            'success' => $success,
            'code' => $code,
            'data' => $data
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $type)
    {
        
        $validateResArr = [];
        if($type == 'Astrologer') {
            $validateResArr = [
                'booking_date' => 'required|date',
                'custom_id' => 'required'
            ];
        }
        else if($type == 'Doctor') {
            $validateResArr = [
                'booking_date' => 'required|date',
                'patient_name' => 'required',
                'custom_id' => 'required'
            ];
        }
        else if($type == 'Hotel') {
            $validateResArr = [
                'check_in_date' => 'required|date',
                'check_in_date' => 'required|date',
                'number_of_room' => 'required|numeric',
                'number_of_guest' => 'required|numeric',
                'custom_id' => 'required'
            ];
        }
        else if($type == 'DinnerMenu') {
            $validateResArr = [
                'booking_date' => 'required|date',
                'number_of_person' => 'required|numeric',
                'custom_id' => 'required'
            ];
        }
        else if($type == 'Car') {
            $validateResArr = [
                'arrival_date' => 'required|date',
                'arrival_time' => 'required',
                'number_of_guest' => 'required|numeric',
                'drop_location' => 'required',
                'custom_id' => 'required'
            ];
        }
        $attr = Validator::make($request->all(), $validateResArr);
        if ($attr->fails()) {
            $res = $this->customResponse('Validation failed', $attr->messages(), false, 400);
            return response()->json($res);
        }
        $modelName = '\App\Models\\'.$type;
        $this->model = new $modelName;
        $exist = $this->model::find($request->custom_id);
        
        $arr = '';
        if($type == 'Astrologer') {
            $arr = json_encode(['booking_date'=>$request->booking_date]);
        }
        else if($type == 'DinnerMenu') {
            $arr = json_encode(['booking_date'=>$request->booking_date, 'number_of_person'=>$request->number_of_person]);
        }
        else if($type == 'Doctor') {
            $arr = json_encode(['booking_date'=>$request->booking_date, 'patient_name'=>$request->patient_name]);
        }
        else if($type == 'Hotel') {
            $arr = json_encode([
                'check_in_date'=>$request->check_in_date,
                'check_out_date'=>$request->check_out_date, 'number_of_room'=>$request->number_of_room, 'number_of_guest'=>$request->number_of_guest
            ]);
        }
        else if($type == 'Car') {
            $arr = json_encode([
                'arrival_date'=>$request->arrival_date, 
                'arrival_time'=>$request->arrival_time, 'number_of_guest'=>$request->number_of_guest, 'drop_location'=>$request->drop_location
            ]);
        }

        $data = $exist->users()->save($request->user(), ['status' => 'under-process', 'extra_data' => $arr, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        
        $res = $this->customResponse('Data saved.', [], true, 200, 
            []
        );
        return response()->json($res);
    }
 
    public function getBookedServices(Request $request)
    {
        $bookedServices = UserBookingService::where('user_id', $request->user()->id)->orderBy('id', 'desc')->get();
        $arr = [];
        foreach ($bookedServices as $service) {
            $serviceId = $service->service_id;
            $serviceType = $service->service_type;

            if ($serviceType === Hotel::class) {
                $_service = Hotel::find($serviceId, ['name', 'image']);
                array_push($arr, [
                    'booked_on' => $service->created_at,
                    'status' => $service->status,
                    'extra_data' => json_decode($service->extra_data),
                    'service' => $_service,
                    'service_type' => 'Hotel',
                ]);
            } elseif ($serviceType === Doctor::class) {
                $_service = Doctor::find($serviceId, ['name', 'image']);
                array_push($arr, [
                    'booked_on' => $service->created_at,
                    'status' => $service->status,
                    'extra_data' => json_decode($service->extra_data),
                    'service' => $_service,
                    'service_type' => 'Doctor',
                ]);
            } elseif ($serviceType === Astrologer::class) {
                $_service = Astrologer::find($serviceId, ['name', 'image']);
                array_push($arr, [
                    'booked_on' => $service->created_at,
                    'status' => $service->status,
                    'extra_data' => json_decode($service->extra_data),
                    'service' => $_service,
                    'service_type' => 'Astrologer',
                ]);
            } elseif ($serviceType === DinnerMenu::class) {
                $_service = DinnerMenu::find($serviceId, ['name', 'image']);
                array_push($arr, [
                    'booked_on' => $service->created_at,
                    'status' => $service->status,
                    'extra_data' => json_decode($service->extra_data),
                    'service' => $_service,
                    'service_type' => 'DinnerMenu',
                ]);
            } elseif ($serviceType === Car::class) {
                $_service = Car::find($serviceId, ['name', 'image']);
                array_push($arr, [
                    'booked_on' => $service->created_at,
                    'status' => $service->status,
                    'extra_data' => json_decode($service->extra_data),
                    'service' => $_service,
                    'service_type' => 'Car',
                ]);
            } else {
                array_push($arr, [
                    'booked_on' => $service->created_at,
                    'status' => $service->status,
                    'extra_data' => json_decode($service->extra_data),
                    'service' => null,
                    'service_type' => null,
                ]);
            }
        }
        
        $res = $this->customResponse('Successfully fetch', [], true, 200, 
            ['services' => $arr]
        );
        return response()->json($res);
    }
}
