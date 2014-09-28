<?php


/*
 * 	Descrição do Arquivo
 * 	@author Vanessa Rossi
 * 	@data de criação - 29/09/2013
 * 	@arquivo - usuario.controller.class.php
 */

require_once("../../functions/crud.class.php");

class Funcionarios extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("LOGIN");	
	}
	
	//Método específico da classe

	public function buscador($where=NULL){
	$SQL = "SELECT * FROM LOGIN WHERE LOG_NOME LIKE '%".$where."%' AND LOG_ACESSO_SISTEMA = 'TRUE'";
	$funcionarios = $this->execute_query($SQL);

		echo "<table class='table table-condensed table-hover table-striped' ta>";
		 echo"<thead>
		 		<tr>
					<th><strong>N° Linha</strong></td>
					<th><strong>Nome</strong></td>
					<th><strong>Senha</strong></td>
					<th>&nbsp;</td>
			  	</tr>
			  </thead>";
	
	$conta = 0;
	while($func = sqlsrv_fetch_array($funcionarios)){
		$conta = $conta+1;
		
		     echo" <tr>
						<td>".$conta."</td>
						<td>".$func["log_nome"]."</td>
						<td><strong style='color:#F93'>".$func["log_senha_falada"]."</strong></td>
						<td>&nbsp;</td>
				  </tr>";
    

		}
	echo "</table>";
	}
		
}
$func = new Funcionarios;
if (!empty($_POST)) {
	$func->buscador($_POST['palavra']);
}else{
$func->buscador();
}




?>
