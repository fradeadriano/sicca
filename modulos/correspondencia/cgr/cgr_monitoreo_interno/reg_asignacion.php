<?
	session_start();
	require_once("../../../../librerias/Recordset.php");
	require_once("../../../../librerias/bitacora.php");	
	$recepcion = stripslashes($_GET["recep"]);	
	$corresponden = stripslashes($_GET["corres"]);		
	$fe_entrega = stripslashes($_GET["fecha"]);			
	//$fe_hora = stripslashes($_GET["hora"]);			
	//$fe_minuto = stripslashes($_GET["minuto"]);	
	$mod = stripslashes($_GET["modo"]);			

//	if ((isset($recepcion) && $recepcion !="") && (isset($mod) && $mod !="") && (isset($corresponden) && $corresponden !="") && (isset($fe_entrega) && $fe_entrega !="") && (isset($fe_hora) && $fe_hora !="") && (isset($fe_minuto) && $fe_minuto !="")) 
	if ((isset($recepcion) && $recepcion !="") && (isset($mod) && $mod !="") && (isset($corresponden) && $corresponden !="") && (isset($fe_entrega) && $fe_entrega !="")) 	
	{	
		if($mod=="recibir"){
			$search = new Recordset();									
			//$hour = $search->formatofecha($fe_entrega)." ".$fe_hora.":".$fe_minuto.":00";	
			$hour = $search->formatofecha($fe_entrega)." 00:00:00";	
		
			$search->sql = "SELECT  * FROM crp_ruta_correspondencia_cgr WHERE crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr = '".$corresponden."' AND crp_ruta_correspondencia_cgr.id_estatus = 5 ORDER BY id_crp_ruta_correspodencia_cgr DESC LIMIT 1";
			$search->abrir();
			if($search->total_registros == 1)							
				{								
					$update = new Recordset();
					echo $update->sql = "INSERT INTO crp_ruta_correspondencia_cgr (id_estatus, id_recepcion_correspodencia_cgr, fecha_recepcion) 
										VALUES (6, '".$corresponden."','".$hour."')";
					$update->abrir();
					$update->cerrar();
					unset($update);				
					
					$update1 = new Recordset();
					$update1->sql = "UPDATE crp_asignacion_correspondencia_cgr SET id_estatus = 6 WHERE id_recepcion_correspondencia_cgr =".$corresponden;
					$update1->abrir();
					$update1->cerrar();
					unset($update1);		

					$update2 = new Recordset();
					$update2->sql = "UPDATE crp_correspondencia_externa SET entregado = 1 WHERE id_correspondencia_externa =".$recepcion;
					$update2->abrir();
					$update2->cerrar();
					unset($update2);								
				}
			$search->cerrar();
			unset($search);		
		} 
	}
	
	if ((isset($recepcion) && $recepcion !="") && (isset($mod) && $mod !="") && (isset($fe_entrega) && $fe_entrega !="")) 	
	{	
		if($mod=="recibir_xx"){
			$search = new Recordset();									
			$hour = $search->formatofecha($fe_entrega)." 00:00:00";	
		
			$search->sql = "SELECT  * FROM crp_ruta_correspondencia_ext WHERE crp_ruta_correspondencia_ext.id_correspondencia_externa = '".$recepcion."' AND crp_ruta_correspondencia_ext.id_estatus = 5 ORDER BY id_crp_ruta_correspondencia_ext DESC LIMIT 1";
			$search->abrir();
			if($search->total_registros == 1)							
				{								
					$update = new Recordset();
					$update->sql = "INSERT INTO crp_ruta_correspondencia_ext (id_estatus, id_correspondencia_externa, fecha_recepcion) 
									VALUES (6, '".$recepcion."','".$hour."')";
					$update->abrir();
					$update->cerrar();
					unset($update);				

					$update2 = new Recordset();
					$update2->sql = "UPDATE crp_correspondencia_externa SET entregado = 1 WHERE id_correspondencia_externa =".$recepcion;
					$update2->abrir();
					$update2->cerrar();
					unset($update2);								
				}
			$search->cerrar();
			unset($search);		
		} 
	}	
?>