<?
session_start();
header('content-type:text/xml; charset=iso-8859-1');
	//require_once("bil.php");
	require_once("../../../librerias/Recordset.php");
	require_once("../../../librerias/bitacora.php");	
	$condicion = stripslashes($_GET["condiciones"]);		
	$acci_realizar = stripslashes($_GET["mandato"]);
	$contador_modi = stripslashes($_GET["contador"]);
	$recepcion_id = stripslashes($_GET["id_rece"]);	
	$contador_modi++;		
	/*echo $condicion;*/
	if ((isset($condicion) && $condicion !="") && (isset($acci_realizar) && $acci_realizar !=""))
	{	
		$tramo1 = explode("!",$condicion);		
		$campos="";
		$valores="";
		if ($acci_realizar=="Asignar")
		{	
	 
			for($u=0;$u<count($tramo1);$u++)
				{
					$tramo2 = explode(":",$tramo1[$u]);				
					switch($tramo2[0])
					{
						case "campo1": // unidad
							if($campos!="")
								{
									$campos = $campos." id_unidad = ".$tramo2[1].", ";
	//								$valores = $valores.$tramo2[1].", ";
								} else {
									$campos = $campos." id_unidad = ".$tramo2[1].", ";
									/*$campos = "id_unidad =";
									$valores = $tramo2[1].", ";*/
								}
								$search = new Recordset();
								$search->sql = "SELECT unidad FROM unidad WHERE id_unidad =".$tramo2[1];
								$search->abrir();
								if($search->total_registros != 0)							
									{
										$search->siguiente();
										$hechos = "a la unidad de ".$search->fila["unidad"];									
									} else {
										$hechos = "a la unidad de ".$tramo2[1];																	
									}
								$search->cerrar();
								unset($search);
								
						break;	
	
						case "campo2": //apoyo
							if($campos!="")
								{
									$campos = $campos." unidades_apoyo = '".$tramo2[1]."', ";
									//$campos = $campos."unidades_apoyo,";
									//$valores = $valores.$tramo2[1].", ";
								} else {
									 $campos = " unidades_apoyo = '".$tramo2[1]."', ";
									//$campos = "unidades_apoyo,";
									//$valores = $tramo2[1].", ";
								}						
							if ($hechos!=""){
								$hechos = $hechos.". Esta asignaci&oacute;n cuenta con el apoyo de las unidades identificadas con: ".$tramo2[1]; 
							}
						break;	
	
						case "campo3": //prioridad
							$tramo3 = explode("_", $tramo2[1]);
							//echo $tramo3[0]."    ".$tramo3[1]."<br>";
							if($campos!="")
								{
									if($tramo3[1]==""){
										$campos = $campos."id_prioridad = ".$tramo3[0].", ";
											//$campos = $campos."prioridad,";
										//$valores = $valores.$tramo3[0].", ";
										
									} else {
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
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
											
												mysql_connect("localhost", "sicca", "1234") or die ("NO SE PUDO CONECTAR CON EL SERVIDOR MYSQL!");
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
											$ffin = fechaFinHabiles($finicio, $dias);	//echo "<tr><td colspan='9'>.$ffin = fechaFinHabiles($finicio, $dias);</td></tr>";
											$dias_feriados = 0;
											do {
												$feriados = getDiasFeriados($finicio, $ffin) - $dias_feriados;	//echo "<tr><td colspan='9'>$feriados = getDiasFeriados($finicio, $ffin);</td></tr>";
												$dias += $feriados;	//echo "<tr><td colspan='9'>$dias += $feriados;</td></tr>";		
												$ffin = fechaFinHabiles($finicio, $dias);	//echo "<tr><td colspan='9'>$ffin = fechaFinHabiles($finicio, $dias);.</td></tr>";		
												$dias_feriados += $feriados;
											} while ($feriados > 0);
											return $ffin;
										}										
										$fecha_vencimiento = getFechaFinHabiles(date('d-m-Y'),$tramo3[1]+1);	
										//echo $fecha_vencimiento;																			
										$fe = new Recordset();																													
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++									
										$campos = $campos."id_prioridad = ".$tramo3[0].", plazo = '".$tramo3[1]."', fecha_vencimiento='".$fe->formatofecha($fecha_vencimiento,'-')."', ";
										$pla = " con un plazo de ".$tramo3[1]." d&iacute;as";
										//$campos = $campos."prioridad, plazo,";
										//$valores = $valores.$tramo3[0].", ".$tramo3[1].",";								
									}
								} else {
									if($tramo3[1]==""){
										$campos = "id_prioridad = ".$tramo3[0].", ";
										//$campos = "prioridad,";
										//$valores = $tramo3[0].", ";
									} else {
										$campos = $campos."id_prioridad = ".$tramo3[0].", plazo = '".$tramo3[1]."', ";
										$pla = " con un plazo de ".$tramo3[1]." d&iacute;as";									
										//$campos = "prioridad, plazo,";
										//$valores = $tramo3[0].", ".$tramo3[1].",";								
									}								
								}
							//echo "<br>".$campos."<br>";
							$search = new Recordset();
							$search->sql = "SELECT prioridad FROM prioridad WHERE id_prioridad =".$tramo3[0];
							$search->abrir();
							if($search->total_registros != 0)							
								{
									$search->siguiente();
									$prio = $search->fila["prioridad"];									
								} else {
									$prio = $tramo3[0];								
								}
							$search->cerrar();
							unset($search);					
									
							if ($hechos!=""){						
									$hechos = $hechos.". Se establecio una prioridad ".$prio; 
								if ($pla!=""){
									$hechos = $hechos." con plazo de: ".$pla." que vence ".$fecha_vencimiento; 								
								} 
							}							
						break;	
	
						case "campo4": //observacion
							$cadenabus = array("á","é","í","ó","ú","ñ");
							$cadenasub = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&ntilde;");
							$ob = str_ireplace($cadenabus, $cadenasub, $tramo2[1]);
																																										
							if($campos!="")
								{
									$campos = $campos."observacion = '".$ob."', ";
									//$valores = $valores.$tramo2[1].", ";
								} else {
									$campos = "observacion = '".$ob."', ";
									//$campos = "observacion,";
									//$valores = $tramo2[1].", ";
								}	
							if ($hechos!=""){
								$hechos = $hechos.". El funcionario coloc&oacute; las siguientes observaciones: ".$ob; 
							}							
						break;	
	
						case "campo5":
							if($campos!="") //copias
								{
									$campos = $campos."copia_unidades = '".$tramo2[1]."', ";
									//$valores = $valores.$tramo2[1].", ";
								} else {
									$campos = "copia_unidades = '".$tramo2[1]."', ";
									//$campos = "copia_unidades,";
									//$valores = $tramo2[1].", ";
								}	
								$hechos = "que reposar&aacute; con copia a Despacho del Contralor y a las siguientes unidades identificadas como: ".$tramo2[1];							
								$unidadDespacho = $tramo2[1];								
						break;	
	
						case "campo6": // codigo padre
							if($tramo2[1]!=""){
								$sql = "UPDATE crp_recepcion_correspondencia SET crp_recepcion_correspondencia.n_correlativo_padre = '".$tramo2[1]."' WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia =";						
							}
						break;	
						
						case "campo7":
								$id = $tramo2[1];
						break;
									
						case "campo8":
							if($campos!="") //accion
								{
									$campos = $campos."accion = '".$tramo2[1]."', ";
									//$campos = $campos."accion,";
									//$valores = $valores.$tramo2[1].", ";
								} else {
									$campos = "accion = '".$tramo2[1]."', ";
									//$campos = "accion,";
									//$valores = $tramo2[1].", ";
								}
							if ($hechos!=""){
								$hechos = $hechos.". Esta correspondencia sera para: ".$tramo2[1]; 
							}
							$comprobacion = $tramo2[1];	
						break;			
						case "campo9":
							if($campos!="") //saldra como oficio externo
								{
									$campos = $campos."externo =".$tramo2[1];
									//$valores = $valores.$tramo2[1].", ";
								} else {
									$campos = "externo =".$tramo2[1];
									//$campos = "externo,";
									//$valores = $tramo2[1].", ";
								}
							$camb_ruta_corta = ""; 
							if ($hechos!=""){
								if($tramo2[1]==1){
									$hechos = $hechos.". La misma se transformar&aacute; para salir como un oficio externo de la Contraloria de Aragua";
									$camb_ruta_corta = 1; 
								} else {
									$hechos = $hechos.". La misma no sera tramitada como oficio externo"; 
									$camb_ruta_corta = 0;									
								}
							}							
						break;											
					}
				}
				
				//--
				if ($comprobacion=="procesar"){
					if($camb_ruta_corta == 1)
					{
						$status = "id_estatus = 1";
						$valStatus = "1";
					} elseif ($camb_ruta_corta == 0) {
						$status = "id_estatus = 5";
						$valStatus = "5";																					
					}
				} else if ($comprobacion=="archivar"){
					if($unidadDespacho=="01"){
						$status = "id_estatus = 6";
						$valStatus = "6";								
					} else {
						$status = "id_estatus = 5";
						$valStatus = "5";																
					}
				}			
				//--
							
				$search1 = new Recordset();
				$search1->sql = "UPDATE crp_asignacion_correspondencia SET $campos, fecha_asignacion= '".date("Y-m-d H:i:s")."', $status WHERE id_recepcion_correspondencia =$id";
				$search1->abrir();
				$search1->cerrar();
				unset($search1);			
				
				$search2 = new Recordset();
				$search2->sql = "INSERT INTO crp_ruta_correspondencia (id_estatus, id_recepcion_correspondencia,fecha_cambio_estatus,fecha_recepcion_digital) VALUES ($valStatus,$id,'".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
				$search2->abrir();
				$search2->cerrar();
				unset($search2);
				
				if($sql!=""){
					$search3 = new Recordset();
					$search3->sql = $sql.$id;
					$search3->abrir();
					$search3->cerrar();
					unset($search3);					
				}
								
				bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Asignaci&oacute;n de Correspondencia con identificaci&oacute;n:'".$id."'","Se asigno una Correspondencia $hechos");
			
/*				if ($comprobacion=="archivar" && $comprobacion )
				{
					$search3 = new Recordset();
					$search3->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 6 WHERE id_recepcion_correspondencia = ".$id;
					$search3->abrir();
					$search3->cerrar();
					unset($search3);					
				}*/
			
		} else if ($acci_realizar=="Modificar")
		{
			for($u=0;$u<count($tramo1);$u++)
				{
					$tramo2 = explode(":",$tramo1[$u]);				
					switch($tramo2[0])
					{
						case "campo1": // unidad
							if($campos!="")
							{
								$campos = $campos." id_unidad = ".$tramo2[1].", ";
//								$valores = $valores.$tramo2[1].", ";
							} else {
								$campos = $campos." id_unidad = ".$tramo2[1].", ";
								/*$campos = "id_unidad =";
								$valores = $tramo2[1].", ";*/
							}
							$search = new Recordset();
							$search->sql = "SELECT unidad FROM unidad WHERE id_unidad =".$tramo2[1];
							$search->abrir();
							if($search->total_registros != 0)							
								{
									$search->siguiente();
									$hechos = "a la unidad de ".$search->fila["unidad"];									
								} else {
									$hechos = "a la unidad de ".$tramo2[1];																	
								}
							$search->cerrar();
								unset($search);						
							if($tramo2[1]=="")
								{
									$hechos = "eliminando a la unidad asignada ";																	
								}
						break;	
	
						case "campo2": //apoyo
							if($campos!="")
								{
									$campos = $campos." unidades_apoyo = '".$tramo2[1]."', ";
									//$campos = $campos."unidades_apoyo,";
									//$valores = $valores.$tramo2[1].", ";
								} else {
									 $campos = " unidades_apoyo = '".$tramo2[1]."', ";
									//$campos = "unidades_apoyo,";
									//$valores = $tramo2[1].", ";
								}						
							if ($hechos!=""){
								$hechos = $hechos.". Estas son las nuevas asignaciones que fueron modificadas: ".$tramo2[1]; 
							}
						break;	
	
						case "campo3": //prioridad
							$tramo3 = explode("_", $tramo2[1]);
							if($tramo3[0]=="")
								{
									if ($hechos!=""){
										$hechos = $hechos.". Al mismo tiempo se elimino la prioridad de la correspondencia"; 
									}							
								} else {
									$campos = $campos." unidades_apoyo = '".$tramo2[1]."', ";
								
								}
						break;	
	
						case "campo4": //observacion							
						break;	
	
						case "campo5":
							if($campos!="") //copias
								{
									$campos = $campos."copia_unidades = '".$tramo2[1]."', ";
									//$valores = $valores.$tramo2[1].", ";
								} else {

									$campos = "copia_unidades = '".$tramo2[1]."', ";
									//$campos = "copia_unidades,";
									//$valores = $tramo2[1].", ";
								}	
								$hechos = $hechos.". Se registra la unidades que reciben copia como: ".$tramo2[1];							
						break;	
	
						case "campo6": // codigo padre
						break;	
						
						case "campo7":
								$id = $tramo2[1];
						break;
									
						case "campo8":
							if($campos!="") //accion
								{
									$campos = $campos."accion = '".$tramo2[1]."', ";
									//$campos = $campos."accion,";
									//$valores = $valores.$tramo2[1].", ";
								} else {
									$campos = "accion = '".$tramo2[1]."', ";
									//$campos = "accion,";
									//$valores = $tramo2[1].", ";
								}
							
							if ($tramo2[1]=="procesar"){
								$status = "id_estatus = 1";
								$valStatus = "1";
							} else if ($tramo2[1]=="archivar"){
								$status = "id_estatus = 5";
								$valStatus = "5";								
							}
															
							if ($hechos!=""){
								$hechos = $hechos.". Esta correspondencia cambio a: ".$tramo2[1]; 
							}							
						break;			
						case "campo9":
							if($campos!="") //saldra como oficio externo
								{
									$campos = $campos."externo =".$tramo2[1];
									//$valores = $valores.$tramo2[1].", ";
								} else {
									$campos = "externo =".$tramo2[1];
									//$campos = "externo,";
									//$valores = $tramo2[1].", ";
								}
							if ($hechos!=""){
								if($tramo2[1]==1){
									$hechos = $hechos.". La misma se transformar&aacute; para salir como un oficio externo de la Contraloria de Aragua"; 
								} else {
									$hechos = $hechos.". La misma no sera tramitada como oficio externo"; 
								}
							}							
						break;											
					}
				}
				$sea = new Recordset();
				$sea->sql = "SELECT id_asignacion_correspondencia FROM crp_asignacion_correspondencia WHERE (modificacion <> 0) AND id_recepcion_correspondencia =".$id;
				$sea->abrir();
				if($sea->total_registros == 0)							
					{
						$delete = new Recordset();
						$delete->sql = "UPDATE crp_asignacion_correspondencia SET id_unidad = null, id_prioridad = null, unidades_apoyo = null, accion = null, externo = null, plazo = null, copia_unidades = null 
											 WHERE id_recepcion_correspondencia = $id";
						$delete->abrir();
						$delete->cerrar();
						unset($delete);	
						
						$search1 = new Recordset();
						$search1->sql = "UPDATE crp_asignacion_correspondencia SET $campos, fecha_asignacion= '".date("Y-m-d H:i:s")."', $status, modificacion = $contador_modi WHERE id_recepcion_correspondencia =$id";
						$search1->abrir();
						$search1->cerrar();
						unset($search1);			
						bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Modificaci&oacute;n de Correspondencia Asignada con identificaci&oacute;n:'".$id."'","Se modifico la Correspondencia $hechos");
					}
				$sea->cerrar();
				unset($sea);						
		} else if ($acci_realizar=="transferir")
		{
			for($u=0;$u<count($tramo1);$u++)
				{
					$tramo2 = explode(":",$tramo1[$u]);				
					switch($tramo2[0])
					{
						case "campo1": // actualizar unidad
							if($tramo2[1]!=""){
								$sql = "UPDATE crp_asignacion_correspondencia SET id_unidad = $tramo2[1] WHERE id_recepcion_correspondencia = ";
								$id_unidadentrente = $tramo2[1];
							}							
						break;	
												
						case "campo2": //motivo
							$cadenabus = array("á","é","í","ó","ú","ñ");
							$cadenasub = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&ntilde;");
							$ob = str_ireplace($cadenabus, $cadenasub, $tramo2[1]);
							
							if($campos!="")
								{
									$campos = $campos."motivo, ";
									$valores = "'".$ob."', ";
								} else {
									$campos = "motivo, ";
									$valores = "'".$ob."', ";									
								}						
							$elmotivo = ". El motivo de la transferencia es: ".$ob; 
						break;	
	
						case "campo3": // registro unidad que cede la correspondencia
							if($campos!="")
								{
									$campos = $campos."id_unidad,";
									$valores = $valores.$tramo2[1].", ";
								} else {
									$campos = "id_unidad,";
									$valores = $tramo2[1].", ";									
								}
								
								$search = new Recordset();
								$search->sql = "SELECT unidad FROM unidad WHERE id_unidad =".$tramo2[1];
								$search->abrir();
								if($search->total_registros != 0)							
									{
										$search->siguiente();
										$hechos = "donde la unidad: ".$search->fila["unidad"].", cede la correspondencia que le fue asignada a la unidad identificada como: ".$id_unidadentrente.$elmotivo;									
									} else {
										$hechos = "donde la unidad identificada como: ".$tramo2[1].", cede la correspondencia que le fue asignada a la unidad identificada como: ".$id_unidadentrente.$elmotivo;
									}
								$search->cerrar();
								unset($search);
						break;
	
						case "campo4": //id_recepcion
							if($campos!="")
								{
									$campos = $campos."id_recepcion_correspondencia,";
									$valores = $valores.$tramo2[1].", ";
								} else {
									$campos = "id_recepcion_correspondencia,";
									$valores = $valores.$tramo2[1].", ";									
								}								
							$id = $tramo2[1];						
						break;	
					}		
				}
				$search = new Recordset();
				$search->sql = "SELECT id_recepcion_correspondencia FROM crp_transferencia_correspondencia WHERE id_recepcion_correspondencia =".$id;
				$search->abrir();
				if($search->total_registros == 0)							
					{				
						$update = new Recordset();
						echo $update->sql = $sql.$id;
						$update->abrir();
						$update->cerrar();
						unset($update);	
						
						$search1 = new Recordset();
						$search1->sql = "INSERT INTO crp_transferencia_correspondencia ($campos fecha_registro) 
						 VALUES ($valores'".date("Y-m-d H:i:s")."')";
						$search1->abrir();
						$search1->cerrar();
						unset($search1);			
						bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Transferencia de Correspondencia con identificaci&oacute;n:'".$id."'","Se efectuo una transferencia $hechos");
					}
				$search->cerrar();
				unset($search);		
		} 
	}
	
	if ($acci_realizar=="recibir")
	{
			$search = new Recordset();
			$search->sql = "SELECT id_recepcion_correspondencia FROM crp_asignacion_correspondencia WHERE id_recepcion_correspondencia =".$recepcion_id." AND crp_asignacion_correspondencia.id_estatus = 3";
			$search->abrir();
			if($search->total_registros == 1)							
				{									
					$update = new Recordset();
					$update->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 4 WHERE id_recepcion_correspondencia = ".$recepcion_id;
					$update->abrir();
					$update->cerrar();
					unset($update);	
					
					$search2 = new Recordset();
					$search2->sql = "INSERT INTO crp_ruta_correspondencia (id_estatus, id_recepcion_correspondencia,fecha_cambio_estatus,fecha_recepcion_digital) VALUES (4,$recepcion_id,'".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
					$search2->abrir();
					$search2->cerrar();
					unset($search2);						
					
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Recepcion de Correspondencia con N&deg; identificaci&oacute;n:'".$recepcion_id."'","Se recibe de la Direcci&oacute;n General el documento &uacute; oficio, esta correspondencia queda bajo estatus 'Aprobado' y en espera del paso a seguir.");
				}
			$search->cerrar();
			unset($search);		
	}	
?>


