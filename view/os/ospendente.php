<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

session_start();
if($_SESSION["idusuario"]==NULL){
	 header('Location: ../login/login.php?acao=5&tipo=2');
}
require_once("../../model/os.class.php");
include_once("../../functions/functions.class.php");
require_once("../../controller/ospendente.controller.class.php");

$functions		= new Functions;
$ospendente 	= new OsPendente;
$ospendentemodel = new os();

if(!$_GET['osid'] == NULL){
	$os_id = $_GET['osid'];
	$os = $ospendente->listOsPendente($os_id);
	if (is_null($os)){header('Location: lista.php?&tipo=4');}	
}else{	
header('Location: lista.php?&tipo=4');
}

if(isset($_GET['submit'])) {
	
	//Se houver tecnicos selecionados Insere no BD
	if(isset($_GET['tecnicos'])){	
	$tecnicos = $_GET['tecnicos'];
	foreach($tecnicos as $tecnico){				
	$ospendente->insereTecnicos($tecnico,$os_id);
		}

	$ospendentemodel->setId($_GET['osid']);
	$ospendentemodel->setIniServ($_GET['data1']);
	$ospendentemodel->setPecasUtil($_GET['utilizadas']);
	$ospendentemodel->setPecasRetir($_GET['retiradas']);
	$ospendentemodel->setServEfe($_GET['servico']);
	$ospendentemodel->setStatus("4");

	//if($_SESSION["nivuser"]==1){
	$ospendente->update($ospendentemodel, 'os_id',$ospendentemodel->getId());
	header('Location: lista.php?&tipo=1&acao=1');
	}
	//Exibir Menssagem selesionar tecnicos!!
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
    <small>Confira abaixo os detalhes da Ordens de serviço ainda em execução.</small></blockquote>   
  <form class="form-horizontal" role="form" id="relatorio-form" action="ospendente.php" method="get">
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
        <td><small><?php echo $os->cli_codigo. " - " . $os->cli_nome;?></small></td>
      </tr>
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
		$listaTecnicos = $ospendente->listTecnicos();
		while($tec = sqlsrv_fetch_array($listaTecnicos)){ ?>
      <div class="checkbox">
      </label>               
      <input name="tecnicos[]" type="checkbox" class="removecampovermelho"  value="<?php echo $tec["tec_id"] ?>">
      <?php echo $tec["tec_nome"] ?>
      </label>
      </div>
            <?php } ?>
                  
          </td>
      </tr>
      <tr>
        <td>Data do serviço:</td>
        <td><div class="form-group has-feedback" style="max-width:150px">
            <input name="osid" type="hidden"id="osid" value="<?php echo ($os_id > 0 ) ? $os_id : ''; ?>"/>
            <input name="data1" type="text" required class="form-control" id="data1" placeholder="Selecionar" value="<?php echo date("m/d/y")?>" />
          </div></td>
      </tr>
      <tr>
        <td>Peças Utilizadas:</td>
        <td><div class="form-group has-feedback">
            <textarea name="utilizadas"  class="form-control" id="utilizadas" placeholder="Frase"></textarea>
          </div></td>
      </tr>
      <tr>
        <td>Peças Retiradas:</td>
        <td><div class="form-group has-feedback">
            <textarea name="retiradas" class="form-control" id="retiradas" placeholder="Frase"></textarea>
          </div></td>
      </tr>
      <tr>
        <td>Serviço Efetuado:</td>
        <td><div class="form-group has-feedback">
            <textarea name="servico" required class="form-control" id="servico" placeholder="Frase"></textarea>
          </div></td>
      </tr>
    </table>
    <input class="btn btn-success" name="submit" type="submit" id="submit" value="Finalizar OS!"/>
    <a class="btn btn-default" href="javascript:print();"><i class="glyphicon glyphicon-print" style="font-size:16px"></i></a>
  </form>

  <?php include_once("../../view/footer/footer.php");?>
</div>
<!-- /container --> 

<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
<script src="../../js/jquery-ui.js"></script> 
<script>
        $(document).ready(function(){
         
         $('#relatorio-form').validate(
         {
			 onkeyup: function(element) {$(element).valid()},	


		highlight: function(element, errorClass) {
          $(element).closest('.form-group').removeClass('has-success').addClass('has-error label.error');
  },
		success: function(element) {
          element.addClass('glyphicon glyphicon-ok form-control-feedback').closest('.form-group').removeClass('has-error').addClass('has-success');
          },  		
         });
        });
</script> 
<script>
$(function() {
    $( "#data1" ).datepicker();
	$( "#data1" ).datepicker( "option", "dateFormat",'dd-mm-yy' );

});
</script>
</body>
</html>
