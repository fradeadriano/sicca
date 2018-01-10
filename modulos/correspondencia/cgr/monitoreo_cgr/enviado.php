<?
if(!stristr($_SERVER['SCRIPT_NAME'],"enviado.php")){
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
		$search->sql = "SELECT id_asignacion_correspondencia  FROM crp_asignacion_correspondencia WHERE (id_recepcion_correspondencia = '".$recepcion."')";
			$search->abrir();
			if($search->total_registros != 0)
			{
				$ext = 0;
				$bus1 = new Recordset();
				$bus1->sql = "SELECT crp_correspondencia_externa.n_oficio_externo, 
										DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%d/%m/%Y %r') AS fregistro, 
										crp_correspondencia_externa.plazo, 
										IF (mensajero.nombre_apellido IS NOT NULL,mensajero.nombre_apellido,'--') AS mensajero, crp_correspondencia_externa.id_recepcion_correspondencia, crp_correspondencia_externa.id_correspondencia_externa
									FROM crp_correspondencia_externa LEFT JOIN mensajero ON (crp_correspondencia_externa.id_mensajero = mensajero.id_mensajero)
									WHERE crp_correspondencia_externa.id_recepcion_correspondencia = '".$recepcion."'";
				$bus1->abrir();
				if($bus1->total_registros != 0)
				{
					$bus1->siguiente();
					$n_oficio = $bus1->fila["n_oficio_externo"];
					$fregistro = $bus1->fila["fregistro"];
					$plazo = $bus1->fila["plazo"];																		
					$nombre_apellido = $bus1->fila["mensajero"];	
					$id_recepcion_correspondencia = $bus1->fila["id_recepcion_correspondencia"];
					$id_correspondencia_externa = $bus1->fila["id_correspondencia_externa"];					
																							
//					$ = $bus->fila[""];											
				} else {
					$ext = 1;								
				}
				$bus = new Recordset();
				$bus->sql = "SELECT crp_recepcion_correspondencia.n_correlativo, DATE_FORMAT(crp_recepcion_correspondencia.fecha_documento,'%d/%m/%Y') AS fdocumento, DATE_FORMAT(crp_recepcion_correspondencia.fecha_registro,'%d/%m/%Y %r') AS registro, crp_recepcion_correspondencia.n_documento,
							  organismo.organismo, tipo_documento.tipo_documento, crp_recepcion_correspondencia.id_tipo_documento, crp_recepcion_correspondencia.n_correlativo_padre,
							  crp_recepcion_correspondencia.anfiscal, tipo_respuesta.tipo_respuesta, crp_recepcion_correspondencia.id_tipo_respuesta, 
							  crp_recepcion_correspondencia.gaceta_n, DATE_FORMAT(crp_recepcion_correspondencia.gaceta_fecha,'%d/%m/%Y') AS fecha_gaceta, 
							  crp_recepcion_correspondencia.gaceta_tipo, crp_recepcion_correspondencia.observacion, crp_recepcion_correspondencia.anexo,
							   DATE_FORMAT(crp_asignacion_correspondencia.fecha_asignacion,'%d/%m/%Y %r') AS f_asignacion,
							   IF(crp_asignacion_correspondencia.externo=1,'Requiere Oficio Externo.','No Requiere Oficio Externo.') AS externo,
							   crp_asignacion_correspondencia.accion, prioridad.prioridad, crp_asignacion_correspondencia.plazo,
							   crp_asignacion_correspondencia.copia_unidades, crp_asignacion_correspondencia.unidades_apoyo, estatus.estatus, crp_asignacion_correspondencia.id_asignacion_correspondencia,
							   crp_asignacion_correspondencia.observacion as obser_asig
							FROM
							  crp_recepcion_correspondencia LEFT JOIN organismo ON (crp_recepcion_correspondencia.id_organismo = organismo.id_organismo)
							  INNER JOIN tipo_documento 
							    ON (crp_recepcion_correspondencia.id_tipo_documento = tipo_documento.id_tipo_documento) 
								LEFT JOIN tipo_respuesta ON (crp_recepcion_correspondencia.id_tipo_respuesta = tipo_respuesta.id_tipo_respuesta)
    							INNER JOIN crp_asignacion_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_asignacion_correspondencia.id_recepcion_correspondencia)							  
								LEFT JOIN prioridad ON (crp_asignacion_correspondencia.id_prioridad = prioridad.id_prioridad)
								INNER JOIN estatus ON (crp_asignacion_correspondencia.id_estatus = estatus.id_estatus)
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
					$f_asignacion = $bus->fila["f_asignacion"];																
					$accion = $bus->fila["accion"];																
					$externo = $bus->fila["externo"];	
					$prioridad = $bus->fila["prioridad"];
					$plazo = $bus->fila["plazo"];	
					$observacion = $bus->fila["observacion"];	
					$copia_unidades = $bus->fila["copia_unidades"];																
					$unidades_apoyo = $bus->fila["unidades_apoyo"];
					$estatus = $bus->fila["estatus"];																			
					$id_asignacion_correspondencia = $bus->fila["id_asignacion_correspondencia"];					

					$obser_asignacion = $bus->fila["obser_asig"];											
//					$ = $bus->fila[""];											
				}
			}
	}
}
?>
<table width="100%" cellpadding="1" cellspacing="0">
	<tr>
		<td align="center">
			<table width="100%" align="center" cellpadding="2" cellspacing="0">
				<tr>
					<td width="30px"><img src="images/enviado.png"/></td>
					<td class="titulomenu" valign="middle">Visualizar Correspondencia Enviada</td>
				</tr>
				<tr>
					<td colspan="2" valign="top"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td align="center" valign="top">
			<table border="0" align="center" class="b_table" width="100%" height="400" bgcolor="#FFFFFF">			
				<tr valign="top">
					<td align="center">
