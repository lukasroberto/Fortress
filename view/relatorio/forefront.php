		<?php
		
		ini_set('display_errors', 1);
		ini_set('log_errors', 1);
		ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
		error_reporting(E_ALL);
		
		session_start();
		if($_SESSION["idusuario"]==NULL){
		header('Location: ../login/login.php?acao=5&tipo=2');
		}
		
		require_once("../../controller/forefront.controller.class.php");
		
		include_once("../../functions/functions.class.php");
		
		$functions	= new Functions;
		
		$filtro  = (isset($_POST['filtro']) )? $_POST['filtro']:'';
		$coluna  = (isset($_POST['coluna']) )? $_POST['coluna']:'';
		
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		
		<!-- Estilos -->
		<link href="../../css/bootstrap.css" rel="stylesheet">
		<link href="../../css/geral.css" rel="stylesheet">
		<link href="../../css/validation.css" rel="stylesheet">
		<link rel="stylesheet" href="../../css/jquery-ui.css" />					
		</head>
		
		<body>
		<?php include_once("../../view/menu/menu.php");?>
		<div class="container"> 
		
		<!-- Título -->
		<blockquote>
		<h2>Visualizar Sites Acessados.</h2>
		<small>Utilize os campos abaixo para filtrar o relatório.</small> </blockquote>
				
		<!-- Mensagem de Retorno -->
		<?php
		if(!empty($_GET["tipo"])){
		$functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
		}
		?>
		
		
		<form class="form-inline" id="contact-form" action="#" method="post" enctype="multipart/form-data">
		<div class="form-group">
		<select class="form-control" name="coluna">
		<option value="ip" <?php echo (isset($coluna) && $coluna == 'ip') ? 'Selected' : ''; ?>>Ip Computador</option>
		<option value="referredserver" <?php echo (isset($coluna) && $coluna == 'referredserver') ? 'Selected' : ''; ?>>Site Acessado</option>
		<option value="uri" <?php echo (isset($coluna) && $coluna == 'uri') ? 'Selected' : ''; ?>>Pagina Acessada</option>
		<option value="regra" <?php echo (isset($coluna) && $coluna == 'regra') ? 'Selected' : ''; ?>>Regra Aplicada</option>
		</select>
		<input class="form-control" placeholder="Filtrar" type="text" name="filtro" id="filtro" required value="<?php echo ($filtro) ? : $filtro; ?>">
		</div>
		<input type="submit" class="btn btn-warning btn-large" value="Buscar" name="submit">
		</form>
		<?php
		$forefront	= new ForefrontController;
		if(isset($_POST['submit'])) {
		$registros 	= $forefront->listObjectsGroup($coluna,$filtro);
		}else{
		$registros 	= $forefront->listObjectsGroup();
		}
		if($registros){
		?>
		<!-- Lista -->
		<table id="tabela" class="tablesorter table table-hover table-striped">
		<thead>
		<tr>
		<th class="iconorder">IP Computador</th>
		<th class="iconorder">Nome Computador</th>
		<th class="iconorder">Data</th>
		<th class="iconorder">Site Acessado</th>
		<th class="iconorder">Pagina Acessada</th>
		<th class="iconorder">Regra Aplicada</th>
		
		</tr>
		</thead>
		<tbody>
		<?php
		while($reg = sqlsrv_fetch_array($registros)){
		?>
		<tr>
		<td><?php echo $reg["clientIP"]; ?></td>
		<td><?php echo $reg["ClientUserName"]; ?></td>
		<td><?php echo $reg["logTime"]; ?></td>
		<td><?php echo $reg["referredserver"]; ?></td>
		<td><?php echo $reg["uri"]; ?></td>
		<td><?php echo $reg["rule"]; ?></td>

		</tr>
		<?php
		}
		?>
		</tbody>
		</table>
		
		<?php
		}else{
		?>
		<div class="text-center">
		<h2>Opsss!!!</h2>
		<p>Sua pesquisa não retornou nenhum resultado válido.</p>
		</div>
		<?php
		}
		?>
		<?php include_once("../../view/footer/footer.php");?>
		</div>
		<!-- /container --> 
		
		<script src="../../js/jquery.validate.min.js"></script> 
		<script src="../../js/bootstrap.min.js"></script> 
		<script src="../../js/jquery-ui.js"></script>
		<script src="../../js/jquery.tablesorter.js"></script>
		
		<!-- Organiza tabela de acordo com a cloluna clicada -->
		<script type="text/javascript">
		$(document).ready(function() { 
		$("#tabela").tablesorter()
		});
		</script>
		</body>
		</html>