<?php 

require_once("crud.class.php");

class Query extends Crud {
	
		//Método Contrutor da classe"
	
		public function __construct(){
		//parent::__construct("CLIENTE");	
	}

	//Método específico da classe"

		public function listaCidades(){
		
			return $this->execute_query("SELECT cli_cidade from CLIENTE GROUP BY cli_cidade ORDER BY cli_cidade");
		}
		
		public function listaEmpresa(){
		
			return $this->execute_query("SELECT cli_empresa from CLIENTE GROUP BY cli_empresa ORDER BY cli_empresa");
		}
		
		public function listaTecnicos(){
		
			return $this->execute_query("SELECT tec_id,tec_nome from TECNICO WHERE tec_status = '0' ORDER BY tec_nome");
		}

}

?>