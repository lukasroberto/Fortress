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

			$dia = date('d')-1;
			$mes = date('m');
			$ano = date('Y');
			$hora = time('h');
			$dataOntem = mktime(0,0,0,$mes,$dia,$ano);
			echo $dataOntem;

			echo "teste".$dataOntem = date('d-m-Y',$dataOntem);

      $datetime = (isset($_POST['datetime']))? $_POST['datetime']:$dataOntem;
		
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
<link rel="stylesheet" href="../../css/menu-relatorio.css" />
</head>
<body>
<?php include_once("../../view/menu/menu.php");?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <?php include_once("../../view/menu/menuRelatorio.php");?>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<!-- Título -->
		<blockquote>
		<h2>Clientes sem Comunicação</h2>
		<small>Especifique no campo abaixo a data e hora que será verificada a Falha de comunicação.</small> </blockquote>
		
      <div class="row">
      <form class="navbar-form navbar-left" id="contact-form" action="lista_cliente_sem_comunicacao.php" method="post" enctype="multipart/form-data">
      <div class="form-group datepicker">
      <input type="text" class="form-control" name="datetime" id="datetime" value="<?php echo $datetime ?>" data-date="12-02-2014" data-date-format="dd-mm-yyyy">
      </div>
      <div class="form-group">
      <input type="submit" class="btn btn-warning btn-large" value="Buscar" name="submit">
      </div>
      </form>
      </div>
			
		<div class="container">
    <div class="row">
        <div class='col-sm-6'>
            <input type='text' class="form-control" id='datetimepicker4' />
        </div>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker4').datetimepicker();
            });
        </script>
    </div>
</div>
		<!-- Mensagem de Retorno -->
		<?php
		if(!empty($_GET["tipo"])){
		$functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
		}
		?>
		
		

		<?php
        $controller = new RelatorioController();
		$registros 	= $controller->listaClientesSemComunicacao($datetime);
		if($registros){
		?>
		<!-- Lista -->
		<table id="tabela" class="tablesorter table table-hover table-striped">
		<thead>
		<tr>
		<th class="iconorder">Código</th>
		<th class="iconorder">Nome</th>
		<th class="iconorder">Ultima Comunicação</th>
		<th class="iconorder">Observação</th>
		<th style="text-align:center"><i class="glyphicon glyphicon-pencil"></i></th>
		</tr>
		</thead>
		<tbody>
		<?php
		while($reg = sqlsrv_fetch_array($registros)){
		?>
		<tr>
		<td><?php echo $reg["cli_codigo"]; ?></td>
		<td><?php echo $reg["cli_nome"]; ?></td>
		<td><?php echo $reg["cli_ultima_comunicacao"]; ?></td>
		<td><?php echo $reg["cli_obs"]; ?></td>
		<td onClick="location.href='../cliente/edita_obs.php?operacao=update&clicodigo=<?php echo $reg["cli_codigo"] ?>'" class="glyphiconDetalhes"><i class="glyphicon glyphicon-pencil danger"></i></td>
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

			  </div>
			</div>
		  </div>
		<!-- /container --> 
		
	<!-- Javascript -->
      <script src="../../js/jquery.validate.min.js"></script> 
      <script src="../../js/teste.js"></script> 
            <script src="../../js/moment.js"></script>

      <script src="../../js/bootstrap.min.js"></script>
      <script src="../../js/jquery.tablesorter.js"></script>
      
      <script type="text/javascript">
      $(document).ready(function() { 
      $("#tabela").tablesorter()
      });
      </script>
      <script>
      $('#datetime').datepicker()
      .on('changeDate', function(ev){
      $('#datetime').datepicker("hide");
      });
      </script>

		</body>
		</html>