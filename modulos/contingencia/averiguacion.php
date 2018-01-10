<?
require_once("../../librerias/Recordset.php"); 

$rsli = new Recordset();
$rsli->sql = 'SELECT id_bitacora,usuario, fecha, hora, titulo_accion,accion, ip  FROM seg_bitacora WHERE usuario = "despachoext" AND DATE_FORMAT(fecha,"%Y") = 2014';
$rsli->abrir();

?>
<table width="100%" align="center" cellpadding="1" cellspacing="1" border="1" class="b_table1">
	<tr class="trcabecera_list">
		<td class="headtabla" width="80">n</td>
    	<td class="headtabla" width="80">id</td>
    	<td class="headtabla" width="80">usuario</td>
        <td class="headtabla" width="80">Fecha</td>
        <td class="headtabla" width="170">hora</td>
        <td class="headtabla" width="50">titulo accion</td>
        <td class="headtabla" width="50">accion</td>		
        <td class="headtabla" width="50">ip</td>				
    </tr>
<?
if($rsli->total_registros > 0)
{
	for($i = 0; $i <= $rsli->total_registros; $i++)
	{
		$rsli->siguiente();	

?>
    <tr>
    	<td align="center"><? echo $i;?></td>
		<td align="center"><? echo $rsli->fila["id_bitacora"];?></td>
        <td align="center"><? echo $rsli->fila["usuario"];?></td>
        <td align="center"><? echo $rsli->fila["fecha"];?></td>
    	<td align="center"><? echo $rsli->fila["hora"];?></td>
    	<td align="center"><? echo base64_decode($rsli->fila["titulo_accion"]); ?></td>
        <td align="center"><? echo base64_decode($rsli->fila["accion"]);?></td>
        <td align="center"><? echo $rsli->fila["ip"];?></td>
    </tr>
<?
	
	}
	
}

?>