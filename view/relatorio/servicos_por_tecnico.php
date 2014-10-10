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

$functions  = new Functions;
$tecnico = (isset($_POST['tecnico']))? $_POST['tecnico']:'';
$dataini = (isset($_POST['dataini']))? $_POST['dataini']:'01'.date('/m/Y');
$datafin = (isset($_POST['datafin']))? $_POST['datafin']:date('d/m/Y');

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

  <h2 class="text-info">Relatórios de Serviços finalizados</h2>
  <small>Utilize os filtros para conferir a quantidade de serviços realizados por cada colaborador.</small></blockquote>

      <div class="row">
        <form class="navbar-form navbar-left" id="contact-form" action="servicos_por_tecnico.php" method="post" enctype="multipart/form-data">
          <div class="form-group datepicker">
            <input type="text" class="form-control" name="dataini" id="dataini" value="<?php echo $dataini ?>" data-date="12/02/2014" data-date-format="dd/mm/yyyy">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="datafin" id="datafin" value="<?php echo $datafin?>" data-date="12/02/2014" data-date-format="dd/mm/yyyy">
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
              <th><b>Média por dia</b></th>
            </tr>
          </thead>
          <?php 
            $totalQuantidadeOS ='';
            //CHAMADA DA FUNCAO PARA CALCULAR DIAS UTEIS
               $DataInicial = "18/10/2010";
                $DataFinal = "27/10/2010";
            $diasUteis = $functions->DiasUteis($dataini, $datafin);
                  while($servicos = sqlsrv_fetch_array($servicosPorTecnico)){
                        $totalQuantidadeOS = $totalQuantidadeOS+$servicos["quantidade"];
                    
                        $media = $servicos["quantidade"] / $diasUteis;
        ?>
          <tr onClick="location.href='../os/lista.php?idtecnico=<?php echo $servicos["tec_id"]; ?>&dataini=<?php echo $dataini ?>&datafin=<?php echo $datafin ?>&status=4&nometecnico=<?php echo $servicos["tec_nome"] ?>'">
            <td><?php echo $servicos["tec_nome"]; ?></td>
            <td><?php echo $servicos["quantidade"]; ?></td>
            <td><?php echo number_format($media,1,",","."); ?></td>
          </tr>
          <?php } ?>
          <tr class="info">
            <td><b>Total</b></td>
            <td><b><?php echo $totalQuantidadeOS; ?></b></td>
            <td><?php echo number_format(($totalQuantidadeOS/$diasUteis),1,",","."); ?></td>
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
</div>


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

</body>
</html>
