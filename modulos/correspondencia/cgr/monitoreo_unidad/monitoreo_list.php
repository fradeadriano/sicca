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
$condicionUnidad = stripslashes($_GET["Uunidad"]);
$cc = str_pad(stripslashes($_GET["Uunidad"]), 2, "0", STR_PAD_LEFT);
$rslista = new Recordset();
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
/*						case "campo1": //Tipo Documento
							$where = $where." AND crp_recepcion_correspondencia_cgr.id_tipo_documento=".$desgloce[1];
						break;*/
						case "campo2": //estatus
							$where = $where." AND crp_asignacion_correspondencia_cgr.id_estatus=".$desgloce[1];
						break;
						case "campo3"://n_documento
							$where = $where." AND crp_recepcion_correspondencia_cgr.n_oficio_circular='".stripslashes($desgloce[1])."'";
						break;
						case "campo4"://Fecha Registro Y DOCUMENTACION
						//echo $desgloce[1];
							$sub_desgloce = explode("_",$desgloce[1]);
							if($sub_desgloce[0]=="asignacion"){
								$where = $where." AND crp_asignacion_correspondencia_cgr.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])." 00:00:00' AND '".$rslista->formatofecha($sub_desgloce[2])." 23:59:59'";
							} else {
								$where = $where." AND crp_recepcion_correspondencia_cgr.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])." 00:00:00' AND '".$rslista->formatofecha($sub_desgloce[2])." 23:59:59'";							
							}
						break;
						case "campo5"://organismo
							$where = $where." AND crp_recepcion_correspondencia_cgr.id_organismo_cgr=".$desgloce[1];
						break;
						case "campo6"://ncorrelativo
							$where = $where." AND crp_recepcion_correspondencia_cgr.n_correlativo='".$desgloce[1]."-CGR'";
						break;
						case "campo7"://prioridad
							$where = $where." AND crp_asignacion_correspondencia_cgr.id_prioridad=".$desgloce[1];
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
				$ondicionW = "ORDER BY n_oficio_circular $y";	
			break;
			case "columna3"://Organ&iacute;smo / Remitente
				$ondicionW = "ORDER BY organismo $y";		
			break;
			case "columna4"://Fecha Registro
				$ondicionW = "ORDER BY crp_recepcion_correspondencia_cgr.fecha_registro $y";	
			break;
			case "columna5"://Fecha Documento
				$ondicionW = "ORDER BY crp_recepcion_correspondencia_cgr.fecha_documento $y";	
			break;
			case "columna6"://Tipo Correspondencia
				$ondicionW = "ORDER BY tipo $y";	
			break;
			case "columna7"://Estatus
				$ondicionW = "ORDER BY Estatus $y";	
			break;
			case "columna8"://Unidad Asignada
				$ondicionW = "ORDER BY f_asig $y";	
			break;
			case "columna9": // N&deg; Correlativo
				$ondicionW = "ORDER BY n_correlativo $y";	
			break;
			case "columna10": // N&deg; Correlativo
				$ondicionW = "ORDER BY prioridad $y";	
			break;			
			default:
				$ondicionW = "ORDER BY fecha_registro $y";
			break;
		}	
	}
	
	$rslista->sql = "SELECT DATEDIFF(crp_recepcion_correspondencia_cgr.fecha_vencimiento, CURRENT_DATE()) AS tiempo, crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr, crp_recepcion_correspondencia_cgr.n_correlativo, crp_recepcion_correspondencia_cgr.n_oficio_circular,
						  organismo.organismo, crp_recepcion_correspondencia_cgr.fecha_registro, DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_registro,'%d/%m/%Y %r') AS f_registro,
						  DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_documento,'%d/%m/%Y') AS f_oficio,
						  IF(crp_recepcion_correspondencia_cgr.fecha_vencimiento IS NULL,'-',DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_vencimiento,'%d/%m/%Y')) AS fvencimiento,
						  crp_recepcion_correspondencia_cgr.fecha_documento,estatus.estatus,crp_recepcion_correspondencia_cgr.plazo,crp_recepcion_correspondencia_cgr.id_tipo_documento,crp_asignacion_correspondencia_cgr.id_estatus, 
						  tipo_documento.tipo_documento, crp_recepcion_correspondencia_cgr.fecha_vencimiento, crp_recepcion_correspondencia_cgr.plazo, crp_asignacion_correspondencia_cgr.habilitado, 
						  DATE_FORMAT(crp_asignacion_correspondencia_cgr.fecha_asignacion,'%d/%m/%Y') AS f_asig, crp_recepcion_correspondencia_cgr.accion  
						FROM crp_recepcion_correspondencia_cgr 
						  INNER JOIN crp_asignacion_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_asignacion_correspondencia_cgr.id_crp_asignacion_correspondencia_cgr) 
						  INNER JOIN tipo_documento ON (crp_recepcion_correspondencia_cgr.id_tipo_documento = tipo_documento.id_tipo_documento) 
						  INNER JOIN organismo ON (crp_recepcion_correspondencia_cgr.id_organismo_cgr = organismo.id_organismo) 
						  INNER JOIN estatus ON (crp_asignacion_correspondencia_cgr.id_estatus = estatus.id_estatus) 						  
						WHERE (crp_asignacion_correspondencia_cgr.id_unidad = $condicionUnidad)
					  $where
					  $ondicionW";
	$rslista->paginar($pagina,8);
	$condi = $condi."&Uunidad=".$condicionUnidad;
	
