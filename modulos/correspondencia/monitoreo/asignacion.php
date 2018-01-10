<?
if(!stristr($_SERVER['SCRIPT_NAME'],"asignacion.php")){
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
require_once("../../../librerias/Recordset.php");
require_once("../../../librerias/bitacora.php");	
$recepcion = stripslashes($_GET["id_recepcion"]);
if ((isset($recepcion) && $recepcion !="")){	
	if(ctype_digit($recepcion)){	
		$search = new Recordset();
		$search->sql = "SELECT id_asignacion_correspondencia  FROM crp_asignacion_correspondencia WHERE id_recepcion_correspondencia = '".$recepcion."' AND (id_unidad = '' OR id_unidad IS NULL)";
			$search->abrir();
			if($search->total_registros != 0)
			{
				$bus = new Recordset();
				$bus->sql = "SELECT crp_recepcion_correspondencia.n_correlativo, DATE_FORMAT(crp_recepcion_correspondencia.fecha_documento,'%d/%m/%Y') AS fdocumento, DATE_FORMAT(crp_recepcion_correspondencia.fecha_registro,'%d/%m/%Y %r') AS registro, crp_recepcion_correspondencia.n_documento,
							  organismo.organismo, tipo_documento.tipo_documento, crp_recepcion_correspondencia.id_tipo_documento, crp_recepcion_correspondencia.n_correlativo_padre,
							  crp_recepcion_correspondencia.anfiscal, tipo_respuesta.tipo_respuesta, crp_recepcion_correspondencia.id_tipo_respuesta, 
							  crp_recepcion_correspondencia.gaceta_n, DATE_FORMAT(crp_recepcion_correspondencia.gaceta_fecha,'%d/%m/%Y') AS fecha_gaceta, 
							  crp_recepcion_correspondencia.gaceta_tipo, crp_recepcion_correspondencia.observacion, crp_recepcion_correspondencia.anexo
							   
							FROM
							  crp_recepcion_correspondencia LEFT JOIN organismo ON (crp_recepcion_correspondencia.id_organismo = organismo.id_organismo)
							  INNER JOIN tipo_documento 
							    ON (crp_recepcion_correspondencia.id_tipo_documento = tipo_documento.id_tipo_documento) 
								LEFT JOIN tipo_respuesta ON (crp_recepcion_correspondencia.id_tipo_respuesta = tipo_respuesta.id_tipo_respuesta)							  
							WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$recepcion."'";
				$bus->abrir();
				if($bus->total_registros != 0)
				{
					$bus->siguiente();
					$n_correlativo = $bus->fila["n_correlativo"];
					$fdocumento = $bus->fila["fdocumento"];
					$registro = $bus->fila["registro"];	
					$organismo = $bus->fila["organismo"];																		
					$n_documento = $bus->fila["n_documento"];	
					$id_tipo_respuesta = $bus->fila["id_tipo_respuesta"];
					$id_tipo_documento = $bus->fila["id_tipo_documento"];					
					$n_correlativo_padre = $bus->fila["n_correlativo_padre"];						
					$tipo_documento= $bus->fila["tipo_documento"];
					$tipo_respuesta = $bus->fila["tipo_respuesta"];											
					$anfiscal = $bus->fila["anfiscal"];
					$gaceta_n = $bus->fila["gaceta_n"];						
					$gaceta_tipo = $bus->fila["gaceta_tipo"];						
					$fecha_gaceta = $bus->fila["fecha_gaceta"];
					$observacion = $bus->fila["observacion"];				
					$anexos = $bus->fila["anexo"];																
//					$ = $bus->fila[""];											
				}
			}
	}
}
function montar_documentos(){
		$rsdocu = new Recordset();
		$rsdocu->sql = "SELECT id_unidad, unidad, codigo FROM unidad";
		$rsdocu->abrir();
		$html = "<table border=\"0\" width=\"100%\" align=\"center\"><tr><td>
		<table border=\"0\" width=\"100%\" align=\"center\" cellpadding=\"5\" cellspacing=\"0\" class=\"fuente_pequenna\">";
		for($i=0;$i<$rsdocu->total_registros;$i++){
			$rsdocu->siguiente();
			if($i == 0)
				$html .= "<tr>";
			if(($i % 4 == 0) && ($i < $rsdocu->total_registros))
				$html .= "</tr><tr>";
			$html .= "<td  width=\"200\" align=\"left\"><input type=\"checkbox\" id=\"".$rsdocu->fila["id_unidad"]."\" value=\"".$rsdocu->fila["codigo"]."\" onclick=\"marcar(this.value);\" />&nbsp;".$rsdocu->fila["unidad"]."</td>";
		}
		$html .= "<tr></table></td></tr></table>";
		return $html;
}	

//require_once("bil.php");
?>
<table width="100%" height="100%" cellpadding="1" cellspacing="0">
	<tr>
		<td align="center">
			<table width="99%" align="center" cellpadding="2" cellspacing="0">
				<tr>
					<td width="30px"><img src="images/asignada.png"/></td>
					<td class="titulomenu" valign="middle">Asignaci&oacute;n Correspondencia</td>
				</tr>
				<tr>
					<td colspan="2" valign="top"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td align="center" valign="top">
		<form action="" name="FormAsg" id="FormAsg" method="post">
			<table border="0" align="center" class="b_table" width="100%" height="400" bgcolor="#FFFFFF">			
				<tr valign="top">
					<td align="center">
						<table border="0" cellpadding="3" ccellspacing="2" width="99%">
							<tr align="center" style="display:none" >
								<td colspan="3" align="center" height="0" id="divi">                                  
								</td>
							</tr>							
							<tr>
								<td align="right" width="150">
									<b>Correlativo:</b>&nbsp;
								</td>
								<td>
									<? 
										echo "<span class='mensaje'>".$n_correlativo."</span>";
									?>								
								</td>
							</tr>
							<tr>
								<td align="right">
									<b>Fecha Documento:</b>&nbsp;
								</td>
								<td>
									<? 
										echo $fdocumento;
									?>																								
								</td>
								<td align="right">
									<b>Fecha Registro:&nbsp;</b>
								</td>
								<td>
									<? 
										echo $registro;
									?>																								
								</td>								
							</tr>
							<tr>
								<td align="right" width="150">
									<b>N&deg; Documento:</b>&nbsp;
								</td>
								<td>
									<? 
										if ($n_documento!=""){echo $n_documento;} else {echo "<u>Sin N&uacute;mero</u>";}
									?>								
								</td>
							</tr>							
							<tr>
								<td align="right">
									<b>Organ&iacute;smo:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
										echo ucwords(mb_strtolower($organismo));
									?>								
								</td>
							</tr>													
						</table>
						<table border="0" cellpadding="3" ccellspacing="2" width="99%">
							<tr>
								<td align="center">
									<fieldset style="width:97%; border-color:#EFEFEF"> 
									<legend class="titulomenu">Detalle Correspondencia</legend>																
									<table border="0" cellpadding="2" ccellspacing="0" width="99%">
<?									if($id_tipo_documento==5) // oficio
										{
?>
											<tr>
												<td align="right" width="120">
													<b>Tipo Documento:</b>
												</td>
												<td>
													<? 
														echo $tipo_documento;
													?>																			
												</td>											
											</tr>
<?
										 	if(ctype_digit($id_tipo_respuesta)){
										?>	
											
											<tr>
												<td align="right" width="120">
													<b>Tipo Respuesta:</b>
												</td>
												<td>
													<? 
														echo $tipo_respuesta;
													?>																			
												</td>
												<td align="right" width="150" rowspan="2" valign="top" colspan="2">
													<b>En respuesta a Oficio:</b>
													<? 
														if (ctype_digit($n_correlativo_padre)) {echo $n_correlativo_padre; } else { echo "<input type='text' name='oficio_padre' id='oficio_padre' maxlength='6' style='width:50px' onchange='life(this.value,\"objeto\");' onkeypress='return validar(event,numeros)'/>&nbsp;<span class='mensaje'>*</span>";}												 	
/*														if (ctype_digit($n_correlativo_padre)){echo "<span class='mensaje'>".$n_correlativo_padre."</span>";  
															$rsdocu = new Recordset();
															$rsdocu->sql = "";
															$rsdocu->abrir();												
															if($rsdocu->total_registros>0)
															{
															
															}
														} else {
															echo "<input type='text' name='oficio_padre' id='oficio_padre' maxlength='6' onkeypress='return validar(event,numeros)'/>&nbsp;<span class='mensaje'>*</span>";															
														}*/												 	
													?>																			
												</td>											
											</tr>
												<? if($id_tipo_respuesta==1 || $id_tipo_respuesta==2) 
												{ 
												?>
											<tr>
												<td align="right">
													<b>Ejercicio Fiscal:</b>
												</td>
												<td align="left">
													<?
														echo $anfiscal;	
													?>													
												</td>																																	
											</tr>										
										<?
												}
											} 
										
										} else if($id_tipo_documento==11){ //gaceta   
?>											
											<tr>
												<td align="right" width="120">
													<b>Tipo Documento:</b>
												</td>
												<td>
													<? 
														echo $tipo_documento;
													?>																			
												</td>
												<td align="right" width="120">
													<b>N&deg; Gaceta:</b>
												</td>
												<td>
													<? 
														echo $gaceta_n;
													?>																			
												</td>																						
											</tr>
											<tr>
												<td align="right" width="120">
													<b>Fecha Gaceta:</b>
												</td>
												<td>
													<? 
														echo $fecha_gaceta;
													?>																			
												</td>
												<td align="right" width="120">
													<b>Tipo Gaceta:</b>
												</td>
												<td>
													<? 
														echo $gaceta_tipo;
													?>																			
												</td>																						
											</tr>																					
<?										
										} else if($id_tipo_documento==4){ //invitaciones  
?>
											<tr>
												<td align="right" width="120">
													<b>Tipo Documento:</b>
												</td>
												<td>
													<? 
														echo $tipo_documento;
													?>																			
												</td>
											</tr>
<?
										} else if($id_tipo_documento==6){ //donaciones  
?>
											<tr>
												<td align="right" width="120">
													<b>Tipo Documento:</b>
												</td>
												<td>
													<? 
														echo $tipo_documento;
													?>																			
												</td>
											</tr>
<?
										} else if($id_tipo_documento==12){ //denuncia  
?>
											<tr>
												<td align="right" width="120">
													<b>Tipo Documento:</b>
												</td>
												<td>
													<? 
														echo $tipo_documento;
													?>																			
												</td>
											</tr>
<?
										}								
										if($anexos!=""){
									?>
										<tr>
											<td align="right" width="120">
												<b>Anexos:</b>
											</td>
											<td colspan="3">
												<? 
													echo $anexos;
												?>																			
											</td>
										</tr>
									<?   }   ?>											
										<tr>
											<td align="right" width="120">
												<b>Motivo:</b>
											</td>
											<td colspan="3">
												<? 
													echo $observacion;
												?>																			
											</td>
										</tr>																		
									</table>									
									</fieldset>
								</td>
							</tr>
							<tr>
								<td>
									<fieldset style="width:97%; border-color:#EFEFEF"> 
									<legend class="titulomenu">Asignaci&oacute;n</legend>		
									<table cellspacing="3" cellpadding="2" border="0" width="100%">
										<tr>
											<td align="right" width="190">
												<b>Acci&oacute;n:</b>
											</td>
											<td>
												Procesar
												<input type="radio" name="acc" id="procesar"  checked="checked" onclick="accion_corres(this.value);" value="procesar" />&nbsp;&nbsp;
												Archivar
												<input type="radio" name="acc" id="archivar" onclick="accion_corres(this.value);" value="archivar" />
											</td>
										</tr>
										<tr id="requie_oficio_exter">
											<td align="right">
												<b>Requiere Oficio Externo:</b>
											</td>
											<td>
												Si&nbsp;
												<input type="radio" name="req" id="si_requiere" value="si_requiere" checked="checked" onclick="validar_reque_ofi(this.value);"/>&nbsp;&nbsp;
												No&nbsp;
												<input type="radio" name="req" id="no_requiere" value="no_requiere" onclick="validar_reque_ofi(this.value);"/>
											</td>
										</tr>																				
										<tr id="unidad_Asignar" style="display:">
											<td align="right"><b>Asignar a:</b></td>
											<td>
												<? $rsun = new Recordset();	$rsun->sql = "SELECT id_unidad, unidad FROM unidad WHERE id_unidad <> 1 order by unidad"; 
												$rsun->llenarcombo($opciones = "\"cmbunidad\"", $checked = "", $fukcion = "onchange=\"m_apoyo(this.value)\"" , $diam = "style=\"width:240px; Height:20px;\""); 
												$rsun->cerrar(); 
												unset($rsun);																						
												?>&nbsp;<span class="mensaje">*</span>													
											</td>
										</tr>
										<tr id="mostrar_apoyo" style="display:none">
											<td align="right">
												<b>Con Apoyo:</b>
											</td>
											<td>
												Si&nbsp;
												<input type="radio" name="apoy" id="positivo" value="positivo" onclick="Ap_co(this.value);" />&nbsp;&nbsp;
												No&nbsp;
												<input type="radio" name="apoy" id="negativo" value="negativo" checked="checked" onclick="Ap_co(this.value)"/>
											</td>
										</tr>
										<tr id="mostrar_cc1" style="display:none">
											<td align="right">
												<b>Con Copia a:</b>
											</td>
											<td></td>
										</tr>										
										<tr id="list_apoyos" style="display:none">
											<td colspan="2" valign="top">
												<table width="100%"  class="b_table">
													<tr align="center">
														<td align="center">
															<? echo montar_documentos();?>
															<input type="hidden" name="cont_marcados" id="cont_marcados"/>
														</td>
													</tr>												
												</table>
											</td>
										</tr>
										<tr id="most_prioridad" style="display:">
											<td align="right">
												<b>Prioridad:</b>
											</td>
											<td valign="bottom">
												<? 
												$rsp = new Recordset();
												$rsp->sql = "SELECT id_prioridad, prioridad FROM prioridad"; 
												$rsp->llenarcombo($opciones = "\"prioridad\"", $checked = "", $fukcion = "onchange=\"esta_prioridad(this.value)\"" , $diam = "style=\"width:120px; Height:20px;\""); 
												$rsp->cerrar(); 
												unset($rsp);																						
												?>&nbsp;<span class="mensaje">*</span>
												<span id="vent_plazo" style="display:none">
													&nbsp;&nbsp;<b>Plazo:</b>&nbsp;<input type="text" name="plazo" id="plazo" maxlength="2" onkeypress="return validar(event,numeros)" />&nbsp;<span class="mensaje">*</span>
												</span>									
											</td>
										</tr>
										<tr>
											<td valign="top" align="right"><b>Observaci&oacute;n:</b></td>
											<td>
												<textarea name="observacion" id="observacion" style="width:450px; height:50px" onkeyup="return maximaLongitud(this.id,200);"></textarea>&nbsp;<span class="mensaje">*</span>
												<br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span>
											</td>
										</tr>																				
									</table>
									</fieldset>									
								</td>
							</tr>
							<tr><td align="right" class="mensaje">* Campos Obligatorios&nbsp;&nbsp;</td></tr>							
							<tr>
								<td align="center">
									<input type="hidden" name="id_recep" id="id_recep" value="<? echo $recepcion; ?>" />
									<input type="button" name="btnRegistrar" id="btnRegistrar" value="Asignar" title="Asignar" onclick="almacenar(this.value);" />
									&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="reset" name="btnCancelar" id="btnCancelar" value="Cancelar" title="Cancelar" onclick="arreglar();" />
									&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="button" class="botones" onclick="window.top.closeMessage();" id="regresar" name="regresar" value="Regresar" title="Regresar" />																
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