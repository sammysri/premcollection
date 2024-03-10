<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ImageTrait;

class CarController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::orderBy('id', 'desc')->get();
        return view('cars.list', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Car Service';
        $car = null;
        return view('cars.form', compact('title', 'car'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try{
            //return $request->all();
            $credentials = $request->validate([
                'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
                'name' => ['required']
            ]);
            $car = Car::create([
                'name' => $request->name,
                'active' => $request->has('active') ? ($request->active == 1 ? 1 : 0) : 0,
                'image' => $request->image ? $this->upload($request, 'car-images') : 'https://placehold.co/50x50/png'
            ]);

            if($car) {
                DB::commit();
                return redirect('/cars/'.$car->id);
            }
     
            return back()->withErrors([
                'car_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            
            return back()->withErrors([
                'car_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::findOrFail($id);
        $title = 'Edit Car Service';
        return view('cars.form', compact('title', 'car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $car = Car::findOrFail($id);
        $title = 'Edit Car Service';
        return view('cars.form', compact('title', 'car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $car = Car::findOrFail($id);
            $credentials = $request->validate([
                'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
                'name' => ['required']
            ]);

            $car->name = $request->name;
            $car->image = $request->image ? $this->upload($request, 'car-images') : $car->image;
            $car->active = $request->has('active') ? ($request->active == 1 ? 1 : 0) : 0;

            // return $car;

            if($car->save()) {
                DB::commit();
                return redirect('/cars/'.$car->id);
            }
     
            return back()->withErrors([
                'car_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            return back()->withErrors([
                'car_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $car = Car::findOrFail($id);
        $car->delete();
        return redirect()->route('cars.index');
    }
}
