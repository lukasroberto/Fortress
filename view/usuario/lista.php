<?php

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
 
require_once("../../controller/usuario.controller.class.php");
require_once("../../model/usuario.class.php");

include_once("../../functions/functions.class.php");

$usuario 	= new UsuarioController;

session_start();
$registros 	= $usuario->listObjectsGroup();
$functions	= new Functions;

$id = ( isset($_GET['idusuario']) ) ? $_GET['idusuario'] : 0;

if ($id > 0) {
	if($_SESSION["nivuser"]==1){
		$load = $usuario->remove($id, 'log_id');
		header('Location: lista.php?acao=3&tipo=1');
	}else{
		header('Location: lista.php?tipo=2');
	}
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
    <h2>Gerenciar Usuários</h2>
    <small>Utilize os campos abaixo para cadastrar ou editar usuários</small> </blockquote>
  
  <!-- Mensagem de Retorno -->
  <?php
        if(!empty($_GET["tipo"])){
			if(!empty($_GET["acao"])){
        	$functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
			}else{
			$functions->mensagemDeRetornoPersonalizada($_GET["tipo"],"Você não tem Permissão para editar ou exluir este usuário! Contate o Administrador em caso de duvidas.");
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
  <hr>
  <div class="control-group">
    <div class="controls"> <a href="edita.php" class="btn btn-primary btn-large">Cadastrar um novo Usuário</a> </div>
  </div>
  <?php
        if($registros){
		?>
  <!-- Lista -->
  <table class="table table-hover table-striped">
    <thead>
      <tr>
        <th>Código</th>
        <th>Nome</th>
        <th>Login</th>
        <th>Tipo de Usuário</th>
        <th style="text-align:center">Acesso ao Sistema</th>
        <th style="text-align:center"><i class="glyphicon glyphicon-edit"></i></th>
        <th style="text-align:center"><i class="glyphicon glyphicon-remove-circle"></i></th>
      </tr>
    </thead>
    <tbody>
      <?php
                	while($reg = sqlsrv_fetch_array($registros)){
						if($reg["log_nivel"] == 1){$tipo="Administrador";}
						if($reg["log_nivel"] == 2){$tipo="Gerenciador de OS";}
						if($reg["log_nivel"] == 3){$tipo="Leitor de OS";}
				?>
      <tr>
        <td><?php echo $reg["log_id"]; ?></td>
        <td><?php echo $reg["log_nome"]; ?></td>
        <td><?php echo $reg["log_user"]; ?></td>
        <td><?php echo $tipo; ?></td>
        <td style="text-align:center"><?php echo ($reg["log_acesso_sistema"] == 0 ) ? '<div style="color:#C00">Não</div>' : '<div style="color:#0C0">Sim</div>' ; ?></td>
        <td style="text-align:center"><a type="button" title="Editar" href="edita.php?idusuario=<?php echo $reg["log_id"]; ?>"><i class="glyphicon glyphicon-edit"></i></a></td>
        <td style="text-align:center"><a type="button" data-toggle="modal" title="Excluir" href="lista.php?idusuario=<?php echo $reg["log_id"]; ?>"><i class="glyphicon glyphicon-remove-circle"></i></a></td>
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
<script>
  $(function() {  
    $('#btnEnviar').click(function(){  
      $('#mensagem_ola').html('Olá, '+$('#txtNome').val());  
      $('#modal').dialog("close");  
    });  
  });  
  </script>
</body>
</html>