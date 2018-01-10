<?
require_once ("../../../../librerias/jpgraph/src/jpgraph.php");
require_once ("../../../../librerias/jpgraph/src/jpgraph_gantt.php");
require_once("../../../../librerias/Recordset.php");

$condicion = stripslashes($_GET["id"]);
if((isset($condicion) && $condicion!=""))
{
		$rsli1 = new Recordset();
		$rsli1->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m') AS inicio
						FROM crp_recepcion_correspondencia_cgr 
						INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
						INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
						WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' 
						ORDER BY crp_ruta_correspondencia_cgr.`fecha_recepcion` ASC LIMIT 1";	
			$rsli1->abrir();	
			if($rsli1->total_registros == 1)
				{
					$rsli1->siguiente();	
					$z1 = $rsli1->fila["inicio"]."-01";
					
				}
			$rsli1->cerrar();				
			unset($rsli1);
			
		$rsli2 = new Recordset();
		$rsli2->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m') AS fin
						FROM crp_recepcion_correspondencia_cgr 
							INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
							INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
						WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' 
						ORDER BY crp_ruta_correspondencia_cgr.`fecha_recepcion` DESC LIMIT 1";	
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

/*	$graph->scale->divider->SetWeight( 4 );
	$graph->scale->divider->SetColor( 'red' );
	$graph->scale->dividerh->SetWeight( 1 );
	$graph->scale->dividerh->SetColor( 'red' );*/
	// Add title and subtitle
	$graph->title-> Set("Ruta Correspondencia CGR medida en Tiempo");
	$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
	//$graph->subtitle->Set("(Draft version)");
	// Show day, week and month scale
	$graph->ShowHeaders(GANTT_HDAY | GANTT_HWEEK | GANTT_HMONTH);
	// Instead of week number show the date for the first day in the week
	// on the week scale
	$graph->scale->day->SetStyle(DAYSTYLE_SHORTDATE4);
	$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY2);
	// Make the week scale font smaller than the default
	$graph->scale->week->SetFont(FF_FONT0);
	// Use the short name of the month together with a 2 digit year
	// on the month scale
	
	$graph->scale->month->SetStyle(MONTHSTYLE_LONGNAMEYEAR4);
	$graph->scale->month->SetFontColor("#444444");
	$graph->scale->month->SetBackgroundColor("#ECE9D8");


