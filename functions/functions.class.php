<?php 

class Functions {

	public function converterData($original='', $format="%d-%m-%Y") { 

		// Converte a data de aaaa-mm-dd para dd-mm-aaaa com a opção de mostrar a hora ou não.
	    $format = ($format=='date' ? "%d-%m-%Y" : $format); 
	    $format = ($format=='datetime' ? "%d-%m-%Y %H:%M:%S" : $format); 
		return (!empty($original) ? strftime($format, strtotime($original)) : "" ); 
} 
	public function removeTime($original='', $format="%Y-%m-%d") { 

		// Converte a data para aaaa-mm-dd e remove a hora
	    $format = ($format=='date' ? "%Y-%m-%d" : $format); 
	    $format = ($format=='datetime' ? "%Y-%m-%d %H:%M:%S" : $format); 
		return (!empty($original) ? strftime($format, strtotime($original)) : "" ); 
} 
	
	
	public function geraMenu($tipoDeUsuario){
	
		$contextoDeMenu = "http://192.168.0.198/fortress";
		//$contextoDeMenu = "http://feob.tempsite.ws/2013/tanbook";
		
				//if($tipoDeUsuario==1){
			
			$menu = "

					<ul class=\"nav navbar-nav\">
					  <li><a href=\"".$contextoDeMenu."/view/home/home.php\">Home</a></li>
					  
					  <li class=\"dropdown\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Fortress<b class=\"caret\"></b></a>
						<ul class=\"dropdown-menu\">
						  <li><a href=\"".$contextoDeMenu."/view/usuario/lista.php\"><i class=\"icon-share\"></i> Gerenciar Usuários</a></li>
						  <li><a href=\"".$contextoDeMenu."/view/login/edita.php\"><i class=\"icon-user\"></i> Gerenciar Minha Conta</a></li>
						  <li><a href=\"".$contextoDeMenu."/view/login/logoff.php?confirma=NAO\"><i class=\"icon-share\"></i> Efetuar Logoff</a></li>
						</ul>
					  </li>
						<li><a href=\"".$contextoDeMenu."/view/relatorio/relatorios.php\">Relatórios</a></li>
					  <li class=\"dropdown\">
						<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Sistema<b class=\"caret\"></b></a>
						<ul class=\"dropdown-menu\">
						  <li><a href=\"".$contextoDeMenu."/view/os/lista.php\">Gerenciar Ordens de Serviço</a></li>
						  <li><a href=\"".$contextoDeMenu."/view/cliente/lista.php\">Gerenciar Clientes</a></li>
						  <li><a href=\"".$contextoDeMenu."/view/chip/lista.php\">Gerenciar Chips</a></li>
						  <li><a href=\"".$contextoDeMenu."/view/funcionarios/lista.php\">Listagem de Contra Senhas</a></li>
						</ul>
					  </li>
					  <li><a href=\"".$contextoDeMenu."/view/sobre/sobre.php\">Sobre</a></li>
					</ul>
			
					";	
		//}
		
		echo $menu;	
		
	}
	
	
	public function statusDaHistoria($status){
	
		switch($status){
		
			case "E":
				$tipo = "Editando";
			break;
			
			case "I":
				$tipo = "Inativa";
			break;
			
			case "P":
				$tipo = "Publicada";
			break;
			
		}
		
		return $tipo;	
		
	}
	
	
	public function mensagemDeRetorno($tipo,$acao){
	
		//Definir o tipo de erro, o ícone e a classe de estilo utilizada para a tela de alerta
		switch($tipo){
			case 1:
				$msgA = "SUCESSO";
				$icnA = "icone_sucesso.png";
				$classe = "alert alert-success";
			break;
	
			case 2:
				$msgA = "ERRO";
				$icnA = "icone-erro.png";
				$classe = "alert alert-danger";
			break;
	
			case 3:
				$msgA = "FALHA";
				$icnA = "icone-aviso.png";
				$classe = "alert alert-warning";
			break;
	
			case 4:
				$msgA = "AVISO";
				$icnA = "icone-aviso.png";
				$classe = "alert alert-info";
			break;
	
		}
			
	
		switch($acao){
			case 1:
				$msgB = "cadastro";
			break;
	
			case 2:
				$msgB = "alteração";
			break;
	
			case 3:
				$msgB = "exclusão";
			break;
	
			case 4:
				$msgB = "logon";
			break;
	
			case 5:
				$msgB = "autenticação";
			break;
	
			case 6:
				$msgB = "pesquisa";
			break;
	
			case 7:
				$msgB = "upload de arquivo";
			break;
	
		}
	
		$mensagem = "
					<div class=\"alert alert-block ".$classe." fade in\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
						<h4 class=\"alert-heading\">".$msgA."</h4>
						<p>Ao realizar a operação de ".$msgB.".</p>
					</div>
					";		
	
		echo $mensagem;
	}
	
