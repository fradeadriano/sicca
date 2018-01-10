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
					<td width="45px"><img src="images/general.png"/></td>
					<td class="titulomenu" valign="middle">Listado General Correspondencia de la CGR</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center">
		<form action="" name="FormPla" id="FormPla" method="post">
			<table border="0" class="b_table">
				<tr>
					<td align="center">
						<fieldset style="width:90%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Filtrado Correspondencia</legend>
						<table border="0" width="100%" class="b_table_b" bgcolor="#F2F9FF"  cellpadding="2" cellspacing="0">
							<tr>
								<td valign="bottom"  align="right" width="132">
									Tipo Documento:&nbsp;
								</td>
								<td valign="bottom">
									<? 
									$rsun = new Recordset();
									$rsun->sql = "SELECT id_tipo_documento, tipo_documento FROM tipo_documento WHERE cgr=1 order by tipo_documento"; 
									$rsun->llenarcombo($opciones = "\"tipo_documento\"", $checked = "", $fukcion = "" , $diam = "style=\"width:120px; Height:20px;\""); 
									$rsun->cerrar(); 
									unset($rsun);																						
									?>
								</td>
								<td width="10"></td>								
								<td valign="bottom" align="right">
									Estatus:&nbsp;
								</td>
								<td valign="bottom">
									<? 
									$rses = new Recordset();
									$rses->sql = "SELECT id_estatus, estatus FROM estatus WHERE cgr=1 order by orden"; 
									$rses->llenarcombo($opciones = "\"estatus\"", $checked = "", $fukcion = "" , $diam = "style=\"width:100px; Height:20px;\""); 
									$rses->cerrar(); 
									unset($rsun);																						
									?>
								</td>
								<td width="10"></td>							
							</tr>
							<tr><td height="10" colspan="8" ></td></tr>																
							<tr>
								<td valign="bottom" align="right">
									Fecha&nbsp;de&nbsp; 
								</td>		
								<td valign="bottom" colspan="4">
									<select name="sel_fecha"  id="sel_fecha">
										<option selected="selected"></option>
										<option id="documento">Documento</option>
										<option id="registro">Registro</option>
									</select>&nbsp;&nbsp;Entre:
									<input type="text" name="desde" id="desde" style="width:70px" onkeyup="this.value=formateafecha(this.value);" />&nbsp;y&nbsp;<input type="text" name="hasta" id="hasta" onkeyup="this.value=formateafecha(this.value);" style="width:70px"/>
									&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span>
								</td>							
							</tr>
							<tr><td height="10" colspan="8" ></td></tr>																							
							<tr>
								<td valign="bottom" align="right">
									Direcci&oacute;n:&nbsp;
								</td>
								<td valign="bottom" colspan="5">
									<textarea name="organismo" id="organismo" style="width:400px; height:30px;" ></textarea>											
									<input type="hidden" name="id_organismo" id="id_organismo"  />									
								</td>																							
							</tr>
							<tr><td height="10" colspan="8"></td></tr>							
							<tr>
								<td valign="bottom" align="left"  colspan="4">
									Unidad Administrativa:&nbsp;<? $rsun = new Recordset();	$rsun->sql = "SELECT id_unidad, unidad FROM unidad WHERE id_unidad <> 8  order by unidad"; 
									$rsun->llenarcombo($opciones = "\"unidad\"", $checked = "", $fukcion = "" , $diam = "style=\"width:240px; Height:20px;\""); 
									$rsun->cerrar(); 
									unset($rsun);																						
									?>									
								</td>
								<td colspan="4" align="center">
									<input type="button" name="btnFiltra" id="btnFiltra" value="Filtrar" title="Filtrar" onclick="doit();" />
									&nbsp;&nbsp;
									<input type="reset" name="btnCancelar" id="btnCancelar" value="Cancelar" title="Cancelar" />								
								</td>								
							</tr>														
						</table>
						</fieldset>
					</td>
				</tr>
				<tr><td height="7"></td></tr>
				<tr>
					<td align="center">
						<table border="0" class="b_table" width="980" cellpadding="0" cellspacing="0">
							<tr class="trcabecera_list_ordenar2">
								<td height="33">
									&nbsp;&nbsp;Ordenado por:&nbsp;&nbsp;<select name="por_ordenar" id="por_ordenar" onchange="filtrar(this.value);">
										<option></option>
										<option value="columna1">Tipo Documento</option>
										<option value="columna2">Organ&iacute;smo / Remitente</option>							
										<option value="columna3">Fecha Registro</option>										
										<option value="columna4">Fecha Documento</option>																				
										<option value="columna5">Estatus</option>
										<option value="columna6">Unidad Asignada</option>
										<option value="columna7">Correlativo</option>
										<option value="columna8">N&deg; Oficio</option>																				
									</select>
									&nbsp;&nbsp;&nbsp;
									Ascendente&nbsp;<input type="radio" name="fo_orden" id="asc" onclick="filtrar(document.getElementById('por_ordenar').value);"/>
									&nbsp;&nbsp;&nbsp;									
									Descendente&nbsp;<input type="radio" name="fo_orden" id="des" checked="checked" onclick="filtrar(document.getElementById('por_ordenar').value);"/>									
									<!--&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/ordenar.png" />-->
								</td>
							</tr>	
							<tr>
								<td id="zone" colspan="2" align="center" height="20">
									No Ex&iacute;sten datos a mostrar!!
								</td>
							</tr>
						</table>
					</td>
				</tr>								
			</table>
		</form>
		</td>
	</tr>	
</table>
<script language="javascript" type="text/javascript">
	$("#organismo").autocomplete("modulos/reportes/bateria2/lis_general_correspondencia/lista.php", { 
		width: 400,
		matchContains: true,
		mustMatch: false,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});

	$("#organismo").result(function(event, data, formatted) {
		try {
			$("#id_organismo").val(data[1]);
		} catch(e) {
			e.name;		
		}
	});
</script>