//configuracion
	
	// Format the bar for the first activity
	// ($row,$title,$startdate,$enddate)
	//$activity = new GanttBar(0,"2013-00156","2013-04-01","2013-06-30");
	//$activity->SetPattern(BAND_RDIAG,"white");
	//$activity->SetFillColor("white");
	
	
	$rslOp = new Recordset();
	$rslOp->sql = "SELECT crp_recepcion_correspondencia_cgr.`id_tipo_documento` FROM crp_recepcion_correspondencia_cgr 
					WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = ".$condicion;	
	$rslOp->abrir();	
	if($rslOp->total_registros > 0)
		{
			$rslOp->siguiente();
			$asdw = $rslOp->fila["id_tipo_documento"];
		}
	$rslOp->cerrar();			
	unset($rslOp);
	
	$rsliQ = new Recordset();
	$rsliQ->sql = "SELECT crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr, DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha_cambio_estatus, 
						estatus.`estatus`, crp_ruta_correspondencia_cgr.`id_estatus`, estatus.`orden`, crp_recepcion_correspondencia_cgr.`id_tipo_documento`
					FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON 
						(crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
						INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
					WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = ".$condicion." ORDER BY estatus.`orden` ASC";	
		$rsliQ->abrir();	

		if($rsliQ->total_registros > 0)
			{
				switch($asdw)
				{
					case 9:
						for($f=0;$f<$rsliQ->total_registros;$f++)
						{
							$rsliQ->siguiente();	
							$y = 0;
							switch($rsliQ->fila["orden"])
							{	
								case 2: //asignado
									$rsli = new Recordset();
									$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
													FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
													INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 2";	
									$rsli->abrir();	
									if($rsli->total_registros == 1)
										{
											$rsli->siguiente();	
											$fecha_fin = $rsli->fila["fecha"];
											
										} else {
											$fecha_fin = date("Y-m-d");
											$y= 1;
										}
									$rsli->cerrar();				
									unset($rsli);								
								
									$activity1 = new GanttBar(0,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
									$activity1->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity1->SetPattern(GANTT_HLINE,"white");
									$activity1->SetFillColor("green");
									$graph->Add($activity1);						
									$fecha_fin = "";
									if($y == 1)	{
										$vline = new GanttVLine($z2,"Asignada!, Pendiente por Recibir          ","red",20);
										$vline->SetDayOffset(1);
										$vline->SetRowSpan(0);
										$graph->Add($vline);														
									}								
									$fecha_fin = "";													
		
								break;
								case 3: //en proceso
									$rsli = new Recordset();
									$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
													FROM crp_recepcion_correspondencia_cgr 
													INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
													INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 4 
													ORDER BY crp_ruta_correspondencia_cgr.`fecha_recepcion` ASC LIMIT 1";	
									$rsli->abrir();	
									if($rsli->total_registros == 1)
										{
											$rsli->siguiente();	
											$fecha_fin = $rsli->fila["fecha"];
											
										} else {
											$fecha_fin = date("Y-m-d");
											$y= 1;
										}
									$rsli->cerrar();				
									unset($rsli);								
								
									$activity3 = new GanttBar(1,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
									$activity3->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity3->SetPattern(GANTT_HLINE,"white");
									$activity3->SetFillColor("green");					
									$graph->Add($activity3);
									if($y == 1)	{
										$vline = new GanttVLine($z2,"En Proceso!, Sin entregar a Despacho","red",20);
										$vline->SetDayOffset(1);
										$vline->SetRowSpan(2);
										$graph->Add($vline);														
									}								
									$fecha_fin = "";
								break;
								case 5: // aprobado
									$rsli = new Recordset();
									$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
													FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
													INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 5 ORDER BY crp_ruta_correspondencia_cgr.`fecha_recepcion` ASC LIMIT 1";	
									$rsli->abrir();	
									if($rsli->total_registros == 1)
										{
											$rsli->siguiente();	
											$fecha_fin = $rsli->fila["fecha"];
											
										} else {
											$fecha_fin = date("Y-m-d");
											$y = 1;
										}
									$rsli->cerrar();				
									unset($rsli);								
								
									$activity5 = new GanttBar(4,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
									$activity5->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity5->SetPattern(GANTT_HLINE,"white");
									$activity5->SetFillColor("green");					
									$graph->Add($activity5);	
									$fecha_fin = "";
									
									if($y == 1)	{
										$vline = new GanttVLine($z2,"Aprobada!, Aun sin Enviar            ","gray",20);
										$vline->SetDayOffset(1);
										$vline->SetRowSpan(3);
										$graph->Add($vline);														
									}	
								
								break;
								case 6: // enviado
									$rslien = new Recordset();
									$rslien->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
													FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
													INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 6";	
									$rslien->abrir();	
									if($rslien->total_registros == 1)
										{
											$rslien->siguiente();	
											$fecha_finhh = $rslien->fila["fecha"];
											
										} else {
											$fecha_finhh = date("Y-m-d");
											$y = 1;
										}
									$rslien->cerrar();				
									unset($rslien);								
								
									$activity6 = new GanttBar(5,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_finhh);
									$activity6->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity6->SetPattern(GANTT_HLINE,"white");
									$activity6->SetFillColor("green");					
									$graph->Add($activity6);	
									$fecha_finhh = "";
									
									if($y == 1)	{
										$a = 
										$vline = new GanttVLine($z2,"Enviada!, Pendiente por Entregar                      ","gray",20);
										$vline->SetDayOffset(1);
										$vline->SetRowSpan(4);
										$graph->Add($vline);														
									}
																
								break;
								case 7: // entregado	
		/*							$activity7 = new GanttBar(5,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],"2013-06-02");
									$activity7->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity7->SetPattern(GANTT_HLINE,"white");
									$activity7->SetFillColor("green");					
									$graph->Add($activity7);*/										
									$milestone = new MileStone(6,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]));
									$milestone->caption->SetFont(FF_ARIAL,FS_BOLD,10);
									$graph->Add($milestone);
									$vline = new GanttVLine($rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]));
									$vline->SetDayOffset(1);
									$graph->Add($vline);							
								break;

							}
						}			
					break;
					case 8:
						for($f=0;$f<$rsliQ->total_registros;$f++)
						{
							$rsliQ->siguiente();	
							$y = 0;
							switch($rsliQ->fila["orden"])
							{	
								case 1: //recibido
									$rsli = new Recordset();
									$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
													FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
														INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 5";	
									$rsli->abrir();	
									if($rsli->total_registros == 1)
										{
											$rsli->siguiente();	
											$fecha_fin = $rsli->fila["fecha"];
											
										}	else {
											$fecha_fin = date("Y-m-d");
											$y= 1;
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
									
									if($y == 1)	{
										$vline = new GanttVLine($z2,"Recibida!, Pendiente por Enviar            ","gray",20);
										$vline->SetDayOffset(1);
										$vline->SetRowSpan(0);
										$graph->Add($vline);														
									}																	

								break;						
								
								case 6: // enviado
									$rslien = new Recordset();
									$rslien->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
													FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
													INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 6";	
									$rslien->abrir();	
									if($rslien->total_registros == 1)
										{
											$rslien->siguiente();	
											$fecha_finhh = $rslien->fila["fecha"];
											
										} else {
											$fecha_finhh = date("Y-m-d");
											$y = 1;
										}
									$rslien->cerrar();				
									unset($rslien);								
								
									$activity6 = new GanttBar(5,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_finhh);
									$activity6->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity6->SetPattern(GANTT_HLINE,"white");
									$activity6->SetFillColor("green");					
									$graph->Add($activity6);	
									$fecha_finhh = "";
									
									if($y == 1)	{
										$a = 
										$vline = new GanttVLine($z2,"Enviada!, Pendiente por Entregar                            ","gray",20);
										$vline->SetDayOffset(1);
										$vline->SetRowSpan(4);
										$graph->Add($vline);														
									}
																
								break;
								
								case 7: // entregado	
		/*							$activity7 = new GanttBar(5,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],"2013-06-02");
									$activity7->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity7->SetPattern(GANTT_HLINE,"white");
									$activity7->SetFillColor("green");					
									$graph->Add($activity7);*/										
									$milestone = new MileStone(6,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]));
									$milestone->caption->SetFont(FF_ARIAL,FS_BOLD,10);
									$graph->Add($milestone);
									$vline = new GanttVLine($rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]));
									$vline->SetDayOffset(1);
									$graph->Add($vline);							
								break;

							}
						}								
					break;
					case 7:
						for($f=0;$f<$rsliQ->total_registros;$f++)
						{
							$rsliQ->siguiente();	
							$y = 0;
							switch($rsliQ->fila["orden"])
							{						
								case 7: // entregado	
			/*							$activity7 = new GanttBar(5,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],"2013-06-02");
									$activity7->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity7->SetPattern(GANTT_HLINE,"white");
									$activity7->SetFillColor("green");					
									$graph->Add($activity7);*/										
									$milestone = new MileStone(0,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]));
									$milestone->caption->SetFont(FF_ARIAL,FS_BOLD,10);
									$graph->Add($milestone);
									$vline = new GanttVLine($rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]));
									$vline->SetDayOffset(1);
									$graph->Add($vline);							
								break;					
							}
						}
					break;
					case 10:
						for($f=0;$f<$rsliQ->total_registros;$f++)
						{
							$rsliQ->siguiente();	
							$y = 0;
							switch($rsliQ->fila["orden"])
							{						
								case 7: // entregado	
			/*							$activity7 = new GanttBar(5,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],"2013-06-02");
									$activity7->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity7->SetPattern(GANTT_HLINE,"white");
									$activity7->SetFillColor("green");					
									$graph->Add($activity7);*/										
									$milestone = new MileStone(0,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]));
									$milestone->caption->SetFont(FF_ARIAL,FS_BOLD,10);
									$graph->Add($milestone);
									$vline = new GanttVLine($rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]));
									$vline->SetDayOffset(1);
									$graph->Add($vline);							
								break;					
							}
						}
					break;
					case 13:
						for($f=0;$f<$rsliQ->total_registros;$f++)
						{
							$rsliQ->siguiente();	
							$y = 0;
							switch($rsliQ->fila["orden"])
							{	
								case 2: //asignado
									$rsli = new Recordset();
									$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
													FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
													INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 2";	
									$rsli->abrir();	
									if($rsli->total_registros == 1)
										{
											$rsli->siguiente();	
											$fecha_fin = $rsli->fila["fecha"];
											
										} else {
											$fecha_fin = date("Y-m-d");
											$y= 1;
										}
									$rsli->cerrar();				
									unset($rsli);								
								
									$activity1 = new GanttBar(0,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
									$activity1->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity1->SetPattern(GANTT_HLINE,"white");
									$activity1->SetFillColor("green");
									$graph->Add($activity1);						
									$fecha_fin = "";
									if($y == 1)	{
										$vline = new GanttVLine($z2,"Asignada!, Pendiente por Recibir          ","red",20);
										$vline->SetDayOffset(1);
										$vline->SetRowSpan(0);
										$graph->Add($vline);														
									}								
									$fecha_fin = "";													
		
								break;
								case 3: //en proceso
									$rsli = new Recordset();
									$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
													FROM crp_recepcion_correspondencia_cgr 
													INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
													INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 4 
													ORDER BY crp_ruta_correspondencia_cgr.`fecha_recepcion` ASC LIMIT 1";	
									$rsli->abrir();	
									if($rsli->total_registros == 1)
										{
											$rsli->siguiente();	
											$fecha_fin = $rsli->fila["fecha"];
											
										} else {
											$fecha_fin = date("Y-m-d");
											$y= 1;
										}
									$rsli->cerrar();				
									unset($rsli);								
								
									$activity3 = new GanttBar(1,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
									$activity3->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity3->SetPattern(GANTT_HLINE,"white");
									$activity3->SetFillColor("green");					
									$graph->Add($activity3);
									if($y == 1)	{
										$vline = new GanttVLine($z2,"En Proceso!, Sin entregar a Despacho","red",20);
										$vline->SetDayOffset(1);
										$vline->SetRowSpan(2);
										$graph->Add($vline);														
									}								
									$fecha_fin = "";
								break;
								case 5: // aprobado
									$rsli = new Recordset();
									$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
													FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
													INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 5 ORDER BY crp_ruta_correspondencia_cgr.`fecha_recepcion` ASC LIMIT 1";	
									$rsli->abrir();	
									if($rsli->total_registros == 1)
										{
											$rsli->siguiente();	
											$fecha_fin = $rsli->fila["fecha"];
											
										} else {
											$fecha_fin = date("Y-m-d");
											$y = 1;
										}
									$rsli->cerrar();				
									unset($rsli);								
								
									$activity5 = new GanttBar(4,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
									$activity5->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity5->SetPattern(GANTT_HLINE,"white");
									$activity5->SetFillColor("green");					
									$graph->Add($activity5);	
									$fecha_fin = "";
									
									if($y == 1)	{
										$vline = new GanttVLine($z2,"Aprobada!, Aun sin Enviar            ","gray",20);
										$vline->SetDayOffset(1);
										$vline->SetRowSpan(3);
										$graph->Add($vline);														
									}	
								
								break;
								case 6: // enviado
									$rslien = new Recordset();
									$rslien->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
													FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
													INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 6";	
									$rslien->abrir();	
									if($rslien->total_registros == 1)
										{
											$rslien->siguiente();	
											$fecha_finhh = $rslien->fila["fecha"];
											
										} else {
											$fecha_finhh = date("Y-m-d");
											$y = 1;
										}
									$rslien->cerrar();				
									unset($rslien);								
								
									$activity6 = new GanttBar(5,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_finhh);
									$activity6->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity6->SetPattern(GANTT_HLINE,"white");
									$activity6->SetFillColor("green");					
									$graph->Add($activity6);	
									$fecha_finhh = "";
									
									if($y == 1)	{
										$a = 
										$vline = new GanttVLine($z2,"Enviada!, Pendiente por Entregar                      ","gray",20);
										$vline->SetDayOffset(1);
										$vline->SetRowSpan(4);
										$graph->Add($vline);														
									}
																
								break;
								case 7: // entregado	
		/*							$activity7 = new GanttBar(5,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],"2013-06-02");
									$activity7->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
									$activity7->SetPattern(GANTT_HLINE,"white");
									$activity7->SetFillColor("green");					
									$graph->Add($activity7);*/										
									$milestone = new MileStone(6,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]));
									$milestone->caption->SetFont(FF_ARIAL,FS_BOLD,10);
									$graph->Add($milestone);
									$vline = new GanttVLine($rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]));
									$vline->SetDayOffset(1);
									$graph->Add($vline);							
								break;

							}
						}			
					break;
				}				
				
				
