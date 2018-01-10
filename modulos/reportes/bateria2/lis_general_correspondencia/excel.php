<?
include ('../../../../librerias/phpexcel/PHPExcel.php');
require_once("../../../../librerias/Recordset.php");

$x = stripslashes($_POST["p_orden"]);
$y = stripslashes($_POST["met"]);
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
						case "campo1": //Tipo Documento
							if($where!="")
								{
									$where = $where." AND crp_recepcion_correspondencia_cgr.id_tipo_documento=".$desgloce[1];
								} else {
									$where = $where." WHERE crp_recepcion_correspondencia_cgr.id_tipo_documento=".$desgloce[1];								
								}
								
							$rsdocu = new Recordset();
							$rsdocu->sql = "SELECT tipo_documento.tipo_documento FROM tipo_documento WHERE id_tipo_documento = ".$desgloce[1];
							$rsdocu->abrir();
								if($rsdocu->total_registros > 0)
									{
										$rsdocu->siguiente();
										$tdo = $rsdocu->fila["tipo_documento"];									
									}
							$rsdocu->cerrar();
							unset($rsdocu);
													
							if($critk=="")
								{
									$critk = "Tipo Documento : ".$tdo;
								} else {
									$critk = $critk.", Tipo Documento : ".$tdo;								
								}								
						break;
						case "campo2": //estatus
							if($where!="")
								{
									$where = $where." AND crp_asignacion_correspondencia_cgr.id_estatus=".$desgloce[1];
								} else {
									$where = $where." WHERE crp_asignacion_correspondencia_cgr.id_estatus=".$desgloce[1];								
								}
								
								$rsdocu = new Recordset();
								$rsdocu->sql = "SELECT estatus.estatus FROM estatus WHERE id_estatus = ".$desgloce[1];
								$rsdocu->abrir();
									if($rsdocu->total_registros > 0)
										{
											$rsdocu->siguiente();
											$est = $rsdocu->fila["estatus"];									
										}
								$rsdocu->cerrar();
								unset($rsdocu);															
							
							if($critk=="")
								{
									$critk = "Estatus : ".$est;
								} else {
									$critk = $critk.", Estatus : ".$est;								
								}	
								
						break;
						case "campo3"://n_documento
							$sub_desgloce = explode("_",$desgloce[1]);
							if($where!="")
								{	
									$where = $where." AND crp_recepcion_correspondencia_cgr.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
								} else {
									$where = $where." WHERE crp_recepcion_correspondencia_cgr.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
								}
								
							if($critk=="")
								{
									$critk = "Fecha ".$sub_desgloce[0].": ".$sub_desgloce[1]." y ".$sub_desgloce[2];
								} else {
									$critk = $critk.", Fecha ".$sub_desgloce[0].": ".$sub_desgloce[1]." y ".$sub_desgloce[2];								
								}								
		
						break;
						case "campo4":// organismo
							if($where!="")
								{
									$where = $where." AND crp_recepcion_correspondencia_cgr.id_organismo_cgr=".$desgloce[1];
								} else {
									$where = $where." WHERE crp_recepcion_correspondencia_cgr.id_organismo_cgr=".$desgloce[1];								
								}	
								
								$rsdocu = new Recordset();
								$rsdocu->sql = "SELECT organismo.organismo FROM organismo WHERE id_organismo = ".$desgloce[1];
								$rsdocu->abrir();
									if($rsdocu->total_registros > 0)
										{
											$rsdocu->siguiente();
											$org = $rsdocu->fila["organismo"];									
										}
								$rsdocu->cerrar();
								unset($rsdocu);	
															
							if($critk=="")
								{
									$critk = "Organ&iacute;smo : ".$org;
								} else {
									$critk = $critk.", Organ&iacute;smo : ".$org;								
								}								
						break;
						case "campo5"://organismo
							$condicionUnidad = $desgloce[1];
							$cc = str_pad($desgloce[1], 2, "0", STR_PAD_LEFT);						
							if($where!="")
								{
									$where = $where." AND crp_asignacion_correspondencia_cgr.id_unidad = ".$desgloce[1]; 
								} else {
									$where = $where." WHERE crp_asignacion_correspondencia_cgr.id_unidad = ".$desgloce[1]; 							
								}	
							
								$rsdocu = new Recordset();
								$rsdocu->sql = "SELECT unidad.unidad FROM unidad WHERE id_unidad = ".$desgloce[1];
								$rsdocu->abrir();
									if($rsdocu->total_registros > 0)
										{
											$rsdocu->siguiente();
											$und = $rsdocu->fila["unidad"];									
										}
								$rsdocu->cerrar();
								unset($rsdocu);	
															
							if($critk=="")
								{
									$critk = "Unidad : ".$und;
								} else {
									$critk = $critk.", Unidad : ".$und;								
								}								
						break;
					}	
			}
	}
