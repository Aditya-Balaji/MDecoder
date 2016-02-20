<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    //
	protected $fillable=array('BID','question','ans1','ans2','ans3','ans4','ans5','ans6','sum','day');
	protected $table = 'bonus';
	protected $primaryKey='BID';
}