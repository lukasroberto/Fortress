					<?php
					
					ini_set('display_errors', 1);
					ini_set('log_errors', 1);
					ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
					error_reporting(E_ALL);
					
					session_start();
					if($_SESSION["idusuario"]==NULL){
					header('Location: ../login/login.php?acao=5&tipo=2');
					}
					
					require_once("../../controller/chip.controller.class.php");
					require_once("../../model/chip.class.php");
					
					include_once("../../functions/functions.class.php");
					
					$chip	= new ChipController;
					$functions	= new Functions;
					
					$filtro  = (isset($_POST['filtro']) )? $_POST['filtro']:'';
					$coluna  = (isset($_POST['coluna']) )? $_POST['coluna']:'';
			
					
					if(isset($_POST['submit'])) {
					
					$registros 	= $chip->listObjectsGroup($coluna,$filtro);
					
					}else{
					$registros 	= $chip->listObjectsGroup($coluna,$filtro);
					}
										
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
					<h2>Gerenciar Chips</h2>
					<small>Utilize os campos abaixo para gerenciar os Chips.</small> </blockquote>
					
					<!-- Mensagem de Retorno -->
					<?php
					if(!empty($_GET["tipo"])){
					$functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
					}
					?>
					

					<form class="navbar-form navbar-left" id="contact-form" action="#" method="post" enctype="multipart/form-data">
					<div class="form-group">
					<select class="form-control" name="coluna">
					<option value="chip_imei" <?php echo (isset($coluna) && $coluna == 'chip_imei') ? 'Selected' : ''; ?>>Imei</option>
					<option value="chip_operadora" <?php echo (isset($coluna) && $coluna == 'chip_operadora') ? 'Selected' : ''; ?>>Operadora</option>
					<option value="chip_data_envio" <?php echo (isset($coluna) && $coluna == 'chip_data_envio') ? 'Selected' : ''; ?>>Data de Envio</option>
					<option value="cli_codigo" <?php echo (isset($coluna) && $coluna == 'cli_codigo') ? 'Selected' : ''; ?>>Cliente</option>
					<option value="chip_status" <?php echo (isset($coluna) && $coluna == 'chip_status') ? 'Selected' : ''; ?>>Status</option>
					</select>
					<input class="form-control" placeholder="Filtrar Chips" type="text" name="filtro" id="filtro" required value="<?php echo ($filtro) ? : $filtro; ?>">
					</div>
					<input type="submit" class="btn btn-warning btn-large" value="Buscar" name="submit">
					<a href="edita.php" class="btn btn-primary btn-large">Cadastrar um novo Chip</a>
					</form>
					<?php
					if($registros){
					?>
					<!-- Lista -->
					<table id="tabela" class="tablesorter table table-hover table-striped">
					<thead>
					<tr>
					<th class="iconorder">Código</th>
					<th class="iconorder">Imei</th>
					<th class="iconorder">Operadora</th>
					<th class="iconorder">Data de Envio</th>
					<th class="iconorder">Cliente</th>
					<th class="iconorder">Status</th>
					<th style="text-align:center"><i class="glyphicon glyphicon-pencil"></i></th>

					</tr>
					</thead>
					<tbody>
					<?php
					while($reg = sqlsrv_fetch_array($registros)){
						($reg["chip_status"] == 1 ? $status = "Ativo" and $class='success' : '');
						($reg["chip_status"] == 2 ? $status = "Estoque" and $class='info' : '');
						($reg["chip_status"] == 3 ? $status = "Cancelado" and $class='danger' : '');
						($reg["chip_status"] == 4 ? $status = "Cancelar" and $class='warning' : '');

						($reg["chip_operadora"] == 'CLARO' ? $icone = '<img border="0" src="../../img/claro.png">' : '');
						($reg["chip_operadora"] == 'VIVO' ? $icone = '<img border="0" src="../../img/vivo.png">' : '');
						($reg["chip_operadora"] == 'TIM(DATORA)' ? $icone = '<img border="0" src="../../img/tim.png">' : '');
					?>
					<tr>
					<td><?php echo $reg["chip_codigo"]; ?></td>
					<td><?php echo $reg["chip_imei"]; ?></td>
					<td><?php echo $icone; ?></td>
					<td><?php echo $reg["chip_data_envio"]; ?></td>
					<td><?php echo $reg["cli_codigo"]; ?></td>
					<td class= "<?php echo $class ?>"><?php echo $status; ?></td>
					<td style="text-align:center"><a type="button" title="Editar" href="edita.php?operacao=update&chipcodigo=<?php echo $reg["chip_codigo"] ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
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
					
					<script type="text/javascript">
					$(document).ready(function() { 
					$("#tabela").tablesorter()
					});
					</script>
					</body>
					</html>