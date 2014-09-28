<!-- #include file="../../functions/conecta.asp" -->
<%
cat		= request.QueryString("cat")
erro 	= request.QueryString("erro")

if request.QueryString("modelo") <> "" then
	modelo				= request.QueryString("modelo")
	session("modelo")	= modelo
end if

if request.QueryString("terminal") <> "" then
	terminal			= request.QueryString("terminal")
	session("terminal")	= terminal
end if

if request.QueryString("placa") <> "" then
	session("placa")	= request.QueryString("placa") 
end if

grupo	= session("grupo")
usuario	= session("usuario")		

Select Case erro
    Case 1: Mens = "Valor fora do intervalo permitido."
    Case 2: Mens = "Valor fora do intervalo permitido."
    Case 3: Mens = "Valor fora do intervalo permitido."
    Case Else
            Mens = "Selecione o tipo de mensagem"
End Select

%>

<table>
<tr>
	<td style="padding:15px 2px 5px 2px; border-bottom: 1px dashed #CCC; font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#666">
    	<img src="img/icons/icon_mens.png" style="vertical-align:middle;" />&nbsp;<%Response.Write(Mens)%>
    </td>
</tr>
<%
if  ((modelo = "15") or (modelo = "20")) then
%>
<tr>
	<td style="padding:5px 2px 5px 2px; border-bottom: 1px dashed #CCC;">

		<form name="form1" method="post" action="">
				<%
				'Seleciona as categorias de mensagens disponíveis para determinado modelo
				SQL_a = "SELECT * FROM TAB_MENS_CAT WHERE ID_MODELO = '"&modelo&"' "
				Set rs_a = con.Execute(SQL_a)
				%>
                
                <select style="background-color:#FFF; color:#333; font-size:11px; font-family:Verdana; border: 1px solid #333; width:200px;font-weight:normal;" name="categoria" onChange="recarregaTela('parent',this,0)">
                
					
                    <option selected>SELECIONE UM TIPO:</option>
						<%
						libera = "0"
						Do While Not rs_a.eof

							if cat = CStr(rs_a.fields("ID_MENS_CAT")) then
								libera = "1"
							end if

							'Verifica se a empresa tem permissão
							SQL_y = "SELECT * FROM TAB_EMPRESA_MENS WHERE ID_EMPRESA = ANY (SELECT ID_EMPRESA FROM TAB_EMPRESAGRUPO WHERE ID_GRUPO = "&grupo&") AND ID_MENS_CAT = "&rs_a.fields("ID_MENS_CAT")&" "
							Set rs_y = con.Execute(SQL_y)
				
							if not rs_y.eof then
							%>
                      			<option value="enviar_MensagemGprs.asp?cat=<%=rs_a.fields("ID_MENS_CAT")%>&amp;modelo=<%=modelo%>"><%=rs_a.fields("MENS_CAT_NOM")%></option>
                   			<%
							end if
						rs_a.MoveNext
						Loop
						%>
				</select>
		</form>
	</td>
</tr>
	<%
    if cat <> ""  AND libera = "1" then
    %>
<tr>
	<td style="padding:5px 2px 5px 2px; border-bottom: 1px dashed #CCC;">

		<form action="enviar_mensagem_gprs_int.asp" method="post" name="envia_mens" id="envia_mens">
				<%
				' Seleciona apenas as mensagens referentes a categoria escolhida
				SQL_b = "SELECT * FROM TAB_MENS WHERE ID_MENS_CAT = "&cat&""
				Set rs_b = con.Execute(SQL_b)
				%>
				<img src="../img/icons/icn_seta.gif" width="29" height="25">
                	<%
					'Aqui vão as chamadas paras as funções de acordo com a categoria selecionada.
						select case cat
									
						'Bloco de Comandos para o Equipamento GPRS
						case "49"  	: GPRSTravamento() 
						case "50"  	: GPRSSirene() 
						case "51"  	: GPRSTrocatempo() 
						case "53"  	: GPRSSolenoide() 
						case "54"  	: GPRSTravaeletrica() 
						case "55"  	: GPRSBau() 
						case "56"  	: GPRSEngate() 
						case "57"  	: GPRSSaida()
						case "58"  	: GPRSSensorestodos() 
						case "59"  	: GPRSSensoresind() 
						case "60"  	: GPRSPosicao() 
						case "62"  	: GPRSTextolivre() 
						case "63"  	: GPRSComandolivre()
						'Versão - 22/02/07
						case "61"  	: GPRSTrocaIp()				'IMEI:63:IP+Portas
						case "64"  	: GPRSServicoGPRS()			'IMEI:64:3030303030
						case "65"  	: GPRSLiberaTotal()
						case "66"  	: GPRSSenhaLibera() 
						case "67"  	: GPRSSenhaBau() 
						case "68"  	: GPRSMensagemPre() 
						case "69"  	: GPRSServicoDisplay() 
						case "70"  	: GPRSTrocaSenhaVeiculo()	'IMEI:90:FF9999
						case "71"  	: GPRSTrocaSenhaBau()		'IMEI:90:FD9999
										
						'Caso nenhuma das opções acima sejam satisfeitas ele retorna a mensagem de erro.
						case else : Response.Write("Este tipo de mensagem não está liberada para o envio via Web."+cat)
										
				end select
				%>
			<input name="Enviar" type="submit" id="Enviar" value="Enviar">
		</form>
	</td>
