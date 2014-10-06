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
include_once("../../functions/functions.class.php");
include_once("../../functions/query.class.php");

$empresa = (isset($_POST['empresa']) )? $_POST['empresa']:'';
$cidade = (isset($_POST['cidade']) )? $_POST['cidade']:'';

$controller = new RelatorioController();
$query = new Query();

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
<link rel="stylesheet" href="../../css/jquery-ui.css" />
</head>
<body>
<?php include_once("../../view/menu/menu.php");?>
<div class="container"> 
  
  <!-- Título -->
  <blockquote>
    <h2>Relatórios de Clientes</h2>
    <small>Confira abaixo os informações relacionadas aos clientes.</small></blockquote>
    <div class="row">
  <form class="navbar-form navbar-left" id="contact-form" action="cliente.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <select class="form-control" name="cidade">
        <option value="">Selecione uma Cidade</option>
        <?php
	  				$listaCidade = $query->listaCidades();
                	while($listaCidades = sqlsrv_fetch_array($listaCidade)){
				?>
        <option value="<?php echo $listaCidades["cli_cidade"]?>" <?php echo ($listaCidades["cli_cidade"] == $cidade) ? 'Selected' : '' ?> ><?php echo ($listaCidades["cli_cidade"])?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <select class="form-control" name="empresa">
        <option value="">Selecione uma Empresa</option>
        <?php
	  				$listaEmpresa = $query->listaEmpresa();
                	while($listaEmpresas = sqlsrv_fetch_array($listaEmpresa)){
						$nomeEmpresa = '';
						if($listaEmpresas["cli_empresa"] == 'Guardian'){$nomeEmpresa="Fortress Guardian";}
						if($listaEmpresas["cli_empresa"] == 'ASA'){$nomeEmpresa="Eletrônica ASA";}
						if($listaEmpresas["cli_empresa"] == 'nm'){$nomeEmpresa="Não Monitorado";}
						if(!$nomeEmpresa){$nomeEmpresa=$listaEmpresas["cli_empresa"];}
				?>
        <option value="<?php echo $listaEmpresas["cli_empresa"]?>" <?php echo ($listaEmpresas["cli_empresa"] == $empresa) ? 'Selected' : '' ?>><?php echo ($nomeEmpresa)?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
    <input type="submit" class="btn btn-warning btn-large" value="Buscar" name="submit">
    </div>
  </form>
  </div>
  <div class="row">
  <?php
			$qtdClientesCidades = $controller->listaQtdClientes($empresa,$cidade);
			$row_count = sqlsrv_num_rows( $qtdClientesCidades );
		
			if ($row_count > 0){

	?>
    
  <table class="table table-striped table-hover table-condensed" width="200" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th><b>Cidade</b></th>
        <th><b>Empresa</b></th>
        <th><b>QTD Clientes</b></th>
      </tr>
    </thead>
    <?php	
						$totalQuantidadeClientes ='';
                	while($qtdClientes = sqlsrv_fetch_array($qtdClientesCidades)){
						$totalQuantidadeClientes = $totalQuantidadeClientes+$qtdClientes["quantidade"];
						$nomeEmpresa = '';
						if($qtdClientes["cli_empresa"] == 'Guardian'){$nomeEmpresa="Fortress Guardian";}
						if($qtdClientes["cli_empresa"] == 'ASA'){$nomeEmpresa="Eletrônica ASA";}
						if($qtdClientes["cli_empresa"] == 'nm'){$nomeEmpresa="Não Monitorado";}
						if(!$nomeEmpresa){$nomeEmpresa=$qtdClientes["cli_empresa"];}


				?>
    <tr onClick="location.href='../cliente/lista.php?cidade=<?php echo $qtdClientes['cli_cidade'];?>&empresa=<?php echo $qtdClientes['cli_empresa']?>'">
      <td><?php echo $qtdClientes["cli_cidade"]; ?></td>
      <td><?php echo $nomeEmpresa ?></td>
      <td><?php echo $qtdClientes["quantidade"]; ?></td>
    </tr>
    <?php } ?>
    <tr class="info">
      <td><b>Total</b></td>
      <td></td>
      <td><b><?php echo $totalQuantidadeClientes; ?></b></td>
    </tr>
  </table>
  
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
  <?php include_once("../../view/footer/footer.php");?>
</div>
<!-- /container --> 

<!-- Javascript --> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
<script src="../../js/jquery-ui.js"></script>
</body>
</html>
