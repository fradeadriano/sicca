<?
require_once("../../../../librerias/Recordset.php");
$z = stripslashes($_POST["condiciones"]);
//$conjunto = stripslashes($_GET["condiciones"])
$rslista = new Recordset();
if(isset($z) && $z!="")
	{
		$mYId = "?id=".$z;
			
		$bus = new Recordset();
		$bus->sql = "SELECT crp_recepcion_correspondencia.n_correlativo, DATE_FORMAT(crp_recepcion_correspondencia.fecha_documento,'%d/%m/%Y') AS fdocumento, DATE_FORMAT(crp_recepcion_correspondencia.fecha_registro,'%d/%m/%Y %r') AS registro, crp_recepcion_correspondencia.n_documento,
					  organismo.organismo, tipo_documento.tipo_documento, crp_recepcion_correspondencia.id_tipo_documento, crp_recepcion_correspondencia.n_correlativo_padre,
					  crp_recepcion_correspondencia.anfiscal, tipo_respuesta.tipo_respuesta, crp_recepcion_correspondencia.id_tipo_respuesta, 
					  crp_recepcion_correspondencia.gaceta_n, DATE_FORMAT(crp_recepcion_correspondencia.gaceta_fecha,'%d/%m/%Y') AS fecha_gaceta, 
					  crp_recepcion_correspondencia.gaceta_tipo, crp_recepcion_correspondencia.observacion, crp_recepcion_correspondencia.anexo,
					   DATE_FORMAT(crp_asignacion_correspondencia.fecha_asignacion,'%d/%m/%Y %r') AS f_asignacion,
					   IF(crp_asignacion_correspondencia.externo=1,'Requiere Oficio Externo.','No Requiere Oficio Externo.') AS externo,
					   crp_asignacion_correspondencia.accion, prioridad.prioridad, crp_asignacion_correspondencia.plazo,
					   crp_asignacion_correspondencia.copia_unidades, crp_asignacion_correspondencia.unidades_apoyo, estatus.estatus, unidad.unidad
					FROM
					  crp_recepcion_correspondencia LEFT JOIN organismo ON (crp_recepcion_correspondencia.id_organismo = organismo.id_organismo)
					  INNER JOIN tipo_documento 
						ON (crp_recepcion_correspondencia.id_tipo_documento = tipo_documento.id_tipo_documento) 
						LEFT JOIN tipo_respuesta ON (crp_recepcion_correspondencia.id_tipo_respuesta = tipo_respuesta.id_tipo_respuesta)
						INNER JOIN crp_asignacion_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_asignacion_correspondencia.id_recepcion_correspondencia)							  
						LEFT JOIN prioridad ON (crp_asignacion_correspondencia.id_prioridad = prioridad.id_prioridad)
						INNER JOIN estatus ON (crp_asignacion_correspondencia.id_estatus = estatus.id_estatus)
						left JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad)
					WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$z."'";
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
			$unidad = $bus->fila["unidad"];						
			
																					
//					$ = $bus->fila[""];											
		}
	}
/*setlocale(LC_TIME, 'spanish');
print "<strong style='color: blue;'>".strftime("&nbsp;  %F %#d de %B del %Y").""; 

$script_tz = date_default_timezone_get();

if (strcmp($script_tz, ini_get('date.timezone'))){
    echo 'La zona horaria del script difiere de la zona horaria de la configuracion ini.';
} else {
    echo 'La zona horaria del script y la zona horaria de la configuración ini coinciden.';
}	
	echo date("d-%B-Y");*/
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
						<div class="titulomenu" style="font-size:18px">Seguimiento Correspondencia</div>					
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
			<table border="0" cellpadding="3" ccellspacing="2" align="center" width="95%">
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
								<td align="right" width="140">
									<b>Prioridad:</b>
								</td>
								<td>
									<? echo "<b><u>".$prioridad."</u></b>"; if ($plazo!="") {echo " Con un Plazo de ".$plazo." d&iacute;as."; }?> 
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
							<?
							}
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
									<? echo $observacion; ?>
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
				<tr style="background-color:#FAFAF1;">
					<td>
						En Revisi&oacute;n									
					</td>
					<td>
						Correspondencia se encuentra en Direcci&oacute;n General
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