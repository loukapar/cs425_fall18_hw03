<!DOCTYPE html>
<html>
	<head>
		<title> Help </title>
		<meta name="author" content="Paraskevas Louka">
		<meta name="description" content="Information and instructions on how to play QuizGame and see scores">
		<meta name="keywords" content="help, instructions, how to">
		<link rel="icon" href="resources/favicon.png">
		<link rel="stylesheet" type="text/css" href="quizstyle.css">
		<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns"
        crossorigin="anonymous">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
	
	</head>
	
	<body class="font-style">
		<nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
			<a class="navbar-brand" href="index.php">QuizGame</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="index.php">Home Page</a>
					</li>
					<li class="nav-item">
						<a class="nav-link nav-active" href="help.php">Help</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="scores.php">High Scores</a>
					</li>    
				</ul>
			</div>  
		</nav>
		
		<a href="#top" class="fas fa-arrow-up"></a>
		
		<div class="container-fluid info">
			<p class="help_header"> Help Page </p>
					<p class="help_subheader"> Main Page - Game </p>
					<p style="font-size: 1.1em;"> Main Page is the landing page of the game where, if you
					wish to play the game you have to press "Play Now".  After that the quiz starts and the
					first question is shown.  You read the question, choose an answer and then press Next.
					If you dont choose any answer then the game mark the question as incorrect.  Also you can
					end the game at any time by pressing the button End Game.  As you play the game, you can see
					at the top of the page the current question number and how many questions are left.  Once you reach the
					5th question and you answer it then you have to push the button Finish in order to display your scores
					for each question and the total score of your game.  After that you can choose to save your score to a 
					nickname that you enter (default is Player) or to play again.  At the bottom of every page you can see
					the social media of our game where you can find us at any time!  Enjoy :)</p>
					<p class="help_subheader"> High Scores Page </p>
					<p style="font-size: 1.1em;">High Score page contains all the scores for all players of the game. There you can see your score 
					every game based on the nickname that you gave on the save process. Go and get first on that rank ;)</p>
		</div>
	</body>
</html>