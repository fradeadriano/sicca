 <?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Listado de Usuarios</title>
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
	session_start();
	require_once("componentes.php");
	destruir($_SESSION["usuario"]);
	$fechaGuardada = $_SESSION["ultimoAcceso"];	
	date_default_timezone_set("America/Caracas"); 
    $ahora = date("Y/n/j H:i:s");	
	$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
	if($tiempo_transcurrido >= 36000) {
			echo '<script language="javascript" type="text/javascript">
				function acen(x) 
				{
					x = x.replace(/ó/g,"\xF3");	x = x.replace(/&oacute;/g,"\xF3")
					return x			
				}
				alert(acen("Su Sesi&oacute;n Ha Caducado...!"));</script>';
			ins_bitacora ($_SESSION["usuario"],date("Y-m-d"),date("h:i:s"),$iip,"Sesi&oacute;n Ha Caducado","Sesi&oacute;n Caducada");				
			require_once("cerrar.php");
//	      	session_destroy(); 			
//			header("Location: "."http://".$_SERVER['HTTP_HOST']."/".basename(dirname(__FILE__)).""); 
	} else {
	    $_SESSION["ultimoAcceso"] = $ahora;
		$ruta = "modulos/";
		creacion($ruta);
		$cabecera = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>'._SISTEMA.' - Usuario: '.$_SESSION["usuario"].'</title>
		<link href="'._HOJA.'style.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="images/sicca.png" type="image/x-icon">
		<script language="javascript" type="text/javascript" src="'._LIBRARY.'script.js"></script>		
		<script type="text/javascript" src="'._DHTML.'dhtmlSuite-common.js"></script>
		<script language="javascript" type="text/javascript" src="'._DHTML.'ajax.js"></script>
		<script language="javascript" type="text/javascript" src="'._LIBRARY.'jquery.js"></script>
		<script language="javascript" type="text/javascript" src="'._LIBRARY.'funciones.js"></script>	
		<script type="text/javascript" src="'._LIBRARY.'jq.js"></script>
		<script type="text/javascript" src="'._LIBRARY.'jquery.autocomplete.js"></script>					
		<script type="text/javascript">
		DHTML_SUITE_JS_FOLDER = "'._DHTML.'";
		DHTML_SUITE_THEME_FOLDER = "'._DHTML_TEMAS.'";
		DHTMLSuite.include("modalMessage");
		</script>			
		</head>
		<body>';		
		echo $cabecera;
		crear_menu($_SESSION["MyIdUser"],$_SESSION["pa"]);
		require_once("librerias/librerias.php");				
	}
?>
