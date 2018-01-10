<?
	session_start();
	require_once("../../../librerias/Recordset.php");
	require_once("../../../librerias/bitacora.php");	
	$recepcion = stripslashes($_GET["recep"]);
	$unidad = stripslashes($_GET["unidad"]);	
	$condn	= stripslashes($_GET["Ha"]);	
	
	if ((isset($recepcion) && $recepcion !=""))
	{	
		if($condn=="recib"){
			$search = new Recordset();
			$search->sql = "SELECT  * FROM crp_ruta_correspondencia WHERE crp_ruta_correspondencia.id_recepcion_correspondencia = '".$recepcion."' AND crp_ruta_correspondencia.`id_estatus` = 2";
			$search->abrir();
			if($search->total_registros == 0)							
				{				
					$update = new Recordset();
					$update->sql = "INSERT INTO crp_ruta_correspondencia (id_estatus, id_recepcion_correspondencia, fecha_cambio_estatus, fecha_recepcion_digital) 
									VALUES (2, '".$recepcion."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
					$update->abrir();
					$update->cerrar();
					unset($update);	
					
					$bg = new Recordset();
					$bg->sql = "SELECT id_ruta_correspondencia FROM crp_ruta_correspondencia WHERE id_recepcion_correspondencia ='".$recepcion."' order by id_ruta_correspondencia desc limit 1";
					$bg->abrir();
					if($bg->total_registros > 0)
						{
							$bg->siguiente();
							$idruta = $bg->fila["id_ruta_correspondencia"];											
																		
						}
					$bg->cerrar();
					unset($bg);	
	
					$update1 = new Recordset();
					$update1->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 2 WHERE id_recepcion_correspondencia =".$recepcion;
					$update1->abrir();
					$update1->cerrar();
					unset($update1);	
									
					$ins22 = new Recordset();
					$ins22->sql = "INSERT INTO crp_ubicacion_correspondencia (id_recepcion_correspondencia, id_unidad_recibe, fecha_recepcion_digital, id_ruta_correspondencia)"." VALUES ( $recepcion, $unidad, '".date("Y-m-d H:i:s")."', $idruta)";
					$ins22->abrir();
					$ins22->cerrar();
					unset($ins22);		
											
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Recepci&oacute;n de Correspondencia identificada con :'".$recepcion."'","La unidad identificada como $unidad ha registrado la recepci&oacute;n de la correspondencia en fecha: '".date("d-m-Y H:i:s")."'");
				}
			$search->cerrar();
			unset($search);		
		} else if($condn=="habilitar"){
			$search = new Recordset();
			$search->sql = "SELECT  * FROM crp_ruta_correspondencia WHERE crp_ruta_correspondencia.id_recepcion_correspondencia = '".$recepcion."' AND crp_ruta_correspondencia.`id_estatus` = 2";
			$search->abrir();
			if($search->total_registros != 0)							
				{	
					$update1 = new Recordset();
					$update1->sql = "UPDATE crp_asignacion_correspondencia SET habilitado = 1 WHERE id_recepcion_correspondencia =".$recepcion;
					$update1->abrir();
					$update1->cerrar();
					unset($update1);								
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Habilitar Correspondencia identificada con :'".$recepcion."'","La unidad ha habilitado la correspondencia en fecha: '".date("d-m-Y H:i:s")."'");
				}
			$search->cerrar();
			unset($search);					
		} else if($condn=="copia"){
			$search = new Recordset();
			$search->sql = "SELECT  * FROM crp_ruta_correspondencia WHERE crp_ruta_correspondencia.id_recepcion_correspondencia = '".$recepcion."' AND crp_ruta_correspondencia.`id_estatus` = 5";
			$search->abrir();
			if($search->total_registros != 0)							
				{	
					$update = new Recordset();
					$update->sql = "INSERT INTO crp_ruta_correspondencia (id_estatus, id_recepcion_correspondencia, fecha_cambio_estatus, fecha_recepcion_digital) 
									VALUES (6, '".$recepcion."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
					$update->abrir();
					$update->cerrar();
					unset($update);	
					
					$bg = new Recordset();
					$bg->sql = "SELECT id_ruta_correspondencia FROM crp_ruta_correspondencia WHERE id_recepcion_correspondencia ='".$recepcion."' order by id_ruta_correspondencia desc limit 1";
					$bg->abrir();
					if($bg->total_registros > 0)
						{
							$bg->siguiente();
							$idruta = $bg->fila["id_ruta_correspondencia"];											
																		
						}
					$bg->cerrar();
					unset($bg);	
	
					$update1 = new Recordset();
					$update1->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 6 WHERE id_recepcion_correspondencia =".$recepcion;
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
					
					$ins22 = new Recordset();
					$ins22->sql = "INSERT INTO crp_ubicacion_correspondencia (id_recepcion_correspondencia, id_unidad_recibe, fecha_recepcion_digital, id_ruta_correspondencia)"." VALUES ( $recepcion, $idunidda, '".date("Y-m-d H:i:s")."', $idruta)";
					$ins22->abrir();
					$ins22->cerrar();
					unset($ins22);		
											
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Recepci&oacute;n de Copia de Correspondencia identificada con :'".$recepcion."'","La unidad identificada como $idunidda ha registrado la recepci&oacute;n de la copia de correspondencia en fecha: '".date("d-m-Y H:i:s")."' enviada por el Despacho del Contralor");
				}
			$search->cerrar();
			unset($search);					
		}

	
	}
?>