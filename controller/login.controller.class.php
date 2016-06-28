<?php

require_once("../../functions/crud.class.php");

class LoginController extends Crud {

	//Método construtor
	
	public function __construct(){
		parent::__construct("LOGIN");
	}

	public function dadosUsuario($usuario){
		echo "Passei aqui";
		return $this->execute_query("SELECT * FROM " . $this->getTabela() .  " WHERE log_user = '" . $usuario . "' 
		AND log_acesso_sistema = 'True' ;" );
	}

		public function autentica($login,$senha){
		return sqlsrv_fetch_object($this->execute_query("declare @senhaBD varbinary(100)
						SELECT @senhaBD = log_senha FROM LOGIN WHERE log_user = '" . $login . "' AND log_acesso_sistema = 'True';
						select pwdCompare('" . $senha . "', @senhaBD, 0) as autenticacao"));
	}	
	
	public function logoff(){
		
		session_start();
		$_SESSION["idusuario"] 		= NULL;
		$_SESSION["grupo"] 			= NULL;
		$_SESSION["nome"] 			= NULL;
		$_SESSION["nivuser"] 		= NULL;
		$_SESSION["ip"]         	= NULL;
		
		session_unset();
		session_destroy();

		//Sucesso, redireciona para a tela principal
		header("Location: login.php");
		
	}

}

?>
