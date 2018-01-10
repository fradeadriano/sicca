<?
session_start();
header('content-type:text/xml; charset=iso-8859-1');
	//require_once("bil.php");
	require_once("../../../../librerias/Recordset.php");
	require_once("../../../../librerias/bitacora.php");	

	$acci_realizar = stripslashes($_GET["mandato"]);
//	$var1 = stripslashes($_GET["ddate"]);
	if(isset($_GET["ddate"]) && stripslashes($_GET["ddate"])!=""){
		$var1 = explode("/",stripslashes($_GET["ddate"]));	
	} else {
		$var1 = explode("/",date("d/m/Y"));
	}

//	$your_hour = stripslashes($_GET["dhour"]);
	$your_date = $var1[2]."/".$var1[1]."/".$var1[0];
	$recepcion_id = stripslashes($_GET["did"]);	
	
	$select = stripslashes($_GET["varEnvi"]);	
	$select_Id_rece = stripslashes($_GET["id_rece"]);	
	$cgr_detalle = stripslashes($_GET["idetalle"]);		
	
	
	

	if ((isset($acci_realizar) && $acci_realizar !=""))
	{	
		switch($acci_realizar)
		{
			case "Registrar":
				$search1 = new Recordset();
				$search1->sql = "UPDATE crp_asignacion_correspondencia_cgr SET id_estatus = 5 WHERE id_recepcion_correspondencia_cgr =".$recepcion_id;
				$search1->abrir();
				$search1->cerrar();
				unset($search1);			
				
				$search2 = new Recordset();
				$search2->sql = "INSERT INTO crp_ruta_correspondencia_cgr (id_recepcion_correspodencia_cgr, id_estatus, fecha_recepcion) VALUES ($recepcion_id, 5,'".$your_date."')";
				$search2->abrir();
				$search2->cerrar();
				unset($search2);
				
				$search3 = new Recordset();
				$search3->sql = "UPDATE crp_recepcion_cgr_detalle SET fecha_envio = '".$your_date."', enviado = 0 WHERE id_recepcion_cgr_detalle =".$cgr_detalle;
				$search3->abrir();
				$search3->cerrar();
				unset($search3);			
				bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro Envio Notificaci&oacute;n","Se registro una notificaci&oacute;n identificada con: '".$cgr_detalle."'");
				
											
				bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro Envio Notificaci&oacute;n","Se registro una notificaci&oacute;n identificada con: '".$recepcion_id."'");
			break;
			
			case "btnRegistrar_varios":		
				$search1 = new Recordset();
				$search1->sql = "UPDATE crp_recepcion_cgr_detalle SET fecha_envio = '".$your_date."', enviado = 0 WHERE id_recepcion_cgr_detalle =".$cgr_detalle;
				$search1->abrir();
				$search1->cerrar();
				unset($search1);			
				bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro Envio Notificaci&oacute;n","Se registro una notificaci&oacute;n identificada con: '".$cgr_detalle."'");
				
				$actu = new Recordset();
				$actu->sql = 'SELECT id_recepcion_cgr_detalle FROM crp_recepcion_cgr_detalle WHERE id_recepcion_correspondencia_cgr = '.$recepcion_id.' AND enviado = 1';
				$actu->abrir();
					if($actu->total_registros == 0)
						{				
							$search3 = new Recordset();
							$search3->sql = "UPDATE crp_asignacion_correspondencia_cgr SET id_estatus = 5 WHERE id_recepcion_correspondencia_cgr =".$recepcion_id;
							$search3->abrir();
							$search3->cerrar();
							unset($search3);			
							
							$search2 = new Recordset();
							$search2->sql = "INSERT INTO crp_ruta_correspondencia_cgr (id_recepcion_correspodencia_cgr, id_estatus, fecha_recepcion) VALUES ($recepcion_id, 5,'".$your_date."')";
							$search2->abrir();
							$search2->cerrar();
							unset($search2);											
							bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro Envio Notificaci&oacute;n","Se registro una notificaci&oacute;n identificada con: '".$recepcion_id."'");
						} else {
							echo "<br>no debi pasar";
						}
				$actu->cerrar();
				unset($actu);							
				
			break;			
			
			case "Finalizar":
				$search1 = new Recordset();
				$search1->sql = "UPDATE crp_asignacion_correspondencia_cgr SET id_estatus = 6 WHERE id_recepcion_correspondencia_cgr =".$recepcion_id;
				$search1->abrir();
				$search1->cerrar();
				unset($search1);			
				
				$search2 = new Recordset();
				$search2->sql = "INSERT INTO crp_ruta_correspondencia_cgr (id_recepcion_correspodencia_cgr, id_estatus, fecha_recepcion) VALUES ($recepcion_id, 6,'".$your_date."')";
				$search2->abrir();
				$search2->cerrar();
				unset($search2);
				
				$search3 = new Recordset();
				$search3->sql = "UPDATE crp_recepcion_cgr_detalle SET fecha_entrega = '".$your_date."', entregado = 0 WHERE id_recepcion_cgr_detalle =".$cgr_detalle;
				$search3->abrir();
				$search3->cerrar();
				unset($search3);			
				bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro Envio Notificaci&oacute;n","Se registro una notificaci&oacute;n identificada con: '".$cgr_detalle."'");
				
											
				bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro Envio Notificaci&oacute;n","Se registro una notificaci&oacute;n identificada con: '".$recepcion_id."'");
			break;


			case "Finalizar_varios":
				$qdesvio = stripslashes($_GET["desvio"]);
				if($qdesvio=="recibido"){		
					$search1 = new Recordset();
					$search1->sql = "UPDATE crp_recepcion_cgr_detalle SET fecha_entrega = '".$your_date."', entregado = 0, finalizado = 'si'  WHERE id_recepcion_cgr_detalle =".$cgr_detalle;
					$search1->abrir();
					$search1->cerrar();
					unset($search1);			
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro Entrega Notificaci&oacute;n","Se registro una notificaci&oacute;n identificada con: '".$cgr_detalle."' la cual fue entregada.");
					
					$actu = new Recordset();
					$actu->sql = 'SELECT id_recepcion_cgr_detalle FROM crp_recepcion_cgr_detalle WHERE id_recepcion_correspondencia_cgr = '.$recepcion_id.' AND entregado = 1';
					$actu->abrir();
						if($actu->total_registros == 0)
							{
								$search1 = new Recordset();
								$search1->sql = "UPDATE crp_asignacion_correspondencia_cgr SET id_estatus = 6 WHERE id_recepcion_correspondencia_cgr =".$recepcion_id;
								$search1->abrir();
								$search1->cerrar();
								unset($search1);			
								
								$search2 = new Recordset();
								$search2->sql = "INSERT INTO crp_ruta_correspondencia_cgr (id_recepcion_correspodencia_cgr, id_estatus, fecha_recepcion) VALUES ($recepcion_id, 6,'".$your_date."')";
								$search2->abrir();
								$search2->cerrar();
								unset($search2);
															
								bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro Envio Notificaci&oacute;n","Se registro una notificaci&oacute;n identificada con: '".$recepcion_id."'");
							
							} else {
								echo "<br>no debi pasar";
							}
					$actu->cerrar();
					unset($actu);							
				} else if ($qdesvio=="NOrecibido"){							
					$search1 = new Recordset();
					$search1->sql = "UPDATE crp_recepcion_cgr_detalle SET finalizado = 'si' WHERE id_recepcion_cgr_detalle =".$cgr_detalle;
					$search1->abrir();
					$search1->cerrar();
					unset($search1);			
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro Envio Notificaci&oacute;n","La notificaci&oacute;n n&deg;: '".$cgr_detalle."' No fue entregada identificada.");

					$actu = new Recordset();
					$actu->sql = 'SELECT id_recepcion_cgr_detalle FROM crp_recepcion_cgr_detalle WHERE id_recepcion_correspondencia_cgr = '.$recepcion_id.' AND finalizado = "no"';
					$actu->abrir();
						if($actu->total_registros == 0)
							{
								$search1 = new Recordset();
								$search1->sql = "UPDATE crp_asignacion_correspondencia_cgr SET id_estatus = 6 WHERE id_recepcion_correspondencia_cgr =".$recepcion_id;
								$search1->abrir();
								$search1->cerrar();
								unset($search1);			
								
								$search2 = new Recordset();
								$search2->sql = "INSERT INTO crp_ruta_correspondencia_cgr (id_recepcion_correspodencia_cgr, id_estatus, fecha_recepcion) VALUES ($recepcion_id, 6,'".$your_date."')";
								$search2->abrir();
								$search2->cerrar();
								unset($search2);
															
								bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro Envio Notificaci&oacute;n","Se registro la ruta de la notificaci&oacute;n identificada con: '".$recepcion_id."' y se actualizo su estatus.");
							
							}
				
				}				
				break;
		}
	} 	

	if ((isset($select) && $select !=""))
	{	
		switch($select)
		{
			case "recibir":
				$search1 = new Recordset();
				$search1->sql = "UPDATE crp_asignacion_correspondencia_cgr SET id_estatus = 4 WHERE id_recepcion_correspondencia_cgr =".$select_Id_rece;
				$search1->abrir();
				$search1->cerrar();
				unset($search1);			
				
				$search2 = new Recordset();
				$search2->sql = "INSERT INTO crp_ruta_correspondencia_cgr (id_recepcion_correspodencia_cgr, id_estatus, fecha_recepcion) VALUES ($select_Id_rece, 4,'".date("Y-m-d H:i:s")."')";
				$search2->abrir();
				$search2->cerrar();
				unset($search2);
											
				bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"CGR: Registro Aprobaci&oacute;n Correspondencia","Se registro una Correspondencia identificada con: '".$select_Id_rece."', la cual es recibida por Despacho del Contralor");
			break;
			
		}
	} 	

?>


