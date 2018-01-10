<?
	require_once("../../../../librerias/Recordset.php");
	$noti = stripslashes($_GET["nonc"]);
	$accion = stripslashes($_GET["acc"]);
	$ddire = stripslashes($_GET["dir"]);	
	$ttelf = stripslashes($_GET["tel"]);	
	$vciudadano = stripslashes($_GET["ciu"]);			
	$tempol = stripslashes($_GET["id_te"]);		
		
	$mensaje="";
	if($accion=="agregar"){
		if (isset($noti) && $noti !="")
		{	
			$search = new Recordset();
			$search->sql = "SELECT id_temp FROM temp WHERE temp.id_campo1 = '".$noti."'";
				$search->abrir();
				if($search->total_registros == 0)
				{
					$searchP = new Recordset();
					$searchP->sql = "insert into temp (id_campo1, id_campo2, id_campo3, id_campo4) values('".$noti."', '".$vciudadano."', '".$ddire."', '".$ttelf."');";
					$searchP->abrir();
					$searchP->cerrar();
					unset($searchP);						
				} else {
					$mensaje = 1;
				}
				$searche = new Recordset();
				$searche->sql = "SELECT id_temp FROM temp";
					$searche->abrir();
					if($searche->total_registros > 0)
					{
						$idd = $searche->total_registros;
					}
				$searche->cerrar();
				unset($searche);					

			$search->cerrar();
			unset($search);
		}
	} else if ($accion=="eliminar"){
		if (isset($tempol) && $tempol !="")
		{	
			if(ctype_digit($tempol))
			{	
				$searchP = new Recordset();
				$searchP->sql = "DELETE FROM temp WHERE id_temp = ".$tempol."";
				$searchP->abrir();
				$searchP->cerrar();
				unset($searchP);
				
				$search = new Recordset();
				$search->sql = "SELECT id_temp FROM temp";
					$search->abrir();
					if($search->total_registros > 0)
					{
						$idd = $search->total_registros;
					}
				$search->cerrar();
				unset($search);					
			}
		}	
 	} else if ($accion=="cancelar"){
		$searchD = new Recordset();
		$searchD->sql = "DELETE FROM temp";
		$searchD->abrir();
		$searchD->cerrar();
		unset($searchD);									
	}
	
	$search1 = new Recordset();
	$search1->sql = "SELECT id_temp, id_campo1, id_campo2, id_campo3, id_campo4 FROM temp";			
	$search1->abrir();
?>
	<tr id="list_ciudadano" style="display:none">
		<td colspan="4" align="center">
			<table align="center" border="0" width="90%" class="b_table">
				<tr>
					<td align="left" colspan="6"><? if ($mensaje==1){ echo '<div id="men" name="men" class="mensaje">El Organismo que acaba de agregar ya se encuentra registrado!!</div>'; } ?></td>
				</tr>	
				<tr>
					<td align="right" colspan="6"><input type="hidden" name="cargar_ciuda" id="cargar_ciuda" value="<? echo $idd; ?>"/><input type="button" name="btnagregar" id="btnagregar" value="Agregar" title="Agregar" onclick="age('ciudadano');"/></td>
				</tr>	
				<tr class="trcabecera_list">
					<td width="30px" align="center">
						N&deg;
					</td>
					<td width="90px" align="center">
						Notificaci&oacute;n
					</td>									
					<td width="180px" align="center">
						Nombre
					</td>
					<td width="180px" align="center">
						Direcci&oacute;n
					</td>		
					<td width="80px" align="center">
						Tel&eacute;fono
					</td>																
					<td width="30px" align="center">
						Acci&oacute;n
					</td>			
				</tr>
<?		
		if($search1->total_registros != 0)
		{
			for($i=0;$i<$search1->total_registros;$i++)
			{
				$search1->siguiente();
				$onclick="eliciu('".$search1->fila["id_temp"]."');";
?>	
				<tr <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
					<td align="center"><? echo $i+1; ?></td>
					<td align="center"><? echo $search1->fila["id_campo1"]; ?></td>
					<td align="center"><? echo $search1->fila["id_campo2"]; ?></td>					
					<td align="center"><? echo $search1->fila["id_campo3"]; ?></td>										
					<td align="center"><? echo $search1->fila["id_campo4"]; ?></td>										
					<td align="center"><img src="images/eliminar.png" style="cursor:pointer" onclick="<? echo $onclick; ?>" title="Seleccionar" /></td>				
				</tr>
<?			
			}
		} else {
?>
				<tr>
					<td align="center" colspan="6">No ex&iacute;sten datos a mostrar!!</td>
				</tr>	
<?		
		}
?>
			</table>
		</td>
	</tr>
<?
		$search1->cerrar();
		unset($search1);
?>