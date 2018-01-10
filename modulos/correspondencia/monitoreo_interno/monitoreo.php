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
					<td width="45px"><img src="images/monitor1.png"/></td>
					<td class="titulomenu" valign="middle">Correspondencias Externas Enviadas</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center">
		<form action="" name="FormExt" id="FormExt" method="post">
			<table border="0" class="b_table">
				<tr>
					<td align="center">
						<fieldset style="width:90%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Filtrado Correspondencia</legend>
						<table border="0" width="100%" class="b_table_b" bgcolor="#F8F8F8"  cellpadding="2" cellspacing="0">
							<tr>							
								<td valign="bottom" align="right" width="130">
									Estatus:&nbsp;
								</td>
								<td valign="bottom" colspan="3">
									<? 
									$rses = new Recordset();
									$rses->sql = "SELECT id_estatus, estatus FROM estatus WHERE id_estatus BETWEEN 5 AND 6 order by orden"; 
									$rses->llenarcombo($opciones = "\"estatus\"", $checked = "", $fukcion = "" , $diam = "style=\"width:100px; Height:20px;\""); 
									$rses->cerrar(); 
									unset($rsun);																						
									?>
								</td>

								<td valign="bottom" align="right">
									N&deg; Oficio Externo:&nbsp;								
								</td>							
								<td valign="bottom">
									<input type="text" name="noficio" id="noficio" style="width:70px" maxlength="5" onkeypress="return validar(event,numeros)"/>
								</td>							
							</tr>
							<tr><td height="10" colspan="8" ></td></tr>							
							<tr>
								<td valign="bottom" align="right">
									Fecha&nbsp;Envio&nbsp;Entre:
								</td>		
								<td valign="bottom" colspan="3">
									
									<input type="text" name="desde" id="desde" style="width:70px" onkeyup="this.value=formateafecha(this.value);" />&nbsp;y&nbsp;<input type="text" name="hasta" id="hasta" onkeyup="this.value=formateafecha(this.value);" style="width:70px"/>
									&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span>
								</td>
								<td align="right" valign="bottom">Documento:&nbsp;</td>
								<td valign="bottom">
									<? $rsun = new Recordset();	$rsun->sql = "SELECT IF(documento_cgr_desgloce.id_documento_cgr_desgloce IS NOT NULL,CONCAT(tipo_documento_cgr.id_tipo_documento_cgr,'-',documento_cgr_desgloce.id_documento_cgr_desgloce),CONCAT(tipo_documento_cgr.id_tipo_documento_cgr,'-0')) AS id, 
																				IF(CONCAT(tipo_documento_cgr.tipo_documento_cgr, '-', documento_cgr_desgloce.documento_cgr_desgloce) IS NULL, tipo_documento_cgr.tipo_documento_cgr, CONCAT(tipo_documento_cgr.tipo_documento_cgr, '-', documento_cgr_desgloce.documento_cgr_desgloce)) AS oficio 
																				FROM tipo_documento_cgr  LEFT JOIN documento_cgr_desgloce   ON (   tipo_documento_cgr.id_tipo_documento_cgr = documento_cgr_desgloce.id_tipo_documento_cgr  ) ORDER BY oficio ASC"; 
									$rsun->llenarcombo($opciones = "\"tipOficio\"", $checked = "", $fukcion = "" , $diam = "style=\"width:190px; Height:20px;\""); 
									$rsun->cerrar(); 
									unset($rsun);																						
									?>								
								</td>								
