<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Album, AlbumImage};
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ImageTrait;
use Carbon\Carbon; 

class AlbumController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = Album::orderBy('id', 'desc')->get();
        return view('albums.list', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Album';
        $album = null;
        return view('albums.form', compact('title', 'album'));
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
            $album = Album::create([
                'publish_at' => $request->publish_at ? Carbon::parse($request->publish_at)->format('y-m-d') : null,
                'name' => $request->name,
                'active' => $request->has('active') ? ($request->active == 1 ? 1 : 0) : 0,
                'image' => $request->image ? $this->upload($request, 'album-images') : 'https://placehold.co/50x50/png'
            ]);

            if($album) {
                DB::commit();
                return redirect('/albums/'.$album->id);
            }
     
            return back()->withErrors([
                'album_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            
            return back()->withErrors([
                'album_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $album = Album::findOrFail($id);
        $title = 'Edit Album';
        return view('albums.form', compact('title', 'album'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $album = Album::findOrFail($id);
        $title = 'Edit Album';
        return view('albums.form', compact('title', 'album'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $album = Album::findOrFail($id);
            $credentials = $request->validate([
                'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
                'name' => ['required']
            ]);
                
            $album->publish_at = $request->publish_at ? Carbon::parse($request->publish_at)->format('y-m-d') : null;
            $album->name = $request->name;
            $album->image = $request->image ? $this->upload($request, 'album-images') : $album->image;
            $album->active = $request->has('active') ? ($request->active == 1 ? 1 : 0) : 0;

            // return $album;

            if($album->save()) {
                DB::commit();
                return redirect('/albums/'.$album->id);
            }
     
            return back()->withErrors([
                'album_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            return back()->withErrors([
                'album_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $album = Album::findOrFail($id);
        $album->delete();
        return redirect()->route('albums.index');
    }
    
    public function getAlbumImage(string $id)
    {
        $album = Album::findOrFail($id);
        $images = $album->images()->get();
        return view('albums.image_list', compact('album', 'images'));
    }
    public function postalbumImage(Request $request, string $id)
    {
        $credentials = $request->validate([
            'image' => 'required|mimes:png,jpg,jpeg,webp|max:2048',
            'alt' => ['required']
        ]);
        $album = Album::findOrFail($id);
        $img = new AlbumImage([ 'alt' => $request->alt, 'image' => $request->image ? $this->upload($request, 'album-images') : 'https://placehold.co/50x50/png' ]); 
        
        $album->images()->save($img);
        return redirect()->route('albumImages', $id);
    }
    public function deletealbumImage(Request $request, string $id, string $imageId)
    {
        $album = Album::findOrFail($id);
        $img = $album->images()->where('id', $imageId)->first();
        if($img) $img->delete();
        return redirect()->route('albumImages', $id);
    }
}

