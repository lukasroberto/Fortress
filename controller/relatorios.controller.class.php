<?php 

require_once("../../functions/crud.class.php");

class RelatorioController extends Crud {

	//Método construtor

	public function __construct(){
		parent::__construct("TAB_POSICIONAMENTO");	
	}
	
	//Método específico da classe

	public function listObjectsGroup($linhas,$data_in,$data_out,$veiculos=NULL,$frase){
		
	if($veiculos!=NULL){
	$SQL = "SELECT TOP ".$linhas." * FROM TAB_POSICIONAMENTO WHERE (PST_DATAHORA BETWEEN '".$data_in."' AND '".$data_out."' AND NUM_PLACA='".$veiculos."' AND PST_LONGITUDE LIKE'-%' AND PST_MENSAGEM LIKE '%".$frase."%')  ORDER BY PST_DATAHORA DESC";					
	return $this->execute_query($SQL);
	
	}else{
	
	$SQL = "SELECT TOP ".$linhas." * FROM TAB_POSICIONAMENTO WHERE (PST_DATAHORA BETWEEN '".$data_in."' AND '".$data_out."' AND PST_LONGITUDE LIKE'-%' AND PST_MENSAGEM LIKE '%".$frase."%')  ORDER BY PST_DATAHORA DESC";					
	return $this->execute_query($SQL);
		}
	}			
		
	public function listPlacas($grupo){
		
	$SQL = "SELECT TAB_PLACAS.NUM_PLACA FROM TAB_PLACAS, TAB_VEICULO, TAB_TER_EMP WHERE TAB_PLACAS.ID_EMPRESA = ANY (SELECT ID_EMPRESA FROM TAB_EMPRESAGRUPO WHERE ID_GRUPO = ".$grupo.") AND TAB_PLACAS.ID_PLACA = TAB_VEICULO.ID_PLACA AND  TAB_VEICULO.ID_VEICULO = TAB_TER_EMP.ID_VEICULO AND DAT_DES = '0' ORDER BY TAB_PLACAS.NUM_PLACA";
	return $this->execute_query($SQL);
		}

	
}

?>