/*				for($f=0;$f<$rsliQ->total_registros;$f++)
				{
					$rsliQ->siguiente();	
					$y = 0;
					switch($rsliQ->fila["orden"])
					{
						case 1: //recibido
							$rslibsq = new Recordset();
							$rslibsq->sql = "SELECT crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr` 
											FROM crp_asignacion_correspondencia_cgr INNER JOIN crp_recepcion_correspondencia_cgr ON (crp_asignacion_correspondencia_cgr.`id_recepcion_correspondencia_cgr` = crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)
											WHERE crp_asignacion_correspondencia_cgr.`id_recepcion_correspondencia_cgr` = '".$condicion."' AND crp_recepcion_correspondencia_cgr.`id_tipo_documento` = 9 ";	
							$rslibsq->abrir();	
							if($rslibsq->total_registros == 1)
								{																				
									$rsli = new Recordset();
									$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
													FROM crp_recepcion_correspondencia_cgr 
													INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
													INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 1";	
									$rsli->abrir();	
									if($rsli->total_registros == 1)
										{
											$rsli->siguiente();	
											$fecha_fin = $rsli->fila["fecha"];
											
										}	else {
											$fecha_fin = date("Y-m-d");
											$y= 1;
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
									
									if($y == 1)	{
										$vline = new GanttVLine($z2,"Recibida!, Pendiente por Asignar","red",20);
										$vline->SetDayOffset(1);
										$vline->SetRowSpan(4);
										$graph->Add($vline);														
									}									
								} else {
									$rsli = new Recordset();
									$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
													FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
													WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 5";	
									$rsli->abrir();	
									if($rsli->total_registros == 1)
										{
											$rsli->siguiente();	
											$fecha_fin = $rsli->fila["fecha"];
											
										}	else {
											$fecha_fin = date("Y-m-d");
											$y= 1;
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
									
									if($y == 1)	{
										$vline = new GanttVLine($z2,"Recibida!, Pendiente por Enviar","red",20);
										$vline->SetDayOffset(1);
										$vline->SetRowSpan(4);
										$graph->Add($vline);														
									}																	
								}
							$rslibsq->cerrar();				
							unset($rslibsq);
						break;						
						case 2: //asignado
							$rsli = new Recordset();
							$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
											FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
											WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 2";	
							$rsli->abrir();	
							if($rsli->total_registros == 1)
								{
									$rsli->siguiente();	
									$fecha_fin = $rsli->fila["fecha"];
									
								} else {
									$fecha_fin = date("Y-m-d");
									$y= 1;
								}
							$rsli->cerrar();				
							unset($rsli);								
						
							$activity2 = new GanttBar(1,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
							//$activity2 = new GanttBar(2,"a","2013-04-10","2013-04-20");
							$activity2->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
							$activity2->SetPattern(GANTT_HLINE,"white");
							$activity2->SetFillColor("green");
							$graph->Add($activity2);
							if($y == 1)	{
								$vline = new GanttVLine($z2,"Recibida!, Aun sin Asignar","red",20);
								$vline->SetDayOffset(1);
								$vline->SetRowSpan(4);
								$graph->Add($vline);														
							}								
							$fecha_fin = "";													

						break;
						case 3: //en proceso
							$rsli = new Recordset();
							$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
											FROM crp_recepcion_correspondencia_cgr 
											INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
											INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
											WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 3 
											ORDER BY crp_ruta_correspondencia_cgr.`fecha_recepcion` ASC LIMIT 1";	
							$rsli->abrir();	
							if($rsli->total_registros == 1)
								{
									$rsli->siguiente();	
									$fecha_fin = $rsli->fila["fecha"];
									
								} else {
									$fecha_fin = date("Y-m-d");
									$y= 1;
								}
							$rsli->cerrar();				
							unset($rsli);								
						
							$activity3 = new GanttBar(2,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
							$activity3->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
							$activity3->SetPattern(GANTT_HLINE,"white");
							$activity3->SetFillColor("green");					
							$graph->Add($activity3);
							if($y == 1)	{
								$vline = new GanttVLine($z2,"Asignada!, Sin entregar a La Gerencia","red",20);
								$vline->SetDayOffset(1);
								$vline->SetRowSpan(4);
								$graph->Add($vline);														
							}								
							$fecha_fin = "";
						break;
						case 4: // revicion
							$rsli = new Recordset();
							$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
											FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
											INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
											WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 4 ORDER BY crp_ruta_correspondencia_cgr.`fecha_recepcion` ASC LIMIT 1";	
							$rsli->abrir();	
							if($rsli->total_registros == 1)
								{
									$rsli->siguiente();	
									$fecha_fin = $rsli->fila["fecha"];
									
								} else {
									$fecha_fin = date("Y-m-d");
									$y= 1;
								}
							$rsli->cerrar();				
							unset($rsli);								
						
							$activity4 = new GanttBar(3,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
							$activity4->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
							$activity4->SetPattern(GANTT_HLINE,"white");
							$activity4->SetFillColor("green");					
							$graph->Add($activity4);
							if($y == 1)	{
								$vline = new GanttVLine($z2,html_entity_decode("En Revisi&oacute;n!, sin Aprobar           "),"gray",20);
								$vline->SetDayOffset(1);
								$vline->SetRowSpan(4);
								$graph->Add($vline);														
							}																
							$fecha_fin = "";	

						break;
						case 5: // aprobado
							$rsli = new Recordset();
							$rsli->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
											FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
											INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
											WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 5 ORDER BY crp_ruta_correspondencia_cgr.`fecha_recepcion` ASC LIMIT 1";	
							$rsli->abrir();	
							if($rsli->total_registros == 1)
								{
									$rsli->siguiente();	
									$fecha_fin = $rsli->fila["fecha"];
									
								} else {
									$fecha_fin = date("Y-m-d");
									$y = 1;
								}
							$rsli->cerrar();				
							unset($rsli);								
						
							$activity5 = new GanttBar(4,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_fin);
							$activity5->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
							$activity5->SetPattern(GANTT_HLINE,"white");
							$activity5->SetFillColor("green");					
							$graph->Add($activity5);	
							$fecha_fin = "";
							
							if($y == 1)	{
								$vline = new GanttVLine($z2,"Aprobada!, Aun sin Enviar            ","gray",20);
								$vline->SetDayOffset(1);
								$vline->SetRowSpan(4);
								$graph->Add($vline);														
							}	
						
						break;
						case 6: // enviado
							$rslien = new Recordset();
							$rslien->sql = "SELECT DATE_FORMAT(crp_ruta_correspondencia_cgr.`fecha_recepcion`,'%Y-%m-%d') AS fecha
											FROM crp_recepcion_correspondencia_cgr INNER JOIN crp_ruta_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr) 
											INNER JOIN estatus ON (crp_ruta_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
											WHERE crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '".$condicion."' AND crp_ruta_correspondencia_cgr.id_estatus = 6";	
							$rslien->abrir();	
							if($rslien->total_registros == 1)
								{
									$rslien->siguiente();	
									$fecha_finhh = $rslien->fila["fecha"];
									
								} else {
									$fecha_finhh = date("Y-m-d");
									$y = 1;
								}
							$rslien->cerrar();				
							unset($rslien);								
						
							$activity6 = new GanttBar(5,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],$fecha_finhh);
							$activity6->caption->Set(html_entity_decode($rsliQ->fila["estatus"]));
							$activity6->SetPattern(GANTT_HLINE,"white");
							$activity6->SetFillColor("green");					
							$graph->Add($activity6);	
							$fecha_finhh = "";
							
							if($y == 1)	{
								$a = 
								$vline = new GanttVLine($z2,"Enviada!, Pendiente por Entregar                      ","gray",20);
								$vline->SetDayOffset(1);
								$vline->SetRowSpan(4);
								$graph->Add($vline);														
							}
														
						break;
						case 7: // entregado											
							$milestone = new MileStone(6,html_entity_decode($rsliQ->fila["estatus"]),$rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]));
							$milestone->caption->SetFont(FF_ARIAL,FS_BOLD,10);
							$graph->Add($milestone);
							$vline = new GanttVLine($rsliQ->fila["fecha_cambio_estatus"],html_entity_decode($rsliQ->fila["estatus"]));
							$vline->SetDayOffset(1);
							$graph->Add($vline);							
						break;
					}				
				}
*/			}

	$graph->Stroke();					

	
		
	
} else {
	echo "El gr&aacute;fico no pudo ser proyectado";
}
?>