<?
require_once("../../../librerias/Recordset.php");
echo '<link href="css/style.css" rel="stylesheet" type="text/css" />';
$pagina = intval($_GET["pagina"]);

if($pagina == 0)
	$pagina = 1;
	
$search = new Recordset();
$search->sql = "SELECT  id_usuario, usuario, nombres, apellidos, CONCAT(nombres, ' ', apellidos) AS nombre, IF(estatus = 1, 'Activo', 'Inactivo') AS estatus, cedula FROM seg_usuario WHERE power_administrator <> 1";
$search->paginar($pagina,10);
?>
<table align="center" width="100%" border="0">
	<tr class="trcabecera">
		<td width="150">Usuario</td>
		<td width="200">Nombre y Apellido</td>												
		<td width="90">C&eacute;dula</td>									
		<td>Acci&oacute;n</td>
	</tr>
<? 
	if($search->total_registros != 0)
	{
		for($i = 1; $i <= $search->total_registros; $i++)
		{
			$search->siguiente();
			$abc = "";
				$ma = new Recordset();
				$ma->sql = "SELECT seg_modulo.`id_modulo` FROM seg_modulo WHERE seg_modulo.`id_modulo` NOT IN (SELECT seg_acceso_modulo.`id_modulo` FROM seg_acceso_modulo WHERE seg_acceso_modulo.`id_usuario`=".$search->fila["id_usuario"].")";			
				$ma->abrir();
				if($ma->total_registros != 0)
				{
					for($m=0;$m<$ma->total_registros;$m++)
					{
						$ma->siguiente();
						if($abc=="")
						{
							$abc = $ma->fila["id_modulo"];
						} else {
							$abc = $abc."-".$ma->fila["id_modulo"];
						}
					}
				}
				$ma->cerrar();
				unset($ma);
			
			$onclick = "devolver('".$search->fila["id_usuario"]."', '".$search->fila["usuario"]."', '".$search->fila["nombres"]."', '".$search->fila["apellidos"]."','".$abc."')";	
			
?>
	<tr align="center" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
		<td><? echo $search->fila["usuario"]; ?></td>
		<td><? echo $search->fila["nombre"]; ?></td>
		<td><? echo $search->fila["cedula"]; ?></td>
        <td align="center" width="80">
			<img src="images/seleccionar.png" style="cursor:pointer" onclick="<? echo $onclick; ?>;" title="Seleccionar" />
        </td>			
	</tr>
<?
		}
?>
    <tr>
    	<td colspan="4"><? $search->CrearPaginadorAjax("modulos/seguridad/privilegios/privilegios_d.php","images/paginador/","cargar_lista") ?></td>
    </tr>
<?
	} else {
?>
    <tr>
    	<td colspan="4"><br />&iexcl;No Ex&iacute;sten Datos a Mostrar!<br />&nbsp;</td>
    </tr>
<?
	}
?>
</table>