<?php

require_once("../../functions/crud.class.php");

class LoginController extends Crud {

	//Método construtor
	
	public function __construct(){
		parent::__construct("LOGIN");
	}

	public function autentica($login,$senha){
		//echo "Passei aqui";
		return $this->execute_query("SELECT * FROM " . $this->getTabela() .  " WHERE log_user = '" . $login . "' 
		AND log_pass = '" . $senha . "' AND log_acesso_sistema = 'True' ;" );
	}
	
	public function logoff(){
		
		session_start();
		$_SESSION["idusuario"] 		= NULL;
		$_SESSION["grupo"] 			= NULL;
		$_SESSION["nome"] 			= NULL;
		$_SESSION["nivuser"] 		= NULL;
		
		session_unset();
		session_destroy();

		//Sucesso, redireciona para a tela principal
		header("Location: login.php");
		
	}

}

?>
