<!DOCTYPE html>
<html>

<head>

	<title>layout</title>
	<meta charset="utf-8">

  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="css/sticky-footer-navbar.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  	<link href='https://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
  	<style>
  body {
  /* Margin bottom by footer height */
   margin-bottom: 60px;
    background-image: url('css/leaderback.jpg');
    background-size: 50%;
    background-repeat: repeat;
  }
  #title{
      padding-left: 20px;
      font-family: Audiowide;
    }
  #scoreboard{
    margin-left: 5%;
    margin-right: 5%;
    background-color: #778899;
    border-radius: 20px;
    opacity: 0.89;
  }
  #heading{
    font-family: Audiowide;
  }
  td{
    padding: 2%;
  }

  #paginate{
    text-align: center;
  }

  .footer{
    font-family: Audiowide;
  }
  </style>
</head>

<body>

<nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ action('LoginController@index') }}">
                    <span><img src="logo.png" width="100px" height="55px"  style="margin-top:-20px;"></span>
					<span id="title">Mdecoder</span>
                </a>

            </div>
        </div>
</nav>

<div class="container" id="scoreboard">
  <h2><div id="heading">Leaderboard</div></h2>
  <p>MDecoder</p>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th><u>Rank</u></th>
        <th><u>Username</u></th>
        <th><u>Score</u></th>
      </tr>
    </thead>
    <tbody>
    @foreach($players as $player)
      <tr>
        <td>{{$player->rank}}</td>
        <td>{{$player->name}}</td>
        <td>{{$player->score}}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
	
	<div id="paginate">
	{!! $players->render() !!}	
	</div>

	<footer class="footer">
    <div class="container"> 
        <p class="text-muted" style="text-align:center">Maximus</p>
      </div>
    </footer>


</body>
</html>