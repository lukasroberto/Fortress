<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

session_start();
if($_SESSION["idusuario"]==NULL){
	 header('Location: ../login/login.php?acao=5&tipo=2');
}

include_once("../../functions/functions.class.php");

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
      <blockquote>
      <h3 class="page-header text-info">Olá <?php echo $_SESSION["nome"] ?></h3>
      <small>Bem vindo aos relatórios do Grupo Fortress.<br><br>
      No menu ao lado estão as opções para gerar os relatórios.<br>
      Usando corretamente esta ferramenta será possível extrair algumas informações muito importantes para a gestão e logística da empresa.<br><br>
      Não existe manual explicando o uso, porem qualquer duvida falar com Dep Informática ou mandar um E-mail para <a href="mailto:lukas@grupofortress.br">lukas@grupofortress.br</a><br>
      Os Relatórios ainda estão em desenvolvimento e com o tempo e ajuda de todos vamos melhorando.
    </small></blockquote>
</blockquote>
      <div class="row placeholders">


      </div>    
  </div>
</div>

<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap-datepicker.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
</body>
</html>