	public function mensagemDeRetornoPersonalizada($tipo,$mensagem){
	
		//Definir o tipo de erro, o ícone e a classe de estilo utilizada para a tela de alerta
		switch($tipo){
			case 1:
				$msgA = "SUCESSO";
				$icnA = "icone_sucesso.png";
				$classe = "alert alert-success";
			break;
	
			case 2:
				$msgA = "ERRO";
				$icnA = "icone-erro.png";
				$classe = "alert alert-danger";
			break;
	
			case 3:
				$msgA = "FALHA";
				$icnA = "icone-aviso.png";
				$classe = "alert alert-warning";
			break;
	
			case 4:
				$msgA = "AVISO";
				$icnA = "icone-aviso.png";
				$classe = "alert alert-info";
			break;
	
		}

		$retorno = "
					<div class=\"alert alert-block ".$classe." fade in\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
						<h4 class=\"alert-heading\">".$msgA."</h4>
						<p>".$mensagem."</p>
					</div>
					";		
	
		echo $retorno;
	}


//CALCULANDO DIAS NORMAIS
/*Abaixo vamos calcular a diferença entre duas datas. Fazemos uma reversão da maior sobre a menor 
para não termos um resultado negativo. */
function CalculaDias($xDataInicial, $xDataFinal){
   $time1 = $this->dataToTimestamp($xDataInicial);  
   $time2 = $this->dataToTimestamp($xDataFinal);  

   $tMaior = $time1>$time2 ? $time1 : $time2;  
   $tMenor = $time1<$time2 ? $time1 : $time2;  

   $diff = $tMaior-$tMenor;  
   $numDias = $diff/86400; //86400 é o número de segundos que 1 dia possui  
   return $numDias;
}

//LISTA DE FERIADOS NO ANO
/*Abaixo criamos um array para registrar todos os feriados existentes durante o ano.*/
function Feriados($ano,$posicao){
   $dia = 86400;
   $datas = array();
   $datas['pascoa'] = easter_date($ano);
   $datas['sexta_santa'] = $datas['pascoa'] - (2 * $dia);
   $datas['carnaval'] = $datas['pascoa'] - (47 * $dia);
   $datas['corpus_cristi'] = $datas['pascoa'] + (60 * $dia);
   $feriados = array (
      '01/01',
      '02/02', // Navegantes
      date('d/m',$datas['carnaval']),
      date('d/m',$datas['sexta_santa']),
      date('d/m',$datas['pascoa']),
      '21/04',
      '01/05',
      date('d/m',$datas['corpus_cristi']),
      '20/09', // Revolução Farroupilha \m/
      '12/10',
      '02/11',
      '15/11',
      '25/12',
   );
   
return $feriados[$posicao]."/".$ano;
}      

//FORMATA COMO TIMESTAMP
/*Esta função é bem simples, e foi criada somente para nos ajudar a formatar a data já em formato  TimeStamp facilitando nossa soma de dias para uma data qualquer.*/
function dataToTimestamp($data){
   $ano = substr($data, 6,4);
   $mes = substr($data, 3,2);
   $dia = substr($data, 0,2);
return mktime(0, 0, 0, $mes, $dia, $ano);  

} 
//SOMA 01 DIA   
function Soma1dia($data){   
   $ano = substr($data, 6,4);
   $mes = substr($data, 3,2);
   $dia = substr($data, 0,2);
return   date("d/m/Y", mktime(0, 0, 0, $mes, $dia+1, $ano));
}


//CALCULA DIAS UTEIS
/*É nesta função que faremos o calculo. Abaixo podemos ver que faremos o cálculo normal de dias ($calculoDias), após este cálculo, faremos a comparação de dia a dia, verificando se este dia é um sábado, domingo ou feriado e em qualquer destas condições iremos incrementar 1*/

function DiasUteis($yDataInicial,$yDataFinal){

   $diaFDS = 0; //dias não úteis(Sábado=6 Domingo=0)
   $calculoDias = $this->CalculaDias($yDataInicial, $yDataFinal); //número de dias entre a data inicial e a final
   $diasUteis = 0;
   
   while($yDataInicial!=$yDataFinal){
      $diaSemana = date("w", $this->dataToTimestamp($yDataInicial));
      if($diaSemana==0 || $diaSemana==6){
         //se SABADO OU DOMINGO, SOMA 01
         $diaFDS++;
      }else{
      //senão vemos se este dia é FERIADO
         for($i=0; $i<=12; $i++){
            if($yDataInicial==$this->Feriados(date("Y"),$i)){
               $diaFDS++;   
            }
         }
      }
      $yDataInicial = $this->Soma1dia($yDataInicial); //dia + 1
   }
return $calculoDias - $diaFDS;
}

}
?>