<?php 
require_once("../../controller/relatorio.controller.class.php");
include_once("../../functions/functions.class.php");
include_once("../../functions/query.class.php");

$functions  = new Functions;
$controller = new RelatorioController();
$query      = new Query();


//Inicializando as variáveis
$table = array();
$rows = array();
$flag = true;
 
//Criando as colunas dentro do array
$table['cols'] = array(
 
array('label' => 'MEIO', 'type' => 'string'),
 array('label' => 'QUANTIDADE', 'type' => 'number')
 
);
 
 //Preenchendo as linhas do array auxiliar "$row" com os dados do banco
 $grafico = $controller->grafico();
 while($row = sqlsrv_fetch_array($grafico)){

 $temp = array();
 $temp[] = array('v' => (string) $row['tec_id']);
 $temp[] = array('v' => (int) $row['quantidade']);
 
$rows[] = array('c' => $temp);
}
 
//Adiciona o array auxiliar "$row" como um array dentro da variavel tabela.
$table['rows'] = $rows;
 
//"json_encode" é uma função do próprio php que irá transformar o array em JSON
$jsonTable = json_encode($table);
print_r ($table);

?>