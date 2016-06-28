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

require_once("../../controller/relatorio.controller.class.php");
include_once("../../functions/functions.class.php");
include_once("../../functions/query.class.php");

$empresa = (isset($_POST['empresa']) )? $_POST['empresa']:'';
$cidade = (isset($_POST['cidade']) )? $_POST['cidade']:'';

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
                  </head>
                  <body>
                  <?php include_once("../../view/menu/menu.php");?>
                  <?php include_once("../../view/menu/menuRelatorio.php");?>
                  <div class="container-fluid">
                  <div class="side-body body-slide-out">
                  <h3 class="page-header text-info">Quantidade de clientes por empresa</h3>
                  <div align="center" class="row placeholders">
                  <div class="col-xs-6 col-sm-2"> <img src="../../img/fortress.jpg" width="200px" height="200px" class="img-responsive centralizado" title="Fortress">
                  <h4><?php $qtdClientesEmpresa = $controller->qtdClientesPorEmpresa('3'); echo($qtdClientesEmpresa->quantidade);?></h4>
                  <span class="text-muted"><a href='../cliente/lista.php?empresa=3&monitorado=True'>Monitorado Fortress</a></span> </div>
                  <div class="col-xs-6 col-sm-2 "> <img src="../../img/logus.jpg" width="200px" height="200px" class="img-responsive centralizado" alt="Logus">
                  <h4><?php $qtdClientesEmpresa = $controller->qtdClientesPorEmpresa('6'); echo($qtdClientesEmpresa->quantidade);?></h4>
                  <span class="text-muted"><a href='../cliente/lista.php?empresa=6&monitorado=True'>Monitorado Logus</a></span> </div>
                  <div class="col-xs-6 col-sm-2 "> <img src="../../img/asa.jpg" width="200px" height="200px" class="img-responsive centralizado" alt="Eletrônica ASA">
                  <h4><?php $qtdClientesEmpresa = $controller->qtdClientesPorEmpresa('8'); echo($qtdClientesEmpresa->quantidade);?></h4>
                  <span class="text-muted"><a href='../cliente/lista.php?empresa=8&monitorado=True'>Monitorado Eletrônica Asa</a></span> </div>
                  <div class="col-xs-6 col-sm-2 "> <img src="../../img/fortressguardian.jpg" width="200px" height="200px" class="img-responsive centralizado" alt="Fortess Guardian">
                  <h4><?php $qtdClientesEmpresa = $controller->qtdClientesPorEmpresa('9'); echo($qtdClientesEmpresa->quantidade);?></h4>
                  <span class="text-muted"><a href='../cliente/lista.php?empresa=9&monitorado=True'>Monitorado Fortress Guardian</a></span> </div>
                  <div class="col-xs-6 col-sm-2 "> <img src="../../img/tm.jpg" width="200px" height="200px" class="img-responsive centralizado" alt="Não Monitorado">
                  <h4><?php $totalClientes = $controller->totalClientes('True'); echo($totalClientes->quantidade);?></h4>
                  <span class="text-muted">Total clientes monitorados</span> </div>
                  <div class="col-xs-6 col-sm-2 "> <img src="../../img/nm.jpg" width="200px" height="200px" class="img-responsive centralizado" alt="Não Monitorado">
                  <h4><?php $totalClientes = $controller->totalClientes('False'); echo($totalClientes->quantidade);?></h4>
                  <span class="text-muted"><a href='../cliente/lista.php?monitorado=False'>Não Monitorado</a></span> </div>
                  
                  </div>
                  <h3 class="page-header text-info">Quantidade de clientes por cidade</h3>
                  <div class="row">
                  <form class="navbar-form navbar-left" id="contact-form" action="cliente.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                  <select class="form-control" name="cidade">
                  <option value="">Selecione uma Cidade</option>
                  <?php
                  $listaCidade = $query->listaCidades();
                  while($listaCidades = sqlsrv_fetch_array($listaCidade)){
                  ?>
                  <option value="<?php echo $listaCidades["cli_cidade"]?>" <?php echo ($listaCidades["cli_cidade"] == $cidade) ? 'Selected' : '' ?> ><?php echo ($listaCidades["cli_cidade"])?></option>
                  <?php } ?>
                  </select>
                  </div>
                  <div class="form-group">
                  <select class="form-control" name="empresa">
                  <option value="">Selecione uma Empresa</option>
                  <?php
                  $listaEmpresa = $query->listaEmpresa();
                  while($listaEmpresas = sqlsrv_fetch_array($listaEmpresa)){
                  $nomeEmpresa = '';
                  if($listaEmpresas["cli_empresa"] == '9'){$nomeEmpresa="Fortress Guardian";}
                  if($listaEmpresas["cli_empresa"] == '3'){$nomeEmpresa="Fortress";}
                  if($listaEmpresas["cli_empresa"] == '6'){$nomeEmpresa="Logus Alarmes";}
                  if($listaEmpresas["cli_empresa"] == '8'){$nomeEmpresa="Eletrônica ASA";}
                  if($listaEmpresas["cli_empresa"] == '9'){$nomeEmpresa="Telseg";}
                  if($listaEmpresas["cli_empresa"] == '10'){$nomeEmpresa="Master";}

                  if(!$nomeEmpresa){$nomeEmpresa=$listaEmpresas["cli_empresa"];}
                  ?>
                  <option value="<?php echo $listaEmpresas["cli_empresa"]?>" <?php echo ($listaEmpresas["cli_empresa"] == $empresa) ? 'Selected' : '' ?>><?php echo ($nomeEmpresa)?></option>
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
                  $qtdClientesCidades = $controller->listaQtdClientes($empresa,$cidade);
                  $row_count = sqlsrv_num_rows( $qtdClientesCidades );
                  
                  if ($row_count > 0){
                  
                  ?>
                  <table id="tabela" class="tablesorter table table-hover table-striped">
                  <thead>
                  <tr>
                  <th class="iconorder"><b>Cidade</b></th>
                  <th class="iconorder"><b>Empresa</b></th>
                  <th class="iconorder"><b>QTD Clientes</b></th>
                  </tr>
                  </thead>
                  <?php	
                  $totalQuantidadeClientes ='';
                  while($qtdClientes = sqlsrv_fetch_array($qtdClientesCidades)){
                  $totalQuantidadeClientes = $totalQuantidadeClientes+$qtdClientes["quantidade"];
                  $nomeEmpresa = '';
                  if($qtdClientes["cli_empresa"] == '9'){$nomeEmpresa="Fortress Guardian";}
                  if($qtdClientes["cli_empresa"] == '3'){$nomeEmpresa="Fortress";}
                  if($qtdClientes["cli_empresa"] == '6'){$nomeEmpresa="Logus Alarmes";}
                  if($qtdClientes["cli_empresa"] == '8'){$nomeEmpresa="Eletrônica ASA";}
                  if(!$nomeEmpresa){$nomeEmpresa=$qtdClientes["cli_empresa"];}
                  
                  
                  ?>
                  <tr onClick="location.href='../cliente/lista.php?cidade=<?php echo $qtdClientes['cli_cidade'];?>&empresa=<?php echo $qtdClientes['cli_empresa']?>&monitorado=True'">
                  <td><?php echo $qtdClientes["cli_cidade"]; ?></td>
                  <td><?php echo $nomeEmpresa ?></td>
                  <td><?php echo $qtdClientes["quantidade"]; ?></td>
                  </tr>
                  <?php } ?>
                  <tr class="info">
                  <td><b>Total</b></td>
                  <td></td>
                  <td><b><?php echo $totalQuantidadeClientes; ?></b></td>
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

                  </body>
                  </html>
