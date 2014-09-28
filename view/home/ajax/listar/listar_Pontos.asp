<!-- #include file="../../functions/conecta.asp" -->
<%
if session("ok") <> TRUE then
	'Erro: Você deve estar logado para acessar esta área (caso o usuário tente acessar esta página diretamente)
	Response.Redirect("../../login.asp?erro=3")
end if

placa = Request.QueryString("C00")

SQL = "SELECT ID_POSICOES, POS_PLACA, POS_LOCAL, POS_ESTADO, POS_RUA, POS_DATAHORA, POS_STATUS, POS_LATITUDE, POS_LONGITUDE, ID_ALERTA, POS_AREA, POS_PANICO, POS_DATAHORABRA, ID_SEN1, ID_SEN2, ID_SEN3, ID_SEN4, POS_COMUNICADOR"
SQL = SQL & " FROM TAB_POSICOES WHERE POS_PLACA = '"&placa&"'"
Set rs = con.Execute(SQL)
%>


<%
'Veículo em movimento
filtro = Instr(rs.fields("POS_STATUS"),"- 0 KM/H")
if filtro <> 0 then
	icone = "c"
	mvel = "Veículo Parado"
else
	icone = "a"
	mvel = "Veículo em Deslocamento"
end if
%>

<%
	
			
	'ALERTAS DA VIAGEM
	'##########################################
	opcao1 = rs.fields("ID_ALERTA")
	Select Case opcao1
		Case 1: alerta1 	= "1"
				alerta2 	= "1"
				alerta3 	= "1"
				alerta4 	= "1"
				mensag1		= "Veículo com pânico ativo"
				mensag2		= "Veículo fora rota"
				mensag3		= "Veículo dentro da área de risco"
				mensag4		= "Veículo próximo da parada"
				linha = "D"
		Case 2: alerta1 	= "1"
				alerta2 	= "1"
				alerta3 	= "1"
				alerta4 	= "0"
				mensag1		= "Veículo com pânico ativo"
				mensag2		= "Veículo fora rota"
				mensag3		= "Veículo dentro da área de risco"
				mensag4		= "Veículo distante da parada"
				linha = "D"				
		Case 3: alerta1 	= "1"
				alerta2 	= "1"
				alerta3 	= "0"
				alerta4 	= "1"
				mensag1		= "Veículo com pânico ativo"
				mensag2		= "Veículo fora rota"
				mensag3		= "Veículo fora da área de risco"
				mensag4		= "Veículo próximo da parada"
				linha = "D"
		Case 4: alerta1 	= "1"
				alerta2 	= "1"
				alerta3 	= "0"
				alerta4 	= "0"
				mensag1		= "Veículo com pânico ativo"
				mensag2		= "Veículo fora rota"
				mensag3		= "Veículo fora da área de risco"
				mensag4		= "Veículo distante da parada"
				linha = "D"
		Case 5: alerta1 	= "1"
				alerta2 	= "0"
				alerta3 	= "1"
				alerta4 	= "1"
				mensag1		= "Veículo com pânico ativo"
				mensag2		= "Veículo dentro da rota"
				mensag3		= "Veículo dentro da área de risco"
				mensag4		= "Veículo próximo da parada"
				linha = "D"
		Case 6: alerta1 	= "1"
				alerta2 	= "0"
				alerta3 	= "1"
				alerta4 	= "0"
				mensag1		= "Veículo com pânico ativo"
				mensag2		= "Veículo dentro da rota"
				mensag3		= "Veículo dentro da área de risco"
				mensag4		= "Veículo distante da parada"
				linha = "D"
		Case 7: alerta1 	= "1"
				alerta2 	= "0"
				alerta3 	= "0"
				alerta4 	= "1"
				mensag1		= "Veículo com pânico ativo"
				mensag2		= "Veículo dentro da rota"
				mensag3		= "Veículo fora da área de risco"
				mensag4		= "Veículo próximo da parada"
				linha = "D"
		Case 8: alerta1 	= "1"
				alerta2 	= "0"
				alerta3 	= "0"
				alerta4 	= "0"
				mensag1		= "Veículo com pânico ativo"
				mensag2		= "Veículo dentro da rota"
				mensag3		= "Veículo fora da área de risco"
				mensag4		= "Veículo distante da parada"
				linha = "D"
		Case 9: alerta1 	= "0"
				alerta2 	= "1"
				alerta3 	= "1"
				alerta4 	= "1"
				mensag1		= "Veículo sem pânico"
				mensag2		= "Veículo fora rota"
				mensag3		= "Veículo dentro da área de risco"
				mensag4		= "Veículo próximo da parada"
				linha = "D"
		Case 10:alerta1 	= "0"
				alerta2 	= "1"
				alerta3 	= "1"
				alerta4 	= "0"
				mensag1		= "Veículo sem pânico"
				mensag2		= "Veículo fora rota"
				mensag3		= "Veículo dentro da área de risco"
				mensag4		= "Veículo distante da parada"
				linha = "D"
		Case 11:alerta1 	= "0"
				alerta2 	= "1"
				alerta3 	= "0"
				alerta4 	= "1"
				mensag1		= "Veículo sem pânico"
				mensag2		= "Veículo fora rota"
				mensag3		= "Veículo fora da área de risco"
				mensag4		= "Veículo próximo da parada"
				linha = "D"
		Case 12:alerta1 	= "0"
				alerta2 	= "1"
				alerta3 	= "0"
				alerta4 	= "0"
				mensag1		= "Veículo sem pânico"
				mensag2		= "Veículo fora rota"
				mensag3		= "Veículo fora da área de risco"
				mensag4		= "Veículo distante da parada"
				linha = "D"
		Case 13:alerta1 	= "0"
				alerta2 	= "0"
				alerta3 	= "1"
				alerta4 	= "1"
				mensag1		= "Veículo sem pânico"
				mensag2		= "Veículo dentro da rota"
				mensag3		= "Veículo dentro da área de risco"
				mensag4		= "Veículo próximo da parada"
				linha = "D"
		Case 14:alerta1 	= "0"
				alerta2 	= "0"
				alerta3 	= "1"
				alerta4 	= "0"
				mensag1		= "Veículo sem pânico"
				mensag2		= "Veículo dentro da rota"
				mensag3		= "Veículo dentro da área de risco"
				mensag4		= "Veículo distante da parada"
				linha = "D"
		Case 15:alerta1 	= "0"
				alerta2 	= "0"
				alerta3 	= "0"
				alerta4 	= "1"
				mensag1		= "Veículo sem pânico"
				mensag2		= "Veículo dentro da rota"
				mensag3		= "Veículo fora da área de risco"
				mensag4		= "Veículo próximo da parada"
				linha = "D"
		Case 16:alerta1 	= "0"
				alerta2 	= "0"
				alerta3 	= "0"
				alerta4 	= "0"
				mensag1		= "Veículo sem pânico"
				mensag2		= "Veículo dentro da rota"
				mensag3		= "Veículo fora da área de risco"
				mensag4		= "Veículo distante da parada"
		Case Else
				alerta1 	= "0"
				alerta2 	= "0"
				alerta3 	= "0"
				alerta4 	= "0"
				mensag1		= "Veículo sem pânico"
				mensag2		= "Veículo dentro da rota"
				mensag3		= "Veículo fora da área de risco"
				mensag4		= "Veículo distante da parada"
	End Select
	'##########################################				


		
	'BLOCO DE SENSORES 1
	'##########################################
	opcao2 = rs.fields("ID_SEN1")
	Select Case opcao2
		Case 20:alerta5 	= "2"
				alerta6 	= "img_icn_sengate_0.gif"
				alerta7 	= "img_icn_sbau_0.gif"
				alerta8 	= "2"
				mensag5		= "Sensor de Porta Ativado - Porta Aberta"
				mensag6		= "Sensor de Engate Ativado - Carreta Desengatada"
				mensag7		= "Sensor de Baú Ativado - Baú Aberto"
				mensag8		= "Chave Ligada"				
		Case 28:alerta5 	= "0"
				alerta6 	= "img_icn_sengate_0.gif"
				alerta7 	= "img_icn_sbau_0.gif"
				alerta8 	= "2"
				mensag5		= "Sensor de Porta Desativado - Porta Fechada"
				mensag6		= "Sensor de Engate Ativado - Carreta Desengatada"
				mensag7		= "Sensor de Baú Ativado - Baú Aberto"
				mensag8		= "Chave Ligada"				
		Case 24:alerta5 	= "2"
				alerta6 	= "img_icn_sengate_1.gif"
				alerta7 	= "img_icn_sbau_0.gif"
				alerta8 	= "2"
				mensag5		= "Sensor de Porta Ativado - Porta Aberta"
				mensag6		= "Sensor de Engate Desativado - Cavalo/Carreta Engatada"
				mensag7		= "Sensor de Baú Ativado - Baú Aberto"
				mensag8		= "Chave Ligada"				
		Case 32:alerta5 	= "0"
				alerta6 	= "img_icn_sengate_1.gif"
				alerta7 	= "img_icn_sbau_0.gif"
				alerta8 	= "2"
				mensag5		= "Sensor de Porta Desativado - Porta Fechada"
				mensag6		= "Sensor de Engate Desativado - Cavalo/Carreta Engatada"
				mensag7		= "Sensor de Baú Ativado - Baú Aberto"
				mensag8		= "Chave Ligada"				
		Case 22:alerta5 	= "2"
				alerta6 	= "img_icn_sengate_0.gif"
				alerta7 	= "img_icn_sbau_1.gif"
				alerta8 	= "2"
				mensag5		= "Sensor de Porta Ativado - Porta Aberta"
				mensag6		= "Sensor de Engate Ativado - Carreta Desengatada"
				mensag7		= "Sensor de Baú Desativado - Baú Fechado"
				mensag8		= "Chave Ligada"				
		Case 30:alerta5 	= "0"
				alerta6 	= "img_icn_sengate_0.gif"
				alerta7 	= "img_icn_sbau_1.gif"
				alerta8 	= "2"
				mensag5		= "Sensor de Porta Desativado - Porta Fechada"
				mensag6		= "Sensor de Engate Ativado - Carreta Desengatada"
				mensag7		= "Sensor de Baú Desativado - Baú Fechado"
				mensag8		= "Chave Ligada"				
		Case 26:alerta5 	= "2"
				alerta6 	= "img_icn_sengate_1.gif"
				alerta7 	= "img_icn_sbau_1.gif"
				alerta8 	= "2"
				mensag5		= "Sensor de Porta Ativado - Porta Aberta"
				mensag6		= "Sensor de Engate Desativado - Cavalo/Carreta Engatada"
				mensag7		= "Sensor de Baú Desativado - Baú Fechado"
				mensag8		= "Chave Ligada"				
		Case 34:alerta5 	= "0"
				alerta6 	= "img_icn_sengate_1.gif"
				alerta7 	= "img_icn_sbau_1.gif"
				alerta8 	= "2"
				mensag5		= "Sensor de Porta Desativado - Porta Fechada"
				mensag6		= "Sensor de Engate Desativado - Cavalo/Carreta Engatada"
				mensag7		= "Sensor de Baú Desativado - Baú Fechado"
				mensag8		= "Chave Ligada"				
		Case 21:alerta5 	= "2"
				alerta6 	= "img_icn_sengate_0.gif"
				alerta7 	= "img_icn_sbau_0.gif"
				alerta8 	= "0"
				mensag5		= "Sensor de Porta Ativado - Porta Aberta"
				mensag6		= "Sensor de Engate Ativado - Carreta Desengatada"
				mensag7		= "Sensor de Baú Ativado - Baú Aberto"
				mensag8		= "Chave Desligada"				
		Case 29:alerta5 	= "0"
				alerta6 	= "img_icn_sengate_0.gif"
				alerta7 	= "img_icn_sbau_0.gif"
				alerta8 	= "0"
				mensag5		= "Sensor de Porta Desativado - Porta Fechada"
				mensag6		= "Sensor de Engate Ativado - Carreta Desengatada"
				mensag7		= "Sensor de Baú Ativado - Baú Aberto"
				mensag8		= "Chave Desligada"				
		Case 25:alerta5 	= "2"
				alerta6 	= "img_icn_sengate_1.gif"
				alerta7 	= "img_icn_sbau_0.gif"
				alerta8 	= "0"
				mensag5		= "Sensor de Porta Ativado - Porta Aberta"
				mensag6		= "Sensor de Engate Desativado - Cavalo/Carreta Engatada"
				mensag7		= "Sensor de Baú Ativado - Baú Aberto"
				mensag8		= "Chave Desligada"				
		Case 33:alerta5 	= "0"
				alerta6 	= "img_icn_sengate_1.gif"
				alerta7 	= "img_icn_sbau_0.gif"
				alerta8 	= "0"
				mensag5		= "Sensor de Porta Desativado - Porta Fechada"
				mensag6		= "Sensor de Engate Desativado - Cavalo/Carreta Engatada"
				mensag7		= "Sensor de Baú Ativado - Baú Aberto"
				mensag8		= "Chave Desligada"				
		Case 23:alerta5		= "2"
				alerta6 	= "img_icn_sengate_0.gif"
				alerta7 	= "img_icn_sbau_1.gif"
				alerta8 	= "0"
				mensag5		= "Sensor de Porta Ativado - Porta Aberta"
				mensag6		= "Sensor de Engate Ativado - Carreta Desengatada"
				mensag7		= "Sensor de Baú Desativado - Baú Fechado"
				mensag8		= "Chave Desligada"				
		Case 31:alerta5 	= "0"
				alerta6 	= "img_icn_sengate_0.gif"
				alerta7 	= "img_icn_sbau_1.gif"
				alerta8 	= "0"
				mensag5		= "Sensor de Porta Desativado - Porta Fechada"
				mensag6		= "Sensor de Engate Ativado - Carreta Desengatada"
				mensag7		= "Sensor de Baú Desativado - Baú Fechado"
				mensag8		= "Chave Desligada"				
		Case 27:alerta5 	= "2"
				alerta6 	= "img_icn_sengate_1.gif"
				alerta7 	= "img_icn_sbau_1.gif"
				alerta8 	= "0"
				mensag5		= "Sensor de Porta Ativado - Porta Aberta"
				mensag6		= "Sensor de Engate Desativado - Cavalo/Carreta Engatada"
				mensag7		= "Sensor de Baú Desativado - Baú Fechado"
				mensag8		= "Chave Desligada"				
		Case 35:alerta5 	= "0"
				alerta6 	= "img_icn_sengate_1.gif"
				alerta7 	= "img_icn_sbau_1.gif"
				alerta8 	= "0"
				mensag5		= "Sensor de Porta Desativado - Porta Fechada"
				mensag6		= "Sensor de Engate Desativado - Cavalo/Carreta Engatada"
				mensag7		= "Sensor de Baú Desativado - Baú Fechado"
				mensag8		= "Chave Desligada"				
		Case Else
				alerta5 	= "0"
				alerta6 	= "img_icn_sengate_0.gif"
				alerta7 	= "img_icn_sbau_1.gif"
				alerta8 	= "0"
				mensag5		= "Sensor de Porta Desativado - Porta Fechada"
				mensag6		= "Sensor de Engate Ativado - Carreta Desengatada"
				mensag7		= "Sensor de Baú Desativado - Baú Fechado"
				mensag8		= "Chave Desligada"				
	End Select				
	'##########################################

		
	'BLOCO DE SENSORES 2
	'##########################################
	opcao3 = rs.fields("ID_SEN2")
	Select Case opcao3
		Case 40:alerta9 	= "img_icn_tengate_1.gif"
				alerta10 	= "2"
				alerta11 	= "img_icn_tsolenoide_1.gif"
				alerta12 	= "0"
				mensag9		= "Trava de Engate Ativada - Engate Travado"
				mensag10	= "Trava Elétrica Ativada - Veículo Travado"
				mensag11	= "Trava Solenóide Ativada - Veículo Travado por Válvula"
				mensag12	= "Sirene Desligada"				
		Case 48:alerta9 	= "img_icn_tengate_0.gif"
				alerta10 	= "2"
				alerta11 	= "img_icn_tsolenoide_1.gif"
				alerta12 	= "0"
				mensag9		= "Trava de Engate Desativada - Engate Destravado"
				mensag10	= "Trava Elétrica Ativada - Veículo Travado"
				mensag11	= "Trava Solenóide Ativada - Veículo Travado por Válvula"
				mensag12	= "Sirene Desligada"				
		Case 44:alerta9 	= "img_icn_tengate_1.gif"
				alerta10 	= "0"
				alerta11 	= "img_icn_tsolenoide_1.gif"
				alerta12 	= "0"
				mensag9		= "Trava de Engate Ativada - Engate Travado"
				mensag10	= "Trava Elétrica Desativada - Veículo Destravado"
				mensag11	= "Trava Solenóide Ativada - Veículo Travado por Válvula"
				mensag12	= "Sirene Desligada"				
		Case 52:alerta9 	= "img_icn_tengate_0.gif"
				alerta10 	= "0"
				alerta11 	= "img_icn_tsolenoide_1.gif"
				alerta12 	= "0"
				mensag9		= "Trava de Engate Desativada - Engate Destravado"
				mensag10	= "Trava Elétrica Desativada - Veículo Destravado"
				mensag11	= "Trava Solenóide Ativada - Veículo Travado por Válvula"
				mensag12	= "Sirene Desligada"				
		Case 42:alerta9 	= "img_icn_tengate_1.gif"
				alerta10 	= "2"
				alerta11 	= "img_icn_tsolenoide_0.gif"
				alerta12 	= "0"
				mensag9		= "Trava de Engate Ativada - Engate Travado"
				mensag10	= "Trava Elétrica Ativada - Veículo Travado"
				mensag11	= "Trava Solenóide Desativada - Veículo Destravado por Válvula"
				mensag12	= "Sirene Desligada"				
		Case 50:alerta9 	= "img_icn_tengate_0.gif"
				alerta10 	= "2"
				alerta11 	= "img_icn_tsolenoide_0.gif"
				alerta12 	= "0"
				mensag9		= "Trava de Engate Desativada - Engate Destravado"
				mensag10	= "Trava Elétrica Ativada - Veículo Travado"
				mensag11	= "Trava Solenóide Desativada - Veículo Destravado por Válvula"
				mensag12	= "Sirene Desligada"				
		Case 46:alerta9 	= "img_icn_tengate_1.gif"
				alerta10 	= "0"
				alerta11 	= "img_icn_tsolenoide_0.gif"
				alerta12 	= "0"
				mensag9		= "Trava de Engate Ativada - Engate Travado"
				mensag10	= "Trava Elétrica Desativada - Veículo Destravado"
				mensag11	= "Trava Solenóide Desativada - Veículo Destravado por Válvula"
				mensag12	= "Sirene Desligada"				
		Case 54:alerta9 	= "img_icn_tengate_0.gif"
				alerta10 	= "0"
				alerta11 	= "img_icn_tsolenoide_0.gif"
				alerta12 	= "0"
				mensag9		= "Trava de Engate Desativada - Engate Destravado"
				mensag10	= "Trava Elétrica Desativada - Veículo Destravado"
				mensag11	= "Trava Solenóide Desativada - Veículo Destravado por Válvula"
				mensag12	= "Sirene Desligada"				
		Case 41:alerta9 	= "img_icn_tengate_1.gif"
				alerta10 	= "2"
				alerta11 	= "img_icn_tsolenoide_1.gif"
				alerta12 	= "2"
				mensag9		= "Trava de Engate Ativada - Engate Travado"
				mensag10	= "Trava Elétrica Ativada - Veículo Travado"
				mensag11	= "Trava Solenóide Ativada - Veículo Travado por Válvula"
				mensag12	= "Sirene Ligada"				
		Case 49:alerta9 	= "img_icn_tengate_0.gif"
				alerta10 	= "2"
				alerta11 	= "img_icn_tsolenoide_1.gif"
				alerta12 	= "2"
				mensag9		= "Trava de Engate Desativada - Engate Destravado"
				mensag10	= "Trava Elétrica Ativada - Veículo Travado"
				mensag11	= "Trava Solenóide Ativada - Veículo Travado por Válvula"
				mensag12	= "Sirene Ligada"				
		Case 45:alerta9 	= "img_icn_tengate_1.gif"
				alerta10 	= "0"
				alerta11 	= "img_icn_tsolenoide_1.gif"
				alerta12 	= "2"
				mensag9		= "Trava de Engate Ativada - Engate Travado"
				mensag10	= "Trava Elétrica Desativada - Veículo Destravado"
				mensag11	= "Trava Solenóide Ativada - Veículo Travado por Válvula"
				mensag12	= "Sirene Ligada"				
		Case 53:alerta9 	= "img_icn_tengate_0.gif"
				alerta10 	= "0"
				alerta11 	= "img_icn_tsolenoide_1.gif"
				alerta12 	= "2"
				mensag9		= "Trava de Engate Desativada - Engate Destravado"
				mensag10	= "Trava Elétrica Desativada - Veículo Destravado"
				mensag11	= "Trava Solenóide Ativada - Veículo Travado por Válvula"
				mensag12	= "Sirene Ligada"				
		Case 43:alerta9 	= "img_icn_tengate_1.gif"
				alerta10 	= "2"
				alerta11 	= "img_icn_tsolenoide_0.gif"
				alerta12 	= "2"
				mensag9		= "Trava de Engate Ativada - Engate Travado"
				mensag10	= "Trava Elétrica Ativada - Veículo Travado"
				mensag11	= "Trava Solenóide Desativada - Veículo Destravado por Válvula"
				mensag12	= "Sirene Ligada"				
		Case 51:alerta9 	= "img_icn_tengate_0.gif"
				alerta10 	= "2"
				alerta11 	= "img_icn_tsolenoide_0.gif"
				alerta12 	= "2"
				mensag9		= "Trava de Engate Desativada - Engate Destravado"
				mensag10	= "Trava Elétrica Ativada - Veículo Travado"
				mensag11	= "Trava Solenóide Desativada - Veículo Destravado por Válvula"
				mensag12	= "Sirene Ligada"				
		Case 47:alerta9 	= "img_icn_tengate_1.gif"
				alerta10 	= "0"
				alerta11 	= "img_icn_tsolenoide_0.gif"
				alerta12 	= "2"
				mensag9		= "Trava de Engate Ativada - Engate Travado"
				mensag10	= "Trava Elétrica Desativada - Veículo Destravado"
				mensag11	= "Trava Solenóide Desativada - Veículo Destravado por Válvula"
				mensag12	= "Sirene Ligada"				
		Case 55:alerta9 	= "img_icn_tengate_0.gif"
				alerta10 	= "0"
				alerta11 	= "img_icn_tsolenoide_0.gif"
				alerta12 	= "2"
				mensag9		= "Trava de Engate Desativada - Engate Destravado"
				mensag10	= "Trava Elétrica Desativada - Veículo Destravado"
				mensag11	= "Trava Solenóide Desativada - Veículo Destravado por Válvula"
				mensag12	= "Sirene Ligada"				
		Case Else
				alerta9 	= "img_icn_tengate_1.gif"
				alerta10 	= "0"
				alerta11 	= "img_icn_tsolenoide_0.gif"
				alerta12 	= "0"
				mensag9		= "Trava de Engate Ativada - Engate Travado"
				mensag10	= "Trava Elétrica Desativada - Veículo Destravado"
				mensag11	= "Trava Solenóide Desativada - Veículo Destravado por Válvula"
				mensag12	= "Sirene Desligada"				
	End Select				
	'##########################################

		
	'BLOCO DE SENSORES 3
	'##########################################
	opcao4 = rs.fields("ID_SEN3")
	Select Case opcao4
		Case 60:alerta13 	= "img_icn_batb_0.gif"
				alerta14 	= "img_icn_tbau_1.gif"
				alerta15 	= "0"
				alerta16 	= "img_icn_bata_0.gif"
				mensag13	= "Bateria Auxiliar Desativada"
				mensag14	= "Trava de Baú Ativada - Baú Travado"
				mensag15	= "Sinal de GPS Inválido - Erro"
				mensag16	= "Bateria Principal Desativada"				
		Case 68:alerta13 	= "img_icn_batb_1.gif"
				alerta14 	= "img_icn_tbau_1.gif"
				alerta15 	= "0"
				alerta16 	= "img_icn_bata_0.gif"
				mensag13	= "Bateria Auxiliar Ativada"
				mensag14	= "Trava de Baú Ativada - Baú Travado"
				mensag15	= "Sinal de GPS Inválido - Erro"
				mensag16	= "Bateria Principal Desativada"				
		Case 64:alerta13 	= "img_icn_batb_0.gif"
				alerta14 	= "img_icn_tbau_0.gif"
				alerta15 	= "0"
				alerta16 	= "img_icn_bata_0.gif"
				mensag13	= "Bateria Auxiliar Desativada"
				mensag14	= "Trava de Baú Desativada - Baú Destravado"
				mensag15	= "Sinal de GPS Inválido - Erro"
				mensag16	= "Bateria Principal Desativada"				
		Case 72:alerta13 	= "img_icn_batb_1.gif"
				alerta14 	= "img_icn_tbau_0.gif"
				alerta15 	= "0"
				alerta16 	= "img_icn_bata_0.gif"
				mensag13	= "Bateria Auxiliar Ativada"
				mensag14	= "Trava de Baú Desativada - Baú Destravado"
				mensag15	= "Sinal de GPS Inválido - Erro"
				mensag16	= "Bateria Principal Desativada"				
		Case 62:alerta13 	= "img_icn_batb_0.gif"
				alerta14 	= "img_icn_tbau_1.gif"
				alerta15 	= "2"
				alerta16 	= "img_icn_bata_0.gif"
				mensag13	= "Bateria Auxiliar Desativada"
				mensag14	= "Trava de Baú Ativada - Baú Travado"
				mensag15	= "Sinal de GPS Válido - OK"
				mensag16	= "Bateria Principal Desativada"				
		Case 70:alerta13 	= "img_icn_batb_1.gif"
				alerta14 	= "img_icn_tbau_1.gif"
				alerta15 	= "2"
				alerta16 	= "img_icn_bata_0.gif"
				mensag13	= "Bateria Auxiliar Ativada"
				mensag14	= "Trava de Baú Ativada - Baú Travado"
				mensag15	= "Sinal de GPS Válido - OK"
				mensag16	= "Bateria Principal Desativada"				
		Case 66:alerta13 	= "img_icn_batb_0.gif"
				alerta14 	= "img_icn_tbau_0.gif"
				alerta15 	= "2"
				alerta16 	= "img_icn_bata_0.gif"
				mensag13	= "Bateria Auxiliar Desativada"
				mensag14	= "Trava de Baú Desativada - Baú Destravado"
				mensag15	= "Sinal de GPS Válido - OK"
				mensag16	= "Bateria Principal Desativada"				
		Case 74:alerta13 	= "img_icn_batb_1.gif"
				alerta14 	= "img_icn_tbau_0.gif"
				alerta15 	= "2"
				alerta16 	= "img_icn_bata_0.gif"
				mensag13	= "Bateria Auxiliar Ativada"
				mensag14	= "Trava de Baú Desativada - Baú Destravado"
				mensag15	= "Sinal de GPS Válido - OK"
				mensag16	= "Bateria Principal Desativada"				
		Case 61:alerta13 	= "img_icn_batb_0.gif"
				alerta14 	= "img_icn_tbau_1.gif"
				alerta15 	= "0"
				alerta16 	= "img_icn_bata_1.gif"
				mensag13	= "Bateria Auxiliar Desativada"
				mensag14	= "Trava de Baú Ativada - Baú Travado"
				mensag15	= "Sinal de GPS Inválido - Erro"
				mensag16	= "Bateria Principal Ativada"				
		Case 69:alerta13 	= "img_icn_batb_1.gif"
				alerta14 	= "img_icn_tbau_1.gif"
				alerta15 	= "0"
				alerta16 	= "img_icn_bata_1.gif"
				mensag13	= "Bateria Auxiliar Ativada"
				mensag14	= "Trava de Baú Ativada - Baú Travado"
				mensag15	= "Sinal de GPS Inválido - Erro"
				mensag16	= "Bateria Principal Ativada"				
		Case 65:alerta13 	= "img_icn_batb_0.gif"
				alerta14 	= "img_icn_tbau_0.gif"
				alerta15 	= "0"
				alerta16 	= "img_icn_bata_1.gif"
				mensag13	= "Bateria Auxiliar Desativada"
				mensag14	= "Trava de Baú Desativada - Baú Destravado"
				mensag15	= "Sinal de GPS Inválido - Erro"
				mensag16	= "Bateria Principal Ativada"				
		Case 73:alerta13 	= "img_icn_batb_1.gif"
				alerta14 	= "img_icn_tbau_0.gif"
				alerta15 	= "0"
				alerta16 	= "img_icn_bata_1.gif"
				mensag13	= "Bateria Auxiliar Ativada"
				mensag14	= "Trava de Baú Desativada - Baú Destravado"
				mensag15	= "Sinal de GPS Inválido - Erro"
				mensag16	= "Bateria Principal Ativada"				
		Case 63:alerta13 	= "img_icn_batb_0.gif"
				alerta14 	= "img_icn_tbau_1.gif"
				alerta15 	= "2"
				alerta16 	= "img_icn_bata_1.gif"
				mensag13	= "Bateria Auxiliar Desativada"
				mensag14	= "Trava de Baú Ativada - Baú Travado"
				mensag15	= "Sinal de GPS Válido - OK"
				mensag16	= "Bateria Principal Ativada"				
		Case 71:alerta13 	= "img_icn_batb_1.gif"
				alerta14 	= "img_icn_tbau_1.gif"
				alerta15 	= "2"
				alerta16 	= "img_icn_bata_1.gif"
				mensag13	= "Bateria Auxiliar Ativada"
				mensag14	= "Trava de Baú Ativada - Baú Travado"
				mensag15	= "Sinal de GPS Válido - OK"
				mensag16	= "Bateria Principal Ativada"				
		Case 67:alerta13 	= "img_icn_batb_0.gif"
				alerta14 	= "img_icn_tbau_0.gif"
				alerta15 	= "2"
				alerta16 	= "img_icn_bata_1.gif"
				mensag13	= "Bateria Auxiliar Desativada"
				mensag14	= "Trava de Baú Desativada - Baú Destravado"
				mensag15	= "Sinal de GPS Válido - OK"
				mensag16	= "Bateria Principal Ativada"				
		Case 75:alerta13 	= "img_icn_batb_1.gif"
				alerta14 	= "img_icn_tbau_0.gif"
				alerta15 	= "2"
				alerta16 	= "img_icn_bata_1.gif"
				mensag13	= "Bateria Auxiliar Ativada"
				mensag14	= "Trava de Baú Desativada - Baú Destravado"
				mensag15	= "Sinal de GPS Válido - OK"
				mensag16	= "Bateria Principal Ativada"				
		Case Else
				alerta13 	= "img_icn_batb_0.gif"
				alerta14 	= "img_icn_tbau_1.gif"
				alerta15 	= "2"
				alerta16 	= "img_icn_bata_1.gif"
				mensag13	= "Bateria Auxiliar Desativada"
				mensag14	= "Trava de Baú Ativada - Baú Travado"
				mensag15	= "Sinal de GPS Válido - OK"
				mensag16	= "Bateria Principal Ativada"				
	End Select
	'##########################################
		
		
	'BLOCO DE SENSORES 4
	'##########################################
	opcao5 = rs.fields("ID_SEN4")
	Select Case opcao5
		Case 80:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 88:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 84:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 92:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 82:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 90:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 86:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 94:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 81:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 89:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 85:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 93:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 83:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 91:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 87:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case 95:alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
		Case Else
				alerta17 	= ""
				alerta18 	= ""
				alerta19 	= ""
				alerta20 	= ""
	End Select
	'##########################################
	
	'Pânico
	if rs.fields("POS_PANICO") = 0 then
		if alerta1 = "1" then
			alerta1 = "2"
			mensag1	= "Veículo com pânico checado"
			linha = "C"
		end if
		if alerta2 = "1" then
			alerta2 = "2"
			mensag2	= "Veículo com desvio de rota checado"
			linha = "C"
		end if
		if alerta3 = "1" then
			alerta3 = "2"
			mensag3	= "Veículo dentro de área de risco checado"
			linha = "C"
		end if
		if alerta4 = "1" then
			alerta4 = "2"
			mensag4	= "Veículo próximo da parada checado"
			linha = "C"
		end if
	end if

	'Cerca Elétrica
	if rs.fields("POS_AREA") = 0 then
		alerta21 = "0"
		mensag21 = "Veículo dentro da cerca"
	else
		alerta21 = "1"
		mensag21 = "Veículo distante da cerca"
	end if
	
	
						'Veículo satelital
						if rs.fields("POS_COMUNICADOR") <> 0 then
							'cor  = "#c3eaff"
							
							'Status não habilitados para esse modelo
							alerta5 	= "3"
							alerta6 	= "3"
							alerta7 	= "3"
							alerta8 	= "3"
							alerta9 	= "3"
							alerta10 	= "3"
							alerta11 	= "3"
							alerta12 	= "3"
							alerta13 	= "3"
							alerta14 	= "3"
							alerta15 	= "3"
							alerta16 	= "3"
							mensag5		= "Status Indisponível"
							mensag6		= "Status Indisponível"
							mensag7		= "Status Indisponível"
							mensag8		= "Status Indisponível"
							mensag9		= "Status Indisponível"
							mensag10	= "Status Indisponível"
							mensag11	= "Status Indisponível"
							mensag12	= "Status Indisponível"
							mensag13	= "Status Indisponível"
							mensag14	= "Status Indisponível"
							mensag15	= "Status Indisponível"
							mensag16	= "Status Indisponível"
							
						end if
	
	
						%>


