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

require_once("../../controller/empresa.controller.class.php");
require_once("../../model/empresa.class.php");

include_once("../../functions/functions.class.php");

$controller = new EmpresaController();
$empresa = new Empresa();
$functions	= new Functions;

if(isset($_POST['submit'])) {

	$empresa->setId($_POST['idempresa']);
	$empresa->setRazaoSocial($_POST['razaosocial']);
	$empresa->setEndereco($_POST['endereco']);
	$empresa->setBairro($_POST['bairro']);
	$empresa->setCidade($_POST['cidade']);
	$empresa->setTelefone($_POST['telefone']);
	$empresa->setEmail($_POST['email']);
  $empresa->setCnpj($_POST['cnpj']);
  $empresa->setCep($_POST['cep']);
  $empresa->setUf($_POST['uf']);
  $empresa->setUf($_POST['True']);


	if($empresa->getId() > 0){
			$controller->update($empresa, 'emp_id', $empresa->getId());
			header('Location: lista.php?acao=2&tipo=1');
	}else{
		$controller->save($empresa, 'emp_id');
		header('Location: lista.php?acao=1&tipo=1');
	}

}

if(isset($_GET['idempresa'])){
	$empresa = $controller->loadObject($_GET['idempresa'], 'emp_id');
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
    <h2>Edição de Empresas</h2>
    <small>Utilize o formulário abaixo para cadastrar e editar empresas</small> </blockquote>
  
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
    <input type="hidden" name="idempresa" id="idempresa" value="<?php echo ($empresa->getId() > 0 ) ? $empresa->getId() : ''; ?>">
<div class="form-group">
      <label for="razaosocial">Razao Social</label>
        <input class="form-control" type="text" name="razaosocial" id="razaosocial" required value="<?php echo ($empresa->getId() > 0 ) ? $empresa->getRazaoSocial() : ''; ?>">
    </div>
<div class="form-group">
      <label for="endereco">Endereco</label>
        <input class="form-control" type="text" name="endereco" id="endereco" required value="<?php echo ($empresa->getId() > 0 ) ? $empresa->getEndereco() : ''; ?>">
    </div>
<div class="form-group">
      <label for="bairro">Bairro</label>
        <input class="form-control"type="text" name="bairro" id="bairro" required value="<?php echo ($empresa->getId() > 0 ) ? $empresa->getBairro() : ''; ?>">
      </div>
<div class="form-group">
      <label for="cidade">Cidade</label>
        <input class="form-control" type="text" name="cidade" id="cidade"  value="<?php echo ($empresa->getId() > 0 ) ? $empresa->getCidade() : ''; ?>">
      </div>
      <div class="form-group">
      <label for="telefone">Telefone</label>
        <input class="form-control" type="text" name="telefone" id="telefone"  value="<?php echo ($empresa->getId() > 0 ) ? $empresa->getTelefone() : ''; ?>">
      </div>
      <div class="form-group">
      <label for="email">E-mail</label>
        <input class="form-control" type="text" name="email" id="email"  value="<?php echo ($empresa->getId() > 0 ) ? $empresa->getEmail() : ''; ?>">
      </div>
      <div class="form-group">
      <label for="cnpj">CNPJ</label>
        <input class="form-control" type="text" name="cnpj" id="cnpj" required value="<?php echo ($empresa->getId() > 0 ) ? $empresa->getCnpj() : ''; ?>">
      </div>
      <div class="form-group">
      <label for="cep">CEP</label>
        <input class="form-control" type="text" name="cep" id="cep"  value="<?php echo ($empresa->getId() > 0 ) ? $empresa->getCep() : ''; ?>">
      </div>
      <div class="form-group">
      <label for="uf">UF</label>
        <input class="form-control" type="text" name="uf" id="uf"  value="<?php echo ($empresa->getId() > 0 ) ? $empresa->getUf() : ''; ?>">
      </div>
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