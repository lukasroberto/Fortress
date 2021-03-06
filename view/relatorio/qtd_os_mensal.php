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

require_once("../../controller/relatorio.controller.class.php");
include_once("../../functions/functions.class.php");

$functions  = new Functions;
$tecnico = (isset($_POST['tecnico']))? $_POST['tecnico']:'';
$dataini = (isset($_POST['dataini']))? $_POST['dataini']:'01-01-2010';
$datafin = (isset($_POST['datafin']))? $_POST['datafin']:date('d/m/Y');

$controller = new RelatorioController();

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
                  <?php include_once("../../view/menu/menuRelatorio.php");?>


    <div class="container-fluid">
        <div class="side-body body-slide-out">    
            <blockquote>
            <h2>Quantidade de ordens de serviço mensal.</h2>
            <small>Utilize os filtros para conferir a quantidade de ordens de serviços realizados por mês.</small> 
            </blockquote>              
                  
                  <div class="row">
                  <form class="navbar-form navbar-left" id="contact-form" action="qtd_os_mensal.php" method="post" enctype="multipart/form-data">
                  <div class="form-group datepicker">
                  <input type="text" class="form-control" name="dataini" id="dataini" value="<?php echo $dataini ?>" data-date="12-02-2014" data-date-format="dd-mm-yyyy">
                  </div>
                  <div class="form-group">
                  <input type="text" class="form-control" name="datafin" id="datafin" value="<?php echo $datafin?>" data-date="12-02-2014" data-date-format="dd-mm-yyyy">
                  </div>
                  <div class="form-group">
                  <input type="submit" class="btn btn-warning btn-large" value="Buscar" name="submit">
                  </div>
                  </form>
                  </div>
                  <div class="row">
                  <?php
                  $qtdOsMensal = $controller->listaQtdOSMensal($dataini,$datafin);
                  $row_count = sqlsrv_num_rows( $qtdOsMensal );
                  
                  if ($row_count > 0){
                  
                  ?>
                  <table id="tabela" class="tablesorter table table-hover table-striped">
                  <thead>
                  <tr>
                  <th class="iconorder"><b>Ano</b></th>
                  <th class="iconorder"><b>Mês</b></th>
                  <th class="iconorder"><b>Quantidade de OS Mês</b></th>
                  <th class="iconorder"><b>Média de OS por Dia</b></th>
                  
                  </tr>
                  </thead>
                  <?php 
                  while($qtdOS = sqlsrv_fetch_array($qtdOsMensal)){
                  ?>
                  <tr>
                  <td><?php echo $qtdOS["YEAR"]; ?></td>
                  <td><?php echo $qtdOS["MONTH"]; ?></td>
                  <td><?php echo $qtdOS["QUANTIDADE"]; ?></td>
                  <td><?php echo number_format(($qtdOS["QUANTIDADE"]/30),1,",","."); ?></td>
                  </tr>
                  <?php } ?>
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
                  <script src="../../js/jquery.tablesorter.js"></script>
                  
                  <script type="text/javascript">
                  $(document).ready(function() { 
                  $("#tabela").tablesorter()
                  });
                  </script>
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
