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
									$where = $where." AND crp_recepcion_correspondencia.id_tipo_documento=".$desgloce[1];
								} else {
									$where = $where." WHERE crp_recepcion_correspondencia.id_tipo_documento=".$desgloce[1];								
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
									$where = $where." AND crp_asignacion_correspondencia.id_estatus=".$desgloce[1];
								} else {
									$where = $where." WHERE crp_asignacion_correspondencia.id_estatus=".$desgloce[1];								
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
									$where = $where." AND crp_recepcion_correspondencia.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
								} else {
									$where = $where." WHERE crp_recepcion_correspondencia.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
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
									$where = $where." AND crp_recepcion_correspondencia.id_organismo=".$desgloce[1];
								} else {
									$where = $where." WHERE crp_recepcion_correspondencia.id_organismo=".$desgloce[1];								
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
									$where = $where." AND (crp_asignacion_correspondencia.id_unidad = ".$desgloce[1]." OR crp_asignacion_correspondencia.copia_unidades like '%$cc%') "; 
								} else {
									$where = $where." WHERE (crp_asignacion_correspondencia.id_unidad = ".$desgloce[1]." OR crp_asignacion_correspondencia.copia_unidades like '%$cc%') "; 							
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
				$ondicionW = "ORDER BY crp_recepcion_correspondencia.fecha_registro $y";		
			break;
			case "columna4"://Fecha Registro
				$ondicionW = "ORDER BY crp_recepcion_correspondencia.fecha_documento $y";	
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
				$ondicionW = "ORDER BY prioridad $y";	
			break;
			default:
				$ondicionW = "ORDER BY fecha_registro $y";
			break;
		}	
	}

	$rslista->sql = "SELECT 
					  crp_recepcion_correspondencia.id_recepcion_correspondencia,  
					  tipo_documento.tipo_documento,
					  IF(crp_recepcion_correspondencia.n_documento='','--',crp_recepcion_correspondencia.n_documento) AS n_documento,
					  IF(
						crp_recepcion_correspondencia.id_organismo <> '',
						organismo.organismo,
						crp_recepcion_correspondencia.remitente
					  ) AS organismo, crp_asignacion_correspondencia.id_unidad, 
					  DATE_FORMAT(crp_recepcion_correspondencia.fecha_registro,'%d/%m/%Y %r') AS registro,
					  DATE_FORMAT(crp_recepcion_correspondencia.fecha_documento,'%d/%m/%Y') AS fdocumento,
					  crp_recepcion_correspondencia.fecha_registro,
					  crp_recepcion_correspondencia.fecha_documento,					  
					  IF(crp_recepcion_correspondencia.tipo_correspondencia=0,'Institucional','Personal') AS tipo,
					  IF(unidad.unidad <>'',unidad.unidad,'--') AS unidad, crp_recepcion_correspondencia.n_correlativo, estatus.estatus,crp_asignacion_correspondencia.id_estatus, crp_asignacion_correspondencia.id_prioridad,
					  IF(crp_asignacion_correspondencia.id_prioridad=1, CONCAT('<u>',prioridad.prioridad,'</u> Plazo:',crp_asignacion_correspondencia.plazo,' d&iacute;as'), prioridad.prioridad) AS prioridad, 
					  crp_asignacion_correspondencia.copia_unidades,  
					  IF(DATEDIFF(crp_asignacion_correspondencia.fecha_vencimiento,CURRENT_DATE()) >= 0,'Vigente', IF(crp_asignacion_correspondencia.fecha_vencimiento IS NOT NULL,'Vencida','')) AS estado,
					  DATEDIFF(crp_asignacion_correspondencia.fecha_vencimiento,CURRENT_DATE()) as plazo_trans, DATE_FORMAT(crp_asignacion_correspondencia.fecha_asignacion,'%d/%m/%Y %r') AS asignacion, DATE_FORMAT(crp_asignacion_correspondencia.fecha_vencimiento,'%d/%m/%Y') AS vencimiento, 
					  crp_asignacion_correspondencia.copia_unidades, crp_asignacion_correspondencia.externo, crp_asignacion_correspondencia.habilitado,
					  CONCAT(crp_asignacion_correspondencia.accion,' y ',IF(crp_asignacion_correspondencia.externo = 0,'No Requiere Oficio','Si Requiere Oficio')) AS accion
					  FROM crp_recepcion_correspondencia INNER JOIN
						  tipo_documento ON (crp_recepcion_correspondencia.id_tipo_documento = tipo_documento.id_tipo_documento)
						  LEFT JOIN organismo ON (crp_recepcion_correspondencia.id_organismo = organismo.id_organismo) 
						  LEFT JOIN crp_asignacion_correspondencia ON (crp_recepcion_correspondencia.id_recepcion_correspondencia = crp_asignacion_correspondencia.id_recepcion_correspondencia)
						  LEFT JOIN unidad ON (crp_asignacion_correspondencia.id_unidad = unidad.id_unidad) INNER JOIN estatus ON (crp_asignacion_correspondencia.id_estatus = estatus.id_estatus)
						  LEFT JOIN prioridad ON (crp_asignacion_correspondencia.id_prioridad = prioridad.id_prioridad) 						  
					  $where
					  $ondicionW";
	$rslista->abrir();


