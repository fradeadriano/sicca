<?
session_start();
if(!stristr($_SERVER['SCRIPT_NAME'],"procesar.php")){
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
require_once("../../../librerias/Recordset.php");
require_once("../../../librerias/bitacora.php");	
?>
<script type="text/javascript" src="../../../librerias/funciones.js"></script>
<?
$recepcion = stripslashes($_GET["id_recepcion"]);
if ((isset($recepcion) && $recepcion !="")){	
	if(ctype_digit($recepcion)){	
		$search = new Recordset();
		$search->sql = "SELECT id_asignacion_correspondencia FROM crp_asignacion_correspondencia WHERE (id_recepcion_correspondencia = '".$recepcion."')";
			$search->abrir();
			if($search->total_registros != 0)
			{
				$bus = new Recordset();
				$bus->sql = "SELECT crp_recepcion_correspondencia.n_correlativo, DATE_FORMAT(crp_recepcion_correspondencia.fecha_documento,'%d/%m/%Y') AS fdocumento, DATE_FORMAT(crp_recepcion_correspondencia.fecha_registro,'%d/%m/%Y %r') AS registro, crp_recepcion_correspondencia.n_documento,
							  organismo.organismo, tipo_documento.tipo_documento, crp_recepcion_correspondencia.id_tipo_documento, crp_recepcion_correspondencia.n_correlativo_padre,
							  crp_recepcion_correspondencia.anfiscal, tipo_respuesta.tipo_respuesta, crp_recepcion_correspondencia.id_tipo_respuesta, 
							  crp_recepcion_correspondencia.gaceta_n, DATE_FORMAT(crp_recepcion_correspondencia.gaceta_fecha,'%d/%m/%Y') AS fecha_gaceta, 
							  crp_recepcion_correspondencia.gaceta_tipo, crp_recepcion_correspondencia.observacion, crp_recepcion_correspondencia.anexo,
							   DATE_FORMAT(crp_asignacion_correspondencia.fecha_asignacion,'%d/%m/%Y %r') AS f_asignacion,
							   IF(crp_asignacion_correspondencia.externo=1,'Requiere Oficio Externo.','No Requiere Oficio Externo.') AS externo,
							   crp_asignacion_correspondencia.accion, prioridad.prioridad, crp_asignacion_correspondencia.plazo,
							   crp_asignacion_correspondencia.copia_unidades, crp_asignacion_correspondencia.unidades_apoyo, crp_asignacion_correspondencia.observacion as ob_asig
							FROM
							  crp_recepcion_correspondencia LEFT JOIN organismo ON (crp_recepcion_correspondencia.id_organismo = organismo.id_organismo)
							  INNER JOIN tipo_documento 
							    ON (crp_recepcion_correspondencia.id_tipo_documento = tipo_documento.id_tipo_documento) 
								LEFT JOIN tipo_respuesta ON (crp_recepcion_correspondencia.id_tipo_respuesta = tipo_respuesta.id_tipo_respuesta)
    							INNER JOIN crp_asignacion_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_asignacion_correspondencia.id_recepcion_correspondencia)							  
								LEFT JOIN prioridad ON (crp_asignacion_correspondencia.id_prioridad = prioridad.id_prioridad)
							WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$recepcion."'";
				$bus->abrir();
				if($bus->total_registros != 0)
				{
					$bus->siguiente();
					$n_correlativo = $bus->fila["n_correlativo"];
					$fdocumento = $bus->fila["fdocumento"];
					$registro = $bus->fila["registro"];	
					$organismo = $bus->fila["organismo"];																		
					$n_documento = $bus->fila["n_documento"];	
					$id_tipo_respuesta = $bus->fila["id_tipo_respuesta"];
					$id_tipo_documento = $bus->fila["id_tipo_documento"];					
					$n_correlativo_padre = $bus->fila["n_correlativo_padre"];						
					$tipo_documento= $bus->fila["tipo_documento"];
					$tipo_respuesta = $bus->fila["tipo_respuesta"];											
					$anfiscal = $bus->fila["anfiscal"];
					$gaceta_n = $bus->fila["gaceta_n"];						
					$gaceta_tipo = $bus->fila["gaceta_tipo"];						
					$fecha_gaceta = $bus->fila["fecha_gaceta"];
					$observacion = $bus->fila["observacion"];				
					$anexos = $bus->fila["anexo"];	
					$f_asignacion = $bus->fila["f_asignacion"];																
					$accion = $bus->fila["accion"];																
					$externo = $bus->fila["externo"];	
					$prioridad = $bus->fila["prioridad"];
					$plazo = $bus->fila["plazo"];	
					$observacion = $bus->fila["observacion"];	
					$copia_unidades = $bus->fila["copia_unidades"];																
					$unidades_apoyo = $bus->fila["unidades_apoyo"];
					$ob_asig = $bus->fila["ob_asig"];												
																							
//					$ = $bus->fila[""];											
				}
			}
	}
	
	$searchD = new Recordset();
	$searchD->sql = "DELETE FROM temp";
	$searchD->abrir();
	$searchD->cerrar();
	unset($searchD);	
}

