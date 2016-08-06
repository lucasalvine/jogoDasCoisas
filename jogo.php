<?php

session_start();
if(isset($_GET['question'])){
	$question = preg_replace('/[^0-9]/', "", $_GET['question']);
	$next = $question + 1;
	$prev = $question - 1;
	if(!isset($_SESSION['qid_array']) && $question != 1){
		$msg = "Desculpe, nao faca assim!";
		header("location: index.php?msg=$msg");
		exit();
	}
	if(isset($_SESSION['qid_array']) && in_array($question, $_SESSION['qid_array'])){
		$msg = "Desculpe, comece novamente";
		unset($_SESSION['answer_array']);
		unset($_SESSION['qid_array']);
		session_destroy();
		header("location: index.php?msg=$msg");
		exit();
	}
	if(isset($_SESSION['lastQuestion']) && $_SESSION['lastQuestion'] != $prev){
		$msg = "Desculpe, comece novamente";
		unset($_SESSION['answer_array']);
		unset($_SESSION['qid_array']);
		session_destroy();
		header("location: index.php?msg=$msg");
		exit();
	}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Cadastro Pergunta</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">
function getQuestion(){
	var hr = new XMLHttpRequest();
		hr.onreadystatechange = function(){
		if (hr.readyState==4 && hr.status==200){
			var response = hr.responseText.split("|");
			if(response[0] == "finished"){
				document.getElementById('status').innerHTML = response[1];
			}
			var nums = hr.responseText.split(",");
			document.getElementById('question').innerHTML = nums[0];
			document.getElementById('answers').innerHTML = nums[1];
			document.getElementById('answers').innerHTML += nums[2];
		}
	}
hr.open("GET", "questoes.php?question=" + <?php echo $question; ?>, true);
  hr.send();
}
function x() {
		var rads = document.getElementsByName("rads");
		for ( var i = 0; i < rads.length; i++ ) {
		if ( rads[i].checked ){
		var val = rads[i].value;
		return val;
		}
	}
}
function post_answer(){
	var p = new XMLHttpRequest();
			var id = document.getElementById('qid').value;
			var url = "respostaUsuario.php";
			var vars = "qid="+id+"&radio="+x();
			p.open("POST", url, true);
			p.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			p.onreadystatechange = function() {
		if(p.readyState == 4 && p.status == 200) {
			document.getElementById("status").innerHTML = '';
			alert("Obrigado! Sua reposta foi enviada"+ p.responseText);
			var url = 'jogo.php?question=<?php echo $next; ?>';
			window.location = url;
	}
}
p.send(vars);
document.getElementById("status").innerHTML = "processing...";
	
}
</script>
<script>
window.oncontextmenu = function(){
	return false;
}
</script>
</head>

<body onLoad="getQuestion()">
<div class="content" id="status">
<div class="content" id="counter_status"></div>
<div class="content" id="question"></div>
<div class="content" id="answers"></div>
</div>
</body>
</html>