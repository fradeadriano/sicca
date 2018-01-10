<?
$pagina = intval($_GET["pagina"]);
require_once("../../../librerias/Recordset.php");
$condicion = stripslashes($_GET["id"]);
if ((isset($condicion) && $condicion !=""))
{	
	$campos = " WHERE crp_recepcion_correspondencia.id_organismo = ".$condicion;
	$condi = "&id=".$condicion;
}

$rsli = new Recordset();
$rsli->sql = "SELECT crp_recepcion_correspondencia.id_recepcion_correspondencia, crp_recepcion_correspondencia.`n_correlativo`, crp_recepcion_correspondencia.`n_documento`, DATE_FORMAT(crp_recepcion_correspondencia.`fecha_documento`,'%d/%m/%Y') AS fecha_do, organismo.`organismo` 
				FROM crp_recepcion_correspondencia INNER JOIN organismo ON (crp_recepcion_correspondencia.`id_organismo` = organismo.`id_organismo`) $campos ORDER BY n_correlativo DESC";
$rsli->paginar($pagina,7);
?>
<table width="100%" align="center" cellpadding="1" cellspacing="1" border="0" class="b_table1">
	<tr class="trcabecera_list">
    	<td class="headtabla" width="80">N&deg; Correlativo</td>
    	<td class="headtabla" width="80">N&deg; Documento</td>
        <td class="headtabla" width="80">Fecha Documento</td>
        <td class="headtabla" width="170">Organismo</td>
        <td class="headtabla" width="50">Acci&oacute;n</td>
    </tr>
<?
if($rsli->total_registros > 0){
	for($i = 1; $i <= $rsli->total_registros; $i++){
		$rsli->siguiente();	
		$onclick="la('".$rsli->fila["id_recepcion_correspondencia"]."');";
?>
    <tr<? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
    	<td align="center"><? echo $rsli->fila["n_correlativo"];?></td>
        <td align="center"><? echo $rsli->fila["n_documento"];?></td>
        <td align="center"><? echo $rsli->fila["fecha_do"];?></td>
    	<td align="center"><? echo $rsli->fila["organismo"];?></td>
        <td align="center">
			<img src="../../../images/seleccionar.png" style="cursor:pointer" onclick="<? echo $onclick; ?>" title="Seleccionar" />
		</td>
    </tr>
<?
	};
?>
    <tr><td height="5"></td></tr>
	<tr>
    	<td colspan="7">
			<? $rsli->CrearPaginadorAjax("bsq_correspondencia_list.php","../../../images/paginador/","llamarlistado",$condi) ?>
		</td>
    </tr>
<?
	unset($rsli);
}else{
?>
	<tr>
        <td colspan="7" class="titulomenu" align="center"><br />&iexcl;No Ex&iacute;sten Datos a Mostrar!<br />&nbsp;</td>
    </tr>
<?
}
?>
</table>