$asig = $_POST["metodo"];
if(isset($asig) && $asig =="asignar")
{
	$esxte = $_POST["n_oficio_ext"];
	$plaz = $_POST["plazo"];
	//$mensajero = $_POST["mensaje"];
	$con = $_POST["desicion"];
	$id = $_POST["id_recep"];
	$salida = $_POST["salid"];
	$Tip_Documen = $_POST["tipo_documento"];
	$Tip_ofic = $_POST["tipo_informe"];
	$contenido_ofic = $search->codificar(stripslashes($_POST["contenido"]));								
	$me = 0;	
	
	if(isset($salida) && $salida =="sel_org") 
	{	
		if(isset($con) && $con =="negativo")
		{
			$organis = $_POST["id_organismo_reci"];
			//if((isset($esxte) && $esxte !="") && (isset($mensajero) && $mensajero !=""))
			if((isset($esxte) && $esxte !=""))		
			{	
				$search = new Recordset();
				$search->sql = "SELECT id_correspondencia_externa FROM crp_correspondencia_externa WHERE n_oficio_externo = '".$esxte."' AND DATE_FORMAT(fecha_registro,'%Y') = '".date(Y)."'";
					$search->abrir();
					if($search->total_registros == 0)
					{
						$searchP = new Recordset();
						/*$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, id_mensajero, n_oficio_externo, plazo, fecha_registro) 
										values('".$id."', '".$mensajero."', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."');";*/
						if($Tip_Documen==1){
							$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, n_oficio_externo, plazo, fecha_registro, id_documento_cgr, id_documento_cgr_desgloce, contenido) 
											values('".$id."', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."', $Tip_Documen, $Tip_ofic, '$contenido_ofic');";									
						} else {
							$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, n_oficio_externo, plazo, fecha_registro, id_documento_cgr, contenido) 
											values('".$id."', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."', $Tip_Documen, '$contenido_ofic');";															
						}
						$searchP->abrir();
						$searchP->cerrar();
						unset($searchP);
						
						$searchB = new Recordset();
						$searchB->sql = "SELECT id_correspondencia_externa FROM crp_correspondencia_externa order by id_correspondencia_externa DESC LIMIT 1";
						$searchB->abrir();					
							if($searchB->total_registros != 0)
							{					
								$searchB->siguiente();
								$id_externo = $searchB->fila["id_correspondencia_externa"];	
							}
						$searchB->cerrar();
						unset($searchB);
	
						$searchD = new Recordset();
						$searchD->sql = "insert into crp_correspondencia_externa_det (id_correspondencia_externa,id_organismo) 
										values('".$id_externo."', '".$organis."');";
						$searchD->abrir();
						$searchD->cerrar();
						unset($searchD);
											
						bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia externa'","Registro de Correspondencia externa con oficio n&deg; '".$esxte."'para organismo identificado con '".$organis."',es relacionado con la correspondencia interna identificaci&oacute;n: '".$id."'");											
	
						$search_a = new Recordset();
						$search_a->sql = "SELECT id_recepcion_correspondencia FROM crp_asignacion_correspondencia WHERE id_recepcion_correspondencia =".$id." AND crp_asignacion_correspondencia.id_estatus = 4";
						$search_a->abrir();
						if($search_a->total_registros == 1)							
							{									
								$update = new Recordset();
								$update->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 5 WHERE id_recepcion_correspondencia = ".$id;
								$update->abrir();
								$update->cerrar();
								unset($update);	
								
								$search2 = new Recordset();
								$search2->sql = "INSERT INTO crp_ruta_correspondencia (id_estatus, id_recepcion_correspondencia,fecha_cambio_estatus,fecha_recepcion_digital) VALUES (5,$id,'".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
								$search2->abrir();
								$search2->cerrar();
								unset($search2);						
								
								//bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia externa con N&deg; identificaci&oacute;n:'".$id."'","Se ha cambiado el estatus de la correspondencia a Enviado. La misma ya tiene n&uacute;mero de oficio el cual es: '".esxte."' y ha sido enciada por el mensajero identificado como: '".$mensajero."'.");
								bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia externa con N&deg; identificaci&oacute;n:'".$id."'","Se ha cambiado el estatus de la correspondencia a Enviado. La misma ya tiene n&uacute;mero de oficio el cual es: '".esxte."'.");
							}
						$search_a->cerrar();
						unset($search_a);				
	
					} else {
						$me = 1;
					}
		
				$search->cerrar();
				unset($search);
			}
		} else if(isset($con) && $con =="positivo"){
			$organis = "";
	
			//if((isset($esxte) && $esxte !="") && (isset($mensajero) && $mensajero !=""))
			if((isset($esxte) && $esxte !=""))		
			{	
				$search = new Recordset();
				$search->sql = "SELECT id_correspondencia_externa FROM crp_correspondencia_externa WHERE n_oficio_externo = '".$esxte."' AND DATE_FORMAT(fecha_registro,'%Y') = '".date(Y)."'";
					$search->abrir();
					if($search->total_registros == 0)
					{
						$searchP = new Recordset();
	/*					$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, id_mensajero, n_oficio_externo, plazo, fecha_registro) 
										values('".$id."', '".$mensajero."', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."');";*/
						
						if($Tip_Documen==1){						
							$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, n_oficio_externo, plazo, fecha_registro, id_documento_cgr, id_documento_cgr_desgloce, contenido) 
											values('".$id."', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."', $Tip_Documen, $Tip_ofic, '$contenido_ofic');";									
						} else {						
							$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, n_oficio_externo, plazo, fecha_registro, id_documento_cgr, contenido) 
											values('".$id."', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."', $Tip_Documen, '$contenido_ofic');";									
						}
						$searchP->abrir();
						$searchP->cerrar();
						unset($searchP);
						
						$searchB = new Recordset();
						$searchB->sql = "SELECT id_correspondencia_externa FROM crp_correspondencia_externa order by id_correspondencia_externa DESC LIMIT 1";
						$searchB->abrir();					
							if($searchB->total_registros != 0)
							{					
								$searchB->siguiente();
								$id_externo = $searchB->fila["id_correspondencia_externa"];	
							}
						$searchB->cerrar();
						unset($searchB);
											
						$consul = new Recordset();
						$consul->sql = "SELECT temp.id_temp, organismo.id_organismo, temp.id_campo1 FROM temp INNER JOIN organismo ON (organismo.id_organismo = temp.id_campo1)";
							$consul->abrir();
							if($consul->total_registros != 0)
							{
								$searchD = new Recordset();
								for($i=0;$i<$consul->total_registros;$i++)
								{
									$consul->siguiente();						
									$searchD->sql = "insert into crp_correspondencia_externa_det (id_correspondencia_externa,id_organismo) 
													values('".$id_externo."', '".$consul->fila["id_organismo"]."');";
									$searchD->abrir();
								}	
								$searchD->cerrar();
								unset($searchD);								
							}					
						$consul->cerrar();
						unset($consul);						
						
						bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia externa'","Registro de Correspondencia externa con oficio n&deg; '".$esxte."'para los siguientes organismos identificado con: '".$organis."',es relacionado con la correspondencia interna identificaci&oacute;n: '".$id."'");																						
					
						$search_a = new Recordset();
						$search_a->sql = "SELECT id_recepcion_correspondencia FROM crp_asignacion_correspondencia WHERE id_recepcion_correspondencia =".$id." AND crp_asignacion_correspondencia.id_estatus = 4";
						$search_a->abrir();
						if($search_a->total_registros == 1)							
							{									
								$update = new Recordset();
								$update->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 5 WHERE id_recepcion_correspondencia = ".$id;
								$update->abrir();
								$update->cerrar();
								unset($update);	
								
								$search2 = new Recordset();
								$search2->sql = "INSERT INTO crp_ruta_correspondencia (id_estatus, id_recepcion_correspondencia,fecha_cambio_estatus,fecha_recepcion_digital) VALUES (5,$id,'".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
								$search2->abrir();
								$search2->cerrar();
								unset($search2);						
								
	//							bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia externa con N&deg; identificaci&oacute;n:'".$id."'","Se ha cambiado el estatus de la correspondencia a Enviado. La misma ya tiene n&uacute;mero de oficio el cual es: '".esxte."' y ha sido enciada por el mensajero identificado como: '".$mensajero."'.");
								bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia externa con N&deg; identificaci&oacute;n:'".$id."'","Se ha cambiado el estatus de la correspondencia a Enviado. La misma ya tiene n&uacute;mero de oficio el cual es: '".esxte."'.");
							}
						$search_a->cerrar();
						unset($search_a);	
									
					} else {
						$me = 1;
					}
		
				$search->cerrar();
				unset($search);
			}
		}
	} else if(isset($salida) && $salida =="sel_otro"){
			
			if((isset($esxte) && $esxte !=""))		
			{	
				$search = new Recordset();
				$search->sql = "SELECT id_correspondencia_externa FROM crp_correspondencia_externa WHERE n_oficio_externo = '".$esxte."' AND DATE_FORMAT(fecha_registro,'%Y') = '".date(Y)."'";
					$search->abrir();
					if($search->total_registros == 0)
					{
						$searchP = new Recordset();
						/*$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, id_mensajero, n_oficio_externo, plazo, fecha_registro) 
										values('".$id."', '".$mensajero."', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."');";*/
						if($Tip_Documen==1){
							$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, n_oficio_externo, plazo, fecha_registro, id_documento_cgr, id_documento_cgr_desgloce, contenido) 
											values('".$id."', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."', $Tip_Documen, $Tip_ofic, '$contenido_ofic');";									
						} else {
							$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, n_oficio_externo, plazo, fecha_registro, id_documento_cgr, contenido) 
											values('".$id."', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."', $Tip_Documen, '$contenido_ofic');";															
						}
						$searchP->abrir();
						$searchP->cerrar();
						unset($searchP);
																	
						bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia externa'","Registro de Correspondencia externa con oficio n&deg; '".$esxte."'para organismo identificado con '".$organis."',es relacionado con la correspondencia interna identificaci&oacute;n: '".$id."'");											
	
						$search_a = new Recordset();
						$search_a->sql = "SELECT id_recepcion_correspondencia FROM crp_asignacion_correspondencia WHERE id_recepcion_correspondencia =".$id." AND crp_asignacion_correspondencia.id_estatus = 4";
						$search_a->abrir();
						if($search_a->total_registros == 1)							
							{									
								$update = new Recordset();
								$update->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 5 WHERE id_recepcion_correspondencia = ".$id;
								$update->abrir();
								$update->cerrar();
								unset($update);	
								
								$search2 = new Recordset();
								$search2->sql = "INSERT INTO crp_ruta_correspondencia (id_estatus, id_recepcion_correspondencia,fecha_cambio_estatus,fecha_recepcion_digital) VALUES (5,$id,'".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
								$search2->abrir();
								$search2->cerrar();
								unset($search2);						
								
								//bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia externa con N&deg; identificaci&oacute;n:'".$id."'","Se ha cambiado el estatus de la correspondencia a Enviado. La misma ya tiene n&uacute;mero de oficio el cual es: '".esxte."' y ha sido enciada por el mensajero identificado como: '".$mensajero."'.");
								bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia externa con N&deg; identificaci&oacute;n:'".$id."'","Se ha cambiado el estatus de la correspondencia a Enviado. La misma ya tiene n&uacute;mero de oficio el cual es: '".esxte."'.");
							}
						$search_a->cerrar();
						unset($search_a);				
	
					} else {
						$me = 1;
					}
		
				$search->cerrar();
				unset($search);
			}
	}					
	
	
	if($me==1){
		echo '<script language="javascript" type="text/javascript">alert(acentos("Imposible registrar correspondencia externa: El N&deg; de oficio '.$esxte.' ya ha sido asignado"));</script>';			
	} else {
		echo '<script language="javascript" type="text/javascript">alert(acentos("Correspondencia externa ha sido registrada exitosamente!!"));</script>';			
		echo '<script language="javascript" type="text/javascript">window.top.document.formB.submit();</script>';
	}
	
	$searchD = new Recordset();
	$searchD->sql = "DELETE FROM temp";
	$searchD->abrir();
	$searchD->cerrar();
	unset($searchD);
	
}

