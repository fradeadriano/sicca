<?
if(!stristr($_SERVER['SCRIPT_NAME'],"editar_asignacion.php")){
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
		$search->sql = "SELECT crp_asignacion_correspondencia.id_asignacion_correspondencia,crp_asignacion_correspondencia.id_unidad,crp_asignacion_correspondencia.id_prioridad,
		crp_asignacion_correspondencia.unidades_apoyo,crp_asignacion_correspondencia.accion,crp_asignacion_correspondencia.copia_unidades, crp_asignacion_correspondencia.plazo,
		prioridad.prioridad, crp_asignacion_correspondencia.externo, crp_asignacion_correspondencia.observacion, crp_asignacion_correspondencia.modificacion
		 				FROM crp_asignacion_correspondencia LEFT JOIN prioridad ON (crp_asignacion_correspondencia.id_prioridad = prioridad.id_prioridad) 
						WHERE id_recepcion_correspondencia = '".$recepcion."'";
			$search->abrir();
			if($search->total_registros != 0)
			{
				$search->siguiente();
				$con = $search->fila["modificacion"];
				$funcionJ = "";
				if ($search->fila["accion"]=="procesar") {
					$funcionJ = "document.getElementById(\"procesar\").checked = true;";
					if ($search->fila["externo"]==1)
						{ 
							$funcionJ = $funcionJ." document.getElementById(\"si_requiere\").checked = true;";
						 } 
					else if ($search->fila["externo"]==0) 
						{ 
							$funcionJ = $funcionJ." document.getElementById(\"no_requiere\").checked = true;";
							$funcionJ = $funcionJ ."document.getElementById(\"most_prioridad\").style.display = \"none\";";
						}  

					if($search->fila["id_unidad"]!="")
						{ 
							$funcionJ = $funcionJ." document.getElementById(\"cmbunidad\").value =".$search->fila["id_unidad"]."; document.getElementById(\"cmbunidad\").disabled = true;";						
						}	
						
					if($search->fila["unidades_apoyo"]!="")
						{ 
							$funcionJ = $funcionJ ."document.getElementById(\"positivo\").checked = true;";
							$funcionJ = $funcionJ ." document.getElementById(\"cont_marcados\").value = \"".$search->fila["unidades_apoyo"]."\"; ";
							$funcionJ = $funcionJ ." var cantidades = \"\"; cantidades = document.getElementById(\"cont_marcados\").value.split('-'); document.getElementById(\"mostrar_apoyo\").style.display = \"\"; document.getElementById(\"list_apoyos\").style.display = \"\"; 
													for (j = 0;j<cantidades.length;j++)
														{ 
														   for (i=0;i<document.FormAsg.elements.length;i++)
														   {
															  if(document.FormAsg.elements[i].type == \"checkbox\")
															  {
																	if(document.FormAsg.elements[i].value == cantidades[j])
																	{
																		document.FormAsg.elements[i].checked = true;
																	} 
															  }
															}				
														}";					

						} else {
							$funcionJ = $funcionJ ."document.getElementById(\"negativo\").checked = true;";

						}
																	
					if($search->fila["id_prioridad"]!=""){
						$funcionJ = $funcionJ ."document.getElementById(\"prioridad\").value =".$search->fila["id_prioridad"].";";
						if($search->fila["plazo"] !=""){
							$funcionJ = $funcionJ ."document.getElementById(\"vent_plazo\").style.display = \"\";";
							$funcionJ = $funcionJ ."document.getElementById(\"plazo\").value =".$search->fila["plazo"].";";							
						}
						$funcionJ = $funcionJ ." document.getElementById(\"prioridad\").disabled = true; ";
						$funcionJ = $funcionJ ." document.getElementById(\"plazo\").disabled = true; ";
					} else {
						$funcionJ = $funcionJ ." document.getElementById(\"prioridad\").disabled = true; ";
					}					
				} else if ($search->fila["accion"]=="archivar") { 
					$funcionJ = "document.getElementById(\"archivar\").checked = true;";
					$funcionJ = $funcionJ ." document.getElementById(\"cont_marcados\").value = \"".$search->fila["copia_unidades"]."\"; ";
					$funcionJ = $funcionJ ." var cantidades = \"\";  document.getElementById(\"most_prioridad\").style.display = \"none\"; document.getElementById(\"requie_oficio_exter\").style.display = \"none\"; document.getElementById(\"unidad_Asignar\").style.display = \"none\"; document.getElementById(\"list_apoyos\").style.display = \"\"; document.getElementById(\"mostrar_cc1\").style.display = \"\"; cantidades = document.getElementById(\"cont_marcados\").value.split('-'); 
											for (j = 0;j<cantidades.length;j++)
												{ 
												   for (i=0;i<document.FormAsg.elements.length;i++)
												   {
													  if(document.FormAsg.elements[i].type == \"checkbox\")
													  {
															if(document.FormAsg.elements[i].value == cantidades[j])
															{
																document.FormAsg.elements[i].checked = true;
															} 
													  }
													}				
												}";					
				}	
				$aqwe = $search->decodificar($search->fila["observacion"]);
							 
				$funcionJ = $funcionJ ." document.getElementById(\"observacion\").value = \"".$search->decodificar($search->fila["observacion"])."\"; ";
				
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
					$observaciones = $bus->fila["observacion"];				
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
?><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<table width="100%" height="100%" cellpadding="1" cellspacing="0">
	<tr>
		<td align="center">
			<table border="0" width="99%" align="center" cellpadding="2" cellspacing="0">
				<tr>
					<td width="30px"><img src="images/editar.png"/></td>
					<td class="titulomenu" valign="middle">Editar Correspondencia Asignada</td>
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
							<tr align="center" style="display:" >
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
												<td align="right" width="150">
													<b>En respuesta a Oficio:</b>
												</td>
												<td>
													<? 
														if (ctype_digit($n_correlativo_padre)) {echo "<span class='mensaje'>".$n_correlativo_padre."</span>"; } else { echo "<input type='text' name='oficio_padre' id='oficio_padre' maxlength='6' onkeypress='return validar(event,numeros)'/>&nbsp;<span class='mensaje'>*</span>";}												 	
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
													echo $observaciones;
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
												<input type="radio" name="acc" id="procesar" onclick="accion_corres(this.value);" value="procesar" />&nbsp;&nbsp;
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
												<input type="radio" name="req" id="si_requiere" value="si_requiere" <? echo $Sexterno1; ?> onclick="validar_reque_ofi(this.value);"/>&nbsp;&nbsp;
												No&nbsp;
												<input type="radio" name="req" id="no_requiere" value="no_requiere" <? echo $Sexterno2; ?> onclick="validar_reque_ofi(this.value);"/>
											</td>
										</tr>																				
										<tr id="unidad_Asignar" style="display:">
											<td align="right"><b>Asignar a:</b></td>
											<td>
												<? $rsun = new Recordset();	$rsun->sql = "SELECT id_unidad, unidad FROM unidad order by unidad"; 
												$rsun->llenarcombo($opciones = "\"cmbunidad\"", $checked = "$Sunidad", $fukcion = "onchange=\"m_apoyo(this.value)\"" , $diam = "style=\"width:240px; Height:20px;\""); 
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
												<input type="radio" name="apoy" id="positivo" <? echo $Sapoyo1; ?> value="positivo" onclick="Ap_co(this.value);" />&nbsp;&nbsp;
												No&nbsp;
												<input type="radio" name="apoy" id="negativo" <? echo $Sapoyo2; ?> value="negativo" onclick="Ap_co(this.value)"/>
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
												$rsp->llenarcombo($opciones = "\"prioridad\"", $checked = "$Sprioridad", $fukcion = "onchange=\"esta_prioridad(this.value)\"" , $diam = "style=\"width:100px; Height:20px;\"", $disab="$dis"); 
												$rsp->cerrar(); 
												unset($rsp);																						
												?>&nbsp;<span class="mensaje">*</span>
												<span id="vent_plazo" style="display:none">
													&nbsp;&nbsp;<b>Plazo:</b>&nbsp;<input type="text" name="plazo" id="plazo" style="width:30px" maxlength="2" value="<? echo $Splazo;?>" <? echo $dis; ?> onkeypress="return validar(event,numeros)" />&nbsp;<span class="mensaje">*</span>&nbsp;d&iacute;as
												</span>									
											</td>
										</tr>										
										<tr>
											<td valign="top" align="right"><b>Observaci&oacute;n:</b></td>
											<td>
												<textarea disabled="disabled" name="observacion" id="observacion" style="width:450px; height:50px" onkeyup="return maximaLongitud(this.id,200);"><? echo $aqwe; ?></textarea>&nbsp;<span class="mensaje">*</span>
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
									<input type="hidden" name="cont_modi" id="cont_modi" value="<? echo $con; ?>" />
									<input type="button" name="btnRegistrar" id="btnRegistrar" value="Modificar" title="Modificar" onclick="editar();" />
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
<? echo "<script language=\"javascript\" type=\"text/javascript\">function ejecutar_senten () { $funcionJ }  ejecutar_senten (); </script>"; ?>