<?
					if($ext==0)
					{
?>						
						<fieldset style="width:97%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Detalle del Oficio Externo</legend>							
						<table border="0" cellpadding="3" ccellspacing="2" width="99%">						
							<tr>
								<td align="right" width="150">
									<b>N&deg; Oficio Externo:</b>&nbsp;
								</td>
								<td>
									<? 
										echo "<span class='mensaje'>".$n_oficio."</span>";
									?>								
								</td>
							</tr>
							<tr>
								<td align="right">
									<b>Fecha Emisi&oacute;n:&nbsp;</b>
								</td>
								<td>
									<? 
										echo $fregistro;
									?>																								
								</td>	
							</tr>
							<tr>
								<td align="right" width="150">
									<b>Plazo en d&iacute;as:</b>&nbsp;
								</td>
								<td>
									<? echo plazo; ?>								
								</td>								
							</tr>							
							<tr>
								<td align="right">
									<b>Mensajero:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
										echo ucwords(mb_strtolower($nombre_apellido));
									?>								
								</td>
							</tr>
							<tr>
								<td align="right" valign="top">
									<b>Organismo Recepctor:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
										$bsqO = new Recordset();
										$bsqO->sql = "SELECT organismo.organismo 
													FROM organismo INNER JOIN crp_correspondencia_externa_det ON (organismo.id_organismo = crp_correspondencia_externa_det.id_organismo)
													WHERE crp_correspondencia_externa_det.id_correspondencia_externa = ".$id_correspondencia_externa;
										$bsqO->abrir();
										if($bsqO->total_registros > 0)
											{	
												for($R=1;$R<=$bsqO->total_registros;$R++)
												{
													$bsqO->siguiente();
													if($organismo1==""){
														$organismo1 = "- ".$bsqO->fila["organismo"];	
													} else {
														$organismo1 = $organismo1."<br>- ".$bsqO->fila["organismo"];											
													}
													
												}
											}
											$bsqO->cerrar();
											unset($bsqO);										
											
										echo ucwords(mb_strtolower($organismo1));
									?>								
								</td>
							</tr>																				
						</table>
						</fieldset>
<? 
					}
