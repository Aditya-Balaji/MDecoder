<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Question;
use App\User;
use App\Lockedquestion;

use App\Http\Controllers\Controller;
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

    //Accepts parameters 'day' and 'user_id'
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

//Accepts 'qpos','PID','day','answer'
public function request_answer(Request $request)
{

        $result = Question::where('day',$request->day)->where('qpos',$request->qpos)
                                                      ->first();
        $data= [];

        $try_count_check=Lockedquestion::where('PID',$request->PID)->where('day',$request->day)
                                                                   ->where('QID',$result['QID'])
                                                                   ->pluck('try_count');
        
        $success_check=Lockedquestion::where('PID',$request->PID)->where('day',$request->day)
                                                                   ->where('QID',$result['QID'])
                                                                   ->pluck('successful');
        if($try_count_check<=0 || $success_check==null)  
           {

             $data['status'] = 103;
             $data['description'] = "Already Answered or Tries Limit Reached";



           }                                                            

        elseif(isset($request->day) && isset($request->qpos))
        {
        

                if($result['answer']==$request->answer)
                { 
                
                //updates QID in locked_questions table
                  Lockedquestion::where('PID',$request->PID)->where('day',$request->day)->decrement('try_count',1,['QID' => $result['QID']]);
                 //plucks the corresponding try_count column
                  $try_count=Lockedquestion::where('PID',$request->PID)->where('day',$request->day)->pluck('try_count');
                
                //inserts a new row in tries table
                //uses $try_count to fill try_no column
                $try_no=3-$try_count;
                $try=new Tries;
                $try->PID=$request->PID;
                $try->QID=$result['QID'];
                $try->answer=$result['answer'];
                $try->try_no=$try_no;
                $try->save();
                
               //plucks TID of the row inserted above
                $TID=Tries::where('PID',$request->PID)->where('QID',$result['QID'])
                                                             ->where('try_no',$try_no)
                                                             ->pluck('TID');
                //updates locked_questions table successful=$TID 
                Lockedquestion::where('PID',$request->PID)->where('day',$request->day)
                                                           ->update(['successful' =>$TID]);
                
                  $data['status'] = 200;
                  $data['description'] = 'success';
                  $data['result'] = '1';
                }

            elseif($result['answer']!=$request->answer)
                {
                     
                  Lockedquestion::where('PID',$request->PID)->where('day',$request->day)->decrement('try_count',1,['QID' => $result['QID']]);
                  $try_count=Lockedquestion::where('PID',$request->PID)->where('day',$request->day)->pluck('try_count');
                
                //inserts a new row in tries table
                //uses $try_count to fill try_no column
                $try_no=3-$try_count;
                $try=new Tries;
                $try->PID=$request->PID;
                $try->QID=$result['QID'];
                $try->answer=$request->answer;
                $try->try_no=$try_no;
                $try->save();



                  $data['status'] = 101;
                  $data['description'] = 0;
                }
            

        }
        
        else
           {
            
            $data['status'] = 102;
            $data['description'] = 'Request Error : This request requires parameters-date,answer and qpos';
           
           }
        return json_encode($data);
        
    
    }

 public function request_locked(Request $request)
 {

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

    /*
    Accepts:  
    'user_id',
    'qpos'
    'day',
    */
    public function lock_question(Request $request){
      
      //get the corresponding question with day and qpos
      $question = Question::where('day',$request->day)
                          ->where('qpos',$request->qpos)
                          ->get();

      //update that question into LockedQuestions table
      $lock = new Lockedquestion();
      $lock->PID = $request->user_id;
      $lock->QID = $question->QID;
      $lock->day = $request->day;
      $lock->save();  
    }    

}


