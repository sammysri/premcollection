<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ImageTrait;

class BannerController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('id', 'desc')->get();
        return view('banners.list', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Banner';
        $banner = null;
        return view('banners.form', compact('title', 'banner'));
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
                'image' => 'required|mimes:png,jpg,jpeg,webp|max:2048',
                'priority' => ['required', 'numeric']
            ]);
            $banner = Banner::create([
                'alt' => $request->alt ? $request->alt : null,
                'priority' => $request->priority,
                'active' => $request->has('active') ? ($request->active == 1 ? 1 : 0) : 0,
                'image' => $request->image ? $this->upload($request, 'banner-images') : 'https://placehold.co/50x50/png'
            ]);

            if($banner) {
                DB::commit();
                return redirect('/banners/'.$banner->id);
            }
     
            return back()->withErrors([
                'banner_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            
            return back()->withErrors([
                'banner_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = Banner::findOrFail($id);
        $title = 'Edit Banner';
        return view('banners.form', compact('title', 'banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        $title = 'Edit Banner';
        return view('banners.form', compact('title', 'banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $banner = Banner::findOrFail($id);
            $credentials = $request->validate([
                'image' => 'required|mimes:png,jpg,jpeg,webp|max:2048',
                'priority' => ['required', 'numeric']
            ]);

            $banner->alt = $request->alt ? $request->alt : null;
            $banner->priority = $request->priority;
            $banner->image = $request->image ? $this->upload($request, 'banner-images') : $banner->image;
            $banner->active = $request->has('active') ? ($request->active == 1 ? 1 : 0) : 0;

            // return $banner;

            if($banner->save()) {
                DB::commit();
                return redirect('/banners/'.$banner->id);
            }
     
            return back()->withErrors([
                'banner_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            return back()->withErrors([
                'banner_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('banners.index');
    }
}
