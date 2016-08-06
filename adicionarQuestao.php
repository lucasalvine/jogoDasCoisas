<?php

if(isset($_POST['desc'])){
	if(!isset($_POST['iscorrect']) || $_POST['iscorrect'] == ""){
		echo "Sorry, important data to submit your question is missing. Please press back in your browser and try again and make sure you select a correct answer for the question.";
		exit();
	}
	if(!isset($_POST['type']) || $_POST['type'] == ""){
		echo "Sorry, there was an error parsing the form. Please press back in your browser and try again";
		exit();
	}
	require_once("scripts/conexao.php");
	$question = $_POST['desc'];
	$answer1 = $_POST['answer1'];
	$answer2 = $_POST['answer2'];

	$type = $_POST['type'];
	
	$type = preg_replace('/[^a-z]/', "", $type);
	$isCorrect = preg_replace('/[^0-9a-z]/', "", $_POST['iscorrect']);
	$answer1 = strip_tags($answer1);
	$answer1 = mysql_real_escape_string($answer1);
	$answer2 = strip_tags($answer2);
	$answer2 = mysql_real_escape_string($answer2);
	
	$question = strip_tags($question);
	$question = mysql_real_escape_string($question);
	if($type == 'tf'){
	if((!$question) || (!$answer1) || (!$answer2) || (!$isCorrect)){
		echo "Desculpe, algo deu errado. Por favor, atualize a pagina para continuar.";
		exit();
		}
	}

	$sql = mysql_query("INSERT INTO questions (question, type) VALUES ('$question', '$type')")or die(mysql_error());
		$lastId = mysql_insert_id();
		mysql_query("UPDATE questions SET question_id='$lastId' WHERE id='$lastId' LIMIT 1")or die(mysql_error());
	//// Update answers based on which is correct //////////
	if($type == 'tf'){
		if($isCorrect == "answer1"){
		$sql2 = mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer1', '1')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer2', '0')")or die(mysql_error());
		$msg = 'Obrigado, sua pergunta foi adicionada';
	  header('location: adicionarQuestao.php?msg='.$msg.'');
	exit();
	}
	if($isCorrect == "answer2"){
		$sql2 = mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer2', '1')")or die(mysql_error());
		mysql_query("INSERT INTO answers (question_id, answer, correct) VALUES ('$lastId', '$answer1', '0')")or die(mysql_error());
		$msg = 'Obrigado, sua pergunta foi adicionada';
	  header('location: adicionarQuestao.php?msg='.$msg.'');
	exit();
		}	
	}
}
?>
<?php 
$msg = "";
if(isset($_GET['msg'])){
	$msg = $_GET['msg'];
}
?>
<?php 
if(isset($_POST['reset']) && $_POST['reset'] != ""){
	$reset = preg_replace('/^[a-z]/', "", $_POST['reset']);
	require_once("scripts/conexao.php");
	mysql_query("SET FOREIGN_KEY_CHECKS=0");
	mysql_query("TRUNCATE TABLE questions")or die(mysql_error());
	mysql_query("TRUNCATE TABLE answers")or die(mysql_error());
	$sql1 = mysql_query("SELECT id FROM questions LIMIT 1")or die(mysql_error());
	$sql2 = mysql_query("SELECT id FROM answers LIMIT 1")or die(mysql_error());
	$numQuestions = mysql_num_rows($sql1);
	$numAnswers = mysql_num_rows($sql2);
	if($numQuestions > 0 || $numAnswers > 0){
		echo "Desculpe, estamos com problemas. Tente mais tarde.";
		exit();
	}else{
		echo "Obrigado, agora temos 0 perguntas.";
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
<script>
function showDiv(el1,el2){
	document.getElementById(el1).style.display = 'block';
	document.getElementById(el2).style.display = 'none';
}
</script>
<script>
function resetQuiz(){
	var x = new XMLHttpRequest();
			var url = "adicionarQuestao.php";
			var vars = 'reset=yes';
			x.open("POST", url, true);
			x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			x.onreadystatechange = function() {
		if(x.readyState == 4 && x.status == 200) {
			document.getElementById("resetBtn").innerHTML = x.responseText;
			
	}
}
x.send(vars);
document.getElementById("resetBtn").innerHTML = "processing...";
	
}
</script>
<style type="text/css">
.content{
	margin-top:48px;
	margin-left:auto;
	margin-right:auto;
	width:780px;
	border:#333 1px solid;
	border-radius:12px;
	-moz-border-radius:12px;
	padding:12px;
	display:none;
}
</style>
</head>

<body>
   <div style="width:700px;margin-left:auto;margin-right:auto;text-align:center;">
   <p style="color:#06F;"><?php echo $msg; ?></p>
	<h2>Que tipo de pergunta vamos criar?</h2>
    <button class="btn btn-primary" onClick="showDiv('tf', 'mc')">Verdadeiro/Falso</button>&nbsp;&nbsp;
    <span id="resetBtn">
    <button class="btn btn-waring" onclick="resetQuiz()">Novo Questionario</button></span>
    <br /><br /><a href='index.php' class="btn btn-primary">Jogar</a>
   </div>
  <div class="content" id="tf">
  	<h3>Verdadeiro ou Falso</h3>
    	<form action="adicionarQuestao.php" name="addQuestion" method="post">
    <strong>Digite a pergunta:</strong>
    	<br />
    		<textarea class="form-control" id="tfDesc" name="desc" rows="5"></textarea>
    	  <br />
    	<br />
    	<strong>Qual resposta correta?</strong>
    	<br />
            <input type="text" id="answer1" name="answer1" value="Verdadeiro" readonly>&nbsp;
              <label style="cursor:pointer; color:#06F;">
            <input type="radio" name="iscorrect" value="answer1">Resposta certa.</label>
    	  <br />
   		<br />
            <input type="text" id="answer2" name="answer2" value="Falso" readonly>&nbsp;
              <label style="cursor:pointer; color:#06F;">
              <input type="radio" name="iscorrect" value="answer2">Resposta certa.
            </label>
    	  <br />
    	<br />
    	<input type="hidden" value="tf" name="type">
    	<input class="btn btn-primary"  type="submit" value="Confimar resposta correta.">
    </form>
 </div>
</body>
</html>