<?php 

require_once("../../functions/crud.class.php");

class CadastraOs extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("OS");	
	}
	
	//Método específico da classe

	public function listCliente($filtro=NULL){
		
		if($filtro){
			return $this->execute_query("SELECT top 1 * FROM CLIENTE WHERE CLI_CODIGO = '" . $filtro . "'");
			
		}else{
			return "Informe um Parametro para a busca";
		}
	}	
		
	public function osCodigo(){
		
	$SQL = "SELECT IDENT_CURRENT('os') + 1 AS Proximo";
	return sqlsrv_fetch_object($this->execute_query($SQL));
		}
}

?>