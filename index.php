<?php 

$msg = "";
if(isset($_GET['msg'])){
	$msg = $_GET['msg'];
	$msg = strip_tags($msg);
	$msg = addslashes($msg);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Jogo das Coisas</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
function startQuiz(url){
	window.location = url;
}
</script>
</head>
<body>
    <div class="content" style="width:700px;margin-left:auto;margin-right:auto;text-align:center;">
        <p style="color:#06F;"><?php echo $msg; ?></p>
        <h3>Jogo das Coisas</h3>
        <button class="btn btn-primary" onClick="startQuiz('jogo.php?question=1')">Jogar</button>
        <input type="button" class="btn btn-warning" value="Cadastrar Perguntas" onclick="javascript: location.href='adicionarQuestao.php';">
        <input type="button" class="btn btn-info" value="Lista de Participantes" onclick="javascript: location.href='listaParticipantes.php';">
    </div>
</body>
</html>