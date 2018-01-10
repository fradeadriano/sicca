<title>CGR - Seguimiento Correspondencia</title>
<?
require_once("../../../../librerias/Recordset.php");
$z = stripslashes($_POST["condiciones"]);
//$conjunto = stripslashes($_GET["condiciones"])
$rslista = new Recordset();
if(isset($z) && $z!="")
	{
		$mYId = "?id=".$z;
			
		$bus = new Recordset();
		$bus->sql = "SELECT crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`, crp_recepcion_correspondencia_cgr.`n_correlativo`, 
							DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_documento,'%d/%m/%Y') AS f_documento, 
							DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_registro,'%d/%m/%Y') AS f_registro, 
							crp_recepcion_correspondencia_cgr.`n_oficio_circular`, organismo.`organismo`, tipo_documento.`tipo_documento`,
							crp_recepcion_correspondencia_cgr.`observacion`, 
							IF (crp_recepcion_correspondencia_cgr.anexos IS NULL ,'-',crp_recepcion_correspondencia_cgr.anexos) AS anexos, 
							DATE_FORMAT(crp_asignacion_correspondencia_cgr.fecha_asignacion,'%d/%m/%Y') AS f_asignacion, 
							unidad.`unidad`, crp_recepcion_correspondencia_cgr.plazo, crp_recepcion_correspondencia_cgr.id_tipo_documento, estatus.estatus
							
							FROM crp_recepcion_correspondencia_cgr 
							INNER JOIN crp_asignacion_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr` = crp_asignacion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)
							INNER JOIN organismo ON (crp_recepcion_correspondencia_cgr.`id_organismo_cgr` = organismo.`id_organismo`)
							INNER JOIN tipo_documento ON (crp_recepcion_correspondencia_cgr.`id_tipo_documento` = tipo_documento.`id_tipo_documento`)
							INNER JOIN unidad ON (crp_asignacion_correspondencia_cgr.`id_unidad` = unidad.`id_unidad`)
							INNER JOIN estatus ON (crp_asignacion_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
					WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$z."'";
		$bus->abrir();
		if($bus->total_registros != 0)
		{
			$bus->siguiente();
			$n_correlativo = $bus->fila["n_correlativo"];
			$fdocumento = $bus->fila["f_documento"];
			$registro = $bus->fila["f_registro"];	
			$organismo = $bus->fila["organismo"];																		
			$n_documento = $bus->fila["n_oficio_circular"];	
			$id_tipo_documento = $bus->fila["id_tipo_documento"];
					
			$tipo_documento= $bus->fila["tipo_documento"];
			$observacion = $bus->fila["observacion"];				
			$anexos = $bus->fila["anexos"];	
			$f_asignacion = $bus->fila["f_asignacion"];																
			$plazo = $bus->fila["plazo"];
			$estatus = $bus->fila["estatus"];	
			$unidad = $bus->fila["unidad"];						
			
																					
//					$ = $bus->fila[""];											
		}
	}
?>
<link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
<table width="80%" class="b_table" align="center" border="0">
	<tr>
		<td align="center">
			<table width="90%" border="0" align="center" >
				<tr>
				  <td valign="middle" align="center" width="360"><img src="../../../../images/logo_reporte.jpg" width="160"></td>
					<td align="center" valign="middle">
					  <div class="titulomenu" style="font-size:18px">Contraloria del estado Aragua</div>
					  <div style="font-size:12px">
					  <br />
							<b>Despacho del Contralor</b>
					  </div>
					</td>
					<td width="100"></td>
				</tr>
				<tr>
					<td colspan="3" align="center" height="40">
						<div class="titulomenu" style="font-size:18px">Seguimiento Correspondencia de la CGR</div>					
					</td>
				</tr>					
				<tr>
					<td colspan="3" align="left">
						<div class="titulomenu" style="font-size:9px">Criterio B&uacute;squeda: Correspondencia n&ordm; <? echo $n_correlativo; ?></div>					
					</td>
				</tr>
				<tr>
				  <td colspan="3"><hr /></td>
				</tr>		
			</table>		
		</td>
	</tr>
	<tr>
		<td align="center"><div class="titulomenu" style="font-size:12px">Ficha de la Correspondencia</div></td>
	</tr>
	<tr>
		<td align="center">
			<table class="b_table_w" width="75%"><tr><td>
			
			<table border="0" cellpadding="3" cellspacing="2" width="100%" align="center">
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
						<b>Organ&iacute;smo:</b>&nbsp;
					</td>
					<td colspan="3">
						<? 
							echo ucwords(mb_strtolower($organismo));
						?>								
					</td>
				</tr>													
			</table>
			<table border="0" cellpadding="3" ccellspacing="2" align="center" width="95%">
				<tr>
					<td align="center">
						<fieldset style="width:97%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Detalle Correspondencia</legend>																
						<table border="0" cellpadding="2" ccellspacing="0" width="99%" class="b_table">
<?						if($id_tipo_documento==7) // oficio
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
							} else if($id_tipo_documento==8){ //gaceta   

								$mn = new Recordset();
								$mn->sql = "SELECT crp_recepcion_cgr_detalle.`id_recepcion_cgr_detalle`,crp_recepcion_cgr_detalle.`n_notificacion` AS notificacion,IF(crp_recepcion_cgr_detalle.`id_organismo` IS NULL,crp_recepcion_cgr_detalle.`nombre`,organismo.`organismo`) AS autor, IF(crp_recepcion_cgr_detalle.`telefono` IS NOT NULL,crp_recepcion_cgr_detalle.telefono,'-') AS telefono, DATE_FORMAT(crp_recepcion_cgr_detalle.fecha_envio,'%d/%m/%Y %r') AS envio, IF(crp_recepcion_cgr_detalle.fecha_entrega IS NULL, '-', DATE_FORMAT(crp_recepcion_cgr_detalle.fecha_entrega,'%d/%m/%Y %r')) AS entrega  
											FROM crp_recepcion_cgr_detalle LEFT JOIN organismo ON (crp_recepcion_cgr_detalle.`id_organismo` = organismo.`id_organismo`) 
											WHERE crp_recepcion_cgr_detalle.`enviado` = 0 AND crp_recepcion_cgr_detalle.`id_recepcion_correspondencia_cgr` = ".$z;
								$mn->abrir();
								if($mn->total_registros != 0)
								{
									echo "<tr>
									<td align=\"right\" width=\"120\">
										<b>Tipo Documento:</b>
									</td>
									<td colspan=\4\>".$tipo_documento."</td>											
								</tr>
									<tr valign=\"middle\" class=\"trcabecera_list1\"><td width=\"120\">Notificaci&oacute;n</td><td>Ciudadano/Organ&iacute;smo</td><td width=\"100\">Tel&eacute;fono</td><td width=\"150\">Fecha Envio</td><td width=\"150\">Fecha Entrega</td></tr>";
									for($f=0;$f<$mn->total_registros;$f++)
									{	
										$mn->siguiente();							
										if($f % 2 == 0) $estilo = " class=\"trresaltado\"";
										echo "<tr $estilo align='center'><td>".$mn->fila["notificacion"]."</td><td>".$mn->fila["autor"]."</td><td>".$mn->fila["telefono"]."</td><td>".$mn->fila["envio"]."</td><td>".$mn->fila["entrega"]."</td></tr>";
										$estilo = "";
									}
								}

							} else if($id_tipo_documento==9){ //invitaciones  
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
							} else if($id_tipo_documento==10){ //donaciones  
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
							} else if($id_tipo_documento==13){ //denuncia  
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
							echo "<tr><td height=\"15\"></td></tr>";						
							if($anexos!="-"){
						?>
							<tr>
								<td align="right" width="120" valign="top">
									<b>Anexos:</b>
								</td>
								<td colspan="4">
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
								<td colspan="4">
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
						<fieldset style="width:100%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Detalle Asignaci&oacute;n</legend>		
						<table cellspacing="3" cellpadding="2" border="0" width="100%">
							<tr>
								<td align="right" width="140">
									<b>Fecha Asignaci&oacute;n:</b>&nbsp;
								</td>
								<td>
									<? 
										echo $f_asignacion;
									?>								
								</td>											
							</tr>									
							<tr>
								<td align="right" width="140">
									<b>Asignado a:</b>&nbsp;
								</td>
								<td>
									<? 
										echo "<span class='mensaje'><u>".$unidad."</u></span>";
									?>								
								</td>											
							</tr>									

							<tr>
								<td align="right" width="140">
									<b>Estatus:</b>
								</td>
								<td>
									<? echo "<span class='mensaje'><b><u>".$estatus."</u></b></script>"; ?>

								</td>
							</tr>																																																												
						</table>
						</fieldset>									
					</td>
				</tr>
			</table>
			
			</td></tr></table>		
		</td>
	</tr>
	<tr>
		<td height="20"></td>
	</tr>
	<tr>
		<td align="center">
			<div class="titulomenu" style="font-size:12px">Gr&aacute;fico</div><br />
			<img src="grafico.php<? echo $mYId; ?>" />	
		</td>
	</tr>
	<tr>
		<td height="20"></td>
	</tr>	
	<tr>
		<td align="center">
			<table class="b_table" cellpadding="5" cellspacing="1">
				<tr>
					<td colspan="2" align="center">
						<span class="titulomenu" style="font-size:12px">Leyenda</span>					
					</td>
				</tr>
				<tr class="trcabecera_list2">
					<td>
						Estatus									
					</td>
					<td>
						Significado			
					</td>
				</tr>
				<tr>
					<td>
						Recibido									
					</td>
					<td>
						La correspondencia se encuentra en Despacho del Contralor
					</td>
				</tr>
				<tr style="background-color:#FAFAF1;">
					<td>
						Asignado									
					</td>
					<td>
						Correspondencia asignada pero aun no ha sido entregada a su Destino Interno
					</td>
				</tr>
				<tr>
					<td>
						En Proceso									
					</td>
					<td>
						Correspondencia se encuentra en la Unidad Asignada
					</td>
				</tr>			
				<tr>
					<td>
						Aprobada
					</td>
					<td>
						Correspondencia se encuentra en Despacho del Contralor
					</td>
				</tr>													
				<tr style="background-color:#FAFAF1;">
					<td>
						Enviado
					</td>
					<td>
						Correspondencia se envio a su Destino
					</td>
				</tr>													
				<tr>
					<td>
						Entragada
					</td>
					<td>
						Correspondencia fue Entregada Satisfactoriamente
					</td>
				</tr>										
			</table>	
		</td>
	</tr>		
	<tr>
		<td height="30"></td>
	</tr>	
	<tr id="aaa">
		<td colspan="4" height="15px" align="center">
			<input type="button" value="Imprimir" name="imprimir" id="imprimir" onclick="im('imprimir');" title="Imprimir"/>
			&nbsp;
			<input type="button" value="Cerrar" name="cerrar" id="cerrar" onclick="im('cerrar');" title="Cerrar"/>&nbsp;
		</td>
	</tr>
</table>
<script language="javascript" type="text/javascript">
// 1
function im(man) {
	if (man=="imprimir"){
		document.getElementById("aaa").style.display="none";
		window.print();
		window.setTimeout("document.getElementById('aaa').style.display=''",3000);
	} else {
		window.close();
	}
}
</script>