<?
if(!stristr($_SERVER['SCRIPT_NAME'],"transferir.php")){
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
		$tra = new Recordset();
		$tra->sql = "SELECT id_recepcion_correspondencia FROM crp_transferencia_correspondencia WHERE id_recepcion_correspondencia =".$recepcion;
		$tra->abrir();
		$tra->siguiente();
		$canttra = $tra->total_registros;				
		$tra->cerrar();	
		unset($tra);
		$search = new Recordset();
		$search->sql = "SELECT crp_asignacion_correspondencia.id_asignacion_correspondencia,crp_asignacion_correspondencia.id_unidad,crp_asignacion_correspondencia.id_prioridad,
		crp_asignacion_correspondencia.unidades_apoyo,crp_asignacion_correspondencia.accion,crp_asignacion_correspondencia.copia_unidades, crp_asignacion_correspondencia.plazo,
		prioridad.prioridad, crp_asignacion_correspondencia.externo, crp_asignacion_correspondencia.observacion, crp_asignacion_correspondencia.modificacion, unidad.unidad
		 				FROM crp_asignacion_correspondencia LEFT JOIN prioridad ON (crp_asignacion_correspondencia.id_prioridad = prioridad.id_prioridad)
								LEFT JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad)  
						WHERE id_recepcion_correspondencia = '".$recepcion."'";
			$search->abrir();
			if($search->total_registros != 0)
			{
				$search->siguiente();
				$accion = $search->fila["accion"];
				$unidad = $search->fila["unidad"];
				if ($search->fila["externo"]==1)
					{ 
						$exter= "Si";
					 } 
					else if ($search->fila["externo"]==0) 
					{ 
						$exter= "Si";						
					}  
				$prioridad = $search->fila["prioridad"];
				if($search->fila["plazo"] !=""){
					$prioridad_plazo = "<b>Plazo:</b> ".$search->fila["plazo"];
				}						
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
?>
<table width="100%" height="100%" cellpadding="1" cellspacing="0">
	<tr>
		<td align="center">
			<table border="0" width="99%" align="center" cellpadding="2" cellspacing="0">
				<tr>
					<td width="30px"><img src="images/transferir.png"/></td>
					<td class="titulomenu" valign="middle">Transferir Correspondencia</td>
				</tr>
				<tr>
					<td colspan="2" valign="top"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td align="center" valign="top">
		<form action="" name="FormTran" id="FormTran" method="post">
			<table border="0" align="center" class="b_table" width="100%" height="400" bgcolor="#FFFFFF">			
				<tr valign="top">
					<td align="center">
						<table border="0" cellpadding="3" ccellspacing="2" width="99%">
							<tr align="center" style="display:none">
								<td colspan="3" align="center" height="0" id="diviT">                                
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
									<table border="0" cellpadding="2" cellspacing="3" width="99%">
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
												<b>Observaci&oacute;n:</b>
											</td>
											<td colspan="3">
												<? 
													echo $observacion;
												?>																			
											</td>
										</tr>																		
										<tr>
											<td align="right" width="120">
												<b>Acci&oacute;n:</b>
											</td>
											<td colspan="3">
												<? 
													echo $accion;
												?>																			
											</td>
										</tr>									
										<tr>
											<td align="right" width="150">
												<b>Requiere Ofc. Externo:</b>
											</td>
											<td colspan="3">
												<? 
													echo $exter;
												?>																			
											</td>
										</tr>
										<? if($prioridad!=""){ ?>
										<tr>
											<td align="right" width="120">
												<b>Prioridad:</b>
											</td>
											<td>
												<? 
													echo $prioridad;
												?>																			
											</td>
											<td colspan="2">
												<? echo $prioridad_plazo; ?>
											</td>
										</tr>	
										<? } ?>	
										<tr>
											<td align="right" width="150">
												<b>Asignada a:</b>
											</td>
											<td colspan="3">
												<? 
													echo $unidad;
												?><input type="hidden" name="id_unidad" id="id_unidad" value="<? echo $search->fila["id_unidad"]; ?>">																			
											</td>
										</tr>														
										<tr>
											<td align="right" width="150">
												<b>Transferir a:</b>
											</td>
											<td colspan="3">
												<? 
												$sqql = "SELECT id_unidad, unidad FROM unidad WHERE id_unidad <> 8 AND id_unidad <> ".$search->fila["id_unidad"]." order by unidad";											
												$rsun = new Recordset();	
												$rsun->sql = $sqql; 
												$rsun->llenarcombo($opciones = "\"cmbunidad\"", $checked = "", $fukcion = "" , $diam = "style=\"width:240px; Height:20px;\""); 
												$rsun->cerrar(); 
												unset($rsun);																						
												?>&nbsp;<span class="mensaje">*</span>												
											</td>
										</tr>	
										<tr>
											<td valign="top" align="right"><b>Motivo:</b></td>
											<td colspan="3">
												<textarea name="motivo" id="motivo" style="width:450px; height:50px" onkeyup="return maximaLongitud(this.id,200);"></textarea>&nbsp;<span class="mensaje">*</span>
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
									<input type="hidden" name="transferencias" id="transferencias" value="<? echo $canttra; ?>" />
									<input type="hidden" name="id_recep" id="id_recep" value="<? echo $recepcion; ?>" />
									<input type="button" name="btnRegistrar" id="btnRegistrar" value="Modificar" title="Modificar" onclick="transferir();" />
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