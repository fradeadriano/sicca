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
	$u = base64_decode($_SESSION["MyIdUser"]);
	$bsq1 = new Recordset();
	$bsq1->sql = "SELECT id_unidad FROM seg_usuario LEFT JOIN encargado_unidad ON (seg_usuario.id_usuario = encargado_unidad.id_usuario) WHERE seg_usuario.id_usuario = ".$u;
	$bsq1->abrir();
	if($bsq1->total_registros > 0)
		{	
			$bsq1->siguiente();
			$unidadD = $bsq1->fila["id_unidad"];
		}
	$bsq1->cerrar();
	unset($bsq1);
?>
<script type="text/javascript" src="librerias/jq.js"></script>
<script type="text/javascript" src="librerias/jquery.autocomplete.js"></script>
<table border="0" align="center" width="1000">
	<tr><td height="20"></td></tr>	
	<tr> 
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="50px"><img src="images/monitor1.png"/></td>
					<td class="titulomenu" valign="middle">Correspondencias CGR Asignadas</td>
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
		<input type="hidden" name="valorUnidad" id="valorUnidad" value="<? echo $unidadD; ?>" />
			<table border="0" class="b_table">
				<tr>
					<td align="center">
						<fieldset style="width:90%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Filtrado Correspondencia</legend>
						<table border="0" width="100%" class="b_table_b" bgcolor="#ECE9D8"  cellpadding="2" cellspacing="0">
							<tr>
<!--								<td valign="bottom"  align="right" width="132">
									Tipo Documento:&nbsp;
								</td>
								<td valign="bottom">
									<? 
								/*	$rsun = new Recordset();
									$rsun->sql = "SELECT id_tipo_documento, tipo_documento FROM tipo_documento WHERE cgr=1 order by tipo_documento"; 
									$rsun->llenarcombo($opciones = "\"tipo_documento\"", $checked = "", $fukcion = "" , $diam = "style=\"width:120px; Height:20px;\""); 
									$rsun->cerrar(); 
									unset($rsun);*/																						
									?>
								</td>-->	
								<td valign="bottom" align="right">
									N&deg; Correlativo:&nbsp;								
								</td>							
								<td valign="bottom">
									<input type="text" name="ncorrelativo" id="ncorrelativo" style="width:75px" maxlength="10" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_correlativo,false)" />&nbsp;- CGR
								</td>
								<td width="10"></td>															
								<td valign="bottom" align="right">
									Estatus:&nbsp;
								</td>
								<td valign="bottom">
									<? 
									$rses = new Recordset();
									$rses->sql = "SELECT id_estatus, estatus FROM estatus WHERE cgr=1 AND (id_estatus BETWEEN 1 AND 6)order by orden"; 
									$rses->llenarcombo($opciones = "\"estatus\"", $checked = "", $fukcion = "" , $diam = "style=\"width:100px; Height:20px;\""); 
									$rses->cerrar(); 
									unset($rsun);																						
									?>
								</td>
								<td width="10"></td>
								<td valign="bottom" align="right">
									N&deg; Oficio/Circular:&nbsp;								
								</td>							
								<td valign="bottom">
									<input type="text" name="ndocumento" id="ndocumento" style="width:70px" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_cgr,false)" />
								</td>							
							</tr>
							<tr><td height="10" colspan="8" ></td></tr>							
							<tr>
								<td valign="bottom" align="right">
									Fecha&nbsp;de&nbsp; 
								</td>		
								<td valign="bottom" colspan="7">
									<select name="sel_fecha"  id="sel_fecha">
										<option selected="selected"></option>
										<option id="documento" value="documento">Oficio/Circular</option>
										<option id="registro" value="registro">Registro</option>
										<option id="asignacion" value="asignacion">Asignaci&oacute;n</option>
									</select>&nbsp;&nbsp;Entre:
									<input type="text" name="desde" id="desde" style="width:70px" onkeyup="this.value=formateafecha(this.value);" />&nbsp;y&nbsp;<input type="text" name="hasta" id="hasta" onkeyup="this.value=formateafecha(this.value);" style="width:70px"/>
									&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span>
								</td>														
