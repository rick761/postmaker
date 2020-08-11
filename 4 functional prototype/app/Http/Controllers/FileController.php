<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function upload(Request $request, $type, $folder){
        $type; //uses  'user_images' & 'avatar', 'order_files'        
        $folder; // empty = 'no extra folder'
        $userId = Auth::id();  
        $to_upload_path = $userId.'/'.$type.'/'.$folder.'/';
        if($folder == 'no extra folder'){
            $to_upload_path = $userId.'/'.$type.'/';
        }
             

        if($request->hasFile('files')){
            foreach($request->file('files') as $file){ 
                $name = $file->getClientOriginalName();
                $ext  = strtolower($file->getClientOriginalExtension()); 
                $path = $file->storeAs( $to_upload_path, $name, 'public' );                  
            };            
        }        
    }


}
