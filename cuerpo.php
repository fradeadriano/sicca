<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
echo "<table bgcolor=#ffffff cellpadding=0 cellspacing=0 align=center width=70% height=100%><tr><td valign=top>";
$mandato = stripslashes($_POST["elegido"]);
if ((isset($mandato) && $mandato !=""))
{	
	if(ctype_alpha($mandato))
	{
		$searchC = new Recordset();
		$searchC->sql = "SELECT ruta FROM seg_modulo WHERE acronimo = '$mandato'";
		$searchC->abrir();
			if($searchC->total_registros != 0)
			{
				$searchC->siguiente();
				$rth = $searchC->fila["ruta"];
//				echo $rth;
				include("$rth");
			} else {
				if($mandato=="cl"){
					$iip = obtenerIP();
					ins_bitacora ($_SESSION["usuario"],date("Y-m-d"),date("h:i:s"),$iip,"Cierre de Sesi&oacute;n","Cierre de Sesi&oacute;n");
					include("cerrar.php");				
				} else {
					echo "Error de Archivo, Consulte al Administrador";
				}
			}
	} else {
		echo "Valor Incorrecto";
	}
}
echo"</td></tr></table>";
?>