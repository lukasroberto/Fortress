<?php 

require_once("../../functions/crud.class.php");

class OsFinalizada extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("OS");	
	}
	
	//Método específico da classe
	
		public function listTecnicos($os_id){
			$SQL = "SELECT TECNICO.tec_nome FROM TECNICO INNER JOIN OS_TECNICO ON TECNICO.tec_id = OS_TECNICO.tec_id
					WHERE(TECNICO.tec_status = '0') AND (OS_TECNICO.os_id = '".$os_id."')";
		return $this->execute_query($SQL);

	}	
			
	public function listOsFinalizada($os_id){
		
	$SQL = "SELECT * FROM OS INNER JOIN CLIENTE ON OS.os_cliente = CLIENTE.cli_codigo WHERE os_id = '".$os_id."'";
	return sqlsrv_fetch_object($this->execute_query($SQL));
		}
}
?>