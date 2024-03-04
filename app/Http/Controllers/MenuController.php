<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DinnerMenu;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ImageTrait;

class MenuController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dinnerMenus = DinnerMenu::orderBy('id', 'desc')->get();
        return view('menu.list', compact('dinnerMenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Menu';
        $dinnerMenu = null;
        return view('menu.form', compact('title', 'dinnerMenu'));
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
                'name' => ['required']
            ]);
            $dinnerMenu = DinnerMenu::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $request->image ? $this->upload($request, 'menu-images') : 'https://placehold.co/50x50/png'
            ]);

            if($dinnerMenu) {
                DB::commit();
                return redirect('/dinner-menus/'.$dinnerMenu->id);
            }
     
            return back()->withErrors([
                'menu_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            
            return back()->withErrors([
                'menu_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dinnerMenu = DinnerMenu::findOrFail($id);
        $title = 'Edit Menu';
        return view('menu.form', compact('title', 'dinnerMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dinnerMenu = DinnerMenu::findOrFail($id);
        $title = 'Edit Menu';
        return view('menu.form', compact('title', 'dinnerMenu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $dinnerMenu = DinnerMenu::findOrFail($id);
            $credentials = $request->validate([
                'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'name' => ['required']
            ]);

            $dinnerMenu->name = $request->name;
            $dinnerMenu->description = $request->description;
            $dinnerMenu->image = $request->image ? $this->upload($request, 'menu-images') : $dinnerMenu->image;

            // return $dinnerMenu;

            if($dinnerMenu->save()) {
                DB::commit();
                return redirect('/dinner-menus/'.$dinnerMenu->id);
            }
     
            return back()->withErrors([
                'menu_error' => 'Error in saving record.',
            ])->withInput();

        }catch(\Exception $e){
            DB::rollback();
            return back()->withErrors([
                'menu_error' => 'Error in saving record. '.$e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $dinnerMenu = DinnerMenu::findOrFail($id);
        $dinnerMenu->delete();
        return redirect()->route('dinner-menus.index');
    }
}
