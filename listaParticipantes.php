<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
$host = "127.0.0.1";
$db   = "teste";
$user = "root";
$pass = "123456";

$con = mysql_pconnect($host, $user, $pass) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_select_db($db, $con);

$query = sprintf("SELECT username, percentage, date_time FROM quiz_takers");

$dados = mysql_query($query, $con) or die(mysql_error());

$linha = mysql_fetch_assoc($dados);

$total = mysql_num_rows($dados);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Lista de Participantes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Resultado dos participantes</h2>
  <table class="table table-hover">
	<thead>
	  <tr>
		<th>Nome</th>
		<th>Porcentagem de Acertos(%)</th>
		<th>Hora de Realizacao do Teste</th>
	  </tr>
	</thead>   
<?php

	if($total > 0) {

		do {
?>
			<tbody>
				<tr>
					<td><?=$linha['username']?></td>
					<td><?=$linha['percentage']?></td>
					<td><?=$linha['date_time']?></td>
			  	</tr>
			</tbody>
<?php
		
		}while($linha = mysql_fetch_assoc($dados));
	
	}
?>
</table>
</div>
<div style="width:700px;margin-left:auto;margin-right:auto;text-align:center;">
	<a href='index.php' class="btn btn-danger">Voltar</a>
</div>
</body>
</html>
<?php
mysql_free_result($dados);
?>