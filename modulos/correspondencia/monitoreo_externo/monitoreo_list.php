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
//echo $z."<br>";
if(isset($z) && $z!="")
	{
		$condi = "&met=".$_GET["met"]."&condiciones=".$_GET["condiciones"];
		$variable = explode("!",$z);
		for ($j=0;$j<count($variable);$j++)
			{
				
				$desgloce = explode(":",$variable[$j]);
				switch($desgloce[0])
					{
						case "campo1": //estatus
							if($where!="")
								{
									$where = $where . " AND crp_asignacion_correspondencia.id_estatus=".$desgloce[1];
								} else {
									$where = " AND crp_asignacion_correspondencia.id_estatus=".$desgloce[1];
								}					
						break;
						case "campo2"://documento
							$ddo = explode("-",$desgloce[1]);
							
							if($ddo[1]==0){
								$where = " AND crp_correspondencia_externa.id_documento_cgr='".$ddo[0]."'"; 	
							} else {
								$where = " AND crp_correspondencia_externa.id_documento_cgr_desgloce='".$ddo[1]."'"; 
							}
						break;
						case "campo3"://Fecha Registro
							$sub_desgloce = explode("_",$desgloce[1]);
							$where = " AND (crp_correspondencia_externa.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."')"; 	
						break;
						case "campo4"://organism
							$where = " AND crp_correspondencia_externa_det.id_organismo = ".$desgloce[1];	
						break;
						case "campo5"://ncorrelativo
							if($where!="")
								{
									$where = $where . " AND crp_recepcion_correspondencia.n_correlativo='".$desgloce[1]."'";
								} else {
									$where = " AND crp_recepcion_correspondencia.n_correlativo='".$desgloce[1]."'";
								}											
						break;
						case "campo6"://unidad
							$where = " AND crp_asignacion_correspondencia.id_unidad=".$desgloce[1];
						break;
						case "campo7"://mensajero
							$where = " AND crp_correspondencia_externa.id_mensajero=".$desgloce[1];
						break;
						case "campo8"://n_documento
							if($where!="")
								{
									$where = $where . " AND crp_correspondencia_externa.n_oficio_externo='".$desgloce[1]."'";
								} else {
									$where = " AND crp_correspondencia_externa.n_oficio_externo='".$desgloce[1]."'";
								}											

							
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
			case "columna1": //mensajero
				$ondicionW = " ORDER BY mensajero.nombre_apellido $y";
			break;
			case "columna2": //N&deg; Documento
				$ondicionW = "ORDER BY n_oficio_externo $y";	
			break;
			case "columna3"://Organ&iacute;smo / Remitente
				$ondicionW = "ORDER BY organismo $y";		
			break;
			case "columna4"://Fecha Registro
				$ondicionW = "ORDER BY crp_correspondencia_externa.fecha_registro $y";	
			break;
			case "columna5"://Estatus
				$ondicionW = "ORDER BY Estatus $y";	
			break;
			case "columna6"://Unidad Asignada
				$ondicionW = "ORDER BY unidad $y";	
			break;
			case "columna7": // N&deg; Correlativo
				$ondicionW = "ORDER BY n_correlativo $y";	
			break;			
			default:
				$ondicionW = "ORDER BY registro $y";
			break;
		}	
	}
/*	$rslista->sql = "SELECT 
					 crp_asignacion_correspondencia.id_recepcion_correspondencia, crp_recepcion_correspondencia.n_correlativo, if(crp_correspondencia_externa.id_mensajero =0,'--', mensajero.nombre_apellido) AS mensajero, 
					 crp_correspondencia_externa.n_oficio_externo, crp_correspondencia_externa.id_correspondencia_externa, crp_asignacion_correspondencia.id_unidad, unidad.unidad, 
					 estatus.estatus, crp_asignacion_correspondencia.id_estatus, DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%d/%m/%Y %r') AS registro, organismo.organismo, 
					 crp_correspondencia_externa.fecha_registro, crp_asignacion_correspondencia.copia_unidades, crp_correspondencia_externa.contenido, crp_correspondencia_externa.anular 
					FROM crp_recepcion_correspondencia 
					 INNER JOIN crp_asignacion_correspondencia 
					  ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_asignacion_correspondencia.id_recepcion_correspondencia) 
					 INNER JOIN crp_correspondencia_externa 
					  ON (crp_asignacion_correspondencia.id_recepcion_correspondencia = crp_correspondencia_externa.id_recepcion_correspondencia) 
					 left JOIN mensajero 
					  ON (crp_correspondencia_externa.id_mensajero = mensajero.id_mensajero) 
					 INNER JOIN estatus 
					  ON (crp_asignacion_correspondencia.id_estatus = estatus.id_estatus) 
					 INNER JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad) INNER JOIN crp_correspondencia_externa_det ON (crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa)
					  INNER JOIN organismo ON (crp_correspondencia_externa_det.id_organismo = organismo.id_organismo)
					WHERE (crp_asignacion_correspondencia.id_estatus BETWEEN 5 AND 6)
					$where
					GROUP BY crp_correspondencia_externa.n_oficio_externo $ondicionW";
*/
	 $rslista->sql = "SELECT 
					 crp_asignacion_correspondencia.id_recepcion_correspondencia, crp_recepcion_correspondencia.n_correlativo,
					 crp_correspondencia_externa.n_oficio_externo, crp_correspondencia_externa.id_correspondencia_externa, crp_asignacion_correspondencia.id_unidad, unidad.unidad, 
					 estatus.estatus, crp_asignacion_correspondencia.id_estatus, DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%d/%m/%Y %r') AS registro, organismo.organismo, 
					 crp_correspondencia_externa.fecha_registro, crp_asignacion_correspondencia.copia_unidades, crp_correspondencia_externa.contenido, crp_correspondencia_externa.anular 
					FROM crp_recepcion_correspondencia 
					 INNER JOIN crp_asignacion_correspondencia 
					  ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_asignacion_correspondencia.id_recepcion_correspondencia) 
					 INNER JOIN crp_correspondencia_externa 
					  ON (crp_asignacion_correspondencia.id_recepcion_correspondencia = crp_correspondencia_externa.id_recepcion_correspondencia) 
					 INNER JOIN estatus 
					  ON (crp_asignacion_correspondencia.id_estatus = estatus.id_estatus) 
					 INNER JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad) INNER JOIN crp_correspondencia_externa_det ON (crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa)
					  INNER JOIN organismo ON (crp_correspondencia_externa_det.id_organismo = organismo.id_organismo)
					WHERE DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%Y') = 2014 AND (crp_asignacion_correspondencia.id_estatus BETWEEN 5 AND 6)
					$where
					GROUP BY crp_correspondencia_externa.n_oficio_externo $ondicionW";

	$rslista->paginar($pagina,10);

