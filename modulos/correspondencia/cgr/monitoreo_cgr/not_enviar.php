
<?
if(!stristr($_SERVER['SCRIPT_NAME'],"not_enviar.php")){
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
require_once("../../../../librerias/Recordset.php");
require_once("../../../../librerias/bitacora.php");	
$recepcion = stripslashes($_GET["id_recepcion"]);

if ((isset($recepcion) && $recepcion !="")){	
	if(ctype_digit($recepcion)){	
		$search = new Recordset();
		$search->sql = "SELECT id_crp_asignacion_correspondencia_cgr FROM crp_asignacion_correspondencia_cgr WHERE (id_recepcion_correspondencia_cgr = '".$recepcion."')";
			$search->abrir();
			if($search->total_registros != 0)
			{
				$bus = new Recordset();
				$bus->sql = "SELECT 
  crp_recepcion_correspondencia_cgr.n_correlativo,
  IF(
    crp_recepcion_correspondencia_cgr.fecha_vencimiento IS NULL,
    '-',
    DATE_FORMAT(
      crp_recepcion_correspondencia_cgr.fecha_vencimiento,
      '%d/%m/%Y'
    )
  ) AS fvencimiento,
  DATE_FORMAT(
    crp_recepcion_correspondencia_cgr.fecha_registro,
    '%d/%m/%Y %r'
  ) AS registro,
  DATE_FORMAT(
    crp_recepcion_correspondencia_cgr.fecha_documento,
    '%d/%m/%Y'
  ) AS foficio,
  crp_recepcion_correspondencia_cgr.n_oficio_circular,
  organismo.organismo,
  tipo_documento.tipo_documento,
  crp_recepcion_correspondencia_cgr.id_tipo_documento,
  IF(
    crp_recepcion_correspondencia_cgr.n_respuesta_oficio IS NULL,
    '-',
    crp_recepcion_correspondencia_cgr.n_respuesta_oficio
  ) AS n_respuesta_oficio,
  crp_recepcion_correspondencia_cgr.observacion,
  crp_recepcion_correspondencia_cgr.anexos,
  DATE_FORMAT(
    crp_asignacion_correspondencia_cgr.fecha_asignacion,
    '%d/%m/%Y %r'
  ) AS f_asignacion,
  IF(crp_recepcion_correspondencia_cgr.plazo IS NULL,'-',CONCAT(crp_recepcion_correspondencia_cgr.plazo,' D&iacute;as')) AS plazo,
  estatus.estatus,
  orga.organismo AS orga_notificacion,
  crp_recepcion_cgr_detalle.n_notificacion,
  crp_recepcion_cgr_detalle.nombre,
  crp_recepcion_cgr_detalle.direccion,
  crp_recepcion_cgr_detalle.telefono,
  crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr, crp_recepcion_cgr_detalle.id_recepcion_cgr_detalle 
FROM
  crp_recepcion_correspondencia_cgr 
  INNER JOIN crp_recepcion_cgr_detalle 
    ON (
      crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr` = crp_recepcion_cgr_detalle.`id_recepcion_correspondencia_cgr`
    ) 
  INNER JOIN organismo 
    ON (
      crp_recepcion_correspondencia_cgr.id_organismo_cgr = organismo.id_organismo
    ) 
  INNER JOIN tipo_documento 
    ON (
      crp_recepcion_correspondencia_cgr.id_tipo_documento = tipo_documento.id_tipo_documento
    ) 
  INNER JOIN crp_asignacion_correspondencia_cgr 
    ON (
      crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr
    ) 
  INNER JOIN estatus 
    ON (
      crp_asignacion_correspondencia_cgr.id_estatus = estatus.id_estatus
    ) 
  LEFT JOIN organismo AS orga 
    ON (
      crp_recepcion_cgr_detalle.id_organismo = orga.id_organismo
    )
								WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$recepcion."'";
				$bus->abrir();
				if($bus->total_registros != 0)
				{
					$bus->siguiente();
					$n_correlativo = $bus->fila["n_correlativo"];
					$fdocumento = $bus->fila["foficio"];
					$fvencimiento = $bus->fila["fvencimiento"];					
					$registro = $bus->fila["registro"];	
					$organismo = $bus->fila["organismo"];																		
					$n_documento = $bus->fila["n_oficio_circular"];	
					$id_tipo_documento = $bus->fila["id_tipo_documento"];					
					$n_correlativo_padre = $bus->fila["n_correlativo_padre"];						
					$tipo_documento= $bus->fila["tipo_documento"];
					$tipo_respuesta = $bus->fila["tipo_respuesta"];											
					$nombre = $bus->fila["nombre"];
					$direccion = $bus->fila["direccion"];						
					$telefono = $bus->fila["telefono"];						
					$fecha_gaceta = $bus->fila["fecha_gaceta"];
					$observacion = $bus->fila["observacion"];				
					$anexos = $bus->fila["anexos"];	
					$f_asignacion = $bus->fila["f_asignacion"];																
					$accion = $bus->fila["accion"];																
					$n_notificacion = $bus->fila["n_notificacion"];	
					$prioridad = $bus->fila["prioridad"];
					$plazo = $bus->fila["plazo"];	
					$observacion = $bus->fila["observacion"];	
					$orga_notificacion = $bus->fila["orga_notificacion"];																
					$unidades_apoyo = $bus->fila["unidades_apoyo"];
					$estatus = $bus->fila["estatus"];																			
					$tipo_documento = $bus->fila["tipo_documento"];
					$id_recepcion_correspodencia_cgr = $bus->fila["id_recepcion_correspondencia_cgr"];	
					$id_detalle = $bus->fila["id_recepcion_cgr_detalle"];						

					//$ = $bus->fila[""];											
				}
			}
	}
}

?>
<table width="100%" height="100%" cellpadding="1" cellspacing="0">
	<tr>
		<td align="center">
			<table width="99%" align="center" cellpadding="2" cellspacing="0">
				<?
				$decisi = stripslashes($_GET["ac"]);
				if ($decisi=="env"){
					echo '<tr>
							<td width="30px"><img src="images/enviado.png"/></td>
							<td class="titulomenu" valign="middle">Registrar Envio Notificaci&oacute;n</td>
						  </tr>';
				} elseif ($decisi=="ent"){
					echo '<tr>
							<td width="30px"><img src="images/recepcion.png"/></td>
							<td class="titulomenu" valign="middle">Registrar Entrega Notificaci&oacute;n</td>
						  </tr>';
				}
				?>
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
									<b>Fecha Oficio/Circular:</b>&nbsp;
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
									<b>Tipo Comunicaci&oacute;n:</b>&nbsp;
								</td>
								<td>
									<? 
										echo $tipo_documento;
									?>								
								</td>
								<td align="right" width="150">
									<b>N&deg; Oficio/Circular:</b>&nbsp;
								</td>
								<td>
									<? 
										if ($n_documento!=""){echo $n_documento;} else {echo "<u>Sin N&uacute;mero</u>";}
									?>								
								</td>								
							</tr>							
							<tr>
								<td align="right">
									<b>Direcci&oacute;n Remitente:</b>&nbsp;
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
									<legend class="titulomenu">Detalle Asignaci&oacute;n</legend>		
									<table cellspacing="3" cellpadding="2" border="0" width="100%" >
										<? 
											switch($id_tipo_documento)
											{
												case 8: // notificacion
													if(is_null($orga_notificacion)!=true)
													{
														echo '<tr>
																<td align="right" width="150"><b>Notificaci&oacute;n a:</b>&nbsp;</td>		
																<td><b>Organismo</b>&nbsp;</td>																		
															  </tr>
															  <tr>	
																<td align="right" width="150"><b>N&deg; Notificaci&oacute;n:</b>&nbsp;</td>

																<td>'.$n_notificacion.'</td>											
															  </tr>
															  <tr>	
																<td align="right" width="150"><b>Organismo:</b>&nbsp;</td>
																<td>'.$orga_notificacion.'</td>											
															  </tr>
															  <tr>
																<td align="right" width="150"><b>Fecha Asignaci&oacute;n:</b>&nbsp;</td>
																<td>'.$f_asignacion.'</td>
															  </tr>															  	
															  <tr>	
																<td align="right" width="150"><b>Plazo:</b>&nbsp;</td>
																<td>'.$plazo.' d&iacute;as</td>											
															  </tr>
															  <tr>
																<td align="right" width="150"><b>Fecha Vencimiento:</b>&nbsp;</td>
																<td>'.$fvencimiento.'</td>
															  </tr>															  																  														  
															  ';													
													} else {
														echo '<tr>
																<td align="right" width="140" ><b>Notificaci&oacute;n a:</b>&nbsp;</td>
																<td><b>Ciudadano</b>&nbsp;</td>		
																<td align="right" ><b>N&deg; Notificaci&oacute;n:</b>&nbsp;</td>
																<td>'.$n_notificacion.'</td>
															  </tr>
															  <tr>	
																<td align="right" ><b>Nombre:</b>&nbsp;</td>
																<td width="200">'.$nombre.'</td>
																<td align="right" ><b>Tel&eacute;fono:</b>&nbsp;</td>
																<td>'.$telefono.'</td>																											
															  </tr>
															  <tr>
																<td align="right" ><b>Direcci&oacute;n:</b>&nbsp;</td>
																<td colspan="3">'.$direccion.'</td>
															  </tr>
															  <tr>	
																<td align="right" ><b>Fecha Vencimiento:</b>&nbsp;</td>
																<td>'.$fvencimiento.'</td>
																<td align="right" ><b>Plazo:</b>&nbsp;</td>
																<td>'.$plazo.'</td>											
															  </tr>
															  ';													
													}
												break;
											}
										
										?>
										<tr>
											<td align="right">
												<b>Estatus:&nbsp;</b>
											</td>
											<td>
												<? echo "<b><u><span class='mensaje'>".$estatus."</span></u></b>"; ?>
	
											</td>
										</tr>																																								
									</table>
									</fieldset>									
								</td>
							</tr>
							<tr>
								<td align="center">
									<fieldset style="width:97%; border-color:#EFEFEF"> 
									<legend class="titulomenu">Informaci&oacute;n Adicional</legend>																
									<table border="0" cellpadding="2" ccellspacing="0" width="99%">
									<?	if($anexos!=""){ ?>
										<tr>
											<td align="right" width="120" valign="top">
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
											<td align="right" width="120" valign="top">
												<b>Observaci&oacute;n:</b>
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
							<?								
									$decisi = stripslashes($_GET["ac"]);
									if ($decisi=="env"){
							?>
									<fieldset style="width:97%; border-color:#EFEFEF"> 
									<legend class="titulomenu">Informaci&oacute;n Envio</legend>									
									<table cellspacing="3" cellpadding="2" border="0" width="90%">
										<tr>
											<td align="right" valign="top" width="130">
												<b>Fecha Envio:</b>&nbsp;
											</td>
											<td>
												<input type="text" name="fentrega" id="fentrega" style="width:70px" onkeyup="this.value=formateafecha(this.value,'2017','2014');" />&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span>
											</td>
										</tr>
<!--										<tr>
											<td align="right" valign="top">
												<b>Hora Envio:</b>&nbsp;
											</td>
											<td>
												H&nbsp;<select name="hentrega" id="hentrega">
													<option></option>
													<option value="00">00</option>										
													<option value="01">01</option>										
													<option value="02">02</option>																														
													<option value="03">03</option>										
													<option value="04">04</option>										
													<option value="05">05</option>																														
													<option value="06">06</option>										
													<option value="07">07</option>										
													<option value="08">08</option>																														
													<option value="09">09</option>										
													<option value="10">10</option>										
													<option value="11">11</option>																														
													<option value="12">12</option>										
													<option value="13">01</option>										
													<option value="14">02</option>	
													<option value="15">03</option>										
													<option value="16">04</option>																														
													<option value="17">05</option>										
													<option value="18">06</option>										
													<option value="19">19</option>																														
													<option value="20">20</option>										
													<option value="21">21</option>										
													<option value="22">22</option>																																							
													<option value="23">23</option>																																																	
												</select>
												&nbsp;
												M&nbsp;<select name="mentrega" id="mentrega">
													<option></option>
													<option value="00">00</option>										
													<option value="05">05</option>										
													<option value="10">10</option>										
													<option value="15">15</option>										
													<option value="20">20</option>										
													<option value="25">25</option>										
													<option value="30">30</option>																																							
													<option value="35">35</option>																																																	
													<option value="40">40</option>
													<option value="45">45</option>																																																											
													<option value="50">50</option>																																																											
													<option value="55">55</option>																																																	
												</select>&nbsp;<span class="mensaje">*</span>									
											</td>
										</tr>-->
										<tr><td align="right" colspan="2" class="mensaje">* Campos Obligatorios&nbsp;&nbsp;</td></tr>																																		
									</table>
									</fieldset>
							<?								
									} elseif ($decisi=="ent"){
							?>	
									<fieldset style="width:97%; border-color:#EFEFEF"> 
									<legend class="titulomenu">Informaci&oacute;n Entrega</legend>									
									<table cellspacing="3" cellpadding="2" border="0" width="90%">
										<tr>
											<td align="right" valign="top" width="130">
												<b>Fecha Entrega:</b>&nbsp;
											</td>
											<td>
												<input type="text" name="fentrega" id="fentrega" style="width:70px" onkeyup="this.value=formateafecha(this.value,'2017','2014');" />&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span>
											</td>
										</tr>
<!--										<tr>
											<td align="right" valign="top">
												<b>Hora Entrega:</b>&nbsp;
											</td>
											<td>
												H&nbsp;<select name="hentrega" id="hentrega">
													<option></option>
													<option value="00">00</option>										
													<option value="01">01</option>										
													<option value="02">02</option>																														
													<option value="03">03</option>										
													<option value="04">04</option>										
													<option value="05">05</option>																														
													<option value="06">06</option>										
													<option value="07">07</option>										
													<option value="08">08</option>																														
													<option value="09">09</option>										
													<option value="10">10</option>										
													<option value="11">11</option>																														
													<option value="12">12</option>										
													<option value="13">01</option>										
													<option value="14">02</option>	
													<option value="15">03</option>										
													<option value="16">04</option>																														
													<option value="17">05</option>										
													<option value="18">06</option>										
													<option value="19">19</option>																														
													<option value="20">20</option>										
													<option value="21">21</option>										
													<option value="22">22</option>																																							
													<option value="23">23</option>																																																
												</select>
												&nbsp;
												M&nbsp;<select name="mentrega" id="mentrega">
													<option></option>
													<option value="00">00</option>										
													<option value="05">05</option>										
													<option value="10">10</option>										
													<option value="15">15</option>										
													<option value="20">20</option>										
													<option value="25">25</option>										
													<option value="30">30</option>																																							
													<option value="35">35</option>																																																	
													<option value="40">40</option>
													<option value="45">45</option>																																																											
													<option value="50">50</option>																																																											
													<option value="55">55</option>																																																	
												</select>&nbsp;<span class="mensaje">*</span>									
											</td>
										</tr>
-->										<tr><td align="right" colspan="2" class="mensaje">* Campos Obligatorios&nbsp;&nbsp;</td></tr>																																		
									</table>
									</fieldset>						
							<?								
									}
							?>															
								</td>
							</tr>														
							<tr>
								<td align="center">								
									<?
										$decisi = stripslashes($_GET["ac"]);
										if ($decisi=="env"){
											echo '<input type="button" name="btnRegistrar" id="btnRegistrar" value="Registrar" title="Registrar" onclick="reg_envio(this.value);" />';
										} elseif ($decisi=="ent"){
											echo '<input type="button" name="btnRegistrar" id="btnRegistrar" value="Registrar" title="Registrar" onclick="reg_envio(\'Finalizar\');" />';
										}
									?>
																									
									<input type="hidden" name="id_recepcion_cgr" id="id_recepcion_cgr" value="<? echo $id_recepcion_correspodencia_cgr; ?>" />
									<input type="hidden" name="id_detalle" id="id_detalle" value="<? echo $id_detalle; ?>" />									
									
									&nbsp;
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