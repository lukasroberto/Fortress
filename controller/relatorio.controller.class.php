<?php 

require_once("../../functions/crud.class.php");

class RelatorioController extends Crud{

	//Método construtor

	public function __construct(){
		parent::__construct("CLIENTE");	
	}
	
	//Clientes.php
	public function listaQtdClientes($empresa=NULL,$cidade=NULL){
		
		if($cidade && $empresa){//CLIENTE.cli_cidade, EMPRESA.emp_nome_fantasia FROM CLIENTE INNER JOIN EMPRESA ON CLIENTE.cli_empresa = EMPRESA.emp_id
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
			return $this->execute_query("Select * FROM Cliente WHERE (cli_empresa <> '11') AND (cli_monitorado = 'true') 
				AND (cli_ultima_comunicacao < '".$datetime."') ORDER BY cli_ultima_comunicacao DESC");
			
		}	

								//cliente_log_sem_comunicacao.php
	public function listaLogClientesSemComunicacao($coluna,$filtro){
		if($coluna){
			if($coluna == "com_cli_codigo"){
				$condicao = $coluna." ='".$filtro."'";
			}else{
				$condicao = $coluna." LIKE'%".$filtro."%'";
			}
			return $this->execute_query("SELECT * FROM RELAT_COMUNICACAO INNER JOIN CLIENTE ON
			 RELAT_COMUNICACAO.com_cli_codigo = CLIENTE.cli_codigo WHERE ".$condicao);
		}else{
			return $this->execute_query("SELECT * FROM RELAT_COMUNICACAO INNER JOIN CLIENTE ON 
				RELAT_COMUNICACAO.com_cli_codigo = CLIENTE.cli_codigo");
			}

		}


		//relat_eventos_alarme.php
	public function listaEventosDeAlarme($dataini,$datafin,$clientes=NULL,$eventos=NULL){
		
		$dataini = $dataini." 00:00:00";
		$datafin = $datafin." 23:59:00";

		if($clientes || $eventos != NULL){

			//Clientes----------------------------------------
			if($clientes != NULL){

			$clientes = substr($clientes, 1);
			$listCliente = explode(',', $clientes);
			$sqlClientes = " AND (LEITOR.eve_codigo_cliente = '";
			$sqlCondicaoCliente1 = NULL;

				if(count($listCliente) > 1){
					
					foreach ($listCliente as $c) {
						$sqlCondicaoCliente = " OR LEITOR.eve_codigo_cliente = '".$c."'" ;
						$sqlCondicaoCliente1 = $sqlCondicaoCliente1.$sqlCondicaoCliente;

					}
						$sqlClientes = $sqlClientes.$c."'".$sqlCondicaoCliente1.")";
				}else{
					$sqlClientes = " AND (LEITOR.eve_codigo_cliente = '".$clientes."')" ;
					}
			}else{
				$sqlClientes = '';
			}

			//Eventos------------------------------------------
			if($eventos != NULL){
	
				$eventos = substr($eventos, 1);
				$listEventos = explode(',', $eventos);
				$sqlEventos = " AND (EVENTO.evento_codigo_evento = '";
				$sqlCondicaoEventos1 = NULL;

					if(count($listEventos) > 1){
						
						foreach ($listEventos as $e) {
							$sqlCondicaoEvento = " OR EVENTO.evento_codigo_evento = '".$e."'" ;
							$sqlCondicaoEventos1 = $sqlCondicaoEventos1.$sqlCondicaoEvento;

						}
							$sqlEventos = $sqlEventos.$e."'".$sqlCondicaoEventos1.")";
					}else{
						$sqlEventos = " AND (EVENTO.evento_codigo_evento  = '".$eventos."')" ;
						}
			}else{
				$sqlEventos = '';
				}

			//SQL--------------------------------------------------	
				$sql = ("SELECT top 1000 LEITOR.eve_codigo_cliente, LEITOR.eve_codigo_evento,
						COUNT(*) AS Quantidade, EVENTO.evento_descricao, LEITOR.eve_usuario_zona,CLIENTE.cli_nome
						FROM LEITOR 
						INNER JOIN EVENTO ON LEITOR.eve_codigo_evento = EVENTO.evento_codigo_evento 
						INNER JOIN CLIENTE ON LEITOR.eve_codigo_cliente = CLIENTE.cli_codigo
						WHERE     (LEITOR.eve_data_hora BETWEEN '".$dataini."' AND '".$datafin."')".$sqlClientes." ".$sqlEventos."
						GROUP BY LEITOR.eve_codigo_cliente, LEITOR.eve_codigo_evento, EVENTO.evento_descricao,
						LEITOR.eve_usuario_zona, CLIENTE.cli_nome
						ORDER BY LEITOR.eve_codigo_cliente");

		}else{

				$sql = ("SELECT top 200 LEITOR.eve_codigo_cliente, LEITOR.eve_codigo_evento,
						COUNT(*) AS Quantidade, EVENTO.evento_descricao, LEITOR.eve_usuario_zona,CLIENTE.cli_nome
						FROM LEITOR 
						INNER JOIN EVENTO ON LEITOR.eve_codigo_evento = EVENTO.evento_codigo_evento 
						INNER JOIN CLIENTE ON LEITOR.eve_codigo_cliente = CLIENTE.cli_codigo
						WHERE     (LEITOR.eve_data_hora BETWEEN '".$dataini."' AND '".$datafin."')
						GROUP BY LEITOR.eve_codigo_cliente, LEITOR.eve_codigo_evento, EVENTO.evento_descricao,
						LEITOR.eve_usuario_zona, CLIENTE.cli_nome
						ORDER BY LEITOR.eve_codigo_cliente");
		}
			return $this->execute_query($sql);
	}































//Atualiza tabelas CLIENTE_SERVICO  E SERVICO_TIPO_COMUNICACAO com os dados de comunicaçõa dos clientes
				public function executa(){//ok

		$registros 	= $this->teste();
		if($registros){

        $conta = 0;

        	//percorre todos os clientes e seus receptores
        while($reg = sqlsrv_fetch_array($registros, SQLSRV_FETCH_ASSOC)){
			$cliente = $reg["eve_codigo_cliente"];
			$eve_conta_grupo_receptor = $reg["eve_conta_grupo_receptor"];
			$comunicacao=NULL;
			if($eve_conta_grupo_receptor == '62') $comunicacao = '1' ;
			if($eve_conta_grupo_receptor == '52') $comunicacao = '1' ;
			if($eve_conta_grupo_receptor == '21') $comunicacao = '3' ;
			if($eve_conta_grupo_receptor == '22') $comunicacao = '3' ;
			if($eve_conta_grupo_receptor == '41') $comunicacao = '3' ;
			if($eve_conta_grupo_receptor == '42') $comunicacao = '3' ;
			if($eve_conta_grupo_receptor == '31') $comunicacao = '3' ;
			if($eve_conta_grupo_receptor == '32') $comunicacao = '3' ;
			if($eve_conta_grupo_receptor == '72') $comunicacao = '1' ;
			if($eve_conta_grupo_receptor == '02') $comunicacao = '3' ;
			if($eve_conta_grupo_receptor == '01') $comunicacao = '3' ;

			$servico = 1;


						//Conexao-----------------------------------------------------------------------------
						$params = array();
						$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

						global $conninfo;
						$conninfo = array("Database" => "monitoramento", "ReturnDatesAsStrings" => true , "UID" => "sa", "PWD" => "spotGF2008", "CharacterSet" => "UTF-8");
						$connection = sqlsrv_connect("192.168.0.6", $conninfo);
						//Fim Conexao ------------------------------------------------------------------------

			//Verifica se ja existe dados na tabela
			$sql = "SELECT * FROM CLIENTE_SERVICO WHERE cli_codigo = ".$cliente." and serv_id = ".$servico;
			$stmt = sqlsrv_query( $connection, $sql , $params, $options );
			$row_count = sqlsrv_num_rows( $stmt );

			if($row_count > 0){
			}else{
				//caso não exista insere
				$sql = "INSERT INTO CLIENTE_SERVICO(cli_codigo, serv_id)VALUES(".$cliente.",".$servico.")";
				sqlsrv_query( $connection, $sql , $params, $options );

			}

						$sql = "INSERT INTO 
						SERVICO_TIPO_COMUNIC(comunic_id, cli_serv_id, recep_conta_grupo_receptor)
						VALUES(".$comunicacao.",(SELECT TOP (1) CLI_SERV_ID FROM CLIENTE_SERVICO 
						WHERE CLI_CODIGO = ".$cliente." ORDER BY CLI_SERV_ID DESC),'".$eve_conta_grupo_receptor."')";


						sqlsrv_query($connection, $sql , $params, $options);

		}

		}else{

		echo "<p>Sua pesquisa não retornou nenhum resultado válido.</p>";

			}
		}

	}
		?>