$hp = new Recordset();
$hp->sql = "SELECT crp_correspondencia_externa.n_oficio_externo FROM crp_correspondencia_externa WHERE DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%Y') = '".date('Y')."' ORDER BY crp_correspondencia_externa.id_correspondencia_externa DESC LIMIT 1";			
$hp->abrir();
	if($hp->total_registros != 0)
	{			
		$hp->siguiente();
		$elultimo = $hp->fila["n_oficio_externo"];
		$transi=(int)$elultimo;
		$transi++;		
		$elnuevovalor = str_pad($transi, 5, "0", STR_PAD_LEFT);		
	} else {
		$elnuevovalor = str_pad("1", 5, "0", STR_PAD_LEFT);		
	}
$hp->cerrar();
unset($hp);	

?>

<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<table width="700px" align="center">
	<tr>
		<td align="center">
			<table width="99%" align="center" cellpadding="2" cellspacing="0">
				<tr>
					<td width="30px"><img src="../../../images/correspondencia.png"/></td>
					<td class="titulomenu" valign="middle">Generar Oficio Externo</td>
				</tr>
				<tr>
					<td colspan="2" valign="top"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td align="center" valign="top">
		<form action="" name="FormPro" id="FormPro" method="post" autocomplete="off">
		<input type="hidden" name="metodo" id="metodo" />
		
			<table border="0" align="center" class="b_table" width="100%" height="400" bgcolor="#FFFFFF">			
				<tr valign="top">
					<td align="center">
						<table border="0" cellpadding="3" ccellspacing="2" width="99%">
							<tr align="center" style="display:none" >
								<td colspan="3" align="center" height="0" id="divi_devo">                                 
								</td>
							</tr>							
							<tr>
								<td align="right" width="173">
									<b>Correlativo:</b>&nbsp;
								</td>
								<td>
									<? 
										echo "<span class='mensaje'>".$n_correlativo."</span>";
									?> 
								</td>
							</tr>
							<tr>
								<td align="right">
									<b>Fecha Documento:</b>&nbsp;
								</td>
								<td>
									<? 
										echo $fdocumento;
									?>																								
								</td>
								<td align="right">
									<b>Fecha Registro:&nbsp;</b>
								</td>
								<td>
									<? 
										echo $registro;
									?>																								
								</td>								
							</tr>
							<tr>
								<td align="right" width="150">
									<b>N&deg; Documento:</b>&nbsp;
								</td>
								<td>
									<? 
										if ($n_documento!=""){echo $n_documento;} else {echo "<u>Sin N&uacute;mero</u>";}
									?>								
								</td>								
							</tr>							
							<tr>
								<td align="right">
									<b>Organismo:</b>&nbsp;
								</td>
								<td colspan="3">
									<? 
										echo ucwords(mb_strtolower($organismo));
									?>								
								</td>
							</tr>																										
