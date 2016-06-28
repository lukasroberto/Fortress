<?php
session_start();
$server = $_SERVER['SERVER_NAME']; 
$endereco = $_SERVER ['REQUEST_URI'];
$_SESSION["link"] = "http://" . $server . $endereco;

  require_once("../../controller/home.controller.class.php");
  include_once("../../functions/functions.class.php");
  include_once("../../functions/query.class.php");

  $controller = new HomeController();


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

<div class="container"> 
  
  <!-- Título -->
  <blockquote>
    <h2>Ola, Seja Bem-vindo!</h2>
    <small>Confira abaixo Algumas informações importantes para ajudar em nosso trabalho.</small></blockquote>

    <?php $qtdClientesParaCadastrar = $controller->qtdClientesParaCadastrar();
    	  $qtdClientesParaCadastrar = ($qtdClientesParaCadastrar->cadastrar);
if($qtdClientesParaCadastrar > 0){
	?>
   <div class="alert alert-info" role="alert"> <strong>Atenção!</strong> <p><p> Existem <strong><?php echo $qtdClientesParaCadastrar; ?></strong> Clientes não cadastrados no sistema de OS, por favor, quando sobrar um tempinho cadastre se tiver os dados destes Clientes. Isso contribui para o bom funcionamento do Sistema, Obrigado! :) 
		<p>
		<div><a class="btn btn-info" href="../cliente/lista.php?coluna=cli_nome&condicao=igual&filtro=Cadastrar&" role="button">Clique para ver os Clientes.</a></div>
   </div>


<?php
}
   ?>
  


  <?php include_once("../../view/footer/footer.php");?>
</div>
<!-- /container --> 
<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap-datepicker.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
</body>
</html>
