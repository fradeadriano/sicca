<?
if(!stristr($_SERVER['SCRIPT_NAME'],"recibir.php")){
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
		$search->sql = "SELECT id_crp_asignacion_correspondencia_cgr  FROM crp_asignacion_correspondencia_cgr WHERE (id_recepcion_correspondencia_cgr = '".$recepcion."')";
			$search->abrir();
			if($search->total_registros != 0)
			{
				$bus = new Recordset();
				$bus->sql = "SELECT 
								  crp_recepcion_correspondencia_cgr.n_correlativo,
								  IF(crp_recepcion_correspondencia_cgr.fecha_vencimiento IS NULL,'-',DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_vencimiento,'%d/%m/%Y')) AS fvencimiento,
								  DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_registro,'%d/%m/%Y %r') AS registro,
								  DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_documento,'%d/%m/%Y') AS foficio,
								  crp_recepcion_correspondencia_cgr.n_oficio_circular,
								  organismo.organismo, tipo_documento.tipo_documento,
								  crp_recepcion_correspondencia_cgr.id_tipo_documento,
								  IF(crp_recepcion_correspondencia_cgr.n_respuesta_oficio IS NULL,'-',crp_recepcion_correspondencia_cgr.n_respuesta_oficio) AS n_respuesta_oficio,
								  crp_recepcion_correspondencia_cgr.observacion,
								  crp_recepcion_correspondencia_cgr.anexos,
								  DATE_FORMAT(crp_asignacion_correspondencia_cgr.fecha_asignacion,'%d/%m/%Y %r') AS f_asignacion,
								  IF(crp_recepcion_correspondencia_cgr.plazo IS NULL,'-',crp_recepcion_correspondencia_cgr.plazo) AS plazo,
								  estatus.estatus,
								  organismo.organismo AS orga_notificacion,
								  crp_asignacion_correspondencia_cgr.id_estatus, 
								  crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr, if(crp_asignacion_correspondencia_cgr.habilitado=0,'no','si') as habilitado
								FROM
								  crp_recepcion_correspondencia_cgr 
								  INNER JOIN organismo ON (crp_recepcion_correspondencia_cgr.`id_organismo_cgr`= organismo.`id_organismo`)
								  INNER JOIN tipo_documento ON (crp_recepcion_correspondencia_cgr.id_tipo_documento = tipo_documento.id_tipo_documento) 
								  INNER JOIN crp_asignacion_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr) 
								  INNER JOIN estatus ON (crp_asignacion_correspondencia_cgr.id_estatus = estatus.id_estatus)
							WHERE crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$recepcion."'";
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
					$SiHabilitado = $bus->fila["habilitado"];																							
//					$ = $bus->fila[""];											
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
					<td width="30px"><? if($SiHabilitado=="no"){ echo '<img src="images/no_habilitado.png"/>'; } else if ($SiHabilitado=="si") { echo '<img src="images/recepcion.png"/>'; } ?></td>
					<td class="titulomenu" valign="middle">Certificar Recepci&oacute;n Correspondencia</td>
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
						<table border="0" cellpadding="3" ccellspacing="2" width="99%">
							<tr>
								<td align="center">
									<fieldset style="width:97%; border-color:#EFEFEF"> 
									<legend class="titulomenu">Informaci&oacute;n Adicional</legend>																
									<table border="0" cellpadding="2" ccellspacing="0" width="99%">
										<tr>
											<td align="right">
												<b>Estatus:&nbsp;</b>
											</td>
											<td>
												<? echo "<b><u><span class='mensaje'>".$estatus."</span></u></b>"; ?>
	
											</td>
										</tr>																																								

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
						</table>
						<table border="0" cellpadding="3" ccellspacing="2" width="99%">
							<? if($SiHabilitado=="si"){ ?>
							<tr>
								<td align="left" class="mensaje">
									<u>Nota:</u><br />
									<p align="justify">
										Desde este formulario usted registrar&aacute; las correspondencias para su aprobaci&oacute;n, no haga clic en el bot&oacute;n recibir si no tiene el documento.
									</p>
								</td>
							</tr>							
							<tr>
								<td align="center">
									<input type="hidden" name="id_recep" id="id_recep" value="<? echo $recepcion; ?>" />
									<input type="hidden" name="id_unidad" id="id_unidad" value="<? echo $UunidadD; ?>" />									
									<input type="button" name="btnRegistrar" id="btnRegistrar" value="Recibir" title="Recibir" onclick="recibir();" />
									&nbsp;&nbsp;
									<input type="button" class="botones" onclick="window.top.closeMessage();" id="regresar" name="regresar" value="Regresar" title="Regresar" />																
								</td>
							</tr>				
							<? } else {?>			
							<tr>
								<td align="left" class="mensaje">
									<u>Nota:</u><br />
									<p align="justify">
										Esta correspondencia no se encuentra habilitada para ser recibida, por favor indique al representante de la gerencia que la correspondencia debe ser habilitada antes de proceder con este paso
									</p>
								</td>
							</tr>							
							<tr>
								<td align="center">
									<input type="hidden" name="id_recep" id="id_recep" value="<? echo $recepcion; ?>" />
									<input type="hidden" name="id_unidad" id="id_unidad" value="<? echo $UunidadD; ?>" />									
									<input type="button" class="botones" onclick="window.top.closeMessage();" id="regresar" name="regresar" value="Regresar" title="Regresar" />																
								</td>
							</tr>					
							<? } ?>														
						</table>
					</td>
				</tr>
			</table>
		</form>
		</td>
	</tr>
</table>