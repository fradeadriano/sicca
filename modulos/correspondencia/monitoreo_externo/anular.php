<?
if(!stristr($_SERVER['SCRIPT_NAME'],"anular.php")){
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
		$search->sql = "SELECT id_correspondencia_externa  FROM crp_correspondencia_externa WHERE (id_correspondencia_externa = '".$recepcion."')";
			$search->abrir();
			if($search->total_registros != 0)
			{
				$bus = new Recordset();
				$bus->sql = "SELECT crp_correspondencia_externa.id_correspondencia_externa, crp_correspondencia_externa.n_oficio_externo, DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%d/%m/%Y %r') AS registro, IF (organismo.organismo IS NULL,crp_correspondencia_externa.destinatario,organismo.organismo) AS organismo, crp_correspondencia_externa.contenido, crp_correspondencia_externa.id_documento_cgr, 
									crp_correspondencia_externa.id_documento_cgr_desgloce, crp_correspondencia_externa.fecha_registro, IF(CONCAT(tipo_documento_cgr.tipo_documento_cgr, '-', documento_cgr_desgloce.documento_cgr_desgloce) IS NULL, tipo_documento_cgr.tipo_documento_cgr, CONCAT(
								   tipo_documento_cgr.tipo_documento_cgr, '-', documento_cgr_desgloce.documento_cgr_desgloce)) AS oficio, crp_correspondencia_externa.plazo 
								FROM crp_correspondencia_externa LEFT JOIN crp_correspondencia_externa_det ON (crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa) 
								 LEFT JOIN organismo 
								  ON (crp_correspondencia_externa_det.id_organismo = organismo.id_organismo) 
								 INNER JOIN crp_ruta_correspondencia_ext 
								  ON (crp_correspondencia_externa.id_correspondencia_externa = crp_ruta_correspondencia_ext.id_correspondencia_externa) 
								 INNER JOIN tipo_documento_cgr ON (crp_correspondencia_externa.id_documento_cgr = tipo_documento_cgr.id_tipo_documento_cgr								  ) 
								 LEFT JOIN documento_cgr_desgloce 
								  ON (crp_correspondencia_externa.id_documento_cgr_desgloce = documento_cgr_desgloce.id_documento_cgr_desgloce) 
								WHERE crp_correspondencia_externa.id_correspondencia_externa = '".$recepcion."' GROUP BY crp_correspondencia_externa.n_oficio_externo";
				$bus->abrir();
			
				if($bus->total_registros != 0)
				{
					$bus->siguiente();
					$n_correlativo = $bus->fila["n_oficio_externo"];
					//$fregistro = $bus->fila["fregistro"];
					$remitente = $bus->fila["organismo"];
					$registro = $bus->fila["registro"];	
					$plazo = $bus->fila["plazo"];																		
					//$nombre_apellido = $bus->fila["nombre_apellido"];	
					//$id_recepcion_correspondencia = $bus->fila["id_recepcion_correspondencia"];
					$id_correspondencia_externa = $bus->fila["id_correspondencia_externa"];					
																							
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
					<td width="30px"><img src="images/no_habilitado.png"/></td>
					<td class="titulomenu" valign="middle">Anular Oficio</td>
				</tr>
				<tr>
					<td colspan="2" valign="top"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td align="center" valign="top">
		<form action="" name="FormEnt" id="FormEnt" method="post">
			<table border="0" align="center" class="b_table" width="100%" height="230" bgcolor="#FFFFFF">			
				<tr valign="top">
					<td align="center">
						<table border="0" cellpadding="3" ccellspacing="2" width="99%">
							<tr align="center" style="display:none" >
								<td colspan="3" align="center" height="0" id="divi">                                 
								</td>
							</tr>							
							<tr>
								<td align="right" width="150">
									<b>N&deg; Oficio Externo:</b>&nbsp;
								</td>
								<td>
									<? 
										echo "<span class='mensaje'>".$n_correlativo."</span>";
									?>								
								</td>
							</tr>
							<tr>
								<td align="right">
									<b>Fecha Envio:&nbsp;</b>
								</td>
								<td>
									<? 
										echo $registro;
									?>																								
								</td>	
							</tr>
							<tr>
								<td align="right" width="150">
									<b>Plazo en d&iacute;as:</b>&nbsp;
								</td>
								<td>
									<? echo $plazo; ?>								
								</td>								
							</tr>							
<!--							<tr>
								<td align="right">
									<b>Mensajero:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
										//echo ucwords(mb_strtolower($nombre_apellido));
									?>								
								</td>
							</tr>-->
							<tr>
								<td align="right" valign="top">
									<b>Organismo:</b>&nbsp;
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
													if($organismo==""){
														$organismo = "- ".$bsqO->fila["organismo"];	
													} else {
														$organismo = $organismo."<br>- ".$bsqO->fila["organismo"];											
													}
													
												}
											} else {
												echo $remitente;
											}
											$bsqO->cerrar();
											unset($bsqO);										
											
										echo ucwords(mb_strtolower($organismo));
									?>								
								</td>
							</tr>
						</table>
						<table border="0" width="88%">
							<tr><td height="10"></td></tr>							
							<tr>
								<td align="left" class="mensaje">
									<p align="justify" style="width:100%; text-align:left">
										<u>Nota:</u><br />
										Desde este formulario usted Anular&aacute; los oficios que han sido generados, asegurese de haber seleccionado el oficio correcto.
									</p>
								</td>
							</tr>
							<tr><td height="20"></td></tr>							
							<tr>
								<td align="center">
									<input type="hidden" name="id_corre_ex" id="id_corre_ex" value="<? echo $id_correspondencia_externa; ?>" />										
									<input type="button" name="btnRegistrar" id="btnRegistrar" value="Anular Oficio" title="Anular Oficio" onclick="anular();" />
									&nbsp;&nbsp;
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
