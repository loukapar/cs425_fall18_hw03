<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title> Quiz Game </title>
		<meta name="author" content="Paraskevas Louka">
		<meta name="description" content="Quiz game with General Knowledge questions. Questions are devided in three categories. Easy, Medium and Hard. Go play that game!">
		<meta name="keywords" content="Quiz, Game, questions, general knowledge, technology, easy, medium, hard">
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
	
	<body class="font-style">
		<nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
			<a class="navbar-brand" href="index.php">QuizGame</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link nav-active" href="index.php">Home Page</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="help.php">Help</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="scores.php">High Scores</a>
					</li>    
				</ul>
			</div>  
		</nav>
		
		<a href="#top" class="fas fa-arrow-up"></a>
		
		<?php
			function getPoints($level) {
				$points = 0;
				switch ($level) {
					case "easy":
						$points = 1;
						break;
					case "medium":
						$points = 2;
						break;
					case "hard":
						$points = 3;
						break;
				}
				return $points;
			}
			$onSave = false;
			$method_post = false;
			$onGame = false;
			$onNext = false;
			$onEnd = false;
			$onFinish = false;
			if (isset($_GET['play'])) {
				$onSave = false;
				$onGame = true;
				$onNext = false;
				$onEnd = false;
				$onFinish = false;
				$_SESSION['saved'] = false;
				$method_post = true;
				$questionsNo = 0;
				$arrayQ = array();
				$get = file_get_contents('resources/questions.xml');
				$arr = simplexml_load_string($get);
				$_SESSION['arrayQ'] = $arrayQ;
				$_SESSION['Questions'] = $arr->asXML();
				
				$_SESSION['QuestionNo'] = $questionsNo;
				//print ($arr->easy->item[0]->answer[0][correct]);
			}
			
			if (isset($_POST['next']) || isset($_POST['finish'])) {
				
				if (isset($_POST['next'])) {
					$onSave = false;
					$onGame = true;
					$onNext = true;
					$onEnd = false;
					$onFinish = false;
					$method_post = true;
				}
				
				if (isset($_POST['finish'])) {
					$onSave = false;
					$onFinish = true;
					$onGame = false;
					$onEnd = false;
					$onNext = false;
					$method_post = true;
				}
				
				$q = array();
				$q['correct'] = $_POST['correct'];
				$q['level'] = $_POST['level'];
				if (isset($_POST['answers']))
					$q['answer'] = $_POST['answers'];
				else 
					$q['answer'] = -1;
				
				$_SESSION['arrayQ'][$_SESSION['QuestionNo'] - 1] = $q;
			}
			
			if (isset($_POST['save']) && $_SESSION['saved'] == false) {
				$onSave = true;
				$onFinish = true;
				$onGame = false;
				$onEnd = false;
				$onNext = false;
				$method_post = false;
			
				$json = file_get_contents('scores-file.json');
				$json_data = json_decode($json, true);
				
				
								
				$arrayQ = array();
				$arrayQ = $_SESSION['arrayQ'];
				$userScore = array();
				if (!empty($_POST['nickname']))
					$userScore['nickname'] = $_POST['nickname'];
				else
					$userScore['nickname'] = "Player" . sizeof($json_data);
				$points = 0;
				for ($i = 0; $i < 5; $i++) 
					if ($arrayQ[$i]['correct'] == $arrayQ[$i]['answer']){
							$points += getPoints($arrayQ[$i]['level']);
					}
				$userScore['score'] = $points;
				
				if (empty($json_data)) {
					$json_data[0] = $userScore;
				} else {
					array_push($json_data,$userScore);
				}
				$jsondata = json_encode($json_data, JSON_PRETTY_PRINT);
				if(file_put_contents("scores-file.json", $jsondata)) {
					print "<div class=\"alert alert-success alert-dismissible\" data-auto-dismiss role=\"alert\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
					<strong>Success!</strong> Your Score has been saved " . $userScore['nickname'] . ".</div>";
				} else {
					print "<div class=\"alert alert-danger alert-dismissible\" data-auto-dismiss role=\"alert\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
					<strong>Error!</strong> Something went wrong. Your score has not been saved.</div>";
				}
				$_SESSION['saved'] = true;
				print "<meta http-equiv=\"refresh\" content=\"1.5;url=index.php\"/>";
			}
			

			
			if (isset($_POST['end'])) {
				$onSave = false;
				$onEnd = true;
				$onGame = false;
				$onNext = false;
				$onFinish = false;
				$method_post = false;
				//echo "END GAME";
			}
			
			$method = "";
			if ($method_post == true){
				$method = "post";
			} else {
				$method = "get";
			}
				
			if ($onFinish == true)
				$containerclass = "container finishcontainer";
			else
				$containerclass = "container";
		?>
		<div class="<?php echo $containerclass;?>">
			<?php
				if ((($onGame == false && $onEnd == false && $onFinish == false) || $onEnd == true) && $onSave == false) {
					print "<br>";
				} else if (($onGame == true || $onNext == true) && $onSave == false) {
					print "<p id=\"numberofquestions\">Question " . ($_SESSION['QuestionNo']+1) . " out of 5 </p>";
				}
				
				$formclass = "";
				if (($onFinish == true)){
					$formclass = "onFinishForm";
				}
			?>
			<form class="container <?php echo $formclass?>" action="index.php" method="<?php echo $method;?>">
				<?php
					if ((($onGame == false && $onEnd == false && $onFinish == false) || $onEnd == true) && $onSave == false) {
						print "<div class=\"welcomeContainer\">";
						print "<p> Welcome, press Play Now to start the Quiz</p>";
						print "<input class=\"btn btn-success btn-lg\" type=\"submit\" name=\"play\" value=\"Play Now\">";
						print "</div>";
					} else if (($onGame == true || $onNext == true) && $onSave == false){
						$currentQ = array();
						if (isset($_SESSION['Questions'])){
							$data = new SimpleXMLElement($_SESSION['Questions']);
							if ($_SESSION['QuestionNo'] == 0) {
								$questionsRange = sizeof($data->medium->item);
								$found = false;
								while ($found == false){
									$rand = rand(0, $questionsRange - 1);
									if ($data->medium->item[$rand]->asked == "false"){
										$currentQ['question'] = $data->medium->item[$rand]->question;
										$currentQ['level'] = "medium";
										$currentQ['correct'] = $data->medium->item[$rand]->correct;
										$currentQ['ans1'] = $data->medium->item[$rand]->answer[0];
										$currentQ['ans2'] = $data->medium->item[$rand]->answer[1];
										$currentQ['ans3'] = $data->medium->item[$rand]->answer[2];
										$currentQ['ans4'] = $data->medium->item[$rand]->answer[3];
										$data->medium->item[$rand]->asked = "true";
										$found = true;
									}
								}
							} else {
								$nextLevel = "medium";
								$arrayQ = array();
								$arrayQ = $_SESSION['arrayQ'];
								$position = $_SESSION['QuestionNo'] - 1;
								if ($arrayQ[$position]['correct'] == $arrayQ[$position]['answer']){
									switch ($arrayQ[$position]['level']) {
										case "easy":
											$nextLevel = "medium";
											break;
										case "medium":
											$nextLevel = "hard";
											break;
										case "hard":
											$nextLevel = "hard";
											break;
									}
								} else {
									switch ($arrayQ[$position]['level']) {
										case "easy":
											$nextLevel = "easy";
											break;
										case "medium":
											$nextLevel = "easy";
											break;
										case "hard":
											$nextLevel = "medium";
											break;
									}
								}
								$questionsRange = sizeof($data->$nextLevel->item);
								$found = false;
								while ($found == false){
									$rand = rand(0, $questionsRange - 1);
									if ($data->$nextLevel->item[$rand]->asked == "false"){
										$currentQ['question'] = $data->$nextLevel->item[$rand]->question;
										$currentQ['level'] = $nextLevel;
										$currentQ['correct'] = $data->$nextLevel->item[$rand]->correct;
										$currentQ['ans1'] = $data->$nextLevel->item[$rand]->answer[0];
										$currentQ['ans2'] = $data->$nextLevel->item[$rand]->answer[1];
										$currentQ['ans3'] = $data->$nextLevel->item[$rand]->answer[2];
										$currentQ['ans4'] = $data->$nextLevel->item[$rand]->answer[3];
										$data->$nextLevel->item[$rand]->asked = "true";
										$found = true;
									}
								}
								
							}
							$_SESSION['Questions'] = $data->asXML();
							$_SESSION['QuestionNo']++;
						}
						print "<p id=\"question\">" . $currentQ['question'] . "</p>";
						print "<input type=\"hidden\" name=\"level\" value=" . $currentQ['level'] . ">";
						print "<input type=\"hidden\" name=\"correct\" value=" . $currentQ['correct'] . ">";
						
						print "<div><input id=\"ch1\" type=\"radio\" name=\"answers\" value=\"0\"><label class=\"choice\" for=\"ch1\">". $currentQ['ans1'] ."</label><br></div>";
						print "<div><input id=\"ch2\" type=\"radio\" name=\"answers\" value=\"1\"><label class=\"choice\" for=\"ch2\">". $currentQ['ans2'] ."</label><br></div>";
						print "<div><input id=\"ch3\" type=\"radio\" name=\"answers\" value=\"2\"><label class=\"choice\" for=\"ch3\">". $currentQ['ans3'] ."</label><br></div>";
						print "<div><input id=\"ch4\" type=\"radio\" name=\"answers\" value=\"3\"><label class=\"choice\" for=\"ch4\">". $currentQ['ans4'] ."</label><br></div>";
						
						print "<div id=\"onGamebtn\">";
						if ($_SESSION['QuestionNo'] < 5)
							print "<input class=\"btn btn-success\" type=\"submit\" name=\"next\" value=\"Next\">";
						else 
							print "<input class=\"btn btn-success\" type=\"submit\" name=\"finish\" value=\"Finish\">";
						print "<input class=\"btn btn-success\" type=\"submit\" name=\"end\" value=\"End Game\">";
						print "</div>";
					} else if ($onFinish == true || $onSave == true) {
						$totalP = 0;
						$arrayQ = array();
						$arrayQ = $_SESSION['arrayQ'];
						//print score in table
						print "<div class=\"tablecontainer\"><p id=\"tableTitle\">Game Score</p>";
						print "<table class=\"table\">";
						print "<thead><tr> <th> Question </th> <th> Level </th> <th> Score </th> </tr></thead>";
						print "<tbody>";
						for ($i = 0; $i < 5; $i++){
							if ($arrayQ[$i]['correct'] == $arrayQ[$i]['answer']){
								$totalP += getPoints($arrayQ[$i]['level']);
								print "<tr>";
								print "<td>" . ($i + 1) . "<i style=\"color: green; margin-left: 3%;\" class=\"fas fa-check\"></i></td>";  
								print "<td>" . $arrayQ[$i]['level'] . "</td>";
								print "<td>" . getPoints($arrayQ[$i]['level']) . "</td>";
								print "</tr>";
								//print "<p class=\"correct\">Question " . ($i + 1) . " - " . $arrayQ[$i]['level'] . " level </p>";
							} else {
								print "<tr>";
								print "<td>" . ($i + 1) . "<i style=\"color: red; margin-left: 3%\" class=\"fas fa-times\"></i></td>";  
								print "<td>" . $arrayQ[$i]['level'] . "</td>";
								print "<td>0</td>";
								print "</tr>";
								//print "<p class=\"incorrect\">Question " . ($i + 1) . " - " . $arrayQ[$i]['level'] . " level </p>";
							}
						}
						print "</tbody></table></div>";
			
						$json = file_get_contents('scores-file.json');
						$json_data = json_decode($json, true);
						
						print "<div class=\"scoreBtms\">";
						print "<p id=\"totalScore\">Total Score " . $totalP . " points. <br> Would you like to save this score?</p>";
						
						print "<div class=\"elements\"><input class=\"nickname-input form-control\" type=\"text\" name=\"nickname\" placeholder=\"Nickname ex.Player" . sizeof($json_data) . "\">";
						
						print "<input class=\"btn btn-success\" type=\"submit\" name=\"save\" value=\"Save Score\">";
						print "<input class=\"btn btn-success\" id=\"playagainbtn\" type=\"submit\" name=\"playagain\" value=\"Play Again\"></div>";

						print "</div>";
						
					} 
					?>
			</form>
		</div>
		
		<?php
			$footerclass = "footer";
			if ($onFinish == false)
				$footerclass = "footer altfooter";
				
		?>
		
		<div class="<?php print $footerclass?>">
				<hr>
				<p class="category-name " id="footer-text"> Find us on </p>
				<a href="https://www.facebook.com" target="_blank" class="fab fa-facebook social-media"></a>
				<a href="https://www.twitter.com" target="_blank" class="fab fa-twitter social-media"></a>
				<a href="https://instagram.com" target="_blank" class="fab fa-instagram social-media"></a>
		</div>
		
	</body>
</html>