?>

<table border="0" class="b_table1" align="center" width="100%" cellpadding="1" cellspacing="1">
	<tr height="30" valign="middle" class="trcabecera_list">
		<td width="20"></td>
		<td width="50">
			Correlativo
		</td>
		<td width="70">
			N&deg; Oficio Externo
		</td>
		<td width="150">
			Contenido
		</td>		
		<td width="180">
			Organismo Receptor
		</td>
		<td width="90">
			Fecha / Hora Envio
		</td>
		<td width="80">
			Fecha / Hora Entrega
		</td>
		<td>
			Unidad Administrativa Responsable
		</td>
		<td width="70">
			Estatus
		</td>		
		<td width="60">
			Acci&oacute;n
		</td>
	</tr>
	<tr><td colspan="10"></td></tr>
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
			<? echo $rslista->fila["n_oficio_externo"]; ?>
		</td>
		<td>
			<? echo substr($rslista->fila["contenido"],0,30); ?>
		</td>		
		<td>
			<? echo ucwords(mb_strtolower($rslista->fila["organismo"])); ?>
		</td>
		<td>
			<? echo $rslista->fila["registro"]; ?>
		</td>
		<td>
			<? 
				$bsf = new Recordset();
				$bsf->sql = "SELECT DATE_FORMAT(fecha_cambio_estatus, '%d/%m/%Y %r') AS entrega 
							FROM crp_ruta_correspondencia 
							WHERE crp_ruta_correspondencia.id_recepcion_correspondencia = ".$rslista->fila["id_recepcion_correspondencia"]." AND crp_ruta_correspondencia.id_estatus = 6";
				$bsf->abrir();
				if($bsf->total_registros == 1)
					{	
						$bsf->siguiente();
						echo  $bsf->fila["entrega"];
					} else {
						echo  "--";					
					}			
			 ?>
		</td>
		<td>
			<? echo $rslista->fila["unidad"]; ?>
		</td>
		<td>
			<? 
				if($rslista->fila["anular"]==0)
				{
					$bsf1 = new Recordset();
					$bsf1->sql = "SELECT estatus.estatus,  crp_ruta_correspondencia.id_estatus,  crp_ruta_correspondencia.`id_ruta_correspondencia`
										FROM crp_ruta_correspondencia INNER JOIN estatus ON (crp_ruta_correspondencia.id_estatus = estatus.id_estatus) 
										WHERE crp_ruta_correspondencia.id_recepcion_correspondencia = ".$rslista->fila["id_recepcion_correspondencia"]." 
										ORDER BY crp_ruta_correspondencia.id_ruta_correspondencia DESC LIMIT 1";
					$bsf1->abrir();
					if($bsf1->total_registros == 1)
						{	
							$bsf1->siguiente();
							echo  $bsf1->fila["estatus"];
						} 				
				} else {
					echo "Anulado";
				}
			 ?>			
		</td>
		<td>
