<?
include ('../../../../librerias/phpexcel/PHPExcel.php');
require_once("../../../../librerias/Recordset.php");

$z = stripslashes($_POST["condiciones"]);
$critk = "";
//$conjunto = stripslashes($_GET["condiciones"])
$rslista = new Recordset();
if(isset($z) && $z!="")
	{
		$variable = explode("!",$z);
		for ($j=0;$j<count($variable);$j++)
			{
				$variable[$j]."<br>";
				$desgloce = explode(":",$variable[$j]);
				switch($desgloce[0])
					{
						case "campo1"://fecha
							$sub_desgloce = explode("_",$desgloce[1]);
							$where = $where." WHERE crp_recepcion_correspondencia_cgr.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";						
							$critk = "Fecha ".$sub_desgloce[0].": ".$sub_desgloce[1]." y ".$sub_desgloce[2];
						break;
						case "campo2": //que totalizar
							if($desgloce[1]=="todos"){
								$cant=4;
								$critk = $critk.", Totalizaci&oacute;n por direcci&oacute;n, unidades administrativas, estatus.";
							} else {
								$cant=1;
								$critk = $critk.", Totalizaci&oacute;n por ".$desgloce[1];
								$elname = $desgloce[1]; 
							}
						break;
					}	
			}
	}

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Ing. Adriano Frade")
							 ->setLastModifiedBy("Ing. Adriano Frade")
							 ->setTitle($rslista->decodificar("Totalizaci&oacute;n Correspondencia de la CGR"))
							 ->setSubject("SICCA")
							 ->setDescription("Totalizaci&oacute;n de Correspondencias de la CGR")
							 ->setKeywords("Reporte")
							 ->setCategory("Reporte");
// Add some data

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('SICCA');
$objDrawing->setDescription('SICCA');
$objDrawing->setPath('../../../../images/logo_reporte.jpg');
$objDrawing->setCoordinates('B3');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

	
$objPHPExcel->getActiveSheet()->mergeCells('F3:K3');	
$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('F4:K4');	
$objPHPExcel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('F6:K6');
$objPHPExcel->getActiveSheet()->getStyle('F6')->getFont()->setBold(true);			

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F3', "CONTRALORIA DEL ESTADO ARAGUA")
            ->setCellValue('F4', "DESPACHO DEL CONTRALOR")
            ->setCellValue('F6', $rslista->decodificar("Totalizaci&oacute;n de Correspondencias de la CGR"));						
// Miscellaneous glyphs, UTF-8

$objPHPExcel->getActiveSheet()->mergeCells('B9:K9');		
$objPHPExcel->getActiveSheet()->getStyle('B9')->getFont()->setSize(10);

