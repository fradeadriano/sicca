<script type="text/javascript" src="../../../librerias/dhtml/dhtmlSuite-common.js"></script>
<script language="javascript" type="text/javascript" src="../../../librerias/dhtml/ajax.js"></script>
<script language="javascript" type="text/javascript" src="../../../librerias/funciones.js"></script>							
<script type="text/javascript" src="../../../librerias/jq.js"></script>
<script type="text/javascript" src="../../../librerias/jquery.autocomplete.js"></script>
<script type="text/javascript">
	DHTML_SUITE_JS_FOLDER = "../../../librerias/dhtml/";
	DHTML_SUITE_THEME_FOLDER = "../../../librerias/dhtml/themes/";
	DHTMLSuite.include("modalMessage");
</script>
<? 
require_once("../../../librerias/Recordset.php"); 
require_once("../../../librerias/bitacora.php"); 
require_once("bil.php");
$id = stripslashes($_GET["id_recepcion"]);
if(ctype_digit($id)){

	$bsqcor = new Recordset();
	$bsqcor->sql = "SELECT crp_recepcion_correspondencia.n_correlativo, DATE_FORMAT(crp_recepcion_correspondencia.fecha_documento,'%d/%m/%Y') AS fdocumento, 
					DATE_FORMAT(crp_recepcion_correspondencia.fecha_registro,'%d/%m/%Y %r') AS registro, crp_recepcion_correspondencia.n_documento,
							  organismo.organismo, tipo_documento.tipo_documento, crp_recepcion_correspondencia.id_tipo_documento, crp_recepcion_correspondencia.n_correlativo_padre,
							  crp_recepcion_correspondencia.anfiscal, tipo_respuesta.tipo_respuesta, crp_recepcion_correspondencia.id_tipo_respuesta, 
							  crp_recepcion_correspondencia.gaceta_n, DATE_FORMAT(crp_recepcion_correspondencia.gaceta_fecha,'%d/%m/%Y') AS fecha_gaceta, 
							  crp_recepcion_correspondencia.gaceta_tipo, crp_recepcion_correspondencia.observacion, crp_recepcion_correspondencia.anexo
							   
							FROM
							  crp_recepcion_correspondencia LEFT JOIN organismo ON (crp_recepcion_correspondencia.id_organismo = organismo.id_organismo)
							  INNER JOIN tipo_documento 
							    ON (crp_recepcion_correspondencia.id_tipo_documento = tipo_documento.id_tipo_documento) 
								LEFT JOIN tipo_respuesta ON (crp_recepcion_correspondencia.id_tipo_respuesta = tipo_respuesta.id_tipo_respuesta)							  
							WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$id."'";
	$bsqcor->abrir();
	if($bsqcor->total_registros > 0)
		{
			$bsqcor->siguiente();
			$n_correlativo1 = $bsqcor->fila["n_correlativo"];
			$fdocumento1 = $bsqcor->fila["fdocumento"];
			$registro1 = $bsqcor->fila["registro"];
			$n_documento1 = $bsqcor->fila["n_documento"];
			$organismo1 = $bsqcor->fila["organismo"];
			$n_correlativo_padre1 = $bsqcor->fila["n_correlativo_padre"];						
			$id_tipo_respuesta1 = $bsqcor->fila["id_tipo_respuesta"];													
			$tipo_respuesta1 = $bsqcor->fila["tipo_respuesta"];																
							
							
		$search = new Recordset();
		$search->sql = "SELECT crp_asignacion_correspondencia.id_asignacion_correspondencia,crp_asignacion_correspondencia.id_unidad,crp_asignacion_correspondencia.id_prioridad,
						crp_asignacion_correspondencia.unidades_apoyo,crp_asignacion_correspondencia.accion,crp_asignacion_correspondencia.copia_unidades, crp_asignacion_correspondencia.plazo,
						prioridad.prioridad, crp_asignacion_correspondencia.externo, crp_asignacion_correspondencia.observacion, crp_asignacion_correspondencia.modificacion, 
						crp_asignacion_correspondencia.id_prioridad
		 				FROM crp_asignacion_correspondencia LEFT JOIN prioridad ON (crp_asignacion_correspondencia.id_prioridad = prioridad.id_prioridad) 
						WHERE id_recepcion_correspondencia = '".$id."'";
			$search->abrir();
			if($search->total_registros != 0)
			{
				$search->siguiente();
				$con = $search->fila["modificacion"];
				$funcionJ = "";
				
				$id_unidad1 = $search->fila["id_unidad"];
				$unidades_apoyo1 = $search->fila["unidades_apoyo"];
				$accion1 = $search->fila["accion"];
				$copia_unidades1 = $search->fila["copia_unidades"];
				$plazo1 = $search->fila["plazo"];
				$id_prioridad1 = $search->fila["id_prioridad"];
				$externo1 = $search->fila["externo"];
				$observacion1 = $search->fila["observacion"];
				$fecha_vencimiento1 = $search->fila["fecha_vencimiento"];				
				
				if ($search->fila["accion"]=="procesar") {
					$funcionJ = "document.getElementById(\"procesar\").checked = true;";
					if ($search->fila["externo"]==1)
						{ 
							$funcionJ = $funcionJ." document.getElementById(\"si_requiere\").checked = true;";
						 } 
					else if ($search->fila["externo"]==0) 
						{ 
							$funcionJ = $funcionJ." document.getElementById(\"no_requiere\").checked = true;";
							$funcionJ = $funcionJ ."document.getElementById(\"most_prioridad\").style.display = \"none\";";
						}  

					if($search->fila["id_unidad"]!="")
						{ 
							$funcionJ = $funcionJ." document.getElementById(\"cmbunidad\").value =".$search->fila["id_unidad"].";";						
						}	
						
					if($search->fila["unidades_apoyo"]!="")
						{ 
							$funcionJ = $funcionJ ."document.getElementById(\"positivo\").checked = true;";
							$funcionJ = $funcionJ ." document.getElementById(\"cont_marcados\").value = \"".$search->fila["unidades_apoyo"]."\"; ";
							$funcionJ = $funcionJ ." var cantidades = \"\"; cantidades = document.getElementById(\"cont_marcados\").value.split('-'); document.getElementById(\"mostrar_apoyo\").style.display = \"\"; document.getElementById(\"list_apoyos\").style.display = \"\"; 
													for (j = 0;j<cantidades.length;j++)
														{ 
														   for (i=0;i<document.recep.elements.length;i++)
														   {
															  if(document.recep.elements[i].type == \"checkbox\")
															  {
																	if(document.recep.elements[i].value == cantidades[j])
																	{
																		document.recep.elements[i].checked = true;
																	} 
															  }
															}				
														}";					

						} else {
							$funcionJ = $funcionJ ."document.getElementById(\"mostrar_apoyo\").style.display = \"\"; document.getElementById(\"negativo\").checked = true;";

						}
																	
					if($search->fila["id_prioridad"]!=""){
						$funcionJ = $funcionJ ."document.getElementById(\"prioridad\").value =".$search->fila["id_prioridad"].";";
						if($search->fila["plazo"] !=""){
							$funcionJ = $funcionJ ."document.getElementById(\"vent_plazo\").style.display = \"\";";
							$funcionJ = $funcionJ ."document.getElementById(\"plazo\").value =".$search->fila["plazo"].";";							
						}
						//$funcionJ = $funcionJ ." document.getElementById(\"prioridad\").disabled = true; ";
						//$funcionJ = $funcionJ ." document.getElementById(\"plazo\").disabled = true; ";
					} /*else {
						$funcionJ = $funcionJ ." document.getElementById(\"prioridad\").disabled = true; ";
					}*/					
				} else if ($search->fila["accion"]=="archivar") { 
					$funcionJ = "document.getElementById(\"archivar\").checked = true;";
					$funcionJ = $funcionJ ." document.getElementById(\"cont_marcados\").value = \"".$search->fila["copia_unidades"]."\"; ";
					$funcionJ = $funcionJ ." var cantidades = \"\";  document.getElementById(\"most_prioridad\").style.display = \"none\"; document.getElementById(\"requie_oficio_exter\").style.display = \"none\"; document.getElementById(\"unidad_Asignar\").style.display = \"none\"; document.getElementById(\"list_apoyos\").style.display = \"\"; document.getElementById(\"mostrar_cc1\").style.display = \"\"; cantidades = document.getElementById(\"cont_marcados\").value.split('-'); 
											for (j = 0;j<cantidades.length;j++)
												{ 
												   for (i=0;i<document.recep.elements.length;i++)
												   {
													  if(document.recep.elements[i].type == \"checkbox\")
													  {
															if(document.recep.elements[i].value == cantidades[j])
															{
																document.recep.elements[i].checked = true;
															} 
													  }
													}				
												}";					
				}	
				$aqwe = $search->decodificar($search->fila["observacion"]);
				function montar_documentos(){
						$rsdocu = new Recordset();
						$rsdocu->sql = "SELECT id_unidad, unidad, codigo FROM unidad";
						$rsdocu->abrir();
						$html = "<table border=\"0\" width=\"100%\" align=\"center\"><tr><td>
						<table border=\"0\" width=\"100%\" align=\"center\" cellpadding=\"5\" cellspacing=\"0\" class=\"fuente_pequenna\">";
						for($i=0;$i<$rsdocu->total_registros;$i++){
							$rsdocu->siguiente();
							if($i == 0)
								$html .= "<tr>";
							if(($i % 4 == 0) && ($i < $rsdocu->total_registros))
								$html .= "</tr><tr>";
							$html .= "<td  width=\"200\" align=\"left\"><input type=\"checkbox\" id=\"".$rsdocu->fila["id_unidad"]."\" value=\"".$rsdocu->fila["codigo"]."\" onclick=\"marcar(this.value);\" />&nbsp;".$rsdocu->fila["unidad"]."</td>";
						}
						$html .= "<tr></table></td></tr></table>";
						return $html;
				}							 
				$funcionJ = $funcionJ ." document.getElementById(\"observacion\").value = \"".$search->decodificar($search->fila["observacion"])."\"; ";
			}
			
			
																													
//			id_tipo_documento
		}
	$accion = stripslashes($_POST["accion"]);
	$recepcion = stripslashes($_POST["irecepcion"]);	
	
	if(isset($accion) && $accion=="modificar")
		{
			$change = 1;
			$otra = 1;
			$consul = "";
			$suiche = trim(stripslashes($_POST["acc"]));
			if (strcasecmp($search->fila["accion"],stripslashes($_POST["acc"])) != 0)
				{
					$change = 0;
					$consul = "accion = '".trim(stripslashes($_POST["acc"]))."'";
				}
				
			if (strcasecmp($search->fila["id_unidad"],stripslashes($_POST["cmbunidad"])) != 0)
				{
					$change = 0;
					if ($consul!=""){
						$consul = $consul.", id_unidad = '".trim(stripslashes($_POST["cmbunidad"]))."'";
					} else { 
						$consul = "id_unidad = '".trim(stripslashes($_POST["cmbunidad"]))."'";
					}							
				}
				
			if (strcasecmp($search->fila["unidades_apoyo"],stripslashes($_POST["cont_marcados"])) != 0)
				{
					$change = 0;
					if ($consul!=""){
						$consul = $consul.", unidades_apoyo = '".stripslashes($_POST["cont_marcados"])."'";
					} else { 
						$consul = "unidades_apoyo = '".stripslashes($_POST["cont_marcados"])."'";
					}							
				}
				
			if (strcasecmp($search->fila["copia_unidades"],stripslashes($_POST["cont_marcados"])) != 0)
				{
					$change = 0;
					if ($consul!=""){
						$consul = $consul.", copia_unidades = '".trim(stripslashes($_POST["cont_marcados"]))."'";
					} else { 
						$consul = "copia_unidades = '".trim(stripslashes($_POST["cont_marcados"]))."'";
					}							
				}
				
			if (strcasecmp($search->fila["id_prioridad"],stripslashes($_POST["prioridad"])) != 0)
				{
					$change = 0;
					if ($consul!=""){
						$consul = $consul.", id_prioridad = '".trim(stripslashes($_POST["prioridad"]))."'";
					} else { 
						$consul = "id_prioridad = '".trim(stripslashes($_POST["prioridad"]))."'";
					}							
				}
										
			if (strcasecmp($search->fila["plazo"],$search->formatofecha($_POST["plazo"])) != 0)
				{
					$change = 0;
					if ($consul!=""){
						$consul = $consul.", plazo = '".trim($_POST["plazo"])."'";
					} else { 
						$consul = "plazo = '".trim($_POST["plazo"])."'";
					}							
				
					if(is_null($search->fila["fecha_vencimiento1"]))
					{
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
						$fe_vencimiento = getFechaFinHabiles(date('d-m-Y'),$_POST["plazo"]+1);	
						$fe = new Recordset();
						
						if ($consul!=""){
							$consul = $consul.", fecha_vencimiento = '".$fe->formatofecha($fe_vencimiento,'-')."'";
						} else { 
							$consul = "fecha_vencimiento = '".$fe->formatofecha($fe_vencimiento,'-')."'";
						}																
					}
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++					
				}	
				
			if (strcasecmp($search->fila["observacion"],stripslashes($_POST["observacion"])) != 0)
				{
					$change = 0;
					if ($consul!=""){
						$consul = $consul.", observacion = '".trim(stripslashes($_POST["observacion"]))."'";
					} else { 
						$consul = "observacion = '".trim(stripslashes($_POST["observacion"]))."'";
					}							
				}	
				

				if($_POST["req"]=="si_requiere"){
					$oficioexterno = 1;					
				} else if($_POST["req"]=="no_requiere"){
					$oficioexterno = 0;									
				}
			if (strcasecmp($search->fila["externo"],$oficioexterno) != 0)
				{
					$change = 0;
					if ($consul!=""){
						$consul = $consul.", externo = '".$oficioexterno."'";
					} else { 
						$consul = "externo = '".$oficioexterno."'";
					}							
				}																																										
							
			if(isset($_POST["oficio_padre"]))
			{
				if (strcasecmp($n_correlativo_padre1,stripslashes($_POST["oficio_padre"])) != 0)
					{
						$otra = 0;
						$sqlll= "update crp_recepcion_correspondencia set n_correlativo_padre = '".trim(stripslashes($_POST["oficio_padre"]))."' where id_recepcion_correspondencia = $id";
					}				
			}
			
			if ($change == 0)
				{
					$modi = new Recordset();
					$modi->sql = "UPDATE crp_asignacion_correspondencia SET $consul WHERE id_recepcion_correspondencia = ".$id;
					$modi->abrir();
					$modi->cerrar();
					unset($modi);
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Modificaci&oacute;n de Correspondencia ","Modificaci&oacute;n de Correspondencia identificada con el n&deg; '".$id."'");

					/* ------------ Modificacion rurta ---------------- */				
					if($suiche=="archivar"){
						$nveces = 0;
						$car = new Recordset();
						$car->sql = "SELECT id_estatus, id_ruta_correspondencia FROM crp_ruta_correspondencia WHERE id_recepcion_correspondencia = '".$recepcion."' ORDER BY id_ruta_correspondencia ASC";
						$car->abrir();
						if ($car->total_registros>0)
						{	
							for($i=0;$i<$car->total_registros;$i++)
							{
								$car->siguiente();
								switch($car->fila["id_estatus"])
								{
									case 1:
										$camb = new Recordset();
										$camb->sql = "UPDATE crp_ruta_correspondencia SET id_estatus = 5, comentario = 'cambio por contingencia, antes ".$car->fila["id_estatus"]."' WHERE id_ruta_correspondencia = ".$car->fila["id_ruta_correspondencia"];
										$camb->abrir();
										$camb->cerrar();
										unset($camb);
										$nveces = 1;				
									break;
									
									case 2:
										$camb = new Recordset();
										$camb->sql = "UPDATE crp_ruta_correspondencia SET id_estatus = 6, comentario = 'cambio por contingencia, antes ".$car->fila["id_estatus"]."' WHERE id_ruta_correspondencia = ".$car->fila["id_ruta_correspondencia"];
										$camb->abrir();
										$camb->cerrar();
										unset($camb);				
										$nveces = 2;
									break;									
								}								
							}
							if ($nveces ==2){
								
								$modi = new Recordset();
								$modi->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 6 WHERE id_recepcion_correspondencia = ".$id;
								$modi->abrir();
								$modi->cerrar();
								unset($modi);
							
							} elseif($nveces ==1) {
								
								$modi = new Recordset();
								$modi->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 5 WHERE id_recepcion_correspondencia = ".$id;
								$modi->abrir();
								$modi->cerrar();
								unset($modi);
							
							}
							
						}										
					} elseif ($suiche=="procesar") {
						$nveces = 0;
						if($oficioexterno==1) // si requiere
						{
							$car = new Recordset();
							$car->sql = "SELECT id_estatus, id_ruta_correspondencia FROM crp_ruta_correspondencia WHERE id_recepcion_correspondencia = '".$recepcion."' ORDER BY id_ruta_correspondencia ASC";
							$car->abrir();
							if ($car->total_registros>0)
							{	
								for($i=0;$i<$car->total_registros;$i++)
								{
									$car->siguiente();
									switch($car->fila["id_estatus"])
									{
										case 5:
											$camb = new Recordset();
											$camb->sql = "UPDATE crp_ruta_correspondencia SET id_estatus = 1, comentario = 'cambio por contingencia, antes ".$car->fila["id_estatus"]."' WHERE id_ruta_correspondencia = ".$car->fila["id_ruta_correspondencia"];
											$camb->abrir();
											$camb->cerrar();
											unset($camb);
											$nveces = 1;				
										break;
										
										case 6:
											$camb = new Recordset();
											$camb->sql = "UPDATE crp_ruta_correspondencia SET id_estatus = 2, comentario = 'cambio por contingencia, antes '".$car->fila["id_estatus"]."' WHERE id_ruta_correspondencia = ".$car->fila["id_ruta_correspondencia"];
											$camb->abrir();
											$camb->cerrar();
											unset($camb);	
											$nveces = 2;			
										break;									
									}								
								}
							}	
							
							if ($nveces ==2){
								
								$modi = new Recordset();
								echo $modi->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 2 WHERE id_recepcion_correspondencia = ".$id;
								$modi->abrir();
								$modi->cerrar();
								unset($modi);
							
							} elseif($nveces ==1) {
								
								$modi = new Recordset();
								$modi->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 1 WHERE id_recepcion_correspondencia = ".$id;
								$modi->abrir();
								$modi->cerrar();
								unset($modi);
							
							}												
						}
						else if($oficioexterno==0)
						{
							$car = new Recordset();
							$car->sql = "SELECT id_estatus, id_ruta_correspondencia FROM crp_ruta_correspondencia WHERE id_recepcion_correspondencia = '".$recepcion."' ORDER BY id_ruta_correspondencia ASC";
							$car->abrir();
							if ($car->total_registros>0)
							{	
								for($i=0;$i<$car->total_registros;$i++)
								{
									$car->siguiente();
									switch($car->fila["id_estatus"])
									{
										case 1:
											$camb = new Recordset();
											$camb->sql = "UPDATE crp_ruta_correspondencia SET id_estatus = 5, comentario = 'cambio por contingencia, antes ".$car->fila["id_estatus"]."' WHERE id_ruta_correspondencia = ".$car->fila["id_ruta_correspondencia"];
											$camb->abrir();
											$camb->cerrar();
											unset($camb);	
											$nveces = 1;			
										break;
										
										case 2:
											$camb = new Recordset();
											$camb->sql = "UPDATE crp_ruta_correspondencia SET id_estatus = 6, comentario = 'cambio por contingencia, antes ".$car->fila["id_estatus"]."' WHERE id_ruta_correspondencia = ".$car->fila["id_ruta_correspondencia"];
											$camb->abrir();
											$camb->cerrar();
											unset($camb);
											$nveces = 2;															
										break;									
									}								
								}
							}
							if ($nveces ==2){
								
								$modi = new Recordset();
								$modi->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 6 WHERE id_recepcion_correspondencia = ".$id;
								$modi->abrir();
								$modi->cerrar();
								unset($modi);
							
							} elseif($nveces ==1) {
								
								$modi = new Recordset();
								$modi->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 5 WHERE id_recepcion_correspondencia = ".$id;
								$modi->abrir();
								$modi->cerrar();
								unset($modi);
							
							}													
						}
					}				

					/* ------------ Modificacion rurta ---------------- */								
				}
					
			if ($otra == 0)
				{
					$modi1 = new Recordset();
					$modi1->sql = $sqlll;
					$modi1->abrir();
					$modi1->cerrar();
					unset($modi1);
				}	
												
			echo '<script language="javascript" type="text/javascript">alert(orto("Modificaci&oacute;n Exitosa!!"));window.parent.frames.framo.location.href="form.php";</script>';
																																													 
		}
?>



<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<form method="post" name="recep" id="recep" autocomplete="off">
<table width="100%">
	<tr>
		<td>
			<table border="0" cellpadding="3" ccellspacing="2" width="99%">
				<tr align="center" style="display:" >
					<td colspan="3" align="center" height="0" id="divi">                                   
					</td>
				</tr>							
				<tr>
					<td align="right" width="150">
						<b>Correlativo:</b>&nbsp;
					</td>
					<td>
						<? 
							echo "<span class='mensaje'>".$n_correlativo1."</span>";
						?>								
					</td>
				</tr>
				<tr>
					<td align="right">
						<b>Fecha Documento:</b>&nbsp;
					</td>
					<td>
						<? 
							echo $fdocumento1;
						?>																								
					</td>
					<td align="right">
						<b>Fecha Registro:&nbsp;</b>
					</td>
					<td>
						<? 
							echo $registro1;
						?>																								
					</td>								
				</tr>
				<tr>
					<td align="right" width="150">
						<b>N&deg; Documento:</b>&nbsp;
					</td>
					<td>
						<? 
							if ($n_documento1!=""){echo $n_documento1;} else {echo "<u>Sin N&uacute;mero</u>";}
						?>								
					</td>
				</tr>							
				<tr>
					<td align="right">
						<b>Organ&iacute;smo:</b>&nbsp;
					</td>
					<td colspan="3">
						<? 
							echo ucwords(mb_strtolower($organismo1));
						?>								
					</td>
				</tr>													
<?
		 	if(ctype_digit($id_tipo_respuesta1))
			{
?>	
				<tr>
					<td align="right" width="120">
						<b>Tipo Respuesta:</b>
					</td>
					<td>
						<? 
							echo $tipo_respuesta1;
						?>																			
					</td>
				</tr>
				<tr>
					<td align="right" width="150">
						<b>En respuesta a Oficio:</b>
					</td>
					<td>
						<? 
							if (ctype_digit($n_correlativo_padre1)) { echo "<input type='text' name='oficio_padre' id='oficio_padre' maxlength='6' onkeypress='return validar(event,numeros)' value='".$n_correlativo_padre1."'/>&nbsp;<span class='mensaje'>*</span>";}												 	
						?>																			
					</td>									
				</tr>
<?
			}
?>			
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<fieldset style="width:97%; border-color:#EFEFEF"> 
			<legend class="titulomenu">Asignaci&oacute;n</legend>		
			<table cellspacing="3" cellpadding="2" border="0" width="100%">
				<tr>
					<td align="right" width="190">
						<b>Acci&oacute;n:</b>
					</td>
					<td>
						Procesar
						<input type="radio" name="acc" id="procesar" onclick="accion_corres(this.value);" value="procesar" />&nbsp;&nbsp;
						Archivar
						<input type="radio" name="acc" id="archivar" onclick="accion_corres(this.value);" value="archivar" />
					</td>
				</tr>
				<tr id="requie_oficio_exter">
					<td align="right">
						<b>Requiere Oficio Externo:</b>
					</td>
					<td>
						Si&nbsp;
						<input type="radio" name="req" id="si_requiere" value="si_requiere" <? echo $Sexterno1; ?> onclick="validar_reque_ofi(this.value);"/>&nbsp;&nbsp;
						No&nbsp;
						<input type="radio" name="req" id="no_requiere" value="no_requiere" <? echo $Sexterno2; ?> onclick="validar_reque_ofi(this.value);"/>
					</td>
				</tr>																				
				<tr id="unidad_Asignar" style="display:">
					<td align="right"><b>Asignar a:</b></td>
					<td>
						<? $rsun = new Recordset();	$rsun->sql = "SELECT id_unidad, unidad FROM unidad order by unidad"; 
						$rsun->llenarcombo($opciones = "\"cmbunidad\"", $checked = "$Sunidad", $fukcion = "onchange=\"m_apoyo(this.value)\"" , $diam = "style=\"width:240px; Height:20px;\""); 
						$rsun->cerrar(); 
						unset($rsun);																						
						?>&nbsp;<span class="mensaje">*</span>													
					</td>
				</tr>
				<tr id="mostrar_apoyo" style="display:none">
					<td align="right">
						<b>Con Apoyo:</b>
					</td>
					<td>
						Si&nbsp;
						<input type="radio" name="apoy" id="positivo" <? echo $Sapoyo1; ?> value="positivo" onclick="Ap_co(this.value);" />&nbsp;&nbsp;
						No&nbsp;
						<input type="radio" name="apoy" id="negativo" <? echo $Sapoyo2; ?> value="negativo" onclick="Ap_co(this.value)"/>
					</td>
				</tr>
				<tr id="mostrar_cc1" style="display:none">
					<td align="right">
						<b>Con Copia a:</b>
					</td>
					<td></td>
				</tr>										
				<tr id="list_apoyos" style="display:none">
					<td colspan="2" valign="top">
						<table width="100%"  class="b_table">
							<tr align="center">
								<td align="center">
									<? echo montar_documentos();?>
									<input type="hidden" name="cont_marcados" id="cont_marcados"/>
								</td>
							</tr>												
						</table>
					</td>
				</tr>
				<tr id="most_prioridad" style="display:">
					<td align="right">
						<b>Prioridad:</b>
					</td>
					<td valign="bottom">
						<? 
						$rsp = new Recordset();
						$rsp->sql = "SELECT id_prioridad, prioridad FROM prioridad"; 
						$rsp->llenarcombo($opciones = "\"prioridad\"", $checked = "$Sprioridad", $fukcion = "onchange=\"esta_prioridad(this.value)\"" , $diam = "style=\"width:100px; Height:20px;\"", $disab="$dis"); 
						$rsp->cerrar(); 
						unset($rsp);																						
						?>&nbsp;<span class="mensaje">*</span>
						<span id="vent_plazo" style="display:none">
							&nbsp;&nbsp;<b>Plazo:</b>&nbsp;<input type="text" name="plazo" id="plazo" style="width:30px" maxlength="2" value="<? echo $Splazo;?>" <? echo $dis; ?> onkeypress="return validar(event,numeros)" />&nbsp;<span class="mensaje">*</span>&nbsp;d&iacute;as
						</span>									
					</td>
				</tr>										
				<tr>
					<td valign="top" align="right"><b>Observaci&oacute;n:</b></td>
					<td>
						<textarea name="observacion" id="observacion" style="width:400px; height:60px" onkeyup="return maximaLongitud(this.id,300);"><? echo $aqwe; ?></textarea>&nbsp;<span class="mensaje">*</span>
						<br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span>
					</td>
				</tr>
				<tr><td align="right" class="mensaje" colspan="2">* Campos Obligatorios&nbsp;&nbsp;</td></tr>							
				<tr>
					<td align="center" colspan="2">
						<input type="hidden" name="cont_modi" id="cont_modi" value="<? echo $con; ?>" />
						<input type="button" name="modificar" id="modificar" value="Modificar" title="Modificar" onclick="editar(this.id);" />
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" onclick="cancelarT();" />																
					</td>
				</tr>																								
			</table>
			</fieldset>									
		
		</td>
	</tr>
</table>
<input type="hidden" name="accion" id="accion" /><input type="hidden"  name="irecepcion" id="irecepcion" value="<? echo $id; ?>"/>
</form>
<? 
/*			if($tipo_correspondencia1==0){
				echo '<script language="javascript" type="text/javascript"> tipo_corres("institucional"); document.getElementById("institucional").checked = true; </script>';
			} else {
				echo '<script language="javascript" type="text/javascript">tipo_corres("personal"); document.getElementById("personal").checked = true;</script>';
			}
			echo '<script language="javascript" type="text/javascript">document.getElementById("tipo_documento").value='.$id_tipo_documento1.';</script>'; 
			echo '<script language="javascript" type="text/javascript">mostrar_ofi('.$id_tipo_documento1.');</script>'; 
			if (isset($id_tipo_respuesta1)){
				echo '<script language="javascript" type="text/javascript">rpts("positivo"); document.getElementById("positivo").checked = true; document.getElementById("correlativo_padre").value='.$n_correlativo_padre1.'; document.getElementById("tipo_respuesta").value='.$id_tipo_respuesta1.';</script>'; 
			}
			if (isset($id_tipo_respuesta1) && ($id_tipo_respuesta1==1 || $id_tipo_respuesta1==2)){
				echo '<script language="javascript" type="text/javascript">informe('.$id_tipo_respuesta1.'); document.getElementById("cont_marcados").value='.$anfiscal1.'; document.getElementById("'.$anfiscal1.'").checked = true;</script>';  
			}
			if (isset($anexo1)){
				echo '<script language="javascript" type="text/javascript">vee_anex("SiAnex"); document.getElementById("listAnexo").value="'.$anexo1.'";</script>';  
			}						
			if (isset($gaceta_tipo1) && $gaceta_tipo1=="extraordinaria"){
				echo '<script language="javascript" type="text/javascript">document.getElementById("extraordinaria").checked = true;</script>';  
			}  												
			if (isset($gaceta_tipo1) && $gaceta_tipo1=="ordinaria"){
				echo '<script language="javascript" type="text/javascript">document.getElementById("ordinaria").checked = true;</script>';  
			} */
	} 
?>	 
<script language="javascript" type="text/javascript">
	$("#organismo").autocomplete("lista.php", { 
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

</script>
<? echo "<script language=\"javascript\" type=\"text/javascript\">function ejecutar_senten () { $funcionJ }  ejecutar_senten (); </script>"; ?>			