<?php 
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');

session_start();
$server = $_SERVER['SERVER_NAME']; 
$endereco = $_SERVER ['REQUEST_URI'];
$_SESSION["link"] = "http://" . $server . $endereco;
        
if($_SESSION["idusuario"]==NULL){
	 header('Location: ../login/login.php?acao=5&tipo=2');
}

require_once("../../controller/cadastraos.controller.class.php");
require_once("../../model/os.class.php");
$controller = new CadastraOs();
$osCodigo = $controller->osCodigo();
$imprimeOsCodigo = ($osCodigo->Proximo);
$os = new Os();

require_once("../../controller/cliente.controller.class.php");
require_once("../../model/cliente.class.php");
$clienteController = new ClienteController();
$cliente = new Cliente();

include_once("../../functions/functions.class.php");
$functions	= new Functions;

if(isset($_POST['submit']) == 'Salvar') {

		$os->setCodCliente($_POST['osclicodigo']);
		$os->setTipo($_POST['ostipo']);
		$os->setSolPor($_POST['solicitadapor']);
		$os->setServSol($_POST['motivo']);
		$os->setDataIni($_POST['data']);
		$os->setObs($_POST['obs']);
		$os->setExpedidor($_SESSION["nome"]);
		$os->setStatus(2);
		
	if(isset($_POST['osclicodigo'])){
		$controller->save($os, 'os_id');
		header('Location: cadastraos.php?&tipo=1&oscodigo='.$imprimeOsCodigo);
	}else{
				header('Location: cadastraos.php?tipo=3');
	}
}
if(isset($_GET['submit']) == 'Buscar') {
	if($_GET['clicodigo']){	
		$cliente = $clienteController->loadObject($_GET['clicodigo'], 'cli_codigo');
	}else{
		header('Location: cadastraos.php?tipo=3');
	}
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
    <h2>Abrir Ordem de Serviço.</h2>
    <small>Utilize o formulário abaixo para abrir uma nova Ordem de Serviço.</small> </blockquote>
  
  <!-- Mensagem de Retorno -->
  <?php
  $mensagem;
			if(!empty($_GET["tipo"])){
				
				if(!empty($_GET["oscodigo"])){
				$functions->mensagemDeRetornoPersonalizada($_GET["tipo"],"Ao abrir a ordem de serviço! Cadastre com o código <b>".$_GET["oscodigo"]."</b> no SAMM.");
			}
				if(!empty($_GET["acao"])){
        		$functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
			}
				if(!empty($_GET["tipo"]) && empty($_GET["oscodigo"]) && empty($_GET["acao"])){
				$functions->mensagemDeRetornoPersonalizada($_GET["tipo"],"Selecione um cliente para abrir uma nova OS!");
        }
			}
        if($cliente){
		?>
  <div class="panel panel-info">
    <div class="panel-heading"> Dados do Cliente.<a class="btn btn-sm btn-info alinha-rigth" href="../cliente/lista.php">Busca Avançada</a></div>
    <div class="panel-body">
      <form id="busca-cliente-form" action="cadastraos.php" method="get" enctype="multipart/form-data">
        <div class="form-group alinha-left" style="width:20%">
          <label for="clicodigo">Código do Cliente</label>
          <div class="input-group">
            <input class="form-control" required type="text" name="clicodigo" id="clicodigo" value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getCodigo() : ''; ?>">
            <span class="input-group-btn">
            <input type="submit" class="btn btn-warning btn-large" value="Buscar" name="submit">
            </span> </div>
        </div>
      </form>
      <div class="form-group alinha-left" style="width:40%; padding-left:5px">
        <label for="nome">Nome</label>
        <input class="form-control" type="text" name="nome" id="nome"  value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getNome() : ''; ?>">
      </div>
      <div class="form-group alinha-left" style="width:40%; padding-left:5px">
        <label for="nome">Endereço</label>
        <input class="form-control" type="text" name="nome" id="nome"  value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getRua() : ''; ?>">
      </div>
    </div>
  </div>
  <?php
	if(isset($_GET['clicodigo'])){
  ?>
  <form id="abrir-os-form" action="cadastraos.php" method="post" enctype="multipart/form-data">
    <input required type="hidden" name="osclicodigo" id="osclicodigo" value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getCodigo() : ''; ?>">
    <div class="form-group alinha-left" style="width:20%">
      <label for="oscodigo">Código da OS</label>
      <input class="form-control" type="text" name="oscodigo" id="oscodigo" disabled value="<?php echo $imprimeOsCodigo; ?>">
    </div>
    <div class="form-group alinha-left" style="width:80%; padding-left:5px">
      <label for="tipoos">Tipo da OS</label>
      <select class="form-control" required id="ostipo" name="ostipo">
        <option value="">Selecione o Tipo da OS</option>
        <option value="3">Administrativo</option>
        <option value="5">Alarmes</option>
        <option value="8">Cancelamento de Monitoramento</option>
        <option value="7">Cerca El&eacute;trica</option>
        <option value="4">CFTV (Cameras-Informatica)</option>
        <option value="10">Manuten&ccedil;&atilde;o t&eacute;cnica (Ricardo)</option>
        <option value="2">Or&ccedil;amentos (Vendas)</option>
        <option value="6">Port&atilde;o</option>
        <option value="11">Vale</option>
        <option value="9">Outros</option>
      </select>
    </div>
    <div class="form-group">
      <label for="solicitadapor">OS Solicitada por</label>
      <input class="form-control" type="text" name="solicitadapor" id="solicitadapor" required value="<?php echo ($os->getId() > 0 ) ? $os->getSolPor() : ''; ?>">
    </div>
    <div class="form-group">
      <label for="motivo">Motivo</label>
      <textarea  required="required" class="form-control" name="motivo" id="motivo" value="<?php echo ($os->getId() > 0 ) ? $os->getServSol() : ''; ?>"></textarea>
    </div>
    <div class="form-group">
      <label for="data">Data</label>
      <input class="form-control" type="text" name="data" id="data" required value="<?php echo ($os->getId() > 0 ) ? $os->getDataIni() : date('d-m-y H:i'); ?>">
    </div>
    <div class="form-group">
      <label for="obs">Observação</label>
      <input class="form-control" type="text" name="obs" id="obs" value="<?php echo ($os->getId() > 0 ) ? $os->getObs() : ''; ?>">
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-success btn-large" value="Salvar" name="submit">
    </div>
  </form>
  <?php 
	}
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

<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
<script src="../../js/jquery-ui.js"></script> 
<script>
$(function() {
    $( "#data" ).datepicker();

});
</script>
</body>
</html>