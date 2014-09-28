<?php 

require_once("../../functions/crud.class.php");

class OsPendente extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("OS");	
	}
	
	//Método específico da classe

	public function listTecnicos(){
			$SQL = "select * from tecnico where tec_status = '0' order by tec_nome";
	return $this->execute_query($SQL);

	}	
	
	public function insereTecnicos($tecnico,$osid){
	
		$SQL = "INSERT INTO OS_TECNICO (TEC_ID, OS_ID) VALUES ('".$tecnico."','".$osid."')";	
		$this->execute_query($SQL);
  
	}		
	public function listOsPendente($os_id){
		
	$SQL = "SELECT * FROM OS INNER JOIN CLIENTE ON OS.os_cliente = CLIENTE.cli_codigo WHERE os_id = '".$os_id."'";
	return sqlsrv_fetch_object($this->execute_query($SQL));
		}
}

?>