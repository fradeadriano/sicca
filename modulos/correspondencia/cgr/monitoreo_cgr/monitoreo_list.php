<?
if(!stristr($_SERVER['SCRIPT_NAME'],"monitoreo_list.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
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
$pagina = intval($_GET["pagina"]);
if($pagina == 0)
	$pagina = 1;
require_once("../../../../librerias/Recordset.php");
require_once("bil.php");
$x = stripslashes($_GET["p_orden"]);
$y = stripslashes($_GET["met"]);
$z = stripslashes($_GET["condiciones"]);
$rslista = new Recordset();
if(isset($z) && $z!="")
	{
		$condi = "&met=".$_GET["met"]."&condiciones=".$_GET["condiciones"];
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
//									$where = $where." WHERE crp_recepcion_correspondencia_cgr.id_tipo_documento=".$desgloce[1];								
									$where = $where." AND crp_recepcion_correspondencia_cgr.id_tipo_documento=".$desgloce[1];								
								}
						break;
						case "campo2": //estatus
							if($where!="")
								{
									$where = $where." AND crp_asignacion_correspondencia_cgr.id_estatus=".$desgloce[1];
								} else {
//									$where = $where." WHERE crp_asignacion_correspondencia_cgr.id_estatus=".$desgloce[1];								
									$where = $where." AND crp_asignacion_correspondencia_cgr.id_estatus=".$desgloce[1];								
								}
						break;
						case "campo3"://n_documento
							if($where!="")
								{
									$where = $where." AND crp_recepcion_correspondencia_cgr.n_oficio_circular='".$desgloce[1]."'";
								} else {
//									$where = $where." WHERE crp_recepcion_correspondencia_cgr.n_oficio_circular='".$desgloce[1]."'";								
									$where = $where." AND crp_recepcion_correspondencia_cgr.n_oficio_circular='".$desgloce[1]."'";																	
								}		
						break;
						case "campo4"://Fecha Registro Y DOCUMENTACION
							$sub_desgloce = explode("_",$desgloce[1]);
							if($where!="")
								{	
									$where = $where." AND crp_recepcion_correspondencia_cgr.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
								} else {
//									$where = $where." WHERE crp_recepcion_correspondencia_cgr.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
									$where = $where." AND crp_recepcion_correspondencia_cgr.fecha_".$sub_desgloce[0]." BETWEEN '".$rslista->formatofecha($sub_desgloce[1])."' AND '".$rslista->formatofecha($sub_desgloce[2])."'";
								}	
						break;
						case "campo5"://organismo
							if($where!="")
								{
									$where = $where." AND crp_recepcion_correspondencia_cgr.id_organismo_cgr=".$desgloce[1];
								} else {
//									$where = $where." WHERE crp_recepcion_correspondencia_cgr.id_organismo_cgr=".$desgloce[1];								
									$where = $where." AND crp_recepcion_correspondencia_cgr.id_organismo_cgr=".$desgloce[1];								
								}	
						break;
						case "campo6"://ncorrelativo
							if($where!="")
								{
									$where = $where." AND crp_recepcion_correspondencia_cgr.n_correlativo='".$desgloce[1]."-CGR'";
								} else {
//									$where = $where." WHERE crp_recepcion_correspondencia_cgr.n_correlativo='".$desgloce[1]."-CGR'";								
									$where = $where." AND crp_recepcion_correspondencia_cgr.n_correlativo='".$desgloce[1]."-CGR'";																	
								}	
						break;
						case "campo7"://unidad
							$condicionUnidad = $desgloce[1];
							$cc = str_pad($desgloce[1], 2, "0", STR_PAD_LEFT);						
							if($where!="")
								{
									$where = $where." AND (crp_asignacion_correspondencia_cgr.id_unidad = ".$desgloce[1].") "; 
								} else {
//									$where = $where." WHERE (crp_asignacion_correspondencia_cgr.id_unidad = ".$desgloce[1].") "; 							
									$where = $where." AND (crp_asignacion_correspondencia_cgr.id_unidad = ".$desgloce[1].") "; 																
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
				$ondicionW = "ORDER BY n_oficio_circular $y";	
			break;
			case "columna3"://Organ&iacute;smo / Remitente
				$ondicionW = "ORDER BY organismo $y";		
			break;
			case "columna4"://Fecha Registro
				$ondicionW = "ORDER BY crp_recepcion_correspondencia_cgr.fecha_registro $y";	
			break;
			case "columna5"://Fecha Documento
				$ondicionW = "ORDER BY crp_recepcion_correspondencia_cgr.fecha_documento $y";	
			break;
			case "columna6"://Tipo Correspondencia
				$ondicionW = "ORDER BY tipo $y";	
			break;
			case "columna7"://Estatus
				$ondicionW = "ORDER BY Estatus $y";	
			break;
			case "columna8"://Unidad Asignada
				$ondicionW = "ORDER BY unidad $y";	
			break;
			case "columna9": // N&deg; Correlativo
				$ondicionW = "ORDER BY n_correlativo $y";	
			break;
			case "columna10": // N&deg; Correlativo
				$ondicionW = "ORDER BY prioridad $y";	
			break;			
			default:
				$ondicionW = "ORDER BY fecha_registro $y";
			break;
		}	
	}
	
/*if(isset($_GET["pa2"]) && $_GET["pa2"]=="codigo_naladisa")
	$cond = "WHERE productos.cod_arancelario_naladisa LIKE '".$_GET["pa1"]."%'";
if(isset($_GET["pa2"]) && $_GET["pa2"]=="denominacion")
	$cond = "WHERE productos.denominacion_comercial LIKE '".$_GET["pa1"]."%'";
*/
	
	$rslista->sql = "SELECT crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr, crp_recepcion_correspondencia_cgr.n_correlativo, tipo_documento.tipo_documento, 
							crp_recepcion_correspondencia_cgr.n_oficio_circular, organismo.organismo, 
							crp_recepcion_correspondencia_cgr.fecha_registro,
							DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_registro,'%d/%m/%Y %r') AS f_registro,
							DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_documento,'%d/%m/%Y') AS f_oficio,
							DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_vencimiento,'%d/%m/%Y') AS f_vencimiento,
							crp_recepcion_correspondencia_cgr.fecha_documento, 
							estatus.estatus, unidad.unidad, crp_recepcion_correspondencia_cgr.plazo,
							crp_recepcion_correspondencia_cgr.id_tipo_documento, crp_asignacion_correspondencia_cgr.id_estatus, crp_asignacion_correspondencia_cgr.habilitado, crp_recepcion_correspondencia_cgr.observacion	
							FROM crp_recepcion_correspondencia_cgr 
							INNER JOIN crp_asignacion_correspondencia_cgr ON (crp_recepcion_correspondencia_cgr.id_recepcion_correspondencia_cgr = crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr)
							INNER JOIN tipo_documento ON (crp_recepcion_correspondencia_cgr.id_tipo_documento = tipo_documento.id_tipo_documento)
							INNER JOIN organismo ON (crp_recepcion_correspondencia_cgr.id_organismo_cgr = organismo.id_organismo)
							INNER JOIN estatus ON (crp_asignacion_correspondencia_cgr.id_estatus = estatus.id_estatus) 	
							INNER JOIN unidad ON (crp_asignacion_correspondencia_cgr.id_unidad = unidad.id_unidad)												  
					  WHERE DATE_FORMAT(crp_recepcion_correspondencia_cgr.fecha_registro,'%Y') >= 2016  $where
					  $ondicionW";
	$rslista->paginar($pagina,10);

