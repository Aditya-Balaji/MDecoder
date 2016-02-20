@extends('layouts.master')

@section('heading')
<span><img src="logo.png" width="100px" height="55px"  style="margin-top:-20px;"></span>
<span id="title">Mdecoder</span>
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
<br/>
Pragyan is an ISO 9001:2008 and ISO 20121:2012 certified student-run organisation.<br/>
As a techno-management fest, Pragyan has evolved into a significant embodiment that reveals to the world and students alike, the infinite opportunities in science and management.<br/>
 It is a four-day fest dedicated to giving a stellar experience in the field of techno-management.The fest offers a plethora of programmes; ranging from events, workshops, exhibitions, guest lectures, crossfires to offbeat contests and infotainment. Attended by some of the most renown personalities of our time and with an international outreach in 60 countries, Pragyan is a great platform for the realisation of dreams and new findings.<br/> The talent displayed so far, promises not just a change in the future, but the future itself. Every edition of Pragyan has transcended its former and this tradition remains to continue into the future.
<br/>
We at Pragyan, are a committed and competitive team with an outlook to innovate and celebrate technology. We remain determined in our motive to pursue excellence towards the satisfaction of our participants and beneficiaries by providing quality services. We plan to achieve the same by constantly improving the quality of our events through innovation and by providing fair judgement.
<br/>
Conforming to the ISO 20121:2012 standards, Pragyan intends to be a sustainable event. Financially viable activities are carried out keeping in mind our environment and society by large. Contributing to the society and bringing up viable solutions has remained the main idea of Pragyan. To achieve this goal, we also foster effective communication and promote professionalism amongst students of all ages.Thus, the promise of building a strong, innovative and sustainable world is kept every time.
<br/>
Pragyan is unique as it believes in the creativity and power of man to think and conquer the impossible. Pragyan's symbol - the wheel and this year, its theme: Fractals, represent the evolution of the world into infinite dimensions and ingenuity of complexity.
<br/>
<b>Let's Fracternize! Let's Celebrate Technology!</b>
@endsection


@section('footer')
question courtesy: Maximus 
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
	        url: "{{action('API@request_question')}}",
	        type:"POST",
	        data: {
	         user_id : 1,
	         day : 1,

	     	},
	        success:function(data){

		        $("#Q1").html("<u><b>Question 1</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['questions'][0]['difficulty']+"<br/> "+data['questions'][0]['question']); 
		        $("#Q2").html("<u><b>Question 2</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['questions'][1]['difficulty']+"<br/> "+data['questions'][1]['question']); 
	   	        $("#Q3").html("<u><b>Question 3</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['questions'][2]['difficulty']+"<br/> "+data['questions'][2]['question']); 
	   		    $("#Q4").html("<u><b>Question 4</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['questions'][3]['difficulty']+"<br/> "+data['questions'][3]['question']); 
	           	$("#Q5").html("<u><b>Question 5</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['questions'][4]['difficulty']+"<br/> "+data['questions'][4]['question']); 
	           	$("#Q6").html("<u><b>Question 6</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['questions'][5]['difficulty']+"<br/> "+data['questions'][5]['question']);
	           	$("#Q7").html(data['bonus']+"<br><br>Matrix:<br><div id='matrix'>"+data['output']+'</div>'	); 
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
		        url: "{{action('API@lock_question')}}",
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
	        url: "{{action('API@request_answer')}}",
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