<?
if(!stristr($_SERVER['SCRIPT_NAME'],"monitoreo_list.php")){
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
$pagina = intval($_GET["pagina"]);
if($pagina == 0)
	$pagina = 1;
require_once("../../../librerias/Recordset.php");
require_once("bil.php");
$x = stripslashes($_GET["p_orden"]);
$y = stripslashes($_GET["met"]);
$z = stripslashes($_GET["condiciones"]);
$rslista = new Recordset();
$where = " AND (crp_asignacion_correspondencia.id_estatus BETWEEN 2 AND 6)";
if(isset($z) && $z!="")
	{
		$condi = "&met=".$_GET["met"]."&condiciones=".$_GET["condiciones"];
		$variable = explode("!",$z);
		for ($j=0;$j<count($variable);$j++)
			{
				$variable[$j]."<br>";
				$desgloce = explode(":",$variable[$j]);
				switch($desgloce[0])
					{
						case "campo1": //Tipo Documento
							$where = " AND (crp_asignacion_correspondencia.id_estatus BETWEEN 2 AND 6) AND crp_recepcion_correspondencia.id_tipo_documento=".$desgloce[1];
						break;
						case "campo2": //estatus
							$where = " AND crp_asignacion_correspondencia.id_estatus=".$desgloce[1];
						break;
						case "campo3"://n_documento
							$where = "  AND (crp_asignacion_correspondencia.id_estatus BETWEEN 2 AND 6) AND crp_recepcion_correspondencia.n_documento='".$desgloce[1]."'"; 	
						break;
						case "campo4"://Fecha Registro Y DOCUMENTACION
							$sub_desgloce = explode("_",$desgloce[1]);
							$where = "  AND (crp_asignacion_correspondencia.id_estatus BETWEEN 2 AND 6) AND crp_recepcion_correspondencia.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'"; 	
						break;
						case "campo5"://organism
							$where = "  AND (crp_asignacion_correspondencia.id_estatus BETWEEN 2 AND 6) AND crp_recepcion_correspondencia.id_organismo=".$desgloce[1];	
						break;
						case "campo6"://ncorrelativo
							$where = "  AND (crp_asignacion_correspondencia.id_estatus BETWEEN 2 AND 6) AND crp_recepcion_correspondencia.n_correlativo='".$desgloce[1]."'";	
						break;
						case "campo7"://unidad
							$where = " AND (crp_asignacion_correspondencia.id_estatus BETWEEN 2 AND 6) AND crp_asignacion_correspondencia.id_unidad=".$desgloce[1];
						break;						
					}	
			}
	}
if(isset($x))
	{
		if($condi!=""){
			$condi = $condi."&p_orden=".$_GET["p_orden"];
		} else {
			$condi = "&p_orden=".$_GET["p_orden"]."&met=".$_GET["met"];		
		}
		switch($x){
			case "columna1": //Tipo Documento
				$ondicionW = " ORDER BY tipo_documento.tipo_documento $y";
			break;
			case "columna2": //N&deg; Documento
				$ondicionW = "ORDER BY n_documento $y";	
			break;
			case "columna3"://Organ&iacute;smo / Remitente
				$ondicionW = "ORDER BY organismo $y";		
			break;
			case "columna4"://Fecha Registro
				$ondicionW = "ORDER BY crp_recepcion_correspondencia.fecha_registro $y";	
			break;
			case "columna5"://Fecha Documento
				$ondicionW = "ORDER BY crp_recepcion_correspondencia.fecha_documento $y";	
			break;
			case "columna6"://Tipo Correspondencia
				$ondicionW = "ORDER BY tipo $y";	
			break;
			case "columna7"://Estatus
				$ondicionW = "ORDER BY Estatus $y";	
			break;
			case "columna8"://Unidad Asignada
				$ondicionW = "ORDER BY unidad $y";	
			break;
			case "columna9": // N&deg; Correlativo
				$ondicionW = "ORDER BY n_correlativo $y";	
			break;			
			default:
				$ondicionW = "ORDER BY fecha_registro $y";
			break;
		}	
	}
	$rslista->sql = "SELECT 
					  crp_recepcion_correspondencia.id_recepcion_correspondencia,  
					  tipo_documento.tipo_documento,
					  IF(crp_recepcion_correspondencia.n_documento='','--',crp_recepcion_correspondencia.n_documento) AS n_documento,
					  IF(crp_recepcion_correspondencia.id_organismo <> '',organismo.organismo,crp_recepcion_correspondencia.remitente) AS organismo, crp_asignacion_correspondencia.id_unidad, 
					  DATE_FORMAT(crp_recepcion_correspondencia.fecha_registro,'%d/%m/%Y %r') AS registro,
					  DATE_FORMAT(crp_recepcion_correspondencia.fecha_documento,'%d/%m/%Y') AS fdocumento,
					  crp_recepcion_correspondencia.fecha_registro,
					  crp_recepcion_correspondencia.fecha_documento,					  
					  IF(crp_recepcion_correspondencia.tipo_correspondencia=0,'Institucional','Personal') AS tipo,
					  IF(unidad.unidad <>'',unidad.unidad,'--') AS unidad, crp_recepcion_correspondencia.n_correlativo, estatus.estatus,crp_asignacion_correspondencia.id_estatus, crp_asignacion_correspondencia.id_prioridad,
					  IF(crp_asignacion_correspondencia.id_prioridad=1, CONCAT('<u>',prioridad.prioridad,'</u>'), prioridad.prioridad) AS prioridad, 
					  crp_asignacion_correspondencia.habilitado, crp_asignacion_correspondencia.copia_unidades 
					  FROM crp_recepcion_correspondencia INNER JOIN
						  tipo_documento ON (crp_recepcion_correspondencia.id_tipo_documento = tipo_documento.id_tipo_documento)
						  LEFT JOIN organismo ON (crp_recepcion_correspondencia.id_organismo = organismo.id_organismo) 
						  LEFT JOIN crp_asignacion_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_asignacion_correspondencia.id_recepcion_correspondencia)
						  LEFT JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad) INNER JOIN estatus ON (crp_asignacion_correspondencia.id_estatus = estatus.id_estatus)
						  LEFT JOIN prioridad ON (crp_asignacion_correspondencia.id_prioridad = prioridad.id_prioridad) 						  
					  WHERE (crp_asignacion_correspondencia.id_unidad IS NOT NULL AND crp_asignacion_correspondencia.externo = 1) 
					  $where
					  $ondicionW";
	$rslista->paginar($pagina,10);

