<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

include_once("../../functions/functions.class.php");
$functions	= new Functions;

if (isset($_GET["login"]) ||  isset($_GET["senha"])){
   
  require_once("../../controller/login.controller.class.php");
		  
	$loginController = new LoginController;
	 
	$result = $loginController->autentica($_GET['login'],$_GET['senha'],$_GET['acesso']);
	$quantidadeDeDados = sqlsrv_num_rows($result);
	
	
	if (!$quantidadeDeDados == false) {        
		$usuario = sqlsrv_fetch_array($result);
		
		//echo "O código do usuário é: ". $usuario["id"];

		//Declara as variáveis de sessão que serão utilizadas no sistema
		session_start();
		$_SESSION["idusuario"] 	= $usuario["log_id"];
		$_SESSION["nome"] 			= $usuario["log_nome"];
		$_SESSION["nivuser"] 		= $usuario["log_nivel"];
    $_SESSION["ip"]         = $_SERVER['REMOTE_ADDR'];
		
		
		//Grava o log de acesso
		//$logDeAcessoController = new LogDeAcessoController();
		//$logDeAcesso = new LogDeAcesso();
		//$logDeAcesso->setUsuario_id($usuario["id"]);
		//$logDeAcesso->setDataAcesso(date('Y/m/d H:i:s'));
		//$logDeAcessoController->save($logDeAcesso);
		
    if(!$_SESSION["link"] == NULL){
        header("Location: ".$_SESSION["link"]);
    }else{
		//Sucesso, redireciona para a tela principal
		header("Location: ../home/home.php");
    }
	}else{
		//Erro, redireciona para a tela de login novamente
		header("Location: login.php?acao=5&tipo=2'");
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
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/geral.css" rel="stylesheet">
<link href="../../css/validation.css" rel="stylesheet">
<link rel="stylesheet" href="../../css/jquery-ui.css" />
</head>

<body>
<div class="container" align="center">
  <div class="panel panel-default" style="width:350px;">
    <form class="login-form" id="login-form" action="login.php" method="get">
        <div class="panel-body"> <img src="../../img/logo.png" alt="Fortress Mecatrônica" style="width:240px;">
          <p>&nbsp;</p>
          <input type="text" class="form-control" name="login" id="login" placeholder="Usuário" style="width:80%;" autofocus required><br>
          <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" style="width:80%;" required>
        </div>
        <div class="panel-footer">
          <button type="submit" class="btn btn-success btn-large">Entrar</button>
        </div>
    </form> 
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

  </div>
</div>

<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
<script src="../../js/jquery-ui.js"></script> 
<script>
        $(document).ready(function(){
         
         $('#login-form').validate(
         {
          rules: {
            login: {
              minlength: 2,
              required: true,
            },
            senha: {
              required: true,
            }
          },
          highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
          },
          success: function(element) {
            element
            .text('OK!').addClass('valid')
            .closest('.control-group').removeClass('error').addClass('success');
          }
         });
        });
        </script>
</body>
</html>
