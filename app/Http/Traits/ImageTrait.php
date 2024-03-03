<?php
namespace App\Http\Traits;
trait ImageTrait {
    public function upload($request, $path) {        
        try {
            if($request['image']) {
                $imageName = time().'.'.$request['image']->extension();        
                $request['image']->move(public_path($path), $imageName);
                return env('DOMAIN_URL').$path.'/'.$imageName;
            }
            else {
                return 'https://placehold.co/50x50/png';
            }
        } catch (\Throwable $th) {
            //throw $th;
            return 'https://placehold.co/50x50/png';
        }
    }
}