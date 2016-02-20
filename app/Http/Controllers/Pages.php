<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Day;
use App\Http\Controllers\Controller;

class Pages extends Controller
{


    public function get_day(){
         
        $current_day = Day::first();
        return $current_day->day;
     }

    public function index(){
    	$day = $this->get_day();
    	return view('sample-layout')->with('day',$day);
    }

    public function leaderboard(Request $request){
    	//return $request->page;
    	if($request->page != 0)
    		$rank = 7*($request->page-1)+1;
    	else
    		$rank = 1;
    	$players = User::orderBy('score','desc')->paginate(7);
    	foreach ($players as $player) {
    		$player['rank'] = $rank++;
    	}
    	//return $players;
    	return view('layouts/leaderboard',compact('players'));
    }
}
