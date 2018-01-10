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
						case "campo1"://fecha
							$sub_desgloce = explode("_",$desgloce[1]);
							$where = $where." WHERE crp_recepcion_correspondencia.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
						break;
						case "campo2": //que totalizar
							if($desgloce[1]=="todos"){
								$cant=4;
							} else {
								$cant=1;
								$elname = $desgloce[1]; 
							}
						break;
					}	
			}
	}
?>
<table border="0" class="b_table1" align="center" width="100%" cellpadding="1" cellspacing="1">	
	<tr  height="20">
		<td align="right" colspan="10" bgcolor="#EEF7F9">
			<table border="0" >
				<tr align="center">
					<td>
						<b>Exportar a</b>&nbsp;
					</td>
					<td align="center">
						<img src="images/excel.png" title="Exportar a Excel" onclick="exprt();" style="cursor:pointer" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<b>Graficar</b>&nbsp;
					</td>
					<td align="center">
						<img src="images/Ba.png" title="Graficar Resultados" onclick="graphi_s();" style="cursor:pointer" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
			</table>				
		</td>
	</tr>
	<tr><td height="5"></td></tr>
	<tr>
		<td align="center">
<?
			if($cant==4){
?>			
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="3" align="center">
			<br />
			<table class="b_table" width="400">
				<tr>
					<td colspan="2" align="center" height="20" bgcolor="#EBEBEB"><b>Totalizaci&oacute;n Correspondencia a la Fecha Solicitada</b></td>
				</tr>
				<tr class="trcabecera_list1">
					<td width="20">Total</td>
				</tr>
<?	
				$rslista->sql = "SELECT COUNT(crp_recepcion_correspondencia.`id_recepcion_correspondencia`) AS total_co
									FROM crp_recepcion_correspondencia 
									$where
									ORDER BY total_co DESC";
				$rslista->abrir();				
				if($rslista->total_registros > 0)
					{	
						for ($i=1;$i<=$rslista->total_registros;$i++)
						{
							$rslista->siguiente();	
?>							
							<tr height="20" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
								<td>
									<? echo $rslista->fila["total_co"]; ?>
								</td>										
							</tr>
<?	
						}
					$rslista->cerrar();
					unset($rslista);						
					} else {
					
						echo "<tr><td align='center'>No ex&iacute;sten Datos a Mostrar</td></tr>";
					}
?>				
			</table>
					<br />
					</td>
				</tr>
				<tr><td valign="top">
				<br />
			<table class="b_table" width="450">
				<tr>
					<td colspan="2" align="center" height="20" bgcolor="#A4D1FF"><b>Totalizaci&oacute;n por Organ&iacute;smo</b></td>
				</tr>
				<tr class="trcabecera_list1">
					<td width="530">Organ&iacute;smo</td>
					<td width="20">Totales</td>
				</tr>
<?	
				$rslista = new Recordset();
				$rslista->sql = "SELECT COUNT(crp_recepcion_correspondencia.`id_recepcion_correspondencia`) AS total_organismo, crp_recepcion_correspondencia.`id_organismo`, 
									organismo.`organismo`  
									FROM crp_recepcion_correspondencia INNER JOIN organismo ON (crp_recepcion_correspondencia.`id_organismo` = organismo.`id_organismo`)
									$where
									GROUP BY crp_recepcion_correspondencia.`id_organismo` ORDER BY total_organismo DESC";
				$rslista->abrir();				
				if($rslista->total_registros > 0)
					{	
						for ($i=1;$i<=$rslista->total_registros;$i++)
						{
							$rslista->siguiente();	
?>							
							<tr height="20" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
								<td>
									<? echo $rslista->fila["organismo"]; ?>
								</td>										
								<td>
									<? echo $rslista->fila["total_organismo"]; ?>
								</td>
							</tr>
<?	
						}
					$rslista->cerrar();
					unset($rslista);						
					} else {
					
						echo "<tr><td colspan='2' align='center'>No ex&iacute;sten Datos a Mostrar</td></tr>";
					}
?>				
			</table>
			<br />
			</td>
			<td width="30"></td>
			<td valign="top">
			<br />
			<table class="b_table" width="300">
				<tr>
					<td colspan="2" align="center" height="20" bgcolor="#E1FFE1"><b>Totalizaci&oacute;n por Unidades Administrativas</b></td>
				</tr>
				<tr class="trcabecera_list1">
					<td width="530">Unidad</td>
					<td width="20">Totales</td>
				</tr>
<?	
				$rslista = new Recordset();
				$rslista->sql = "SELECT COUNT(crp_asignacion_correspondencia.`id_asignacion_correspondencia`) AS total_unidad_asig, crp_asignacion_correspondencia.`id_unidad`, unidad.`unidad`
								FROM crp_asignacion_correspondencia INNER JOIN unidad ON (crp_asignacion_correspondencia.`id_unidad` = unidad.`id_unidad`)
								INNER JOIN crp_recepcion_correspondencia  ON (crp_asignacion_correspondencia.`id_asignacion_correspondencia` = crp_recepcion_correspondencia.`id_recepcion_correspondencia`)			
								$where
								GROUP BY crp_asignacion_correspondencia.`id_unidad` ORDER BY total_unidad_asig DESC";
				$rslista->abrir();				
				if($rslista->total_registros > 0)
					{	
						for ($i=1;$i<=$rslista->total_registros;$i++)
						{
							$rslista->siguiente();	
?>							
							<tr height="20" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
								<td>
									<? echo $rslista->fila["unidad"]; ?>
								</td>										
								<td>
									<? echo $rslista->fila["total_unidad_asig"]; ?>
								</td>
							</tr>
<?	
						}
					$rslista->cerrar();
					unset($rslista);						
					} else {
					
						echo "<tr><td colspan='2' align='center'>No ex&iacute;sten Datos a Mostrar</td></tr>";
					}
?>				
			</table>
			<br /><br />
			<table class="b_table" width="300">
				<tr>
					<td colspan="2" align="center" height="20" bgcolor="#FFDDBB"><b>Totalizaci&oacute;n por Estatus</b></td>
				</tr>
				<tr class="trcabecera_list1">
					<td width="530">Estatus</td>
					<td width="20">Totales</td>
				</tr>
<?	
				$rslista = new Recordset();
				$rslista->sql = "SELECT COUNT(crp_asignacion_correspondencia.`id_asignacion_correspondencia`) AS total_estatus, crp_asignacion_correspondencia.`id_estatus`, estatus.`estatus`
									FROM crp_asignacion_correspondencia INNER JOIN estatus ON (crp_asignacion_correspondencia.`id_estatus` = estatus.`id_estatus`)
									INNER JOIN crp_recepcion_correspondencia  ON (crp_asignacion_correspondencia.`id_asignacion_correspondencia` = crp_recepcion_correspondencia.`id_recepcion_correspondencia`)
									$where
									GROUP BY crp_asignacion_correspondencia.`id_estatus`
									ORDER BY total_estatus DESC";
				$rslista->abrir();				
				if($rslista->total_registros > 0)
					{	
						for ($i=1;$i<=$rslista->total_registros;$i++)
						{
							$rslista->siguiente();	
?>							
							<tr height="20" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
								<td>
									<? echo $rslista->fila["estatus"]; ?>
								</td>										
								<td>
									<? echo $rslista->fila["total_estatus"]; ?>
								</td>
							</tr>
<?	
						}
					$rslista->cerrar();
					unset($rslista);						
					} else {
					
						echo "<tr><td colspan='2' align='center'>No ex&iacute;sten Datos a Mostrar</td></tr>";
					}
?>				
			</table>
			<br /><br />
			<table class="b_table" width="300">
				<tr>
					<td colspan="2" align="center" height="20" bgcolor="#FFFFC6"><b>Totalizaci&oacute;n por Prioridad</b></td>
				</tr>
				<tr class="trcabecera_list1">
					<td width="530">Prioridad</td>
					<td width="20">Totales</td>
				</tr>
<?	
				$rslista = new Recordset();
				$rslista->sql = "SELECT COUNT(crp_asignacion_correspondencia.`id_asignacion_correspondencia`) AS total_prioridad, 
									crp_asignacion_correspondencia.`id_prioridad`, IF(prioridad.`prioridad` IS NULL,'No Establecida', prioridad.`prioridad`) AS prioridad
									FROM crp_asignacion_correspondencia LEFT JOIN prioridad ON (crp_asignacion_correspondencia.`id_prioridad` = prioridad.`id_prioridad`)
									INNER JOIN crp_recepcion_correspondencia  ON (crp_asignacion_correspondencia.`id_asignacion_correspondencia` = crp_recepcion_correspondencia.`id_recepcion_correspondencia`)
									$where
									GROUP BY crp_asignacion_correspondencia.`id_prioridad`
									ORDER BY total_prioridad DESC";
				$rslista->abrir();				
				if($rslista->total_registros > 0)
					{	
						for ($i=1;$i<=$rslista->total_registros;$i++)
						{
							$rslista->siguiente();	
?>							
							<tr height="20" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
								<td>
									<? echo $rslista->fila["prioridad"]; ?>
								</td>										
								<td>
									<? echo $rslista->fila["total_prioridad"]; ?>
								</td>
							</tr>
<?	
						}
					$rslista->cerrar();
					unset($rslista);						
					} else {
					
						echo "<tr><td colspan='2' align='center'>No ex&iacute;sten Datos a Mostrar</td></tr>";
					}
?>				
			</table>															
			</td></tr></table>
<?			
			} else if ($cant==1){
				if($elname=="estatus")
				{
?>		
					<table class="b_table" width="300">
						<tr>
							<td colspan="2" align="center" height="20" bgcolor="#FFDDBB"><b>Totalizaci&oacute;n por Estatus</b></td>
						</tr>
						<tr class="trcabecera_list1">
							<td width="530">Estatus</td>
							<td width="20">Totales</td>
						</tr>
<?	
						$rslista = new Recordset();
						$rslista->sql = "SELECT COUNT(crp_asignacion_correspondencia.`id_asignacion_correspondencia`) AS total_estatus, crp_asignacion_correspondencia.`id_estatus`, estatus.`estatus`
											FROM crp_asignacion_correspondencia INNER JOIN estatus ON (crp_asignacion_correspondencia.`id_estatus` = estatus.`id_estatus`)
											INNER JOIN crp_recepcion_correspondencia  ON (crp_asignacion_correspondencia.`id_asignacion_correspondencia` = crp_recepcion_correspondencia.`id_recepcion_correspondencia`)
											$where
											GROUP BY crp_asignacion_correspondencia.`id_estatus`
											ORDER BY total_estatus DESC";
						$rslista->abrir();				
						if($rslista->total_registros > 0)
							{	
								for ($i=1;$i<=$rslista->total_registros;$i++)
								{
									$rslista->siguiente();	
?>							
									<tr height="20" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
										<td>
											<? echo $rslista->fila["estatus"]; ?>
										</td>										
										<td>
											<? echo $rslista->fila["total_estatus"]; ?>
										</td>
									</tr>
<?	
								}
							$rslista->cerrar();
							unset($rslista);						
							} else {
							
								echo "<tr><td colspan='2' align='center'>No ex&iacute;sten Datos a Mostrar</td></tr>";
							}
?>				
					</table>
<?			
				} else if ($elname=="organismo"){
?>			
					<table class="b_table" width="450">
						<tr>
							<td colspan="2" align="center" height="20" bgcolor="#A4D1FF"><b>Totalizaci&oacute;n por Organ&iacute;smo</b></td>
						</tr>
						<tr class="trcabecera_list1">
							<td width="530">Organ&iacute;smo</td>
							<td width="20">Totales</td>
						</tr>
<?	
						$rslista = new Recordset();
						$rslista->sql = "SELECT COUNT(crp_recepcion_correspondencia.`id_recepcion_correspondencia`) AS total_organismo, crp_recepcion_correspondencia.`id_organismo`, 
											organismo.`organismo`  
											FROM crp_recepcion_correspondencia INNER JOIN organismo ON (crp_recepcion_correspondencia.`id_organismo` = organismo.`id_organismo`)
											$where
											GROUP BY crp_recepcion_correspondencia.`id_organismo` ORDER BY total_organismo DESC";
						$rslista->abrir();				
						if($rslista->total_registros > 0)
							{	
								for ($i=1;$i<=$rslista->total_registros;$i++)
								{
									$rslista->siguiente();	
?>							
									<tr height="20" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
										<td>
											<? echo $rslista->fila["organismo"]; ?>
										</td>										
										<td>
											<? echo $rslista->fila["total_organismo"]; ?>
										</td>
									</tr>
<?	
								}
							$rslista->cerrar();
							unset($rslista);						
							} else {
							
								echo "<tr><td colspan='2' align='center'>No ex&iacute;sten Datos a Mostrar</td></tr>";
							}
?>				
					</table>			
<?
				} else if ($elname=="unidad"){
?>
					<table class="b_table" width="300">
						<tr>
							<td colspan="2" align="center" height="20" bgcolor="#E1FFE1"><b>Totalizaci&oacute;n por Unidades Administrativas</b></td>
						</tr>
						<tr class="trcabecera_list1">
							<td width="530">Unidad</td>
							<td width="20">Totales</td>
						</tr>
<?	
						$rslista = new Recordset();
						$rslista->sql = "SELECT COUNT(crp_asignacion_correspondencia.`id_asignacion_correspondencia`) AS total_unidad_asig, crp_asignacion_correspondencia.`id_unidad`, unidad.`unidad`
										FROM crp_asignacion_correspondencia INNER JOIN unidad ON (crp_asignacion_correspondencia.`id_unidad` = unidad.`id_unidad`)
										INNER JOIN crp_recepcion_correspondencia  ON (crp_asignacion_correspondencia.`id_asignacion_correspondencia` = crp_recepcion_correspondencia.`id_recepcion_correspondencia`)			
										$where
										GROUP BY crp_asignacion_correspondencia.`id_unidad` ORDER BY total_unidad_asig DESC";
						$rslista->abrir();				
						if($rslista->total_registros > 0)
							{	
								for ($i=1;$i<=$rslista->total_registros;$i++)
								{
									$rslista->siguiente();	
?>							
									<tr height="20" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
										<td>
											<? echo $rslista->fila["unidad"]; ?>
										</td>										
										<td>
											<? echo $rslista->fila["total_unidad_asig"]; ?>
										</td>
									</tr>
<?	
								}
							$rslista->cerrar();
							unset($rslista);						
							} else {
							
								echo "<tr><td colspan='2' align='center'>No ex&iacute;sten Datos a Mostrar</td></tr>";
							}
?>				
					</table>
<?				
				} else if ($elname=="prioridad"){ 
?>
					<table class="b_table" width="300">
						<tr>
							<td colspan="2" align="center" height="20" bgcolor="#FFFFC6"><b>Totalizaci&oacute;n por Prioridad</b></td>
						</tr>
						<tr class="trcabecera_list1">
							<td width="530">Prioridad</td>
							<td width="20">Totales</td>
						</tr>
<?	
						$rslista = new Recordset();
						$rslista->sql = "SELECT COUNT(crp_asignacion_correspondencia.`id_asignacion_correspondencia`) AS total_prioridad, 
											crp_asignacion_correspondencia.`id_prioridad`, IF(prioridad.`prioridad` IS NULL,'No Establecida', prioridad.`prioridad`) AS prioridad
											FROM crp_asignacion_correspondencia LEFT JOIN prioridad ON (crp_asignacion_correspondencia.`id_prioridad` = prioridad.`id_prioridad`)
											INNER JOIN crp_recepcion_correspondencia  ON (crp_asignacion_correspondencia.`id_asignacion_correspondencia` = crp_recepcion_correspondencia.`id_recepcion_correspondencia`)
											$where
											GROUP BY crp_asignacion_correspondencia.`id_prioridad`
											ORDER BY total_prioridad DESC";
						$rslista->abrir();				
						if($rslista->total_registros > 0)
							{	
								for ($i=1;$i<=$rslista->total_registros;$i++)
								{
									$rslista->siguiente();	
?>							
									<tr height="20" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
										<td>
											<? echo $rslista->fila["prioridad"]; ?>
										</td>										
										<td>
											<? echo $rslista->fila["total_prioridad"]; ?>
										</td>
									</tr>
<?	
								}
							$rslista->cerrar();
							unset($rslista);						
							} else {
							
								echo "<tr><td colspan='2' align='center'>No ex&iacute;sten Datos a Mostrar</td></tr>";
							}
?>				
					</table>															
<?				
				}
			}
?>		
		<br />
		</td>
	</tr>
</table>		
<form action="" method="post" name="rep" id="rep">
	<input type="hidden" name="condiciones" id="condiciones" value="<? echo stripslashes($_GET["condiciones"]); ?>" />
</form>		
<form action="" method="post" name="gra" id="gra">
	<input type="hidden" name="condiciones" id="condiciones" value="<? echo stripslashes($_GET["condiciones"]); ?>" />
</form>													