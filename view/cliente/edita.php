<?php 
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

session_start();
if($_SESSION["idusuario"]==NULL){
	 header('Location: ../login/login.php?acao=5&tipo=2');
}
ini_set('date.timezone', 'America/Sao_Paulo');
require_once("../../controller/cliente.controller.class.php");
require_once("../../model/cliente.class.php");
include_once("../../functions/functions.class.php");

$controller = new ClienteController();
$cliente = new Cliente();
$functions	= new Functions;

if(isset($_POST['submit'])) {

	$cliente->setCodigo($_POST['codigo']);
	$cliente->setNome($_POST['nome']);
	$cliente->setNumero($_POST['numero']);
	$cliente->setRua($_POST['rua']);
	$cliente->setBairro($_POST['bairro']);
	$cliente->setCidade($_POST['cidade']);
	$cliente->setEmpresa($_POST['empresa']);
	$cliente->setEstado($_POST['estado']);
	$cliente->setTelefone($_POST['tel']);
	$cliente->setTelefonSecundario($_POST['tel-secundario']);
	$cliente->setMonitorado($_POST['monitorado']);
//$cliente->setObs($_POST['obs']);
 	$cliente->setUltimaComunicacao('2015-06-01 00:00:00.000');
  if($_POST['monitorado'] == "False"){
      $cliente->setCliDataCanceladoMon(date('d/m/y H:i:s'));
  }
	$cliente->setCadastradoPor($_SESSION["nome"]);


	$operaçao = $_POST['update'];
	if($operaçao == "update"){
		if($_SESSION["nivuser"]==1 || $_SESSION["nivuser"]==2){
			$controller->update($cliente, 'cli_codigo',$cliente->getCodigo());
      header('Location: lista.php?tipo=1&acao=2');
		}else{
		header('Location: lista.php?tipo=2');
		}
	}else{
		$controller->save($cliente);
		header('Location: lista.php?acao=1&tipo=1');
	}

}

