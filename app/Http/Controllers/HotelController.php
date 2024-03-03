<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ImageTrait;

class HotelController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::orderBy('id', 'desc')->get();
        return view('hotels.list', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Hotel';
        $hotel = null;
        return view('hotels.form', compact('title', 'hotel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try{
            
            $credentials = $request->validate([
                //'image' => 'required|image|mimes:jpg,png,jpeg|max:2048|dimensions:min_width=100,min_height=100,max_width=500,max_height=500',
                'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'name' => ['required'],
                'address' => ['required'],
                'price' => ['required']
            ]);
            $hotel = Hotel::create([
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'price' => $request->price,
                'image' => $request->image ? $this->upload($request, 'hotel-images') : 'https://placehold.co/50x50/png',
                'price_text' => '₹'.$request->price.' onwards'
            ]);

            if($hotel) {
                DB::commit();
                return redirect('/hotels/'.$hotel->id);
            }
     
            return back()->withErrors([
                'hotel_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            
            return back()->withErrors([
                'hotel_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hotel = Hotel::findOrFail($id);
        $title = 'Edit Hotel';
        return view('hotels.form', compact('title', 'hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hotel = Hotel::findOrFail($id);
        $title = 'Edit Hotel';
        return view('hotels.form', compact('title', 'hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $hotel = Hotel::findOrFail($id);
            $credentials = $request->validate([
                'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'name' => ['required'],
                'address' => ['required'],
                'price' => ['required']
            ]);

            $hotel->name = $request->name;
            $hotel->description = $request->description;
            $hotel->address = $request->address;
            $hotel->price = $request->price;
            $hotel->image = $request->image ? $this->upload($request, 'hotel-images') : $hotel->image;
            $hotel->price_text = '₹'.$request->price.' onwards';

            // return $hotel;

            if($hotel->save()) {
                DB::commit();
                return redirect('/hotels/'.$hotel->id);
            }
     
            return back()->withErrors([
                'hotel_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            return back()->withErrors([
                'hotel_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return redirect()->route('hotels.index');
    }
}
