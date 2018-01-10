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
$z = stripslashes($_GET["condicion"]);
//echo $z;
$rslista = new Recordset();
									
if (isset($z) && $z!=""){						
	$desgloce = explode("!",$z);									
	$sub_desgloce = explode(":",$desgloce[0]);									

	if($sub_desgloce[0] == "campo1"){
		$where = " WHERE crp_recepcion_correspondencia_cgr.id_organismo_cgr=".$sub_desgloce[1];								
	} else if($sub_desgloce[0] == "campo2"){
		$where = " WHERE crp_asignacion_correspondencia_cgr.id_unidad=".$sub_desgloce[1];									
	}
	
	$sub_sub_desgloce = explode(":",$desgloce[1]);									

	$where = $where." AND LEFT(crp_recepcion_correspondencia_cgr.n_correlativo,4)=".$sub_sub_desgloce[1];
	
	$rslista->sql = "SELECT crp_recepcion_correspondencia_cgr.`n_correlativo`, crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`, 
						crp_recepcion_correspondencia_cgr.`n_oficio_circular`, unidad.`unidad`, organismo.`organismo`,
						DATE_FORMAT(crp_recepcion_correspondencia_cgr.`fecha_registro`,'%d/%m/%Y %r') AS f_registro, 
						DATE_FORMAT(crp_recepcion_correspondencia_cgr.`fecha_documento`,'%d/%m/%Y') AS f_documento
					FROM crp_recepcion_correspondencia_cgr 
						INNER JOIN crp_asignacion_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr` = crp_asignacion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)
						INNER JOIN unidad ON (crp_asignacion_correspondencia_cgr.`id_unidad` = unidad.`id_unidad`)
						INNER JOIN organismo ON (crp_recepcion_correspondencia_cgr.`id_organismo_cgr` = organismo.`id_organismo`)
					  $where ORDER BY crp_recepcion_correspondencia_cgr.n_correlativo DESC";
	$rslista->abrir();
?>

<table border="0" class="b_table1" align="center" width="100%" cellpadding="1" cellspacing="1">	
	<tr  height="20">
		<td align="right" colspan="10">
			<table border="0">
				<tr align="center">
<!--					<td>
						<b>Exportar a</b>&nbsp;
					</td>
					<td align="center">
						<img src="images/excel.png" title="Exportar a Excel" onclick="exprt();" style="cursor:pointer" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>-->
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
		<td width="90">
			N&deg; Oficio/Circular
		</td>	
		<td width="190">
			Direcci&oacute;n
		</td>
		<td width="150">
			Unidad Administrativa
		</td>
		<td width="130">
			Fecha / Hora Registro
		</td>
		<td width="100">
			Fecha Documento
		</td>
		<td width="60">Acci&oacute;n</td>
	</tr>
	<tr><td colspan="7"></td></tr>
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
			<? echo $rslista->fila["n_oficio_circular"]; ?>
		</td>		
		<td>
			<? echo ucwords(mb_strtolower($rslista->fila["organismo"])); ?>
		</td>
		<td>
			<? 
				echo $rslista->fila["unidad"]; 	
			?>
		</td>		
		<td>
			<? echo $rslista->fila["f_registro"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["f_documento"]; ?>
		</td>
		<td>
			<img src="images/grant.jpg" title="Graficar Correspondencia" onclick="graphi_s('<? echo $rslista->fila["id_recepcion_correspondencia_cgr"]; ?>');" style="cursor:pointer" />
		</td>
	</tr>
<?	
			}
?>
	<tr><td height="11" colspan="7"></td></tr>		    
<?
		} else {
?>	
	<tr class="trresaltado">
		<td colspan="7">
			No Ex&iacute;sten Datos a Mostrar!!
		</td>																					
	</tr>
<?
}

}
?>	
</table>		
<form action="" method="post" name="gra" id="gra">
	<input type="hidden" name="condiciones" id="condiciones" />
</form>															