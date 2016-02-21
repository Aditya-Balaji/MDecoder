<!DOCTYPE html>
<html>

<head>
	<style>
		#lock-row{
			display: none;
		}
		#answer-row{
			display: none;
		}
		.not-active{
			cursor : default;
			pointer-events: none;
			opacity: 0.5;
			background-color: lightgrey;
			padding-left: 1%;
		}
		#question-body{
			padding:3%;
		}
		.question-button{
			padding-left: 1%;
		}
		#main-box{
			opacity: 0.97;
			margin-top: 2%;
		}
		#matrix{
			margin-left: 25%;
			margin-right: 40%;
			padding-left: 4%;
			padding-top: 10px;
			padding-bottom: 10px;
			border-left : 1px solid white;
			border-right : 1px solid white;
			border-radius: 5%;
			white-space: nowrap;
			overflow: auto;
		}
		#title{
			padding-left: 20px;
			font-family: Audiowide;
		}
		#help-links{
			font-size: 90%;
			margin-top: 10px;
			font-family: Audiowide;
		}

		#loading {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url('loading.gif') 50% 50% no-repeat rgb(249,249,249);
		}

	</style>
	<title>MDecoder</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="csrf-token" value="{{ csrf_token() }}">
  	<link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/sticky-footer-navbar.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  	<script src="js/jquery.toaster.js"></script>
  	<link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
  	<script>
  	var current_question;
  	var locked = 0;
  	$(document).ready(function(){

  		
 		//Hide answer field 
  		$('#instructions').click(function(){
  			if(locked == 0)
  				$('#lock-row').fadeOut('slow');
  			else 
  				$('#answer-row').fadeOut('slow');
  		});

  		//Display answer field
  		$('.question-button').click(function(){
  			//alert('clickwe');
  			current_question = $(this).attr('id');
   			if(current_question != 8){

	   			if(locked == 0)
	   				if(current_question == 7){
			  			$('#lock-row').fadeOut();
			  			$('#answer-row').fadeIn('slow');
	   				}
			  		else{
			  			$('#answer-row').fadeOut();
			  			$('#lock-row').fadeIn('slow');	
			  		}
	   			
	  			else
	  				$('#answer-row').fadeIn('slow');
 	  		}

 	  		else{

 	  			$('#lock-row').fadeOut();
 	  			$('#answer-row').fadeOut();	
 	  		}
  		
  		});

  	});

  	</script>
</head>

<body>



<div id="loading" style="display:none;"></div>

	<nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Branding Image -->
                

                	<div class="container">
                		<div class="col-sm-9">
	                		<a class="navbar-brand" href="{{ action('LoginController@index') }}">
	        	        	    @yield('heading')
        	        		</a>
    	     			</div>

    	       			<div class="col-sm-2" id="help-links">
  						<div class="dropdown">
							  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
							  		@yield('user_name')
								  <span class="caret"></span></button>
								  <ul class="dropdown-menu">
								    <li><a href="{{action('Pages@leaderboard')}}">Leaderboard</a></li>
								    <li><a href="{{action('LoginController@logout')}}">Logout</a></li>
								  </ul>
								</div>
  						
	        	        
	        	        
	        	        </div>
    	        	</div>
    	        	
    	        

            </div>
        </div>
    </nav>

    

	<div class="container" id="main-box">
			
		<div class="panel panel-default" id="question-panel">
  			
  			<div class="panel-heading">
  				<ul class="nav nav-pills">
				  <li class="active"><a data-toggle="pill" href="#home" id="instructions">Instructions</a></li>
				  <li><a data-toggle="pill" id='1' class="question-button" href="#Q1">Question 1</a></li>
				  <li><a data-toggle="pill" id='2' class="question-button" href="#Q2">Question 2</a></li>
				  <li><a data-toggle="pill" id='3' class="question-button" href="#Q3">Question 3</a></li>
				  <li><a data-toggle="pill" id='4' class="question-button" href="#Q4">Question 4</a></li>
				  <li><a data-toggle="pill" id='5' class="question-button" href="#Q5">Question 5</a></li>
				  <li><a data-toggle="pill" id='6' class="question-button" href="#Q6">Question 6</a></li>
				  <li><a data-toggle="pill" id='7' class="question-button" href="#Q7">Bonus</a></li>
				  <li><a data-toggle="pill" id='8' class="question-button" href="#Q8">About Pragyan</a></li>
				</ul>
  			</div>

  			<div class="panel-body">

 				<div class="row" id="question-body">

	  				<div class="tab-content">
						  
						  <div id="home" class="tab-pane fade in active">
						    <div class="col-sm-12">
					  			<u><b>Instructions:</b></u><br/> 
					  			@yield('instructions')
				  			</div>
						  </div>

						  <div id="Q1" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(1):</b> <span id="Q1">@yield('Q1')</span> <br/>
				  			</div>
						  </div>

						  <div id="Q2" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(2):</b> <span id="Q2">@yield('Q2')</span> <br/>
				  			</div>
						  </div>

						  <div id="Q3" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(3):</b> <span id="Q3">@yield('Q3')</span> <br/>
				  			</div>
						  </div>

						  <div id="Q4" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(4):</b> <span id="Q4">@yield('Q4')</span><br/>
				  			</div>
						  </div>

						  <div id="Q5" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(5):</b><span id="Q5">@yield('Q5')</span><br/>
				  			</div>
						  </div>

						  <div id="Q6" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(6):</b><span id="Q6">@yield('Q6')</span><br/>
				  			</div>
						  </div>

						  <div id="Q7" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(7):</b><span id="Q7">@yield('Q7')</span><br/>
				  			</div>
						  </div>
						  <div id="Q8" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>About Pragyan:</b><span id="Q8">@yield('Q8')</span><br/>
				  			</div>
						  </div>
		  			</div>

		  			<div id="answer-row">
		  			<hr/>
			  			<div class="col-sm-4">
				  			<div class="form-group" id="answer">
				  				<label for="answer">Answer:</label>
				  				<input type="number" name="answer" class="form-control" id="answer_input">
							</div>
						</div>
						<div class="col-sm-8">
							<br/>
							<button type="submit" id="submit_answer" class="btn btn-lg btn-default">Submit</button>
						</div>
		  				<div><font color="#0ce3ac">Remember that you can only try answering a question 3 times!</font></div>
					</div>

					<div id="lock-row">	
						<hr/>
						<div class="col-md-2 col-md-offset-5">
							<button id="lock" class="btn btn-lg btn-default" data-toggle="modal" data-target="#lock_modal">Lock</button>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
	
	
	
	<div id="lock_modal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

    	  
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal">&times;</button>
	        		<h4 class="modal-title">Type Y/y to confirm your lock :  </h4><br/>
	        		<b>Warning!! : </b> Once your choice of question has been locked, it is not possible to choose again.
	      		</div>
	      		<div class="modal-body">
	        		<input type="text" name="confirm" class="form-control" id="confirm" />
	      		</div>
	      		<div class="modal-footer">
	      			<button type="submit" id="confirm_lock" class="btn btn-lg btn-default" data-dismiss="modal">Confirm?</button>
	      		</div>
	    	</div>

  		</div>
	</div>

	<footer class="footer" id="title">
      <div class="container">
        <p class="text-muted" style="text-align:center">@yield('footer')</p>
      </div>
    </footer>	

</body>
</html>