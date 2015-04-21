<?php 

require_once("../../functions/crud.class.php");

class oslist extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("OS");	
	}
	
	//Método específico da classe
		
	public function listOsBusca($frase=NULL,$status=NULL){
		if($frase!=NULL){
			$SQL = "SELECT * FROM OS INNER JOIN CLIENTE ON OS.os_cliente = CLIENTE.cli_codigo where os.os_id LIKE '%".$frase."%' and os.os_status = '".$status."' ORDER BY OS_DATA_INI DESC";
	return $this->execute_query($SQL);
			}else{
			$SQL = "SELECT TOP 100 * FROM OS INNER JOIN CLIENTE ON OS.os_cliente = CLIENTE.cli_codigo where os.os_status = '".$status."' ORDER BY OS_DATA_INI DESC";
	return $this->execute_query($SQL);
				}
	}
			//Busca cliente 78 (Administrativa) ou todos
		public function listOsBuscaPorCliente78($frase=NULL,$status=NULL){
		if($frase!=NULL){
			$SQL = "SELECT TOP 100 * FROM OS INNER JOIN CLIENTE ON OS.os_cliente = CLIENTE.cli_codigo where os.os_tipo = '3' and os.os_status = '".$status."' and os.os_expedidor = '".$_SESSION["nome"]."' and datediff(hh, OS_DATA_INI, getdate()) < 24 ORDER BY OS_DATA_INI DESC";
	return $this->execute_query($SQL);
			}else{
			$SQL = "SELECT TOP 100 * FROM OS INNER JOIN CLIENTE ON OS.os_cliente = CLIENTE.cli_codigo where os.os_tipo != '3' and os.os_status = '".$status."' and os.os_expedidor = '".$_SESSION["nome"]."' and datediff(hh, OS_DATA_INI, getdate()) < 12 ORDER BY OS_DATA_INI DESC";
	return $this->execute_query($SQL);
				}
	}

		public function listOsPorTecnico($tecnico=NULL,$dataini=NULL,$datafin=NULL){
			$SQL = "SELECT * FROM OS INNER JOIN OS_TECNICO ON OS.os_id = OS_TECNICO.os_id INNER JOIN TECNICO ON OS_TECNICO.tec_id = TECNICO.tec_id INNER JOIN CLIENTE ON OS.os_cliente = CLIENTE.cli_codigo
					WHERE(OS_TECNICO.tec_id = '".$tecnico."' AND (OS.os_data_ini BETWEEN CONVERT(VARCHAR(10),'".$dataini."',103) AND
					CONVERT(VARCHAR(10),'".$datafin."',103)))ORDER BY OS.os_id";
	return $this->execute_query($SQL);

	}
}

?>