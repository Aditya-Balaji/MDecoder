@extends('layouts.master')

@section('heading')
Mdecoder
@endsection

@section('instructions')
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. 
@endsection

@section('Q1')
@endsection

@section('Q2')
@endsection

@section('Q3')
@endsection

@section('Q4')
@endsection

@section('Q5')
@endsection

@section('Q6')
@endsection

@section('footer')
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex 
@endsection

<!--Javascript for AJAX -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
	
	//AJAX headers
	$.ajaxSetup({
  			headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  			}
		});

	//AJAX for retrieving questions
  		$.ajax({
  			dataType: "json",
	        url: "getquestion",
	        type:"POST",
	        data: {
	         user_id : 1,
	         day : 1,

	     	},
	        success:function(data){
	           $("#Q1").text(data['questions'][0]['question']); 
	           $("#Q2").text(data['questions'][1]['question']); 
	           $("#Q3").text(data['questions'][2]['question']); 
	           $("#Q4").text(data['questions'][3]['question']); 
	           $("#Q5").text(data['questions'][4]['question']); 
	           $("#Q6").text(data['questions'][5]['question']); 
	        },error:function(){ 
	            alert("error!");
	        }
    	});

  	//AJAX to lock the question
  	$('#lock').click(function(){
		$.ajax({
  			dataType: "json",
	        url: "lock",
	        type:"POST",
	        data: {
	         user_id : 1,
	         day : 1,
	         qpos : current_question,
	     	},
	        success:function(data){
	           alert('Succesfully Locked!'); 
	        },error:function(){ 
	            alert("error!");
	        }
    	})  		
  	});

  	
 });
</script>