<?php 

/*
 * 	Descrição do Arquivo
 * 	@author Lukas Roberto
 * 	@data de criação - 30/04/2015
 * 	@arquivo - forefront.controller.class.php
 */

require_once("../../functions/crud.class.php");

class ForefrontController extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("FOREFRONT");	
	}
	
	//Método específico da classe

	public function listObjectsGroup($coluna=NULL,$filtro=NULL){
		
		if($filtro){
			if($coluna == 'regra'){
				$coluna = '[rule]';
			}
			else if($coluna == 'ip'){
				$coluna = '[clientIP]';
				$separa = explode(".", $filtro); // quebra a string nos pontos
				$count = count($separa); 
				$filtro = dechex($separa[0]).dechex($separa[1]).dechex($separa[2]).'0'.dechex($separa[3]);
			}
			else if($coluna == 'site'){
				$coluna = '[referredserver]';
			}
			else if($coluna == 'sitePagina'){
				$coluna = '[UrlDestHost]';
			}



			return $this->execute_query("SELECT top 10 [dbo].[ipclient] (ClientIP) [clientIP]
										  ,[ClientUserName] 
									      ,[logTime]
									      ,[referredserver]
									      ,[uri]
									      ,[rule] 
									 from webproxylog
									 where ".$coluna." like '%".$filtro."%' 
									 order by 3 desc");
	
		}else{
			return $this->execute_query("SELECT top 10 [dbo].[ipclient] (ClientIP) [clientIP]
										  ,[ClientUserName]
									      ,[logTime]
									      ,[referredserver]
									      ,[uri]
									      ,[rule]
									 from webproxylog  order by 3 desc");
		}
	}
}

?>