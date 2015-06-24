<?php
session_start();
$server = $_SERVER['SERVER_NAME']; 
$endereco = $_SERVER ['REQUEST_URI'];
$_SESSION["link"] = "http://" . $server . $endereco;

if($_SESSION["idusuario"]==NULL){
header('Location: ../login/login.php?acao=5&tipo=2');
}
$localizacao = $_GET['localizacao'];
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
<link rel="stylesheet" href="../../css/jquery-ui.css" />
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding-top: 25px
      }
      #panel {
        position: absolute;
        top: 55px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

  </head>
<body onLoad="initialize(), codeAddress()">  

  <?php include_once("../../view/menu/menu.php");?>
  
     <div id="panel">
      <input id="address" type="hidden" value="<?php echo $localizacao ?>">
      <a href='javascript:history.back(1)' class="btn btn-success btn-large"> Voltar para tela anterior </a>
    </div>
    <div id="map-canvas"></div>

    
<script src="../../js/bootstrap.min.js"></script> 
<script src="../../js/maps.js"></script> 
  </body>
</html>