<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FeedbackForm;

class FeedbackController extends Controller
{    
        public function create(Request $request){        
            $item = FeedbackForm::create($request->all());    
            $item->version = $request->version;
            return $item->save();        
        }
        public function get(){
            return feedbackForm::all();
        }
}