<?						if($id_tipo_documento==5) // oficio
							{
?>
							<tr>
								<td align="right" width="160">
									<b>Tipo Documento:</b>
								</td>
								<td>
									<? 
										echo $tipo_documento;
									?>																			
								</td>											
							</tr>
<?
						if(ctype_digit($id_tipo_respuesta)){
									?>		
							<tr>
								<td align="right" width="120">
									<b>Tipo Respuesta:</b>
								</td>
								<td>
									<? 
										echo $tipo_respuesta;
									?>																			
								</td>
								<td align="right" width="150">
									<b>En respuesta a Oficio:</b>
								</td>
								<td>
									<? 
										if (ctype_digit($n_correlativo_padre)) {echo $n_correlativo_padre; } else { echo "<input type='text' name='oficio_padre' id='oficio_padre' maxlength='6' onkeypress='return validar(event,numeros)'/>&nbsp;<span class='mensaje'>*</span>";}												 	
									?>																			
								</td>											
							</tr>
<? 						if($id_tipo_respuesta==1 || $id_tipo_respuesta==2) { 
?>
							<tr>
								<td align="right">
									<b>Ejercicio Fiscal:</b>
								</td>
								<td align="left">
									<?
										echo $anfiscal;	
									?>													
								</td>																						
							</tr>										
<?							}
					} 					
	} else if($id_tipo_documento==11){ //gaceta   
?>											
							<tr>
								<td align="right" width="120">
									<b>Tipo Documento:</b>
								</td>
								<td>
									<? 
										echo $tipo_documento;
									?>																			
								</td>
								<td align="right" width="120">
									<b>N&deg; Gaceta:</b>
								</td>
								<td>
									<? 
										echo $gaceta_n;
									?>																			
								</td>																						
							</tr>
							<tr>
								<td align="right" width="120">
									<b>Fecha Gaceta:</b>
								</td>
								<td>
									<? 
										echo $fecha_gaceta;
									?>																			
								</td>
								<td align="right" width="120">
									<b>Tipo Gaceta:</b>
								</td>
								<td>
									<? 
										echo $gaceta_tipo;
									?>																			
								</td>																						
							</tr>																					
<?										
	} else if($id_tipo_documento==4){ //invitaciones  
?>
							<tr>
								<td align="right" width="120">
									<b>Tipo Documento:</b>
								</td>
								<td>
									<? 
										echo $tipo_documento;
									?>																			
								</td>
							</tr>
<?
	} else if($id_tipo_documento==6){ //donaciones  
?>
							<tr>
								<td align="right" width="120">
									<b>Tipo Documento:</b>
								</td>
								<td>
									<? 
										echo $tipo_documento;
									?>																			
								</td>
							</tr>
<?
	} else if($id_tipo_documento==12){ //denuncia  
?>
							<tr>
								<td align="right" width="120">
									<b>Tipo Documento:</b>
								</td>
								<td>
									<? 
										echo $tipo_documento;
									?>																			
								</td>
							</tr>
<?
	}								
					if($anexos!=""){
									?>
							<tr>
								<td align="right" width="120">
									<b>Anexos:</b>
								</td>
								<td colspan="3">
									<? 
										echo $anexos;
									?>																			
								</td>
							</tr>
									<?   }   ?>											
							<tr>
								<td align="right" width="120" valign="top">
									<b>Observaci&oacute;n:</b>
								</td>
								<td colspan="3">
									<? 
										echo $observacion;
									?>																			
								</td>
							</tr>																		
							<tr>
								<td align="right">
									<b>Fecha Asignaci&oacute;n:</b>
								</td>
								<td>
									<? 
										echo $f_asignacion;
									?>								
								</td>											
							</tr>									
							<tr>
								<td align="right" width="150">
									<b>Acci&oacute;n:</b>
								</td>
								<td colspan="3">
									Correspondencia para <? echo "<u>".$accion."</u> y ".$externo;?> 

								</td>
							</tr>
						<?
							if($prioridad!="" || is_null(prioridad)==true){
						?>
							<tr>
								<td align="right" width="150">
									<b>Prioridad:</b>
								</td>
								<td colspan="2">
									<? echo "<b><u>".$prioridad."</u></b>"; if ($plazo!="") {echo " Con un Plazo de ".$plazo." d&iacute;as."; }?> 
								</td>
							</tr>																														
						<?
						}
							if($copia_unidades!="" || is_null(copia_unidades)==true){
						?> 
							<tr>
								<td align="right">
									<b>Con Copia a:</b>
								</td>
								<td colspan="3">
									<?
										$Var = explode("-",$copia_unidades);
										$rsdocu = new Recordset();
										$SqL = "";
										for($r=0;$r<count($Var);$r++){
											if($SqL == ""){
												$SqL = "SELECT id_unidad, unidad, codigo FROM unidad WHERE id_unidad =".$Var[$r];
											} else if ($SqL != ""){
												$SqL = $SqL." UNION SELECT id_unidad, unidad, codigo FROM unidad WHERE id_unidad =".$Var[$r];													
											}
										}
										$rsdocu->sql = $SqL;
										$rsdocu->abrir();
										for($i=0;$i<$rsdocu->total_registros;$i++){
											$rsdocu->siguiente();
											echo "- ".$rsdocu->fila["unidad"].".<br>";
										}												
									?>
								</td>
							</tr>
							<? 
							}
							?>
							<?
							if($unidades_apoyo!="" || is_null(unidades_apoyo)==true){
										?> 
							<tr>
								<td align="right">
									<b>Con Apoyo de:</b>
								</td>
								<td colspan="3">
									<?
										$Var = explode("-",$unidades_apoyo);
										$rsdocu = new Recordset();
										$SqL = "";
										for($r=0;$r<count($Var);$r++){
											if($SqL == ""){
												$SqL = "SELECT id_unidad, unidad, codigo FROM unidad WHERE id_unidad =".$Var[$r];
											} else if ($SqL != ""){
												$SqL = $SqL." UNION SELECT id_unidad, unidad, codigo FROM unidad WHERE id_unidad =".$Var[$r];													
											}
										}
										$rsdocu->sql = $SqL;
										$rsdocu->abrir();
										for($i=0;$i<$rsdocu->total_registros;$i++){
											$rsdocu->siguiente();
											echo "- ".$rsdocu->fila["unidad"].".<br>";
										}
										$Var="";
										$rsdocu->cerrar();
										unset($rsdocu);												
									?>
								</td>
							</tr>
							<? 
							}
							?>										
							<tr>
								<td valign="top" align="right" width="160px"><b>Informaci&oacute;n Asignaci&oacute;n:</b></td>
								<td colspan="3">
									<? echo $ob_asig; ?>
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<fieldset style="width:97%; border-color:#EFEFEF"> 
									<legend class="titulomenu">Detalle del Envio</legend>		
									<table border="0" cellpadding="3" ccellspacing="3" width="99%">
										<tr>
											<td width="203" align="right">
												N&deg; Oficio / Circular:
											</td>
											<td width="180">
												<input type="text" name="n_oficio_ext" id="n_oficio_ext" style="width:120px" maxlength="5" onkeypress="return validar(event,numeros)" onchange="life(this.value,'objeto');"/>&nbsp;<span class="mensaje">*</span>&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../../images/Help_16x16.png" style="cursor:pointer" title="EL n&uacute;mero de oficio que corresponden es: <? echo $elnuevovalor; ?>" />
											</td>
											<td width="120" align="right">
												<b>Plazo:</b>
											</td>
											<td>
												&nbsp;<input type="text" name="plazo" id="plazo" style="width:20px" maxlength="2" onkeypress="return validar(event,numeros)"/>&nbsp;d&iacute;as
											</td>
										</tr>
									
