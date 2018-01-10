<?
require_once ("../../../../librerias/jpgraph/src/jpgraph.php");
require_once ("../../../../librerias/jpgraph/src/jpgraph_gantt.php");
require_once("../../../../librerias/Recordset.php");

$condicion = stripslashes($_GET["id"]);
if((isset($condicion) && $condicion!=""))
{
		$rsli1 = new Recordset();
		$rsli1->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia.`fecha_cambio_estatus`,'%Y-%m') AS inicio
						 FROM crp_recepcion_correspondencia INNER JOIN crp_ruta_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_ruta_correspondencia.id_recepcion_correspondencia) INNER JOIN estatus ON (crp_ruta_correspondencia.`id_estatus` = estatus.`id_estatus`)
						 WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$condicion."' ORDER BY crp_ruta_correspondencia.`fecha_cambio_estatus` ASC LIMIT 1";	
			$rsli1->abrir();	
			if($rsli1->total_registros == 1)
				{
					$rsli1->siguiente();	
					$z1 = $rsli1->fila["inicio"]."-01";
					
				}
			$rsli1->cerrar();				
			unset($rsli1);
			
		$rsli2 = new Recordset();
		$rsli2->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia.`fecha_cambio_estatus`,'%Y-%m') AS fin
						 FROM crp_recepcion_correspondencia INNER JOIN crp_ruta_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_ruta_correspondencia.id_recepcion_correspondencia) INNER JOIN estatus ON (crp_ruta_correspondencia.`id_estatus` = estatus.`id_estatus`)
						 WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$condicion."' ORDER BY crp_ruta_correspondencia.`fecha_cambio_estatus` DESC LIMIT 1";	
		$rsli2->abrir();	
		if($rsli2->total_registros == 1)
			{
				$rsli2->siguiente();	
				$trat = explode("-",$rsli2->fila["fin"]);
				if($trat[1]=="02"){
					$z2 = $rsli2->fila["fin"]."-28";
				} else {
					$z2 = $rsli2->fila["fin"]."-30";
				}
			}
	
		$rsli2->cerrar();				
		unset($rsli2);

