<?php 

require_once("../../functions/crud.class.php");

class RelatorioController extends Crud{

	//Método construtor

	public function __construct(){
		parent::__construct("CLIENTE");	
	}
	
	//Clientes.php
	public function listaQtdClientes($empresa=NULL,$cidade=NULL){
		
		if($cidade && $empresa){
			return $this->execute_query("SELECT cli_empresa, cli_cidade, COUNT(cli_cidade) AS quantidade FROM CLIENTE WHERE(cli_empresa = '".$empresa."') and (cli_cidade = '".$cidade."')GROUP BY cli_cidade, cli_empresa ORDER BY cli_empresa");

				  
		}else if(!$empresa ==NULL){
			return $this->execute_query("SELECT cli_empresa, cli_cidade, COUNT(cli_cidade) AS quantidade FROM CLIENTE WHERE(cli_empresa = '".$empresa."')GROUP BY cli_cidade, cli_empresa ORDER BY cli_empresa");
		}else if(!$cidade ==NULL){
			return $this->execute_query("SELECT cli_empresa, cli_cidade, COUNT(cli_cidade) AS quantidade FROM CLIENTE WHERE(cli_cidade = '".$cidade."')GROUP BY cli_cidade, cli_empresa ORDER BY cli_empresa");
		}else{
			return $this->execute_query("SELECT cli_empresa, cli_cidade, COUNT(cli_cidade) AS quantidade FROM CLIENTE GROUP BY cli_cidade, cli_empresa ORDER BY cli_empresa");
		}
	}
	
		//servicos_por_tecnico.php
	public function listaQtdServicos($tecnico=NULL,$dataini=NULL,$datafin=NULL){
		
			if($tecnico){
			return $this->execute_query("SELECT OS_TECNICO.tec_id, TECNICO.tec_nome, COUNT(OS_TECNICO.os_id) AS quantidade FROM TECNICO INNER JOIN OS_TECNICO 
										ON TECNICO.tec_id = OS_TECNICO.tec_id INNER JOIN OS ON OS_TECNICO.os_id = OS.os_id WHERE (OS.os_data_ini BETWEEN 
										CONVERT(VARCHAR(10),'".$dataini."',103) AND  CONVERT(VARCHAR(10),'".$datafin."',103)) AND (TECNICO.tec_id = '".$tecnico."')
										GROUP BY OS_TECNICO.tec_id, TECNICO.tec_nome ORDER BY quantidade DESC");
			}else{
			return $this->execute_query("SELECT OS_TECNICO.tec_id, TECNICO.tec_nome, COUNT(OS_TECNICO.os_id) AS quantidade FROM TECNICO INNER JOIN OS_TECNICO 
										ON TECNICO.tec_id = OS_TECNICO.tec_id INNER JOIN OS ON OS_TECNICO.os_id = OS.os_id WHERE (OS.os_data_ini BETWEEN 
										CONVERT(VARCHAR(10),'".$dataini."',103) AND  CONVERT(VARCHAR(10),'".$datafin."',103))
										GROUP BY OS_TECNICO.tec_id, TECNICO.tec_nome ORDER BY quantidade DESC");
			}
		
	}
		
	}

?>