?>

<table border="0" class="b_table1" align="center" width="100%" cellpadding="1" cellspacing="1">	
	<tr height="30" valign="middle" class="trcabecera_list1">
		<td width="20"></td>
		<td width="50">
			Correlativo
		</td>
		<td width="75">
			Tipo Documento
		</td>
		<td width="70">
			N&deg; Oficio/Circular
		</td>
		<td width="180">
			Direci&oacute;n Remitente
		</td>
		<td width="90">
			Fecha / Hora Registro
		</td>
		<td width="80">
			Fecha Oficio/Circular
		</td>
		<td>
			Unidad Administrativa
		</td>
		<td width="70">
			Estatus
		</td>		
		<td width="60">
			Acci&oacute;n
		</td>
	</tr>
	<tr><td colspan="11"></td></tr>
<?
	if($rslista->total_registros > 0)
		{	
			for ($i=1;$i<=$rslista->total_registros;$i++)
			{
				$rslista->siguiente();
				//echo $i."<br>";
?>				
	<tr <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
		<td align="center">
			<img src="images/mas.png" id="img_mas<? echo $rslista->fila["id_recepcion_correspondencia_cgr"]; ?>" style="cursor:pointer" title="Detallar m&aacute;s" onclick="mostrar_detalles('mDeta_<? echo $rslista->fila["id_recepcion_correspondencia_cgr"]; ?>',this.id);" />
		</td>
		<td>
			<? echo $rslista->fila["n_correlativo"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["tipo_documento"]; ?>
			
		</td>
		<td>
			<? echo $rslista->fila["n_oficio_circular"]; ?>
		</td>
		<td>
			<? echo ucwords(mb_strtolower($rslista->fila["organismo"])); ?>
		</td>
		<td>
			<? echo $rslista->fila["f_registro"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["f_oficio"]; ?>
		</td>
		<td>
			<? 
				echo $rslista->fila["unidad"]; 	
				$unidad_recep = $rslista->fila["unidad"];				
			?>
		</td>
		<td>
			<? echo $rslista->fila["estatus"]; ?>
		</td>
		<td>
<?			
		$casos = $rslista->fila["id_estatus"];
		$tipos = $rslista->fila["id_tipo_documento"];
		//echo $tipos;
		$imagen = "";
		switch ($tipos) 
		{		
			case 7: // invitacion
				$imagen = '<img title="Clic para Visualizar Correspondencia" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'450\');" />';								
			break;
			case 8: // notificacion
				switch($casos)
				{				
					case 7: //recibido
						$aqw = new Recordset();
						$aqw->sql = 'SELECT id_recepcion_cgr_detalle FROM crp_recepcion_cgr_detalle WHERE id_recepcion_correspondencia_cgr = '.$rslista->fila["id_recepcion_correspondencia_cgr"];
						$aqw->abrir();
						if($aqw->total_registros == 1)
							{						
								$imagen = '<img title="Clic para Enviar Notificaci&oacute;n" src="images/enviado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/not_enviar.php?ac=env&id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'630\');" />';															
							} else {
								$imagen = '<img title="Clic para Enviar Notificaci&oacute;n" src="images/enviado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/not_enviar_deta.php?ac=env&id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'550\');" />';															
							}										
					break;						
					case 5: //enviado
						$aqw = new Recordset();
						$aqw->sql = 'SELECT id_recepcion_cgr_detalle FROM crp_recepcion_cgr_detalle WHERE id_recepcion_correspondencia_cgr = '.$rslista->fila["id_recepcion_correspondencia_cgr"];
						$aqw->abrir();
						if($aqw->total_registros == 1)
							{						
								$imagen = '<img title="Clic para Registrar Entrega Notificaci&oacute;n" src="images/recepcion.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/not_enviar.php?ac=ent&id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'630\');" />';															
							} else {
								$imagen = '<img title="Clic para Registrar Entrega Notificaci&oacute;n" src="images/recepcion.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/not_enviar_deta.php?ac=ent&id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'600\');" />';															
							}						
						
						//$imagen = '<img title="Clic para Registrar Entrega Notificaci&oacute;n" src="images/recepcion.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/not_enviar.php?ac=ent&id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'550\');" />';													
					break;	
					case 6: //entregado
						$imagen = '<img title="Clic para Visualizar Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver_noti.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'550\');" />';								
					break;					
				}
			break;	
			case 9: // solicitud
				switch($casos)
				{
					case 1: //asignado
						$imagen ='<img title="Clic para Visualizar Correspondencia Asignada" src="images/asignada.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'450\');" />';
					break;
					
					case 2: //en proceso
						if ($rslista->fila["habilitado"]==0)
						{
							$imagen ='<img title="Clic para Visualizar Correspondencia" src="images/consultar.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'450\');" />';
						} else if ($rslista->fila["habilitado"]==1){
							$imagen = '<img title="Clic para Recibir Correspondencia" src="images/habilitado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/recibir.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'450\');" />';						
						}
					break;	
					
					case 4: //aprobado
						$imagen = '<img title="Clic para Visualizar Correspondencia Aprobada" src="images/aprobado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'450\');" />';						
					break;	
					
					case 5: //enviado
						$imagen = '<img title="Clic para Visualizar Correspondencia Enviada" src="images/enviado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'550\');" />';								
					break;
					
					case 6: //entregado
						$imagen = '<img title="Clic para Visualizar Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'550\');" />';								
					break;																
				}
			break;
			case 10: //respuesta oficio
				$imagen = '<img title="Clic para Visualizar Correspondencia" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'450\');" />';								
			break;
			case 13: // correo electronico
				switch($casos)
				{
					case 1: //asignado
						$imagen ='<img title="Clic para Visualizar Correspondencia Asignada" src="images/asignada.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'450\');" />';
					break;
					
					case 2: //en proceso
						if ($rslista->fila["habilitado"]==0)
						{
							$imagen ='<img title="Clic para Visualizar Correspondencia" src="images/consultar.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'450\');" />';
						} else if ($rslista->fila["habilitado"]==1){
							$imagen = '<img title="Clic para Recibir Correspondencia" src="images/habilitado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/recibir.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'450\');" />';						
						}
					break;	
					
					case 4: //aprobado
						$imagen = '<img title="Clic para Visualizar Correspondencia Aprobada" src="images/aprobado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'450\');" />';						
					break;	
					
					case 5: //enviado
						$imagen = '<img title="Clic para Visualizar Correspondencia Enviada" src="images/enviado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'550\');" />';								
					break;
					
					case 6: //entregado
						$imagen = '<img title="Clic para Visualizar Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'550\');" />';								
					break;																
				}
			break;
			case 14: // comunicfado
				$imagen = '<img title="Clic para Visualizar Correspondencia" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/cgr/monitoreo_cgr/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia_cgr"].'\',\'790\',\'450\');" />';								
			break;											
		}		
/*		switch ($casos) 
		{		
			case 1:
				$imagen = '<img title="Clic para Editar Asignaci&oacute;n" src="images/editar.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo/editar_asignacion.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'650\');" />
						   &nbsp;<img title="Clic para Transferir" src="images/transferir.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo/transferir.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'490\');" />
				';
			break;
			case 2:
				$imagen = '<img title="Clic para Editar Asignaci&oacute;n" src="images/editar.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo/editar_asignacion.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'650\');" />
						   &nbsp;<img title="Clic para Transferir" src="images/transferir.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo/transferir.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'490\');" />
				';			
			break;
			case 3:
				$imagen = '<img title="Clic para Recibir Correspondencia Revisada" src="images/revision.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo/aprobar.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'550\');" />';								
			break; 
			case 4:
				$imagen = '<img title="Clic para Visualizar Correspondencia Aprobada" src="images/aprobado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo/ver.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'450\');" />';								
			break; 
			case 5:
				$imagen = '<img title="Clic para Visualizar Correspondencia Enviada" src="images/enviado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo/enviado.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'600\');" />';								
			break; 
			case 6:
				$bus1 = new Recordset();
				$bus1->sql = "SELECT crp_correspondencia_externa.id_correspondencia_externa
								FROM crp_correspondencia_externa LEFT JOIN mensajero ON (crp_correspondencia_externa.id_mensajero = mensajero.id_mensajero) 
								WHERE crp_correspondencia_externa.id_recepcion_correspondencia = '".$rslista->fila["id_recepcion_correspondencia"]."'";
				$bus1->abrir();
				if($bus1->total_registros == 0)
				{
					if($rslista->fila["copia_unidades"]!="")
					{
						$imagen = '<img title="Clic para Visualizar Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo/entregado_copia.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'500\');" />';								
					} else {
						$imagen = '<img title="Clic para Visualizar Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo/entregado_copia.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'500\');" />';													
					}
				} else {
					$imagen = '<img title="Clic para Visualizar Correspondencia Entregada" src="images/entregado.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo/entregado.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'550\');" />';												
				}				
			break; 			
			case 7:
				$imagen = '<img title="Clic para asignar la Unidad Administrativa Responsable" src="images/asignada.png" style="cursor:pointer" onclick="window.top.displayMessage(\'modulos/correspondencia/monitoreo/asignacion.php?id_recepcion='.$rslista->fila["id_recepcion_correspondencia"].'\',\'790\',\'650\');" />';					
			break;			
		}
*/		echo $imagen; 
?>&nbsp;|&nbsp;<img src="images/contenido.png" style="cursor:help" title="<? echo $rslista->fila["observacion"]; ?>" />
		</td>																						
	</tr>
	<tr bgcolor="#F8F8F8" id="mDeta_<? echo $rslista->fila["id_recepcion_correspondencia_cgr"]; ?>" style="display:none" height="100">
		<td align="center">
			&nbsp;&nbsp;<img src="images/menos.png" style="cursor:pointer" title="Ocultar Detalle" onclick="ocultar_detalles('mDeta_<? echo $rslista->fila["id_recepcion_correspondencia_cgr"]; ?>');"/>		
		</td>
		<td colspan="10" align="left">
			<table border="0">
<?
			$id = $rslista->fila["id_recepcion_correspondencia_cgr"];			
			$bsq = new Recordset();
			$bsq->sql = 'SELECT IF(crp_ruta_correspondencia_cgr.id_estatus = 7, "<b>Ofic. Correspondencia - Despacho Contralor</b>", 
									IF(crp_ruta_correspondencia_cgr.id_estatus = 1, CONCAT("<b>Asignado a:</b> ", (SELECT unidad.unidad FROM crp_asignacion_correspondencia_cgr INNER JOIN unidad ON (crp_asignacion_correspondencia_cgr.id_unidad = unidad.id_unidad) WHERE crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '.$id.')), 
									IF(crp_ruta_correspondencia_cgr.id_estatus = 2, CONCAT("<b>Ya Recibido Por:</b> ", (SELECT unidad.unidad FROM crp_asignacion_correspondencia_cgr  INNER JOIN unidad  ON (crp_asignacion_correspondencia_cgr.id_unidad = unidad.id_unidad) WHERE crp_asignacion_correspondencia_cgr.id_recepcion_correspondencia_cgr = '.$id.')), 
									 IF(crp_ruta_correspondencia_cgr.id_estatus = 4, "<b>Se encuentra en Despacho del Contralor</b>", 
									 IF(crp_ruta_correspondencia_cgr.id_estatus = 5, "<b>Enviado</b> ", 
									 IF(crp_ruta_correspondencia_cgr.id_estatus = 6, "<b>Entregado</b> ", "--")))))) AS ruta, DATE_FORMAT(crp_ruta_correspondencia_cgr.fecha_recepcion, "%d/%m/%Y %r") AS faccion, crp_ruta_correspondencia_cgr.id_estatus
								FROM crp_ruta_correspondencia_cgr 
								WHERE crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr ='.$id;
			$bsq->abrir();
			if($bsq->total_registros > 0)
				{
?>
					<tr>
						<td>&nbsp;</td>						
						<td>
							<table border="0" class="b_table_w" height="30">
								<tr>
									<td colspan="3" class="trcabecera_list">Bitacora de Movimientos</td>
								</tr>
								<tr bgcolor="#BF0000">
									<td width="370px"><b><font color="#FFFFFF">Ubicaci&oacute;n</font></b></td>
									<td width="180px"><b><font color="#FFFFFF">Fecha Estatus</font></b></td>	
									<!--<td width="250px"><b><font color="#FFFFFF">Informaci&oacute;n Adicional</font></b></td>	-->			
								</tr>	
<?
								$zx = 0;
								$zy = 0;
								for($f=0;$f<$bsq->total_registros;$f++)
								{	
									$bsq->siguiente();
?>
									<tr <? if($f % 2 == 0) echo " class=\"trresaltado_info\"" ?>>
										<td><? echo $bsq->fila["ruta"]; ?></td>				
										<td><? echo $bsq->fila["faccion"]; ?></td>						
									</tr>

<?								}	
				} 
			
			$bsq->cerrar();	
			unset($bsq);	
?>		
							</table>
<?
	if((is_null($rslista->fila["plazo"])!=true) && ($rslista->fila["id_estatus"]==1 || $rslista->fila["id_estatus"]==2))
	{								
?>
							<br />
							<table border="0" class="b_table_w" height="30">
								<tr>
									<td colspan="3" class="trcabecera_list">Informaci&oacute;n Asignaci&oacute;n</td>
								</tr>
								<tr>
									<td>Plazo:</td>
									<td><? echo $rslista->fila["plazo"]." d&iacute;as"; ?></td>					
								</tr>
								<tr>
									<td>Fecha Vencimiento:</td>
									<td><? echo "<span class='mensaje'>".$rslista->fila["f_vencimiento"]."</span>"; ?></td>
								</tr>
							</table>
<? } ?>							
						</td>
					</tr>
			</table>
		</td>
	</tr>
	<tr><td height="1" colspan="11"></td></tr>	
<? } ?>
	<tr><td height="11" colspan="11"></td></tr>		    
	<tr>
    	<td colspan="11"><? $rslista->CrearPaginadorAjax("modulos/correspondencia/cgr/monitoreo_cgr/monitoreo_list.php","images/paginador/","cargar_lista_corres",$condi) ?></td>
    </tr>
<?
		} else {
?>	
	<tr class="trresaltado">
		<td colspan="11">
			No Ex&iacute;sten Datos a Mostrar
		</td>																					
	</tr>
<?
}
?>	
</table>		

<?
/*
consulta para restar fechas
SELECT DATEDIFF(crp_ruta_correspondencia.fecha_cambio_estatus,
(SELECT crp_ruta_correspondencia.fecha_cambio_estatus
	FROM crp_ruta_correspondencia INNER JOIN estatus ON (crp_ruta_correspondencia.id_estatus) 
	WHERE crp_ruta_correspondencia.id_recepcion_correspondencia = 2 AND crp_ruta_correspondencia.id_estatus = 3 GROUP BY crp_ruta_correspondencia.id_ruta_correspondencia)) AS q,
	crp_ruta_correspondencia.`id_ruta_correspondencia`

FROM
 crp_ruta_correspondencia 
 INNER JOIN estatus 
  ON (
   crp_ruta_correspondencia.id_estatus
  ) 
WHERE crp_ruta_correspondencia.id_recepcion_correspondencia = 2 
 AND (crp_ruta_correspondencia.id_estatus =5)
GROUP BY crp_ruta_correspondencia.id_ruta_correspondencia 
*/

?>