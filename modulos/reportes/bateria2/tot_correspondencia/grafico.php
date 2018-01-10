<?
require_once ("../../../../librerias/jpgraph/src/jpgraph.php");
require_once ("../../../../librerias/jpgraph/src/jpgraph_pie.php");
require_once ("../../../../librerias/jpgraph/src/jpgraph_pie3d.php");
require_once("../../../../librerias/Recordset.php");
$condicion = stripslashes($_GET["tipo"]);
$fechas = stripslashes($_GET["campo1"]);
$rslista = new Recordset();
if((isset($condicion) && $condicion!="") && (isset($fechas) && $fechas!=""))
	{
		$sub_desgloce = explode("_",$fechas);
		$where = " WHERE crp_recepcion_correspondencia_cgr.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
	}
	
	if($condicion=="estatus"){
			$rsli = new Recordset();
			$rsli->sql = "SELECT COUNT(crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr`) AS total_estatus, estatus.`estatus`
									FROM crp_asignacion_correspondencia_cgr INNER JOIN estatus ON (crp_asignacion_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
									INNER JOIN crp_recepcion_correspondencia_cgr  ON (crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr` = crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)
									$where
									GROUP BY crp_asignacion_correspondencia_cgr.`id_estatus`
									ORDER BY total_estatus DESC";	
				$rsli->abrir();	
		
				if($rsli->total_registros > 0)
					{
						for($i = 0; $i < $rsli->total_registros; $i++)
						{
							$rsli->siguiente();	
							$data1[$i] = $rsli->fila["total_estatus"];
							$legend[$i] = html_entity_decode($rsli->fila["estatus"]);
						}
					}
				/////////////////////////////////
		/*			$data1 = "array(".$data1.")";
				$legend = "array(".$legend.")";*/
		
		
				$piegraph = new PieGraph(600,400);
				
				$piegraph->title->Set("Porcentaje Totalización por estatus");
				$piegraph->title->SetFont(FF_FONT1,FS_BOLD);
				$piegraph->legend->Pos( 0.05,0.5,"left" ,"left");
				$p1 = new PiePlot3D($data1);
				$p1->SetLegends($legend);
				$p1->SetTheme("earth");
				$p1->SetAngle(30);
				$p1->SetSize(0.3);
				$p1->SetCenter(0.5,0.2);
				$piegraph->Add($p1);
				$piegraph->Stroke();
				
		} else if ($condicion=="organismo") {
			$rsli = new Recordset();
			$rsli->sql = "SELECT COUNT(crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`) AS total_organismo, LEFT(organismo.`organismo`,85) as organismo  
											FROM crp_recepcion_correspondencia_cgr INNER JOIN organismo ON (crp_recepcion_correspondencia_cgr.`id_organismo_cgr` = organismo.`id_organismo`)
											$where
											GROUP BY crp_recepcion_correspondencia_cgr.`id_organismo_cgr` ORDER BY total_organismo DESC limit 10";	
				$rsli->abrir();	
		
				if($rsli->total_registros > 0)
					{
						for($i = 0; $i < $rsli->total_registros; $i++)
						{
							$rsli->siguiente();	
							$data1[$i] = $rsli->fila["total_organismo"];
							$legend[$i] = html_entity_decode($rsli->fila["organismo"]);
						}
					}
				/////////////////////////////////
		/*			$data1 = "array(".$data1.")";
				$legend = "array(".$legend.")";*/
		
		
				
				$piegraph = new PieGraph(600,400);
				
				$piegraph->title->Set("Porcentaje Totalización por Dirección");
				$piegraph->title->SetFont(FF_FONT1,FS_BOLD);
				$piegraph->legend->Pos( 0.05,0.5,"left" ,"left");
				$p1 = new PiePlot3D($data1);
				$p1->SetLegends($legend);
				$p1->SetTheme("earth");
				$p1->SetAngle(30);
				$p1->SetSize(0.3);
				$p1->SetCenter(0.5,0.2);
				$piegraph->Add($p1);
				$piegraph->Stroke();
						
		} else if ($condicion=="unidad") {		
			$rsli = new Recordset();
			$rsli->sql = "SELECT COUNT(crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr`) AS total_unidad_asig, crp_asignacion_correspondencia_cgr.`id_unidad`, unidad.`unidad`
										FROM crp_asignacion_correspondencia_cgr INNER JOIN unidad ON (crp_asignacion_correspondencia_cgr.`id_unidad` = unidad.`id_unidad`)
										INNER JOIN crp_recepcion_correspondencia_cgr  ON (crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr` = crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)			
										$where
										GROUP BY crp_asignacion_correspondencia_cgr.`id_unidad` ORDER BY total_unidad_asig DESC";	
				$rsli->abrir();	
		
				if($rsli->total_registros > 0)
					{
						for($i = 0; $i < $rsli->total_registros; $i++)
						{
							$rsli->siguiente();	
							$data1[$i] = $rsli->fila["total_unidad_asig"];
							$legend[$i] = html_entity_decode($rsli->fila["unidad"]);
						}
					}
				/////////////////////////////////
		/*			$data1 = "array(".$data1.")";
				$legend = "array(".$legend.")";*/
		
		
				$piegraph = new PieGraph(600,400);
				
				$piegraph->title->Set("Porcentaje Totalización por Unidad Administrativa");
				$piegraph->title->SetFont(FF_FONT1,FS_BOLD);
				$piegraph->legend->Pos( 0.05,0.5,"left" ,"left");
				$p1 = new PiePlot3D($data1);
				$p1->SetLegends($legend);
				$p1->SetTheme("earth");
				$p1->SetAngle(30);
				$p1->SetSize(0.3);
				$p1->SetCenter(0.5,0.2);
				$piegraph->Add($p1);
				$piegraph->Stroke();		
		
		}
?>