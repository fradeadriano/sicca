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
		$where = " WHERE crp_recepcion_correspondencia.id_organismo=".$sub_desgloce[1];								
	} else if($sub_desgloce[0] == "campo2"){
		$where = " WHERE crp_asignacion_correspondencia.id_unidad=".$sub_desgloce[1];									
	}
	
	$sub_sub_desgloce = explode(":",$desgloce[1]);									
	$where = $where." AND LEFT(crp_recepcion_correspondencia.n_correlativo,4)=".$sub_sub_desgloce[1];
	
	$rslista->sql = "SELECT crp_recepcion_correspondencia.n_correlativo, crp_recepcion_correspondencia.id_recepcion_correspondencia,IF(crp_recepcion_correspondencia.id_organismo <> '', organismo.organismo, crp_recepcion_correspondencia.remitente) AS organismo,
							  crp_asignacion_correspondencia.id_unidad,DATE_FORMAT(crp_recepcion_correspondencia.fecha_registro,'%d/%m/%Y %r') AS registro,crp_recepcion_correspondencia.fecha_registro,
							  IF(unidad.unidad <> '',unidad.unidad,'--') AS unidad,DATE_FORMAT(crp_asignacion_correspondencia.fecha_asignacion,'%d/%m/%Y %r') AS asignacion,
							  crp_asignacion_correspondencia.id_estatus, crp_asignacion_correspondencia.copia_unidades
						FROM crp_recepcion_correspondencia LEFT JOIN organismo ON (crp_recepcion_correspondencia.id_organismo = organismo.id_organismo) 
						  LEFT JOIN crp_asignacion_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_asignacion_correspondencia.id_recepcion_correspondencia) 
						  LEFT JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad) 
					  $where ORDER BY crp_recepcion_correspondencia.n_correlativo DESC";
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
		<td width="250">
			Organ&iacute;smo / Remitente
		</td>
		<td width="150">
			Unidad Administrativa
		</td>
		<td width="120">
			Fecha / Hora Registro
		</td>
		<td width="120">
			Fecha / Hora Asignaci&oacute;n
		</td>
		<td width="60">Acci&oacute;n</td>
	</tr>
	<tr><td colspan="6"></td></tr>
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
			<? echo ucwords(mb_strtolower($rslista->fila["organismo"])); ?>
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
			<? echo $rslista->fila["registro"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["asignacion"]; ?>
		</td>
		<td>
			<img src="images/grant.jpg" title="Graficar Correspondencia" onclick="graphi_s('<? echo $rslista->fila["id_recepcion_correspondencia"]; ?>');" style="cursor:pointer" />
		</td>
	</tr>
<?	
			}
?>
	<tr><td height="11" colspan="6"></td></tr>		    
<?
		} else {
?>	
	<tr class="trresaltado">
		<td colspan="6">
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