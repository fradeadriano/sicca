<?
if(!stristr($_SERVER['SCRIPT_NAME'],"ver.php")){
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
				$bus1 = new Recordset();
				$bus1->sql = "SELECT crp_correspondencia_externa.id_correspondencia_externa, crp_correspondencia_externa.n_oficio_externo, 
									DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%d/%m/%Y %r') AS registro, organismo.organismo, crp_correspondencia_externa.contenido, 
									crp_correspondencia_externa.id_documento_cgr, crp_correspondencia_externa.id_documento_cgr_desgloce, crp_correspondencia_externa.fecha_registro, 
									IF(
								  CONCAT(tipo_documento_cgr.tipo_documento_cgr, '-', documento_cgr_desgloce.documento_cgr_desgloce) IS NULL, tipo_documento_cgr.tipo_documento_cgr, CONCAT(
								   tipo_documento_cgr.tipo_documento_cgr, '-', documento_cgr_desgloce.documento_cgr_desgloce)) AS oficio, crp_correspondencia_externa.plazo, crp_correspondencia_externa.anexos 
								
								FROM
									 crp_correspondencia_externa 
									 INNER JOIN crp_correspondencia_externa_det 
									  ON (
									   crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa
									  ) 
									 INNER JOIN organismo 
									  ON (
									   crp_correspondencia_externa_det.id_organismo = organismo.id_organismo
									  ) 
									 INNER JOIN crp_ruta_correspondencia
									  ON (
									   crp_correspondencia_externa.id_recepcion_correspondencia = crp_ruta_correspondencia.id_recepcion_correspondencia
									  ) 
									 LEFT JOIN tipo_documento_cgr 
									  ON (
									   crp_correspondencia_externa.id_documento_cgr = tipo_documento_cgr.id_tipo_documento_cgr
									  ) 
									 LEFT JOIN documento_cgr_desgloce 
									  ON (
									   crp_correspondencia_externa.id_documento_cgr_desgloce = documento_cgr_desgloce.id_documento_cgr_desgloce
									  )
									WHERE crp_correspondencia_externa.id_recepcion_correspondencia = '".$recepcion."' 
									GROUP BY crp_correspondencia_externa.id_recepcion_correspondencia";
				$bus1->abrir();
				if($bus1->total_registros != 0)
				{
					$bus1->siguiente();
					$n_oficio = $bus1->fila["n_oficio_externo"];
					$fregistro = $bus1->fila["registro"];
					$plazo = $bus1->fila["plazo"];																		
					$contenido = $bus1->fila["contenido"];	
					$documen = $bus1->fila["oficio"];	
					$annexos = $bus1->fila["anexos"];	
					$id_recepcion_correspondencia = $bus1->fila["id_recepcion_correspondencia"];
					$id_correspondencia_externa = $bus1->fila["id_correspondencia_externa"];					
									
																							
//					$ = $bus->fila[""];											
				}
			
				$bus = new Recordset();
				$bus->sql = "SELECT crp_recepcion_correspondencia.n_correlativo, DATE_FORMAT(crp_recepcion_correspondencia.fecha_documento,'%d/%m/%Y') AS fdocumento, 
							DATE_FORMAT(crp_recepcion_correspondencia.fecha_registro,'%d/%m/%Y %r') AS registro, crp_recepcion_correspondencia.n_documento,
							  organismo.organismo, tipo_documento.tipo_documento, crp_recepcion_correspondencia.id_tipo_documento, crp_recepcion_correspondencia.n_correlativo_padre,
							  crp_recepcion_correspondencia.anfiscal, tipo_respuesta.tipo_respuesta, crp_recepcion_correspondencia.id_tipo_respuesta, 
							  crp_recepcion_correspondencia.gaceta_n, DATE_FORMAT(crp_recepcion_correspondencia.gaceta_fecha,'%d/%m/%Y') AS fecha_gaceta, 
							  crp_recepcion_correspondencia.gaceta_tipo, crp_recepcion_correspondencia.observacion, crp_recepcion_correspondencia.anexo,
							   DATE_FORMAT(crp_asignacion_correspondencia.fecha_asignacion,'%d/%m/%Y %r') AS f_asignacion,
							   IF(crp_asignacion_correspondencia.externo=1,'Requiere Oficio Externo.','No Requiere Oficio Externo.') AS externo,
							   crp_asignacion_correspondencia.accion, prioridad.prioridad, crp_asignacion_correspondencia.plazo,
							   crp_asignacion_correspondencia.copia_unidades, crp_asignacion_correspondencia.unidades_apoyo, estatus.estatus 
							   
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
					<td width="30px"><img src="images/entregado.png"/></td>
					<td class="titulomenu" valign="middle">Visualizar Correspondencia</td>
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
								<td align="right">
									<b>Fecha Entrega Organismo:&nbsp;</b>
								</td>
								<td>
									<? 
										$bsqO = new Recordset();
										$bsqO->sql = "SELECT 
													 DATE_FORMAT(
													  crp_ruta_correspondencia.fecha_recepcion_digital, '%d/%m/%Y %r'
													 ) AS recepcion 
													FROM
													 crp_ruta_correspondencia 
													 INNER JOIN estatus 
													  ON (
													   crp_ruta_correspondencia.id_estatus = estatus.id_estatus
													  ) 
													WHERE crp_ruta_correspondencia.id_recepcion_correspondencia = '".$recepcion."' AND crp_ruta_correspondencia.id_estatus= 6";
										$bsqO->abrir();
										if($bsqO->total_registros > 0)
											{	
												$bsqO->siguiente();
												$frecepcion = $bsqO->fila["recepcion"];	
											}
											$bsqO->cerrar();
											unset($bsqO);										
											
										echo $frecepcion;																				
									?>																								
								</td>	
							</tr>							
							<tr>
								<td align="right" width="190">
									<b>Plazo en d&iacute;as:</b>&nbsp;
								</td>
								<td>
									<? echo $plazo; ?>								
								</td>								
							</tr>							
							<tr>
								<td align="right">
									<b>Documento:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
										echo ucwords(mb_strtolower($documen));
									?>								
								</td>
							</tr>
							<tr>
								<td align="right" valign="top">
									<b>Anexos:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
										if($annexos!="") { echo ucwords(mb_strtolower($annexos)); } else { echo "Sin Anexos"; }
									?>								
								</td>
							</tr>	
							<tr>
								<td align="right" valign="top">
									<b>Contenido:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
										echo ucwords(mb_strtolower($contenido));
									?>								
								</td>
							</tr>													
							<tr>
								<td align="right" valign="top">
									<b>Organismo Recepctor:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
/*										$bsqO = new Recordset();
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
											
										echo ucwords(mb_strtolower($organismo1));*/
										echo ucwords(mb_strtolower($organismo));
										
									?>								
								</td>
							</tr>																				
						</table>
						</fieldset>
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