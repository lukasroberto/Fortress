		<?php
		
		ini_set('display_errors', 1);
		ini_set('log_errors', 1);
		ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
		error_reporting(E_ALL);
		
		session_start();
		if($_SESSION["idusuario"]==NULL){
		header('Location: ../login/login.php?acao=5&tipo=2');
		}
		
		require_once("../../controller/relatorio.controller.class.php");
		require_once("../../model/cliente.class.php");
		include_once("../../functions/functions.class.php");

			ini_set('date.timezone', 'America/Sao_Paulo');
			$filtro  = (isset($_POST['filtro']) )? $_POST['filtro']:'';
			$coluna  = (isset($_POST['coluna']) )? $_POST['coluna']:'';

			$controller = new RelatorioController();

			if(isset($_POST['submit'])) {
				$registros 	= $controller->listaLogClientesSemComunicacao($coluna,$filtro);
			}else{
				$registros 	= $controller->listaLogClientesSemComunicacao("","");
			}

			$functions	= new Functions;		
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
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/geral.css" rel="stylesheet">
<link rel="stylesheet" href="../../css/jquery-ui.css" />
<link rel="stylesheet" href="../../css/datepicker.css" />
</head>
<body>
<?php include_once("../../view/menu/menu.php");?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <?php include_once("../../view/menu/menuRelatorio.php"); ?>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<!-- Título -->
		<blockquote>
		<h2>Histórico de Clientes sem Comunicação</h2>
		<small>Abaixo é exibido um histórico das falhas de comunicação dos clientes.</small> </blockquote>
				<!-- Mensagem de Retorno -->
		<?php
		if(!empty($_GET["tipo"])){
		$functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
		}
		?>
		
		<div class="row">
		<form class="navbar-form navbar-left" id="contact-form" action="#" method="post" enctype="multipart/form-data">
		<div class="form-group">
		<select class="form-control" name="coluna">
		<option value="com_cli_codigo" <?php echo (isset($coluna) && $coluna == 'com_cli_codigo') ? 'Selected' : ''; ?>>Código do Cliente</option>
		<option value="cli_nome" <?php echo (isset($coluna) && $coluna == 'cli_nome') ? 'Selected' : ''; ?>>Nome do Cliente</option>
		</select>
		<input class="form-control" placeholder="Filtrar por Cliente" type="text" name="filtro" id="filtro" value="<?php echo ($filtro) ? : $filtro; ?>">
		</div>
		<input type="submit" class="btn btn-warning btn-large" value="Buscar" name="submit">
		</form>
		</div>
			
		<?php
		if(sqlsrv_num_rows($registros)){
		?>
		<!-- Lista -->
		<table id="tabela" class="tablesorter table table-hover table-striped">
		<thead>
		<tr>
		<th class="iconorder">Código</th>
		<th class="iconorder">Cliente</th>
		<th class="iconorder">Ultima Comunicação</th>
		<th class="iconorder">ATNR Até</th>
		<th class="iconorder">Tempo Sem Comunicação</th>
		</tr>
		</thead>
		<tbody>

		<?php
        $conta = 0;
		while($reg = sqlsrv_fetch_array($registros)){
			$conta = $conta + 1;

		$inicio = $functions->converterData($reg["com_data_ultima_comunicacao"],"%d-%m-%Y %H:%M");
		$fim    = $functions->converterData($reg["com_data_atual"],"%d-%m-%Y %H:%M");	 

		// Converte as duas datas para um objeto DateTime do PHP
		$inicio = DateTime::createFromFormat('d-m-Y H:i', $inicio);
		$fim = DateTime::createFromFormat('d-m-Y H:i', $fim);
		 
		$diff = $inicio->diff($fim);

		//var_dump($diff); //Mostra todo o array

        $resultado = "{$diff->format('%m Meses')} ";
        $resultado .= "{$diff->format('%d Dias')} ";
        $resultado .= "{$diff->format('%h Horas')} ";
        $resultado .= "{$diff->format('%i Minutos')} ";


		?>
		<tr>
		<td><?php echo $reg["com_codigo"]; ?></td>
		<td><?php echo $reg["com_cli_codigo"]." - ". $reg["cli_nome"]; ?></td>
		<td><?php echo $reg["com_data_ultima_comunicacao"]; ?></td>
		<td><?php echo $reg["com_data_atual"]; ?></td>
		<td><?php echo $resultado; ?></td>
		</tr>
		<?php
		}
		?>
		</tbody>
		</table>
		<div class="row">
		<strong>Total de Registros: <?php echo $conta; ?></strong>
		</div>
		
		<?php

		}else{
		?>
		<div class="row">
		<div class="text-center">
		<h2>Opsss!!!</h2>
		<p>Sua pesquisa não retornou nenhum resultado válido.</p>
		</div>
		</div>
		<?php
		}
		?>

			  </div>
			</div>
		  </div>
		<!-- /container --> 
		
	<!-- Javascript -->
      <script src="../../js/jquery.validate.min.js"></script> 

      <script src="../../js/bootstrap.min.js"></script>
      <script src="../../js/jquery.tablesorter.js"></script>
      
      <script type="text/javascript">
      $(document).ready(function() { 
      $("#tabela").tablesorter()
      });
      </script>

		</body>
		</html>