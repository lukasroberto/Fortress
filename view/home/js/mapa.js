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
		  
		