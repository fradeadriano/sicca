<?
session_start();
session_destroy();
unset($_SESSION["autenti"]);
unset($_SESSION["usuario"]);
unset($_SESSION["Id"]);
unset($_SESSION["MyIdUser"]);
unset($_SESSION["ultimoAcceso"]);
unset($_SESSION["pa"]);
unset($_SESSION["mensaje"]);
$road = "http://".$_SERVER['HTTP_HOST']."/".basename(dirname(__FILE__));
echo '<script language="javascript" type="text/javascript">location.href="'.$road.'"</script>';
//header("Location: $road"); 
?>