<!--								<td width="10"></td>
								<td valign="bottom" align="right">
									Correspondencia:&nbsp;
								</td>
								<td>
									Institucional<input type="radio" name="tipo_corres" id="institucional" checked="checked" />&nbsp;&nbsp;&nbsp;&nbsp;Personal<input type="radio" name="tipo_corres" id="personal" />
								</td>-->							
							</tr>
							<tr><td height="10" colspan="8"></td></tr>										
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
<!--								<td valign="bottom" align="right">Prioridad:&nbsp;</td>
								<td valign="bottom" align="left"  colspan="3">
									<? /*$rsun = new Recordset();	$rsun->sql = "SELECT id_prioridad, prioridad FROM prioridad order by prioridad"; 
									$rsun->llenarcombo($opciones = "\"prioridad\"", $checked = "", $fukcion = "" , $diam = "style=\"width:120px; Height:20px;\""); 
									$rsun->cerrar(); 
									unset($rsun);*/																						
									?>									
								</td>-->
								<td colspan="8" align="center">
									<input type="button" name="btnFiltra" id="btnFiltra" value="Filtrar" title="Filtrar" onclick="doit(document.getElementById('valorUnidad').value);" />
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
							<tr class="trcabecera_list_ordenar1">
								<td height="33">
									&nbsp;&nbsp;Ordenado por:&nbsp;&nbsp;<select name="por_ordenar" id="por_ordenar" onchange="filtrar(this.value);">
										<option></option>
										<!--<option value="columna1">Tipo Documento</option>-->
										<option value="columna2">N&deg; Oficio/Circular</option>										
										<option value="columna3">Direcci&oacute;n</option>							
										<option value="columna4">Fecha Registro</option>										
										<option value="columna5">Fecha Oficio/Circular</option>																				
										<!--<option value="columna6">Tipo Correspondencia</option>-->
										<option value="columna7">Estatus</option>
										<option value="columna8">Fecha Asignaci&oacute;n</option>
										<option value="columna9">N&deg; Correlativo</option>
										<!--<option value="columna10">Prioridad</option>-->																														
									</select>
									&nbsp;&nbsp;&nbsp;
									Ascendente&nbsp;<input type="radio" name="fo_orden" id="asc" onclick="filtrar(document.getElementById('por_ordenar').value);"/>
									&nbsp;&nbsp;&nbsp;									
									Descendente&nbsp;<input type="radio" name="fo_orden" id="des" checked="checked" onclick="filtrar(document.getElementById('por_ordenar').value);"/>									
									<!--&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/ordenar.png" />-->
								</td>
								<td align="right" valign="middle">
									<img src="images/actualizar.png" style="cursor:pointer" title="Actualizar P&aacute;gina" onclick="cargar_lista_corres('modulos/correspondencia/cgr/monitoreo_unidad/monitoreo_list.php?pagina=1&met=DESC&Uunidad=<? echo $unidadD?>');" />&nbsp;&nbsp;Actualizar&nbsp;&nbsp;&nbsp;
								</td>
							</tr>				
							<tr><td id="zone" colspan="2">&nbsp;</td></tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table border="0" width="100%">
							<TR>
								<td align="left">
									<table class="b_table" cellpadding="0" cellspacing="0" width="220">
										<tr class="trcabecera_list1">
											<td colspan="2" height="20">Leyenda:</td>
										</tr>						
										<tr><td height="5"></td></tr>								
										<tr bgcolor="#f6f5ee" height="30">
											<td align="right">Correspondencia Asignada:&nbsp;&nbsp;</td>
											<td>
												<img src="images/asignadas.png" />
											</td>
										</tr>
										<tr><td height="5"></td></tr>							
										<tr height="20">
											<td align="right">Correspondencia Recibida: &nbsp;&nbsp;</td>
											<td>
												<img src="images/recibido.png"  />
											</td>
										</tr>
										<tr><td height="5"></td></tr>							
										<tr bgcolor="#f6f5ee" height="30">
											<td align="right">Correspondencia Habilitada:&nbsp;&nbsp;</td>
											<td>
												<img src="images/habilitado.png" />
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
<? //$valor = stripslashes($_GET["iddcalificacion"]); +"&met="+metod
echo '<script language="javascript" type="text/javascript">cargar_lista_corres("'.'modulos/correspondencia/cgr/monitoreo_unidad/monitoreo_list.php?pagina=1&Uunidad='.$unidadD.'&met=DESC");</script>'; 
?>
<script language="javascript" type="text/javascript">
	$("#organismo").autocomplete("modulos/correspondencia/cgr/monitoreo_unidad/lista.php", { 
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
setInterval('cargar_lista_corres("modulos/correspondencia/cgr/monitoreo_unidad/monitoreo_list.php?pagina=1&met=DESC&Uunidad=<? echo $unidadD; ?>")',1800000);		
</script>