<?php
include_once("../../functions/functions.class.php");
$functions	= new Functions;	
?>
    <title>FORTRESS - Gerenciamento de Ve&iacute;culos</title>


    <!-- Fixed navbar -->
    
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
      <img class="brand" src="../../img/assinatura.png" alt="" style="width:200px;">
        </div>
        <div class="collapse navbar-collapse">
             <?php
                $functions->geraMenu($_SESSION["nivuser"]);
            ?>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    
    <script src="../../js/jquery.min.js"></script>
