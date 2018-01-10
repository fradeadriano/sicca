<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acceso Ilegal</title>
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
require_once("librerias/Recordset.php");
require_once("librerias/bitacora.php");
require_once("bil.php");

if (!isset($_SESSION["spam"]))
    $_SESSION["spam"] = rand(1, 99999999);
	if ((isset($_POST["spam"]) && isset($_SESSION["spam"])) && $_POST["spam"] == $_SESSION["spam"]) 
		{
//-----------------------------------------------------------------------------------------------------------------------------------------------
		$tipo = "";
		$rssolicitud = new Recordset();
		$rssolicitud->sql = "SELECT n_correlativo FROM crp_recepcion_correspondencia_cgr WHERE n_correlativo like '".date("Y")."%' order by id_recepcion_correspondencia_cgr desc limit 1";
		$rssolicitud->abrir();
		if($rssolicitud->total_registros > 0)
			{	
				$rssolicitud->siguiente();
				$codviejo = explode("-",$rssolicitud->fila["n_correlativo"]);
				$fechanueva = date("Y");
				if ($codviejo[0] == $fechanueva)
				{
					$nuevovalor=(int)$codviejo[1];
					$nuevovalor++;
					$nuevovalor = str_pad($nuevovalor, 5, "0", STR_PAD_LEFT);
					$codnuevo= $fechanueva."-".$nuevovalor."-CGR";
				}
				else
				{
					$nuevovalor= str_pad("1", 5, "0", STR_PAD_LEFT);
					$codnuevo= $fechanueva."-".$nuevovalor."-CGR";
				}
			} else {
				$fechanueva = date("Y");
				$nuevovalor= str_pad("1", 5, "0", STR_PAD_LEFT);
				$codnuevo= $fechanueva."-".$nuevovalor."-CGR";
			}				
//-----------------------------------------------------------------------------------------------------------------------------------------------

			$ins = new Recordset();
			$accion = stripslashes($_POST["accion"]);
			if(isset($accion) && $accion=="registrar")
				{
					$campos = "";
					$valores = "";
					
					$direcc_remitentea = stripslashes($_POST["direcc_remitente"]);
					$id_direcc_remitentea = stripslashes($_POST["id_direcc_remitente"]);
					$fe_documentoa = $ins->formatofecha(stripslashes($_POST["fe_documento"]));
					//$fe_registroa = $ins->formatofecha(stripslashes($_POST["fe_registro"]));					
					$observaciona = stripslashes($_POST["observacion"]);					
					$anexosa = stripslashes($_POST["listAnexo"]);					
//					$procesamientoa = stripslashes($_POST["procesamiento"]);
					$tcomunicaciona = stripslashes($_POST["tcomunicacion"]);					
					$plazoa = stripslashes($_POST["plazo"]);					
					
					if($id_direcc_remitentea!= "")
						{					
							$direcgr = $_POST["direcc_remitente"];
							$campos = "id_organismo_cgr";
							$valores = "$id_direcc_remitentea";			
							$tipo = "Correspondencia es remitida por $direcgr ($id_direcc_remitentea)";									
						}
						
					$n_documentoa = stripslashes($_POST["n_documento"]);					
					if($n_documentoa!= "")
						{					
							$campos = $campos.", n_oficio_circular";
							$valores = $valores.", '$n_documentoa'";									
							$tipo = $tipo." con oficio o circular n&deg; $n_documentoa";
						}
						
					if($fe_documentoa!= "")
						{	
							$campos = $campos.", fecha_documento";
							$valores = $valores.", '$fe_documentoa'";			
							$tipo = $tipo.", la fecha corresponde a $fe_documentoa";																
						}
						
					if($observaciona!= "")
						{					
							$campos = $campos.", observacion";
							$valores = $valores.", '".$ins->codificar($observaciona)."'";			
							$tipo = $tipo.", con las siguientes observaciones: ".$ins->codificar($observaciona);																							
						}	
						
					if($anexosa!= "")
						{					
							$campos = $campos.", anexos";
							$valores = $valores.", '".$ins->codificar($anexosa)."'";	
							$tipo = $tipo.", y anexos: ".$ins->codificar($anexosa);									
						}																																			

/*					if($procesamientoa!= "")
						{					
							if ($procesamientoa=="procesar"){
								$campos = $campos.", accion";
								$valores = $valores.", 0";
								$tipo = $tipo.". Dicho documento sera Procesado";																		
							} else if ($procesamientoa=="archivar"){
								$campos = $campos.", accion";
								$valores = $valores.", 1";
								$tipo = $tipo.". Dicho documento sera Archivado";																		
							}		
						}*/												
						
					if($tcomunicaciona!= "")
						{					
							$campos = $campos.", id_tipo_documento";
							$valores = $valores.", $tcomunicaciona";
							$tipo = $tipo." y el tipo de oficio o circular corresponden a: $tcomunicaciona";									
						}	

/*					if($tcomunicaciona == "8")
						{	
							$noti_a = stripslashes($_POST["noti"]);
							
							if ($noti_a=="notiOrga")
							{
								$tipo = $tipo.", va dirigido a un organ&iacute;smo";
								$n_notificaciona = stripslashes($_POST["n_notificacion"]);
								$id_organismoa = stripslashes($_POST["id_organismo"]);								
								$plazoa = stripslashes($_POST["plazo"]);																
									if ($n_notificaciona!=""){
										$campos = $campos.", n_notificacion";
										$valores = $valores.", '$n_notificaciona'";	
										$tipo = $tipo.", el n&deg; notificaci&oacute;n es: $n_notificaciona";									
									}
									
									if ($id_organismoa!=""){
										$orga = utf8_decode($_POST["organismo"]);
										$campos = $campos.", id_organismo";
										$valores = $valores.", $id_organismoa";										
										$tipo = $tipo.", es dirigido al organ&iacute;smo $orga";																			
									}									
									
									if ($plazoa!=""){
										$campos = $campos.", plazo";
										$valores = $valores.", $plazoa";						
										$tipo = $tipo."con un plazo de $plazoa d&iacute;as";														
									}									
							}
							
							if ($noti_a=="notiCiu"){
								$tipo = $tipo.", va dirigido a un ciudadano";							
								$ciudadanoa = stripslashes($_POST["ciudadano"]);
								$n_notificaciona = stripslashes($_POST["n_notificacion"]);
								$direcciona = stripslashes($_POST["direccion"]);								
								$telefonoa = stripslashes($_POST["telefono"]);																
								$plazoa = stripslashes($_POST["plazo"]);																
									if ($n_notificaciona!=""){
										$campos = $campos.", n_notificacion";
										$valores = $valores.", '$n_notificaciona'";	
										$tipo = $tipo.", el n&deg; notificaci&oacute;n es: $n_notificaciona";									
									}
																		
									if ($ciudadanoa!=""){
										$campos = $campos.", nombre";
										$valores = $valores.", '".$ins->codificar($ciudadanoa)."'";							
										$tipo = $tipo.", llamado: ".$ins->codificar($ciudadanoa);																				
									} 
									
									if ($direcciona!=""){
										$campos = $campos.", direccion";
										$valores = $valores.", '".$ins->codificar($direcciona)."'";										
										$tipo = $tipo.", ubicado en la direcci&oacute;n: ".$ins->codificar($direcciona);																														
									}	
									
									if ($telefonoa!=""){
										$campos = $campos.", telefono";
										$valores = $valores.", '$telefonoa'";										
										$tipo = $tipo.", tel&eacute;fono contacto: $telefonoa";
									}																	
									
									if ($plazoa!=""){
										$campos = $campos.", plazo";
										$valores = $valores.", $plazoa";						
										$tipo = $tipo.", con plazo de $plazoa d&iacute;as";														
									}								
							}
						}*/
						
					if($tcomunicaciona == "10")
						{
							$n_respuestaa = stripslashes($_POST["n_respuesta"]);
							$unidada = stripslashes($_POST["unidad"]); 																	
							if ($n_respuestaa!=""){
								$campos = $campos.", n_respuesta_oficio";
								$valores = $valores.", '$n_respuestaa'";										
								$tipo = $tipo.", el n&deg; de respuesta es: $n_respuestaa ";
							}
							
							if ($unidada!=""){
								$campos = $campos.", id_unidad";
								$valores = $valores.", $unidada";						
								$tipo = $tipo." y ha sido direccionado a la unidad administrativa identificada con el n&deg;: $unidada ";
							}
						}
						
					if($tcomunicaciona== "9")
						{
							$plazoa = stripslashes($_POST["plazo"]);
							$unidada = stripslashes($_POST["unidad"]); 																	
							if ($unidada!=""){
								$campos = $campos.", id_unidad";
								$valores = $valores.", $unidada";	
								$tipo = $tipo." y ha sido direccionado a la unidad administrativa identificada con el n&deg;: $unidada ";																	
							}

							if ($plazo!=""){
								$campos = $campos.", plazo";
								$valores = $valores.", $plazoa";	
								$tipo = $tipo." con un plazo de $plazoa d&iacute;as";									
							}								
						}
						
					if($tcomunicaciona== "13")
						{
							$plazoa = stripslashes($_POST["plazo"]);
							$unidada = stripslashes($_POST["unidad"]);
							$requiere_ofic = stripslashes($_POST["requiere_oficio"]);							 																	
							if($requiere_ofic==1){$accionn = "necesitando un oficio para dar respuesta";} else {$accionn = "No requiriendo oficio externo";}
							if ($unidada!=""){
								$campos = $campos.", id_unidad, accion";
								$valores = $valores.", $unidada, $requiere_ofic";	
								$tipo = $tipo." y ha sido direccionado a la unidad administrativa identificada con el n&deg;: $unidada,  $accionn";																	
							}

							if ($plazo!=""){
								$campos = $campos.", plazo";
								$valores = $valores.", $plazoa";	
								$tipo = $tipo." con un plazo de $plazoa d&iacute;as";									
							}								
						}						
// _________________________________________________________________________________________________________________________________________________________________________					
						if ($plazoa!=""){
							function fechaFinHabiles($fecha, $dias) {
								if ($dias==1 || $dias==0) $dias=0; else $dias--;
								$sumar=true;
								$dia_semana=getDiaSemana($fecha);	//echo "<tr><td colspan='9'>$dia_semana=getDiaSemana($fecha);</td></tr>";
								list($dia, $mes, $anio)=SPLIT('[/.-]', $fecha);
								$d=(int) $dia; $m=(int) $mes; $a=(int) $anio;
								
								for ($i=1; $i<=$dias;) {
									$dia_semana++;
									if ($dia_semana==8) $dia_semana=1;
									if ($dia_semana>=1 && $dia_semana<=5) $i++;
									$d++;
									$dias_mes=getDiasMes($a, $m);
									if ($d>$dias_mes) { 
										$d=1; $m++; 
										if ($m>12) { $m=1; $a++; }
									}
									
								}
								if ($d<10) $d="0$d";
								if ($m<10) $m="0$m";
								return "$d-$m-$a";
							}									
							function getDiaSemana($fecha) {
								// primero creo un array para saber los días de la semana
								$dias = array(0, 1, 2, 3, 4, 5, 6);
								$dia = substr($fecha, 0, 2);
								$mes = substr($fecha, 3, 2);
								$anio = substr($fecha, 6, 4);
								
								// en la siguiente instrucción $pru toma el día de la semana, lunes, martes,
								$pru = strtoupper($dias[intval((date("w",mktime(0,0,0,$mes,$dia,$anio))))]);
								return $pru;
							}
							function getDiasMes($anio, $mes) {
								$dias_mes[1]=31;
								if ($anio%4==0) $dias_mes[2]=29; else $dias_mes[2]=28;
								$dias_mes[3]=31;
								$dias_mes[4]=30;
								$dias_mes[5]=31;
								$dias_mes[6]=30;
								$dias_mes[7]=31;
								$dias_mes[8]=31;
								$dias_mes[9]=30;
								$dias_mes[10]=31;
								$dias_mes[11]=30;
								$dias_mes[12]=31;
								return $dias_mes[$mes];
							}
							function getDiasFeriados($fdesde, $fhasta){
								
									mysql_connect("localhost", "root", "syslogadmin") or die ("NO SE PUDO CONECTAR CON EL SERVIDOR MYSQL!");
									mysql_select_db("sicca") or die ("NO SE PUDO CONECTAR CON LA BASE DE DATOS!");
									
									list($dia_desde, $mes_desde, $anio_desde)=SPLIT('[/.-]', $fdesde); $DiaDesde = "$mes_desde-$dia_desde";
									list($dia_hasta, $mes_hasta, $anio_hasta)=SPLIT('[/.-]', $fhasta); $DiaHasta = "$mes_hasta-$dia_hasta";
									
										$sql = "SELECT DiaFeriado, annoferiado 
											FROM feriados 
											WHERE 
												((annoferiado = '".$anio_desde."' OR annoferiado = '".$anio_hasta."') AND  (DiaFeriado >= '".$DiaDesde."' AND DiaFeriado <= '".$DiaHasta."')) ";
									$query = mysql_query($sql) or die ($sql.mysql_error());
									$rows = mysql_num_rows($query);	$dias_feriados = 0;
									while ($field = mysql_fetch_array($query)) {
										list($mes, $dia) = SPLIT('[/.-]', $field['DiaFeriado']);
										if ($field['annoferiado'] == "") $anio = $anio_desde; else $anio = $field['annoferiado'];
										$fecha = "$dia-$mes-$anio";
										$dia_semana = getDiaSemana($fecha);
										if ($dia_semana >= 1 && $dia_semana <= 5) $dias_feriados++;
										if ($anio_desde != $anio_hasta) {
											if ($field['annoferiado'] == "") $anio = $anio_hasta; else $anio = $field['annoferiado'];
											$fecha = "$dia-$mes-$anio";
											$dia_semana = getDiaSemana($fecha);
											if ($dia_semana >= 1 && $dia_semana <= 5) $dias_feriados++;
										}
									}
									return $dias_feriados;

							}
							function getFechaFinHabiles($fecha, $dias) {
								$finicio = $fecha;
								$ffin = fechaFinHabiles($finicio, $dias);	
								$dias_feriados = 0;
								do {
									$feriados = getDiasFeriados($finicio, $ffin) - $dias_feriados;	
									$dias += $feriados;	
									$ffin = fechaFinHabiles($finicio, $dias);
									$dias_feriados += $feriados;
								} while ($feriados > 0);
								return $ffin;
							}										
							$fecha_vencimiento = getFechaFinHabiles(date('d-m-Y'),$plazoa+1);	
							$fe = new Recordset();
							
							$campos = $campos.", fecha_vencimiento";
							$valores = $valores.", '".$fe->formatofecha($fecha_vencimiento,'-')."'";	
							$tipo = $tipo." con una fecha de vencimiento para ".$fe->formatofecha($fecha_vencimiento,'-');								
						}							
// _________________________________________________________________________________________________________________________________________________________________________						
					if($n_documentoa!= "")
						{						
							$search = new Recordset();
							$search->sql = "SELECT id_recepcion_correspondencia_cgr FROM crp_recepcion_correspondencia_cgr WHERE n_oficio_circular = '".$n_documentoa."' AND DATE_FORMAT(fecha_documento,'%Y') = '".date("Y")."' ";
								$search->abrir();
								if($search->total_registros == 0)
								{
									$ins = new Recordset();
									$ins->sql = "INSERT INTO crp_recepcion_correspondencia_cgr ( ".$campos.", fecha_registro, hora_registro, n_correlativo )"." VALUES ( ".$valores.", '".date("Y-m-d H:i:s")."', '".date("H:i:s")."', '".$codnuevo."' )";
//									$ins->sql = "INSERT INTO crp_recepcion_correspondencia_cgr ( ".$campos.", fecha_registro, hora_registro, n_correlativo )"." VALUES ( ".$valores.", '".$fe_registroa."', '".date("H:i:s")."', '".$codnuevo."' )";

									$ins->abrir();
									$ins->cerrar();
									unset($ins);		
									/*bitacora*/bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia CGR n&deg; '".$codnuevo."'","Se registro una Correspondencia proveniente de la CGR (correlativo: '".$codnuevo."') ".$tipo.".");

									$sel = new Recordset();
									$sel->sql = "SELECT id_recepcion_correspondencia_cgr FROM crp_recepcion_correspondencia_cgr ORDER BY crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr DESC LIMIT 1";
									$sel->abrir();
									if($sel->total_registros != 0)
										{											
											$sel->siguiente();
											$id = $sel->fila["id_recepcion_correspondencia_cgr"];
										}
									$sel->cerrar();
									unset($sel);									
									
									switch($tcomunicaciona){
										case 7: //invitacion
											$ins = new Recordset();
											$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", 1, '".date("Y-m-d H:i:s")."', 6 )"; //entregado
											$ins->abrir();
											$ins->cerrar();
											unset($ins);	
											$elestatus = 6;																			
										break;
										
										case 8: //notificacion
											$consul = new Recordset();
											$consul->sql = "SELECT id_temp, id_campo1, id_campo2, id_campo3, id_campo4 FROM temp";
												$consul->abrir();
												if($consul->total_registros != 0)
												{
													for($gh=0;$gh<$consul->total_registros;$gh++)
													{
														$consul->siguiente();
														if (ctype_digit($consul->fila["id_campo2"]) == true)
														{
															$searchD = new Recordset();
															$searchD->sql = "INSERT INTO crp_recepcion_cgr_detalle (`id_recepcion_correspondencia_cgr`, `id_organismo`, `n_notificacion`, enviado, `entregado`) 
																			  VALUES (".$id.", ".$consul->fila["id_campo2"].", '".$consul->fila["id_campo1"]."', 1, 1);";
															$searchD->abrir();
															$searchD->cerrar();
															unset($searchD);														
														} else {													
															$searchD = new Recordset();
															$searchD->sql = "INSERT INTO crp_recepcion_cgr_detalle (`id_recepcion_correspondencia_cgr`, `n_notificacion`, `nombre`, `direccion`, `telefono`, enviado, `entregado`)  
																			  VALUES (".$id.", '".$consul->fila["id_campo1"]."', '".$consul->fila["id_campo2"]."', '".$consul->fila["id_campo3"]."', '".$consul->fila["id_campo4"]."', 1, 1);";
															$searchD->abrir();
															$searchD->cerrar();
															unset($searchD);														
														}
													}	
																					
												}					
											$consul->cerrar();
											unset($consul);						

											$ins = new Recordset();
											$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) 
														VALUES ( ".$id.", 1, '".date("Y-m-d H:i:s")."', 7 )"; //recibido
											$ins->abrir();
											$ins->cerrar();
											unset($ins);
											
											$searchD = new Recordset();
											$searchD->sql = "DELETE FROM temp";
											$searchD->abrir();
											$searchD->cerrar();
											unset($searchD);											
											$elestatus = 7;
										break;
										
										case 9: //solicitud

											$ins = new Recordset();
											if($unidada==1){												
												$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", $unidada, '".date("Y-m-d H:i:s")."', 2 )"; //entregado											
												$irut = new Recordset();
												$irut->sql = "INSERT INTO crp_ruta_correspondencia_cgr (id_recepcion_correspodencia_cgr, id_estatus, fecha_recepcion) VALUES (".$id.",1,'".date("Y-m-d H:i:s")."')";
												$irut->abrir();
												$irut->cerrar();
												unset($irut);
												$elestatus = 2;																					
												
											} else {
												$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", $unidada, '".date("Y-m-d H:i:s")."', 1 )"; //entregado											
												$elestatus = 1;																					
											}
											$ins->abrir();
											$ins->cerrar();
											unset($ins);
	
										break;
										
										case 10: //respuesta a
											$ins = new Recordset();
											$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", 1, '".date("Y-m-d H:i:s")."', 6 )"; //recibido
											$ins->abrir();
											$ins->cerrar();
											unset($ins);
											$elestatus = 6;
										break;	
										
										case 13: //correo
											$ins = new Recordset();
											if ($requiere_ofic==1)
											{
												if($unidada==1){	
													$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", $unidada, '".date("Y-m-d H:i:s")."', 2 )"; //proceso
													$elestatus = 2;																					
												} else {
													$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", $unidada, '".date("Y-m-d H:i:s")."', 1 )"; //asignado
													$elestatus = 1;																					
												}
											} else {
												if($unidada==1){	
													$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", $unidada, '".date("Y-m-d H:i:s")."', 6 )"; //entregado
													$elestatus = 6;																					
												} else {
													$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", $unidada, '".date("Y-m-d H:i:s")."', 5 )"; //enviado
													$elestatus = 5;																					
												}											
											}
											$ins->abrir();
											$ins->cerrar();
											unset($ins);
																			
										break;
										case 14: //invitacion
											$ins = new Recordset();
											$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", 1, '".date("Y-m-d H:i:s")."', 6 )"; //entregado
											$ins->abrir();
											$ins->cerrar();
											unset($ins);	
											$elestatus = 6;																			
										break;																																															
									
									}
									unset($_POST["accion"]); unset($_POST["n_documento"]); unset($_POST["direcc_remitente"]); unset($_POST["id_direcc_remitente"]); unset($_POST["fe_documento"]); unset($_POST["observacion"]); unset($_POST["listAnexo"]); unset($_POST["procesamiento"]); unset($_POST["tcomunicacion"]); unset($_POST["direcc_remitente"]);unset($_POST["noti"]);unset($_POST["n_notificacion"]);unset($_POST["id_organismo"]);unset($_POST["plazo"]);unset($_POST["organismo"]);unset($_POST["ciudadano"]);unset($_POST["telefono"]);unset($_POST["direccion"]);unset($_POST["n_respuesta"]); unset($_POST["unidad"]);					
									
									$irut = new Recordset();
									$irut->sql = "INSERT INTO crp_ruta_correspondencia_cgr (id_recepcion_correspodencia_cgr, id_estatus, fecha_recepcion) VALUES (".$id.",$elestatus,'".date("Y-m-d H:i:s")."')";
									$irut->abrir();
									$irut->cerrar();
									unset($irut);
									
									$mensaje = 1;
								} else {
									$mensaje = 2;						
								}
							$search->cerrar();
							unset($search);		
/*						} else {
							$ins = new Recordset();
							$ins->sql = "INSERT INTO crp_recepcion_correspondencia_cgr ( ".$campos.", fecha_registro, hora_registro, n_correlativo )"." VALUES ( ".$valores.", '".date("Y-m-d H:i:s")."', '".date("H:i:s")."', '".$codnuevo."' )";
							$ins->abrir();
							$ins->cerrar();
							unset($ins);		
							/*bitacorabitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia CGR n&deg; '".$codnuevo."'","Se registro una Correspondencia proveniente de la CGR (correlativo: '".$codnuevo."') ".$tipo.".");
							unset($_POST["accion"]); unset($_POST["n_documento"]); unset($_POST["direcc_remitente"]); unset($_POST["id_direcc_remitente"]); unset($_POST["fe_documento"]); unset($_POST["observacion"]); unset($_POST["listAnexo"]); unset($_POST["procesamiento"]); unset($_POST["tcomunicacion"]); unset($_POST["direcc_remitente"]);unset($_POST["noti"]);unset($_POST["n_notificacion"]);unset($_POST["id_organismo"]);unset($_POST["plazo"]);unset($_POST["organismo"]);unset($_POST["ciudadano"]);unset($_POST["telefono"]);unset($_POST["direccion"]);unset($_POST["n_respuesta"]); unset($_POST["unidad"]);					
							$mensaje = 1;*/
						} else {
						
							if($tcomunicaciona== "13")
								{
		
									$ins = new Recordset();
									//$ins->sql = "INSERT INTO crp_recepcion_correspondencia_cgr ( ".$campos.", fecha_registro, hora_registro, n_correlativo )"." VALUES ( ".$valores.", '".$fe_registroa."', '".date("H:i:s")."', '".$codnuevo."' )";
									$ins->sql = "INSERT INTO crp_recepcion_correspondencia_cgr ( ".$campos.", fecha_registro, hora_registro, n_correlativo )"." VALUES ( ".$valores.", '".date("Y-m-d")."', '".date("H:i:s")."', '".$codnuevo."' )";
									$ins->abrir();
									$ins->cerrar();
									unset($ins);		
		
									/*bitacora*/bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia CGR n&deg; '".$codnuevo."'","Se registro una Correspondencia proveniente de la CGR (correlativo: '".$codnuevo."') ".$tipo.". con los siguientes campos: $campos y valores: $valores.");
			
									$sel = new Recordset();
									$sel->sql = "SELECT id_recepcion_correspondencia_cgr FROM crp_recepcion_correspondencia_cgr ORDER BY crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr DESC LIMIT 1";
									$sel->abrir();
									if($sel->total_registros != 0)
										{											
											$sel->siguiente();
											$id = $sel->fila["id_recepcion_correspondencia_cgr"];
										}
									$sel->cerrar();
									unset($sel);
									
									$ins = new Recordset();
									if($unidada==1)
									{	
										if($requiere_ofic==1)
										{								
											$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", $unidada, '".date("Y-m-d H:i:s")."', 2 )"; //entregado
											$ins->abrir();
											$elestatus = 2;
										} else if ($requiere_ofic==0){
											$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", $unidada, '".date("Y-m-d H:i:s")."', 6 )"; //entregado
											$ins->abrir();
											$elestatus = 6;
										}																						
									} else {
										if($requiere_ofic==1)
										{								
											$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", $unidada, '".date("Y-m-d H:i:s")."', 2 )"; //entregado
											$ins->abrir();
											$elestatus = 2;										
										
										} else if ($requiere_ofic==0){
											$ins->sql = "INSERT INTO crp_asignacion_correspondencia_cgr ( id_recepcion_correspondencia_cgr, id_unidad, fecha_asignacion, id_estatus) VALUES ( ".$id.", $unidada, '".date("Y-m-d H:i:s")."', 5 )"; //entregado
											$ins->abrir();
											$elestatus = 5;
										}																				
									}									
									
									$irut = new Recordset();
									$irut->sql = "INSERT INTO crp_ruta_correspondencia_cgr (id_recepcion_correspodencia_cgr, id_estatus, fecha_recepcion) VALUES (".$id.",$elestatus,'".date("Y-m-d H:i:s")."')";
									$irut->abrir();
									$irut->cerrar();
									unset($irut);										

									$ins->cerrar();
									unset($ins);								
									
									unset($_POST["accion"]); unset($_POST["n_documento"]); unset($_POST["direcc_remitente"]); unset($_POST["id_direcc_remitente"]); unset($_POST["fe_documento"]); unset($_POST["observacion"]); unset($_POST["listAnexo"]); unset($_POST["procesamiento"]); unset($_POST["tcomunicacion"]); unset($_POST["direcc_remitente"]);unset($_POST["noti"]);unset($_POST["n_notificacion"]);unset($_POST["id_organismo"]);unset($_POST["plazo"]);unset($_POST["organismo"]);unset($_POST["ciudadano"]);unset($_POST["telefono"]);unset($_POST["direccion"]);unset($_POST["n_respuesta"]); unset($_POST["unidad"]);					
									$mensaje = 1;	
								}						
						}
				} 			
			$_SESSION["spam"] = rand(1, 99999999);
		} else {
			$_SESSION["spam"] = rand(1, 99999999);
		}

