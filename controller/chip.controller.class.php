<?php 

/*
 * 	Descrição do Arquivo
 * 	@author Lukas Roberto
 * 	@data de criação - 19/20/2014
 * 	@arquivo - chip.controller.class.php
 */

require_once("../../functions/crud.class.php");

class ChipController extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("CHIP");	
	}
	
	//Método específico da classe

	public function listObjectsGroup($coluna=NULL,$filtro=NULL){
		
		if($filtro){
			return $this->execute_query("SELECT * FROM CHIP WHERE " . $coluna . " like '%" . $filtro . "%'");
			
		}else{
			return $this->execute_query("SELECT * FROM CHIP" );
		}
	}

	public function listaChipsAtivos($coluna=NULL,$filtro=NULL){
		
		if($filtro){
			return $this->execute_query("SELECT CHIP.chip_imei, CHIP.chip_operadora, CHIP.chip_data_envio, CHIP.cli_codigo, CHIP.chip_status, CHIP.chip_codigo, CLIENTE.cli_nome
FROM  CHIP INNER JOIN CLIENTE ON CHIP.cli_codigo = CLIENTE.cli_codigo WHERE CHIP." . $coluna . " = '" . $filtro . "'");
			
		}else{
			return $this->execute_query("SELECT CHIP.chip_imei, CHIP.chip_operadora, CHIP.chip_data_envio, CHIP.cli_codigo, CHIP.chip_status, CHIP.chip_codigo, CLIENTE.cli_nome
FROM  CHIP INNER JOIN CLIENTE ON CHIP.cli_codigo = CLIENTE.cli_codigo" );
		}
	}

			public function qtqChips(){
			return $this->execute_query("SELECT chip_status, COUNT(chip_codigo) AS quantidade FROM CHIP GROUP BY chip_status");
			}

}

?>