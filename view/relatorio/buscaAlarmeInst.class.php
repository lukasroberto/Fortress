<?php


/*
Controller especifico para busca instantanea de Eventos de alarme
 */

require_once("../../functions/crud.class.php");

class Eventos extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("EVENTOS");	
	}
	
	//Método específico da classe

	public function buscador($where=NULL){
	$SQL = "SELECT TOP 30 * FROM EVENTO WHERE EVENTO_DESCRICAO LIKE '%".$where."%' or EVENTO_CODIGO_EVENTO LIKE '%".$where."%'";
	$eventos = $this->execute_query($SQL);

		echo "<table style='font-size: 12px' class='table table-condensed table-hover table-striped'>";
		 echo"<thead>
		 		<tr>
					<th><strong>Código</strong></td>
					<th><strong>Código do Evento</strong></td>
					<th><strong>Nome do Evento</strong></td>
					<th>&nbsp;</td>
			  	</tr>
			  </thead>";
	
	while($evento = sqlsrv_fetch_array($eventos)){
		$teste = 'teste';
		     echo" <tr>
						<td>".$evento["evento_id"]."</td>
						<td>".$evento["evento_codigo_evento"]."</td>
						<td>".$evento["evento_descricao"]."</td>
						<td><button type='button' class='btn-xs btn-warning' id=".$evento["evento_codigo_evento"]."
						 onClick=addArray('".$evento["evento_codigo_evento"]."');>Selecionar</button>
						</td>
				  </tr>";
    

		}
	echo "</table>";
	}
	//Fecha o modal -------- data-dismiss='modal' ex: <button type='button' class='btn btn-warning'  data-dismiss='modal' id=".$cliente["cli_codigo"]." onClick='javascript:passarParametro(".$cliente["cli_codigo"].");'>Selecionar</button>
		
}
$evento = new Eventos;
if (!empty($_POST)) {
	$evento->buscador($_POST['palavra']);
}else{
$evento->buscador();
}




?>
