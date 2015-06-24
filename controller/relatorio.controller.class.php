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
			return $this->execute_query("SELECT cli_empresa, cli_cidade, COUNT(cli_cidade) AS quantidade FROM CLIENTE WHERE(cli_empresa = '".$empresa."') and (cli_cidade = '".$cidade."') and cli_monitorado = 'True' GROUP BY cli_cidade, cli_empresa ORDER BY cli_empresa");				  
		}else if(!$empresa ==NULL){
			return $this->execute_query("SELECT cli_empresa, cli_cidade, COUNT(cli_cidade) AS quantidade FROM CLIENTE WHERE(cli_empresa = '".$empresa."') and cli_monitorado = 'True' GROUP BY cli_cidade, cli_empresa ORDER BY cli_empresa");
		}else if(!$cidade ==NULL){
			return $this->execute_query("SELECT cli_empresa, cli_cidade, COUNT(cli_cidade) AS quantidade FROM CLIENTE WHERE(cli_cidade = '".$cidade."') and cli_monitorado = 'True' GROUP BY cli_cidade, cli_empresa ORDER BY cli_empresa");
		}else{
			return $this->execute_query("SELECT cli_empresa, cli_cidade, COUNT(cli_cidade) AS quantidade FROM CLIENTE Where cli_monitorado = 'True' GROUP BY cli_cidade, cli_empresa ORDER BY cli_empresa");
		}
	}
	//Clientes.php
		public function qtdClientesPorEmpresa($empresa=NULL){
		
			$SQL = "SELECT COUNT(cli_empresa) AS quantidade FROM CLIENTE WHERE(cli_empresa = '".$empresa."') and cli_monitorado = 'True'";
			return sqlsrv_fetch_object($this->execute_query($SQL));
			}

	//Clientes.php
	public function totalClientes($monitorado){
	
		$SQL = "SELECT COUNT(cli_empresa) AS quantidade FROM CLIENTE WHERE cli_monitorado = '".$monitorado."'";
		return sqlsrv_fetch_object($this->execute_query($SQL));
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

				//qtd_os_mensal.php
	public function listaQtdOSMensal($dataini=NULL,$datafin=NULL){
		
			if($dataini && $datafin){
			return $this->execute_query("SELECT YEAR = YEAR(OS_DATA_INI),
												       MONTH = MONTH(OS_DATA_INI),  
												       QUANTIDADE = CONVERT(VARCHAR,FLOOR(COUNT(OS_TIPO)),1) 
												FROM   OS
												WHERE os.os_cliente != '78' and os.os_tipo != '3' and OS.os_data_ini BETWEEN CONVERT(VARCHAR(10),'".$dataini."',103) AND CONVERT(VARCHAR(10),'".$datafin."',103)
												GROUP BY YEAR(OS_DATA_INI), 
												         MONTH(OS_DATA_INI)
												ORDER BY YEAR, 
														 MONTH
												");	
			}else{
			return $this->execute_query("SELECT YEAR = YEAR(OS_DATA_INI),
												       MONTH = MONTH(OS_DATA_INI),  
												       QUANTIDADE = CONVERT(VARCHAR,FLOOR(COUNT(OS_TIPO)),1) 
												FROM   OS
												WHERE os.os_cliente != '78' and os.os_tipo != '3'
												GROUP BY YEAR(OS_DATA_INI), 
												         MONTH(OS_DATA_INI)
												ORDER BY YEAR, 
														 MONTH

												");	
			}
		}


				//grafico.php
	public function grafico(){
		
			return $this->execute_query("SELECT OS_TECNICO.tec_id, COUNT(OS_TECNICO.os_id) AS quantidade FROM TECNICO INNER JOIN OS_TECNICO 
										ON TECNICO.tec_id = OS_TECNICO.tec_id INNER JOIN OS ON OS_TECNICO.os_id = OS.os_id 
										GROUP BY OS_TECNICO.tec_id");
			
		}	

						//cliente_sem_comunicacao.php
	public function listaClientesSemComunicacao($datetime){
	
	$datetime = $datetime.' 06:00:00';
			return $this->execute_query("Select * FROM Cliente WHERE (cli_empresa <> 'guardian') AND (cli_monitorado = 'true') 
				AND (cli_ultima_comunicacao < '".$datetime."') ORDER BY cli_ultima_comunicacao DESC");
			
		}				
	}

?>