?>						
						<br />						
						<fieldset style="width:97%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Detalle Correspondencia Procesada</legend>							
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
									<b>Fecha Recepci&oacute;n:&nbsp;</b>
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
									<b>Organ&iacute;smo Emisor:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
										echo ucwords(mb_strtolower($organismo));
									?>								
								</td>
							</tr>
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
								<td align="right" valign="top" width="120">
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
						<br />
						<fieldset style="width:97%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Detalle Asignaci&oacute;n</legend>		
						<table cellspacing="3" cellpadding="2" border="0" width="100%">
							<tr>
								<td align="right" width="150">
									<b>Fecha Asignaci&oacute;n:</b>&nbsp;
								</td>
								<td>
									<? 
										echo $f_asignacion;
									?>								
								</td>											
							</tr>
							<tr>
								<td align="right" width="190">
									<b>Unidad Responsable:</b>
								</td>
								<td>
							<?
								$bus2 = new Recordset();
								$bus2->sql = "SELECT unidad.unidad FROM crp_asignacion_correspondencia INNER JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad)
												WHERE crp_asignacion_correspondencia.id_asignacion_correspondencia=".$id_asignacion_correspondencia;
								$bus2->abrir();
								if($bus2->total_registros != 0)
								{
									$bus2->siguiente();
									echo "<span class='mensaje'><u>".$bus2->fila["unidad"]."</u></span>";																		
								}															
							?>	
								</td>
							</tr>									
							<tr>
								<td align="right" width="190">
									<b>Acci&oacute;n:</b>
								</td>
								<td>
									Correspondencia para <? echo "<u>".$accion."</u> y ".$externo;?> 

								</td>
							</tr>
							<?
								if($prioridad!="" || is_null(prioridad)==true){
							?>
							<tr>
								<td align="right" width="190">
									<b>Prioridad:</b>
								</td>
								<td>
									<? echo "<b><u>".$prioridad."</u></b>"; if ($plazo!="") {echo " Con un Plazo de ".$plazo." d&iacute;as."; }?> 
								</td>
							</tr>
							<? } ?>
							<tr>
								<td align="right" width="190">
									<b>Estatus:</b>
								</td>
								<td>
									<? echo "<span class='mensaje'><b><u>".$estatus."</u></b></span>"; ?>

								</td>
							</tr>																																								
							<?
								if($copia_unidades!="" || is_null(copia_unidades)==true){
							?> 
							<tr>
								<td align="right">
									<b>Con Copia a:</b>
								</td>
								<td>
									<?
										$Var = explode("-",$copia_unidades);
										$rsdocu = new Recordset();
										$SqL = "";
										for($r=0;$r<count($Var);$r++){
											if($SqL == ""){
												$SqL = "SELECT id_unidad, unidad, codigo FROM unidad WHERE id_unidad =".$Var[$r];
											} else if ($SqL != ""){
												$SqL = $SqL." UNION SELECT id_unidad, unidad, codigo FROM unidad WHERE id_unidad =".$Var[$r];													
											}
										}
										$rsdocu->sql = $SqL;
										$rsdocu->abrir();
										for($i=0;$i<$rsdocu->total_registros;$i++){
											$rsdocu->siguiente();
											echo "- ".$rsdocu->fila["unidad"].".<br>";
										}												
									?>
								</td>
							</tr>
							<? 
							}
							?>
							<?
								if($unidades_apoyo!="" || is_null(unidades_apoyo)==true){
							?> 
							<tr>
								<td align="right">
									<b>Con Apoyo de:</b>
								</td>
								<td>
									<?
										$Var = explode("-",$unidades_apoyo);
										$rsdocu = new Recordset();
										$SqL = "";
										for($r=0;$r<count($Var);$r++){
											if($SqL == ""){
												$SqL = "SELECT id_unidad, unidad, codigo FROM unidad WHERE id_unidad =".$Var[$r];
											} else if ($SqL != ""){
												$SqL = $SqL." UNION SELECT id_unidad, unidad, codigo FROM unidad WHERE id_unidad =".$Var[$r];													
											}
										}
										$rsdocu->sql = $SqL;
										$rsdocu->abrir();
										for($i=0;$i<$rsdocu->total_registros;$i++){
											$rsdocu->siguiente();
											echo "- ".$rsdocu->fila["unidad"].".<br>";
										}
										$Var="";
										$rsdocu->cerrar();
										unset($rsdocu);												
									?>
								</td>
							</tr>
							<? 
							}
							?>										
							<tr>
								<td valign="top" align="right"><b>Observaci&oacute;n:</b></td>
								<td>
									<? echo $obser_asignacion; ?>
								</td>
							</tr>																				
						</table>
						</fieldset>									
						<table>
							<tr>
								<td align="center">								
									<input type="button" class="botones" onclick="window.top.closeMessage();" id="regresar" name="regresar" value="Regresar" title="Regresar" />																
								</td>
							</tr>							
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>