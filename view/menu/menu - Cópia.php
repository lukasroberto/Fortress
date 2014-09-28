<?php
include_once("../../functions/functions.class.php");
$functions	= new Functions;	
?><head>
<title>FORTRESS - Gerenciamento de Ve&iacute;culos</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
</head>



<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <img class="brand" src="../../img/assinatura_tanbook.png" alt="" style="width:200px;">
      <div class="nav-collapse collapse">
        <?php
                $functions->geraMenu($_SESSION["nivuser"]);
            ?>
      </div>
      <!--/.nav-collapse --> 
    </div>
  </div>
</div>
