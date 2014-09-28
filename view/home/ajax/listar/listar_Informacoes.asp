<!-- #include file="../../functions/conecta.asp" -->
<%
if session("ok") <> TRUE then
	'Erro: Você deve estar logado para acessar esta área (caso o usuário tente acessar esta página diretamente)
	Response.Redirect("../../login.asp?erro=3")
end if

placa = Request.QueryString("C00")

SQL = "SELECT motorista.motorista, motorista.tel_cel, TAB_EMPRESA.NOM_EMPRESA, TAB_PLACAS.REN_VEICULO, TAB_PLACAS.COR_VEICULO, TAB_PLACAS.FAB_VEICULO, TAB_PLACAS.MOD_VEICULO, TAB_PLACAS.CHS_VEICULO, TAB_PLACAS.MAR_VEICULO, TAB_PLACAS.TIP_VEICULO"
SQL = SQL & " FROM TAB_PLACAS"
SQL = SQL & " INNER JOIN TAB_VEICULO ON TAB_VEICULO.ID_PLACA = TAB_PLACAS.ID_PLACA"
SQL = SQL & " INNER JOIN TAB_EMPRESA ON TAB_EMPRESA.ID_EMPRESA = TAB_PLACAS.ID_EMPRESA"
SQL = SQL & " INNER JOIN motorista ON motorista.id = TAB_PLACAS.ID_MOTORISTA"
SQL = SQL & " WHERE (TAB_PLACAS.NUM_PLACA = '"&placa&"')"
Set rs = con.Execute(SQL)
%>
<table>
<tr>
	<td style="text-align:center; padding:3px 3px 3px 3px; width:50%">
    	<img style="padding: 2px 2px 2px 2px;" src="img/icons/icon_mot.png" height="24" /><br />
    	<span style="font-size:18px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#999">
        	<% response.Write(Server.HTMLEncode(rs.fields("motorista"))) %>
        </span>
    </td>
	<td style="text-align:center; padding:3px 3px 3px 3px; width:50%">
    	<img style="padding: 2px 2px 2px 2px;" src="img/icons/icon_fone.png" /><br />
    	<span style="font-size:18px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#999">
			<% response.Write(rs.fields("tel_cel")) %>
		</span>
    </td>
</tr>
</table>

<table>
<tr>
	<td colspan="2" style="padding:10px 2px 10px 2px; background-color:#E5E5E5; font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#666">
    	<% response.Write(rs.fields("MOD_VEICULO")) %>
    </td>
</tr>
<tr>
	<td style="width:15%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-weight:bold; text-align:left; height:25px;">
    	Cor:
    </td>
    <td style="width:85%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;">
		<% response.Write(rs.fields("COR_VEICULO")) %>
	</td>
</tr>
<tr>
	<td style="width:15%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-weight:bold; text-align:left; height:25px;">
    	Renavam:
    </td>
    <td style="width:85%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;">
		<% response.Write(rs.fields("REN_VEICULO")) %>
	</td>
</tr>
<tr>
	<td style="width:15%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-weight:bold; text-align:left; height:25px;">
    	Fabricação:
    </td>
    <td style="width:85%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;">
		<% response.Write(rs.fields("FAB_VEICULO")) %>
	</td>
</tr>
<tr>
	<td style="width:15%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-weight:bold; text-align:left; height:25px;">
    	Marca:
    </td>
    <td style="width:85%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;">
		<% response.Write(rs.fields("MAR_VEICULO")) %>
	</td>
</tr>
<tr>
	<td style="width:15%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-weight:bold; text-align:left; height:25px;">
    	Chassis
    </td>
    <td style="width:85%; padding:2px 2px 2px 2px; border-bottom:1px dashed #CCC; font-size:11px; font-family:Verdana, Geneva, sans-serif; text-align:left;">
		<% response.Write(rs.fields("CHS_VEICULO")) %>
	</td>
</tr>
</table>