<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Question;
use App\User;
use App\Lockedquestion;

use App\Http\Controllers\Controller;
use App\Lockedquestion;
use App\Tries;

class API extends Controller
{

    public function get_day(){
        	return 1;
        }


    public function user_check($pid)
    {
       if($user=User::where('PID',$pid)->exists())
    return 1;
        else 
    return 0;

    }


    public function request_question(Request $request)
    {

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

public function request_answer(Request $request){

        $answer = Question::where('day',$request->day)->where('qpos',$request->qpos)->first();
        $data= [];


        if(isset($request->day) && isset($request->qpos))
        {
        

                if($answer['answer']!=null)
                {
                  $data['status'] = 200;
                  $data['description'] = 'success';
                  $data['answer'] = $answer['answer'];
                }
                else
                {
                
                  $data['status'] = 101;
                  $data['description'] = 'Wrong qpos-day combination';
                }
            

        }
        
        else
           {
            
            $data['status'] = 102;
            $data['description'] = 'Request Error : This request requires parameters-date and qpos';
           
           }
        return json_encode($data);
        
    
    }

 public function request_locked(Request $request){

            $locked = Lockedquestion::where('day',$request->day)->where('PID',$request->PID)
                                                                ->lists('QID');
        
           $data = [];


        if(isset($request->day) && isset($request->PID)) {
        
            if($request->day == $this->get_day() && $this->user_check($request->PID))
            {
                $data['status'] = 200;
                $data['description'] = 'success';
            if($locked=='[]')
               {
                $data['lockedquestion'] = 0;
               }  
            else
               { 
                $data['lockedquestion'] = $locked;
                }
            }
            else {
                $data['status'] = 101;
                $data['description'] = 'Day Mismatch or PID entered is wrong';

            }
                
        }
        else{
            $data['status'] = 102;
            $data['description'] = 'Request Error : This request requires parameters-day and user_id';
        }
        return json_encode($data);
        
    
    }

    

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