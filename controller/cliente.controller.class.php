<?php 

/*
 * 	Descrição do Arquivo
 * 	@author Vanessa Rossi
 * 	@data de criação - 29/09/2013
 * 	@arquivo - usuario.controller.class.php
 */

require_once("../../functions/crud.class.php");

class ClienteController extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("CLIENTE");	
	}
	
	//Método específico da classe

	public function listObjectsGroup($coluna=NULL,$condicao=NULL,$filtro=NULL){
		
		$WHERE = $coluna . " like '%" . $filtro . "%'";

		if($condicao == "like"){
		$WHERE = $coluna . " like '%" . $filtro . "%'";
		}		
		if($condicao == "="){
		$WHERE = $coluna . "= '" . $filtro."'";
		}


		if($filtro){
			return $this->execute_query("SELECT top 50 * FROM CLIENTE WHERE " . $WHERE);
			
		}else{
			return $this->execute_query("SELECT top 100 * FROM CLIENTE" );
		}
	}
		public function listaClientesDoRelatorio($cidade=NULL,$empresa=NULL,$monitorado=NULL){
		
			if($cidade){
				return $this->execute_query("SELECT * FROM CLIENTE WHERE CLI_CIDADE = '".$cidade."' AND CLI_EMPRESA = '". $empresa."' AND CLI_MONITORADO = '".$monitorado."'");
			}else if($monitorado == 'False' && $empresa == NULL){
				return $this->execute_query("SELECT * FROM CLIENTE WHERE CLI_MONITORADO = '".$monitorado."'");	
			}else{
				return $this->execute_query("SELECT * FROM CLIENTE WHERE CLI_EMPRESA = '". $empresa."' AND CLI_MONITORADO = '".$monitorado."'");
			}
	}

}

?>