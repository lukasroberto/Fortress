<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

session_start();
if($_SESSION["idusuario"]==NULL){
	 header('Location: ../login/login.php?acao=5&tipo=2');
}

include_once("../../functions/functions.class.php");
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
  <blockquote>
    <h3>Listagem de Senhas e Contra Senhas</h3>
  </blockquote>
  <form id="form-pesquisa" action="" method="post">
      <input class="form-control" type="text" name="pesquisa" id="pesquisa" placeholder="Digite um nome para Filtrar">
      <br>
  </form>
  <div class="resultados"> </div>
  <?php include_once("../../view/footer/footer.php");?>
</div>

<!-- Javascript --> 
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<script src="../../js/jquery.validate.min.js"></script> 
<script src="../../js/bootstrap.min.js"></script> 
<script src="../../js/jquery-ui.js"></script> 
<script src="../../js/tab.js"></script> 
<script type="text/javascript">
$(function(){
			//LISTA TODOS ANTES DE FILTRAR
			$.post('funcionarios.class.php', function(retorna){	$(".resultados").html(retorna);
			});
	
	//PESQUISA INSTANTANEA PELO INPUT
	$("#pesquisa").keyup(function(){
		//Recupera oque está sendo digitado no input de pesquisa
		var pesquisa 	= $(this).val();

		//Recupera oque foi selecionado
		var campo 		= $("#campo").val();

		//Verifica se foi digitado algo
		if(pesquisa != ''){
			//Cria um objeto chamado de 'dados' e guarda na propriedade 'palavra' a pesquisa e na propriedade campo o campo a ser pesquisado
			var dados = {
				palavra : pesquisa,
				campo 	: campo
			}
			
			//Envia por AJAX pelo metodo post, a pequisa para o arquivo 'busca.php'
			//O paremetro 'retorna' é responsável por recuperar oque vem do arquivo 'busca.php'
			$.post('funcionarios.class.php', dados, function(retorna){
				//Mostra dentro da ul com a class 'resultados' oque foi retornado
				$(".resultados").html(retorna);
			});
		}else{
			$(".resultados").html('');
		}
	});
	});
</script>
</body>
</html>