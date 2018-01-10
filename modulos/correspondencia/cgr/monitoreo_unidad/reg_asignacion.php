<?
	session_start();
	require_once("../../../../librerias/Recordset.php");
	require_once("../../../../librerias/bitacora.php");	
	$recepcion = stripslashes($_GET["recep"]);
	$unidad = stripslashes($_GET["unidad"]);	
	$condn	= stripslashes($_GET["Ha"]);	
	
	if ((isset($recepcion) && $recepcion !=""))
	{	
		if($condn=="recib")
		{
			$search = new Recordset();
			$search->sql = "SELECT  * FROM crp_ruta_correspondencia_cgr WHERE crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr = '".$recepcion."' AND crp_ruta_correspondencia_cgr.`id_estatus` = 2";
			$search->abrir();
			if($search->total_registros == 0)							
				{				
					$update = new Recordset();
					$update->sql = "INSERT INTO crp_ruta_correspondencia_cgr (id_estatus, id_recepcion_correspodencia_cgr, fecha_recepcion) 
									VALUES (2, '".$recepcion."','".date("Y-m-d H:i:s")."')";
					$update->abrir();
					$update->cerrar();
					unset($update);	
					
					$bg = new Recordset();
					$bg->sql = "SELECT id_crp_ruta_correspodencia_cgr FROM crp_ruta_correspondencia_cgr WHERE id_recepcion_correspodencia_cgr ='".$recepcion."' order by id_crp_ruta_correspodencia_cgr desc limit 1";
					$bg->abrir(); 
					if($bg->total_registros > 0)
						{
							$bg->siguiente();
							$idruta = $bg->fila["id_crp_ruta_correspodencia_cgr"];											
																		
						}
					$bg->cerrar();
					unset($bg);	
	
					$update1 = new Recordset();
					//$update1->sql = "UPDATE crp_asignacion_correspondencia_cgr SET id_estatus = 2 WHERE id_recepcion_correspondencia_cgr =".$recepcion;
					$update1->sql = "UPDATE crp_asignacion_correspondencia_cgr SET id_estatus = 2, habilitado = 1 WHERE id_recepcion_correspondencia_cgr =".$recepcion;
					$update1->abrir();
					$update1->cerrar();
					unset($update1);	
																				
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"CGR: Recepci&oacute;n de Correspondencia identificada con :'".$recepcion."'","La unidad identificada como $unidad ha registrado la recepci&oacute;n de la correspondencia en fecha: '".date("d-m-Y H:i:s")."'");
				}
			$search->cerrar();
			unset($search);		
		} else if($condn=="habilitar"){
			$search = new Recordset();
			$search->sql = "SELECT  * FROM crp_ruta_correspondencia_cgr WHERE crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr = '".$recepcion."' AND crp_ruta_correspondencia_cgr.`id_estatus` = 2";
			$search->abrir();
			if($search->total_registros != 0)							
				{	
					$update1 = new Recordset();
					$update1->sql = "UPDATE crp_asignacion_correspondencia_cgr SET habilitado = 1 WHERE id_recepcion_correspondencia_cgr =".$recepcion;
					$update1->abrir();
					$update1->cerrar();
					unset($update1);								
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Habilitar Correspondencia CGR identificada con :'".$recepcion."'","La unidad ha habilitado la correspondencia en fecha: '".date("d-m-Y H:i:s")."'");
				}
			$search->cerrar();
			unset($search);					
		} else if($condn=="copia"){
			$search = new Recordset();
			echo $search->sql = "SELECT  * FROM crp_ruta_correspondencia_cgr WHERE crp_ruta_correspondencia_cgr.id_recepcion_correspodencia_cgr = '".$recepcion."' AND crp_ruta_correspondencia_cgr.`id_estatus` = 5";
			$search->abrir();
			if($search->total_registros != 0)							
				{	
					$update = new Recordset();
					$update->sql = "INSERT INTO crp_ruta_correspondencia_cgr (id_estatus, id_recepcion_correspodencia_cgr, fecha_recepcion) 
									VALUES (6, '".$recepcion."','".date("Y-m-d H:i:s")."')";
					$update->abrir();
					$update->cerrar();
					unset($update);	
					
					$bg = new Recordset();
					$bg->sql = "SELECT id_crp_ruta_correspodencia_cgr FROM crp_ruta_correspondencia_cgr WHERE id_recepcion_correspodencia_cgr ='".$recepcion."' order by id_crp_ruta_correspodencia_cgr desc limit 1";
					$bg->abrir();
					if($bg->total_registros > 0)
						{
							$bg->siguiente();
							$idruta = $bg->fila["id_crp_ruta_correspodencia_cgr"];											
																		
						}
					$bg->cerrar();
					unset($bg);	
	
					$update1 = new Recordset();
					$update1->sql = "UPDATE crp_asignacion_correspondencia_cgr SET id_estatus = 6 WHERE id_recepcion_correspondencia_cgr =".$recepcion;
					$update1->abrir();
					$update1->cerrar();
					unset($update1);	
									
					$bu = new Recordset();
					$bu->sql = "SELECT id_unidad, unidad, codigo FROM unidad WHERE id_unidad =".$unidad;
					$bu->abrir();
					if($bu->total_registros > 0)
						{
							$bu->siguiente();
							$idunidda = $bu->fila["id_unidad"];											
																		
						}
					$bu->cerrar();
					unset($bu);						
																
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Recepci&oacute;n de Correspondencia identificada con :'".$recepcion."'","La unidad identificada como $idunidda ha registrado la recepci&oacute;n de la correspondencia en fecha: '".date("d-m-Y H:i:s")."' enviada por el Despacho del Contralor");
				}
			$search->cerrar();
			unset($search);					
		}

	
	}
?>