function getDiaSemana($fecha) {
											// primero creo un array para saber los días de la semana
											$dias = array(0, 1, 2, 3, 4, 5, 6);
											$dia = substr($fecha, 0, 2);
											$mes = substr($fecha, 3, 2);
											$anio = substr($fecha, 6, 4);
											
											// en la siguiente instrucción $pru toma el día de la semana, lunes, martes,
											$pru = strtoupper($dias[intval((date("w",mktime(0,0,0,$mes,$dia,$anio))))]);
											return $pru;
										}	
//	echo "<br><br>".$condi;
?>

<table border="0" class="b_table1" align="center" width="100%" cellpadding="1" cellspacing="1">
	<tr height="30" valign="middle" class="trcabecera_list1">
		<td width="20"></td>		
		<td width="50">
			Correlativo
		</td>
<!--		<td width="70">
			Tipo Documento
		</td>-->
		<td width="70">
			N&deg; Oficio/Circular
		</td>
		<td width="220">
			Organismo / Remitente
		</td>
		<td width="90">
			Fecha / Hora Registro
		</td>
		<td width="80">
			Fecha Oficio/Circular
		</td>
		<td width="80">
			Fecha Asignaci&oacute;n
		</td>		
		<td width="80">
			Fecha Vencimiento
		</td>
		<td width="70">
			Estatus
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
			<img src="images/mas.png" id="img_mas<? echo $rslista->fila["id_recepcion_correspondencia_cgr"]; ?>" style="cursor:pointer" title="Detallar m&aacute;s" onclick="mostrar_detalles('mDeta_<? echo $rslista->fila["id_recepcion_correspondencia_cgr"]; ?>',this.id);" />
		</td>		
		<td>
			<? echo $rslista->fila["n_correlativo"]; ?>
		</td>
