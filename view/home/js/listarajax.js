// LISTAR NO SISTEMA VIA AJAX

//Função para listar os itens
function listarInformacoes(placa,tela){
    xmlhttp.open("GET", "ajax/listar/listar_Informacoes.asp?C00="+placa,true);
	xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4){
			if (xmlhttp.status == 200){
				//Resposta da Requisição
				var aResposta = (xmlhttp.responseText);
				aResposta = aResposta.replace(/^\s+|\s+$/g,"");
				
				document.getElementById(tela).innerHTML = aResposta;
				
			}else{
				//Erro na resposta da requisição
				alert("Sua requisição não retornou um resultado válido.\nErro: "+xmlhttp.status)	
			}
        }else{
			if(xmlhttp.readyState==3){
				document.getElementById(tela).innerHTML = "<br><br><br><center><img src='img/icons/loading.gif'><br>carregando...</center>";
			}
		}
    }
    xmlhttp.send(null);
}

//Função para listar os itens
function listarPontos(placa,tela){
    xmlhttp.open("GET", "ajax/listar/listar_Pontos.asp?C00="+placa,true);
	xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4){
			if (xmlhttp.status == 200){
				//Resposta da Requisição
				var aResposta = (xmlhttp.responseText);
				aResposta = aResposta.replace(/^\s+|\s+$/g,"");
				
				document.getElementById(tela).innerHTML = aResposta;
				
			}else{
				//Erro na resposta da requisição
				alert("Sua requisição não retornou um resultado válido.\nErro: "+xmlhttp.status)	
			}
        }else{
			if(xmlhttp.readyState==3){
				document.getElementById(tela).innerHTML = "<br><br><br><center><img src='img/icons/loading.gif'><br>carregando...</center>";
			}
		}
    }
    xmlhttp.send(null);
}

//Função para listar os itens
function buscaPosicaoDosVeiculos(placa){
	//if(placa.length > 2){
		xmlhttp.open("GET", "ajax/listar/listar_Veiculos.asp?C00="+placa,true);
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4){
				if (xmlhttp.status == 200){
					//Resposta da Requisição
					var aResposta = (xmlhttp.responseText);
					aResposta = aResposta.replace(/^\s+|\s+$/g,"");
					
					document.getElementById('veiculos').innerHTML = aResposta;
					
				}else{
					//Erro na resposta da requisição
					alert("Sua requisição não retornou um resultado válido.\nErro: "+xmlhttp.status)	
				}
			}else{
				if(xmlhttp.readyState==3){
					document.getElementById('veiculos')	.innerHTML = "<br><br><br><center><img src='img/icons/loading.gif'><br>carregando...</center>";
				}
			}
		}
		xmlhttp.send(null);
	//}
}



//Função para listar os itens
function enviarMensagem(placa,tela){
	
	var terminal 	= "853";
	var modelo		= "15";
	
    xmlhttp.open("GET", "ajax/enviar/enviar_MensagemGprs.asp?placa="+placa+"&terminal="+terminal+"&modelo="+modelo,true);
	xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4){
			if (xmlhttp.status == 200){
				//Resposta da Requisição
				var aResposta = (xmlhttp.responseText);
				aResposta = aResposta.replace(/^\s+|\s+$/g,"");
				
				document.getElementById(tela).innerHTML = aResposta;
				
			}else{
				//Erro na resposta da requisição
				alert("Sua requisição não retornou um resultado válido.\nErro: "+xmlhttp.status)	
			}
        }else{
			if(xmlhttp.readyState==3){
				document.getElementById(tela).innerHTML = "<br><br><br><center><img src='img/icons/loading.gif'><br>carregando...</center>";
			}
		}
    }
    xmlhttp.send(null);
}