?>

<table border="0" class="b_table1" align="center" width="100%" cellpadding="1" cellspacing="1">
	<tr height="30" valign="middle" class="trcabecera_list">
		<td width="20"></td>
		<td width="50">
			Correlativo
		</td>
		<td width="70">
			Tipo Documento
		</td>
		<td width="70">
			N&deg; Documento
		</td>
		<td width="180">
			Organismo / Remitente
		</td>
		<td width="90">
			Fecha / Hora Registro
		</td>
		<td width="80">
			Fecha Documento
		</td>
		<td>
			Unidad Administrativa
		</td>
		<td width="70">
			Estatus
		</td>
		<td width="80">
			Prioridad
		</td>		
		<td width="60">
			Acci&oacute;n
		</td>
	</tr>
	<tr><td colspan="11"></td></tr>
<?
	if($rslista->total_registros > 0)
		{	
			for ($i=1;$i<=$rslista->total_registros;$i++)
			{
				$rslista->siguiente();
?>				
	<tr <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
		<td align="center">
			<img src="images/mas.png" id="img_mas<? echo $rslista->fila["id_recepcion_correspondencia"]; ?>" style="cursor:pointer" title="Detallar m&aacute;s" onclick="mostrar_detalles('mDeta_<? echo $rslista->fila["id_recepcion_correspondencia"]; ?>',this.id);" />
		</td>
		<td>
			<? echo $rslista->fila["n_correlativo"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["tipo_documento"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["n_documento"]; ?>
		</td>
		<td>
			<? echo ucwords(mb_strtolower($rslista->fila["organismo"])); ?>
		</td>
		<td>
			<? echo $rslista->fila["registro"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["fdocumento"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["unidad"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["estatus"]; ?>
		</td>
		<td>
			<? if ($rslista->fila["prioridad"]!="") { echo $rslista->fila["prioridad"]; } else { echo "--";} ?>		
		</td>
		<td>
<?			
		$casos = $rslista->fila["id_estatus"];
		switch ($casos) 
		{		
			case 2: // proceso
				if($rslista->fila["habilitado"]==0){
					$imagen = '<img title="Clic para Visualizar Correspondencia" src="images/no_habilitado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_revisar/recibir.php?habilitado=no&id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'550\');" />';			
				} else if($rslista->fila["habilitado"]==1){
					$imagen = '<img title="Clic para Recibir Correspondencia" src="images/recepcion.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_revisar/recibir.php?habilitado=si&id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'550\');" />';							
				}
			break;
			case 3: // revision
				$imagen = '<img title="Clic para Devolver la Correspondencia" src="images/devolucion.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_revisar/devolucion.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'700\');" />';								
			break; 
			case 4: //aprobado
				$imagen = '<img title="Clic para Visualizar la Correspondencia" src="images/consultar.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_revisar/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'550\');" />';					
			break;	
			case 5: //enviado
				$imagen = '<img title="Clic para Visualizar Correspondencia Enviada" src="images/enviado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_revisar/enviado.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'550\');" />';								
			break; 
			case 6: //entregado
				$imagen = '<img title="Clic para Visualizar Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_revisar/entregado.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'600\');" />';					
			break;						
		}
?>		
			<a>
				<? echo $imagen; ?>				
			</a>	
		</td>																						
	</tr>
	<tr bgcolor="#F8F8F8" id="mDeta_<? echo $rslista->fila["id_recepcion_correspondencia"]; ?>" style="display:none" height="100">
		<td align="center">
			&nbsp;&nbsp;<img src="images/menos.png" style="cursor:pointer" title="Ocultar Detalle" onclick="ocultar_detalles('mDeta_<? echo $rslista->fila["id_recepcion_correspondencia"]; ?>');"/>		
		</td>
		<td colspan="11" align="center">&nbsp;<br />
			<table border="0">
<?
		$id = $rslista->fila["id_recepcion_correspondencia"];
/*		$ver = new Recordset();
		echo $ver->sql = 'SELECT crp_correspondencia_externa.id_recepcion_correspondencia FROM crp_correspondencia_externa INNER JOIN crp_correspondencia_externa_det ON (crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa)
					 WHERE crp_correspondencia_externa.id_recepcion_correspondencia ='.$id;
		$ver->abrir();
		//echo $ver->total_registros;
		if($ver->total_registros <= 1)
			{		
*/			
			if($rslista->fila["copia_unidades"]=="" || is_null($rslista->fila["copia_unidades"])==true){
			$bsq = new Recordset();
			$bsq->sql = 'SELECT IF(crp_ruta_correspondencia.id_estatus = 7, "<b>Ofic. Correspondencia - Despacho Contralor</b>", IF(
						   crp_ruta_correspondencia.id_estatus = 1, CONCAT("<b>Asignado a:</b> ", (SELECT unidad.unidad FROM crp_asignacion_correspondencia INNER JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad) WHERE crp_asignacion_correspondencia.id_recepcion_correspondencia = '.$id.')), IF(
							crp_ruta_correspondencia.id_estatus = 2, CONCAT("<b>Ya Recibido Por:</b> ", (SELECT unidad.unidad FROM crp_asignacion_correspondencia  INNER JOIN unidad  ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad) WHERE crp_asignacion_correspondencia.id_recepcion_correspondencia = '.$id.')), IF(
							 crp_ruta_correspondencia.id_estatus = 3, "<b>En Revisi&oacute;n Por:</b> Direcci&oacute;n General", IF(
							  crp_ruta_correspondencia.id_estatus = 4, "<b>Despacho del Contralor</b>", IF(
							   crp_ruta_correspondencia.id_estatus = 5, CONCAT("<b>Enviado a:</b> ",(SELECT organismo.organismo FROM crp_correspondencia_externa INNER JOIN crp_correspondencia_externa_det ON (crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa) INNER JOIN organismo ON (crp_correspondencia_externa_det.id_organismo = organismo.id_organismo) WHERE crp_correspondencia_externa.id_recepcion_correspondencia = '.$id.')), IF(
								crp_ruta_correspondencia.id_estatus = 6, CONCAT("<b>Entregado a:</b> ", (SELECT organismo.organismo FROM crp_correspondencia_externa INNER JOIN crp_correspondencia_externa_det ON (crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa) INNER JOIN organismo ON (crp_correspondencia_externa_det.id_organismo = organismo.id_organismo) WHERE crp_correspondencia_externa.id_recepcion_correspondencia = '.$id.')), "--"))))))) AS ruta, 
								 DATE_FORMAT(crp_ruta_correspondencia.fecha_cambio_estatus, "%d/%m/%Y %r") as faccion, crp_ruta_correspondencia.id_estatus
						FROM crp_ruta_correspondencia 
						WHERE crp_ruta_correspondencia.id_recepcion_correspondencia ='.$id;
			$bsq->abrir();
			if($bsq->total_registros > 0)
				{
?>
					<tr>
						<td>&nbsp;</td>						
						<td>
							<table border="0" class="b_table_w" height="30">
								<tr>
									<td colspan="3" class="trcabecera_list">Bitacora de Movimientos</td>
								</tr>
								<tr bgcolor="#BF0000">
									<td width="370px"><b><font color="#FFFFFF">Ubicaci&oacute;n</font></b></td>
									<td width="180px"><b><font color="#FFFFFF">Fecha Estatus</font></b></td>	
									<td width="250px"><b><font color="#FFFFFF">Informaci&oacute;n Adicional</font></b></td>				
								</tr>	
<?
								$zx = 0;
								$zy = 0;								
								for($f=0;$f<$bsq->total_registros;$f++)
								{	
									$bsq->siguiente();
?>
									<tr <? if($f % 2 == 0) echo " class=\"trresaltado_info\"" ?>>
										<td><? echo $bsq->fila["ruta"]; ?></td>				
										<td><? echo $bsq->fila["faccion"]; ?></td>
										<td>
											<? 
												if($bsq->fila["id_estatus"]==2)
												{
													$zx = $zx+1;
													$zy = $zy+1;

													if($zy >= 3)
													{
														echo "<b>Hubo Devoluci&oacute;n:</b> La correspondencia se encuentra nuevamente en la unidad";
														$zx = 0;
													}													
												}
		
												if($zx==2)
												{
													echo "<b>Hubo Devoluci&oacute;n:</b> La correspondencia se encuentra nuevamente en la unidad";
													$zx = 0;
												}								
											?>
											
										</td>						
									</tr>
<?								}	
				}
			$bsq->cerrar();	
			unset($bsq);	
?>		
							</table>
						</td>
					</tr>
			
<?
		//			} else {
			} else { ?>
					<tr>
						<td>&nbsp;</td>						
						<td>
<?			
							$bsq1 = new Recordset();
							echo $bsq1->sql = 'SELECT IF(crp_ruta_correspondencia.id_estatus = 7, "<b>Ofic. Correspondencia - Despacho Contralor</b>", IF(
										   crp_ruta_correspondencia.id_estatus = 1, CONCAT("<b>Asignado a:</b> ", (SELECT unidad.unidad FROM crp_asignacion_correspondencia INNER JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad) WHERE crp_asignacion_correspondencia.id_recepcion_correspondencia = '.$id.')), IF(
											crp_ruta_correspondencia.id_estatus = 2, CONCAT("<b>Ya Recibido Por:</b> ", (SELECT unidad.unidad FROM crp_asignacion_correspondencia  INNER JOIN unidad  ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad) WHERE crp_asignacion_correspondencia.id_recepcion_correspondencia = '.$id.')), IF(
											 crp_ruta_correspondencia.id_estatus = 3, "<b>En Revisi&oacute;n Por:</b> Direcci&oacute;n General", IF(
											  crp_ruta_correspondencia.id_estatus = 4, "<b>Despacho del Contralor</b>", IF(
											   crp_ruta_correspondencia.id_estatus = 5, CONCAT("<b>Enviado a:</b> ",(SELECT unidad.unidad FROM unidad WHERE unidad.codigo = "'.$rslista->fila["copia_unidades"].'")), IF(
												crp_ruta_correspondencia.id_estatus = 6, CONCAT("<b>Entregado a:</b> ", (SELECT unidad.unidad FROM unidad WHERE unidad.codigo = "'.$rslista->fila["copia_unidades"].'")), "--"))))))) AS ruta, 
												 DATE_FORMAT(crp_ruta_correspondencia.fecha_cambio_estatus, "%d/%m/%Y %r") as faccion
										FROM crp_ruta_correspondencia 
										WHERE crp_ruta_correspondencia.id_recepcion_correspondencia ='.$id;
							$bsq1->abrir();
							if($bsq1->total_registros > 0)
								{
?>			
									<table border="0" class="b_table_w" height="30">
										<tr>
											<td colspan="2" class="trcabecera_list">Bitacora de Movimientos</td>
										</tr>
										<tr bgcolor="#BF0000">
											<td width="300px"><b><font color="#FFFFFF">Ubicaci&oacute;n</font></b></td>
											<td><b><font color="#FFFFFF">Fecha Estatus</font></b></td>					
										</tr>	
<?
										for($f=0;$f<$bsq1->total_registros;$f++)
										{	
											$bsq1->siguiente();
?>
										<tr <? if($f % 2 == 0) echo " class=\"trresaltado_info\"" ?>>
											<td><? echo $bsq1->fila["ruta"]; ?></td>
											<td><? echo $bsq1->fila["faccion"]; ?></td>
										</tr>
<?										} ?>
									</table>	
<?								}

							$bsq1->cerrar();	
							unset($bsq1);	
?>			
						</td>
					</tr>		
<?			}		
/*			}
		$ver->cerrar();	
		unset($ver);			
*/?>
			</table>
		</td>
	</tr>
	<tr><td height="1" colspan="11"></td></tr>	
<?	
			}
?>
	<tr><td height="10" colspan="11"></td></tr>		    
	<tr>
    	<td colspan="11"><? $rslista->CrearPaginadorAjax("modulos/correspondencia/monitoreo_revisar/monitoreo_list.php","images/paginador/","cargar_lista_corres",$condi) ?></td>
    </tr>
<?
		} else {
?>	
	<tr class="trresaltado">
		<td colspan="11">
			No Ex&iacute;sten Datos a Mostrar
		</td>																					
	</tr>
<?
}
?>	
</table>		