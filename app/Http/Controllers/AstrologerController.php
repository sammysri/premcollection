<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Astrologer;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ImageTrait;

class AstrologerController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $astrologers = Astrologer::orderBy('id', 'desc')->get();
        return view('astrologers.list', compact('astrologers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Astrologer';
        $astrologer = null;
        return view('astrologers.form', compact('title', 'astrologer'));
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
                'experience' => ['required']
            ]);
            $astrologer = Astrologer::create([
                'name' => $request->name,
                'description' => $request->description,
                'active' => $request->has('active') ? ($request->active == 1 ? 1 : 0) : 0,
                'image' => $request->image ? $this->upload($request, 'astrologer-images') : 'https://placehold.co/50x50/png',
                'experience' => $request->experience
            ]);

            if($astrologer) {
                DB::commit();
                return redirect('/astrologers/'.$astrologer->id);
            }
     
            return back()->withErrors([
                'astrologer_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            
            return back()->withErrors([
                'astrologer_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $astrologer = Astrologer::findOrFail($id);
        $title = 'Edit Astrologer';
        return view('astrologers.form', compact('title', 'astrologer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $astrologer = Astrologer::findOrFail($id);
        $title = 'Edit Astrologer';
        return view('astrologers.form', compact('title', 'astrologer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $astrologer = Astrologer::findOrFail($id);
            $credentials = $request->validate([
                'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'name' => ['required'],
                'experience' => ['required']
            ]);

            $astrologer->name = $request->name;
            $astrologer->description = $request->description;
            $astrologer->experience = $request->experience;
            $astrologer->active = $request->has('active') ? ($request->active == 1 ? 1 : 0) : 0;
            $astrologer->image = $request->image ? $this->upload($request, 'astrologer-images') : $astrologer->image;

            // return $astrologer;

            if($astrologer->save()) {
                DB::commit();
                return redirect('/astrologers/'.$astrologer->id);
            }
     
            return back()->withErrors([
                'astrologer_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            return back()->withErrors([
                'astrologer_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $astrologer = Astrologer::findOrFail($id);
        $astrologer->delete();
        return redirect()->route('astrologers.index');
    }
}
