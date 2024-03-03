<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ImageTrait;

class DoctorController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::orderBy('id', 'desc')->get();
        return view('doctors.list', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Doctor';
        $doctor = null;
        return view('doctors.form', compact('title', 'doctor'));
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
                'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'name' => ['required'],
                'degree' => ['required'],
                'speciality' => ['required'],
                'experience' => ['required']
            ]);
            $doctor = Doctor::create([
                'name' => $request->name,
                'description' => $request->description,
                'degree' => $request->degree,
                'speciality' => $request->speciality,
                'image' => $request->image ? $this->upload($request, 'doctor-images') : 'https://placehold.co/50x50/png',
                'experience' => $request->experience
            ]);

            if($doctor) {
                DB::commit();
                return redirect('/doctors/'.$doctor->id);
            }
     
            return back()->withErrors([
                'doctor_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            
            return back()->withErrors([
                'doctor_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $title = 'Edit Doctor';
        return view('doctors.form', compact('title', 'doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $title = 'Edit Doctor';
        return view('doctors.form', compact('title', 'doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $doctor = Doctor::findOrFail($id);
            $credentials = $request->validate([
                'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'name' => ['required'],
                'degree' => ['required'],
                'speciality' => ['required'],
                'experience' => ['required']
            ]);

            $doctor->name = $request->name;
            $doctor->description = $request->description;
            $doctor->degree = $request->degree;
            $doctor->speciality = $request->speciality;
            $doctor->experience = $request->experience;
            $doctor->image = $request->image ? $this->upload($request, 'doctor-images') : $doctor->image;

            // return $doctor;

            if($doctor->save()) {
                DB::commit();
                return redirect('/doctors/'.$doctor->id);
            }
     
            return back()->withErrors([
                'doctor_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            return back()->withErrors([
                'doctor_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        return redirect()->route('doctors.index');
    }
}
