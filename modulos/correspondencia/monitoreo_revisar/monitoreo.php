<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado de Usuarios</title>
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
	<tr><td height="20"></td></tr>
	<tr> 
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="45px"><img src="images/monitor1.png"/></td>
					<td class="titulomenu" valign="middle">Revisi&oacute;n Correspondencia</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>
<!--	<tr>
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="50px"><img src="images/monitor.png"/></td>
					<td class="titulomenu" valign="middle">Monitoreo Correspondencia</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center">
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="60px"><img src="images/1monitor.png"/></td>
					<td class="titulomenu" valign="middle">Monitoreo Correspondencia</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>-->
	<tr>
		<td align="center">
		<form action="" name="FormPla" id="FormPla" method="post">
			<table border="0" class="b_table">
				<tr>
					<td align="center">
						<fieldset style="width:90%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Filtrado Correspondencia</legend>
						<table border="0" width="100%" class="b_table_b" bgcolor="#F8F8F8"  cellpadding="2" cellspacing="0">
							<tr>
								<td valign="bottom"  align="right" width="132">
									Tipo Documento:&nbsp;
								</td>
								<td valign="bottom">
									<? 
									$rsun = new Recordset();
									$rsun->sql = "SELECT id_tipo_documento, tipo_documento FROM tipo_documento WHERE cgr=0 order by tipo_documento"; 
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
									$rses->sql = "SELECT id_estatus, estatus FROM estatus WHERE id_estatus BETWEEN 2 AND 6 order by orden"; 
									$rses->llenarcombo($opciones = "\"estatus\"", $checked = "", $fukcion = "" , $diam = "style=\"width:100px; Height:20px;\""); 
									$rses->cerrar(); 
									unset($rsun);																						
									?>
								</td>
								<td width="10"></td>
								<td valign="bottom" align="right">
									N&deg; Documento:&nbsp;								
								</td>							
								<td valign="bottom">
									<input type="text" name="ndocumento" id="ndocumento" style="width:70px" />
								</td>							
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
								<td width="10"></td>
								<td valign="bottom" align="right">
									Correspondencia:&nbsp;
								</td>
								<td>
									Institucional<input type="radio" name="tipo_corres" id="institucional" checked="checked" />&nbsp;&nbsp;&nbsp;&nbsp;Personal<input type="radio" name="tipo_corres" id="personal" />
								</td>							
							</tr>
							<tr><td height="10" colspan="8"></td></tr>										
							<tr>
								<td valign="bottom" align="right">
									Organismo:&nbsp;
								</td>
								<td valign="bottom" colspan="5">
									<textarea name="organismo" id="organismo" style="width:400px; height:30px;" ></textarea>											
									<input type="hidden" name="id_organismo" id="id_organismo"  />									
								</td>
								<td valign="bottom" align="right">
									N&deg; Correlativo:&nbsp;								
								</td>							
								<td valign="bottom">
									<input type="text" name="ncorrelativo" id="ncorrelativo" style="width:75px" maxlength="10" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_correlativo,false)" />
								</td>																							
							</tr>
							<tr><td height="10" colspan="8"></td></tr>							
							<tr>
								<td valign="bottom" align="left"  colspan="4">
									Unidad Administrativa:&nbsp;<? $rsun = new Recordset();	$rsun->sql = "SELECT id_unidad, unidad FROM unidad WHERE id_unidad <> 8 AND id_unidad <> 1 order by unidad"; 
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
							<tr class="trcabecera_list_ordenar">
								<td height="33">
									&nbsp;&nbsp;Ordenado por:&nbsp;&nbsp;<select name="por_ordenar" id="por_ordenar" onchange="filtrar(this.value);">
										<option></option>
										<option value="columna1">Tipo Documento</option>
										<option value="columna2">N&deg; Documento</option>										
										<option value="columna3">Organ&iacute;smo / Remitente</option>							
										<option value="columna4">Fecha Registro</option>										
										<option value="columna5">Fecha Documento</option>																				
										<option value="columna6">Tipo Correspondencia</option>
										<option value="columna7">Estatus</option>
										<option value="columna8">Unidad Asignada</option>
										<option value="columna9">N&deg; Correlativo</option>
										<option value="columna10">Prioridad</option>																														
									</select>
									&nbsp;&nbsp;&nbsp;
									Ascendente&nbsp;<input type="radio" name="fo_orden" id="asc" onclick="filtrar(document.getElementById('por_ordenar').value);"/>
									&nbsp;&nbsp;&nbsp;									
									Descendente&nbsp;<input type="radio" name="fo_orden" id="des" checked="checked" onclick="filtrar(document.getElementById('por_ordenar').value);"/>									
									<!--&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/ordenar.png" />-->
								</td>
								<td align="right" valign="middle">
									<img src="images/actualizar.png" style="cursor:pointer" title="Actualizar P&aacute;gina" onclick="cargar_lista_corres('modulos/correspondencia/monitoreo_revisar/monitoreo_list.php?pagina=1&met=DESC');" />&nbsp;&nbsp;Actualizar&nbsp;&nbsp;&nbsp;
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
									<table class="b_table" cellpadding="0" cellspacing="0" width="220">
										<tr class="trcabecera_list">
											<td colspan="2" height="20">Leyenda:</td>
										</tr>						
										<tr><td height="5"></td></tr>								
										<tr bgcolor="#f6f5ee" height="30">
											<td align="right">Correspondencia Sin Habilitar:&nbsp;&nbsp;</td>
											<td>
												<img src="images/no_habilitado.png" />
											</td>
										</tr>
										<tr><td height="5"></td></tr>							
										<tr height="20">
											<td align="right">Correspondencia Por Recibir: &nbsp;&nbsp;</td>
											<td>
												<img src="images/recepcion.png"  />
											</td>
										</tr>
										<tr><td height="5"></td></tr>							
										<tr bgcolor="#f6f5ee" height="30">
											<td align="right">Devolver Correspondencia :&nbsp;&nbsp;</td>
											<td>
												<img src="images/devolucion.png" />
											</td>
										</tr>
										<tr><td height="5"></td></tr>							
										<tr height="20">
											<td align="right">Visualizar Correspondencia:&nbsp;&nbsp;</td>
											<td>
												<img src="images/consultar.png"  />
											</td>
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
echo '<script language="javascript" type="text/javascript">cargar_lista_corres("'.'modulos/correspondencia/monitoreo_revisar/monitoreo_list.php?pagina=1&id_ca='.$valor.'&met=DESC");</script>'; 
?>
<script language="javascript" type="text/javascript">
	$("#organismo").autocomplete("modulos/correspondencia/monitoreo_revisar/lista.php", { 
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
setInterval('cargar_lista_corres("modulos/correspondencia/monitoreo_revisar/monitoreo_list.php?pagina=1&met=DESC")',1800000);		
</script>