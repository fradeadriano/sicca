<?
	session_start();
	require_once("../../../librerias/Recordset.php");
	require_once("../../../librerias/bitacora.php");	
	$qdate = stripslashes($_GET["cedula"]);
	$qnom = stripslashes($_GET["nombre"]);
	$qape = stripslashes($_GET["telef"]);		
	if ((isset($qdate) && $qdate !="")){	
		if(ctype_digit($qdate)){	
			$search = new Recordset();
			$search->sql = "SELECT * FROM rec_visitante WHERE rec_visitante.cedula = '".$qdate."'";
				$search->abrir();
				if($search->total_registros == 0)
				{
					$searchP = new Recordset();
					$searchP->sql = "insert into rec_visitante (cedula, visitante, telefono) values('".$qdate."','".$qnom."','".$qape."');";
					$searchP->abrir();
					$searchP->cerrar();
					unset($searchP);
					/*bitacora*/bitacora ($_SESSION["usuario"],date("Y-m-d"),date("h:i:s"),"Registro de visitante","Registro de visitante: Se registro un visitante con los siguientes datos: C&eacute;dula:".$qdate.", nombre y apellido: ".$qnom." y tel&eacute;fono: ".$qape);							
?>
				<!--<script language="javascript" type="text/javascript"> closeMessage(); </script>-->
<?
				}
			}
		}
// hacer_llamados("modulos/reg_visitas/visitas/busq.php?ce='.$qdate.'");
?>

