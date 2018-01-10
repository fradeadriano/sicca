<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado de Usuarios</title>
</head>
<body>
<form action="sprivelegio.php" name="ilegal" id="ilegal" method="post">
	<input type="hidden" name="archivo" value="'.$_SERVER['SCRIPT_NAME'].'" />
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
	document.getElementById("ilegal").submit();
</script>';
	die($hmtl);
}
define("_VERSION","1.0");
define("_SISTEMA",".... __Sistema de Correspondencia de la Contraloria del Estado Aragua__ ....");
define("_DHTML","librerias/dhtml/");
define("_LIBRARY","librerias/");
define("_DHTML_TEMAS","librerias/dhtml/themes/");
define("_IMAGESPAGINADOR","images/paginador/");
define("_IMAGES","images/");
define("_HOJA","css/");
?>