<?php

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

session_start();
$server = $_SERVER['SERVER_NAME']; 
$endereco = $_SERVER ['REQUEST_URI'];
$_SESSION["link"] = "http://" . $server . $endereco;

if($_SESSION["idusuario"]==NULL){
	 header('Location: ../login/login.php?acao=5&tipo=2');
}

include_once("../../functions/functions.class.php");
$functions	= new Functions;

if($_GET["confirma"]=="SIM"){

	require_once("../../controller/login.controller.class.php");
	$login 	= new LoginController;

	$login->logoff();
	
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
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/geral.css" rel="stylesheet">
<link href="../../css/validation.css" rel="stylesheet">
<link rel="stylesheet" href="../../css/jquery-ui.css" />
</head>
<body>

<?php include_once("../../view/menu/menu.php");?>

    <div class="container">

		<!-- Título -->
        <blockquote>
          <h2>Logoff</h2>
          <small>Escolha a opção desejada clicando nos botões abaixo</small>
        </blockquote>
        
		<hr>
        
		<div class="text-center">
			<h2>Efetuar Logoff</h2>
			<p>Deseja sair do sistema de Gerenciamento  Fortress?</p>
        
        <p>&nbsp;</p>

              <a href="logoff.php?confirma=SIM" class="btn btn-success btn-large">Sim, desejo sair do sistema</a>&nbsp;&nbsp;
              <a href="../home/home.php" class="btn btn-warning btn-large">Não desejo sair do sistema</a>
            </div>
            

  <?php include_once("../../view/footer/footer.php");?>


    </div> <!-- /container -->

<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
<script src="../../js/jquery-ui.js"></script> 

    
</body>
</html>