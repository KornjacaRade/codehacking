<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminMediaController extends Controller
{
    public function index(){

        $photos = Photo::all();
        return view('admin.media.index', compact('photos'));

    }

    public function create(){

        return view('admin.media.create');
    }

    public function store(Request $request){

        $file = $request->file('file'); // 'file' is from dropzone

        $name = time() . $file->getClientOriginalName();

        $file->move('images', $name);

        Photo::create(['file'=>$name]); //different 'file', it is from database photos table

    }

    public function destroy($id){

        $photo = Photo::findOrFail($id);

        unlink(public_path(). $photo->file);

        $photo->delete();


    }

    public function deleteMedia(Request $request){

//  For separate delete button
//        if(isset($request->delete_single)){
//            $this->destroy($request->photo);
//            return redirect()->back();
//        }

        if(isset($request->delete_all) && !empty($request->checkBoxArray)){

        $photos = Photo::findOrFail($request->checkBoxArray);

        foreach ($photos as $photo){
            $photo->delete();
              }
            return redirect()->back();

        }
        else {
            return redirect()->back();
        }
    }
}