<!--		<td>
			<? //echo $rslista->fila["tipo_documento"]; ?>
		</td>-->
		<td>
			<? echo $rslista->fila["n_oficio_circular"]; ?>
		</td>
		<td>
			<? echo ucwords(mb_strtolower($rslista->fila["organismo"])); ?>
		</td>
		<td>
			<? echo $rslista->fila["f_registro"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["f_oficio"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["f_asig"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["fvencimiento"]; ?>  
		</td>
		<td>
			<? 
				echo $rslista->fila["estatus"];
			?>
		</td>
		<td align="center">
<?			
		$casos = $rslista->fila["id_estatus"];
		switch ($casos) 
		{		
			case 1:
				$imagen = '<img title="Clic para Recibir Correspondencia Asignada" src="images/asignadas.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_unidad/recibir.php?UnidadD='.$condicionUnidad.'&id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'450\');" />';
			break;
			case 2:
				if($rslista->fila["habilitado"]==0){
					$imagen = '<img title="Clic para Visualizar la Correspondencia" src="images/recibido.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_unidad/ver.php?opera=habil&UnidadD='.$condicionUnidad.'&id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'480\');" />';									
				} else if($rslista->fila["habilitado"]==1){
					$imagen = '<img title="Clic para Visualizar la Correspondencia Habilitada" src="images/habilitado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_unidad/ver.php?opera=Nohabil&UnidadD='.$condicionUnidad.'&id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'480\');" />';																	
				}
			break;			
			case 3:
				$imagen = '<img title="Clic para Visualizar la Correspondencia" src="images/consultar.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_unidad/sol_ver.php?UnidadD='.$condicionUnidad.'&id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'480\');" />';									
			break;
			case 4:
				$imagen = '<img title="Clic para Visualizar la Correspondencia Aprobada" src="images/consultar.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_unidad/sol_ver.php?UnidadD='.$condicionUnidad.'&id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'480\');" />';									
			break;
			case 5:
				if($rslista->fila["accion"]==1){
					$bsq1 = new Recordset();
					$bsq1->sql = "SELECT crp_asignacion_correspondencia_cgr.id_crp_asignacion_correspondencia_cgr  
								FROM crp_asignacion_correspondencia_cgr
								WHERE crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr = ".$rslista->fila["id_recepcion_correspondencia_cgr"]; 
					$bsq1->abrir();
					if($bsq1->total_registros > 0)
						{	
							$imagen = '<img title="Clic para Visualizar la Correspondencia Enviada" src="images/consultar.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_unidad/sol_ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'480\');" />';
						}
					$bsq1->cerrar();
					unset($bsq1);					
				} else {
					$bsq1 = new Recordset();
					$bsq1->sql = "SELECT crp_asignacion_correspondencia_cgr.id_crp_asignacion_correspondencia_cgr  
								FROM crp_asignacion_correspondencia_cgr
								WHERE crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr = ".$rslista->fila["id_recepcion_correspondencia_cgr"]; 
					$bsq1->abrir();
					if($bsq1->total_registros > 0)
						{	
							$imagen = '<img title="Clic para Visualizar la Correspondencia Enviada" src="images/asignadas.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_unidad/recibir_copias.php?UnidadD='.$condicionUnidad.'&id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'480\');" />';
						}
					$bsq1->cerrar();
					unset($bsq1);					
				}
			break;
			case 6:
				$bsq1 = new Recordset();
				$bsq1->sql = "SELECT crp_asignacion_correspondencia_cgr.id_crp_asignacion_correspondencia_cgr 
							FROM crp_asignacion_correspondencia_cgr
							WHERE crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr = ".$rslista->fila["id_recepcion_correspondencia_cgr"]; 
				$bsq1->abrir();
				if($bsq1->total_registros ==1)
					{	
						$imagen = '<img title="Clic para Visualizar la Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_unidad/sol_ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'480\');" />';									
					}
				$bsq1->cerrar();
				unset($bsq1);				
				
			break;									
		}

?>		
			<a>
				<? echo $imagen; ?>				
			</a>	
		</td>																						
	</tr>

	<tr bgcolor="#F8F8F8" id="mDeta_<? echo $rslista->fila["id_recepcion_correspondencia_cgr"]; ?>" style="display:none" height="100">
		<td align="center">
			&nbsp;&nbsp;<img src="images/menos.png" style="cursor:pointer" title="Ocultar Detalle" onclick="ocultar_detalles('mDeta_<? echo $rslista->fila["id_recepcion_correspondencia_cgr"]; ?>');"/>		
		</td>
		<td colspan="10" align="left">
			<table border="0">		
<?
		$id = $rslista->fila["id_recepcion_correspondencia_cgr"];
					$bsq = new Recordset();
					$bsq->sql = 'SELECT IF(crp_ruta_correspondencia_cgr.id_estatus = 7, "<b>Ofic. Correspondencia - Despacho Contralor</b>", 
									IF(crp_ruta_correspondencia_cgr.id_estatus = 1, CONCAT("<b>Asignado a:</b> ", (SELECT unidad.unidad FROM crp_asignacion_correspondencia_cgr INNER JOIN unidad ON (crp_asignacion_correspondencia_cgr.id_unidad = unidad.id_unidad) WHERE crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '.$id.')), 
									IF(crp_ruta_correspondencia_cgr.id_estatus = 2, CONCAT("<b>Ya Recibido Por:</b> ", (SELECT unidad.unidad FROM crp_asignacion_correspondencia_cgr  INNER JOIN unidad  ON (crp_asignacion_correspondencia_cgr.id_unidad = unidad.id_unidad) WHERE crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '.$id.')), 
									IF(crp_ruta_correspondencia_cgr.id_estatus = 4, "<b>Se encuentra en Despacho del Contralor</b>", 
									IF(crp_ruta_correspondencia_cgr.id_estatus = 5, "<b>Enviado</b> ", 
									IF(crp_ruta_correspondencia_cgr.id_estatus = 6, "<b>Entregado</b> ", "--")))))) AS ruta, DATE_FORMAT(crp_ruta_correspondencia_cgr.fecha_recepcion, "%d/%m/%Y %r") AS faccion, crp_ruta_correspondencia_cgr.id_estatus
								FROM crp_ruta_correspondencia_cgr 
								WHERE crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr ='.$id;
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
									<td width="300px"><b><font color="#FFFFFF">Ubicaci&oacute;n</font></b></td>
									<td><b><font color="#FFFFFF">Fecha Estatus</font></b></td>
									<!--<td width="250px"><b><font color="#FFFFFF">Informaci&oacute;n Adicional</font></b></td>-->													
								</tr>	
			<?
							for($f=0;$f<$bsq->total_registros;$f++)
							{	
								$bsq->siguiente();
			?>
								<tr <? if($f % 2 == 0) echo " class=\"trresaltado_info\"" ?>>
									<td><? echo $bsq->fila["ruta"]; ?></td>				
									<td><? echo $bsq->fila["faccion"]; ?></td>
								</tr>
				<? 			}	 ?>
							</table>			
			    <?		}
					$bsq->cerrar();	
					unset($bsq);	
?>
						</td>
					</tr>					
					<tr><td  height="10"colspan="2"></td></tr>
					<tr>
						<td></td>
						<td>
<?
	if(is_null($rslista->fila["plazo"])!=true && ($rslista->fila["id_estatus"]==1 || $rslista->fila["id_estatus"]==2))
	{	
								
?>
							<table border="0" class="b_table_w" height="30">
								<tr>
									<td colspan="3" class="trcabecera_list">Informaci&oacute;n Asignaci&oacute;n</td>
								</tr>
								<tr>
									<td>Plazo:</td>
									<td><? echo $rslista->fila["plazo"]." d&iacute;as"; ?></td>					
								</tr>
								<tr>
									<td>Fecha Vencimiento:</td>
									<td><? echo "<span class='mensaje'>".$rslista->fila["f_vencimiento"]."</span>"; ?></td>
								</tr>
<!--								<tr>
									<td>Faltan:</td>
									<td>
										<? 									
/*											echo "<span class='mensaje'>".$rslista->fila["tiempo"]."</span>"; 
											for ($b=1;$b<=$rslista->fila["tiempo"];$b++){
												getDiaSemana();
											
											}*/
										?>
									</td>
								</tr>-->								
							</table>
<? } ?>							
						</td>
					</tr>
				<tr><td height="5"></td></tr>			
			</table>
		</td>
	</tr>
	<tr><td height="1" colspan="11"></td></tr>	
<?	
			}
?>

	<tr><td height="10" colspan="11"></td></tr>		    
	<tr>
    	<td colspan="11"><? $rslista->CrearPaginadorAjax("modulos/correspondencia/cgr/monitoreo_unidad/monitoreo_list.php","images/paginador/","cargar_lista_corres",$condi) ?></td>
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