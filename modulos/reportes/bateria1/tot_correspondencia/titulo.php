<?
require_once("../../../../librerias/Recordset.php");
$z = stripslashes($_POST["condiciones"]);
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
							$campo1 = "?campo1=".$desgloce[1];
							$sub_desgloce = explode("_",$desgloce[1]);
							$where = $where." WHERE crp_recepcion_correspondencia.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
							$critk = "Fecha ".$sub_desgloce[0].": ".$sub_desgloce[1]." y ".$sub_desgloce[2];
						break;
						case "campo2": //que totalizar
							if($desgloce[1]=="todos"){
								$cant=4;
								$critk = $critk.", Totalizaci&oacute;n por organ&iacute;smo, unidades administrativas, estatus, prioridad";
							} else {
								$cant=1;
								$elname = $desgloce[1]; 
								$critk = $critk.", Totalizaci&oacute;n por ".$desgloce[1];
							}
						break;
					}	
			}
	}
?>
<link href="../../../../css/style.css" rel="stylesheet" type="text/css" />
<table width="80%" class="b_table" align="center" border="0">
	<tr>
		<td align="center">
			<table width="90%" border="0" align="center" >
				<tr>
				  <td valign="middle" align="center" width="360"><img src="../../../../images/logo_reporte.jpg" width="160"></td>
					<td align="center" valign="middle">
					  <div class="titulomenu" style="font-size:18px">Contraloria del estado Aragua</div>
					  <div style="font-size:12px">
					  <br />
							<b>Despacho del Contralor</b>
					  </div>
					</td>
					<td width="100"></td>
				</tr>
				<tr>
					<td colspan="3" align="center" height="40">
						<div class="titulomenu" style="font-size:18px">Totalizaci&oacute;n Correspondencia</div>					
					</td>
				</tr>					
				<tr>
					<td colspan="3" align="left">
						<div class="titulomenu" style="font-size:9px">Criterios B&uacute;squeda: <? echo $critk; ?></div>					
					</td>
				</tr>
				<tr>
				  <td colspan="3"><hr /></td>
				</tr>		
			</table>		
		</td>
	</tr>
<!--	<tr>
		<td align="center"><div class="titulomenu" style="font-size:12px">Totalizaciones</div></td>
	</tr>-->	
	<tr>
		<td align="center">