<?			
				if($rslista->fila["anular"]==0)
				{		
					$casos = $rslista->fila["id_estatus"];
					switch ($casos) 
					{		
						case 5: //enviado
							$imagen = '<img title="Clic para Registrar Entrega" src="images/enviado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_externo/registrar.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'600\',\'370\');" />
										<img title="Clic para Anular Oficio" src="images/no_habilitado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_externo/anular.php?id_recepcion='.$rslista->fila["id_correspondencia_externa"].'\',\'600\',\'290\');" />							
							';								
						break; 
						case 6: //entregado
							$imagen = '<img title="Clic para Visualizar Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_externo/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'750\',\'490\');" />';					
						break;						
					}
				} else {
					$imagen = '<img title="Clic para Visualizar Correspondencia Anulada" src="images/Paper-x.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_externo/ver_anulado.php?id_recepcion='.$rslista->fila["id_correspondencia_externa"].'\',\'600\',\'350\');" />';									
				}
?>		
			<a>
				<? echo $imagen; ?>				
			</a>	
<?			
/*		$casos = $rslista->fila["id_estatus"];
		switch ($casos) 
		{		
			case 5: //enviado
				$imagen = '<img title="Clic para Registrar Entrega" src="images/enviado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_externo/registrar.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'600\',\'370\');" />';								
			break; 
			case 6: //entregado
				$imagen = '<img title="Clic para Visualizar Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_externo/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'750\',\'490\');" />';					
			break;						
		}*/
?>		
<!--			<a>
				<? //echo $imagen; ?>				
			</a>-->	
		</td>																						
	</tr>
	<tr bgcolor="#F8F8F8" id="mDeta_<? echo $rslista->fila["id_recepcion_correspondencia"]; ?>" style="display:none" height="40">
		<td align="center">
			&nbsp;&nbsp;<img src="images/menos.png" style="cursor:pointer" title="Ocultar Detalle" onclick="ocultar_detalles('mDeta_<? echo $rslista->fila["id_recepcion_correspondencia"]; ?>');"/>		
		</td>
		<td colspan="9" align="center">
