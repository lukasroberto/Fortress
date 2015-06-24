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

require_once("../../controller/usuario.controller.class.php");
require_once("../../model/usuario.class.php");

include_once("../../functions/functions.class.php");

$controller = new UsuarioController();
$usuario = new Login();
$functions	= new Functions;

if(isset($_POST['submit'])) {

	$usuario->setId($_POST['idusuario']);
	$usuario->setNome($_POST['nome']);
	$usuario->setUser($_POST['login']);
	$usuario->setSenhaFalada($_POST['senhafalada']);
	$usuario->setAcessoSistema($_POST['acessosistema']);
	$usuario->setSenha($_POST['senha']);
	$usuario->setNivel($_POST['tipodeusuario']);


	if($usuario->getId() > 0){
		if($_SESSION["nivuser"]==1){
			$controller->update($usuario, 'log_id',$usuario->getId());
			header('Location: lista.php?acao=2&tipo=1');
		}else{
		header('Location: lista.php?tipo=2');
		}
	}else{
		$controller->save($usuario, 'log_id');
		header('Location: lista.php?acao=1&tipo=1');
	}

}

if(isset($_GET['idusuario'])){
	$usuario = $controller->loadObject($_GET['idusuario'], 'log_id');
}

$usuarios = $controller->listObjects();


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
    <h2>Edição de Usuários</h2>
    <small>Utilize o formulário abaixo para cadastrar e editar usuários</small> </blockquote>
  
  <!-- Mensagem de Retorno -->
  <?php
        if(!empty($_GET["tipo"])){
		?>
  <section id="aviso">
    <?php
        	$functions->mensagemDeRetorno($_GET["tipo"],$_GET["acao"]);
		?>
  </section>
  <?php
        }
        ?>
        <div style="max-width:400px;">
  <form class="form-horizontal" id="contact-form" action="edita.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idusuario" id="idusuario" value="<?php echo ($usuario->getId() > 0 ) ? $usuario->getId() : ''; ?>">
<div class="form-group">
      <label for="nome">Nome</label>
        <input class="form-control" type="text" name="nome" id="nome" required value="<?php echo ($usuario->getId() > 0 ) ? $usuario->getNome() : ''; ?>">
    </div>
<div class="form-group">
      <label for="login">Login</label>
        <input class="form-control" type="text" name="login" id="login" required value="<?php echo ($usuario->getId() > 0 ) ? $usuario->getUser() : ''; ?>">
    </div>
<div class="form-group">
      <label for="senhafalada">Senha Falada</label>
        <input class="form-control"type="text" name="senhafalada" id="senhafalada" required value="<?php echo ($usuario->getId() > 0 ) ? $usuario->getSenhaFalada() : ''; ?>">
      </div>
<div class="form-group">
      <label for="senha">Senha</label>
        <input class="form-control" type="password" name="senha" id="senha" required value="<?php echo ($usuario->getId() > 0 ) ? $usuario->getSenha() : ''; ?>">
      </div>
<div class="form-group">
      <label for="tipodeusuario">Tipo de Usuário</label>
        <select class="form-control" name="tipodeusuario" id="tipodeusuario">
        <?php if($_SESSION["nivuser"]==1){?>
          <option value="1" <?php echo ($usuario->getId() > 0 && $usuario->getNivel() == '1') ? 'Selected' : ''; ?>>Administrador</option>
        <?php }?>
          <option value="2" <?php echo ($usuario->getId() > 0 && $usuario->getNivel() == '2') ? 'Selected' : ''; ?>>Usuário Gerenciador das OS</option>
          <option value="3" <?php echo ($usuario->getId() > 0 && $usuario->getNivel() == '3') ? 'Selected' : ''; ?>>Leitor (Apenas Cadastra as OS e visualiza Relatórios)</option>
        </select>
      </div>
      <div class="form-group">
      <label for="acessosistema">Acesso ao Sistema</label>
        <select class="form-control" name="acessosistema" id="acessosistema">
          <option value="True" <?php echo ($usuario->getId() > 0 && $usuario->getAcessoSistema() == '1') ? 'Selected' : ''; ?>>Sim - Este usuário pode acessar o Sistema!</option>
          <option value="False" <?php echo ($usuario->getId() > 0 && $usuario->getAcessoSistema() == '0') ? 'Selected' : ''; ?>>Não - Este usuário não pode acessar o Sistema!</option>
        </select>
      </div>
<div class="form-group">
        <input type="submit" class="btn btn-success btn-large" value="Salvar" name="submit">
      </div>
  </form>
  </div>
  <?php include_once("../../view/footer/footer.php");?>
</div>
<!-- /container --> 

<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
<script src="../../js/jquery-ui.js"></script> 
<script src="../../js/tab.js"></script> 

</body>
</html>