?>
<script type="text/javascript" src="librerias/jq.js"></script>
<script type="text/javascript" src="librerias/jquery.autocomplete.js"></script>
<table border="0" align="center" width="700">
<!--	<tr>
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="40px"><img src="images/recepcion.png"/></td>
					<td class="titulomenu" valign="middle">Recepci&oacute;n Correspondencia</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>-->
	<tr>
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="45px"><img src="images/recepcion1.png"/></td>
					<td class="titulomenu" valign="middle">Recepci&oacute;n Correspondencia CGR</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td align="center">
			<form method="post" name="recep" id="recep"><input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" autocomplete="off"/>
			<table width="99%" border="0" class="b_table" cellpadding="3" cellspacing="3">
				<tr>
					<td colspan="3" align="center">
                        <input type="hidden"  name="ms" id="ms" value="<? echo $mensaje; ?>"/>
						<div id="mensa"  name="mensa" class="escuela" style="width:90%;float:center; font-size:12px;font-weight:bold;"></div>                                    
					</td>
				</tr>								
				<tr>
					<td width="20"></td>				
					<td align="right">Tipo Comunicaci&oacute;n:&nbsp;</td>
					<td>
						<? 
						$rsun = new Recordset();
						$rsun->sql = "SELECT id_tipo_documento, tipo_documento FROM tipo_documento WHERE cgr = 1 order by tipo_documento"; 
						$rsun->llenarcombo($opciones = "\"tcomunicacion\"", $checked = "", $fukcion = "onchange=\"campos(this.value)\"" , $diam = "style=\"width:135px; Height:20px;\""); 
						$rsun->cerrar(); 
						unset($rsun);																						
						?>&nbsp;<span class="mensaje">*</span>
					</td>					
				</tr>
				<tr id="di_correo_edf" style="display:none">
					<td width="20"></td>					
					<td align="right">Genera Oficio Respuesta:</td>					
					<td align="left">
						Si &nbsp;<input type="radio" name="requiere_oficio" id="si_ofi" value="1" />&nbsp;
						No &nbsp;<input type="radio" name="requiere_oficio" id="no_ofi" value="0" checked="checked"/>					
					</td>
				</tr>																				
				<tr > 
					<td width="20"></td>				
					<td align="right"  width="180">N&deg; Oficio / Circular:&nbsp;</td>
					<td>
						<input type="text" name="n_documento" id="n_documento" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_cgr,false)">&nbsp;<span id="camp_oblo_ofi" class="mensaje">*</span>
						<span id="di_correo" style="display:none">
						Con N&deg;&nbsp;<input type="radio" name="correo_nOficio" id="con_ofi" checked="checked" onclick="ocultar_selec_email(this.id);" value="con_ofi"/>&nbsp;
						Sin N&deg;&nbsp;<input type="radio" name="correo_nOficio" id="sin_ofi" value="sin_ofi" onclick="ocultar_selec_email(this.id);"/>					
						</div>
					</td>					
				</tr>							
				<tr>
					<td width="20"></td>				
					<td align="right" valign="top">Direcci&oacute;n Remitente:&nbsp;</td>
					<td>
						<textarea name="direcc_remitente" id="direcc_remitente"  style="width:300px; height:30px;" ></textarea>&nbsp;<span class="mensaje">*</span>
						<input type="hidden" name="id_direcc_remitente" id="id_direcc_remitente" value="<? echo $search->fila["id_organismo"]; ?>"  />
						<? 
