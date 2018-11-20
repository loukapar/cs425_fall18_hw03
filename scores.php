<!DOCTYPE html>
<html>
	<head>
		<title> High Scores </title>
		<meta name="author" content="Paraskevas Louka">
		<meta name="description" content="QuizGame - full score table of all players ever played">
		<meta name="keywords" content="scores, quiz, game, nickname">
		<link rel="icon" href="resources/favicon.png">
		<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="quizstyle.css">
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
	
	<?php
		$json = file_get_contents('./scores-file.json');
		$json_data = json_decode($json, true);
		$style = "height: 100% !important;";
		$footerstyle = "footer altfooter";
		if (sizeof($json_data) > 5) {
			$style = "height: auto !important;";
			$footerstyle = "footer";
		}
	?>
	
	<body class="font-style" style="<?php echo $style;?>">
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
						<a class="nav-link" href="help.php">Help</a>
					</li>
					<li class="nav-item">
						<a class="nav-link nav-active" href="scores.php">High Scores</a>
					</li>    
				</ul>
			</div>  
		</nav>
		
		<a href="#top" class="fas fa-arrow-up"></a>
		
		<div id="scoreTableContainer" class="container">
			<table class="table">
				<p id="rankingTableName">Ranking</p>
				<thead><tr><th>Position</th> <th> Nickname </th> <th> Score </th> </tr></thead>
				<tbody>
				<?php
					$json = file_get_contents('./scores-file.json');
					$json_data = json_decode($json, true);
					if (sizeof($json_data) > 0) {
						$scores = array();
						foreach ($json_data as $key => $row){
							$scores[$key] = $row['score'];
						}
						array_multisort($scores, SORT_DESC, $json_data);
						
						for ($i = 0; $i < sizeof($json_data); $i++){
							print "<tr>";
							print "<td>" . ($i + 1) . "</td>";
							print "<td>" . $json_data[$i]['nickname'] . "</td>";
							print "<td>" . $json_data[$i]['score'] . "</td>";
							print "</tr>";
						}
					}
				?>
				</tbody>
			</table>
		</div>
		<div class="<?php echo $footerstyle?>">
			<hr>
			<p class="category-name " id="footer-text"> Find us on </p>
			<a href="https://www.facebook.com" target="_blank" class="fab fa-facebook social-media"></a>
			<a href="https://www.twitter.com" target="_blank" class="fab fa-twitter social-media"></a>
			<a href="https://instagram.com" target="_blank" class="fab fa-instagram social-media"></a>
		</div>
	</body>
</html>