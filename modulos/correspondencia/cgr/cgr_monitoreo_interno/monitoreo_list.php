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
require_once("../../../../librerias/Recordset.php");
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
									$where = $where . " AND crp_asignacion_correspondencia_cgr.id_estatus=".$desgloce[1];
								} else {
									$where = " AND crp_asignacion_correspondencia_cgr.id_estatus=".$desgloce[1];
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
							if($where!="")
								{
									$where = $where . " AND (crp_correspondencia_externa.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."')";
								} else {
									$where = " AND (crp_correspondencia_externa.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."')"; 	
								}								
						break;
						case "campo4"://organism
							if($where!="")
								{
									$where = $where . " AND crp_correspondencia_externa_det.id_organismo = ".$desgloce[1];
								} else {
									$where = " AND crp_correspondencia_externa_det.id_organismo = ".$desgloce[1];
								}								
						break;
						case "campo5"://ncorrelativo
							if($where!="")
								{
									$where = $where . " AND crp_recepcion_correspondencia_cgr.n_correlativo='".$desgloce[1]."'";
								} else {
									$where = " AND crp_recepcion_correspondencia_cgr.n_correlativo='".$desgloce[1]."'";
								}											
						break;
						case "campo6"://unidad
							if($where!="")
								{
									$where = $where . " AND crp_asignacion_correspondencia_cgr.id_unidad=".$desgloce[1];
								} else {
									$where = " AND crp_asignacion_correspondencia_cgr.id_unidad=".$desgloce[1];
								}								
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
						default:
							$where = " (crp_asignacion_correspondencia_cgr.id_estatus BETWEEN 5 AND 6)";
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
				$ondicionW = "ORDER BY n_oficio_externo $y";
			break;
		}	
	}
	/*echo $rslista->sql = "SELECT crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr, crp_recepcion_correspondencia_cgr.n_correlativo,crp_correspondencia_externa.n_oficio_externo, crp_correspondencia_externa.id_correspondencia_externa,
								  crp_asignacion_correspondencia_cgr.id_unidad, unidad.unidad, estatus.estatus, crp_asignacion_correspondencia_cgr.id_estatus, DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%d/%m/%Y %r') AS registro,
								  organismo.organismo, crp_correspondencia_externa.fecha_registro, crp_correspondencia_externa.contenido 
						FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_asignacion_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr) 
							  INNER JOIN crp_correspondencia_externa ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_correspondencia_externa.id_recepcion_correspondencia_cgr) 
							  INNER JOIN estatus ON (crp_asignacion_correspondencia_cgr.id_estatus = estatus.id_estatus) 
							  INNER JOIN unidad ON (crp_asignacion_correspondencia_cgr.id_unidad = unidad.id_unidad) 
							  INNER JOIN crp_correspondencia_externa_det ON (crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa) 
							  INNER JOIN organismo ON (crp_correspondencia_externa_det.id_organismo = organismo.id_organismo) 
					WHERE DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%Y')=2014 AND (crp_asignacion_correspondencia_cgr.id_estatus BETWEEN 5 AND 6)
					$where
					GROUP BY crp_correspondencia_externa.n_oficio_externo $ondicionW";
	*/
	$rslista->sql = "SELECT crp_correspondencia_externa.`n_oficio_externo`, crp_correspondencia_externa.`contenido`, organismo.`organismo`, DATE_FORMAT(crp_correspondencia_externa.fecha_registro,'%d/%m/%Y %r') AS registro, crp_correspondencia_externa.`id_correspondencia_externa`, 
				if(crp_recepcion_correspondencia_cgr.`n_correlativo` IS NULL,'--',crp_recepcion_correspondencia_cgr.`n_correlativo`) AS n_correlativo,
				crp_correspondencia_externa.`id_recepcion_correspondencia_cgr`, IF(crp_recepcion_correspondencia_cgr.`n_oficio_circular` IS NULL, '-', crp_recepcion_correspondencia_cgr.`n_oficio_circular`) AS n_oficio_circular, 
				IF(crp_asignacion_correspondencia_cgr.`id_unidad` IS NULL, 0, crp_asignacion_correspondencia_cgr.`id_unidad`) AS id_unidad, IF(crp_asignacion_correspondencia_cgr.`id_estatus` IS NULL, 0, crp_asignacion_correspondencia_cgr.`id_estatus`) AS id_estatus
	FROM crp_correspondencia_externa 
		INNER JOIN crp_correspondencia_externa_det ON (crp_correspondencia_externa.`id_correspondencia_externa` = crp_correspondencia_externa_det.`id_correspondencia_externa`)
		INNER JOIN organismo ON (organismo.`id_organismo` = crp_correspondencia_externa_det.`id_organismo`)
		LEFT JOIN crp_recepcion_correspondencia_cgr ON (crp_correspondencia_externa.`id_recepcion_correspondencia_cgr` = crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)
		LEFT JOIN crp_asignacion_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr` = crp_asignacion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)
	WHERE organismo.`cgr` = 1 AND DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%Y')=2016
	 $ondicionW";			
	$rslista->paginar($pagina,10);
?>

<table border="0" class="b_table1" align="center" width="100%" cellpadding="1" cellspacing="1">
	<tr height="30" valign="middle" class="trcabecera_list1">
		<td width="20"></td>
		<td width="70">
			N&deg; Oficio Externo
		</td>
		<td width="50">
			Correlativo
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
			<img src="images/det_contenido.png" style="cursor:help" title="<? echo $rslista->fila["contenido"]; ?>" />
		</td>
		<td>
			<? echo $rslista->fila["n_oficio_externo"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["n_correlativo"]; ?>
		</td>
		<td>
			<? echo substr($rslista->fila["contenido"],0,30)." .."; ?>
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
				$bsf->sql = "SELECT DATE_FORMAT(fecha_recepcion, '%d/%m/%Y %r') AS entrega 
							FROM crp_ruta_correspondencia_cgr 
							WHERE crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr = ".$rslista->fila["id_recepcion_correspondencia_cgr"]." AND crp_ruta_correspondencia_cgr.id_estatus = 6";
				$bsf->abrir();
				if($bsf->total_registros == 1)
					{	
						$bsf->siguiente();
						echo  $bsf->fila["entrega"];
					} else {
						echo  "--";					
					}	
				$bsf->cerrar();
				unset($bsf);							
			 ?>
		</td>
		<td>
			<? 
				$bsf1 = new Recordset();
				$bsf1->sql = "SELECT unidad.`unidad` FROM unidad WHERE unidad.`id_unidad` = ".$rslista->fila["id_unidad"];
				$bsf1->abrir();
				if($bsf1->total_registros == 1)
					{	
						$bsf1->siguiente();
						echo  $bsf1->fila["unidad"];
					} else {
						echo  "--";					
					}	
				$bsf1->cerrar();
				unset($bsf1);							
							
			 ?>
		</td>
		<td>
			<? 			
				$suytr = 0;
				$bsf2 = new Recordset();
				$bsf2->sql = "SELECT estatus.estatus, crp_ruta_correspondencia_ext.id_estatus 
								FROM crp_ruta_correspondencia_ext INNER JOIN estatus ON (crp_ruta_correspondencia_ext.id_estatus = estatus.id_estatus) 
								WHERE crp_ruta_correspondencia_ext.id_correspondencia_externa = ".$rslista->fila["id_correspondencia_externa"]." ORDER BY crp_ruta_correspondencia_ext.id_crp_ruta_correspondencia_ext DESC LIMIT 1 ";
				$bsf2->abrir();
				if($bsf2->total_registros == 1)
					{	
						$bsf2->siguiente();
						echo $bsf2->fila["estatus"];
						$iid_estatus = $bsf2->fila["id_estatus"];
						
					} else if($bsf2->total_registros == 0){
						$bsfsub = new Recordset();
						$bsfsub->sql = "SELECT estatus.estatus, estatus.id_estatus, crp_correspondencia_externa.id_recepcion_correspondencia_cgr FROM crp_correspondencia_externa INNER JOIN crp_ruta_correspondencia_cgr ON (crp_correspondencia_externa.`id_recepcion_correspondencia_cgr` = crp_ruta_correspondencia_cgr.`id_recepcion_correspodencia_cgr`) INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
												WHERE crp_correspondencia_externa.`id_correspondencia_externa` = ".$rslista->fila["id_correspondencia_externa"]."
												ORDER BY crp_ruta_correspondencia_cgr.`id_crp_ruta_correspodencia_cgr` DESC LIMIT 1";
						$bsfsub->abrir();
						if($bsfsub->total_registros == 1)
							{	
								$bsfsub->siguiente();
								echo $bsfsub->fila["estatus"];
								$iid_estatus = $bsfsub->fila["id_estatus"];
								$suytr = 1;
							}						
						$bsfsub->cerrar();
						unset($bsfsub);
					}
					$bsf2->cerrar();
					unset($bsf2);				
				
			?>
		</td>
		<td>
<?			
		$casos = $iid_estatus;
		if($suytr == 0)
		{
			switch ($casos) 
			{		
				case 5: //enviado
					$imagen = '<img title="Clic para Registrar Entrega" src="images/enviado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/cgr_monitoreo_interno/registrar_caso.php?id_recepcion='.$rslista->fila["id_correspondencia_externa"].'\',\'600\',\'370\');" />';								
				break; 
				case 6: //entregado
					$imagen = '<img title="Clic para Visualizar Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/cgr_monitoreo_interno/ver_caso.php?id_recepcion='.$rslista->fila["id_correspondencia_externa"].'\',\'650\',\'390\');" />';					
				break;						
			}
		} else if ($suytr ==1){
			switch ($casos) 
			{		
				case 5: //enviado
					$imagen = '<img title="Clic para Registrar Entrega" src="images/enviado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/cgr_monitoreo_interno/registrar.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'600\',\'370\');" />';								
				break; 
				case 6: //entregado
					$imagen = '<img title="Clic para Visualizar Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/cgr_monitoreo_interno/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'750\',\'490\');" />';					
				break;						
			}
		}
?>		
			<a>
				<?  echo $imagen; 
					$casos = "";
					$iid_estatus = "";
					$imagen="";  				
				?>				
			</a>	
		</td>																						
	</tr>
	
<?	
			}
?>
	<tr><td height="10" colspan="10"></td></tr>		    
	<tr>
    	<td colspan="10"><? $rslista->CrearPaginadorAjax("modulos/correspondencia/cgr/cgr_monitoreo_interno/monitoreo_list.php","images/paginador/","cargar_lista_corres",$condi) ?></td>
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