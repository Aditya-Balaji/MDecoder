<html>

<head>

	<title>MDecoder Pragyan</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="csrf-token" value="{{ csrf_token() }}">
  	<link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/sticky-footer-navbar.css">
    <link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  	<script src="js/jquery.toaster.js"></script>
  	<style>

  	#main-box{
			opacity: 0.97;
			margin-top: 2%;
		}
    #title{
      padding-left: 20px;
      font-family: Audiowide;
    }
    #help-links{
      margin-top: 10px;
      font-size: 90%;
      font-family: Audiowide;
    }
	</style>
</head>

<body>

<nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Branding Image -->
                

                  <div class="container">
                    <div class="col-sm-9">
                      <a class="navbar-brand" href="{{ action('LoginController@index') }}">
                          <span><img src="logo.png" width="100px" height="55px"  style="margin-top:-20px;"></span>
                          <span id="title" style="margin">Mdecoder</span>
                      </a>
                </div>

                  <div class="col-sm-3" id="help-links">
              
              <div class="col-sm-6">
                        <div class="dropdown" style="margin-top:10px;">
                <a href="{{action('Pages@leaderboard')}}">Leaderboard</a>
              </div>
                    </div>
                  
                    </div>
                </div>
                
              

            </div>
        </div>
    </nav>

    <div class="container" id="main-box">

    <div class="panel panel-default">
    <div class="panel-body">
    <div  class = "col-md-offset-2 col-md-8">
    	@if(isset($error))
    		{!! $error !!}
    	@endif
    	<form role="form" class="form-horizontal" method="post">
			{{ csrf_field() }}
			<div class="form-group">
	            <label for="name" class="col-lg-3 control-label">Pragyan Email ID</label>
	            <div class="col-lg-7">
	                <input type="email" class="form-control" id="email" name="email" placeholder="Pragyan Email ID" required>
	            </div>
	        </div>
			<div class="form-group">
	            <label for="password" class="col-lg-3 control-label">Pragyan Password</label>
	            <div class="col-lg-7">
	                <input type="password" class="form-control" id="password" name="password" placeholder="Pragyan Password" required>
	            </div>
	        </div>
			<input class="col-md-offset-3 btn btn-yellow" type="submit" value="Submit">

		</form>
	<div class="col-md-offset-3">Register at <a href="http://prgy.in/mdecoder">prgy.in/mdecoder</a></div>
	</div>
		
	</div>
    </div>

    </div>


</body>