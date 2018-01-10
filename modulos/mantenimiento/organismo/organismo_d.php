<?
require_once("../../../librerias/Recordset.php");
echo '<link href="css/style.css" rel="stylesheet" type="text/css" />';
$pagina = intval($_GET["pagina"]);

if($pagina == 0)
	$pagina = 1;
	
$search = new Recordset();
$search->sql = "SELECT organismo.id_organismo, organismo.organismo FROM organismo WHERE organismo.cgr = 0 ORDER BY organismo.id_organismo DESC";
$search->paginar($pagina,10);
?>
<table align="center" width="100%" border="0">
	<tr class="trcabecera">
		<td width="40">N&deg;</td>
		<td width="250">Organismo</td>												
		<!--<td>Acci&oacute;n</td>-->
	</tr>
<? 
	if($search->total_registros != 0)
	{
		for($i = 1; $i <= $search->total_registros; $i++)
		{
			$search->siguiente();
			$onclick = "devolver1('Modificar','".$search->fila["id_usuario"]."', '".$search->fila["usuario"]."', '".$search->fila["estatus"]."', '".$search->fila["admi"]."', '".$search->fila["nombres"]."', '".$search->fila["apellidos"]."', '".$search->fila["cedula"]."')";	
			$onclick = "devolver2('Eliminar','".$search->fila["id_usuario"]."', '".$search->fila["usuario"]."', '".$search->fila["estatus"]."', '".$search->fila["admi"]."', '".$search->fila["nombres"]."', '".$search->fila["apellidos"]."', '".$search->fila["cedula"]."')";	
?>
	<tr align="center" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
		<td><? echo $search->fila["id_organismo"]; ?></td>
		<td><? echo $search->fila["organismo"]; ?></td>
<!--        <td align="center" width="80">
			<img src="images/modificar.png" style="cursor:pointer" onclick="<? echo $onclick1; ?>;" title="Modificar" />
			<img src="images/eliminar.png" style="cursor:pointer" onclick="<? echo $onclick2; ?>;" title="Eliminar" />
        </td>-->			
	</tr>
<?
		}
?>
    <tr>
    	<td colspan="5"><? $search->CrearPaginadorAjax("modulos/mantenimiento/organismo/organismo_d.php","images/paginador/","cargar_lista") ?></td>
    </tr>
<?
	} else {
?>
    <tr>
    	<td colspan="5"><br />&iexcl;No Ex&iacute;sten Datos a Mostrar!<br />&nbsp;</td>
    </tr>
<?
	}
?>
</table>