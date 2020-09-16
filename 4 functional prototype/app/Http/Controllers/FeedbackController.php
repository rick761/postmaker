<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FeedbackForm;

class FeedbackController extends Controller
{    
        public function create(Request $request){   
            $item = new FeedbackForm;               
            $item->version = $request->version;
            $item->story = $request->version; 
            $item->rate = $request->version;
            if(isset($item->feedback)){$item->feedback = $request->feedback;}
            if(isset($item->notation)){$item->notation = $request->notation;}
            $item->save();

            return $item;      
        }

        public function get(){
            return feedbackForm::all();
        }

}
