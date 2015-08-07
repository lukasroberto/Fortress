<?php 

/*
 * 	Descrição do Arquivo
 * 	@author Vanessa Rossi
 * 	@data de criação - 29/09/2013
 * 	@arquivo - usuario.controller.class.php
 */

require_once("../../functions/crud.class.php");

class EmpresaController extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("EMPRESA");	
	}
	
	//Método específico da classe

	public function listObjectsGroup($where=NULL){
		
		if($where){
			return $this->execute_query("SELECT * FROM EMPRESA WHERE EMP_STATUS = 'True' AND EMP_ID = '" . $where);
		}else{
			return $this->execute_query("SELECT * FROM EMPRESA WHERE EMP_STATUS = 'True'" );
		}
	}

		public function listObjectsGroup2($where=NULL){
		

			$foto = sqlsrv_fetch_object($this->execute_query("SELECT emp_logo FROM EMPRESA WHERE EMP_STATUS = 'True'"));
			// Definindo tipo do retorno
        header('Content-Type: image/png');
        
        // Retornando conteudo
        return $foto->emp_logo;
	}

}

?>