<!--										<tr>
											<td width="150" align="right">
												<b>Mensajero:</b>
											</td>
											<td><? 
/*												$rsmen = new Recordset();
												$rsmen->sql = "SELECT id_mensajero, nombre_apellido FROM mensajero WHERE activo=0"; 
												$rsmen->llenarcombo($opciones = "\"mensaje\"", $checked = "", $fukcion = "" , $diam = "style=\"width:140px; Height:20px;\""); 
												$rsmen->cerrar(); 
												unset($rsmen);*/																						
												?>&nbsp;<span class="mensaje">*</span>
											</td>
										</tr>-->
										<tr>
											<td width="160" align="right">
												Tipo Documento:								
											</td>
											<td>
												<?
												$rsmen = new Recordset();
												$rsmen->sql = "SELECT id_tipo_documento_cgr, tipo_documento_cgr FROM tipo_documento_cgr"; 
												$rsmen->llenarcombo($opciones = "\"tipo_documento\"", $checked = "", $fukcion = "onchange=\"cagr(this.value);\"" , $diam = "style=\"width:122px; Height:20px;\""); 
												$rsmen->cerrar(); 
												unset($rsmen);									
												?>&nbsp;<span class="mensaje">*</span>
											</td>							
										</tr>
										<tr id="infm" style="display:none">
											<td width="160" align="right">
												Tipo Oficio:								
											</td>
											<td>
												<?
												$rsmen = new Recordset();
												$rsmen->sql = "SELECT documento_cgr_desgloce.id_documento_cgr_desgloce, documento_cgr_desgloce.documento_cgr_desgloce FROM documento_cgr_desgloce WHERE documento_cgr_desgloce.id_documento_cgr_desgloce = 1"; 
												$rsmen->llenarcombo($opciones = "\"tipo_informe\"", $checked = "", $fukcion = "" , $diam = "style=\"width:160px; Height:20px;\""); 
												$rsmen->cerrar(); 
												unset($rsmen);									
												?>&nbsp;<span class="mensaje">*</span>
											</td>							
										</tr>																				
										<tr>
											<td align="right">
												Salida:	
											</td>							
											<td colspan="2">
												Organismo/Cgr&nbsp;<input type="radio" name="salid" id="org_cgr" checked="checked"  onclick="sali(this.id);" value="sel_org" />&nbsp;&nbsp;&nbsp;&nbsp;
														Otros&nbsp;<input type="radio" value="sel_otro" name="salid" id="otro" onclick="sali(this.id);" />															
											</td>
										</tr>							
										<tr id="salida_1">
											<td colspan="4">
												<table border="0" cellpadding="2" cellspacing="2" width="100%">										
													<tr>
														<td width="200" align="right">M&aacute;s de un Organismo &oacute; Direcci&oacute;n:</td>
														<td colspan="2">Si&nbsp;<input type="radio" name="desicion" id="si" onclick="invo(this.id);" value="positivo" />&nbsp;&nbsp;No&nbsp;<input type="radio" value="negativo" name="desicion" id="no" checked="checked" onclick="invo(this.id);" /></td>
													</tr>									
													<tr>
														<td width="150" align="right" valign="top">
															Organismo &oacute; Direcci&oacute;n:
														</td>
														<td colspan="3">
															<textarea name="organismo_reci" id="organismo_reci" style="width:300px; height:55px;" ></textarea>&nbsp;<span class="mensaje">*</span>
															<input type="hidden" name="id_organismo_reci" id="id_organismo_reci"  />
														</td>
													</tr>							
													<tr><td></td></tr>
													<tr id="uno" style="display:none">
														<td colspan="4" align="center"  >
															<table align="center" border="0" width="90%" class="b_table" id="llint">
																<tr>
																	<td colspan="3" align="right"><input type="hidden" name="can" id="can" /><input type="button" name="btnagregar" id="btnagregar" value="Agregar" title="Agregar" onclick="age(document.getElementById('id_organismo_reci').value);"/></td>
																</tr>													
																<tr class="trcabecera_list">
																	<td width="30px" align="center">
																		N&deg;
																	</td>
																	<td width="180px" align="center">
																		Organismo &oacute; Direcci&oacute;n
																	</td>
																	<td width="30px" align="center">
																		Acci&oacute;n
																	</td>														
																</tr>
																<tr >
																	<td colspan="3" ><table  width="100%" border="0" class="b_table1"><tr><td align="center">No Ex&iacute;sten Datos a mostrar</td></tr></table></td>
																</tr>
															</table>
														</td>
													</tr>																														
												</table>
											</td>
										</tr>
										<tr>
											<td width="160" align="right" valign="top">
												Contenido:								
											</td>
											<td colspan="3">
												<textarea id="contenido" name="contenido" onblur="formatotexto(this)" style="width:300px; height:105px" onKeyUp="return maximaLongitud(this.id,300);"></textarea>&nbsp;<span class="mensaje">*</span><br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span>
											</td>							
										</tr>										
										<tr height="25" valign="bottom"><td align="right" class="mensaje" colspan="5">* Campos Obligatorios&nbsp;&nbsp;</td></tr>																														
									</table>
									</fieldset>									
								</td>
							</tr>							
							<tr>
								<td align="center" colspan="4">
									<input type="hidden" name="id_recep" id="id_recep" value="<? echo $recepcion; ?>" />
									<input type="hidden" name="id_unidad" id="id_unidad" value="<? echo $UunidadD; ?>" />									
									<input type="button" name="btnRegistrar" id="btnRegistrar" value="Registrar Envio" title="Registrar Envio" onclick="reg();" />
									&nbsp;&nbsp;
									<input type="button" class="botones" id="limpiar" name="limpiar" value="Limpiar" title="Limpiar" onclick="limp();" />																
									&nbsp;&nbsp;
									<input type="button" class="botones" id="cancelar" name="cancelar" value="Cancelar" title="Cancelar" onclick="canc();" />																
								</td>
							</tr>							
						</table>
					</td>
				</tr>
			</table>
		</form>
		</td>
	</tr>
</table>
<script language="javascript" type="text/javascript" src="../../../librerias/jq.js"></script>
<script language="javascript" type="text/javascript" src="../../../librerias/jquery.autocomplete.js"></script>
<script language="javascript" type="text/javascript" src="../../../librerias/dhtml/ajax.js"></script>
<script type="text/javascript" src="../../../librerias/dhtml/dhtmlSuite-common.js"></script>
<script type="text/javascript">
	DHTML_SUITE_JS_FOLDER = "../../../librerias/dhtml/";
	DHTML_SUITE_THEME_FOLDER = "../../../librerias/dhtml/themes";
	DHTMLSuite.include("modalMessage");
</script>
<? require_once("bil.php"); ?>
<script language="javascript" type="text/javascript">
	$("#organismo_reci").autocomplete("../../../modulos/correspondencia/procesar/lista.php", { 
		width: 400,
		matchContains: true,
		mustMatch: false,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});

	$("#organismo_reci").result(function(event, data, formatted) {
		try {
			$("#id_organismo_reci").val(data[1]);
		} catch(e) {
			e.name;		
		}
	});	
</script>