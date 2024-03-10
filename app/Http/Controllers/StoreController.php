<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ImageTrait;

class StoreController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::orderBy('id', 'desc')->get();
        return view('stores.list', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Store';
        $store = null;
        return view('stores.form', compact('title', 'store'));
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
            $store = Store::create([
                'address' => $request->address ? $request->address : null,
                'name' => $request->name,
                'active' => $request->has('active') ? ($request->active == 1 ? 1 : 0) : 0,
                'image' => $request->image ? $this->upload($request, 'store-images') : 'https://placehold.co/50x50/png'
            ]);

            if($store) {
                DB::commit();
                return redirect('/stores/'.$store->id);
            }
     
            return back()->withErrors([
                'store_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            
            return back()->withErrors([
                'store_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $store = Store::findOrFail($id);
        $title = 'Edit Store';
        return view('stores.form', compact('title', 'store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $store = Store::findOrFail($id);
        $title = 'Edit Store';
        return view('stores.form', compact('title', 'store'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $store = Store::findOrFail($id);
            $credentials = $request->validate([
                'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
                'name' => ['required']
            ]);
                
            $store->address = $request->address ? $request->address : null;
            $store->name = $request->name;
            $store->image = $request->image ? $this->upload($request, 'store-images') : $store->image;
            $store->active = $request->has('active') ? ($request->active == 1 ? 1 : 0) : 0;

            // return $store;

            if($store->save()) {
                DB::commit();
                return redirect('/stores/'.$store->id);
            }
     
            return back()->withErrors([
                'store_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            return back()->withErrors([
                'store_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $store = Store::findOrFail($id);
        $store->delete();
        return redirect()->route('stores.index');
    }
}
