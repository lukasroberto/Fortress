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
		include_once("../../functions/functions.class.php");


		if (isset($_POST["submit"])){
	        $controller = new RelatorioController();
			$controller->executa();
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
<link rel="stylesheet" href="../../css/menu-relatorio.css" />
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
		<h2>Atualiza tabelas CLIENTE_SERVICO  E SERVICO_TIPO_COMUNICACAO com os dados de comunicações dos clientes, isso ajuda a verificar onde os clientes comunicam.</h2>
				<!-- Mensagem de Retorno -->
		<?php
		if(!empty($_GET["tipo"])){
		$functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
		}
		?>
		
      <div class="row">
      <form class="navbar-form navbar-left" id="contact-form" action="atualiza_cli_serv_serv_tipo_comunic.php" method="post" enctype="multipart/form-data">
       <div class="form-group">
    	<div class="input-group col-xs-4">
  		</div>
      <div class="form-group">
      <input type="submit" class="btn btn-warning btn-large" value="Executar Atualização" name="submit">
      </div>
      </form>
      </div>
			

			  </div>
			</div>
		  </div>
		<!-- /container --> 


		</body>
		</html>


