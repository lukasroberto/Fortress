<?php


/*
Controller especifico para busca instantanea
 */

require_once("../../functions/crud.class.php");

class Clientes extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("CLIENTE");	
	}
	
	//Método específico da classe

	public function buscador($where=NULL){
	$SQL = "SELECT TOP 30 * FROM CLIENTE WHERE CLI_NOME LIKE '%".$where."%'";
	$clientes = $this->execute_query($SQL);

		echo "<table class='table table-condensed table-hover table-striped' ta>";
		 echo"<thead>
		 		<tr>
					<th><strong>Código</strong></td>
					<th><strong>Nome</strong></td>
					<th><strong>Endereço</strong></td>
					<th>&nbsp;</td>
			  	</tr>
			  </thead>";
	
	while($cliente = sqlsrv_fetch_array($clientes)){
		$teste = 'teste';
		     echo" <tr>
						<td>".$cliente["cli_codigo"]."</td>
						<td>".$cliente["cli_nome"]."</td>
						<td>".$cliente["cli_rua"]."</td>
						<td><button type='button' class='btn btn-warning' data-dismiss='modal' id=".$cliente["cli_codigo"]."
						 onClick='javascript:passarParametro(".$cliente["cli_codigo"].");'>Selecionar</button>
						</td>
				  </tr>";
    

		}
	echo "</table>";
	}
		
}
$cliente = new Clientes;
if (!empty($_POST)) {
	$cliente->buscador($_POST['palavra']);
}else{
$cliente->buscador();
}




?>