</tr>
<%
	end if
%>


<%
else
%>
	<div align="center"><%Response.Write("Este Modelo não permite o envio de mensagens via web")%></div>
<%
end if 
%>


<!-- Bloco de funções disponíveis para o modelo GPRS -->
<%
Sub GPRSTravamento()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=UCase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSSirene()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=Ucase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSTrocatempo()

	Response.Write("Selecione o intervalo de tempo desejado.")%><br><br>
	<select name="mens_a">					
		<option value="3030">00 hora</option>
		<option value="3031">01 hora</option>
		<option value="3032">02 horas</option>
		<option value="3033">03 horas</option>
		<option value="3034">04 horas</option>
		<option value="3035">05 horas</option>
		<option value="3036">06 horas</option>
		<option value="3037">07 horas</option>
		<option value="3038">08 horas</option>
		<option value="3039">09 horas</option>
		<option value="3130">10 horas</option>
		<option value="3131">11 horas</option>
		<option value="3132">12 horas</option>
		<option value="3133">13 horas</option>
		<option value="3134">14 horas</option>
		<option value="3135">15 horas</option>
		<option value="3136">16 horas</option>
		<option value="3137">17 horas</option>
		<option value="3138">18 horas</option>
		<option value="3139">19 horas</option>
		<option value="3230">20 horas</option>
		<option value="3231">21 horas</option>
		<option value="3232">22 horas</option>
		<option value="3233">23 horas</option>
	</select>
	<select name="mens_b">					
		<option value="3030">00 minuto</option>
		<option value="3031" selected>01 minuto</option>
		<option value="3032">02 minutos</option>
		<option value="3033">03 minutos</option>
		<option value="3034">04 minutos</option>
		<option value="3035">05 minutos</option>
		<option value="3036">06 minutos</option>
		<option value="3037">07 minutos</option>
		<option value="3038">08 minutos</option>
		<option value="3039">09 minutos</option>
		<option value="3130">10 minutos</option>
		<option value="3131">11 minutos</option>
		<option value="3132">12 minutos</option>
		<option value="3133">13 minutos</option>
		<option value="3134">14 minutos</option>
		<option value="3135">15 minutos</option>
		<option value="3136">16 minutos</option>
		<option value="3137">17 minutos</option>
		<option value="3138">18 minutos</option>
		<option value="3139">19 minutos</option>
		<option value="3230">20 minutos</option>
		<option value="3231">21 minutos</option>
		<option value="3232">22 minutos</option>
		<option value="3233">23 minutos</option>
		<option value="3234">24 minutos</option>
		<option value="3235">25 minutos</option>
		<option value="3236">26 minutos</option>
		<option value="3237">27 minutos</option>
		<option value="3238">28 minutos</option>
		<option value="3239">29 minutos</option>
		<option value="3330">30 minutos</option>
		<option value="3331">31 minutos</option>
		<option value="3332">32 minutos</option>
		<option value="3333">33 minutos</option>
		<option value="3334">34 minutos</option>
		<option value="3335">35 minutos</option>
		<option value="3336">36 minutos</option>
		<option value="3337">37 minutos</option>
		<option value="3338">38 minutos</option>
		<option value="3339">39 minutos</option>
		<option value="3430">40 minutos</option>
		<option value="3431">41 minutos</option>
		<option value="3432">42 minutos</option>
		<option value="3433">43 minutos</option>
		<option value="3434">44 minutos</option>
		<option value="3435">45 minutos</option>
		<option value="3436">46 minutos</option>
		<option value="3437">47 minutos</option>
		<option value="3438">48 minutos</option>
		<option value="3439">49 minutos</option>
		<option value="3530">50 minutos</option>
		<option value="3531">51 minutos</option>
		<option value="3532">52 minutos</option>
		<option value="3533">53 minutos</option>
		<option value="3534">54 minutos</option>
		<option value="3535">55 minutos</option>
		<option value="3536">56 minutos</option>
		<option value="3537">57 minutos</option>
		<option value="3538">58 minutos</option>
		<option value="3539">59 minutos</option>
	</select>
	<input type="hidden" value="<%=rs_b.fields("ID_MENS")%>" name="mens" id="mens">
	
	<%
