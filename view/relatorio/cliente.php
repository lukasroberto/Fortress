                  <?php
                  ini_set('display_errors', 1);
                  ini_set('log_errors', 1);
                  ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
                  error_reporting(E_ALL);
                  
                  session_start();
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
                  <h2 class="page-header text-info">Quantidade de clientes por empresa</h2>
                  <div class="row placeholders">
                  <div class="col-xs-6 col-sm-2"> <img src="../../img/fortress.jpg" width="200px" height="200px" class="img-responsive centralizado" title="Fortress">
                  <h4><?php $qtdClientesEmpresa = $controller->qtdClientesPorEmpresa('fortress'); echo($qtdClientesEmpresa->quantidade);?></h4>
                  <span class="text-muted"><a href='../cliente/lista.php?empresa=fortress&monitorado=True'>Fortress</a></span> </div>
                  <div class="col-xs-6 col-sm-2 "> <img src="../../img/logus.jpg" width="200px" height="200px" class="img-responsive centralizado" alt="Logus">
                  <h4><?php $qtdClientesEmpresa = $controller->qtdClientesPorEmpresa('logus'); echo($qtdClientesEmpresa->quantidade);?></h4>
                  <span class="text-muted"><a href='../cliente/lista.php?empresa=logus&monitorado=True'>Logus</a></span> </div>
                  <div class="col-xs-6 col-sm-2 "> <img src="../../img/asa.jpg" width="200px" height="200px" class="img-responsive centralizado" alt="Eletrônica ASA">
                  <h4><?php $qtdClientesEmpresa = $controller->qtdClientesPorEmpresa('asa'); echo($qtdClientesEmpresa->quantidade);?></h4>
                  <span class="text-muted"><a href='../cliente/lista.php?empresa=asa&monitorado=True'>Eletrônica Asa</a></span> </div>
                  <div class="col-xs-6 col-sm-2 "> <img src="../../img/fortressguardian.jpg" width="200px" height="200px" class="img-responsive centralizado" alt="Fortess Guardian">
                  <h4><?php $qtdClientesEmpresa = $controller->qtdClientesPorEmpresa('guardian'); echo($qtdClientesEmpresa->quantidade);?></h4>
                  <span class="text-muted"><a href='../cliente/lista.php?empresa=guardian&monitorado=True'>Fortress Guardian</a></span> </div>
                  <div class="col-xs-6 col-sm-2 "> <img src="../../img/tm.jpg" width="200px" height="200px" class="img-responsive centralizado" alt="Não Monitorado">
                  <h4><?php $totalClientes = $controller->totalClientes('True'); echo($totalClientes->quantidade);?></h4>
                  <span class="text-muted">Total clientes monitorados</span> </div>
                  <div class="col-xs-6 col-sm-2 "> <img src="../../img/nm.jpg" width="200px" height="200px" class="img-responsive centralizado" alt="Não Monitorado">
                  <h4><?php $totalClientes = $controller->totalClientes('False'); echo($totalClientes->quantidade);?></h4>
                  <span class="text-muted"><a href='../cliente/lista.php?monitorado=False'>Não Monitorado</a></span> </div>
                  
                  </div>
                  <h3 class="sub-header text-info">Quantidade de clientes por cidade</h3>
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
                  if($listaEmpresas["cli_empresa"] == 'Guardian'){$nomeEmpresa="Fortress Guardian";}
                  if($listaEmpresas["cli_empresa"] == 'ASA'){$nomeEmpresa="Eletrônica ASA";}
                  if($listaEmpresas["cli_empresa"] == 'nm'){$nomeEmpresa="Não Monitorado";}
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
                  if($qtdClientes["cli_empresa"] == 'Guardian'){$nomeEmpresa="Fortress Guardian";}
                  if($qtdClientes["cli_empresa"] == 'ASA'){$nomeEmpresa="Eletrônica ASA";}
                  if($qtdClientes["cli_empresa"] == 'nm'){$nomeEmpresa="Não Monitorado";}
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