<!--								<td valign="bottom" align="right">
									Unidad Administrativa:&nbsp;								
								</td>
								<td>
									<? /*$rsun = new Recordset();	$rsun->sql = "SELECT id_unidad, unidad FROM unidad WHERE id_unidad <> 8 AND id_unidad <> 1 order by unidad"; 
									$rsun->llenarcombo($opciones = "\"unidad\"", $checked = "", $fukcion = "" , $diam = "style=\"width:240px; Height:20px;\""); 
									$rsun->cerrar(); 
									unset($rsun);*/																						
									?>									
								</td>								
								<td valign="bottom" align="right" width="120">
									N&deg; Correlativo:&nbsp;								
								</td>							
								<td valign="bottom" width="230">
									<input type="text" name="ncorrelativo" id="ncorrelativo" style="width:75px" maxlength="10" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_correlativo,false)" />
								</td>																						
								<td align="right">Mensajero:&nbsp;</td>
								<td>
									<? /*$rsun = new Recordset();	$rsun->sql = "SELECT id_mensajero, nombre_apellido FROM mensajero order by nombre_apellido"; 
									$rsun->llenarcombo($opciones = "\"mensajero\"", $checked = "", $fukcion = "" , $diam = "style=\"width:150px; Height:20px;\""); 
									$rsun->cerrar(); 
									unset($rsun);*/																						
									?>								
								</td>-->
							</tr>
							<tr><td height="10" colspan="8"></td></tr>										
							<tr>
								<td valign="top" align="right">
									Organismo Receptor:
								</td>
								<td valign="bottom" colspan="4">
									<textarea name="organismo" id="organismo" style="width:400px; height:50px;" ></textarea>											
									<input type="hidden" name="id_organismo" id="id_organismo"  />									
								</td>																															
							</tr>
							<tr><td height="10" colspan="8"></td></tr>							
							<tr>
								<td colspan="8" align="center">
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
							<tr class="trcabecera_list_ordenar">
								<td height="33">
									&nbsp;&nbsp;Ordenado por:&nbsp;&nbsp;<select name="por_ordenar" id="por_ordenar" onchange="filtrar(this.value);">
										<option></option>
										<option value="columna1">Estatus</option>
										<option value="columna2">N&deg; Oficio Externo</option>										
										<option value="columna3">Fecha Envio</option>
										<option value="columna4">Organ&iacute;smo</option>													
										<option value="columna5">Documento</option>
										<!--<option value="columna6">Unidad Responsable</option>-->
										<!--<option value="columna7">N&deg; Correlativo</option>-->
									</select>
									&nbsp;&nbsp;&nbsp;
									Ascendente&nbsp;<input type="radio" name="fo_orden" id="asc" onclick="filtrar(document.getElementById('por_ordenar').value);"/>
									&nbsp;&nbsp;&nbsp;									
									Descendente&nbsp;<input type="radio" name="fo_orden" id="des" checked="checked" onclick="filtrar(document.getElementById('por_ordenar').value);"/>									
									<!--&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/ordenar.png" />-->
								</td>
								<td align="right" valign="middle">
									<img src="images/actualizar.png" style="cursor:pointer" title="Actualizar P&aacute;gina" onclick="cargar_lista_corres('modulos/correspondencia/monitoreo_interno/monitoreo_list.php?pagina=1&met=DESC');" />&nbsp;&nbsp;Actualizar&nbsp;&nbsp;&nbsp;
								</td>
							</tr>				
							<tr>
								<td id="zone" colspan="2">&nbsp;
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table border="0" width="100%">
							<TR>
								<td align="left">
									<table class="b_table" cellpadding="0" cellspacing="0" width="230">
										<tr class="trcabecera_list">
											<td colspan="2" height="20">Leyenda:</td>
										</tr>						
										<tr><td height="5"></td></tr>							
										<tr height="20" bgcolor="#f6f5ee">
											<td align="right">Correspondencia Enviada:&nbsp;&nbsp;</td>
											<td>
												<img src="images/enviado.png"  />
											</td>
										</tr>	
										<tr><td height="5"></td></tr>							
										<tr height="20">
											<td align="right">Correspondencia Entregada:&nbsp;&nbsp;</td>
											<td>
												<img src="images/entregado.png"  />
											</td>
										</tr>		
										<tr><td height="5"></td></tr>							
										<tr height="20" bgcolor="#f6f5ee">
											<td align="right">Correspondencia Anulada:&nbsp;&nbsp;</td>
											<td>
												<img src="images/Paper-x.png"  />
											</td>
										</tr>	
										<tr><td height="5"></td></tr>							
										<tr height="20">
											<td align="right">Anular Correspondencia:&nbsp;&nbsp;</td>
											<td>
												<img src="images/no_habilitado.png"  />
											</td>
										</tr>
										<tr><td height="5"></td></tr>							
										<tr height="20">
											<td align="right">Consultar Correspondencia CGR:&nbsp;&nbsp;</td>
											<td>
												<img src="images/consultar.png"  />
											</td>
										</tr>																																							
									</table>								
								</td>
							</TR>
						</table>
					</td>
				</tr>								
			</table>
		</form>
		</td>
	</tr>	
</table>
<?
echo '<script language="javascript" type="text/javascript">cargar_lista_corres("'.'modulos/correspondencia/monitoreo_interno/monitoreo_list.php?pagina=1&met=DESC");</script>'; 
?>
<script language="javascript" type="text/javascript">
	$("#organismo").autocomplete("modulos/correspondencia/monitoreo_interno/lista.php", { 
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
	
	
setInterval('cargar_lista_corres("modulos/correspondencia/monitoreo_interno/monitoreo_list.php?pagina=1&met=DESC")',1800000);		
</script>