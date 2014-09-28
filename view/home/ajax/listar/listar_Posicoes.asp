<!-- #include file="../../functions/conecta.asp" -->
<%
if session("ok") <> TRUE then
	'Erro: Você deve estar logado para acessar esta área (caso o usuário tente acessar esta página diretamente)
	Response.Redirect("../../login.asp?erro=3")
end if

SQL = "SELECT ID_POSICOES, POS_PLACA, POS_LOCAL, POS_ESTADO, POS_RUA, POS_DATAHORA, POS_STATUS, POS_LATITUDE, POS_LONGITUDE, ID_ALERTA, POS_AREA, POS_PANICO, POS_DATAHORABRA, ID_SEN1, ID_SEN2, ID_SEN3, ID_SEN4, POS_COMUNICADOR"
SQL = SQL & " FROM TAB_POSICOES WHERE (POS_PLACA IN (SELECT TAB_PLACAS.NUM_PLACA FROM TAB_PLACAS INNER JOIN"
SQL = SQL & " TAB_VEICULO ON TAB_VEICULO.ID_PLACA = TAB_PLACAS.ID_PLACA INNER JOIN"
SQL = SQL & " TAB_EMPRESA ON TAB_EMPRESA.ID_EMPRESA = TAB_PLACAS.ID_EMPRESA INNER JOIN"
SQL = SQL & " TAB_EMPRESAGRUPO ON TAB_EMPRESAGRUPO.ID_EMPRESA = TAB_EMPRESA.ID_EMPRESA INNER JOIN"
SQL = SQL & " TAB_GRUPO ON TAB_GRUPO.ID_GRUPO = TAB_EMPRESAGRUPO.ID_GRUPO AND TAB_GRUPO.ID_GRUPO = "&session("grupo")&" INNER JOIN"
SQL = SQL & " TAB_TER_EMP ON TAB_TER_EMP.ID_VEICULO = TAB_VEICULO.ID_VEICULO AND TAB_TER_EMP.DAT_DES = '0'))"
Set rs = con.Execute(SQL)
%>

<%
aux = 1
pontos = ""
	
'Loop de posições dos veículos do grupo
Do While not rs.eof
	filtro = Instr(rs.fields("POS_STATUS"),"- 0 KM/H")
	if filtro <> 0 then
		filtro = 1
	end if
	pontos = pontos & ""&rs.fields("POS_PLACA")&"', "&TRIM(rs.fields("POS_LATITUDE"))&", "&TRIM(rs.fields("POS_LONGITUDE"))&" ,"&aux&" , "&filtro&"#"
	aux = aux+1
rs.MoveNext
Loop

tamanho = len(pontos)-1

pontos = mid(pontos,1,tamanho)

response.Write(pontos)
%>