if(isset($_GET['clicodigo'])){
	$cliente = $controller->loadObject($_GET['clicodigo'], 'cli_codigo');
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

<body onload="initialize()">
<?php include_once("../../view/menu/menu.php");?>
<div class="container"> 
  
  <!-- Título -->
  <blockquote>
    <h2>Edição de Clientes</h2>
    <small>Utilize o formulário abaixo para cadastrar ou editar Clientes</small> </blockquote>
  
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
      <div class="form-group">
        </input>
        <label for="codigo">Código</label>
        <input class="form-control" type="hidden" name="update" id="update" value="<?php if(!empty($_GET["operacao"]))echo"update"; ?>">
        <input name="codigo" required type="text" class="form-control" id="codigo" value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getCodigo() : ''; ?>">
      </div>
      <div class="form-group">
        <label for="nome">Nome Completo</label>
        <input class="form-control" type="text" name="nome" id="nome" required value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getNome() : ''; ?>">
      </div>
      <div class="form-group">
        <label for="empresa">Empresa</label>
        <select class="form-control" name="empresa"id="empresa" required>
          <option value="">Selecionar</option>
          <option value="8" <?php echo ($cliente->getCodigo() > 0 && $cliente->getEmpresa() == '8') ? 'Selected' : ''; ?>>Eletrônica ASA</option>
          <option value="3" <?php echo ($cliente->getCodigo() > 0 && $cliente->getEmpresa() == '3') ? 'Selected' : ''; ?>>Fortress</option>
          <option value="6" <?php echo ($cliente->getCodigo() > 0 && $cliente->getEmpresa() == '6') ? 'Selected' : ''; ?>>Logus</option>
        </select>
      </div>
           <div class="form-group">
        <label for="monitorado">Cliente Monitorado</label>
        <select class="form-control" name="monitorado"id="monitorado" required>
                  <option value="">Selecionar</option>
          <option value="True" <?php echo ($cliente->getMonitorado() == true) ? 'Selected' : ''; ?>>Monitorado</option>
          <option value="False" <?php echo ($cliente->getMonitorado() == false) ? 'Selected' : ''; ?>>Não Monitorado</option>
        </select>
      </div>
      <div class="form-group">
        <label for="tel">Telefone</label>
        <input class="form-control" type="text" name="tel" id="tel"  value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getTelefone() : ''; ?>">
      </div>
      <div class="form-group">
        <label for="tel-secundario">Telefone 2</label>
        <input class="form-control" type="text" name="tel-secundario" id="tel-secundario"  value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getTelefoneSecundario() : ''; ?>">
      </div>
      <div class="form-group">
        <label for="autocomplete">Buscar endereço</label>
        <input class="form-control" type="text" id="autocomplete" placeholder="Digite o endereço, Ex: America Galo Olandesi, São João..." onFocus="geolocate()" style="background-color:#D5F1FF">
      </div>
      <div class="form-group">
        <label for="locality">Cidade</label>
        <select class="form-control" name="cidade" id="locality" required>
          <option value="">Selecione a Cidade</option>
          <option value="Andradas" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Andradas') ? 'Selected' : ''; ?>>Andradas</option>
          <option value="Aguaí" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Aguaí') ? 'Selected' : ''; ?>>Aguaí</option>
          <option value="Águas da Prata" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Águas da Prata') ? 'Selected' : ''; ?>>Águas da Prata</option>
          <option value="Casa Branca" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Casa Branca') ? 'Selected' : ''; ?>>Casa Branca</option>
          <option value="Espírito Santo do Pinhal" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Espírito Santo do Pinhal') ? 'Selected' : ''; ?>>Espírito Santo do Pinhal</option>
          <option value="Mogi Guaçu" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Mogi Guaçu') ? 'Selected' : ''; ?>>Mogi Guaçu</option>
          <option value="Mogi Mirim" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Mogi Mirim') ? 'Selected' : ''; ?>>Mogi Mirim</option>
          <option value="Poços de Caldas" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Poços de Caldas') ? 'Selected' : ''; ?>>Poços de Caldas</option>
          <option value="Santo Antônio do Jardim" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Santo Antônio do Jardim') ? 'Selected' : ''; ?>>Santo Antônio do Jardim</option>
          <option value="São João da Boa Vista" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'São João da Boa Vista') ? 'Selected' : ''; ?>>São João da Boa Vista</option>
          <option value="São José do Rio Pardo" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'São José do Rio Pardo') ? 'Selected' : ''; ?>>São José do Rio Pardo</option>
          <option value="Sorocaba" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Sorocaba') ? 'Selected' : ''; ?>>Sorocaba</option>
          <option value="Mococa" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Mococa') ? 'Selected' : ''; ?>>Mococa</option>
          <option value="Arceburgo" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Arceburgo') ? 'Selected' : ''; ?>>Arceburgo</option>
          <option value="São Sebastião da Grama" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'São Sebastião da Grama') ? 'Selected' : ''; ?>>São Sebastião da Grama</option>
          <option value="Itobi" <?php echo ($cliente->getCodigo() > 0 && $cliente->getCidade() == 'Itobi') ? 'Selected' : ''; ?>>Itobi</option>

        </select>
      </div>
      <div class="form-group">
        <label for="sublocality">Bairro</label>
        <input class="form-control" type="text" name="bairro" id="sublocality" required value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getBairro() : ''; ?>">
      </div>
      <div class="form-group">
        <label for="route">Rua</label>
        <input class="form-control" type="text" name="rua" id="route" required value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getRua() : ''; ?>">
      </div>
      <div class="form-group">
        <label for="street_number">Número</label>
        <input class="form-control"type="text" name="numero" id="street_number" value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getNumero() : ''; ?>">
      </div>
      <div class="form-group">
        <label for="administrative_area_level_1">Estado</label>
        <input class="form-control" type="text" name="estado" id="administrative_area_level_1" required value="<?php echo ($cliente->getCodigo() > 0 ) ? $cliente->getEstado() : ''; ?>">
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
<script src="../../js/endereco.js"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
</body>
</html>