$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Ing. Adriano Frade")
							 ->setLastModifiedBy("Ing. Adriano Frade")
							 ->setTitle($rslista->decodificar("Listado General Correspondencia"))
							 ->setSubject("SICCA")
							 ->setDescription("Listado General de Correspondencia")
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
            ->setCellValue('F6', $rslista->decodificar("Listado General de Correspondencia"));						
// Miscellaneous glyphs, UTF-8

$objPHPExcel->getActiveSheet()->mergeCells('B9:K9');		
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
		$objPHPExcel->getActiveSheet()->getStyle('J11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('K11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						

		$objPHPExcel->getActiveSheet()->getStyle('B11')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C11')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D11')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E11')->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle('F11')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('G11')->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle('H11')->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle('I11')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('J11')->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle('K11')->getFont()->setBold(true);
		
		$k=11;
		
		$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':K'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':K'.$k)->getFill()->getStartColor()->setARGB('CFCFA0');						
																																
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('B'.$k, $rslista->decodificar("Correlativo"))
					->setCellValue('C'.$k, $rslista->decodificar("Tipo Documento"))			
					->setCellValue('D'.$k, $rslista->decodificar("N&deg; Documento"))	
					->setCellValue('E'.$k, $rslista->decodificar("Organ&iacute;smo / Remitente"))
					->setCellValue('F'.$k, $rslista->decodificar("Fecha / Hora Registro"))	
					->setCellValue('G'.$k, $rslista->decodificar("Fecha Documento"))	
					->setCellValue('H'.$k, $rslista->decodificar("Unidad Administrativa"))
					->setCellValue('I'.$k, $rslista->decodificar("Estatus"))	
					->setCellValue('J'.$k, $rslista->decodificar("Prioridad"))									
					->setCellValue('K'.$k, $rslista->decodificar("Acci&oacute;n"));		
		$k=12;
			for($i=1;$i<=$rslista->total_registros;$i++)
				{
					$rslista->siguiente();
					//***********************
						if ($rslista->fila["unidad"]=="--" && ($rslista->fila["id_estatus"]==5 || $rslista->fila["id_estatus"]==6) ){
							/*if(is_null($rslista->fila["copia_unidades"])==true)
							{*/
								$Var = explode("-",$rslista->fila["copia_unidades"]); 
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
								$unidad_recep ="";
								for($a=0;$a<$rsdocu->total_registros;$a++){
									$rsdocu->siguiente();
									$rsdocu->fila["unidad"]."<br>";
									if($unidad_recep == ""){
										$unidad_recep = $rsdocu->fila["unidad"];
									} else {
										$unidad_recep = $unidad_recep." - ".$rsdocu->fila["unidad"];
									}
									
								}
								$rsdocu->cerrar();
								unset($rsdocu);
								$Var = "";	
								$SqL = "";
		/*					} else {
								
								echo "hola";
							}*/
						} else {
							//echo $rslista->fila["unidad"]; 	
							$unidad_recep = $rslista->fila["unidad"];			
						}					
					//***********************	
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('H'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('I'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->getFont()->setSize(10);																											
					$objPHPExcel->getActiveSheet()->getStyle('K'.$k)->getFont()->setSize(10);

					$objPHPExcel->setActiveSheetIndex(0) 
								->setCellValue('B'.$k, $rslista->fila["n_correlativo"])
								->setCellValue('C'.$k, $rslista->fila["tipo_documento"])			
								->setCellValue('D'.$k, $rslista->fila["n_documento"])	
								->setCellValue('E'.$k, $rslista->decodificar(ucwords(mb_strtolower($rslista->fila["organismo"]))))
								->setCellValue('F'.$k, $rslista->fila["registro"])	
								->setCellValue('G'.$k, $rslista->fila["fdocumento"])	
								->setCellValue('H'.$k, $rslista->decodificar($unidad_recep))
								->setCellValue('I'.$k, $rslista->decodificar($rslista->fila["estatus"]))	
								->setCellValue('J'.$k, $rslista->fila["prioridad"])									
								->setCellValue('K'.$k, $rslista->fila["accion"]);	
				
				$k=$k+1;
				}

	} else {
			
			$objPHPExcel->getActiveSheet()->mergeCells('B12:K12');		
			$objPHPExcel->getActiveSheet()->getStyle('B12')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B12')->getFont()->setSize(13);			
			
			$objPHPExcel->setActiveSheetIndex(0) 
						->setCellValue('B12', $rslista->decodificar("No Ex&iacute;sten Datos a Mostrar!!" ));		
	}
	
$rslista->cerrar();
unset($rslista);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('General Correspondencia');
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
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);

$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="listado_general_correspondencia_'.date('d-m-Y').'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>
