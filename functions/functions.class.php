<?php 

class Functions {
	
	public function converterData($strData) {
	
		// Converte a data de dd/mm/aaaa para o formato: aaaa-mm-dd
		$strDataFinal = implode('-', array_reverse(explode('/',$strData)));
		return $strDataFinal;
	}
	
	public function converterDataPadrao($strData) {
	
		// Converte a data de aaaa-mm-dd para o formato: dd/mm/aaaa
		$strDataFinal = implode('/', array_reverse(explode('-',$strData)));
		return $strDataFinal;
	}
	
	
	public function geraMenu($tipoDeUsuario){
	
		$contextoDeMenu = "http://192.168.0.198/fortress";
		//$contextoDeMenu = "http://feob.tempsite.ws/2013/tanbook";
		
				//if($tipoDeUsuario==1){
			
			$menu = "

					<ul class=\"nav navbar-nav\">
					  <li><a href=\"".$contextoDeMenu."/view/home/home.php\">Home</a></li>
					  
					  <li class=\"dropdown\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Fortress<b class=\"caret\"></b></a>
						<ul class=\"dropdown-menu\">
						  <li><a href=\"".$contextoDeMenu."/view/usuario/lista.php\"><i class=\"icon-share\"></i> Gerenciar Usuários</a></li>
						  <li><a href=\"".$contextoDeMenu."/view/login/edita.php\"><i class=\"icon-user\"></i> Gerenciar Minha Conta</a></li>
						  <li><a href=\"".$contextoDeMenu."/view/login/logoff.php?confirma=NAO\"><i class=\"icon-share\"></i> Efetuar Logoff</a></li>
						</ul>
					  </li>
					  <li class=\"dropdown\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Relatórios<b class=\"caret\"></b></a>
						<ul class=\"dropdown-menu\">
						  <li><a href=\"".$contextoDeMenu."/view/relatorio/cliente.php\"><i class=\"icon-share\"></i> Clientes</a></li>
						  <li><a href=\"".$contextoDeMenu."/view/relatorio/servicos_por_tecnico.php\"><i class=\"icon-share\"></i> Serviços Realizados</a></li>
						</ul>
					  </li>
					  <li class=\"dropdown\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Sistema<b class=\"caret\"></b></a>
						<ul class=\"dropdown-menu\">
						  <li><a href=\"".$contextoDeMenu."/view/os/lista.php\">Gerenciar Ordens de Serviço</a></li>
						  <li><a href=\"".$contextoDeMenu."/view/cliente/lista.php\">Gerenciar Clientes</a></li>
						  <li><a href=\"".$contextoDeMenu."/view/funcionarios/lista.php\">Listagem de Contra Senhas</a></li>
						</ul>
					  </li>
					  <li><a href=\"".$contextoDeMenu."/view/sobre/sobre.php\">Sobre</a></li>
					</ul>
			
					";	
		//}
		
		echo $menu;	
		
	}
	
	
	public function statusDaHistoria($status){
	
		switch($status){
		
			case "E":
				$tipo = "Editando";
			break;
			
			case "I":
				$tipo = "Inativa";
			break;
			
			case "P":
				$tipo = "Publicada";
			break;
			
		}
		
		return $tipo;	
		
	}
	
	
	public function mensagemDeRetorno($tipo,$acao){
	
		//Definir o tipo de erro, o ícone e a classe de estilo utilizada para a tela de alerta
		switch($tipo){
			case 1:
				$msgA = "SUCESSO";
				$icnA = "icone_sucesso.png";
				$classe = "alert alert-success";
			break;
	
			case 2:
				$msgA = "ERRO";
				$icnA = "icone-erro.png";
				$classe = "alert alert-danger";
			break;
	
			case 3:
				$msgA = "FALHA";
				$icnA = "icone-aviso.png";
				$classe = "alert alert-warning";
			break;
	
			case 4:
				$msgA = "AVISO";
				$icnA = "icone-aviso.png";
				$classe = "alert alert-info";
			break;
	
		}
			
	
		switch($acao){
			case 1:
				$msgB = "cadastro";
			break;
	
			case 2:
				$msgB = "alteração";
			break;
	
			case 3:
				$msgB = "exclusão";
			break;
	
			case 4:
				$msgB = "logon";
			break;
	
			case 5:
				$msgB = "autenticação";
			break;
	
			case 6:
				$msgB = "pesquisa";
			break;
	
			case 7:
				$msgB = "upload de arquivo";
			break;
	
		}
	
		$mensagem = "
					<div class=\"alert alert-block ".$classe." fade in\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
						<h4 class=\"alert-heading\">".$msgA."</h4>
						<p>Ao realizar a operação de ".$msgB.".</p>
					</div>
					";		
	
		echo $mensagem;
	}
	
	public function mensagemDeRetornoPersonalizada($tipo,$mensagem){
	
		//Definir o tipo de erro, o ícone e a classe de estilo utilizada para a tela de alerta
		switch($tipo){
			case 1:
				$msgA = "SUCESSO";
				$icnA = "icone_sucesso.png";
				$classe = "alert alert-success";
			break;
	
			case 2:
				$msgA = "ERRO";
				$icnA = "icone-erro.png";
				$classe = "alert alert-danger";
			break;
	
			case 3:
				$msgA = "FALHA";
				$icnA = "icone-aviso.png";
				$classe = "alert alert-warning";
			break;
	
			case 4:
				$msgA = "AVISO";
				$icnA = "icone-aviso.png";
				$classe = "alert alert-info";
			break;
	
		}

		$retorno = "
					<div class=\"alert alert-block ".$classe." fade in\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
						<h4 class=\"alert-heading\">".$msgA."</h4>
						<p>".$mensagem."</p>
					</div>
					";		
	
		echo $retorno;
	}


}
?>