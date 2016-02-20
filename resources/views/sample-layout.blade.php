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

@section('Q7')
@endsection

@section('Q8')
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

		        $("#Q1").html("<u><b>Question 1:</b></u><br/> "+data['questions'][0]['question']); 
		        $("#Q2").html("<u><b>Question 2:</b></u><br/> "+data['questions'][1]['question']); 
	   	        $("#Q3").html("<u><b>Question 3:</b></u><br/> "+data['questions'][2]['question']); 
	   		    $("#Q4").html("<u><b>Question 4:</b></u><br/> "+data['questions'][3]['question']); 
	           	$("#Q5").html("<u><b>Question 5:</b></u><br/> "+data['questions'][4]['question']); 
	           	$("#Q6").html("<u><b>Question 6:</b></u><br/> "+data['questions'][5]['question']);
	           	$("#Q7").html(data['bonus']+"<br><br>Matrix:<br><div id='matrix'>"+data['output']+'</div>'); 
	        	if(data['status'] == 104){
	  				locked++;
	        		var i = 1;
	  				var id;
	  				for(i;i<=6;i++)
	  					if(data['locked_qpos'] != i){
	  					id = '#'+i;
	  					$(id).attr('class','not-active');
	  				}		
	        	}

	        },error:function(){ 
	            alert("error!");
	        }
    	});
	
  	//AJAX to lock the question
  	$('#confirm_lock').click(function(){
  		var confirm = $('#confirm').val();
  		if(confirm == 'Y'|| confirm == 'y'){
	  		$('#lock-row').fadeOut();
	  		locked++;
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
		           //alert('Succesfully Locked!'); 
		        },error:function(){ 
		            alert("error!");
		        }
	    	});
	  		$('#answer-row').fadeIn('slow');
	  		var i = 1;
	  		var id;
	  		for(i;i<=6;i++)
	  			if(current_question != i){
	  			id = '#'+i;
	  			$(id).attr('class','not-active');
	  		}
  	 	}
	});


  	//AJAX to check the answer
  	$('#submit_answer').click(function(){
  		var user_answer = $('#answer_input').val();
		
  		$.ajax({
  			dataType: "json",
	        url: "answer",
	        type:"POST",
	        data: {
	         PID : 1,
	         day : 1,
	         qpos : current_question,
	         answer : user_answer,
	     	},
	        success:function(data){

	            $.toaster({ priority : data['color'], title : '<strong>Message</strong>', message : data['description']}); 
	        
	        },error:function(){ 
	            alert("error!");
	        }
    	});
		
		
  	});
 });
</script>