<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Day;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\User as User;
use Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_day(){
         
        $current_day = Day::first();
        return $current_day->day;
     }

    public function index(){
        $day = $this->get_day();
        $user_id = Session::get('user_id');
        $user_name = User::where('PID',$user_id)->pluck('name');
        //return $user_name;
        return view('sample-layout')->with(['day' => $day,'user_id' => $user_id,'user_name' => $user_name]);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $email = $request->email;
        $password = $request->password;
        $client = new Client();
        $res = $client->post('https://api.pragyan.org/user/eventauth', 
            array   (
                        'body' => array(
                            'user_email' =>  $email,'event_id'=>'39','user_pass'=>$password
                    )
                )
            );
        $res = json_decode($res->getBody(), true);
        if($res['status'] > 0)
        {
            if(User::where('email',$email)->exists())
            {
                $user=User::where('email',$email)->first();
                Session::put('user_id',$user->PID);
                return redirect('home');
            }
            $res = $client->post('https://api.pragyan.org/user/getDetails', 
            array   (
                        'body' => array(
                            'user_email' =>  $email,'user_pass'=>$password
                    )
                )
            );
            $res = json_decode($res->getBody(), true);
            if($res['status']==2)
            {
                $user = new User();
                $user->name = $res['data']['user_fullname'];
                $user->prag_pid = $res['data']['user_id'];
                $user->email = $email;
                $user->save();
                Session::put('user_id',$user->PID);
                return redirect('home');

            }
            else
                return view('login', ['error'=>'Try after sometime']);
            
        }
        else
            return view('login', ['error'=>'Email or password incorrect! If not registered, register at <a href="http://prgy.in/mdecoder">prgy.in/mdecoder</a>']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        //
        Session::flush();
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
