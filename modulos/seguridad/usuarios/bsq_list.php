<?
$pagina = intval($_GET["pagina"]);
require_once("../../../librerias/Recordset.php");

if($pagina == 0)
	$pagina = 1;
	
	if(isset($_GET["pa2"]) && $_GET["pa2"]=="user")
	$cond = " AND seg_usuario.`usuario` LIKE '".$_GET["pa1"]."%'";
if(isset($_GET["pa2"]) && $_GET["pa2"]=="apellido")
	$cond = " AND seg_usuario.`apellidos` LIKE '".$_GET["pa1"]."%'";
if(isset($_GET["pa2"]) && $_GET["pa2"]=="nombre")
	$cond = " AND seg_usuario.`usuario` LIKE '".$_GET["pa1"]."%'";
	
$rsli = new Recordset();
$rsli->sql = "SELECT seg_usuario.id_usuario, seg_usuario.`usuario`, CONCAT(seg_usuario.`nombres`,', ',seg_usuario.`apellidos`) AS nombre
				FROM seg_usuario 
				where seg_usuario.id_usuario <> 1
				$cond ORDER BY seg_usuario.usuario ASC"; 

$rsli->paginar($pagina,8);
?>
<table align="center" width="100%" border="0">
	<tr class="trcabecera">
		<td width="200">Usuario</td>												
		<td width="200">Nombre y Apellido</td>	
        <td width="70">Acci&oacute;n</td>
    </tr>
<?
if($rsli->total_registros > 0){
	for($i = 1; $i <= $rsli->total_registros; $i++){
		$rsli->siguiente();
		$onclick = "devolver('".$rsli->fila["id_usuario"]."')";
		$condi = "&pa2=".$_GET["pa2"]."&pa1=".$_GET["pa1"];			
?>
    <tr<? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
    	<td align="center"><? echo $rsli->fila["usuario"];?></td>
        <td align="center"><? echo $rsli->fila["nombre"];?></td>
        <td align="center">
			<img src="images/seleccionar.png" style="cursor:pointer" onclick="<? echo $onclick; ?>;" title="Seleccionar" />&nbsp;&nbsp;
		</td>
    </tr>
<?
	}
?>
    <tr>
    	<td colspan="4"><? $rsli->CrearPaginadorAjax("modulos/seguridad/usuarios/bsq_list.php","images/paginador/","cargar_lista_bsq",$condi) ?></td>
    </tr>
<?
	unset($rsli);
}else{
?>
	<tr>
        <td colspan="4" class="titulomenu" align="center"><br />&iexcl;No Ex&iacute;sten Datos a Mostrar!<br />&nbsp;</td>
    </tr>
<?
}
?>
</table>