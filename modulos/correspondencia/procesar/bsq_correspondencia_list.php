<?
$pagina = intval($_GET["pagina"]);
require_once("../../../librerias/Recordset.php");
$condicion = stripslashes($_GET["condicion"]);
if ((isset($condicion) && $condicion !=""))
{	
	$tramo1 = explode("!",$condicion);		
	$campos="";
	for($u=0;$u<count($tramo1);$u++)
		{
			$tramo2 = explode(":",$tramo1[$u]);				
			switch($tramo2[0])
			{
				case "campo1": // unidad
					$campos = " AND crp_asignacion_correspondencia.id_unidad = ".$tramo2[1];
					$condi = "&condicion=campo1:".$tramo2[1];
				break;	
	
				case "campo2": //apoyo
					$campos = $campos." AND crp_recepcion_correspondencia.id_organismo = ".$tramo2[1];
					$condi = $condi."!campo2:".$tramo2[1];
				break;	
			}
		}
}

$rsli = new Recordset();
$rsli->sql = "SELECT crp_recepcion_correspondencia.id_recepcion_correspondencia, crp_recepcion_correspondencia.n_documento, organismo.organismo, unidad.unidad,  crp_recepcion_correspondencia.n_correlativo, tipo_documento.tipo_documento, DATE_FORMAT(crp_asignacion_correspondencia.fecha_asignacion,'%d/%m/%Y %r') AS fasig 
			FROM crp_asignacion_correspondencia 
			 INNER JOIN crp_recepcion_correspondencia ON (crp_asignacion_correspondencia.id_recepcion_correspondencia = crp_recepcion_correspondencia.id_recepcion_correspondencia) 
			 INNER JOIN tipo_documento ON (crp_recepcion_correspondencia.id_tipo_documento = tipo_documento.id_tipo_documento) 
			 INNER JOIN organismo ON (crp_recepcion_correspondencia.id_organismo = organismo.id_organismo) 
			 INNER JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad)
			WHERE DATE_FORMAT(crp_recepcion_correspondencia.fecha_registro,'%Y') = 2014 AND crp_asignacion_correspondencia.id_estatus = 4 AND crp_asignacion_correspondencia.id_recepcion_correspondencia NOT IN (SELECT id_recepcion_correspondencia FROM crp_correspondencia_externa) AND crp_asignacion_correspondencia.externo = 1 $campos  order by crp_recepcion_correspondencia.n_correlativo ASC";
$rsli->paginar($pagina,7);
?>
<table width="100%" align="center" cellpadding="1" cellspacing="1" border="0" class="b_table1">
	<tr class="trcabecera_list">
    	<td class="headtabla" width="80">N&deg; Correlativo</td>
        <td class="headtabla" width="170">Organismo</td>
        <td class="headtabla" width="100">Unidad</td>
    	<td class="headtabla" width="80">N&deg; Documento</td>
        <td class="headtabla" width="80">Tipo Documento</td>
        <td class="headtabla" width="80">Fecha Asignaci&oacute;n</td>
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
        <td align="center"><? echo $rsli->fila["organismo"];?></td>
        <td align="center"><? echo $rsli->fila["unidad"];?></td>
    	<td align="center"><? echo $rsli->fila["n_documento"];?></td>
        <td align="center"><? echo $rsli->fila["tipo_documento"];?></td>
        <td align="center"><? echo $rsli->fila["fasig"];?></td>		
        <td align="center">
			<img src="images/seleccionar.png" style="cursor:pointer" onclick="<? echo $onclick; ?>" title="Seleccionar" />
		</td>
    </tr>
<?
	};
?>
    <tr><td height="5"></td></tr>
	<tr>
    	<td colspan="7">
			<? $rsli->CrearPaginadorAjax("modulos/correspondencia/procesar/bsq_correspondencia_list.php","images/paginador/","cargar_lista",$condi) ?>
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
	<tr><td height="5"></td></tr>
	<tr><td colspan="7" align="right"><input type="button" class="botones" onclick="closeMessage();" id="regresar" name="regresar" value="Regresar" title="Regresar" /></td></tr>
</table>