$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('B9', $rslista->decodificar("Criterios de B&uacute;squeda: ".$critk));		

		if($cant==4)
		{
			//total
			$rslista1 = new Recordset();
			$rslista1->sql = "SELECT COUNT(crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`) AS total_co
								FROM crp_recepcion_correspondencia_cgr 
								$where
								ORDER BY total_co DESC";
			$rslista1->abrir();				
			if($rslista1->total_registros > 0)
				{	
					$objPHPExcel->getActiveSheet()->mergeCells('B11:C11');
					$objPHPExcel->getActiveSheet()->getStyle('B11:C11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('B11:C11')->getFill()->getStartColor()->setARGB('EBEBEB');					
					$objPHPExcel->getActiveSheet()->getStyle('B11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('B11')->getFont()->setBold(true);
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('B11', $rslista->decodificar("Totalizaci&oacute;n Correspondencia de la CGR a la Fecha Solicitada"));	
								
					$objPHPExcel->getActiveSheet()->mergeCells('B12:C12');
					$objPHPExcel->getActiveSheet()->getStyle('B12:C12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('B12:C12')->getFill()->getStartColor()->setARGB('ECE9D8');							
					$objPHPExcel->getActiveSheet()->getStyle('B12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('B12')->getFont()->setBold(true);
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('B12', "Total");	
				
					$rslista1->siguiente();
					$objPHPExcel->getActiveSheet()->mergeCells('B13:C13');	
					$objPHPExcel->getActiveSheet()->getStyle('B13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('B13', $rslista1->fila["total_co"]);						
				}		
			
			$rslista1->cerrar();
			unset($rslista1);				

			//organismo
			$k=16;
			$rslista1 = new Recordset();
			$rslista1->sql = "SELECT COUNT(crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`) AS total_organismo, crp_recepcion_correspondencia_cgr.`id_organismo_cgr`, 
									organismo.`organismo`  
									FROM crp_recepcion_correspondencia_cgr INNER JOIN organismo ON (crp_recepcion_correspondencia_cgr.`id_organismo_cgr` = organismo.`id_organismo`)
									$where
									GROUP BY crp_recepcion_correspondencia_cgr.`id_organismo_cgr` ORDER BY total_organismo DESC";
			$rslista1->abrir();				
			if($rslista1->total_registros > 0)
				{	
					$objPHPExcel->getActiveSheet()->mergeCells('B'.$k.':C'.$k);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':C'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':C'.$k)->getFill()->getStartColor()->setARGB('A4D1FF');	
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFont()->setBold(true);
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('B'.$k, $rslista->decodificar("Totalizaci&oacute;n por Direcci&oacute;n"));				
				
					$k = $k+1;
					$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(55);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFill()->getStartColor()->setARGB('ECE9D8');						
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFont()->setBold(true);
					
					$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFill()->getStartColor()->setARGB('ECE9D8');						
					$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFont()->setBold(true);
										
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('B'.$k, $rslista1->decodificar("Direcci&oacute;n"))
								->setCellValue('C'.$k, "Totales");				
				
					$k = $k+1;
					for ($i=1;$i<=$rslista1->total_registros;$i++)
						{						
						$rslista1->siguiente();	
						$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue('B'.$k, $rslista1->decodificar($rslista1->fila["organismo"]))
									->setCellValue('C'.$k, $rslista1->fila["total_organismo"]);						
						$k = $k+1;
						}
				}		
			
			$rslista1->cerrar();
			unset($rslista1);	
			
			
			// unidades administrativas
			
			$k=11;
			$rslista1 = new Recordset();
			$rslista1->sql = "SELECT COUNT(crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr`) AS total_unidad_asig, crp_asignacion_correspondencia_cgr.`id_unidad`, unidad.`unidad`
							  FROM crp_asignacion_correspondencia_cgr INNER JOIN unidad ON (crp_asignacion_correspondencia_cgr.`id_unidad` = unidad.`id_unidad`)
								INNER JOIN crp_recepcion_correspondencia_cgr  ON (crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr` = crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)			
							  $where
							  GROUP BY crp_asignacion_correspondencia_cgr.`id_unidad` ORDER BY total_unidad_asig DESC";
			$rslista1->abrir();				
			if($rslista1->total_registros > 0)
				{	
					$objPHPExcel->getActiveSheet()->mergeCells('G'.$k.':H'.$k);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k.':H'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k.':H'.$k)->getFill()->getStartColor()->setARGB('E1FFE1');	
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getFont()->setBold(true);
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('G'.$k, $rslista->decodificar("Totalizaci&oacute;n por Unidades Administrativas"));				
				
					$k = $k+1;
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getFill()->getStartColor()->setARGB('ECE9D8');						
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getFont()->setBold(true);
					
					$objPHPExcel->getActiveSheet()->getStyle('H'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('H'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('H'.$k)->getFill()->getStartColor()->setARGB('ECE9D8');						
					$objPHPExcel->getActiveSheet()->getStyle('H'.$k)->getFont()->setBold(true);
										
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('G'.$k, $rslista1->decodificar("Unidad"))
								->setCellValue('H'.$k, "Totales");				
				
					$k = $k+1;
					for ($i=1;$i<=$rslista1->total_registros;$i++)
						{						
						$rslista1->siguiente();	
						$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue('G'.$k, $rslista1->decodificar($rslista1->fila["unidad"]))
									->setCellValue('H'.$k, $rslista1->fila["total_unidad_asig"]);						
						$k = $k+1;
						}
				}		
			
			$rslista1->cerrar();
			unset($rslista1);	
			
			// estatus
			
			$k=$k + 3;
			$rslista1 = new Recordset();
			$rslista1->sql = "SELECT COUNT(crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr`) AS total_estatus, crp_asignacion_correspondencia_cgr.`id_estatus`, estatus.`estatus`
									FROM crp_asignacion_correspondencia_cgr INNER JOIN estatus ON (crp_asignacion_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
									INNER JOIN crp_recepcion_correspondencia_cgr  ON (crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr` = crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)
									$where
									GROUP BY crp_asignacion_correspondencia_cgr.`id_estatus`
									ORDER BY total_estatus DESC";
			$rslista1->abrir();				
			if($rslista1->total_registros > 0)
				{	
					$objPHPExcel->getActiveSheet()->mergeCells('G'.$k.':H'.$k);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k.':H'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k.':H'.$k)->getFill()->getStartColor()->setARGB('FFDDBB');	
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getFont()->setBold(true);
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('G'.$k, $rslista->decodificar("Totalizaci&oacute;n por Estatus"));				
				
					$k = $k+1;
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getFill()->getStartColor()->setARGB('ECE9D8');						
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getFont()->setBold(true);
					
					$objPHPExcel->getActiveSheet()->getStyle('H'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('H'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('H'.$k)->getFill()->getStartColor()->setARGB('ECE9D8');						
					$objPHPExcel->getActiveSheet()->getStyle('H'.$k)->getFont()->setBold(true);
										
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('G'.$k, $rslista1->decodificar("Estatus"))
								->setCellValue('H'.$k, "Totales");				
				
					$k = $k+1;
					for ($i=1;$i<=$rslista1->total_registros;$i++)
						{						
						$rslista1->siguiente();	
						$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue('G'.$k, $rslista1->decodificar($rslista1->fila["estatus"]))
									->setCellValue('H'.$k, $rslista1->fila["total_estatus"]);						
						$k = $k+1;
						}
				}		
			
			$rslista1->cerrar();
			unset($rslista1);
			
		} else if ($cant==1){
			if($elname=="estatus")
			{
				$k=11;
				$rslista1 = new Recordset();
				$rslista1->sql = "SELECT COUNT(crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr`) AS total_estatus, crp_asignacion_correspondencia_cgr.`id_estatus`, estatus.`estatus`
										FROM crp_asignacion_correspondencia_cgr INNER JOIN estatus ON (crp_asignacion_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
										INNER JOIN crp_recepcion_correspondencia_cgr  ON (crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr` = crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)
										$where
										GROUP BY crp_asignacion_correspondencia_cgr.`id_estatus`
										ORDER BY total_estatus DESC";
				$rslista1->abrir();				
				if($rslista1->total_registros > 0)
					{	
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$k.':C'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':C'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':C'.$k)->getFill()->getStartColor()->setARGB('FFDDBB');	
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue('B'.$k, $rslista->decodificar("Totalizaci&oacute;n por Estatus"));				
					
						$k = $k+1;
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFill()->getStartColor()->setARGB('ECE9D8');						
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFont()->setBold(true);
						
						$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFill()->getStartColor()->setARGB('ECE9D8');						
						$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFont()->setBold(true);
											
						$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue('B'.$k, $rslista1->decodificar("Estatus"))
									->setCellValue('C'.$k, "Totales");				
					
						$k = $k+1;
						for ($i=1;$i<=$rslista1->total_registros;$i++)
							{						
							$rslista1->siguiente();	
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('B'.$k, $rslista1->decodificar($rslista1->fila["estatus"]))
										->setCellValue('C'.$k, $rslista1->fila["total_estatus"]);						
							$k = $k+1;
							}
					}		
				
				$rslista1->cerrar();
				unset($rslista1);
				
			} else if ($elname=="organismo"){
			
				$k=11;
				$rslista1 = new Recordset();
				$rslista1->sql = "SELECT COUNT(crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`) AS total_organismo, crp_recepcion_correspondencia_cgr.`id_organismo_cgr`, 
										organismo.`organismo`  
										FROM crp_recepcion_correspondencia_cgr INNER JOIN organismo ON (crp_recepcion_correspondencia_cgr.`id_organismo_cgr` = organismo.`id_organismo`)
										$where
										GROUP BY crp_recepcion_correspondencia.`id_organismo_cgr` ORDER BY total_organismo DESC";
				$rslista1->abrir();				
				if($rslista1->total_registros > 0)
					{	
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$k.':C'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':C'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':C'.$k)->getFill()->getStartColor()->setARGB('A4D1FF');	
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue('B'.$k, $rslista->decodificar("Totalizaci&oacute;n por Direcci&oacute;n"));				
					
						$k = $k+1;
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(55);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFill()->getStartColor()->setARGB('ECE9D8');						
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFont()->setBold(true);
						
						$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFill()->getStartColor()->setARGB('ECE9D8');						
						$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFont()->setBold(true);
											
						$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue('B'.$k, $rslista1->decodificar("Direcci&oacute;n"))
									->setCellValue('C'.$k, "Totales");				
					
						$k = $k+1;
						for ($i=1;$i<=$rslista1->total_registros;$i++)
							{						
							$rslista1->siguiente();	
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('B'.$k, $rslista1->decodificar($rslista1->fila["organismo"]))
										->setCellValue('C'.$k, $rslista1->fila["total_organismo"]);						
							$k = $k+1;
							}
					}		
				
				$rslista1->cerrar();
				unset($rslista1);	
			
			
			} else if ($elname=="unidad"){
			
				$k=11;
				$rslista1 = new Recordset();
				$rslista1->sql = "SELECT COUNT(crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr`) AS total_unidad_asig, crp_asignacion_correspondencia_cgr.`id_unidad`, unidad.`unidad`
								  FROM crp_asignacion_correspondencia_cgr INNER JOIN unidad ON (crp_asignacion_correspondencia_cgr.`id_unidad` = unidad.`id_unidad`)
									INNER JOIN crp_recepcion_correspondencia_cgr  ON (crp_asignacion_correspondencia_cgr.`id_crp_asignacion_correspondencia_cgr` = crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)			
								  $where
								  GROUP BY crp_asignacion_correspondencia_cgr.`id_unidad` ORDER BY total_unidad_asig DESC";
				$rslista1->abrir();				
				if($rslista1->total_registros > 0)
					{	
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$k.':C'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':C'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':C'.$k)->getFill()->getStartColor()->setARGB('E1FFE1');	
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue('B'.$k, $rslista->decodificar("Totalizaci&oacute;n por Unidades Administrativas"));				
					
						$k = $k+1;
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFill()->getStartColor()->setARGB('ECE9D8');						
						$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFont()->setBold(true);
						
						$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFill()->getStartColor()->setARGB('ECE9D8');						
						$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFont()->setBold(true);
											
						$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue('B'.$k, $rslista1->decodificar("Unidad"))
									->setCellValue('C'.$k, "Totales");				
					
						$k = $k+1;
						for ($i=1;$i<=$rslista1->total_registros;$i++)
							{						
							$rslista1->siguiente();	
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('B'.$k, $rslista1->decodificar($rslista1->fila["unidad"]))
										->setCellValue('C'.$k, $rslista1->fila["total_unidad_asig"]);						
							$k = $k+1;
							}
					}		
				
				$rslista1->cerrar();
				unset($rslista1);	
			} 
		}
	
	
	
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Totalizacion CGR');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="totalizacion_corresp_CGR_'.date('d-m-Y').'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>
