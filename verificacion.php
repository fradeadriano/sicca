<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>..</title>
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
require_once("librerias/Recordset.php");
require_once("componentes.php");
$user = stripslashes($_POST["usuario"]); $pass = stripslashes($_POST["clave"]);
if ((isset($user) && $user !="") && (isset($pass) && $pass !="")){	
	if(ctype_alnum($user) && ctype_alnum($pass)){
		$search = new Recordset();
		$search->sql = "SELECT id_usuario, usuario, estatus, power_administrator, campo FROM seg_usuario WHERE (usuario = '".trim($user)."' AND clave = '".md5($pass)."') AND estatus = '1'";
		$search->abrir();
			if($search->total_registros != 0)
			{
				$search->siguiente();
				session_start();	
				//session_name("MySeSsion");
				$_SESSION["autenti"] = "ya";
				$_SESSION["usuario"] = $search->fila["usuario"];
				$_SESSION["Id"] = session_id();
				$_SESSION["MyIdUser"] = base64_encode($search->fila["id_usuario"]);
				$_SESSION["ultimoAcceso"]= date("Y/n/j H:i:s");
				$_SESSION["pa"] = base64_encode($search->fila["power_administrator"]);				
				$_SESSION["x"] = base64_decode($search->fila["campo"]);
				unset($_SESSION["mensaje"]);
				place($search->fila["usuario"]);
				$iip = obtenerIP();
				ins_bitacora ($search->fila["usuario"],date("Y-m-d"),date("h:i:s"),$iip,"Inicio de Sesi&oacute;n","Inicio de Sesi&oacute;n");
			} else {
				$searchD = new Recordset();
				$searchD->sql = "SELECT usuario, estatus FROM seg_usuario WHERE (usuario = '".trim($user)."' AND clave = '".md5($pass)."')";
				$searchD->abrir();
					if($searchD->total_registros != 0)
					{
						$searchD->siguiente();
						if ($searchD->fila["estatus"] != 1)
							$_SESSION["mensaje"] = "Usuario Inactivo";			
					} else {
						$_SESSION["mensaje"] = "Usuario o Contrase&ntilde;a <br> Incorrectos<br>";			
					}
				$searchD->cerrar();
				unset($searchD);
				$road = "http://".$_SERVER['HTTP_HOST']."/".basename(dirname(__FILE__));
				header("Location: $road");						
			}
	} else {
		$_SESSION["mensaje"] = "Se introdujo caracteres <br>No permitidos para el acceso<br><br>";			
		$road = "http://".$_SERVER['HTTP_HOST']."/".basename(dirname(__FILE__));
		header("Location: $road");	
	}	
} 
?>