<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Question;
use App\User;
use App\Lockedquestion;
use App\Bonus;
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

    /*
    Get that day's question
    Accepts parameters
     'day'
     'user_id'
    */
    public function request_question(Request $request)
    {

      $data = [];
      //Check if the user has already locked a question for the day
      $locked = Lockedquestion::where('PID',$request->user_id)
                              ->where('day',$request->day)
                              ->first();
      if(!empty($locked)){
        
        $locked_question = Question::where('QID',$locked->QID)
                            ->first();
        $question = Question::where('day',$request->day)->get();
        //return $question;                   
        $data['status'] = 104;
        $data['description'] = 'Locked for the day';
        $data['locked_qpos'] = $locked_question->qpos;
        $data['questions'] = $question;
      
      }
      else{

      	$question = Question::where('day',$request->day)->get();
      	


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

      }
	   $q = Question::where('day',$request->day)->get();
	  $bonus=Bonus::where('day',$request->day)->first();
	  $data['bonus']=$bonus->question;
	  $counts=[$q[0]->count,$q[1]->count,$q[2]->count,$q[3]->count,$q[4]->count,$q[5]->count];
	  $answers=[$bonus->ans1,$bonus->ans2,$bonus->ans3,$bonus->ans4,$bonus->ans5,$bonus->ans6];
	  
	  $output=shell_exec("sudo python /home/vijay/trial.py ".$counts[0]." ".$counts[1]." ".$counts[2]." ".$counts[3]." ".$counts[4]." ".$counts[5]." ".$answers[0]." ".$answers[1]." ".$answers[2]." ".$answers[3]." ".$answers[4]." ".$answers[5]);
	
	  $data['output']=$output;
    	return json_encode($data);
    	
    }
	
	 

/*
Find whether the user answer is correct
Accepts -  
'qpos'
'PID'
'day'
'answer'
*/
public function request_answer(Request $request)
{
if($request->qpos<7)
{
        //get the question with the 'day' and 'qpos'
        $result = Question::where('day',$request->day)
                          ->where('qpos',$request->qpos)
                          ->first();
        $data= [];
        
        //Get the question from LockedQuestions table
        $locked = Lockedquestion::where('PID',$request->PID)
                                ->where('day',$request->day)
                                ->where('QID',$result->QID)
                                ->first();
                                       
        //return $locked;
        
        //return $result->QID;
        if($locked->try_count <= 0)  
           {

             $data['status'] = 102;
             $data['color'] = 'warning';
             $data['description'] = "your're outta tries!! :O";

           }

        elseif($locked->successful != 0){
             $data['status'] = 103;
             $data['color'] = 'info';
             $data['description'] = "You have already answered this question!! :)";
        }                                                            

        elseif(isset($request->day) && isset($request->qpos))
        {
        

                if($result->answer==$request->answer)
                { 
                
                //updates QID in locked_questions table
                  Lockedquestion::where('PID',$request->PID)
                                ->where('day',$request->day)
                                ->decrement('try_count',1,['QID' => $result['QID']]);

                  Question::where('PID',$request->PID)
                          ->where('day',$request->day)
                          ->increment('try_count',1,['QID' => $result['QID']]);

                //plucks the corresponding try_count column
                $try_count=Lockedquestion::where('PID',$request->PID)
                                         ->where('day',$request->day)
                                         ->pluck('try_count');
                
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
                $TID=Tries::where('PID',$request->PID)
                          ->where('QID',$result['QID'])
                          ->where('try_no',$try_no)
                          ->pluck('TID');

                //updates locked_questions table successful=$TID 
                Lockedquestion::where('PID',$request->PID)
                              ->where('day',$request->day)
                              ->update(['successful' =>$TID]);
                
                  $data['status'] = 200;
                  $data['color'] = 'success';
                  $data['description'] = 'Correct Answer!! :)';
                  $data['result'] = '1';
                }

            elseif($result->answer!=$request->answer)
                {
                     
                  Lockedquestion::where('PID',$request->PID)
                                ->where('day',$request->day)
                                ->decrement('try_count',1,['QID' => $result['QID']]);

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
                  $data['color'] = 'danger';
                  $data['description'] = 'Wrong Answer!! :(';
                }
            

        }
        
        else
           {
            
            $data['status'] = 105;
            $data['color'] = 'info';
            $data['description'] = 'Request Error : This request requires parameters-date,answer and qpos';
           
           }
        return json_encode($data);
      }
else{
$data= [];
        $question=Bonus::where('day',$request->day)->first();
        //Get the question from LockedQuestions table
       
                                       
        $tries=Tries::where('PID',$request->PID)->where('BID',$question->BID)->get();
        
      
        if(sizeof($tries)>=3)  
           {

             $data['status'] = 102;
             $data['color'] = 'warning';
             $data['description'] = "your're outta tries!! :O";

           }

               else{                                                    
               
				$try_count=sizeof($tries)+1;
                //inserts a new row in tries table
                //uses $try_count to fill try_no column
                $bonus_try_no=3-$try_count;
                $try=new Tries;
                $try->PID=$request->PID;
                $try->BID=$question['BID'];
                $try->answer=$request->answer;
                $try->bonus_try_no=$bonus_try_no;
                $try->save();
            
        if(isset($request->day) && isset($request->qpos))
        {
        

                if($question->sum==$request->answer)
                { 
                
                
                
                
                  $data['status'] = 200;
                  $data['color'] = 'success';
                  $data['description'] = 'Correct Answer!! :)';
                  $data['result'] = '1';
                }

            elseif($question->sum!=$request->answer)
                {
                     
            

                  $data['status'] = 101;
                  $data['color'] = 'danger';
                  $data['description'] = 'Wrong Answer!! :(';
                }
            

        }
        
        else
           {
            
            $data['status'] = 105;
            $data['color'] = 'info';
            $data['description'] = 'Request Error : This request requires parameters-date,answer and qpos';
           
      
		   }
		   }
        return json_encode($data);
}	  
    
    }

/*
accepts 
'day',
'PID',
*/

 public function request_locked(Request $request)
 {
          //Get the QID of the locked question for the day by the user
          $locked = Lockedquestion::where('day',$request->day)
                                  ->where('PID',$request->PID)
                                  ->pluck('QID');
        
          $question=Question::where('QID',$locked)
                            ->where('day',$request->day)
                            ->pluck('qpos');

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
                          ->first();

      //check whether a day's question has been already locked or not
      $locked_status = Lockedquestion::where('PID',$request->user_id)
                                     ->where('day',$request->day)
                                     ->first();
      if(empty($locked_status)){
        
        //update that question into LockedQuestions table
        $lock = new Lockedquestion();
        $lock->PID = $request->user_id;
        $lock->QID = $question->QID;
        $lock->day = $request->day;
        $lock->save();  
        return 1;  
      
      }                                
      
      return 0;
    
    }   

}


