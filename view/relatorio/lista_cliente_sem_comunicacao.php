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
		<blockquote class="alinha-left">
		<h2>Clientes sem Comunicação</h2>
		<small></small> </blockquote>
		
			
		
		<!-- Mensagem de Retorno -->
		<?php
		if(!empty($_GET["tipo"])){
		$functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
		}
		?>
		
		

		<?php
        $controller = new RelatorioController();
		$registros 	= $controller->listaClientesSemComunicacao();
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
					$dia = date('d') - 1;
			$mes = date('m');
			$ano = date('Y');
			$data = mktime(0,0,0,$mes,$dia,$ano);
			echo "ontem: ".date('d/m/Y',$data);
		}else{
		?>
		<div class="text-center">
		<h2>Opsss!!!</h2>
		<p>Sua pesquisa não retornou nenhum resultado válido.</p>
		</div>
		<?php
		}
		?>





</blockquote>
      <div class="row placeholders">


      </div>    
  </div>
</div>
		
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