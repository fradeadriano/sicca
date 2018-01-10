<?
	session_start();
	require_once("../../../librerias/Recordset.php");
	require_once("../../../librerias/bitacora.php");	
	$recepcion = stripslashes($_GET["recep"]);	
	$mot = stripslashes($_GET["mot"]);		
	$mod = stripslashes($_GET["modo"]);			
	if ((isset($recepcion) && $recepcion !="") && (isset($mod) && $mod !=""))
	{
		if($mod=="recibir"){
			$search = new Recordset();
			$search->sql = "SELECT  * FROM crp_ruta_correspondencia WHERE crp_ruta_correspondencia.id_recepcion_correspondencia = '".$recepcion."' AND crp_ruta_correspondencia.id_estatus = 2 ORDER BY id_ruta_correspondencia DESC LIMIT 1";
			$search->abrir();
			if($search->total_registros == 1)							
				{								
					$update = new Recordset();
					$update->sql = "INSERT INTO crp_ruta_correspondencia (id_estatus, id_recepcion_correspondencia, fecha_cambio_estatus, fecha_recepcion_digital) 
									VALUES (3, '".$recepcion."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
					$update->abrir();
					$update->cerrar();
					unset($update);				
					
					$update1 = new Recordset();
					$update1->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 3 WHERE id_recepcion_correspondencia =".$recepcion;
					$update1->abrir();
					$update1->cerrar();
					unset($update1);				
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Revisi&oacute;n de Correspondencia identificada con :' ".$recepcion." '","La Direcci&oacute;n General ha recibido una correspondencia para su revisi&oacute;n, la cual se registro: '".date("d-m-Y H:i:s")."'");
				}
			$search->cerrar();
			unset($search);		
		} else if ($mod=="devolucion"){
			$search = new Recordset();
			$search->sql = "SELECT  * FROM crp_ruta_correspondencia WHERE crp_ruta_correspondencia.id_recepcion_correspondencia = '".$recepcion."' AND crp_ruta_correspondencia.id_estatus = 3 ORDER BY id_ruta_correspondencia DESC LIMIT 1";
			$search->abrir();
			if($search->total_registros == 1)							
				{	
					$cadenabus = array("á","é","í","ó","ú","ñ");
					$cadenasub = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&ntilde;");
					$justi = str_ireplace($cadenabus, $cadenasub, $mot);					
								
					$update = new Recordset();
					$update->sql = "INSERT INTO crp_ruta_correspondencia (id_estatus, id_recepcion_correspondencia, fecha_cambio_estatus, fecha_recepcion_digital) 
									VALUES (2, '".$recepcion."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
					$update->abrir();
					$update->cerrar();
					unset($update);	
					
					$inserttar = new Recordset();
					$inserttar->sql = "INSERT INTO crp_devolucion_correspondencia (id_recepcion_correspondencia, motivo, fecha_registro) 
									VALUES ('".$recepcion."','".base64_encode($justi)."','".date("Y-m-d H:i:s")."')";
					$inserttar->abrir();
					$inserttar->cerrar();
					unset($inserttar);					
					
					$update1 = new Recordset();
					$update1->sql = "UPDATE crp_asignacion_correspondencia SET id_estatus = 2, habilitado = 0 WHERE id_recepcion_correspondencia =".$recepcion;
					$update1->abrir();
					$update1->cerrar();
					unset($update1);				
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Devoluci&oacute;n de Correspondencia identificada con :' ".$recepcion." '","La Direcci&oacute;n General ha devuelto una correspondencia motivado a : '".$justi."', la cual se registro: '".date("d-m-Y H:i:s")."'");
				}
			$search->cerrar();
			unset($search);				
		}
	}
?>