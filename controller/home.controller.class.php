<?php 

/*
 * 	Descrição do Arquivo
 * 	@author Vanessa Rossi
 * 	@data de criação - 29/09/2013
 * 	@arquivo - usuario.controller.class.php
 */

require_once("../../functions/crud.class.php");

class HomeController extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("HOME");	
	}
		//Clientes.php
		public function qtdClientesParaCadastrar(){
		
			$SQL = "SELECT COUNT(cli_nome) AS cadastrar FROM CLIENTE WHERE (cli_nome = 'Cadastrar') AND (cli_monitorado = 'True')
			GROUP BY cli_nome";
			return sqlsrv_fetch_object($this->execute_query($SQL));
			}

}
?>