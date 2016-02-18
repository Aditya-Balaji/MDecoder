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
		}
		#question-body{
			padding:5%;
		}

		.footer{
			position: absolute;
			bottom: 0;
			width: 100%;
			height: 60px;
			text-align: center;
			background-color: #E7E7E7;
			
		}
	</style>
	<title>layout</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="csrf-token" value="{{ csrf_token() }}">
  	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  	<script>
  	var current_question;
  	var locked = 0;
  	$(document).ready(function(){

  		
 		//Hide answer field 
  		$('#instructions').click(function(){
  			$('#lock-row').slideUp('slow');
  		});

  		//Display answer field
  		$('.question-button').click(function(){
  			//alert('clickwe');
  			current_question = $(this).attr('id');
   			if(locked == 0)
	  			$('#lock-row').slideDown('slow');
  			else
  				$('#answer-row').slideDown('slow');
  		});


  	});

  	</script>
</head>

<body>


	<nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('#') }}">
                    @yield('heading')
                </a>

            </div>
        </div>
    </nav>

    <br/><br/>

	<div class="container">
		<br/><br/>
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
				</ul>
  			</div>

  			<div class="panel-body">

 				<div class="row" id="question-body">

	  				<div class="tab-content">
						  
						  <div id="home" class="tab-pane fade in active">
						    <div class="col-sm-12">
					  			<b>Instructions:</b> 
					  			@yield('instructions')
				  			</div>
						  </div>

						  <div id="Q1" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(1):</b> <span id="Q1">@yield('Q1')</span> <br/><br/>
				  			</div>
						  </div>

						  <div id="Q2" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(2):</b> <span id="Q2">@yield('Q2')</span> <br/><br/>
				  			</div>
						  </div>

						  <div id="Q3" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(3):</b> <span id="Q3">@yield('Q3')</span> <br/><br/>
				  			</div>
						  </div>

						  <div id="Q4" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(4):</b> <span id="Q4">@yield('Q4')</span><br/><br/>
				  			</div>
						  </div>

						  <div id="Q5" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(5):</b><span id="Q5">@yield('Q5')</span><br/><br/>
				  			</div>
						  </div>

						  <div id="Q6" class="tab-pane fade">
						    <div class="col-sm-12">
					  			<b>Question(6):</b><span id="Q6">@yield('Q6')</span><br/><br/>
				  			</div>
						  </div>
		  			</div>

		  			<div id="answer-row">
			  			<div class="col-sm-4">
				  			<div class="form-group" id="answer">
				  				<label for="answer">Answer:</label>
				  				<input type="number" name="answer" class="form-control" id="answer_input">
							</div>
						</div>
						<div class="col-sm-3">
							<br/>
							<button type="submit" id="submit_answer" class="btn btn-lg btn-default">Submit</button>
						</div>
					</div>

					<div id="lock-row">	
						<div class="col-md-2 col-md-offset-5">
							<button id="lock" class="btn btn-lg btn-default">Lock</button>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
	<footer class="footer">
	@yield('footer')
	</footer>
	
</body>
</html>