<table>
<tr>
	<td style="text-align:center; padding:3px 3px 3px 3px; width:50%">
    	<img style="padding: 2px 2px 2px 2px;" src="img/icons/icon_vel.png" /><br />
    	<span style="font-size:18px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#999">
        	<%
			comunica = Server.HTMLEncode(rs.fields("POS_STATUS"))
			comunica = replace(comunica, "-S", "<br>Satelital")
			comunica = replace(comunica, "-", "<br>")
			response.Write(comunica)
			%>
        </span>
    </td>
	<td style="text-align:center; padding:3px 3px 3px 3px; width:50%">
    	<img style="padding: 2px 2px 2px 2px;" src="img/icons/icon_clock.png" /><br />
    	<span style="font-size:18px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#999">
			<%=FormatDateTime(rs.fields("POS_DATAHORABRA"),2)%><br />
			<%=FormatDateTime(rs.fields("POS_DATAHORABRA"),4)%>
		</span>
    </td>
</tr>
</table>
<table>
<tr>
	<td colspan="2" style="padding:10px 2px 10px 2px; background-color:#E5E5E5; font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#666">
    	<% response.Write(Server.HTMLEncode(rs.fields("POS_LOCAL"))) %> - <% response.Write(rs.fields("POS_ESTADO")) %>
    </td>
