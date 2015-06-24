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
          if($_GET["acao"] == "mail"){
          $functions->mensagemDeRetornoPersonalizada($_GET["tipo"],"E-Mail Enviado com sucesso! Uma cópia foi enviada para você.");
          }else{          
          if(!empty($_GET["acao"])){
          $functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
          }else{
          $functions->mensagemDeRetornoPersonalizada($_GET["tipo"],"Nada encontrado! Por favor, Selecione uma Ordem se de serviço.");
          }}}
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
		  <a class="btn btn-default  btn-xs" title="Exibe as Ordens de Serviço Administrativas abertas em seu plantão." href="lista.php?status=<?php echo $status ?>&busca=78&submit=tipoCliente">Mostrar OS Administrativa</a>
		  <a class="btn btn-default  btn-xs" title="Exibe as Ordens de Serviço Técnicas abertas em seu plantão." href="lista.php?status=<?php echo $status ?>&busca=&submit=tipoCliente">Mostrar OS Técnica</a>
		  <a class="btn btn-default  btn-xs" title="Exibe todas as Ordens de Serviço em Aberto." href="lista.php">Mostrar Todas</a>
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
          $contaOsAberta =0;
          $contaTotalOsAberta =0;
          $contaOsAbertaA3Dias =0;
          $contaOsAbertaA7Dias =0;

          $dados = "";
          while($os = sqlsrv_fetch_array($listaDeOs)){
          $contaTotalOsAberta = $contaTotalOsAberta + 1;
          
          ?>

         <tr <?php if (date("Y/m/d", strtotime($os["os_data_ini"])) < date('Y/m/d', strtotime("-7 days")) & $os["os_status"] !=4) { ?>
               class="danger" title="OS Aberta á mais 7 dias"
               <?php $contaOsAbertaA7Dias = $contaOsAbertaA7Dias+1; } ?>
               <?php if (date("Y/m/d", strtotime($os["os_data_ini"])) < date('Y/m/d', strtotime("-3 days")) & $os["os_status"] != 4) { ?>
               class="warning" title="OS Aberta á mais 3 dias"
               <?php $contaOsAbertaA3Dias = $contaOsAbertaA3Dias+1; }else{
               $contaOsAberta = $contaOsAberta + 1;
                    } ?>
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
          <div class="row">
          <div style='position:absolute; left:70%;'>
          <ul class="list-group">
          <li class="list-group-item list-group-item-info">         
          OS aberta a menos de 3 Dias: 
          <span class="label label-primary alinha-rigth">
          <?php echo $contaOsAberta; ?>
          </span>
          </li>
          <li class="list-group-item list-group-item-warning">         
          OS abertas a mais de 3 Dias : 
          <span class="label label-warning alinha-rigth">
          <?php echo $contaOsAbertaA3Dias; ?>
          </span>
          </li>
          <li class="list-group-item list-group-item-danger">         
          OS abertas a mais de 7 Dias : 
          <span class="label label-danger alinha-rigth">
          <?php echo $contaOsAbertaA7Dias; ?>
          </span>
          </li>
          <li class="list-group-item">         
          Total de Orders de Serviço: 
          <span class="label label-default alinha-rigth">
          <?php echo $contaTotalOsAberta; ?>
          </span>
          </li>
          </ul>
          </div>
          </div>
<?php
 $oslist2  = new oslist;
if ($tecnico && $dataini && $datafin) {
$listaDeOs = $oslist2->listOsPorTecnico($tecnico,$dataini,$datafin);
}else{
if($submit == 'tipoCliente'){
$listaDeOs = $oslist->listOsBuscaPorCliente78($busca,$status);
}else{
$listaDeOs = $oslist->listOsBusca($busca,$status);
}
}

if($busca == 78){
$tipoOS = "Administrativa";
}else{
     $tipoOS = "Operacional";
}

$tabela ="
     <table width=\"100%\" style='font-family:\"sans-serif\", Arial, Helvetica, sans-serif; font-size: 14px'>
<tr>
    <td colspan='3' style='font-size: 20px; color:#FF8544'><strong>Ordens de Serviço ".$tipoOS.".</strong></td>
  </tr>
  <tr>
    <td><strong>Operador: ".$_SESSION["nome"]."</strong></td>
  </tr>
</table>


          <table style='font-family:\"sans-serif\", Arial, Helvetica, sans-serif; font-size: 14px; padding: 6px' >
          <thead style='background-color:#FF8544;border:10px solid; border-color:#FF8544; color:#fff;'>
          <tr style='border-bottom:10px solid #fff'>
          <th>Cod.</th>
          <th>Cliente</th>
          <th>Aberta em</th>
          <th>Solicitada por</th>
          <th>Aberta por</th>
          </thead>
          </tr>";

          $conta =0;
            
          while($os = sqlsrv_fetch_array($listaDeOs)){
          $conta = $conta + 1;

        $linha = "";

           if (date("Y/m/d", strtotime($os["os_data_ini"])) < date('Y/m/d', strtotime("-7 days"))) {
        $linha = "<tr style='border-bottom:8px solid #fff; border-top:1px solid #E7EBF1; background-color:#FBD9E6 '\">";
          	}else if (date("Y/m/d", strtotime($os["os_data_ini"])) < date('Y/m/d', strtotime("-3 days"))) {
        $linha = "<tr style='border-bottom:8px solid #fff; border-top:1px solid #E7EBF1; background-color:#FFFFB9 '\">";
           }else{
        $linha = "<tr style='border-bottom:8px solid #fff; border-top:1px solid #E7EBF1; background-color:#F5F5F5'>";
          	}


       	$linha = $linha.
          "
          <td><strong style='font-size:12px; color:#F93'>".$os["os_id"]."</strong></td>
          <td>".$os['cli_codigo'].' - '.$os['cli_nome']."</td>
          <td>".date("Y/m/d H:m", strtotime($os["os_data_ini"]))."</td>
          <td>".$os["os_solicitada_por"]."</td>
          <td>".$os["os_expedidor"]."</td>
          </tr>
          <tr>
          <td></td>
          <td colspan='4'>".$os["os_serv_sol"]."</td>
          <p><p>
          </tr>
          ";

          $dados = $dados.$linha;
               

           }
           $dados = $tabela.$dados."</table>";
           ?>
          </table>
          </form>
          <hr>
          <form class="form-inline" method="post" action="../mail/mail.php">
          <input style="visibility:hidden;" name="tipoOS" type="text" id="tipoOS" value="<?php echo $tipoOS ?>"/>
          <textarea style="visibility:hidden;" name="dados" id="dados"><?php echo $dados ?> </textarea>
          <div>Selecione o Turno</div>
          <select class="form-control" name="turno" id="turno">
          <option value="1">06:00 até 18:00</option>
          <option value="2">18:00 até 06:00</option>
          </select>
          <div class="form-group has-feedback">
          <input class="btn btn-warning" name="submit" type="submit" id="busca" value="Enviar E-mail"/>
          </div>
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
