<?php 
session_start();
require_once("scripts/conexao.php");
$arrCount = "";
if(isset($_GET['question'])){
	$question = preg_replace('/[^0-9]/', "", $_GET['question']);
	$output = "";
	$answers = "";
	$q = "";
	$sql = mysql_query("SELECT id FROM questions");
	$numQuestions = mysql_num_rows($sql);
	if(!isset($_SESSION['answer_array']) || $_SESSION['answer_array'] < 1){
		$currQuestion = "1";
	}else{
		$arrCount = count($_SESSION['answer_array']);
	}
	
	if($numQuestions == 0){	

		echo '
		<form action="adicionarQuestao.php" method="">
		<br /><input type="submit" value="Cadastrar Perguntas"/>
		</form>';
		exit();

	}

	if($arrCount > $numQuestions){
		unset($_SESSION['answer_array']);
		header("location: index.php");
		exit();
	}
	if($arrCount >= $numQuestions){
		echo 'finished|<h2>Nao temos mais perguntas</h2>
				<p>Digite o nome do participante.</p>
				<form action="respostaUsuario.php" method="post">
				<input type="hidden" name="complete" value="true">
				<input type="text" name="username">
				<input type="submit" value="Terminar">
				</form>';
		exit();
	}

	$singleSQL = mysql_query("SELECT * FROM questions WHERE id='$question' LIMIT 1");
		while($row = mysql_fetch_array($singleSQL)){
			$id = $row['id'];
			$thisQuestion = $row['question'];
			$type = $row['type'];
			$question_id = $row['question_id'];
			$q = '<h2>'.$thisQuestion.'</h2>';
			$sql2 = mysql_query("SELECT * FROM answers WHERE question_id='$question' ORDER BY rand()");
			while($row2 = mysql_fetch_array($sql2)){
				$answer = $row2['answer'];
				$correct = $row2['correct'];
				$answers .= '<label style="cursor:pointer;"><input type="radio" name="rads" value="'.$correct.'">'.$answer.'</label> 
				<input type="hidden" id="qid" value="'.$id.'" name="qid"><br /><br />
				';
				
			}
			$output = ''.$q.','.$answers.',<span id="btnSpan"><button onclick="post_answer()">Enviar</button></span>';
			echo $output;
		   }
		}
	

?>