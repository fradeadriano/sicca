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
	$graph->SetDateRange("2013-04-01","2013-06-30");
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
		
/*	$rsliQ = new Recordset();
	$rsliQ->sql = "SELECT crp_recepcion_correspondencia.id_recepcion_correspondencia, DATE_FORMAT(crp_ruta_correspondencia.`fecha_cambio_estatus`,'%Y-%m-%d') as fecha_cambio_estatus, 
							estatus.`estatus`, crp_ruta_correspondencia.`id_estatus`, estatus.`orden`
					FROM crp_recepcion_correspondencia INNER JOIN crp_ruta_correspondencia ON 
						(crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_ruta_correspondencia.id_recepcion_correspondencia) 
						INNER JOIN estatus ON (crp_ruta_correspondencia.`id_estatus` = estatus.`id_estatus`)
					WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = '".$condicion."' ORDER BY estatus.`orden`ASC";	
		$rsliQ->abrir();	

		if($rsliQ->total_registros > 0)
			{*/

							$activity = new GanttBar(0,"recibido","2013-04-30","2013-04-30");
							$activity->caption->Set("recibido");
							$activity->SetPattern(GANTT_HLINE,"white");
							$activity->SetFillColor("green");
							$graph->Add($activity);
							
							$activity1 = new GanttBar(1,"asignado","2013-04-30","2013-05-01");
							$activity1->caption->Set("asignado");
							$activity1->SetPattern(GANTT_HLINE,"white");
							$activity1->SetFillColor("green");
							$graph->Add($activity1);						

							$activity2 = new GanttBar(2,"proceso","2013-05-01","2013-05-24");
							$activity2->caption->Set("proceso");
							$activity2->SetPattern(GANTT_HLINE,"white");
							$activity2->SetFillColor("green");
							$graph->Add($activity2);						

							$activity3 = new GanttBar(3,"revision","2013-05-24","2013-05-24");
							$activity3->caption->Set("revision");
							$activity3->SetPattern(GANTT_HLINE,"white");
							$activity3->SetFillColor("green");
							$graph->Add($activity3);						

							$activity4 = new GanttBar(4,"aprobado","2013-05-24","2013-06-01");
							$activity4->caption->Set("aprobado");
							$activity4->SetPattern(GANTT_HLINE,"white");
							$activity4->SetFillColor("green");
							$graph->Add($activity4);						

							$activity5 = new GanttBar(5,"enviado","2013-06-01","2013-06-02");
							$activity5->caption->Set("enviado");
							$activity5->SetPattern(GANTT_HLINE,"white");
							$activity5->SetFillColor("green");
							$graph->Add($activity5);						
										
							$aq = new MileStone(6,"Entregado","2013-06-02","Entregado");
							

							$graph->Add($aq);						

	$vline = new GanttVLine("2013-06-02","FIN");
	$vline->SetDayOffset(1);
	$graph->Add($vline);
			//}
	$graph->Stroke();						
} else {
	echo "El gr&aacute;fico no pudo ser proyectada";
}
?>