<?
require_once("../../../librerias/Recordset.php");
echo '<link href="css/style.css" rel="stylesheet" type="text/css" />';
$pagina = intval($_GET["pagina"]);

if($pagina == 0)
	$pagina = 1;
$search = new Recordset();
$lospara = $_GET["parametros1"];
$condicion = stripslashes($_GET["parametros1"]);
$condi = "&parametros1=".$condicion;
$variable = explode("_",$lospara);
	for ($j=0;$j<count($variable);$j++)
		{
			$contenido = explode(":",$variable[$j]);	
			switch($contenido[0])
				{
					case "dsd":		
						$sqql = "WHERE fecha BETWEEN '".$search->formatofecha($contenido[1])."'";
					break;
					case "hst":		
						$sqql = $sqql." AND '".$search->formatofecha($contenido[1])."'";
					break;
					case "usu":		
						$sqql = $sqql." AND usuario='".$contenido[1]."'";
					break;					

				}
		}

$search->sql = "select ID_BITACORA, usuario, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha, DATE_FORMAT(hora, '%r') as hora , titulo_accion, accion from seg_bitacora $sqql ORDER BY ID_bitacora DESC";
$search->paginar($pagina,10);
?>
<table align="center" width="100%" border="0" cellspacing="5">
	<tr class="trcabecera">
		<td width="70">Usuario</td>
		<td width="70">Fecha</td>												
		<td width="80">Hora</td>
		<td width="220">Titulo de la Acci&oacute;n</td>												
		<td>Acci&oacute;n</td>
	</tr>
<? 
	if($search->total_registros != 0)
	{
		for($i = 1; $i <= $search->total_registros; $i++)
		{
			$search->siguiente();
?>
	<tr align="center" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
		<td><? echo $search->fila["usuario"]; ?></td>
		<td><? echo $search->fila["fecha"]; ?></td>
		<td><? echo $search->fila["hora"]; ?></td>
		<td><? echo html_entity_decode(base64_decode($search->fila['titulo_accion']), ENT_COMPAT, 'UTF-8'); ?></td>
		<td><? echo html_entity_decode(base64_decode($search->fila['titulo_accion']), ENT_COMPAT, 'UTF-8'); ?></td>
        </td>			
	</tr>
<?
		}
?>
    <tr>
    	<td colspan="5"><? $search->CrearPaginadorAjax("modulos/seguridad/auditoria/auditoria_d.php","images/paginador/","cargar_lista",$condi) ?></td>
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