<?
		$id = $rslista->fila["id_recepcion_correspondencia"];
			if($rslista->fila["copia_unidades"]=="" || is_null($rslista->fila["copia_unidades"])==true)
			{
				if($rslista->fila["anular"]==1)
				{			
					$bsq = new Recordset();
					$bsq->sql = 'SELECT IF(crp_ruta_correspondencia.id_estatus = 7, "<b>Ofic. Correspondencia - Despacho Contralor</b>", IF(
								   crp_ruta_correspondencia.id_estatus = 1, CONCAT("<b>Asignado a:</b> ", (SELECT unidad.unidad FROM crp_asignacion_correspondencia INNER JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad) WHERE crp_asignacion_correspondencia.id_recepcion_correspondencia = '.$id.')), IF(
									crp_ruta_correspondencia.id_estatus = 2, CONCAT("<b>Ya Recibido Por:</b> ", (SELECT unidad.unidad FROM crp_asignacion_correspondencia  INNER JOIN unidad  ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad) WHERE crp_asignacion_correspondencia.id_recepcion_correspondencia = '.$id.')), IF(
									 crp_ruta_correspondencia.id_estatus = 3, "<b>En Revisi&oacute;n Por:</b> Direcci&oacute;n General", IF(
									  crp_ruta_correspondencia.id_estatus = 4, "<b>Despacho del Contralor</b>", "<font color=\"red\"><b>Anulado</b></font>"))))) AS ruta, 
										 DATE_FORMAT(crp_ruta_correspondencia.fecha_cambio_estatus, "%d/%m/%Y %r") as faccion, crp_ruta_correspondencia.id_estatus
								FROM crp_ruta_correspondencia 
								WHERE crp_ruta_correspondencia.id_recepcion_correspondencia ='.$id;
					$bsq->abrir();
		?>
						<table border="0">
		<?
					if($bsq->total_registros > 0)
						{
						
						
		?>
							<tr>
								<td>&nbsp;
									
								</td>						
								<td>
									<table border="0" class="b_table_w" height="30">
										<tr>
											<td colspan="3" class="trcabecera_list">Bitacora de Movimientos</td>
										</tr>
										<tr bgcolor="#BF0000">
											<td width="370px"><b><font color="#FFFFFF">Ubicaci&oacute;n</font></b></td>
											<td width="180"><b><font color="#FFFFFF">Fecha Estatus</font></b></td>	
											<td width="320px"><b><font color="#FFFFFF">Informaci&oacute;n Adicional</font></b></td>				
										</tr>	
						<?
										$zx = 0;
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
													}
			
													if($zx==2)
													{
														echo "<b>Hubo Devoluci&oacute;n:</b> La correspondencia se encuentra nuevamente en la unidad";
														$zx = 0;
													}								
												?>
												
											</td>						
										</tr>
						<?					
										}								
						
						}
								$bsq->cerrar();	
								unset($bsq);	
						?>		
									</table>
						</td>
						<td>
						<td>
					</tr>							
<?				
				} else {
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
		?>
						<table border="0">
		<?
					if($bsq->total_registros > 0)
						{
						
						
		?>
							<tr>
								<td>&nbsp;
									
								</td>						
								<td>
									<table border="0" class="b_table_w" height="30">
										<tr>
											<td colspan="3" class="trcabecera_list">Bitacora de Movimientos</td>
										</tr>
										<tr bgcolor="#BF0000">
											<td width="370px"><b><font color="#FFFFFF">Ubicaci&oacute;n</font></b></td>
											<td width="180"><b><font color="#FFFFFF">Fecha Estatus</font></b></td>	
											<td width="320px"><b><font color="#FFFFFF">Informaci&oacute;n Adicional</font></b></td>				
										</tr>	
						<?
										$zx = 0;
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
													}
			
													if($zx==2)
													{
														echo "<b>Hubo Devoluci&oacute;n:</b> La correspondencia se encuentra nuevamente en la unidad";
														$zx = 0;
													}								
												?>
												
											</td>						
										</tr>
						<?					
										}								
						
						}
								$bsq->cerrar();	
								unset($bsq);	
						?>		
									</table>
						</td>
						<td>
						<td>
					</tr>							
<?
				}
				
			} else {          ?>
					<tr>
						<td>&nbsp;
							
						</td>						
						<td>
<?			
							$bsq1 = new Recordset();
							$bsq1->sql = 'SELECT IF(crp_ruta_correspondencia.id_estatus = 7, "<b>Ofic. Correspondencia - Despacho Contralor</b>", IF(
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
								for($f=0;$f<$bsq1->total_registros;$f++){	
									$bsq1->siguiente();
				?>
								<tr <? if($f % 2 == 0) echo " class=\"trresaltado_info\"" ?>>
									<td><? echo $bsq1->fila["ruta"]; ?></td>
									<td><? echo $bsq1->fila["faccion"]; ?></td>
								</tr>
				<?					
									}	
								}
							$bsq1->cerrar();	
							unset($bsq1);	
				?>		
							</table>
						</td>
						<td>&nbsp;
							
						</td>
					</tr>
<?			
			}		
?>
			</table>
		</td>
	</tr>
	
<?	
			}
?>
	<tr><td height="10" colspan="10"></td></tr>		    
	<tr>
    	<td colspan="10"><? $rslista->CrearPaginadorAjax("modulos/correspondencia/monitoreo_externo/monitoreo_list.php","images/paginador/","cargar_lista_corres",$condi) ?></td>
    </tr>
<?
		} else {
?>	
	<tr class="trresaltado">
		<td colspan="10">
			No Ex&iacute;sten Datos a Mostrar
		</td>																					
	</tr>
<?
}
?>	
</table>