</tr>
<tr>
	<td style="width:5%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC;"><img src="img/icons/icon_local.png" border="0"></td>
    <td style="width:95%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;"><% response.Write(Server.HTMLEncode(rs.fields("POS_RUA"))) %></td>  
</tr>
<tr>
	<td style="width:5%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC;"><img src="img/icons/truck_<% Response.Write(icone) %>.png" border="0"></td>
    <td style="width:95%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;"><%=Server.HTMLEncode(mvel)%></td>  
</tr>
<tr>
	<td style="width:5%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC;"><img src="img/icons/icon_chave_<%=alerta8%>.png" alt="<%=Server.HTMLEncode(mensag8)%>"></td>
    <td style="width:95%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;"><%=Server.HTMLEncode(mensag8)%></td>  
</tr>
<tr>
	<td style="width:5%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC;">
    <!-- PÂNICO -->
    <%if alerta1 = "1" then%>
        <img src="img/icons/icon_alert_<%=alerta1%>.png" alt="<%=Server.HTMLEncode(mensag1)%>">
    <%else%>
         <img src="img/icons/icon_alert_<%=alerta1%>.png" alt="<%=Server.HTMLEncode(mensag1)%>">
    <%end if%>
    </td>
    <td style="width:95%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;"><%=Server.HTMLEncode(mensag1)%></td>
