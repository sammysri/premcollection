<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Category;
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
        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id')->all();
        $title = 'Create Doctor';
        $doctor = null;
        $savedCategoryIds = [];
        return view('doctors.form', compact('title', 'doctor', 'categories', 'savedCategoryIds'));
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
                //'speciality' => ['required'],
                'experience' => ['required']
            ]);
            
            $categories = [];
            if($request->speciality && count($request->speciality)) {
                $categories = Category::whereIn('id',$request->speciality)->pluck( 'id')->all();
            }

            $doctor = Doctor::create([
                'name' => $request->name,
                'description' => $request->description,
                'degree' => $request->degree,
                //'speciality' => $request->speciality,
                'image' => $request->image ? $this->upload($request, 'doctor-images') : 'https://placehold.co/50x50/png',
                'experience' => $request->experience
            ]);

            if($doctor) {
                if(count($categories)) $doctor->categories()->sync($categories);
                DB::commit();
                return redirect('/doctors/'.$doctor->id);
            }
     
            return back()->withErrors([
                'doctor_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            //return $e;
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
        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id')->all();
        $doctor = Doctor::findOrFail($id);
        $savedCategoryIds = $doctor->categories()->pluck('category_id')->all();
        $title = 'Edit Doctor';
        return view('doctors.form', compact('title', 'doctor', 'categories', 'savedCategoryIds'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id')->all();
        $doctor = Doctor::findOrFail($id);
        $savedCategoryIds = $doctor->categories()->pluck('category_id')->all();
        $title = 'Edit Doctor';
        return view('doctors.form', compact('title', 'doctor', 'categories', 'savedCategoryIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            //return $request->all();
            $doctor = Doctor::findOrFail($id);
            $credentials = $request->validate([
                'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'name' => ['required'],
                'degree' => ['required'],
                //'speciality' => ['required'],
                'experience' => ['required']
            ]);
            $categories = [];
            if($request->speciality && count($request->speciality)) {
                $categories = Category::whereIn('id',$request->speciality)->pluck( 'id')->all();
            }
           // return $categories;
            $doctor->name = $request->name;
            $doctor->description = $request->description;
            $doctor->degree = $request->degree;
            //$doctor->speciality = $request->speciality;
            $doctor->experience = $request->experience;
            $doctor->image = $request->image ? $this->upload($request, 'doctor-images') : $doctor->image;

            // return $doctor;

            if($doctor->save()) {
                if(count($categories)) $doctor->categories()->sync($categories);
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
    
    public function category(Request $request, Category $category)
    {
        $title = $category->id ? "Edit Categories" : "Add Categories";
        $categories = Category::orderBy('id', 'desc')->get();
        return view('doctors.category', compact('categories', 'category', 'title'));
    }
    public function postCategory(Request $request,Category $category)
    {
        try{
            $credentials = $request->validate([
                'name' => ['required']
            ]);
            if($category->id) {}
            else {
                $category = new Category;
            }
            $category->name = $request->name;

            if($category->save()) {
                return redirect()->route('category');
            }
     
            return back()->withErrors([
                'category_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            return back()->withErrors([
                'category_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }
}