if(isset($x))
	{
		if($condi!=""){
			$condi = $condi."&p_orden=".$_GET["p_orden"];
		} else {
			$condi = "&p_orden=".$_GET["p_orden"]."&met=".$_GET["met"];		
		}
		switch($x){
			case "columna1": //Tipo Documento
				$ondicionW = " ORDER BY tipo_documento.tipo_documento $y";
			break;
			case "columna2": //N&deg; Documento
				$ondicionW = "ORDER BY organismo $y";
			break;
			case "columna3"://Organ&iacute;smo / Remitente
				$ondicionW = "ORDER BY crp_recepcion_correspondencia_cgr.fecha_registro $y";		
			break;
			case "columna4"://Fecha Registro
				$ondicionW = "ORDER BY crp_recepcion_correspondencia_cgr.fecha_documento $y";	
			break;
			case "columna5"://Fecha Documento
				$ondicionW = "ORDER BY Estatus $y";
			break;
			case "columna6"://Tipo Correspondencia
				$ondicionW = "ORDER BY unidad $y";	
			break;
			case "columna7"://Estatus
				$ondicionW = "ORDER BY n_correlativo $y";	
			break;
			case "columna8"://Unidad Asignada
				$ondicionW = "ORDER BY oficioCircular $y";	
			break;
			default:
				$ondicionW = "ORDER BY fecha_registro $y";
			break;
		}	
	}

	$rslista->sql = "SELECT crp_recepcion_correspondencia_cgr.`n_correlativo`, tipo_documento.`tipo_documento`, 
							IF(crp_recepcion_correspondencia_cgr.n_oficio_circular='','--',crp_recepcion_correspondencia_cgr.n_oficio_circular) AS oficioCircular,
							organismo.`organismo`,
							DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_registro,'%d/%m/%Y %r') AS f_registro, 
							DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_documento,'%d/%m/%Y') AS f_documento, 
							unidad.`unidad`, estatus.`estatus`, crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`, 
							crp_recepcion_correspondencia_cgr.id_tipo_documento, crp_recepcion_correspondencia_cgr.fecha_registro,
							crp_recepcion_correspondencia_cgr.fecha_documento, crp_recepcion_correspondencia_cgr.id_organismo_cgr   
						FROM crp_recepcion_correspondencia_cgr 
							INNER JOIN tipo_documento ON (crp_recepcion_correspondencia_cgr.`id_tipo_documento` = tipo_documento.`id_tipo_documento`)
							INNER JOIN organismo ON (crp_recepcion_correspondencia_cgr.`id_organismo_cgr` = organismo.`id_organismo`)
							INNER JOIN crp_asignacion_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.`id_recepcion_correspondencia_cgr` = crp_asignacion_correspondencia_cgr.`id_recepcion_correspondencia_cgr`)
							INNER JOIN unidad ON (crp_asignacion_correspondencia_cgr.`id_unidad` = unidad.`id_unidad`)		
							INNER JOIN estatus ON (crp_asignacion_correspondencia_cgr.`id_estatus` = estatus.`id_estatus`)
					  $where
					  $ondicionW";
	$rslista->abrir();


$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Ing. Adriano Frade")
							 ->setLastModifiedBy("Ing. Adriano Frade")
							 ->setTitle($rslista->decodificar("Listado General Correspondencia CGR"))
							 ->setSubject("SICCA")
							 ->setDescription("Listado General de Correspondencia de la CGR")
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

	
$objPHPExcel->getActiveSheet()->mergeCells('F3:I3');	
$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('F4:I4');	
$objPHPExcel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('F6:I6');
$objPHPExcel->getActiveSheet()->getStyle('F6')->getFont()->setBold(true);			

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F3', "CONTRALORIA DEL ESTADO ARAGUA")
            ->setCellValue('F4', "DESPACHO DEL CONTRALOR")
            ->setCellValue('F6', $rslista->decodificar("Listado General de Correspondencia de la CGR"));						
// Miscellaneous glyphs, UTF-8

$objPHPExcel->getActiveSheet()->mergeCells('B9:I9');		
$objPHPExcel->getActiveSheet()->getStyle('B9')->getFont()->setSize(10);

$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('B9', $rslista->decodificar("Criterios de B&uacute;squeda: ".$critk));		

if($rslista->total_registros != 0)
	{	

		$objPHPExcel->getActiveSheet()->getStyle('B11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('F11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('H11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('I11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						

		$objPHPExcel->getActiveSheet()->getStyle('B11')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C11')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D11')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E11')->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle('F11')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('G11')->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle('H11')->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle('I11')->getFont()->setBold(true);
		
		$k=11;
		
		$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':K'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':K'.$k)->getFill()->getStartColor()->setARGB('CFCFA0');						
																																
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('B'.$k, $rslista->decodificar("Correlativo"))
					->setCellValue('C'.$k, $rslista->decodificar("Tipo Documento"))			
					->setCellValue('D'.$k, $rslista->decodificar("N&deg; Oficio/Circular"))	
					->setCellValue('E'.$k, $rslista->decodificar("Direcci&oacute;n Remitente"))
					->setCellValue('F'.$k, $rslista->decodificar("Fecha / Hora Registro"))	
					->setCellValue('G'.$k, $rslista->decodificar("Fecha Documento"))	
					->setCellValue('H'.$k, $rslista->decodificar("Unidad Administrativa"))
					->setCellValue('I'.$k, $rslista->decodificar("Estatus"));	
		$k=12;
			for($i=1;$i<=$rslista->total_registros;$i++)
				{
					$rslista->siguiente();	
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('H'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('I'.$k)->getFont()->setSize(10);

					$objPHPExcel->setActiveSheetIndex(0) 
								->setCellValue('B'.$k, $rslista->fila["n_correlativo"])
								->setCellValue('C'.$k, $rslista->decodificar($rslista->fila["tipo_documento"]))			
								->setCellValue('D'.$k, $rslista->fila["oficioCircular"])	
								->setCellValue('E'.$k, $rslista->decodificar(ucwords(mb_strtolower($rslista->fila["organismo"]))))
								->setCellValue('F'.$k, $rslista->fila["f_registro"])	
								->setCellValue('G'.$k, $rslista->fila["f_documento"])	
								->setCellValue('H'.$k, $rslista->decodificar($rslista->fila["unidad"]))
								->setCellValue('I'.$k, $rslista->decodificar($rslista->fila["estatus"]));	
				
				$k=$k+1;
				}

	} else {
			
			$objPHPExcel->getActiveSheet()->mergeCells('B12:I12');		
			$objPHPExcel->getActiveSheet()->getStyle('B12')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B12')->getFont()->setSize(13);			
			
			$objPHPExcel->setActiveSheetIndex(0) 
						->setCellValue('B12', $rslista->decodificar("No Ex&iacute;sten Datos a Mostrar!!" ));		
	}
	
$rslista->cerrar();
unset($rslista);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('General Correspondencia CGR');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle('F6')->getFont()->setSize(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(23);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="listado_general_correspondencia_CGR_'.date('d-m-Y').'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>
