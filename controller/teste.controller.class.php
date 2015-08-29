<?php 

/*
 * 	Descrição do Arquivo
 * 	@author Vanessa Rossi
 * 	@data de criação - 29/09/2013
 * 	@arquivo - usuario.controller.class.php
 */

require_once("../../functions/crud.class.php");

class TesteController extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("TESTE");	
	}
	
	//Método específico da classe

	public function listObjectsGroup($where=NULL){
		
		if($where){
			return $this->execute_query("SELECT * FROM LOGIN WHERE LOG_ID = '" . $where);
		}else{
			return $this->execute_query("SELECT * FROM LOGIN" );
		}
	}

}

?>