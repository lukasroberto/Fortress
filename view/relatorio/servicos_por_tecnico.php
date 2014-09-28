<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');

session_start();
if($_SESSION["idusuario"]==NULL){
	 header('Location: ../login/login.php?acao=5&tipo=2');
}

require_once("../../controller/relatorio.controller.class.php");
include_once("../../functions/functions.class.php");
include_once("../../functions/query.class.php");

$tecnico = (isset($_POST['tecnico']))? $_POST['tecnico']:'';
$dataini = (isset($_POST['dataini']))? $_POST['dataini']:date((date('d'))+1-(date('d')).'-m-Y');
$datafin = (isset($_POST['datafin']))? $_POST['datafin']:date('d-m-Y');

$controller = new RelatorioController();
$query = new Query();

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
<style>
@media screen and (max-width: 1px) {
.row-offcanvas {
	position: relative;
	-webkit-transition: all .25s ease-out;
	-o-transition: all .25s ease-out;
	transition: all .25s ease-out;
}
.row-offcanvas-right {
	right: 0;
}
.row-offcanvas-left {
	left: 0;
}
.row-offcanvas-right .sidebar-offcanvas {
	right: -50%; /* 6 columns */
}
.row-offcanvas-left .sidebar-offcanvas {
	left: -50%; /* 6 columns */
}
.row-offcanvas-right.active {
	right: 50%; /* 6 columns */
}
.row-offcanvas-left.active {
	left: 50%; /* 6 columns */
}
.sidebar-offcanvas {
	position: absolute;
	top: 0;
	width: 50%; /* 6 columns */
}
}
</style>
</head>
<body>
<?php include_once("../../view/menu/menu.php");?>

<div class="container">
<!-- Título -->
<blockquote>
  <h2>Relatórios de Serviços</h2>
  <small>Confira abaixo as informações relacionadas aos Serviços realizados neste mês.</small></blockquote>
  <div class="row row-offcanvas row-offcanvas-right">
    <div class="col-xs-12 col-sm-9">
      <p class="pull-right visible-xs">
        <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Opções</button>
      </p>
      <div class="row">
        <form class="navbar-form navbar-left" id="contact-form" action="servicos_por_tecnico.php" method="post" enctype="multipart/form-data">
          <div class="form-group datepicker">
            <input type="text" class="form-control" name="dataini" id="dataini" value="<?php echo (!$dataini == NULL) ?  $dataini  :  date((date('d'))+1-(date('d')).'-m-Y'); ?>" data-date="12-02-2014" data-date-format="dd-mm-yyyy">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="datafin" id="datafin" value="<?php echo (!$datafin == NULL) ?  $datafin  :  date('d-m-Y'); ?>" data-date="12-02-2014" data-date-format="dd-mm-yyyy">
          </div>
          <div class="form-group">
            <select class="form-control" name="tecnico">
              <option value="">Selecione um Técnico</option>
              <?php
	  				$listaTecnico = $query->listaTecnicos();
                	while($listaTecnicos = sqlsrv_fetch_array($listaTecnico)){
				?>
              <option value="<?php echo $listaTecnicos["tec_id"]?>" <?php echo ($listaTecnicos["tec_id"] == $tecnico) ? 'Selected' : '' ?>><?php echo $listaTecnicos["tec_nome"]?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-warning btn-large" value="Buscar" name="submit">
          </div>
        </form>
      </div>
      <div class="row">
        <?php
			$servicosPorTecnico = $controller->listaQtdServicos($tecnico,$dataini,$datafin);
			$row_count = sqlsrv_num_rows( $servicosPorTecnico );
		
			if ($row_count > 0){

	?>
        <table class="table table-striped table-hover table-condensed" width="200" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th><b>Técnico</b></th>
              <th><b>QTD de OS</b></th>
            </tr>
          </thead>
          <?php	
						$totalQuantidadeOS ='';
                	while($servicos = sqlsrv_fetch_array($servicosPorTecnico)){
						$totalQuantidadeOS = $totalQuantidadeOS+$servicos["quantidade"];
				?>
          <tr onClick="location.href='../os/lista.php?idtecnico=<?php echo $servicos["tec_id"]; ?>&dataini=<?php echo $dataini ?>&datafin=<?php echo $datafin ?>&status=4&nometecnico=<?php echo $servicos["tec_nome"] ?>'">
            <td><?php echo $servicos["tec_nome"]; ?></td>
            <td><?php echo $servicos["quantidade"]; ?></td>
          </tr>
          <?php } ?>
          <tr class="info">
            <td><b>Total</b></td>
            <td><b><?php echo $totalQuantidadeOS; ?></b></td>
          </tr>
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
    <!--/span-->
    
    <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
      <div class="list-group">
       <a href="#" class="list-group-item active">Link</a> 
      <a href="#" class="list-group-item">Link</a>
       <a href="#" class="list-group-item">Link</a>
        <a href="#" class="list-group-item">Link</a>
         <a href="#" class="list-group-item">Link</a>
          <a href="#" class="list-group-item">Link</a>
           <a href="#" class="list-group-item">Link</a>
            <a href="#" class="list-group-item">Link</a>
             <a href="#" class="list-group-item">Link</a>
              <a href="#" class="list-group-item">Link</a>
               </div>
    </div>
    <!--/span--> 
  </div>
  <!--/row-->
  <?php include_once("../../view/footer/footer.php");?>
</div>
<!-- /container --> 

<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap-datepicker.js"></script> 
<script src="../../js/bootstrap.min.js"></script>

<script>
$('#dataini').datepicker()
  .on('changeDate', function(ev){
	$('#dataini').datepicker("hide");
  });
  
  $('#datafin').datepicker()
  .on('changeDate', function(ev){
	$('#datafin').datepicker("hide");
  });  

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
 
<script> 
	$(document).ready(function () {
  $('[data-toggle="offcanvas"]').click(function () {
    $('.row-offcanvas').toggleClass('active')
  });
});</script> 
</body>
</html>
