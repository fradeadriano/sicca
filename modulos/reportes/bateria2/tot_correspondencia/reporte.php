<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<form action="nprivilegio.php" name="ilegal" id="ilegal" method="post">
	<input type="hidden" name="archivo" value="'.$_SERVER['SCRIPT_NAME'].'" />
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
	document.getElementById("ilegal").submit();
</script>';
	die($hmtl); 
}
require_once("librerias/Recordset.php");
require_once("bil.php");
?>
<script type="text/javascript" src="librerias/jq.js"></script>
<script type="text/javascript" src="librerias/jquery.autocomplete.js"></script>
<table border="0" align="center" width="1000">
	<tr> 
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="45px"><img src="images/totalizacion.png"/></td>
					<td class="titulomenu" valign="middle">Totalizaci&oacute;n Correspondencia de la CGR</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center">
		
			<table border="0" class="b_table">
				<tr>
					<td align="center">
						<fieldset style="width:90%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Opciones Totalizaci&oacute;n</legend>
						<table border="0" width="100%" class="b_table_b" bgcolor="#F2F9FF"  cellpadding="2" cellspacing="0">
							<tr>
								<td align="center" colspan="2">
									Todos&nbsp;<input type="radio" name="type_to" value="todo" id="todo" checked="checked" onclick="habil(this.id);"/>
									&nbsp;
									Espec&iacute;fico:&nbsp;<input type="radio" name="type_to"  value="especi" id="especi" onclick="habil(this.id);"/>
									&nbsp;&nbsp;
								</td>
							</tr>
							<tr><td height="10" colspan="3" ></td></tr>																
							<tr>															
								<td colspan="3" align="center">
									<form name="tipos_es" id="tipos_es">
									&nbsp;&nbsp;&nbsp;&nbsp;
									Estatus&nbsp;<input type="radio" name="especi_seu" value="estatus" id="estatus" disabled="disabled" />
									&nbsp;&nbsp;
									Direcci&oacute;n&nbsp;<input type="radio" name="especi_seu" value="organismo" id="organismo" disabled="disabled"/>
									&nbsp;&nbsp;
									Unidad Administrativa&nbsp;<input type="radio" name="especi_seu" value="unidad" id="unidad" disabled="disabled"/>
									</form>
								</td>
							</tr>
							<tr><td height="10" colspan="3" ></td></tr>																
							<tr>
								<td valign="bottom" align="right" width="270">
									Fecha&nbsp;de&nbsp; 
								</td>		
								<td valign="bottom" width="450" colspan="2">
									<select name="sel_fecha"  id="sel_fecha">
										<option selected="selected"></option>
										<option id="documento">Documento</option>
										<option id="registro">Registro</option>
									</select>&nbsp;&nbsp;Entre:
									<input type="text" name="desde" id="desde" style="width:70px" onkeyup="this.value=formateafecha(this.value);" />&nbsp;y&nbsp;<input type="text" name="hasta" id="hasta" onkeyup="this.value=formateafecha(this.value);" style="width:70px"/>
									&nbsp;
									<span class="mensaje">*</span>
									&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span>
								</td>
							
							</tr>
							<tr><td height="10" colspan="8" ></td></tr>																							
							<tr>
								<td colspan="4" align="center">
									<input type="button" name="btnFiltra" id="btnFiltra" value="Filtrar" title="Filtrar" onclick="doit();" />
									&nbsp;&nbsp;
									<input type="reset" name="btnCancelar" id="btnCancelar" value="Cancelar" title="Cancelar" onclick="resta();" />								
								</td>								
							</tr>
							<tr><td colspan="3" align="right" class="mensaje">* Campos Obligatorios&nbsp;&nbsp;</td></tr>														
						</table>
						</fieldset>
					</td>
				</tr>
				<tr><td height="7"></td></tr>
				<tr>
					<td align="center">
						<table border="0" class="b_table" width="980" cellpadding="0" cellspacing="0">	
							<tr>
								<td id="zone" colspan="2" align="center" height="20">
									No Ex&iacute;sten datos a mostrar!!
								</td>
							</tr>
						</table>
					</td>
				</tr>								
			</table>
		
		</td>
	</tr>	
</table>