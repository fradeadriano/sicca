<?
if(!stristr($_SERVER['SCRIPT_NAME'],"ver_noti.php")){
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
							  crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`,
							  crp_recepcion_correspondencia_cgr.`n_correlativo`,
							  crp_recepcion_correspondencia_cgr.`n_oficio_circular`,
							  DATE_FORMAT(
								crp_recepcion_correspondencia_cgr.fecha_registro,
								'%d/%m/%Y %r'
							  ) AS registro,
							  DATE_FORMAT(
								crp_recepcion_correspondencia_cgr.fecha_documento,
								'%d/%m/%Y'
							  ) AS foficio,
							  tipo_documento.`tipo_documento`,
							  organismo.`organismo`,   crp_recepcion_correspondencia_cgr.observacion, crp_recepcion_correspondencia_cgr.anexos
							FROM
							  crp_recepcion_correspondencia_cgr 
							  INNER JOIN organismo 
								ON (
								  crp_recepcion_correspondencia_cgr.`id_organismo_cgr` = organismo.`id_organismo`
								) 
							  INNER JOIN tipo_documento 
								ON (
								  crp_recepcion_correspondencia_cgr.`id_tipo_documento` = tipo_documento.`id_tipo_documento`
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
				<tr>
					<td width="30px"><img src="images/entregado.png"/></td>
					<td class="titulomenu" valign="middle">Visualizar Correspondencia CGR Entregada</td>
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
						<br />
						<fieldset style="width:97%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Notificaciones</legend>
						<table border="0" cellpadding="3" ccellspacing="2" width="99%">
							<?	
																
							$mostr = new Recordset();
							$mostr->sql = "SELECT crp_recepcion_cgr_detalle.`id_recepcion_cgr_detalle`,crp_recepcion_cgr_detalle.`n_notificacion` AS notificacion,
												IF(crp_recepcion_cgr_detalle.`id_organismo` IS NULL,crp_recepcion_cgr_detalle.`nombre`,organismo.`organismo`) AS autor, 
												IF(crp_recepcion_cgr_detalle.`telefono` IS NOT NULL,crp_recepcion_cgr_detalle.telefono,'-') AS telefono, 
												DATE_FORMAT(crp_recepcion_cgr_detalle.fecha_envio,'%d/%m/%Y %r') AS envio, 
												IF(crp_recepcion_cgr_detalle.fecha_entrega IS NULL, '-', DATE_FORMAT(crp_recepcion_cgr_detalle.fecha_entrega,'%d/%m/%Y %r')) AS entrega,
												IF(crp_recepcion_cgr_detalle.`entregado`=1 AND crp_recepcion_cgr_detalle.`finalizado` = 'no', '-',IF(crp_recepcion_cgr_detalle.fecha_entrega IS NULL,'No Localizado','Entregado')) AS ocurrido  
											FROM crp_recepcion_cgr_detalle LEFT JOIN organismo ON (crp_recepcion_cgr_detalle.`id_organismo` = organismo.`id_organismo`) 
											WHERE crp_recepcion_cgr_detalle.`enviado` = 0 AND crp_recepcion_cgr_detalle.`id_recepcion_correspondencia_cgr` = ".$recepcion;
								$mostr->abrir();
								if($mostr->total_registros != 0)
								{							
							?>						
							<tr>
								<td colspan="2">
									<table border="0" cellpadding="3" ccellspacing="2" width="99%" class="b_table">								
										<tr class="trcabecera_list1"><td colspan="6">Notificaciones Enviadas</td></tr>
										<tr valign="middle" class="trcabecera_list1">
											<td width="110">N&deg; Notificaci&oacute;n</td>
											<td>Ciudadano/Organ&iacute;smo</td>
											<td width="100">Tel&eacute;fono</td>
											<td width="100">Fecha Envio</td>
											<td width="100">Fecha Entrega</td>
											<td width="100">Condici&oacute;n</td>											
										</tr>
							<?
									for($f=0;$f<$mostr->total_registros;$f++)
									{	
										$mostr->siguiente();							
										if($f % 2 == 0) $estilo = " class=\"trresaltado\"";
							?>										
										<tr <? echo $estilo; ?> align='center'>
											<td>
												<? echo $mostr->fila["notificacion"]; ?>
											</td>
											<td>
												<? echo $mostr->fila["autor"]; ?>
											</td>
											<td>
												<? echo $mostr->fila["telefono"]; ?>
											</td>
											<td>
												<? echo $mostr->fila["envio"]; ?>
											</td>
											<td>
												<? echo $mostr->fila["entrega"]; ?>
											</td>
											<td>
												<? 
													
												echo $mostr->fila["ocurrido"]; 
												?>
											</td>											
										</tr>
								<?
										$estilo = "";										
									}
							?>
									</table>
								</td>
							</tr>							
							<? 
								}
							?>
							<tr>
								<td align="center" width="132" colspan="2">																
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
								</td>
							</tr>							
						</table>
						</fieldset>
						<table border="0" cellpadding="3" ccellspacing="2" width="99%">														
							<tr>
								<td align="center">																																
									<input type="hidden" name="id_recepcion_cgr" id="id_recepcion_cgr" value="<? echo $id_recepcion_correspodencia_cgr; ?>" />
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