End Sub
%>

<%
Sub GPRSSolenoide()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=Ucase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSTravaeletrica()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=Ucase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSBau()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=Ucase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSEngate()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=Ucase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSSaida()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=Ucase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSSensorestodos()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=Ucase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSSensoresind()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=Ucase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSPosicao()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=Ucase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSTextolivre()
	Response.Write("Digite o texto desejado no campo abaixo. <strong>(Máx. 36 caracteres)</strong>")%><br><br>
	<input type="text" size="64" id="mens_a" maxlength="64" name="mens_a">
	<input type="hidden" value="<%=rs_b.fields("ID_MENS")%>" name="mens" id="mens">
	<%
End Sub
%>

<%
Sub GPRSComandolivre()
	Response.Write("Digite o texto nos campo abaixo.")%><br><br>
	<input type="text" size="32" id="mens_a" maxlength="32" name="mens_a"> :
	<input type="text" size="128" id="mens_b" maxlength="128" name="mens_b"><br> 
<!--    <input type="text" size="256" id="mens_b" maxlength="256" name="mens_b"><br> -->
	<input type="hidden" value="<%=rs_b.fields("ID_MENS")%>" name="mens" id="mens">
	<%
End Sub
%>

<%
Sub GPRSLiberaTotal()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=UCase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSSenhaLibera()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=UCase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSSenhaBau()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=UCase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSMensagemPre()
	Response.Write("Selecione a mensagem desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=UCase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub
%>

<%
Sub GPRSServicoDisplay()
	Response.Write("Selecione a opção desejada.")%><br><br>
	<select name="mens">					
	<%
	Do While not rs_b.eof 
	%>
		<option value="<%=rs_b.fields("ID_MENS")%>"><%=UCase(rs_b.fields("MENS_NOM"))%></option>
	<%
	rs_b.MoveNext
	Loop
	%>
	</select>
	
	<%
End Sub

%>

<%
Sub GPRSServicoGPRS()

	Response.Write("Selecione os comandos desejados.")%><br><br>
	<select name="mens_a">					
		<option value="30">Desabilita SAT</option>
		<option value="31">Habilita SAT</option>
	</select>
	<select name="mens_b">					
		<option value="30">Desabilita Display</option>
		<option value="31">Habilita Display</option>
	</select>
	<select name="mens_c">					
		<option value="30">Desabilita Sensores</option>
		<option value="31">Habilita Sensores</option>
	</select>
	<select name="mens_d">					
		<option value="30">Desabilita Conexão Discada</option>
		<option value="31">Habilita Conexão Discada</option>
	</select>
	<select name="mens_e">					
		<option value="30">Desabilita Senha</option>
		<option value="31">Habilita Senha</option>
	</select>			
	<input type="hidden" value="<%=rs_b.fields("ID_MENS")%>" name="mens" id="mens">
	
	<%
End Sub
%>

<%
Sub GPRSTrocaSenhaVeiculo()
	Response.Write("Digite a senha de liberação do veículo. <strong>(Máx. 4 caracteres / Somente Números 0-9)</strong>")%><br><br>
	<input type="text" size="4" id="mens_a" maxlength="4" name="mens_a">
	<input type="hidden" value="<%=rs_b.fields("ID_MENS")%>" name="mens" id="mens">
	<%
End Sub
%>

<%
Sub GPRSTrocaSenhaBau()
	Response.Write("Digite a senha do baú. <strong>(Máx. 4 caracteres / Somente Números 0-9)</strong>")%><br><br>
	<input type="text" size="4" id="mens_a" maxlength="4" name="mens_a">
	<input type="hidden" value="<%=rs_b.fields("ID_MENS")%>" name="mens" id="mens">
	<%
End Sub
%>
<!--  ##############################  FIM  GPRS #################################-->