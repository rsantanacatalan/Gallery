<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photos;
class PhotosController extends Controller
{
    public function index(Request $request)
    {
        
        if($request->name != ""){
            

            $photos = Photos::where('label','like', '%'.$request->name.'%' )->get();
            return view('Gallery.index', [
                    'photos' => $photos
            ]);
        }
        else{

            $photos = Photos::get();
            
            return view('Gallery.index', [
                    'photos' => $photos
            ]);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'label' => 'required',
            'url' => 'required'
        ]);
        
        Photos::create([
            'label' => $request->label,
            'url' => $request->url
        ]);

        return back();
    }

    public function delete(Photos $photo)
    {
     
        $photo->delete();

        return back();
    }
}
