<?php 

 
require_once("../../controller/usuario.controller.class.php");
require_once("../../model/usuario.class.php");

include_once("../../functions/functions.class.php");

session_start();

$controller = new UsuarioController();
$usuario = new login();
$functions	= new Functions;

if(isset($_POST['submit'])) {

	//$usuario->setId($_POST['idusuario']);
	$usuario->setNome($_POST['nome']);
	$usuario->setUser($_POST['user']);
	$usuario->setSenha($_POST['senha']);
	$usuario->setSenhaFalada($_POST['senhafalada']);

	//$usuario->setNivel($_POST['tipodeusuario']);

	$controller->update($usuario, 'LOG_ID', $_POST['idusuario']);

}

$usuario = $controller->loadObject($_SESSION["idusuario"], 'LOG_ID');


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
<!-- <link href="../../css/bootstrap.min.css" rel="stylesheet">-->
<link href="../../css/geral.css" rel="stylesheet">
<link href="../../css/validation.css" rel="stylesheet">
<link rel="stylesheet" href="../../css/jquery-ui.css" />
</head>


<body>
<?php include_once("../../view/menu/menu.php");?>

<div class="container"> 
  
  <!-- Título -->
  <blockquote>
    <h2>Gerenciamento de Conta</h2>
    <small>Utilize o formulário abaixo para atualizar sua conta</small> </blockquote>
  
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
  <form role="form" id="contact-form" action="edita.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idusuario" id="idusuario" value="<?php echo ($usuario->getId() > 0 ) ? $usuario->getId() : ''; ?>">
    <div class="form-group">
      <label for="nome">Nome</label>
        <input class="form-control" type="text" name="nome" id="nome" required value="<?php echo ($usuario->getId() > 0 ) ? $usuario->getNome() : ''; ?>">
      </div>
    <div class="form-group">
      <label for="user">Usuário</label>
        <input class="form-control" type="text" name="user" id="user" required value="<?php echo ($usuario->getId() > 0 ) ? $usuario->getUser() : ''; ?>">
      </div>
    <div class="form-group">
      <label for="senha">Senha</label>
        <input class="form-control" type="password" name="senha" id="senha" required value="<?php echo ($usuario->getId() > 0 ) ? $usuario->getSenha() : ''; ?>">
    </div>
        <div class="form-group">
      <label for="senhafalada">Senha falada de Segurança</label>
        <input class="form-control" type="text" name="senhafalada" id="senhafalada" required value="<?php echo ($usuario->getId() > 0 ) ? $usuario->getSenhaFalada() : ''; ?>">
      </div>
    <div class="control-group">
      <div class="controls">
        <input type="submit" class="btn btn-success btn-large" value="Salvar" name="submit">
      </div>
    </div>
  </form>
  </div>
  <?php include_once("../../view/footer/footer.php");?>

</div>
<!-- /container --> 

<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
<script src="../../js/jquery-1.8.2.js"></script> 
<script src="../../js/jquery-ui.js"></script> 
<script src="../../js/jquery.min.js"></script>

<script>
        $(document).ready(function(){
         
         $('#contact-form').validate(
         {

          highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
          },
          success: function(element) {
            element.text('OK!').addClass('valid').closest('.control-group').removeClass('error').addClass('success');
          }
         });
        });
        </script>
</body>
</html>