<?
			if($cant==4){
?>			
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="3" align="center" valign="top">
						<table class="b_table" >
							<tr>
								<td colspan="2" align="center" height="20" bgcolor="#A4D1FF"><b>Totalizaci&oacute;n por Estatus</b></td>
							</tr>
							<tr class="trcabecera_list1">
								<td width="330">Estatus</td>
								<td width="20">Totales</td>
							</tr>
			<?	
							$rslista = new Recordset();
							$rslista->sql = "SELECT COUNT(crp_asignacion_correspondencia.`id_asignacion_correspondencia`) AS total_estatus, estatus.`estatus`
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
					</td>
					<td width="10"></td>
					<td align="center" valign="top">
						<!--<div class="titulomenu" style="font-size:12px">Gr&aacute;fico</div>-->
						<img src="grafico.php<? echo $campo1."&tipo=estatus"; ?>" />
					</td>
				</tr>
			</table>
			<br /><hr style="width:900px" /><br />
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="3" align="center" valign="top">
						<table class="b_table" >
							<tr>
								<td colspan="2" align="center" height="20" bgcolor="#A4D1FF"><b>Totalizaci&oacute;n por Organ&iacute;smo</b></td>
							</tr>
							<tr class="trcabecera_list1">
								<td width="330">Organ&iacute;smo</td>
								<td width="20">Totales</td>
							</tr>
			<?	
							$rslista = new Recordset();
							$rslista->sql = "SELECT COUNT(crp_recepcion_correspondencia.`id_recepcion_correspondencia`) AS total_organismo, crp_recepcion_correspondencia.`id_organismo`, 
												organismo.`organismo`  
												FROM crp_recepcion_correspondencia INNER JOIN organismo ON (crp_recepcion_correspondencia.`id_organismo` = organismo.`id_organismo`)
												$where
												GROUP BY crp_recepcion_correspondencia.`id_organismo` ORDER BY total_organismo DESC limit 10";
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
					</td>
					<td width="10"></td>
					<td align="center" valign="top">
						<!--<div class="titulomenu" style="font-size:12px">Gr&aacute;fico</div>-->
						
						<img src="grafico.php<? echo $campo1."&tipo=organismo"; ?>" />
					</td>
				</tr>
			</table>
			<br /><hr style="width:900px" /><br />
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="3" align="center" valign="top">
						<table class="b_table" >
							<tr>
								<td colspan="2" align="center" height="20" bgcolor="#A4D1FF"><b>Totalizaci&oacute;n por Unidad Administrativa</b></td>
							</tr>
							<tr class="trcabecera_list1">
								<td width="330">Unidad</td>
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
					</td>
					<td width="10"></td>
					<td align="center" valign="top">
						<!--<div class="titulomenu" style="font-size:12px">Gr&aacute;fico</div>-->
						
						<img src="grafico.php<? echo $campo1."&tipo=unidad"; ?>" />
					</td>
				</tr>
			</table>
			<br /><hr style="width:900px" /><br />
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="3" align="center" valign="top">
						<table class="b_table" >
							<tr>
								<td colspan="2" align="center" height="20" bgcolor="#A4D1FF"><b>Totalizaci&oacute;n por Prioridad</b></td>
							</tr>
							<tr class="trcabecera_list1">
								<td width="330">Prioridad</td>
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
					</td>
					<td width="10"></td>
					<td align="center" valign="top">
						<!--<div class="titulomenu" style="font-size:12px">Gr&aacute;fico</div>-->
						
						<img src="grafico.php<? echo $campo1."&tipo=prioridad"; ?>" />
					</td>
				</tr>
			</table>			
<?
			} else if ($cant==1){
				if($elname=="estatus")
				{			
	?>	
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td colspan="3" align="center" valign="top">
							<table class="b_table" >
								<tr>
									<td colspan="2" align="center" height="20" bgcolor="#FFDDBB"><b>Totalizaci&oacute;n por Estatus</b></td>
								</tr>
								<tr class="trcabecera_list1">
									<td width="330">Estatus</td>
									<td width="20">Totales</td>
								</tr>
				<?	
								$rslista = new Recordset();
								$rslista->sql = "SELECT COUNT(crp_asignacion_correspondencia.`id_asignacion_correspondencia`) AS total_estatus, estatus.`estatus`
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
						</td>
						<td width="10"></td>
						<td align="center" valign="top">
							<!--<div class="titulomenu" style="font-size:12px">Gr&aacute;fico</div>-->
							<img src="grafico.php<? echo $campo1."&tipo=estatus"; ?>" />
						</td>
					</tr>
				</table>
	<? 
				} else if ($elname=="organismo"){
	?>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td colspan="3" align="center" valign="top">
							<table class="b_table" >
								<tr>
									<td colspan="2" align="center" height="20" bgcolor="#A4D1FF"><b>Totalizaci&oacute;n por Organ&iacute;smo</b></td>
								</tr>
								<tr class="trcabecera_list1">
									<td width="330">Organ&iacute;smo</td>
									<td width="20">Totales</td>
								</tr>
				<?	
								$rslista = new Recordset();
								$rslista->sql = "SELECT COUNT(crp_recepcion_correspondencia.`id_recepcion_correspondencia`) AS total_organismo, crp_recepcion_correspondencia.`id_organismo`, 
													organismo.`organismo`  
													FROM crp_recepcion_correspondencia INNER JOIN organismo ON (crp_recepcion_correspondencia.`id_organismo` = organismo.`id_organismo`)
													$where
													GROUP BY crp_recepcion_correspondencia.`id_organismo` ORDER BY total_organismo DESC limit 10";
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
						</td>
						<td width="10"></td>
						<td align="center" valign="top">
							<!--<div class="titulomenu" style="font-size:12px">Gr&aacute;fico</div>-->
							
							<img src="grafico.php<? echo $campo1."&tipo=organismo"; ?>" />
						</td>
					</tr>
				</table>
<?
				} else if ($elname=="unidad"){
?>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td colspan="3" align="center" valign="top">
							<table class="b_table" >
								<tr>
									<td colspan="2" align="center" height="20" bgcolor="#E1FFE1"><b>Totalizaci&oacute;n por Unidad Administrativa</b></td>
								</tr>
								<tr class="trcabecera_list1">
									<td width="330">Unidad</td>
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
						</td>
						<td width="10"></td>
						<td align="center" valign="top">
							<!--<div class="titulomenu" style="font-size:12px">Gr&aacute;fico</div>-->
							
							<img src="grafico.php<? echo $campo1."&tipo=unidad"; ?>" />
						</td>
					</tr>
				</table>
	<?
				} else if ($elname=="prioridad"){ 
	?>			
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td colspan="3" align="center" valign="top">
							<table class="b_table" >
								<tr>
									<td colspan="2" align="center" height="20" bgcolor="#FFFFC6"><b>Totalizaci&oacute;n por Prioridad</b></td>
								</tr>
								<tr class="trcabecera_list1">
									<td width="330">Prioridad</td>
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
						</td>
						<td width="10"></td>
						<td align="center" valign="top">
							<!--<div class="titulomenu" style="font-size:12px">Gr&aacute;fico</div>-->
							
							<img src="grafico.php<? echo $campo1."&tipo=prioridad"; ?>" />
						</td>
					</tr>
				</table>			
<?			
				}
			}
?>	

		</td>
	</tr>
	<tr>
		<td height="30"></td>
	</tr>	
	<tr id="aaa">
		<td colspan="4" height="15px" align="center">
			<input type="button" value="Imprimir" name="imprimir" id="imprimir" onclick="im('imprimir');" title="Imprimir"/>
			&nbsp;
			<input type="button" value="Cerrar" name="cerrar" id="cerrar" onclick="im('cerrar');" title="Cerrar"/>&nbsp;
		</td>
	</tr>
</table>
<script language="javascript" type="text/javascript">
// 1
function im(man) {
	if (man=="imprimir"){
		document.getElementById("aaa").style.display="none";
		window.print();
		window.setTimeout("document.getElementById('aaa').style.display=''",3000);
	} else {
		window.close();
	}
}
</script>