/*						$rsun = new Recordset();
						$rsun->sql = "SELECT id_organismo, organismo FROM organismo"; 
						$rsun->llenarcombo($opciones = "\"unidad\"", $checked = "", $fukcion = "" , $diam = "style=\"width:300px; Height:20px;\""); 
						$rsun->cerrar(); 
						unset($rsun);	*/																					
						?>					</td>					
				</tr>					
				<tr>
					<td width="20"></td>				
					<td align="right">Fecha Documento:&nbsp;</td>
					<td><input type="text" name="fe_documento" id="fe_documento" onkeyup="this.value=formateafecha(this.value,'2017','2015');">&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span></td>					
				</tr>
<!--				<tr>
					<td width="20"></td>				
					<td align="right">Fecha Recepci&oacute;n:&nbsp;</td>
					<td><input type="text" name="fe_registro" id="fe_registro" onkeyup="this.value=formateafecha(this.value,'2014','2014');">&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span></td>					
				</tr>-->				
				<tr id="di_notificacion" style="display:none">
					<td width="20"></td>
					<td width="20"></td>					
					<td align="left">
						Organ&iacute;smo&nbsp;<input type="radio" name="noti" id="notiOrga" checked="checked" onclick="ocultar_selec(this.id);" value="notiOrga"/>&nbsp;
						Ciudadano&nbsp;<input type="radio" name="noti" id="notiCiu" value="notiCiu" onclick="ocultar_selec(this.id);"/>					
					</td>
				</tr>				
				<tr id="div_organismo" style="display:none">
					<td></td>
					<td colspan="2" >
						<table border="0">
							<tr>
								<td width="60"></td>
								<td  width="120" valign="top" align="right">
									N&deg; Notificaci&oacute;n:&nbsp;								
								</td>
								<td width="120">
									<input type="text" name="n_notificacion_o" id="n_notificacion_o" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_cgr,false)"/>&nbsp;<span class="mensaje">*</span>
								</td>
							</tr>
							<tr>
								<td width="50"></td>							
								<td valign="top" align="right">
									Organ&iacute;smo:&nbsp;
								</td>
								<td width="330">
									<textarea name="organismo" id="organismo" style="width:300px; height:40px;" ></textarea>&nbsp;<span class="mensaje">*</span>
									<input type="hidden" name="id_organismo" id="id_organismo" value=""  />									
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr id="list_organismo" style="display:none">
					<td colspan="4" align="center"  >
						<table align="center" border="0" width="90%" class="b_table">
							<tr>
								<td colspan="4" align="right"><input type="hidden" name="cargar_orga" id="cargar_orga" /><input type="button" name="btnagregar" id="btnagregar" value="Agregar" title="Agregar" onclick="age('organismo');"/></td>
							</tr>													
							<tr class="trcabecera_list">
								<td width="30px" align="center">
									N&deg;
								</td>
								<td width="60px" align="center">
									Notificaci&oacute;n
								</td>					
								<td width="180px" align="center">
									Organ&iacute;smo
								</td>
								<td width="30px" align="center">
									Acci&oacute;n
								</td>														
							</tr>
							<tr>
								<td colspan="3" ><table  width="100%" border="0" class="b_table1"><tr><td align="center">No Ex&iacute;sten Datos a mostrar</td></tr></table></td>
							</tr>
						</table>
					</td>
				</tr>				
				<tr id="div_ciudadano" style="display:none">
					<td></td>
					<td colspan="2" >
						<table border="0">
							<tr>
								<td width="60"></td>
								<td valign="top" align="right" width="120">
									N&deg; Notificaci&oacute;n:&nbsp;								
								</td>
								<td>
									<input type="text" name="n_notificacion_c" id="n_notificacion_c" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_cgr,false)"/>&nbsp;<span class="mensaje">*</span>
								</td>
							</tr>
							<tr>
								<td width="51"></td>
								<td width="100" align="right">Nombre:&nbsp;</td>
								<td>
									<input type="text" maxlength="40" name="ciudadano" onblur="formatotexto(this)" id="ciudadano" onkeypress="return validar(event,letras)" style="width:180px"/>&nbsp;<span class="mensaje">*</span>
								</td>
							</tr>
							<tr>
								<td width="51"></td>
								<td valign="top" align="right">Direcci&oacute;n:&nbsp;</td>
								<td width="330">
									<textarea name="direccion" id="direccion" style="width:300px; height:70px" onkeyup="return maximaLongitud(this.id,200);"></textarea>&nbsp;<span class="mensaje">*</span>
									<br /><span style="font-size:9px">M&aacute;ximo 200 Caracteres</span>
								</td>							
							</tr>
							<tr>
								<td width="51"></td>
								<td valign="top" align="right">Tel&eacute;fono:&nbsp;</td>
								<td>
									<input type="text" name="telefono" id="telefono" onkeypress="return validar(event,numeros+'-')" maxlength="12" onkeyup="mascara(this,'-',p_telefonico,false)" style="width:120px"/><!--&nbsp;<span class="mensaje">*</span>-->&nbsp;<span style="font-size:9px">ejmp.(0412-1234567)</span>
								</td>							
							</tr>
						</table>
					</td>
				</tr>
				<tr id="list_ciudadano" style="display:none">
					<td colspan="4" align="center"  >
						<table align="center" border="0" width="90%" class="b_table">
							<tr>
								<td colspan="6" align="right"><input type="hidden" name="cargar_ciuda" id="cargar_ciuda" /><input type="button" name="btnagregar" id="btnagregar" value="Agregar" title="Agregar" onclick="age('ciudadano');"/></td>
							</tr>													
							<tr class="trcabecera_list">
								<td width="30px" align="center">
									N&deg;
								</td>
								<td width="90px" align="center">
									Notificaci&oacute;n
								</td>									
								<td width="180px" align="center">
									Nombre
								</td>
								<td width="180px" align="center">
									Direcci&oacute;n
								</td>		
								<td width="80px" align="center">
									Tel&eacute;fono
								</td>																
								<td width="30px" align="center">
									Acci&oacute;n
								</td>														
							</tr>
							<tr >
								<td colspan="6" ><table  width="100%" border="0" class="b_table1"><tr><td align="center">No Ex&iacute;sten Datos a mostrar</td></tr></table></td>
							</tr>
						</table>
					</td>
				</tr>												
				<tr id="di_respuesta" style="display:none">
					<td width="20"></td>
					<td align="right" valign="botton">
						Respuesta Oficio N&deg;:&nbsp;
					</td>
					<td align="left">
						<input type="text" name="n_respuesta" id="n_respuesta" maxlength="10" onkeypress="return validar(event,numeros)"/>&nbsp;<span class="mensaje">*</span>
					</td>										
				</tr>
				<tr id="di_solicitud" style="display:none">
					<td width="20"></td>
					<td align="right" valign="botton">
						Unidad Administrativa:&nbsp;					
					</td>
					<td align="left">
					<? 
						$rsun = new Recordset();
						$rsun->sql = "SELECT id_unidad, unidad FROM unidad"; 
						$rsun->llenarcombo($opciones = "\"unidad\"", $checked = $search->fila["id_unidad"], $fukcion = "" , $diam = "style=\"width:304px; Height:20px;\""); 
						$rsun->cerrar(); 
						unset($rsun);								
					?>&nbsp;<span class="mensaje">*</span></td>										
				</tr>				
				<tr id="di_plazo" style="display:none">
					<td width="20"></td>
					<td align="right">
						Plazo:					
					</td>
					<td>
						<input type="text" name="plazo" id="plazo" onkeypress="return validar(event,numeros)" maxlength="2" style="width:120px" /><!--&nbsp;<span class="mensaje">*</span>-->					
					</td>
				</tr>				
				<tr>
					<td width="20"></td>				
					<td align="right" valign="top">Observaci&oacute;n:&nbsp;</td>
					<td><textarea name="observacion" id="observacion" style="width:300px; height:110px" onblur="formatotexto(this)" onkeyup="return maximaLongitud(this.id,300);"></textarea>					  &nbsp;<span class="mensaje">*</span><br />
				  	<span style="font-size:9px">M&aacute;ximo 300 Caracteres</span></td></tr>									
				<tr>
					<td width="20"></td>				
					<td align="right" valign="botton">Con Anexo:&nbsp;</td>
					<td>Si&nbsp;<input type="radio" name="anex" id="SiAnex" onclick="vee_anex(this.id);"/>&nbsp;&nbsp;No&nbsp;<input type="radio" name="anex" id="NoAnex" checked="checked" onclick="vee_anex(this.id);"/></td>					
				</tr>	
				<tr id="danex1" style="display:none">
					<td height="8" colspan="3"></td>
				</tr>				
				<tr id="danex2" style="display:none">
					<td width="20"></td>				
					<td align="right" valign="top">Especifique los Anexos:</td>
					<td>
						<textarea name="listAnexo" id="listAnexo" style="width:300px; height:120px" onKeyUp="return maximaLongitud(this.id,300);"></textarea>&nbsp;<span class="mensaje">*</span>
						<br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span>
					</td>					
				</tr>					
				<tr><td height="20" colspan="3"></td></tr>
				<tr><td colspan="3" align="right" class="mensaje">* Campos Obligatorios&nbsp;&nbsp;</td></tr>														
				<tr><td height="20" colspan="2"></td></tr>				
				<tr>
					<td colspan="3" align="center">
						<input type="button" name="registrar" id="registrar" value="Registrar" title="Registrar" onclick="doit(this.id);" />					
						&nbsp;								
						<input type="button" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" onclick="cancelarT();" />					
					</td>
				</tr>
				<tr><td height="10" colspan="2"></td></tr>				
			</table>
			<input type="hidden" name="accion" id="accion" /><input type="hidden"  name="spam" value="<? echo $_SESSION["spam"]; ?>"/>
			</form>
		</td>
	</tr>
	<tr><td height="30"></td></tr>
