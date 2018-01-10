<?
$pagina = intval($_GET["pagina"]);
require_once("../../../librerias/Recordset.php");
$condicion = stripslashes($_GET["id"]);
if ((isset($condicion) && $condicion !=""))
{	
	$campos = " AND crp_correspondencia_externa.n_oficio_externo = ".$condicion;
	$condi = "&id=".$condicion;
}

$rsli = new Recordset();
$rsli->sql = "SELECT crp_correspondencia_externa.id_correspondencia_externa, crp_correspondencia_externa.n_oficio_externo, organismo.organismo, crp_correspondencia_externa.contenido, DATE_FORMAT(crp_correspondencia_externa.fecha_registro,'%d/%m/%Y') as fecha_registro
						FROM crp_correspondencia_externa 
						 INNER JOIN crp_correspondencia_externa_det 
						  ON (crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa) 
						 INNER JOIN organismo ON (crp_correspondencia_externa_det.id_organismo = organismo.id_organismo)
						WHERE crp_correspondencia_externa.entregado = 0 $campos ORDER BY crp_correspondencia_externa.n_oficio_externo DESC";
$rsli->paginar($pagina,7);
?>
<table width="100%" align="center" cellpadding="1" cellspacing="1" border="0" class="b_table1">
	<tr class="trcabecera_list">
    	<td class="headtabla" width="80">N&deg; Oficio</td>
		<td class="headtabla" width="170">Organismo</td>    	
		<td class="headtabla" width="80">Contenido</td>
        <td class="headtabla" width="80">Fecha Registro</td>
        <td class="headtabla" width="50">Acci&oacute;n</td>
    </tr>
<?
if($rsli->total_registros > 0){
	for($i = 1; $i <= $rsli->total_registros; $i++){
		$rsli->siguiente();	
		$onclick="la('".$rsli->fila["id_correspondencia_externa"]."');";
?>
    <tr<? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
    	<td align="center"><? echo $rsli->fila["n_oficio_externo"];?></td>
        <td align="center"><? echo ucwords(mb_strtolower($rsli->fila["organismo"]));?></td>
        <td align="center" title="<? echo $rsli->fila["contenido"]; ?>"><? echo substr($rsli->fila["contenido"],0,30); ?></td>
    	<td align="center"><? echo $rsli->fila["fecha_registro"];?></td>
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