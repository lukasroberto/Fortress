					<?php
					
					ini_set('display_errors', 1);
					ini_set('log_errors', 1);
					ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
					error_reporting(E_ALL);
					
					session_start();
					if($_SESSION["idusuario"]==NULL){
					header('Location: ../login/login.php?acao=5&tipo=2');
					}
					
					require_once("../../controller/cliente.controller.class.php");
					require_once("../../model/cliente.class.php");
					
					include_once("../../functions/functions.class.php");
					
					$cliente 	= new ClienteController;
					$functions	= new Functions;
					
					$filtro  = (isset($_POST['filtro']) )? $_POST['filtro']:'';
					$coluna  = (isset($_POST['coluna']) )? $_POST['coluna']:'';
					$cidade  = (isset($_GET['cidade']) )? $_GET['cidade']:'';
					$empresa = (isset($_GET['empresa']) )? $_GET['empresa']:'';
					$monitorado = (isset($_GET['monitorado']) )? $_GET['monitorado']:'';
					//$order = (isset($_GET['order']) )? $_GET['order']:'cli_codigo';
					
					
					if(isset($_POST['submit'])) {
					
					$registros 	= $cliente->listObjectsGroup($coluna,$filtro);
					
					}else{
					$registros 	= $cliente->listObjectsGroup($coluna,$filtro);
					}
					
					if(isset($_GET['monitorado'])) {
					
					$registros 	= $cliente->listaClientesDoRelatorio($cidade,$empresa,$monitorado);
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
					<h2>Gerenciar Clientes</h2>
					<small>Utilize os campos abaixo para gerenciar os Clientes.</small> </blockquote>
					
					<!-- Mensagem de Retorno -->
					<?php
					if(!empty($_GET["tipo"])){
					if(!empty($_GET["acao"])){
					$functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
					}else{
					$functions->mensagemDeRetornoPersonalizada($_GET["tipo"],"Você não tem Permissão para editar ou exluir este Cliente! Contate o Administrador em caso de duvidas.");
					}
					}
					?>
					
					<!-- Confirma excluir -->
					<?php
					$id = ( isset($_GET['clicodigo']) ) ? $_GET['clicodigo'] : 0;
					
					if ($id > 0) {
					if($_SESSION["nivuser"]==1){
					?>
					<div class="alert alert-danger text-center">
					<h3>Deseja exluir este Cliente?</h3>
					<a href="lista.php?clicodigo=<?php echo $id?>&confirma=SIM" class="btn btn-success btn-large">Sim, desejo excluir este Cliente!</a>&nbsp;&nbsp; <a href="lista.php" class="btn btn-warning btn-large">Não exluir este Cliente.</a> </div>
					<?php		
					if(isset($_GET['confirma'])=="SIM"){
					$load = $cliente->remove($id, 'cli_codigo');
					header('Location: lista.php?acao=3&tipo=1');
					}
					}else{
					header('Location: lista.php?tipo=2');
					}
					}
					?>
					
					<!--
					<div class="tabbable">
					<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1" data-toggle="tab">Busca simples</a></li>
					<li><a href="#tab2" data-toggle="tab">Busca avançada</a></li>
					</ul>
					<div class="tab-content">
					<div class="tab-pane active" id="tab1">
					<blockquote>
					<h4>Busca simples</h4>
					<small>Utilize os campos abaixo para cadastrar o usuário</small>
					</blockquote>
					</div>
					<div class="tab-pane" id="tab2">
					<blockquote>
					<h4>Busca avançada</h4>
					<small>Utilize os campos abaixo para cadastrar o usuário</small>
					</blockquote>
					</div>
					</div>
					</div>
					-->
					<form class="navbar-form navbar-left" id="contact-form" action="#" method="post" enctype="multipart/form-data">
					<div class="form-group">
					<select class="form-control" name="coluna">
					<option value="cli_codigo" <?php echo (isset($coluna) && $coluna == 'cli_codigo') ? 'Selected' : ''; ?>>Código</option>
					<option value="cli_nome" <?php echo (isset($coluna) && $coluna == 'cli_nome') ? 'Selected' : ''; ?>>Nome</option>
					<option value="cli_rua" <?php echo (isset($coluna) && $coluna == 'cli_rua') ? 'Selected' : ''; ?>>Endereço</option>
					<option value="cli_cidade" <?php echo (isset($coluna) && $coluna == 'cli_cidade') ? 'Selected' : ''; ?>>Cidade</option>
					<option value="cli_bairro" <?php echo (isset($coluna) && $coluna == 'cli_bairro') ? 'Selected' : ''; ?>>Bairro</option>
					<option value="cli_telefone" <?php echo (isset($coluna) && $coluna == 'cli_telefone') ? 'Selected' : ''; ?>>Telefone</option>
					</select>
					<input class="form-control" placeholder="Filtrar Clientes" type="text" name="filtro" id="filtro" required value="<?php echo ($filtro) ? : $filtro; ?>">
					</div>
					<input type="submit" class="btn btn-warning btn-large" value="Buscar" name="submit">
					<a href="edita.php" class="btn btn-primary btn-large">Cadastrar um novo Cliente</a>
					</form>
					<?php
					if($registros){
					?>
					<!-- Lista -->
					<table id="tabela" class="tablesorter table table-hover table-striped">
					<thead>
					<tr>
					<th class="iconorder">Código   </th>
					<th class="iconorder">Nome</th>
					<th class="iconorder">Rua</th>
					<th class="iconorder">Bairro</th>
					<th class="iconorder">Ult. Comunicação   </th>
					<th class="iconorder">Monitorado   </th>
					<th style="text-align:center"><i class="glyphicon glyphicon-wrench"></i></th>
					<th style="text-align:center"><i class="glyphicon glyphicon-globe"></i></th>
					<th style="text-align:center"><i class="glyphicon glyphicon-pencil"></i></th>
					<th style="text-align:center"><i class="glyphicon glyphicon-trash"></i></th>
					</tr>
					</thead>
					<tbody>
					<?php
					while($reg = sqlsrv_fetch_array($registros)){		
					?>
					<tr>
					<td><?php echo $reg["cli_codigo"]; ?></td>
					<td><?php echo $reg["cli_nome"]; ?></td>
					<td><?php echo $reg["cli_rua"]." - N°". $reg["cli_numero"]; ?></td>
					<td><?php echo $reg["cli_bairro"]; ?></td>
					<td><?php echo $functions->converterData($reg["cli_ultima_comunicacao"],'datetime'); ?></td>

					<?php 
						if ($reg["cli_monitorado"] == true){
							echo $monitorado = "<td style='text-align:center'><strong class='text-success'>Sim</strong></td>";
						}
						else{
							echo $monitorado = "<td style='text-align:center'><strong class='text-danger'>Não</strong></td>";
						}
					?>
					<td style="text-align:center"><a type="button" title="Abrir Ordem de Serviço" class="laranja-os" href="../os/cadastraos.php?clicodigo=<?php echo $reg["cli_codigo"]?>&submit=Buscar"><i class="glyphicon glyphicon-wrench"></i></a></td>
					
					<td style="text-align:center"><a type="button" title="Visualizar no Mapa" class="verdemaps" href="mapa.php?localizacao=<?php echo $reg["cli_rua"].", ".$reg["cli_numero"].", ". $reg["cli_cidade"]?>"><i class="glyphicon glyphicon-globe"></i></a></td>
					
					<td style="text-align:center"><a type="button" title="Editar" href="edita.php?operacao=update&clicodigo=<?php echo $reg["cli_codigo"] ?>"><i class="glyphicon glyphicon-pencil"></i></a></td>
					
					<td style="text-align:center"><a type="button" title="Excluir" class="vermelho-excluir" href="lista.php?clicodigo=<?php echo $reg["cli_codigo"] ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
					</tr>
					<?php
					}
					?>
					</tbody>
					</table>
					
					<!--
					<div class="pagination">
					<ul>
					<li><a href="#">Prev</a></li>
					<li><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li class="active"><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#">6</a></li>
					<li><a href="#">Next</a></li>
					</ul>
					</div>
					-->
					
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
					<?php include_once("../../view/footer/footer.php");?>
					</div>
					<!-- /container --> 
					
					<script src="../../js/jquery.validate.min.js"></script> 
					<script src="../../js/bootstrap.min.js"></script> 
					<script src="../../js/jquery-ui.js"></script>
					<script src="../../js/jquery.tablesorter.js"></script>
					
					<script type="text/javascript">
					$(document).ready(function() { 
					$("#tabela").tablesorter()
					});
					</script>
					</body>
					</html>