</tr>
<tr>
	<td style="width:5%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC;">
    <!-- DESVIO DE ROTA -->
    <%if alerta2 = "1" then%>
        <img src="img/icons/icon_alert_<%=alerta2%>.png" alt="<%=mensag2%>">
    <%else%>
        <img src="img/icons/icon_alert_<%=alerta2%>.png" alt="<%=mensag2%>">
    <%end if%>
    </td>
    <td style="width:95%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;"><%=mensag2%></td>
</tr>
<tr>
	<td style="width:5%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC;">
    <!-- PRÓXIMO DE PARADA -->
    <%if alerta4 = "1" then%>
        <img src="img/icons/icon_alert_<%=alerta4%>.png" alt="<%=mensag4%>">
    <%else%>
        <img src="img/icons/icon_alert_<%=alerta4%>.png" alt="<%=mensag4%>">
    <%end if%>
    </td>
    <td style="width:95%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;"><%=mensag4%></td>
</tr>
<tr>
	<td style="width:5%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC;">
    <!-- ÁREA DE RISCO -->
    <%if alerta3 = "1" then%>
        <img src="img/icons/icon_alert_<%=alerta3%>.png" alt="<%=mensag3%>">
    <%else%>
        <img src="img/icons/icon_alert_<%=alerta3%>.png" alt="<%=mensag3%>">
    <%end if%>
    </td>
    <td style="width:95%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;"><%=mensag3%></td>
</tr>
<tr>
	<td style="width:5%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC;"><img src="img/icons/icon_gps_<%=alerta15%>.png" alt="<%=mensag15%>"></td>
    <td style="width:95%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;"><%=mensag15%></td>  
</tr>
<tr>
	<td style="width:5%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC;"><img src="img/icons/icon_buzzer_<%=alerta12%>.png" alt="<%=mensag12%>"></td>
    <td style="width:95%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;"><%=mensag12%></td>  
</tr>
<tr>
	<td style="width:5%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC;"><img src="img/icons/icon_door_<%=alerta5%>.png" alt="<%=mensag5%>"></td>
    <td style="width:95%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;"><%=mensag5%></td>  
</tr>
<tr>
	<td style="width:5%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC;"><img src="img/icons/icon_lock_<%=alerta10%>.png" alt="<%=mensag10%>"></td>
    <td style="width:95%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;"><%=mensag10%></td>  
</tr>
</table>