//configuracion
	$graph  = new GanttGraph ();
	$graph->SetDateRange($z1,$z2);
	$graph->SetShadow();
	$graph->scale->SetDateLocale("");
	$graph->title-> Set("Ruta Correspondencia medida en Tiempo");
	$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
	$graph->ShowHeaders(GANTT_HDAY | GANTT_HWEEK | GANTT_HMONTH);
	$graph->scale->day->SetStyle(DAYSTYLE_SHORTDATE4);
	$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY2);
	$graph->scale->week->SetFont(FF_FONT0);
	
	$graph->scale->month->SetStyle(MONTHSTYLE_LONGNAMEYEAR4);
	$graph->scale->month->SetFontColor("#444444");
	$graph->scale->month->SetBackgroundColor("#ECE9D8");
		
	$rsliQ = new Recordset();
	$rsliQ->sql = "SELECT crp_recepcion_correspondencia.id_recepcion_correspondencia, DATE_FORMAT(crp_ruta_correspondencia.`fecha_cambio_estatus`,'%Y-%m-%d') as fecha_cambio_estatus, 
							estatus.`estatus`, crp_ruta_correspondencia.`id_estatus`, estatus.`orden`
					FROM crp_recepcion_correspondencia INNER JOIN crp_ruta_correspondencia ON 
						(crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_ruta_correspondencia.id_recepcion_correspondencia) 
						INNER JOIN estatus ON (crp_ruta_correspondencia.`id_estatus` = estatus.`id_estatus`)
					WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$condicion."' ORDER BY estatus.`orden`ASC";	
		$rsliQ->abrir();	

		if($rsliQ->total_registros > 0)
			{
				for($f=0;$f<$rsliQ->total_registros;$f++)
				{
					$rsliQ->siguiente();	
					switch($rsliQ->fila["orden"])
					{
						case 1: //recibido
							$rsli = new Recordset();
							$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia.`fecha_cambio_estatus`,'%Y-%m-%d') AS fecha
											 FROM crp_recepcion_correspondencia INNER JOIN crp_ruta_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_ruta_correspondencia.id_recepcion_correspondencia) INNER JOIN estatus ON (crp_ruta_correspondencia.`id_estatus` = estatus.`id_estatus`)
											 WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$condicion."' AND crp_ruta_correspondencia.id_estatus = 1";	
							$rsli->abrir();	
							if($rsli->total_registros == 1)
								{
									$rsli->siguiente();	
									$fecha_fin = $rsli->fila["fecha"];
									
								}	else {
									$fecha_fin = date("Y-m-d");
								}
							$rsli->cerrar();				
							unset($rsli);					
										
							//$activity1 = new GanttBar(1,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
							$activity1 = new GanttBar(0,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
							$activity1->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
							$activity1->SetPattern(GANTT_HLINE,"white");
							$activity1->SetFillColor("green");
							$graph->Add($activity1);						
							$fecha_fin = "";
							
							$vline = new GanttVLine($rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]), 'red', 8);
							$vline->SetDayOffset(0);
							$graph->Add($vline);
						break;						
						case 2: //asignado
							$rsli = new Recordset();
							$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia.`fecha_cambio_estatus`,'%Y-%m-%d') AS fecha
											 FROM crp_recepcion_correspondencia INNER JOIN crp_ruta_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_ruta_correspondencia.id_recepcion_correspondencia) INNER JOIN estatus ON (crp_ruta_correspondencia.`id_estatus` = estatus.`id_estatus`)
											 WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$condicion."' AND crp_ruta_correspondencia.id_estatus = 2";	
							$rsli->abrir();	
							if($rsli->total_registros == 1)
								{
									$rsli->siguiente();	
									$fecha_fin = $rsli->fila["fecha"];
									
								} else {
									$fecha_fin = date("Y-m-d");
								}
							$rsli->cerrar();				
							unset($rsli);								
						
							$activity2 = new GanttBar(1,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
							//$activity2 = new GanttBar(2,"a","2013-04-10","2013-04-20");
							$activity2->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
							$activity2->SetPattern(GANTT_HLINE,"white");
							$activity2->SetFillColor("green");
							$graph->Add($activity2);	
							$fecha_fin = "";													

						break;
						case 3: //en proceso
							$rsli = new Recordset();
							$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia.`fecha_cambio_estatus`,'%Y-%m-%d') AS fecha
											 FROM crp_recepcion_correspondencia INNER JOIN crp_ruta_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_ruta_correspondencia.id_recepcion_correspondencia) INNER JOIN estatus ON (crp_ruta_correspondencia.`id_estatus` = estatus.`id_estatus`)
											 WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$condicion."' AND crp_ruta_correspondencia.id_estatus = 3 ORDER BY crp_ruta_correspondencia.`fecha_cambio_estatus` ASC LIMIT 1";	
							$rsli->abrir();	
							if($rsli->total_registros == 1)
								{
									$rsli->siguiente();	
									$fecha_fin = $rsli->fila["fecha"];
									
								} else {
									$fecha_fin = date("Y-m-d");
								}
							$rsli->cerrar();				
							unset($rsli);								
						
							$activity3 = new GanttBar(2,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
							$activity3->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
							$activity3->SetPattern(GANTT_HLINE,"white");
							$activity3->SetFillColor("green");					
							$graph->Add($activity3);	
							$fecha_fin = "";
						break;
						case 4: // revicion
							$rsli = new Recordset();
							$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia.`fecha_cambio_estatus`,'%Y-%m-%d') AS fecha
											 FROM crp_recepcion_correspondencia INNER JOIN crp_ruta_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_ruta_correspondencia.id_recepcion_correspondencia) INNER JOIN estatus ON (crp_ruta_correspondencia.`id_estatus` = estatus.`id_estatus`)
											 WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$condicion."' AND crp_ruta_correspondencia.id_estatus = 4 ORDER BY crp_ruta_correspondencia.`fecha_cambio_estatus` ASC LIMIT 1";	
							$rsli->abrir();	
							if($rsli->total_registros == 1)
								{
									$rsli->siguiente();	
									$fecha_fin = $rsli->fila["fecha"];
									
								} else {
									$fecha_fin = date("Y-m-d");
								}
							$rsli->cerrar();				
							unset($rsli);								
						
							$activity4 = new GanttBar(3,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
							$activity4->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
							$activity4->SetPattern(GANTT_HLINE,"white");
							$activity4->SetFillColor("green");					
							$graph->Add($activity4);	
							$fecha_fin = "";	

						break;
						case 5: // aprobado
							$rsli = new Recordset();
							$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia.`fecha_cambio_estatus`,'%Y-%m-%d') AS fecha
											 FROM crp_recepcion_correspondencia INNER JOIN crp_ruta_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_ruta_correspondencia.id_recepcion_correspondencia) INNER JOIN estatus ON (crp_ruta_correspondencia.`id_estatus` = estatus.`id_estatus`)
											 WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$condicion."' AND crp_ruta_correspondencia.id_estatus = 5 ORDER BY crp_ruta_correspondencia.`fecha_cambio_estatus` ASC LIMIT 1";	
							$rsli->abrir();	
							if($rsli->total_registros == 1)
								{
									$rsli->siguiente();	
									$fecha_fin = $rsli->fila["fecha"];
									
								} else {
									$fecha_fin = date("Y-m-d");
								}
							$rsli->cerrar();				
							unset($rsli);								
						
							$activity5 = new GanttBar(4,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
							$activity5->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
							$activity5->SetPattern(GANTT_HLINE,"white");
							$activity5->SetFillColor("green");					
							$graph->Add($activity5);	
							$fecha_fin = "";		
						
						break;
						case 6: // enviado
							$rslien = new Recordset();
							$rslien->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia.`fecha_cambio_estatus`,'%Y-%m-%d') AS fecha
											 FROM crp_recepcion_correspondencia INNER JOIN crp_ruta_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_ruta_correspondencia.id_recepcion_correspondencia) INNER JOIN estatus ON (crp_ruta_correspondencia.`id_estatus` = estatus.`id_estatus`)
											 WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$condicion."' AND crp_ruta_correspondencia.id_estatus = 6";	
							$rslien->abrir();	
							if($rslien->total_registros == 1)
								{
									$rslien->siguiente();	
									$fecha_finhh = $rslien->fila["fecha"];
									
								} else {
									$fecha_finhh = date("Y-m-d");
								}
							$rslien->cerrar();				
							unset($rslien);								
						
							$activity6 = new GanttBar(5,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_finhh);
							$activity6->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
							$activity6->SetPattern(GANTT_HLINE,"white");
							$activity6->SetFillColor("green");					
							$graph->Add($activity6);	
							$fecha_finhh = "";
						break;
						case 7: // entregado											
							$vline = new GanttVLine($rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]), 'red', 8);
							$vline->SetDayOffset(1);
							$graph->Add($vline);
						break;
					}				
				}
			}
	$graph->Stroke();						
} else {
	echo "El gr&aacute;fico no pudo ser proyectada";
}
?>