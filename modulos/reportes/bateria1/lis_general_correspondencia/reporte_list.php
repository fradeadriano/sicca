<?
if(!stristr($_SERVER['SCRIPT_NAME'],"reporte_list.php")){
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
$x = stripslashes($_GET["p_orden"]);
$y = stripslashes($_GET["met"]);
$z = stripslashes($_GET["condiciones"]);
//$conjunto = stripslashes($_GET["condiciones"])
$rslista = new Recordset();
if(isset($z) && $z!="")
	{
		$variable = explode("!",$z);
		for ($j=0;$j<count($variable);$j++)
			{
				$variable[$j]."<br>";
				$desgloce = explode(":",$variable[$j]);
				switch($desgloce[0])
					{
						case "campo1": //Tipo Documento
							if($where!="")
								{
									$where = $where." AND crp_recepcion_correspondencia.id_tipo_documento=".$desgloce[1];
								} else {
									$where = $where." WHERE crp_recepcion_correspondencia.id_tipo_documento=".$desgloce[1];								
								}
						break;
						case "campo2": //estatus
							if($where!="")
								{
									$where = $where." AND crp_asignacion_correspondencia.id_estatus=".$desgloce[1];
								} else {
									$where = $where." WHERE crp_asignacion_correspondencia.id_estatus=".$desgloce[1];								
								}
						break;
						case "campo3"://n_documento
							$sub_desgloce = explode("_",$desgloce[1]);
							if($where!="")
								{	
									$where = $where." AND crp_recepcion_correspondencia.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
								} else {
									$where = $where." WHERE crp_recepcion_correspondencia.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
								}
		
						break;
						case "campo4"://Fecha Registro Y DOCUMENTACION
							if($where!="")
								{
									$where = $where." AND crp_recepcion_correspondencia.id_organismo=".$desgloce[1];
								} else {
									$where = $where." WHERE crp_recepcion_correspondencia.id_organismo=".$desgloce[1];								
								}	
						break;
						case "campo5"://organismo
							$condicionUnidad = $desgloce[1];
							$cc = str_pad($desgloce[1], 2, "0", STR_PAD_LEFT);						
							if($where!="")
								{
									$where = $where." AND (crp_asignacion_correspondencia.id_unidad = ".$desgloce[1]." OR crp_asignacion_correspondencia.copia_unidades like '%$cc%') "; 
								} else {
									$where = $where." WHERE (crp_asignacion_correspondencia.id_unidad = ".$desgloce[1]." OR crp_asignacion_correspondencia.copia_unidades like '%$cc%') "; 							
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
			case "columna1": //Tipo Documento
				$ondicionW = " ORDER BY tipo_documento.tipo_documento $y";
			break;
			case "columna2": //N&deg; Documento
				$ondicionW = "ORDER BY organismo $y";
			break;
			case "columna3"://Organ&iacute;smo / Remitente
				$ondicionW = "ORDER BY crp_recepcion_correspondencia.fecha_registro $y";		
			break;
			case "columna4"://Fecha Registro
				$ondicionW = "ORDER BY crp_recepcion_correspondencia.fecha_documento $y";	
			break;
			case "columna5"://Fecha Documento
				$ondicionW = "ORDER BY Estatus $y";
			break;
			case "columna6"://Tipo Correspondencia
				$ondicionW = "ORDER BY unidad $y";	
			break;
			case "columna7"://Estatus
				$ondicionW = "ORDER BY n_correlativo $y";	
			break;
			case "columna8"://Unidad Asignada
				$ondicionW = "ORDER BY prioridad $y";	
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
					  IF(
						crp_recepcion_correspondencia.id_organismo <> '',
						organismo.organismo,
						crp_recepcion_correspondencia.remitente
					  ) AS organismo, crp_asignacion_correspondencia.id_unidad, 
					  DATE_FORMAT(crp_recepcion_correspondencia.fecha_registro,'%d/%m/%Y %r') AS registro,
					  DATE_FORMAT(crp_recepcion_correspondencia.fecha_documento,'%d/%m/%Y') AS fdocumento,
					  crp_recepcion_correspondencia.fecha_registro,
					  crp_recepcion_correspondencia.fecha_documento,					  
					  IF(crp_recepcion_correspondencia.tipo_correspondencia=0,'Institucional','Personal') AS tipo,
					  IF(unidad.unidad <>'',unidad.unidad,'--') AS unidad, crp_recepcion_correspondencia.n_correlativo, estatus.estatus,crp_asignacion_correspondencia.id_estatus, crp_asignacion_correspondencia.id_prioridad,
					  IF(crp_asignacion_correspondencia.id_prioridad=1, CONCAT('<u>',prioridad.prioridad,'</u> Plazo:',crp_asignacion_correspondencia.plazo,' d&iacute;as'), prioridad.prioridad) AS prioridad, 
					  crp_asignacion_correspondencia.copia_unidades,  
					  IF(DATEDIFF(crp_asignacion_correspondencia.fecha_vencimiento,CURRENT_DATE()) >= 0,'Vigente', IF(crp_asignacion_correspondencia.fecha_vencimiento IS NOT NULL,'Vencida','')) AS estado,
					  DATEDIFF(crp_asignacion_correspondencia.fecha_vencimiento,CURRENT_DATE()) as plazo_trans, DATE_FORMAT(crp_asignacion_correspondencia.fecha_asignacion,'%d/%m/%Y %r') AS asignacion, DATE_FORMAT(crp_asignacion_correspondencia.fecha_vencimiento,'%d/%m/%Y') AS vencimiento, 
					  crp_asignacion_correspondencia.copia_unidades, crp_asignacion_correspondencia.externo, crp_asignacion_correspondencia.habilitado,
					  CONCAT(crp_asignacion_correspondencia.accion,' y ',IF(crp_asignacion_correspondencia.externo = 0,'No Requiere Oficio','Si Requiere Oficio')) AS accion
					  FROM crp_recepcion_correspondencia INNER JOIN
						  tipo_documento ON (crp_recepcion_correspondencia.id_tipo_documento = tipo_documento.id_tipo_documento)
						  LEFT JOIN organismo ON (crp_recepcion_correspondencia.id_organismo = organismo.id_organismo) 
						  LEFT JOIN crp_asignacion_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_asignacion_correspondencia.id_recepcion_correspondencia)
						  LEFT JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad) INNER JOIN estatus ON (crp_asignacion_correspondencia.id_estatus = estatus.id_estatus)
						  LEFT JOIN prioridad ON (crp_asignacion_correspondencia.id_prioridad = prioridad.id_prioridad) 						  
					  $where
					  $ondicionW";
	$rslista->abrir();

?>

<table border="0" class="b_table1" align="center" width="100%" cellpadding="1" cellspacing="1">	
	<tr  height="20">
		<td align="right" colspan="10">
			<table border="0">
				<tr align="center">
					<td>
						<b>Exportar a</b>&nbsp;
					</td>
					<td align="center">
						<img src="images/excel.png" title="Exportar a Excel" onclick="exprt();" style="cursor:pointer" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<b>Total Registros:</b>&nbsp;<? echo "<span class='mensaje'>".$rslista->total_registros."</span>"; ?>
					</td>
				</tr>
			</table>				
		</td>
	</tr>
	<tr height="30" valign="middle" class="trcabecera_list2">
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
			Organ&iacute;smo / Remitente
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
		<td width="80">
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
			<? 
				if ($rslista->fila["unidad"]=="--" && ($rslista->fila["id_estatus"]==5 || $rslista->fila["id_estatus"]==6) ){
					/*if(is_null($rslista->fila["copia_unidades"])==true)
					{*/
						$Var = explode("-",$rslista->fila["copia_unidades"]); 
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
						$unidad_recep ="";
						for($a=0;$a<$rsdocu->total_registros;$a++){
							$rsdocu->siguiente();
							echo $rsdocu->fila["unidad"]."<br>";
							if($unidad_recep == ""){
								$unidad_recep = "-".$rsdocu->fila["unidad"];
							} else {
								$unidad_recep = $unidad_recep."<br>-".$rsdocu->fila["unidad"];
							}
							
						}
						$rsdocu->cerrar();
						unset($rsdocu);
						$Var = "";	
						$SqL = "";
/*					} else {
						
						echo "hola";
					}*/
				} else {
					echo $rslista->fila["unidad"]; 	
					$unidad_recep = $rslista->fila["unidad"];			
				}			
			?>
		</td>
		<td>
			<? echo $rslista->fila["estatus"]; ?>
		</td>
		<td>
			<? if ($rslista->fila["prioridad"]!="") { 
				if ($rslista->fila["id_estatus"]==1 || $rslista->fila["id_estatus"]==2 && $rslista->fila["habilitado"]==0) { echo $rslista->fila["prioridad"]; if ($rslista->fila["estado"]=="Vigente") { echo "<br><b><span class='vigente' style='cursor:help' title='Restan ".$rslista->fila["plazo_trans"]." d&iacute;a(s)'><u>".$rslista->fila["estado"]."</u></span></b>"; } else { echo "<br><b><span class='mensaje' style='cursor:help' title='".substr($rslista->fila["plazo_trans"],1)." d&iacute;a(s)'><u>".$rslista->fila["estado"]."</u></span></b>"; } } else { echo $rslista->fila["prioridad"]; } } else { echo "--";} ?>		
		</td>
		<td>
			<? echo ucwords($rslista->fila["accion"]); ?>
		</td>		
	</tr>
<?	
			}
?>
	<tr><td height="11" colspan="11"></td></tr>		    
<?
		} else {
?>	
	<tr class="trresaltado">
		<td colspan="11">
			No Ex&iacute;sten Datos a Mostrar!!
		</td>																					
	</tr>
<?
}
?>	
</table>		
<form action="" method="post" name="rep" id="rep">
	<input type="hidden" name="p_orden" id="p_orden" value="<? echo stripslashes($_GET["p_orden"]); ?>" />
	<input type="hidden" name="met" id="met" value="<? echo stripslashes($_GET["met"]); ?>" />
	<input type="hidden" name="condiciones" id="condiciones" value="<? echo stripslashes($_GET["condiciones"]); ?>" />
</form>															