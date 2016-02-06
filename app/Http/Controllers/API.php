<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Question;
use App\Http\Controllers\Controller;
use App\Lockedquestion;
use App\Tries;

class API extends Controller
{

    public function get_day(){
        	return 1;
        }


    public function request_question(Request $request){

    	$question = Question::where('day',$request->day)->get();
    	$data = [];


    	if(isset($request->day)){
    	
	    	if($request->day == $this->get_day()){
	    		$data['status'] = 200;
				$data['description'] = 'success';
				$data['questions'] = $question;
	    	}
	    	else {
	    		$data['status'] = 101;
	    		$data['description'] = 'Date Mismatch';

	    	}
	    		
    	}
    	else{
    		$data['status'] = 102;
    		$data['description'] = 'Request Error : This request accepts parameter called date';
    	}
    	return json_encode($data);
    	
    }


    public function tries_available(Request $request){

        $data = [];

        if (isset($request->day)) {

            if($request->day==$this->get_day()){
                $question = Lockedquestion::where('PID',$request->user_id)
                                      ->where('day',$request->day)
                                      ->first();
                
                if($question){
                    
                    $data['status'] = 200;
                    $data['description'] = 'success';
                    $data['tries'] = $question;   
                
                }                      
                
                else {
                    $data['status'] = 101;
                    $data['description'] = 'Question not locked';
                }

            }
            else {

                $data['status'] = 102;
                $data['description'] = 'Date Mismatch';                
                
            }
        }

        else{
            $data['status'] = 102;
            $data['description'] = 'Request Error : This request accepts parameter called day';      
        }
        
        return json_encode($data);

    }

}