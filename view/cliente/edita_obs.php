<?php 
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

session_start();
if($_SESSION["idusuario"]==NULL){
	 header('Location: ../login/login.php?acao=5&tipo=2');
}
require_once("../../controller/cliente.controller.class.php");
require_once("../../model/cliente.class.php");
include_once("../../functions/functions.class.php");

$controller = new ClienteController();
$cliente = new Cliente();
$functions	= new Functions;

if(isset($_POST['submit'])) {

	$cliente->setCodigo($_POST['codigo']);
	$cliente->setNome($_POST['nome']);
  $cliente->setObs($_POST['obs']);


	$operaçao = $_POST['update'];
	if($operaçao == "update"){
		if($_SESSION["nivuser"]==1 || $_SESSION["nivuser"]==2){
			$controller->update($cliente, 'cli_codigo',$cliente->getCodigo());
      header('Location: ../relatorio/lista_cliente_sem_comunicacao.php?tipo=1&acao=2');
		}else{
		header('Location: ../relatorio/lista_cliente_sem_comunicacao.php?tipo=2');
		}
	}else{
		$controller->save($cliente, 'cli_codigo');
		header('Location: ../relatorio/lista_cliente_sem_comunicacao.php?acao=1&tipo=1');
	}

}

if(isset($_GET['clicodigo'])){
	$cliente = $controller->loadObject($_GET['clicodigo'], 'cli_codigo');
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

<body onload="initialize()">
<?php include_once("../../view/menu/menu.php");?>
<div class="container"> 
  
  <!-- Título -->
  <blockquote>
    <h2>Edição de Clientes</h2>
    <small>Utilize o formulário abaixo para editar observações sobre a comunicação dos Clientes</small> </blockquote>
  
  <!-- Mensagem de Retorno -->
  <?php
        if(!empty($_GET["tipo"])){
		?>
  <section id="aviso">
    <?php
        	$functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
		?>
  </section>
  <?php
        }
        ?>
  <div style="max-width:400px;">
    <form class="form-horizontal" id="contact-form" action="edita_obs.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        </input>
        <label for="codigo">Código</label>
        <input class="form-control" type="hidden" name="update" id="update" value="<?php if(!empty($_GET["operacao"]))echo"update"; ?>">
        <input name="codigo" required type="text" class="form-control" id="codigo" value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getCodigo() : ''; ?>">
      </div>
      <div class="form-group">
        <label for="nome">Nome Completo</label>
        <input class="form-control" type="text" name="nome" id="nome" required value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getNome() : ''; ?>">
      </div>
        <div class="form-group">
        <label for="tel-secundario">Observação</label>
        <small><br>Informações referente a comunicação do CLiente.</small>
        <textarea class="form-control" name="obs" id="obs" rows="10" cols="40" maxlength="500"><?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getObs() : ''; ?></textarea>
        </div>
      <div class="form-group">
        <input type="submit" class="btn btn-success btn-large" value="Salvar" name="submit">
      </div>
    </form>
  </div>
  <?php include_once("../../view/footer/footer.php");?>
</div>
<!-- /container --> 

<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
<script src="../../js/jquery-ui.js"></script> 
<script src="../../js/endereco.js"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
</body>
</html>