<?
require_once("../../../librerias/Recordset.php");
echo '<link href="css/style.css" rel="stylesheet" type="text/css" />';
$pagina = intval($_GET["pagina"]);

if($pagina == 0)
	$pagina = 1;
	if(isset($_GET["b_id"]) && $_GET["b_id"]!=""){
	$idVALOR = $_GET["b_id"];
	$cond = "AND seg_usuario.id_usuario =".$idVALOR;
}
	
$search = new Recordset();
$search->sql = "SELECT  id_usuario, usuario, nombres, apellidos, CONCAT(nombres, ' ', apellidos) AS nombre, IF(estatus = 1, 'Activo', 'Inactivo') AS estatus_mos, estatus, cedula FROM seg_usuario  WHERE id_usuario <> 1 $cond";
$search->paginar($pagina,5);
?>
<table align="center" width="100%" border="0">
	<tr class="trcabecera">
		<td width="90">Usuario</td>
		<td width="150">Nombre y Apellido</td>												
		<td width="90">C&eacute;dula</td>
		<td width="80">Estatus</td>												
		<td>Acci&oacute;n</td>
	</tr>
<? 
	if($search->total_registros != 0)
	{
		for($i = 1; $i <= $search->total_registros; $i++)
		{
			$search->siguiente();
			$onclick1 = "subir('Modificar','".$search->fila["id_usuario"]."', '".$search->fila["usuario"]."', '".$search->fila["estatus"]."', '".$search->fila["nombres"]."', '".$search->fila["apellidos"]."', '".$search->fila["cedula"]."')";	
			$onclick2 = "subir('Eliminar','".$search->fila["id_usuario"]."', '".$search->fila["usuario"]."', '".$search->fila["estatus"]."','".$search->fila["nombres"]."', '".$search->fila["apellidos"]."', '".$search->fila["cedula"]."')";	
?>
	<tr align="center" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
		<td><? echo $search->fila["usuario"]; ?></td>
		<td><? echo $search->fila["nombre"]; ?></td>
		<td><? echo $search->fila["cedula"]; ?></td>
		<td><? echo $search->fila["estatus_mos"]; ?></td>
        <td align="center" width="80">
			<img src="images/modificar.png" style="cursor:pointer" onclick="<? echo $onclick1; ?>;" title="Modificar" />
			<img src="images/eliminar.png" style="cursor:pointer" onclick="<? echo $onclick2; ?>;" title="Eliminar" />
        </td>			
	</tr>
<?
		}
?>
    <tr>
    	<td colspan="5"><? $search->CrearPaginadorAjax("modulos/seguridad/usuarios/usuarios_d.php","images/paginador/","cargar_lista") ?></td>
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