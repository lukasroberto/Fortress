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
require_once("../../model/os.class.php");
include_once("../../functions/functions.class.php");
require_once("../../controller/osfinalizada.controller.class.php");

$functions		= new Functions;
$osfinalizada 	= new OsFinalizada;

if(!$_GET['osid'] == NULL){
	$os_id = $_GET['osid'];
	$os = $osfinalizada->listOsFinalizada($os_id);
	if (is_null($os)){header('Location: lista.php?&tipo=4');}
}else{	
header('Location: lista.php?&tipo=4');
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
    <h2>Ordens de Serviço em Aberto</h2>
    <small>Confira abaixo os detalhes da Ordem de serviço Finalizada.</small></blockquote>
    <table class="table table-condensed">
      <tr>
        <td colspan="2" class="active"><h4>Dados Gerais</h4></td>
      </tr>
      <tr>
        <td width="16%">Código da Os:</td>
        <td width="84%"><small><?php echo $os_id?></small></td>
      </tr>
      <tr>
        <td>Os Solicitada por:</td>
        <td><small><?php echo($os->os_solicitada_por);?></small></td>
      </tr>
      <tr>
        <td>Motivo da Solicitação:</td>
        <td><small><?php echo($os->os_serv_sol);?></small></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="active"><h4>Dados do Cliente</h4></td>
      </tr>
      <tr>
        <td>Cliente:</td>
		<td><small><?php echo $os->cli_codigo. " - " . $os->cli_nome;?></small></td>      </tr>
      <tr>
        <td>Endereço:</td>
        <td><small><?php echo($os->cli_rua);?></small></td>
      </tr>
      <tr>
        <td>Bairro:</td>
        <td><small><?php echo($os->cli_bairro);?></small></td>
      </tr>
      <tr>
        <td>Cidade:</td>
        <td><small><?php echo($os->cli_cidade);?></small></td>
      </tr>
      <tr>
        <td>Telefone  1:</td>
        <td><?php echo($os->cli_telefone);?></td>
      </tr>
      <tr>
        <td>Telefone 2:</td>
        <td><?php echo($os->cli_telefone1);?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="active"><h4>Informações Extras</h4></td>
      </tr>
      <tr>
        <td>Observações:</td>
        <td><?php echo($os->os_obs);?></td>
      </tr>
      <tr>
        <td>OS Solicitada em:</td>
        <td><?php echo($os->os_data_ini);?></td>
      </tr>
      <tr>
        <td>Experidor:</td>
        <td><?php echo($os->os_expedidor);?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
        <td colspan="2" class="active"><h4>Serviço Realizado</h4></td>
      </tr>
      <tr>
        <td>Serviço Realizado por:</td>
        <td>
            <?php 
		$listaTecnicos = $osfinalizada->listTecnicos($os_id);
		while($tec = sqlsrv_fetch_array($listaTecnicos)){ 
		echo $tec["tec_nome"]."<br>";} ?>
                  
          </td>
      </tr>
            <tr>
        <td>Data:</td>
        <td><?php echo($os->os_ini_serv);?></td>
      </tr>
            <tr>
        <td>Peças Utilizadas:</td>
        <td><?php echo($os->os_pecas_util);?></td>
      </tr>
            <tr>
        <td>Peças Retiradas:</td>
        <td><?php echo($os->os_pecas_retir);?></td>
      </tr>
                  <tr>
        <td>Serviço Efetuado:</td>
        <td><?php echo($os->os_serv_efe);?></td>
      </tr>
    </table>
    <a class="btn btn-default" href="javascript:print();"><i class="glyphicon glyphicon-print" style="font-size:16px"></i></a>

  <?php include_once("../../view/footer/footer.php");?>
</div>
<!-- /container --> 

<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
<script src="../../js/jquery-ui.js"></script> 
</body>
</html>
