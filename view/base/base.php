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
<?php include_once("../../view/menu/menu.php");?>
<div class="container"> 
  
  <!-- Título -->
  <blockquote>
    <h2>Bem-vindo</h2>
    <small>Confira abaixo os serviços pendentes.</small></blockquote>
  
  <!-- Título -->
  <blockquote>
    <h2>Outras OS</h2>
    <small>Confira abaixo as Ordens de Serviço concluidas</small></blockquote>
  <hr>
  <?php include_once("../../view/footer/footer.php");?>
</div>
<!-- /container --> 

<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
<script src="../../js/jquery-ui.js"></script> 

<script>
        $(document).ready(function(){
         
         $('#contact-form').validate(
         {
          rules: {
            login: {
              minlength: 2,
              required: true
            },
            senha: {
              required: true,
              email: true
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
