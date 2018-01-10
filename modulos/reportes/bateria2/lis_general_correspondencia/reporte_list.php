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
									$where = $where." AND crp_recepcion_correspondencia_cgr.id_tipo_documento=".$desgloce[1];
								} else {
									$where = $where." WHERE crp_recepcion_correspondencia_cgr.id_tipo_documento=".$desgloce[1];								
								}
						break;
						case "campo2": //estatus
							if($where!="")
								{
									$where = $where." AND crp_asignacion_correspondencia_cgr.id_estatus=".$desgloce[1];
								} else {
									$where = $where." WHERE crp_asignacion_correspondencia_cgr.id_estatus=".$desgloce[1];								
								}
						break;
						case "campo3"://n_documento
							$sub_desgloce = explode("_",$desgloce[1]);
							if($where!="")
								{	
									$where = $where." AND crp_recepcion_correspondencia_cgr.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
								} else {
									$where = $where." WHERE crp_recepcion_correspondencia_cgr.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
								}
		
						break;
						case "campo4"://Fecha Registro Y DOCUMENTACION
							if($where!="")
								{
									$where = $where." AND crp_recepcion_correspondencia_cgr.id_organismo_cgr=".$desgloce[1];
								} else {
									$where = $where." WHERE crp_recepcion_correspondencia_cgr.id_organismo_cgr=".$desgloce[1];								
								}	
						break;
						case "campo5"://organismo
							$condicionUnidad = $desgloce[1];
							$cc = str_pad($desgloce[1], 2, "0", STR_PAD_LEFT);						
							if($where!="")
								{
									$where = $where." AND crp_asignacion_correspondencia_cgr.id_unidad = ".$desgloce[1]; 
								} else {
									$where = $where." WHERE crp_asignacion_correspondencia_cgr.id_unidad = ".$desgloce[1]; 							
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
				$ondicionW = "ORDER BY crp_recepcion_correspondencia_cgr.fecha_registro $y";		
			break;
			case "columna4"://Fecha Registro
				$ondicionW = "ORDER BY crp_recepcion_correspondencia_cgr.fecha_documento $y";	
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
			case "columna8"://Estatus
				$ondicionW = "ORDER BY oficioCircular $y";	
			break;			
			default:
				$ondicionW = "ORDER BY fecha_registro $y";
			break;
		}	
	}

	$rslista->sql = " SELECT crp_recepcion_correspondencia_cgr.`n_correlativo`, tipo_documento.`tipo_documento`, 
							IF(crp_recepcion_correspondencia_cgr.n_oficio_circular='','--',crp_recepcion_correspondencia_cgr.n_oficio_circular) AS oficioCircular,
							organismo.`organismo`,
							DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_registro,'%d/%m/%Y %r') AS f_registro, 
							DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_documento,'%d/%m/%Y') AS f_documento, 
							unidad.`unidad`, estatus.`estatus`, crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`, 
							crp_recepcion_correspondencia_cgr.id_tipo_documento, crp_recepcion_correspondencia_cgr.fecha_registro,
							crp_recepcion_correspondencia_cgr.fecha_documento, crp_recepcion_correspondencia_cgr.id_organismo_cgr   
						FROM crp_recepcion_correspondencia_cgr 
							INNER JOIN tipo_documento ON (crp_recepcion_correspondencia_cgr.`id_tipo_documento` = tipo_documento.`id_tipo_documento`)
							INNER JOIN organismo ON (crp_recepcion_correspondencia_cgr.`id_organismo_cgr` = organismo.`id_organismo`)
							INNER JOIN crp_asignacion_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr` = crp_asignacion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)
							INNER JOIN unidad ON (crp_asignacion_correspondencia_cgr.`id_unidad` = unidad.`id_unidad`)		
							INNER JOIN estatus ON (crp_asignacion_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
		 						  
					  $where
					  $ondicionW";
	$rslista->abrir();

?>

<table border="0" class="b_table1" align="center" width="100%" cellpadding="1" cellspacing="1">	
	<tr  height="20">
		<td align="right" colspan="7">
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
		<td width="100">
			Tipo Documento
		</td>
		<td width="100">
			N&deg; Oficio/Circular
		</td>
		<td width="180">
			Direcci&oacute;n Remitente
		</td>
		<td width="120">
			Fecha / Hora Registro
		</td>
		<td width="120">
			Fecha Documento
		</td>
		<td width="180">
			Unidad Administrativa
		</td>
		<td width="70">
			Estatus
		</td>
	</tr>
	<tr><td colspan="8"></td></tr>
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
			<? echo $rslista->fila["oficioCircular"]; ?>
		</td>
		<td>
			<? echo ucwords(mb_strtolower($rslista->fila["organismo"])); ?>
		</td>
		<td>
			<? echo $rslista->fila["f_registro"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["f_documento"]; ?>
		</td>
		<td>
			<? 
				echo $rslista->fila["unidad"]; 	
			?>
		</td>
		<td>
			<? echo $rslista->fila["estatus"]; ?>
		</td>		
	</tr>
<?	
			}
?>
	<tr><td height="11" colspan="8"></td></tr>		    
<?
		} else {
?>	
	<tr class="trresaltado">
		<td colspan="8">
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