</table>
<script language="javascript" type="text/javascript">
	$("#direcc_remitente").autocomplete("modulos/correspondencia/cgr/recepcion/lista.php?op=ccgr", { 
		width: 300,
		matchContains: true,
		mustMatch: false,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});

	$("#direcc_remitente").result(function(event, data, formatted) {
		try {
			$("#id_direcc_remitente").val(data[1]);
		} catch(e) {
			e.name;		
		}
	});
	
	$("#organismo").autocomplete("modulos/correspondencia/cgr/recepcion/lista.php?op=ext", { 
		width: 300,
		matchContains: true,
		mustMatch: false,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});

	$("#organismo").result(function(event, data, formatted) {
		try {
			$("#id_organismo").val(data[1]);
		} catch(e) {
			e.name;		
		}
	});	
	
$(document).ready(function()
{
	valor=$('#ms').val();
	if(valor==1){

		mensaje=acentos('&iexcl;La correspondencia ha sido registrada exitosamente!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}
    
	if(valor==2){

		mensaje=acentos('&iexcl;Registro Rechazado, esta correspondencia ha sido registrada anteriormente!')
		$("#mensa").addClass('fallo');
		$('#mensa').html(mensaje);
	}
	setTimeout(function(){$(".escuela").fadeOut(6000);},1000); 
});	
</script>
