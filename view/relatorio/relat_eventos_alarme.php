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
require_once("../../model/cliente.class.php");
include_once("../../functions/functions.class.php");

$codigoCliente = (isset($_POST['codigoCliente']))? $_POST['codigoCliente']:'';
$codigoEventos = (isset($_POST['codigoEventos']))? $_POST['codigoEventos']:'';
$dataini = (isset($_POST['dataini']))? $_POST['dataini']:'01'.date('/m/Y');
$datafin = (isset($_POST['datafin']))? $_POST['datafin']:date('d/m/Y');

$functions	= new Functions;		
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
      <?php include_once("../../view/menu/menuRelatorio.php"); ?>
        <div class="container-fluid">
        <div class="side-body body-slide-out">
        <blockquote>
        <h2>Relatório de Evendos de Alarme</h2>
        <small>Abaixo é listado os Eventos recebidos dos Clientes de Alarme.</small> 
        </blockquote>
		<!-- Mensagem de Retorno -->
		<?php
		if(!empty($_GET["tipo"])){
		$functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
		}
		?>
		
        <div class="row">
            <form class="navbar-form navbar-left" id="contact-form" action="relat_eventos_alarme.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" class="form-control" name="dataini" id="dataini" value="<?php echo $dataini ?>" data-date="12/02/2014" data-date-format="dd/mm/yyyy">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="datafin" id="datafin" value="<?php echo $datafin?>" data-date="12/02/2014" data-date-format="dd/mm/yyyy">
                </div>
                <div class="form-group">
                        <input class="form-control" type="hidden" name="codigoCliente" id="codigoCliente" value="">
                        <input type="button" id="btSelecionar" class="btn btn-primary" data-toggle="modal" data-target="#modalClientes" data-whatever="@getbootstrap" onclick="defineVariaveisClientes()" value="Selecionar Clientes">
                </div>
                <div class="form-group">
                        <input class="form-control" type="hidden" name="codigoEventos" id="codigoEventos" value=""> 
                        <input type="button" id="btSelecionarEventos" class="btn btn-primary" data-toggle="modal" data-target="#modalEventos" data-whatever="@getbootstrap" onclick="defineVariaveisEventos()" value="Selecionar Eventos">
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-warning btn-large" value="Buscar" name="submit">
                </div>
            </form>
        </div>
			
		<?php
        $controller = new RelatorioController();
		$registros 	= $controller->listaEventosDeAlarme($dataini,$datafin,$codigoCliente,$codigoEventos);
		if($registros){
		?>
		<!-- Lista -->
		<table id="tabela" class="tablesorter table table-hover table-striped">
		<thead>
		<tr>
		<th class="iconorder">Cód. Cliente  </th>
		<th class="iconorder">Cliente</th>
		<th class="iconorder">Cód Evento  </th>
		<th class="iconorder">Evento</th>
		<th class="iconorder">Setor ou Usuário  </th>
		<th class="iconorder">Quantidade do Evento  </th>
		</tr>
		</thead>
		<tbody>
		<?php
        $conta = 0;
		while($reg = sqlsrv_fetch_array($registros)){
			$conta = $conta + 1;
		?>
		<tr>
		<td><?php echo $reg["eve_codigo_cliente"]; ?></td>
		<td><?php echo $reg["cli_nome"]; ?></td>
		<td><?php echo $reg["eve_codigo_evento"]; ?></td>
		<td><?php echo $reg["evento_descricao"]; ?></td>
		<td><?php echo $reg["eve_usuario_zona"]; ?></td>
		<td><?php echo $reg["Quantidade"]; ?></td>

		</tr>
		<?php
		}
		?>

		</tbody>
		</table>
		<div><strong>Total de linhas: <?php echo $conta; ?></strong></div>
		
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

<!--modal Selecionar Clientes-->   

<div class="modal fade bs-example-modal-lg" id="modalClientes" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
            <!-- Título -->
            <h4 class="modal-title" id="gridSystemModalLabel">Selecionar Clientes</h4>
        </div>
        <div class="modal-body">
            <form id="form-pesquisa" action="" method="post">
                <div id="divSelecionados" style="display:none" class="panel panel-success" >
                    <div class="panel-heading">
                    <h3 class="panel-title">Clientes Selecionados</h3> 
                    </div>
                   <div id="campoPai" class="panel-body">
                        <button type="button" style="float: right" class="btn btn-danger" data-dismiss="modal" onclick="limparArray()">Limpar</button>
                        <button type="button" style="float: right" class="btn btn-success" data-dismiss="modal">OK</button>
                   </div>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                    Selecione abaixo os Clientes para a pesquisa de Eventos de alarme.
                    </div>
                    <div class="panel-footer">
                    <input class="form-control" name="pesquisa" id="pesquisa" placeholder="Digite o Código ou nome do Cliente para Filtrar">
              
                    <br>
                    <div class="resultados"> </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
        </div>
    </div>
   </div>
 </div>

<!--modal Selecionar Eventos de Alarme-->   
 <div class="modal fade bs-example-modal-lg" id="modalEventos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
            <!-- Título -->
            <h4 class="modal-title" id="gridSystemModalLabel">Selecionar Eventos</h4>
        </div>
        <div class="modal-body">
            <form id="form-pesquisaEventos" action="" method="post">
                <div id="divSelecionadosEventos" style="display:none" class="panel panel-success" >
                    <div class="panel-heading">
                    <h3 class="panel-title">Eventos Selecionados</h3> 
                    </div>
                   <div id="campoPaiEventos" class="panel-body">
                        <button type="button" style="float: right" class="btn btn-danger" data-dismiss="modal" onclick="limparArray()">Limpar</button>
                        <button type="button" style="float: right" class="btn btn-success" data-dismiss="modal">OK</button>
                   </div>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                    Selecione abaixo os Eventos para a pesquisa.
                    </div>
                    <div class="panel-footer">
                    <input class="form-control" name="pesquisaEventos" id="pesquisaEventos" placeholder="Digite o Código ou nome do Evento para Filtrar">
              
                    <br>
                    <div class="resultadosEventos"> </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
        </div>
    </div>
   </div>
 </div>


        <!--Fim modal Selecionar Clientes -->

		  </div>
		<!-- /container --> 
		   
         <!-- Javascript --> 

    <script src="../../js/jquery.validate.min.js"></script> 
    <script src="../../js/bootstrap-datepicker.js"></script> 
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.tablesorter.js"></script>
    <script src="../../js/geral.js"></script>



    <script type="text/javascript">
        function defineVariaveisClientes() {
            nomeObjetoSelecionado = "Clientes Selecionados!";
            campoPai="campoPai";
            divSelecionados="divSelecionados";
            btSelecionar= "btSelecionar";
            codigo = "codigoCliente";
            resultados = "resultados";
            pesquisa = "#pesquisa";
            filho = "filhoCliente";
            array.length = 0;
            string = document.getElementById(codigo).value;
            array = string.split(",");

            listaBancoDeDados('buscaInst.class.php');
        }

        function defineVariaveisEventos() {
            nomeObjetoSelecionado = "Eventos Selecionados!";
            campoPai="campoPaiEventos";
            divSelecionados="divSelecionadosEventos";
            btSelecionar= "btSelecionarEventos";
            codigo = "codigoEventos";
            resultados = "resultadosEventos";
            pesquisa = "#pesquisaEventos";
            filho = "filhoEvento";
            array.length = 0;
            string = document.getElementById(codigo).value;
            array = string.split(",");

            listaBancoDeDados('buscaAlarmeInst.class.php');

       }

        </script>

        <?php
            if(!$codigoCliente == NULL){
                    $codigoCliente = substr($codigoCliente, 1);
                    $listCliente = explode(',', $codigoCliente);
                

                if(count($listCliente) > 0){
                    echo "<script type=\"text/javascript\">  defineVariaveisClientes();";
                    foreach ($listCliente as $c) {
                        
            echo "addArray(".$c.");";

                    }
                    echo "imprimeArray();</script>";
                }
            }
                        if(!$codigoEventos == NULL){
                    $codigoEventos = substr($codigoEventos, 1);
                    $listEvento = explode(',', $codigoEventos);
                

                if(count($listEvento) > 0){
                    echo "<script type=\"text/javascript\">  defineVariaveisEventos();";
                    foreach ($listEvento as $e) {
                        
            echo "addArray('".$e."');";

                    }
                    echo "imprimeArray();</script>";
                }
            }
        ?>
    

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
    
    <script type="text/javascript">
        $(document).ready(function() { 
        $("#tabela").tablesorter()
        });
    </script>

		</body>
		</html>