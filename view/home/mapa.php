<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

include_once("../../functions/functions.class.php");
require_once("../../controller/mapa.controller.class.php");

$mapa 	= new mapaController;
$registros 	= $mapa->listObjectsGroup();

		$aux = 1;
		$pontos = "";
		//Loop de posições dos veículos do grupo
		while($reg = sqlsrv_fetch_array($registros)){
		
		$pontos = $pontos . "['".$reg["POS_PLACA"]."', ".trim($reg["POS_LATITUDE"]).", ".trim($reg["POS_LONGITUDE"])." ,".$aux."],";
		$aux = $aux + '1';
		}
?>
<html>
        <!-- MAPA -->
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
		<script type="text/javascript">
			
			var map;
			
// Cerca
var citymap = {};
citymap['chicago'] = {
  center: new google.maps.LatLng(-22.0677016666667, -46.974785),
  radius: 2000 //2km
};
citymap['newyork'] = {
  center: new google.maps.LatLng(-22.4677, -46.574785),
  radius: 2000
};
citymap['losangeles'] = {
  center: new google.maps.LatLng(-22.6677, -47.774785),
  radius: 2000
}
var cityCircle;

//Fim da Cerca
			
			
			function initialize(){
				var myLatlng = new google.maps.LatLng(-22.0677016666667, -46.974785);
				var myOptions = {
					zoom: 10,
					center: myLatlng,
					mapTypeControl: true,
					mapTypeControlOptions: {
						style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
					},
					zoomControl: true,
					zoomControlOptions: {
						style: google.maps.ZoomControlStyle.SMALL
					},
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}
				
				map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);


				//Cerca
				
				  for (var city in citymap) {
					// Construct the circle for each value in citymap. We scale population by 20.
					var populationOptions = {
					  strokeColor: "#FF0000",
					  strokeOpacity: 0.8,
					  strokeWeight: 2,
					  fillColor: "#FF0000",
					  fillOpacity: 0.35,
					  map: map,
					  center: citymap[city].center,
					  radius: citymap[city].radius
					};
			//		cityCircle = new google.maps.Circle(populationOptions);
				  }
				
				//Fim da Cerca


				setMarkers(map, pontos);
				
				//Cria serviço de elevação
				elevator = new google.maps.ElevationService();
				
				checarMovimentacao();
			
				//Busca
				var input = document.getElementById('searchTextField');
				var autocomplete = new google.maps.places.Autocomplete(input);

				autocomplete.bindTo('bounds', map);

				var infowindow = new google.maps.InfoWindow();
				
				var marcador = new google.maps.MarkerImage('http://189.111.190.44/intranet/prototipo/img/icons/marker_a.png',
					new google.maps.Size(16, 26),
					new google.maps.Point(0,0),
					new google.maps.Point(0, 13));
				
				var marker = new google.maps.Marker({
					icon: marcador,
					title: "Ponto de Referência",
					map: map
				});

				google.maps.event.addListener(autocomplete, 'place_changed', function() {
					infowindow.close();
					var place = autocomplete.getPlace();
					if (place.geometry.viewport) {
						map.fitBounds(place.geometry.viewport);
					}else{
						map.setCenter(place.geometry.location);
						map.setZoom(17);  // Why 17? Because it looks good.
					}

					var image = new google.maps.MarkerImage(
						place.icon, new google.maps.Size(71, 71),
						new google.maps.Point(0, 0), new google.maps.Point(17, 34),
						new google.maps.Size(35, 35));
						marker.setIcon(marcador);
						marker.setDraggable(true);
						marker.setPosition(place.geometry.location);

					var address = '';
					
					if (place.address_components) {
						address = [
						(place.address_components[0] &&
						place.address_components[0].short_name || ''),
						(place.address_components[1] &&
						place.address_components[1].short_name || ''),
						(place.address_components[2] &&
						place.address_components[2].short_name || '')].join(' ');
					}

					infowindow.setContent('<div id="cadref"><table><tr><td><img src="img/icons/icon_referencia.png"></td><td><b style="font-size:14px; font-family: Arial">Cadastro de Ponto de Referência</b></td></tr><tr><td>Movimente o marcador para capturar as coordenadas do ponto.</td></tr></table><table><tr><td colspan="2">&nbsp;</td></tr><tr><td>Nome do ponto:</td><td><input style="background-color:#FFF; color:#333; font-size:11px; font-family:Verdana; border: 1px solid #333; width:200px; padding:4px 4px 4px 4px;" type="text" id="nomeponto" value="' + place.name + '"></td></tr><tr><td>Tipo de Referência</td><td><select style="background-color:#FFF; color:#333; font-size:11px; font-family:Verdana; border: 1px solid #333; width:200px;font-weight:normal;" name="tipoponto"><option value="0" selected>Tipos de Refer&ecirc;ncias</option><option value="13">&Aacute;rea de Descanso</option><option value="4">Armaz&eacute;m</option><option value="5">Distribuidora</option><option value="2">Hospital</option><option value="7">Local de Coleta</option><option value="6">Local de Descarga</option><option value="3">Loja</option><option value="8">Oficina Mec&acirc;nica</option><option value="12">Pol&iacute;cia</option><option value="9">Porto</option><option value="1">Posto de Combust&iacute;vel</option><option value="11">Pousada / Hotel</option><option value="10">Restaurante</option></select></td></tr><tr><td>Latitude</td><td><input style="background-color:#FFF; color:#333; font-size:11px; font-family:Verdana; border: 1px solid #333; width:200px; padding:4px 4px 4px 4px;" id="latitude" type="text" value="" /></td></tr><td>Longitude</td><td><input style="background-color:#FFF; color:#333; font-size:11px; font-family:Verdana; border: 1px solid #333; width:200px; padding:4px 4px 4px 4px;" id="longitude" type="text" value="" /></td></tr><tr><td>&nbsp;</td><td><input style="background-color:#272727; color:#FFF; font-size:11px; font-family:Verdana; border: 1px solid #333; width:200px; padding:4px 4px 4px 4px;" type="button" value="Cadastrar"></td></tr></table></div>');
					infowindow.open(map, marker);

				});
				
				google.maps.event.addListener(marker, 'dragend', function(evt){
					document.getElementById('latitude').value = evt.latLng.lat();
    				document.getElementById('longitude').value = evt.latLng.lng();
				});

				// Sets a listener on a radio button to change the filter type on Places
				// Autocomplete.
				var setupClickListener = function(id, types) {
					var radioButton = document.getElementById(id);
					google.maps.event.addDomListener(radioButton, 'click', function() {
						autocomplete.setTypes(types);
					});
				}

				setupClickListener('changetype-all', []);
				setupClickListener('changetype-establishment', ['establishment']);
				setupClickListener('changetype-geocode', ['geocode']);
				//Fim da Busca
				
				
			
          }
		  
		  //Busca
		  //google.maps.event.addDomListener(window, 'load', initialize);
		  //Fim da Busca
		  
		</script>
        
        
	<script type="text/javascript">
		
		var markersArray = [];
		var veiculosDaFrota = [];
		var novolocal;
		infos = []; // Variável de informações
		
		// Checar movimentação de veículos
		function checarMovimentacao(){
			setInterval(function(){
				
				//alert("Aqui");
				
				closeInfos();
				
				// Ajax
				xmlhttp.open("GET", "ajax/listar/listar_Posicoes.asp",true);
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4){
						if (xmlhttp.status == 200){
							//Resposta da Requisição
							var aResposta = (xmlhttp.responseText);
							//aResposta = aResposta.replace(/^\s+|\s+$/g,"");
							
							var pontosB = aResposta.split("#");
							//alert(pontosB.length);
							
							if (markersArray) {
								for (i in markersArray) {
									
									var pontoNovo = pontosB[i].split(",");
									
									//alert(pontoNovo[1] +" ou "+ pontoNovo[2]);
									
									novolocal = new google.maps.LatLng(pontoNovo[1], pontoNovo[2]);
									markersArray[i].setPosition(novolocal);
									
									if(pontoNovo[4]!=0){
										var marcadoratl = new google.maps.MarkerImage('http://189.111.190.44/intranet/prototipo/img/icons/truck_c.png',
											new google.maps.Size(30, 30),
											new google.maps.Point(0,0),
											new google.maps.Point(0, 15));
									}else{
										var marcadoratl = new google.maps.MarkerImage('http://189.111.190.44/intranet/prototipo/img/icons/truck_a.png',
											new google.maps.Size(30, 30),
											new google.maps.Point(0,0),
											new google.maps.Point(0, 15));
									}
									markersArray[i].setIcon(marcadoratl);
									
								}
							}
							
							
						}else{
							//Erro na resposta da requisição
							alert("Sua requisição não retornou um resultado válido.\nErro: "+xmlhttp.status+"\nRetorno: "+xmlhttp.status);
						}
					}
				}
				xmlhttp.send(null);
				// Fim do Ajax
				
				//pontosB = [listarPosicoes();];
				

			},60000);// 1 minuto
		}

		// Array de pontos
		var pontos = [<?php echo($pontos)?>];

		// Adicionar Pontos
		function setMarkers(map, locations) {
		
			var image = new google.maps.MarkerImage('http://189.111.190.44/intranet/prototipo/img/icons/truck_c.png',
				new google.maps.Size(30, 30),
				new google.maps.Point(0,0),
				new google.maps.Point(0, 15));
		
			for (var i = 0; i < locations.length; i++) {
				
				var ponto = locations[i];
				var htmlinfo = '<div id="infoWindow"><table><tr><th style="color:#369; padding-right: 15px; font-size:24px; font-family:Arial; font-weight:bold; background-color:#FFF;">'+ponto[0]+'</th><th><a href="#" onclick="chamaJanela('+i+',&quot;M&quot;,&quot;'+ponto[0]+'&quot;,&quot;'+ponto[1]+'&quot;,&quot;'+ponto[2]+'&quot;);"><img src="img/icons/icon_message.png"></a></th><th><a href="#" onclick="chamaJanela('+i+',&quot;P&quot;,&quot;'+ponto[0]+'&quot;,&quot;'+ponto[1]+'&quot;,&quot;'+ponto[2]+'&quot;);"><img src="img/icons/icon_position.png"></a></th><!--<th><a href="#" onclick="chamaJanela('+i+',&quot;I&quot;,&quot;'+ponto[0]+'&quot;,&quot;'+ponto[1]+'&quot;,&quot;'+ponto[2]+'&quot;);"><img src="img/icons/icon_info.png"></a></th>--><th><a href="#" onclick="chamaJanela('+i+',&quot;G&quot;,&quot;'+ponto[0]+'&quot;,&quot;'+ponto[1]+'&quot;,&quot;'+ponto[2]+'&quot;);"><img src="img/icons/icon_sts.png"></a></th></tr><tr><td colspan="5" style="height:200px;"><div style="height:200px; overflow-y:scroll" id="tela_'+ponto[0]+'_'+i+'"><br><br><br><br>Selecione uma das opções acima para<br> mais informações do veículo.</div></td></tr></table>';
				var myLatLng = new google.maps.LatLng(ponto[1], ponto[2]);
				var marker = new google.maps.Marker({
					position: myLatLng,
					map: map,
					icon: image,
					title: ponto[0],
					content:htmlinfo,
					zIndex: ponto[3]
				});
				
				// Guardando os makers em um array
				markersArray.push(marker);
				veiculosDaFrota.push(ponto[0]);
		
				// Insere os pontos no mapa
				google.maps.event.addListener(marker, 'click', function() {
					closeInfos();
					var info = new google.maps.InfoWindow({content: this.content,maxWidth: 420,pixelOffset : new google.maps.Size(10,10)});
					info.open(map,this);
					infos[0]=info;
					
				});
			}
		}
		
		// Fechar Janelas de Informações
		function closeInfos(){
			if(infos.length > 0){
				infos[0].set("marker",null);
				infos[0].close();
				infos.length = 0;
			}
		}
		
		
		 // Removes the overlays from the map, but keeps them in the array
		  function clearOverlays() {
			if (markersArray) {
			  for (i in markersArray) {
				document.getElementById('exibirVeiculo_'+i).checked = false;
				markersArray[i].setMap(null);
			  }
			}
		  }
		
		  // Shows any overlays currently in the array
		  function showOverlays() {
			if (markersArray) {
			  for (i in markersArray) {
				document.getElementById('exibirVeiculo_'+i).checked = true;
				markersArray[i].setMap(map);
			  }
			}
		  }
		  
		  
		function filtraVeiculos(){
			if (document.getElementById('filtraVeiculo').checked == true){
				showOverlays();
			}else{
				clearOverlays();
			}
		}
		  
		  
		function checaVeiculo(veiculo){
			if (document.getElementById('exibirVeiculo_'+veiculo).checked == true){
				markersArray[veiculo].setMap(map);
			}else{
				markersArray[veiculo].setMap(null);
			}
		}
		
		
		// Centralizar Mapa
		/**/
		function centralizaMapa(marcadordoponto,latitude,longitude){
			
			var marcadorimg = new google.maps.MarkerImage('http://189.111.190.44/intranet/prototipo/img/icons/truck_b.png',
				new google.maps.Size(30, 30),
				new google.maps.Point(0,0),
				new google.maps.Point(0, 15));
				
			markersArray[marcadordoponto].setIcon(marcadorimg);
			novolocalmarcador = new google.maps.LatLng(latitude, longitude);
			map.setCenter(novolocalmarcador);
			map.setZoom(18);
		
		}
		
		
		var elevator;
		//Captura Altitude
		function listarGraficos(placa,tela,latgraf,lnggraf){

			var locations = [];
			
			locations[0] = new google.maps.LatLng(latgraf,lnggraf);
			//alert(locations[0]);
		
			var positionalRequest = {
				'locations': locations
			}
			
			elevator.getElevationForLocations(positionalRequest, function(results, status) {
			 
				if (status == google.maps.ElevationStatus.OK) {
					
					if(results[0]){
						
						//alert(results[0].elevation);
						document.getElementById(tela).innerHTML = "A elevação do local onde este ponto está,<br>em relação ao nível do mar é de: <br><br><img src='img/icons/icon_mountain.png' ><h1 style='color:#15adff; line-height:10px;'>" + Math.round(results[0].elevation) + " Metros</h1>"
			
					}else{
						alert("Resultado não encontrado");
					}
				}else{
					alert("Serviço de consulta de elevação falhou: " + status);
				}
			});
		}
		

		function buscaVeiculos(placa){
			
			var contaVeiculos = 0;
			
			if(placa.length > 0){
				if (markersArray) {
					
					//document.getElementById("searchCar").value = placa.toUpperCase();
					//buscaPosicaoDosVeiculos(placa.toUpperCase());
		
					clearOverlays();
					
					for(var i=0;i<markersArray.length;i++){	
						if(veiculosDaFrota[i].indexOf(placa.toUpperCase()) == 0){
							contaVeiculos++;
							document.getElementById('exibirVeiculo_'+i).checked = true;
							checaVeiculo(i);
						}
					}
				}
			}else{
				clearOverlays();
				showOverlays();
			}
		}
	
		
		// Chamar Janelas de Informações Internas
		function chamaJanela(ponto,tipo,placa,latitude,longitude){
			var tela = "tela_"+placa+"_"+ponto;
			switch (tipo) {
				case "M":
					enviarMensagem(placa,tela);
					break;
				case "P":
					listarPontos(placa,tela);
					break;
				case "I":
					listarInformacoes(placa,tela);
					break;
				case "G":
					listarGraficos(placa,tela,latitude,longitude);
					break;
			}
		}
		</script>

        <!-- FIM DO MAPA --> 
               
        <style>
		
			#map_canvas{
				margin-top: 0px;	
				width:100%;
				height:100%;
			}
					
        </style>
       
       
	</head>
    <body onLoad="initialize()">
        
        <!-- MAPA -->
	<div id="map_canvas"></div>
        <!-- FIM DO MAPA -->
            </body>
</html>