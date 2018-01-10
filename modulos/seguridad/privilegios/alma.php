<?
	session_start();
	require_once("../../../librerias/Recordset.php");
	require_once("../../../librerias/bitacora.php");		
	$idd = stripslashes($_GET["id"]);
	$moddo = stripslashes($_GET["modo"]);
	$ussu = stripslashes($_GET["usu"]);	

	if(isset($idd) && $idd!="")
	{
		switch($moddo){
			case "insert":
				$rsverif= new Recordset();
				$rsverif->sql = "SELECT seg_acceso_modulo.`id_acceso_modulo` FROM seg_acceso_modulo WHERE seg_acceso_modulo.`id_modulo` = ".$idd." AND seg_acceso_modulo.`id_usuario` = ".$ussu; 
				$rsverif->abrir();
				if($rsverif->total_registros != 0){
					$rsverif->siguiente();
					$fgh = $rsverif->fila["id_acceso_modulo"];					
					$rsinsert= new Recordset();
					$rsinsert->sql = "DELETE FROM seg_acceso_modulo WHERE id_acceso_modulo = '".$fgh."'";
					$rsinsert->abrir();
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Asignaci&oacute;n de Privilegio", "Se Agrego el Privilegio Identificado con el: '".$idd."' al Usuario '".$ussu."'");
					$rsinsert->cerrar();		
					unset($rsinsert);
				}	
				$rsverif->cerrar();
				unset($rsverif);
			break;

			case "delete":
				$rsverif= new Recordset();
				$rsverif->sql = "SELECT seg_acceso_modulo.`id_acceso_modulo` FROM seg_acceso_modulo WHERE seg_acceso_modulo.`id_modulo` = ".$idd." AND seg_acceso_modulo.`id_usuario` = ".$ussu; 
				$rsverif->abrir();
				if($rsverif->total_registros == 0){				
					$rsinsert= new Recordset();
					$rsinsert->sql = "INSERT INTO seg_acceso_modulo(id_usuario, id_modulo) VALUES ($ussu, $idd)";
					$rsinsert->abrir();
					bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Negar Privilegio", "Se Nego el Privilegio Identificado con el: '".$idd."' al Usuario '".$ussu."'");
					$rsinsert->cerrar();		
					unset($rsinsert);
				}	
				$rsverif->cerrar();
				unset($rsverif);
			break;
		}
	}
?>