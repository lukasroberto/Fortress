          <?php
          ini_set('display_errors', 1);
          ini_set('log_errors', 1);
          ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
          error_reporting(E_ALL);
          
          session_start();
          if($_SESSION["idusuario"]==NULL){
          header('Location: ../login/login.php?acao=5&tipo=2');
          }
          
          include_once("../../functions/functions.class.php");
          require_once("../../controller/oslist.controller.class.php");
          
          $functions		= new Functions;
          $oslist 	= new oslist;
          
          $tecnico = (isset($_GET['idtecnico']))? $_GET['idtecnico']:'';
          $dataini = (isset($_GET['dataini']))? $_GET['dataini']:'';
          $datafin = (isset($_GET['datafin']))? $_GET['datafin']:'';
          $busca = (isset($_GET['busca']))? $_GET['busca']:'';
          $status = (isset($_GET['status']))? $_GET['status']:'2';
          $submit = (isset($_GET['submit']))? $_GET['submit']:'';

          
          if ($tecnico && $dataini && $datafin) {
          $listaDeOs 	= $oslist->listOsPorTecnico($tecnico,$dataini,$datafin);
          }else{
          	if($submit == 'tipoCliente'){
          		$listaDeOs 	= $oslist->listOsBuscaPorCliente78($busca,$status);
          }else{
          	$listaDeOs 	= $oslist->listOsBusca($busca,$status);
          }
      			}
          
          if($status == 2){//aberta
          $contextoDoLink = "ospendente";
          $contextoDoTitulo = " em Aberto";
          $contextoDoIcone = "glyphicon-wrench";
          $contextoDoALT = "Editar";
          };
          if($status == 4){//finalizada
          $contextoDoLink = "osfinalizada";
          $contextoDoTitulo = "Finalizadas";
          $contextoDoTecnico = (isset($_GET["nometecnico"]))? " pelo técnico ".$_GET["nometecnico"]:'';
          $contextoDoIcone = "glyphicon-list-alt";
          $contextoDoALT = "Visualizar";
          };
          
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
          <h2>Listagem das ordens de serviço.</h2>
          <small>Confira abaixo as ordens de serviço <?php echo $contextoDoTitulo?><?php echo (isset($contextoDoTecnico))? $contextoDoTecnico:'';?>.</small></blockquote>
          </blockquote>
          <!-- Mensagem de Retorno -->
          <?php
          if(!empty($_GET["tipo"])){
          if(!empty($_GET["acao"])){
          $functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
          }else{
          $functions->mensagemDeRetornoPersonalizada($_GET["tipo"],"Nada encontrado! Por favor, Selecione uma Ordem se de serviço.");
          }}
          ?>
          <form class="form-inline" role="form" id="relatorio-form" action="lista.php" method="get">
          <select class="form-control" name="status" id="status">
          <option value="2">OS em Aberto</option>
          <option value="4">Finalizadas</option>
          </select>
          <div class="form-group has-feedback">
          <input class="form-control" name="busca" id="busca" type="text" placeholder="Código da OS"/>
          </div>
          <input class="btn btn-warning" name="submit" type="submit" id="busca" value="Buscar"/>
          <a class="btn btn-primary" href="cadastraos.php">Abrir Nova OS</a>
          
		  <a class="btn btn-default  btn-xs" href="lista.php?status=<?php echo $status ?>&busca=78&submit=tipoCliente">Mostrar OS Administrativa</a>
		  <a class="btn btn-default  btn-xs" href="lista.php?status=<?php echo $status ?>&busca=&submit=tipoCliente">Mostrar OS Técnica</a>
		  <a class="btn btn-default  btn-xs" href="lista.php">Mostrar Todas</a>
          </form>
          <table id="tabela" class="tablesorter table table-hover table-striped">
          <thead>
          <tr>
          <th class="iconorder">Cod. OS</th>
          <th class="iconorder">Cliente</th>
          <th class="iconorder">Aberta em</th>
          <th class="iconorder">Solicitada por</th>
          <th class="iconorder">Aberta por</th>
          <th class="iconorder">Status</th>
          </thead>
          </tr>
          
          <?php

          $conta =0;

          $dados = "";
          while($os = sqlsrv_fetch_array($listaDeOs)){
          $conta = $conta + 1;
          
          ?>

         <tr <?php if (date("Y/m/d", strtotime($os["os_data_ini"])) < date('Y/m/d', strtotime("-7 days"))) { ?>
          	class="danger" title="OS Aberta á mais 7 dias"
          	<?php } ?>
          	<?php if (date("Y/m/d", strtotime($os["os_data_ini"])) < date('Y/m/d', strtotime("-3 days"))) { ?>
          	class="warning" title="OS Aberta á mais 3 dias"
          	<?php } ?>
          	 onClick="location.href='<?php echo $contextoDoLink; ?>.php?osid=<?php echo $os["os_id"]?>'">

          <td><div><strong style="color:#F93"><?php echo $os["os_id"]?></strong></div></td>
          <td><div><?php echo $os["cli_codigo"]." - ". $os["cli_nome"] ?></div></td>
          <td><div><?php echo date("Y/m/d H:m", strtotime($os["os_data_ini"]));?>
          </div></td>
          <td><div><?php echo $os["os_solicitada_por"]?></div></td>
          <td><div><?php echo $os["os_expedidor"]?></div></td>
          <td style="text-align:center"><a type="button" title="<?php echo $contextoDoALT; ?>" href="<?php echo $contextoDoLink; ?>.php?osid=<?php echo $os["os_id"]; ?>"><i class="glyphicon <?php echo $contextoDoIcone; ?>"></i></a></td>
          </tr>
          <tr>
          <td></td>
          <td colspan="5"><div><?php echo $os["os_serv_sol"]?></div></td>


          </tr>
          <?php
           } ?>
          </table>
          </form>
          <?php include_once("../../view/footer/footer.php");?>
          </div>
          <!-- /container --> 
          
          <!-- Javascript --> 
          <script src="../../js/jquery.validate.min.js"></script> 
          <script src="../../js/bootstrap.min.js"></script> 
          <script src="../../js/jquery-ui.js"></script> 
          <script src="../../js/tab.js"></script>
          <script src="../../js/jquery.tablesorter.js"></script>
          
          <script type="text/javascript">
          $(document).ready(function() { 
          $("#tabela").tablesorter()
          });
          </script>
          </body>
          </html>
