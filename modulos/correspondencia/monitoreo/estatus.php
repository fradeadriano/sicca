<?
	require_once("../../../librerias/Recordset.php");	
	$search1 = new Recordset();
	$search1->sql = "SELECT COUNT(crp_asignacion_correspondencia.id_estatus) AS total, estatus.estatus 
					FROM crp_asignacion_correspondencia INNER JOIN estatus ON (crp_asignacion_correspondencia.id_estatus = estatus.id_estatus)
					WHERE DATE_FORMAT(crp_asignacion_correspondencia.`fecha_registro`,'%Y') = DATE_FORMAT(NOW(),'%Y') AND crp_asignacion_correspondencia.`id_estatus` BETWEEN 5 AND 7
					GROUP BY crp_asignacion_correspondencia.id_estatus ORDER BY total DESC";			
	$search1->abrir();
	echo '<link href="../../../css/style.css" rel="stylesheet" type="text/css" />';
?>
			<table>
				<tr class="trcabecera_listEsta1">
					<td align="center" colspan="2">Por Estatus</td>
				</tr>	
				<tr class="trcabecera_list" height="20">
					<td width="180px" align="center">
						Estatus
					</td>
					<td width="30px" align="center">
						Total
					</td>
				</tr>
<?		
		if($search1->total_registros != 0)
		{
			$toCO = 0;
			for($i=0;$i<$search1->total_registros;$i++)
			{
				$search1->siguiente();
?>	
				<tr <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
					<td align="center"><? echo $search1->fila["estatus"]; ?></td>				
					<td align="center"><? echo $search1->fila["total"]; ?></td>
				</tr>
<?			
				$toCO = $toCO+$search1->fila["total"]; 
			}
?>
				<tr><td height="2"></td></tr>
				<tr bgcolor="#FFD1A4">
					<td align="center"><b>Total Correspondencias</b></td>				
					<td align="center"><b><? echo $toCO; ?></b></td>
				</tr>

<?			
		} else {
?>				
				<tr>
					<td align="center" colspan="2">No ex&iacute;sten datos a mostrar!!</td>
				</tr>	
<?		
		}
?>
			</table>
<?
		$search1->cerrar();
		unset($search1);
?>