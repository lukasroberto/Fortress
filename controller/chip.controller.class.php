<?php 

/*
 * 	Descrição do Arquivo
 * 	@author Lukas Roberto
 * 	@data de criação - 19/20/2014
 * 	@arquivo - chip.controller.class.php
 */

require_once("../../functions/crud.class.php");

class ChipController extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("CHIP");	
	}
	
	//Método específico da classe

	public function listObjectsGroup($coluna=NULL,$filtro=NULL){
		
		if($filtro){
			return $this->execute_query("SELECT * FROM CHIP WHERE " . $coluna . " like '%" . $filtro . "%'");
			
		}else{
			return $this->execute_query("SELECT * FROM CHIP" );
		}
	}
}

?>