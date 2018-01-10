<?
if(!stristr($_SERVER['SCRIPT_NAME'],"monitoreo_list.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado de Usuarios</title>
</head>
<body>
<form action="nprivilegio.php" name="ilegal" id="ilegal" method="post">
	<input type="hidden" name="archivo" value="'.$_SERVER['SCRIPT_NAME'].'" />
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
	document.getElementById("ilegal").submit();
</script>';
	die($hmtl);
}
$pagina = intval($_GET["pagina"]);
if($pagina == 0)
	$pagina = 1;
require_once("../../../librerias/Recordset.php");
require_once("bil.php");
$x = stripslashes($_GET["p_orden"]);
$y = stripslashes($_GET["met"]);
$z = stripslashes($_GET["condiciones"]);
$rslista = new Recordset();
//echo $z."<br>";
if(isset($z) && $z!="")
	{
		$condi = "&met=".$_GET["met"]."&condiciones=".$_GET["condiciones"];
		$variable = explode("!",$z);
		for ($j=0;$j<count($variable);$j++)
			{
				
				$desgloce = explode(":",$variable[$j]);
				switch($desgloce[0])
					{
						case "campo1": //estatus
							if($where!="")
								{
									$where = $where . " AND crp_ruta_correspondencia_ext.id_estatus=".$desgloce[1];
								} else {
									//$where = " WHERE crp_ruta_correspondencia_ext.id_estatus=".$desgloce[1];
									$where = " AND crp_ruta_correspondencia_ext.id_estatus=".$desgloce[1];
								}					
						break;
						case "campo2"://n oficio
							if($where!="")
								{
									$where = $where . " AND crp_correspondencia_externa.n_oficio_externo='".$desgloce[1]."'";
								} else {
									//$where = " WHERE crp_correspondencia_externa.n_oficio_externo='".$desgloce[1]."'";
									$where = " AND crp_correspondencia_externa.n_oficio_externo='".$desgloce[1]."'";
								}
						break;
						
						case "campo3"://Fecha Registro
							$sub_desgloce = explode("_",$desgloce[1]);

							if($where!="")
								{
									$where = $where ." AND (crp_correspondencia_externa.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."')"; 	
								} else {
									//$where = " WHERE (crp_correspondencia_externa.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."')"; 
									$where = " AND (crp_correspondencia_externa.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."')"; 
								}							
							

						break;
						
						case "campo4"://organism
							if($where!="")
								{
									$where = $where . " AND crp_correspondencia_externa_det.id_organismo = ".$desgloce[1];
								} else {
									//$where = " WHERE crp_correspondencia_externa_det.id_organismo = ".$desgloce[1];
									$where = " AND crp_correspondencia_externa_det.id_organismo = ".$desgloce[1];
								}							
							
						break;
																		
						case "campo5"://documento
							$ddo = explode("-",$desgloce[1]);
							if($ddo[1]==0){
								if($where!="")
									{
										$where = $where." AND crp_correspondencia_externa.id_documento_cgr='".$ddo[0]."'"; 	
									} else {
										//$where = " WHERE crp_correspondencia_externa.id_documento_cgr='".$ddo[0]."'"; 	
										$where = " AND crp_correspondencia_externa.id_documento_cgr='".$ddo[0]."'"; 	
									}								
							} else {
								if($where!="")
									{
										$where = $where." AND crp_correspondencia_externa.id_documento_cgr_desgloce='".$ddo[1]."'"; 	
									} else {
										//$where = " WHERE crp_correspondencia_externa.id_documento_cgr_desgloce='".$ddo[1]."'"; 	
										$where = " AND crp_correspondencia_externa.id_documento_cgr_desgloce='".$ddo[1]."'"; 	
									}								
							}
						break;																	
					}	
			}
	}
if(isset($x))
	{
		if($condi!=""){
			$condi = $condi."&p_orden=".$_GET["p_orden"];
		} else {
			$condi = "&p_orden=".$_GET["p_orden"]."&met=".$_GET["met"];		
		}
		switch($x){
			case "columna1": //estatus
				$ondicionW = " ORDER BY crp_ruta_correspondencia_ext.id_estatus $y";
			break;
			case "columna2": //N&deg; oficio
				$ondicionW = "ORDER BY crp_correspondencia_externa.n_oficio_externo $y";	
			break;
			case "columna3"://Organ&iacute;smo / Remitente
				$ondicionW = "ORDER BY crp_correspondencia_externa.fecha_registro $y";					
			break;
			case "columna4"://Fecha Registro
				$ondicionW = "ORDER BY organismo $y";		
			break;
			case "columna5"://documento
				$ondicionW = "ORDER BY oficio $y";	
			break;
/*			case "columna6"://Unidad Asignada
				$ondicionW = "ORDER BY unidad $y";	
			break;
			case "columna7": // N&deg; Correlativo
				$ondicionW = "ORDER BY n_correlativo $y";	
			break;			
*/			default:
				$ondicionW = "ORDER BY crp_correspondencia_externa.fecha_registro $y";
			break;
		}	
	}
	$rslista->sql = "SELECT crp_correspondencia_externa.id_correspondencia_externa, crp_correspondencia_externa.n_oficio_externo, crp_correspondencia_externa.anular,
							crp_correspondencia_externa.id_correspondencia_externa, DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%d/%m/%Y %r') AS registro, 
							IF(organismo.organismo IS NULL,crp_correspondencia_externa.destinatario,organismo.organismo) AS organismo, crp_correspondencia_externa.contenido, crp_correspondencia_externa.id_documento_cgr, crp_correspondencia_externa.id_documento_cgr_desgloce, crp_correspondencia_externa.fecha_registro, 
							IF(IF(CONCAT(tipo_documento_cgr.tipo_documento_cgr,'-',documento_cgr_desgloce.documento_cgr_desgloce) IS NULL,tipo_documento_cgr.tipo_documento_cgr,CONCAT(tipo_documento_cgr.tipo_documento_cgr,'-',documento_cgr_desgloce.documento_cgr_desgloce)) IS NULL,'--',IF(CONCAT(tipo_documento_cgr.tipo_documento_cgr,'-',documento_cgr_desgloce.documento_cgr_desgloce) IS NULL,tipo_documento_cgr.tipo_documento_cgr,CONCAT(tipo_documento_cgr.tipo_documento_cgr,'-',documento_cgr_desgloce.documento_cgr_desgloce))) AS oficio, crp_correspondencia_externa.plazo
						FROM crp_correspondencia_externa LEFT JOIN crp_correspondencia_externa_det 
							ON (crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa) 
							 LEFT JOIN organismo ON (crp_correspondencia_externa_det.id_organismo = organismo.id_organismo)
    						 LEFT JOIN crp_ruta_correspondencia_ext ON (crp_correspondencia_externa.id_correspondencia_externa = crp_ruta_correspondencia_ext.id_correspondencia_externa) 							 
							 LEFT JOIN tipo_documento_cgr ON (crp_correspondencia_externa.id_documento_cgr = tipo_documento_cgr.id_tipo_documento_cgr)
							 LEFT JOIN documento_cgr_desgloce ON (crp_correspondencia_externa.id_documento_cgr_desgloce = documento_cgr_desgloce.id_documento_cgr_desgloce)					
					WHERE DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%Y') = 2016 $where
					GROUP BY crp_correspondencia_externa.n_oficio_externo $ondicionW";
	$rslista->paginar($pagina,10);

?>

<table border="0" class="b_table1" align="center" width="100%" cellpadding="1" cellspacing="1">
	<tr height="30" valign="middle" class="trcabecera_list">
		<!--<td width="20"></td>-->
		<td width="50">
			N&deg; Oficio Externo
		</td>		
		<td width="180">
			Organismo / Destinatario
		</td>
		<td width="180">
			Contenido
		</td>
		<td width="120">
			Documento
		</td>				
		<td width="90">
			Fecha / Hora Envio
		</td>
		<td width="40">
			Plazo
		</td>
		<td width="80">
			Fecha / Hora Entrega
		</td>
		<td width="70">
			Estatus
		</td>		
		<td width="60">
			Acci&oacute;n
		</td>
	</tr>
	<tr><td colspan="10"></td></tr>
<?
	if($rslista->total_registros > 0)
		{	
			for ($i=1;$i<=$rslista->total_registros;$i++)
			{
				$rslista->siguiente();
?>				
	<tr <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
<!--		<td align="center">
			<img src="images/mas.png" id="img_mas<? echo $rslista->fila["id_correspondencia_externa"]; ?>" style="cursor:pointer" title="Detallar m&aacute;s" onclick="mostrar_detalles('mDeta_<? echo $rslista->fila["id_correspondencia_externa"]; ?>',this.id);" />
		</td>-->
		<td>
			<? echo $rslista->fila["n_oficio_externo"]; ?>
		</td>		
		<td>
			<? echo ucwords(mb_strtolower($rslista->fila["organismo"])); ?>
		</td>
		<td title="<? echo $rslista->fila["contenido"]; ?>">
			<? echo substr($rslista->fila["contenido"],0,30); ?>
		</td>
		<td>
			<? 
				echo $rslista->fila["oficio"];			
/*				$id_documento_cgr = $rslista->fila["id_documento_cgr"];
				$id_documento_cgr_desgloce = $rslista->fila["id_documento_cgr_desgloce"];
				
				if ($id_documento_cgr_desgloce!="")
				{
					 $sql = "SELECT CONCAT(tipo_documento_cgr.tipo_documento_cgr,'-',documento_cgr_desgloce.documento_cgr_desgloce) AS documento 
							FROM tipo_documento_cgr INNER JOIN documento_cgr_desgloce ON (tipo_documento_cgr.id_tipo_documento_cgr = documento_cgr_desgloce.id_tipo_documento_cgr)
							WHERE documento_cgr_desgloce.id_documento_cgr_desgloce = ".$id_documento_cgr_desgloce;
				} else {
					 $sql = "SELECT tipo_documento_cgr.tipo_documento_cgr AS documento 
							FROM tipo_documento_cgr 
							WHERE tipo_documento_cgr.id_tipo_documento_cgr = ".$id_documento_cgr;
				}
				$bsf2 = new Recordset();
				$bsf2->sql = $sql;
				$bsf2->abrir();
				if($bsf2->total_registros == 1)
					{	
						$bsf2->siguiente();
						echo  $bsf2->fila["documento"];
					}				
				$bsf2->cerrar();
				unset($bsf2);*/
			 ?>
		</td>				
		<td>
			<? echo $rslista->fila["registro"]; ?>
		</td>
		<td>
			<? 
				if($rslista->fila["plazo"]!=""){
					echo $rslista->fila["plazo"];	
				} else {
					echo "--";		
				}
			?>
		</td>
		<td>
			<? 
				$bsf = new Recordset();
				$bsf->sql = "SELECT DATE_FORMAT(fecha_recepcion, '%d/%m/%Y %r') AS entrega 
							FROM crp_ruta_correspondencia_ext 
							WHERE crp_ruta_correspondencia_ext.id_correspondencia_externa = ".$rslista->fila["id_correspondencia_externa"]." AND crp_ruta_correspondencia_ext.id_estatus = 6";
				$bsf->abrir();
				if($bsf->total_registros == 1)
					{	
						$bsf->siguiente();
						echo  $bsf->fila["entrega"];
					} else {
						echo  "--";					
					}			
			 ?>
		</td>
		<td>
			<? 
				$suytr = 0;
				if($rslista->fila["anular"]==0)
				{
					$bsf1 = new Recordset();
					$bsf1->sql = "SELECT estatus.estatus, crp_ruta_correspondencia_ext.id_estatus 
									FROM crp_ruta_correspondencia_ext INNER JOIN estatus ON (crp_ruta_correspondencia_ext.id_estatus = estatus.id_estatus) 
									WHERE crp_ruta_correspondencia_ext.id_correspondencia_externa = ".$rslista->fila["id_correspondencia_externa"]." ORDER BY crp_ruta_correspondencia_ext.id_crp_ruta_correspondencia_ext DESC LIMIT 1 ";
					$bsf1->abrir();
					if($bsf1->total_registros == 1)
						{	
							$bsf1->siguiente();
							echo  $bsf1->fila["estatus"];
							
						} else {
							$bsfsub = new Recordset();
							$bsfsub->sql = "SELECT estatus.estatus, estatus.id_estatus, crp_correspondencia_externa.id_recepcion_correspondencia_cgr FROM crp_correspondencia_externa INNER JOIN crp_ruta_correspondencia_cgr ON (crp_correspondencia_externa.`id_recepcion_correspondencia_cgr` = crp_ruta_correspondencia_cgr.`id_recepcion_correspodencia_cgr`) INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_correspondencia_externa.`id_correspondencia_externa` = ".$rslista->fila["id_correspondencia_externa"]."
													ORDER BY crp_ruta_correspondencia_cgr.`id_crp_ruta_correspodencia_cgr` DESC LIMIT 1";
							$bsfsub->abrir();
							if($bsfsub->total_registros == 1)
								{	
									$bsfsub->siguiente();
									echo  $bsfsub->fila["estatus"];
									$iid_estatus = $bsfsub->fila["id_estatus"];
									$id_recepcion_correspondencia_cgr = $bsfsub->fila["id_recepcion_correspondencia_cgr"];

								}						
							$suytr = 1;
							$bsfsub->cerrar();
							unset($bsfsub);
						}				


				} else {
					echo "Anulado";
				}
			 ?>
		</td>
		<td>
		
<?			
		//echo $rslista->fila["id_correspondencia_externa"];
				if($suytr == 0)
				{				
					if($rslista->fila["anular"]==0)
					{		
						$casos = $bsf1->fila["id_estatus"];
						switch ($casos) 
						{		
							case 5: //enviado
								
								$b = new Recordset();
								$b->sql = "SELECT crp_correspondencia_externa.`id_correspondencia_externa` 
											FROM crp_correspondencia_externa 
												INNER JOIN crp_correspondencia_externa_det ON (crp_correspondencia_externa.`id_correspondencia_externa` = crp_correspondencia_externa_det.`id_correspondencia_externa`)
												INNER JOIN organismo ON (crp_correspondencia_externa_det.`id_organismo` = organismo.`id_organismo`)
											WHERE organismo.`cgr` = 1 AND crp_correspondencia_externa.`id_correspondencia_externa` = ".$rslista->fila["id_correspondencia_externa"];
								$b->abrir();
								if($b->total_registros == 1)
									{	
										$imagen = '<img title="Clic para Visualizar Correspondencia" src="images/consultar.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_interno/ver.php?id_recepcion='.$rslista->fila["id_correspondencia_externa"].'\',\'600\',\'450\');" />';													
									} else {
										$imagen = '<img title="Clic para Registrar Entrega" src="images/enviado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_interno/registrar.php?id_recepcion='.$rslista->fila["id_correspondencia_externa"].'\',\'600\',\'370\');" />
													<img title="Clic para Anular Oficio" src="images/no_habilitado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_interno/anular.php?id_recepcion='.$rslista->fila["id_correspondencia_externa"].'\',\'600\',\'290\');" />							
										';								
									}						
								$b->cerrar();
								unset($b);								

							break; 
							case 6: //entregado
								$imagen = '<img title="Clic para Visualizar Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_interno/ver.php?id_recepcion='.$rslista->fila["id_correspondencia_externa"].'\',\'600\',\'350\');" />';					
							break;						
						}
					} else {
						$imagen = '<img title="Clic para Visualizar Correspondencia Anulada" src="images/Paper-x.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_interno/ver_anulado.php?id_recepcion='.$rslista->fila["id_correspondencia_externa"].'\',\'600\',\'350\');" />';									
					}
				} else {
					if($iid_estatus == 5)
					{			
						$imagen = '<img title="Clic para Visualizar Correspondencia" src="images/consultar.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_interno/ver_cgr.php?id_recepcion='.$id_recepcion_correspondencia_cgr.'\',\'600\',\'450\');" />';													
					} else if ($iid_estatus == 6) {
						$imagen = '<img title="Clic para Visualizar Correspondencia" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo_interno/ver_cgr.php?id_recepcion='.$id_recepcion_correspondencia_cgr.'\',\'600\',\'450\');" />';																		
					}						
				}
?>		
			<a>
				<? echo $imagen; 
					$iid_estatus = "";
					$imagen="";  
					$bsf1->cerrar();
					unset($bsf1);
					$id_recepcion_correspondencia_cgr = "";
				?>				
			</a>	
		</td>																						
	</tr>

<?	
			}
?>
	<tr><td height="10" colspan="10"></td></tr>		    
	<tr>
    	<td colspan="10"><? $rslista->CrearPaginadorAjax("modulos/correspondencia/monitoreo_interno/monitoreo_list.php","images/paginador/","cargar_lista_corres",$condi) ?></td>
    </tr>
<?
		} else {
?>	
	<tr class="trresaltado">
		<td colspan="10">
			No Ex&iacute;sten Datos a Mostrar
		</td>																					
	</tr>
<?
}
?>	
</table>