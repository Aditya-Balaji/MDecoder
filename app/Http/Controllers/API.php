<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Question;
use App\User;
use App\Lockedquestion;

use App\Http\Controllers\Controller;

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

        $result = Question::where('day',$request->day)->where('qpos',$request->qpos)->where('answer',$request->answer)
                                                      ->first();
        $data= [];


        if(isset($request->day) && isset($request->qpos))
        {
        

                if($result['answer']==$request->answer)
                {
                  $data['status'] = 200;
                  $data['description'] = 'success';
                  $data['result'] = '1';
                }
                else
                {
                
                  $data['status'] = 101;
                  $data['description'] = '0';
                }
            

        }
        
        else
           {
            
            $data['status'] = 102;
            $data['description'] = 'Request Error : This request requires parameters-date,answer and qpos';
           
           }
        return json_encode($data);
        
    
    }

 public function request_locked(Request $request){

            $locked = Lockedquestion::where('day',$request->day)->where('PID',$request->PID)
                                                                ->pluck('QID');
        
            $question=Question::where('QID',$locked)->where('day',$request->day)->pluck('qpos');        
           $data = [];


        if(isset($request->day) && isset($request->PID)) {
        
            if($request->day == $this->get_day() && $this->user_check($request->PID))
            {
                $data['status'] = 200;
                $data['description'] = 'success';
            if($question=='[]')
               {
                $data['lockedquestion'] = 0;
               }  
            else
               { 
                $data['lockedquestion'] = $question;
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
