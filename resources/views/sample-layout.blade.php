@extends('layouts.master')

@section('heading')
<span><img src="logo.png" width="100px" height="55px"  style="margin-top:-20px;"></span>
<span id="title" style="margin">Mdecoder</span>
@endsection

@section('user_name')
Hi! {{$user_name}}
@endsection

@section('instructions')
This is a <b><u>6 day online event</u></b>. 
<br><br>
* Each day <b><u>6 questions</u></b> with different weightages(2-easy,2-medium,2-hard) and <b><u> an encrypted

  puzzle </u></b>(which gives a sequence of numbers ) will be presented.
<br><br>
* The participant has to solve <b><u>only 1</u></b> out of the 6 questions(mandatory) and he may solve the

   puzzle(not mandatory) for bonus points.
<br><br>
* To aid the participant to get a “better score” ,<b><u> a puzzle (as mentioned above), and an equation
 </u></b> will be presented to the participant.
<br><br>
<b><u>Event Equation: AX=B</u></b>
<br>
  * A (6*6 matrix) - Given to participant (which is frequently updated by the server to keep up the equation AX=B).
<br><br>
  * X (6*1 matrix) - To be deducted from puzzle.
<br><br>
  * B (6*1 matrix) - Gives information about the number of participants who have solved each question upto that point in time.
<br><br>
* The Bonus answer will be completely related to the puzzle. i.e., the sum of all the values of matrix X is the bonus answer.
<br><br>
* So, solving the puzzle not only gets the person bonus points but also helps him get Matrix B(6*1matrix),

   which hints at the number of participants who solved at that time.
<br><br>

The score of a participant is decided by the <b><u>difficulty</u></b> of the problem he has solved that day as well as <b><u>the number of people </u></b>who have solved the problem before him. 
<br><br>
<b><u>Tip:</u></b> 

Let’s say you see a question with high difficulty, which can potentially fetch you many points. 

But suppose you find that many people have already solved this question, and only a few people have solved a relatively easier

question. In this case, solving the easier question is probably more profitable, since the score of a participant also depends on the

number of people who have previously solved the question.

<br> 
<br>
* The 6 questions will test basic concepts in algebra, combinatorics, geometry and related topics and some common sense.
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
<b><u>Let's Fracternize! Let's Celebrate Technology!</u></b>
@endsection


@section('footer')
Questions set with &hearts; by Maximus, Math Society of NITT
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
		$("#loading").css('display', 'block');
	//AJAX for retrieving questions
  		$.ajax({
  			dataType: "json",
	        url: "{{action('API@request_question')}}",
	        type:"POST",
	        data: {
	         user_id : {{$user_id}},
	         day : {{$day}},

	     	},
	        success:function(data){
	        	if(data['status'] == 200){

		        $("#Q1").html("<u><b>Question 1</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['questions'][0]['difficulty']+"<br/> "+data['questions'][0]['question']); 
		        $("#Q2").html("<u><b>Question 2</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['questions'][1]['difficulty']+"<br/> "+data['questions'][1]['question']); 
	   	        $("#Q3").html("<u><b>Question 3</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['questions'][2]['difficulty']+"<br/> "+data['questions'][2]['question']); 
	   		    $("#Q4").html("<u><b>Question 4</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['questions'][3]['difficulty']+"<br/> "+data['questions'][3]['question']); 
	           	$("#Q5").html("<u><b>Question 5</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['questions'][4]['difficulty']+"<br/> "+data['questions'][4]['question']); 
	           	$("#Q6").html("<u><b>Question 6</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['questions'][5]['difficulty']+"<br/> "+data['questions'][5]['question']);

	           	$("#Q7").html(data['bonus']+"<br><br>Matrix:<br><div id='matrix'>"+data['output']+'</div><div>Use <a href="http://matrix.reshish.com/multiplication.php">this link</a> to do matrix multiplication!</div>'	); 
	        	
	        	}
	        	if(data['status'] == 104){
	        		
	        		$("#Q"+data['locked_qpos']).html("<u><b>Question "+data['locked_qpos']+"</b></u><br/><b><u>Difficulty: </u></b>&nbsp"+data['difficulty']+"<br/> "+data['question']);
	           		$("#Q7").html(data['bonus']+"<br><br>Matrix:<br><div id='matrix'>"+data['output']+'</div>'	);

	  				locked++;
	        		var i = 1;
	  				var id;
	  				for(i;i<=6;i++)
	  					if(data['locked_qpos'] != i){
	  					id = '#'+i;
	  					$(id).attr('class','not-active');
	  				}		
	        	}
	        	$("#loading").css('display', 'none');
	        },error:function(){ 
	            alert("error!");
	        }
    	});
	
  	//AJAX to lock the question
  	$('#confirm_lock').click(function(){
  		var confirm = $('#confirm').val();
  		if(confirm == 'Y'|| confirm == 'y'){
	  		$('#lock-row').fadeOut();
	  		$("#loading").css('display', 'block');
	  		locked++;
	  		$.ajax({
	  			dataType: "json",
		        url: "{{action('API@lock_question')}}",
		        type:"POST",
		        data: {
		         user_id : {{$user_id}},
		         day : {{$day}},
		         qpos : current_question,
		     	},
		        success:function(data){
		           //alert('Succesfully Locked!'); 
		           $("#loading").css('display', 'none');
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
		$("#loading").css('display', 'block');
  		$.ajax({
  			dataType: "json",
	        url: "{{action('API@request_answer')}}",
	        type:"POST",
	        data: {
	         user_id : {{$user_id}},
	         day : {{$day}},
	         qpos : current_question,
	         answer : user_answer,
	     	},
	        success:function(data){
	        	$("#loading").css('display', 'none');
	            $.toaster({ priority : data['color'], title : '<strong>Message</strong>', message : data['description']}); 
	        
	        },error:function(){ 
	            alert("error!");
	        }
    	});
		
		
  	});
 });
</script>