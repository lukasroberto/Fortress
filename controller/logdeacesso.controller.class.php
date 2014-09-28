<?php 

/*
 * 	Descrição do Arquivo
 * 	@author Vanessa Rossi
 * 	@data de criação - 29/09/2013
 * 	@arquivo - logdeacesso.controller.class.php
 */

require_once("../../functions/crud.class.php");

class LogDeAcessoController extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("logdeacesso");	
	}

}

?>