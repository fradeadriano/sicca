<?
if(!stristr($_SERVER['SCRIPT_NAME'],"ver_caso.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
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
require_once("../../../../librerias/Recordset.php");
require_once("../../../../librerias/bitacora.php");	
$recepcion = stripslashes($_GET["id_recepcion"]);

if ((isset($recepcion) && $recepcion !="")){	
	if(ctype_digit($recepcion)){	
		$search = new Recordset();
		$search->sql = "SELECT id_correspondencia_externa  FROM crp_correspondencia_externa WHERE (id_correspondencia_externa = '".$recepcion."')";
			$search->abrir();
			if($search->total_registros != 0)
			{
				$bus1 = new Recordset();
				$bus1->sql = "SELECT 
										  crp_correspondencia_externa.id_correspondencia_externa,
										  crp_correspondencia_externa.n_oficio_externo,
										  DATE_FORMAT(crp_correspondencia_externa.fecha_registro,'%d/%m/%Y %r') AS registro,
										  organismo.organismo,
										  crp_correspondencia_externa.contenido,
										  crp_correspondencia_externa.fecha_registro,
										  crp_correspondencia_externa.anexos 
										FROM crp_correspondencia_externa 
											INNER JOIN crp_correspondencia_externa_det ON (crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa) 
											INNER JOIN organismo ON (crp_correspondencia_externa_det.id_organismo = organismo.id_organismo) 
											INNER JOIN crp_ruta_correspondencia_ext ON (crp_correspondencia_externa.id_correspondencia_externa = crp_ruta_correspondencia_ext.id_correspondencia_externa) 										
										WHERE crp_correspondencia_externa.`id_correspondencia_externa` = '".$recepcion."' 
										GROUP BY crp_correspondencia_externa.id_correspondencia_externa"; 
				$bus1->abrir();
				if($bus1->total_registros != 0)
				{
					$bus1->siguiente();
					$n_oficio = $bus1->fila["n_oficio_externo"];
					$fregistro = $bus1->fila["registro"];																		
					$contenido = $bus1->fila["contenido"];		
					$annexos = $bus1->fila["anexos"];	
					$id_recepcion_correspondencia = $bus1->fila["id_recepcion_correspondencia"];
					$id_correspondencia_externa = $bus1->fila["id_correspondencia_externa"];					
					$organismo = $bus1->fila["organismo"];				
																							
//					$ = $bus->fila[""];											
				}
			
				$bus = new Recordset();
				$bus->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_ext.`fecha_recepcion`,'%d/%m/%Y') AS fecha_entrega, estatus.`estatus`, crp_ruta_correspondencia_ext.`id_correspondencia_externa`
								FROM crp_ruta_correspondencia_ext INNER JOIN estatus ON (crp_ruta_correspondencia_ext.`id_estatus` = estatus.`id_estatus`) 
								WHERE crp_ruta_correspondencia_ext.`id_correspondencia_externa` = '".$recepcion."' AND crp_ruta_correspondencia_ext.`id_estatus`= 6";
				$bus->abrir();
				if($bus->total_registros != 0)
				{
					$bus->siguiente();
					$estatus = $bus->fila["estatus"];
					$fdocumento = $bus->fila["fecha_entrega"];
				}
			}
	}
}
?>
<table width="100%" cellpadding="1" cellspacing="0">
	<tr>
		<td align="center">
			<table width="100%" align="center" cellpadding="2" cellspacing="0">
				<tr>
					<td width="30px"><img src="images/entregado.png"/></td>
					<td class="titulomenu" valign="middle">Visualizar Correspondencia</td>
				</tr>
				<tr>
					<td colspan="2" valign="top"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td align="center" valign="top">
			<table border="0" align="center" class="b_table" width="100%" height="300" bgcolor="#FFFFFF">			
				<tr valign="top">
					<td align="center">
						<fieldset style="width:97%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Detalle del Oficio Externo</legend>							
						<table border="0" cellpadding="3" ccellspacing="2" width="99%">						
							<tr>
								<td align="right" width="200">
									<b>N&deg; Oficio Externo:</b>&nbsp;
								</td>
								<td>
									<? 
										echo "<span class='mensaje'>".$n_oficio."</span>";
									?>								
								</td>
							</tr>
							<tr>
								<td align="right" valign="top">
									<b>Organismo Recepctor:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
										echo ucwords(mb_strtolower($organismo));										
									?>								
								</td>
							</tr>							
							<tr>
								<td align="right">
									<b>Fecha Emisi&oacute;n:&nbsp;</b>
								</td>
								<td>
									<? 
										echo $fregistro;
									?>																								
								</td>	
							</tr>
							<tr>
								<td align="right">
									<b>Fecha Entrega Organismo:&nbsp;</b>
								</td>
								<td>
									<? 									
										echo $fdocumento;																				
									?>																								
								</td>	
							</tr>
							<tr>
								<td align="right">
									<b>Estatus:&nbsp;</b>
								</td>
								<td>
									<? 									
										echo "<span class='mensaje'>".$estatus."</span>";																				
									?>																								
								</td>	
							</tr>																					
							<tr>
								<td align="right" valign="top">
									<b>Anexos:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
										if($annexos!="") { echo ucwords(mb_strtolower($annexos)); } else { echo "Sin Anexos"; }
									?>								
								</td>
							</tr>	
							<tr>
								<td align="right" valign="top">
									<b>Contenido:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
										echo ucwords(mb_strtolower($contenido));
									?>								
								</td>
							</tr>																																	
						</table>
						</fieldset>
						<br />						
						<table>
							<tr>
								<td align="center">								
									<input type="button" class="botones" onclick="window.top.closeMessage();" id="regresar" name="regresar" value="Regresar" title="Regresar" />																
								</td>
							</tr>							
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>