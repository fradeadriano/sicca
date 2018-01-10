<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
//<form action="sprivelegio.php" name="ilegal" id="ilegal" method="post">
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
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo _SISTEMA; ?></title>
<link href="<? echo _HOJA; ?>style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/sicca.png" type="image/x-icon">
</head>
<body style="overflow-x: hidden; overflow-y: hidden"> 
<form action="" method="post" name="form" id="form" autocomplete="off">
<table align=center id="Tabla_01" width="1024" height="768" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="5" background="images/logeo/loginsicca_01.jpg" width="1024" height="283" valign="bottom" align="center">
			<? //if (isset($_SESSION["mensaje"])) { echo "<span class=\"mensaje_fallo\">".$_SESSION["mensaje"]."</span>"; }?>
		</td>
	</tr>
	<tr>
		<td rowspan="4">
			<img src="images/logeo/loginsicca_02.jpg" width="310" height="485" alt=""></td>
		<td>
			<img src="images/logeo/loginsicca_03.jpg" width="12" height="14" alt=""></td>
		<td background="images/logeo/loginsicca_04.jpg">
			<img src="images/logeo/loginsicca_04.jpg" width="350" height="14" alt=""></td>
		<td>
			<img src="images/logeo/loginsicca_05.jpg" width="11" height="14" alt=""></td>
		<td rowspan="4">
			<img src="images/logeo/loginsicca_06.jpg" width="341" height="485" alt=""></td>
	</tr>
	<tr>
		<td background="images/logeo/loginsicca_07.jpg"><img src="images/logeo/loginsicca_07.jpg" width="12" height="192" alt=""></td>
		<td background="images/logeo/loginsicca_08.jpg" width="350" height="192" align=center valign=top>
			<table width="350" height="192" border="0">
				<tr>
					<td rowspan=3 align=center><img src=images/logeo/lock.png></td>
					<td rowspan=3 align=center><img src=images/logeo/lines.png></td>
					<td height=26><img src=images/logeo/acceso.png></td>
				</tr>
				<tr>
					<td valign="middle">
						<table border="0" width="100%" cellpadding="4" cellspacing="2" class="text_logeo">
							<tr>
								<td align="right">Usuario:</td>
								<td ><input type="text" name="usuario" id="usuario" /></td>
							</tr>
							<tr>
								<td align="right">Clave:</td>
								<td><input type="password" name="clave" id="clave" /></td>								
							</tr>				
							<tr><td height="7px"></td></tr>							
							<tr>
								<td align="center" colspan="2">
									<input type="submit" value="Iniciar" />
									<input type="reset" value="Cancelar" />					
								</td>
							</tr>											
						</table>
					</td>
				</tr>				
			</table>
		</td>
		<td background="images/logeo/loginsicca_09.jpg"><img src="images/logeo/loginsicca_09.jpg" width="11" height="192" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/logeo/loginsicca_10.jpg" width="12" height="17" alt=""></td>
		<td background="images/logeo/loginsicca_11.jpg">
			<img src="images/logeo/loginsicca_11.jpg" width="350" height="17" alt=""></td>
		<td>
			<img src="images/logeo/loginsicca_12.jpg" width="11" height="17" alt="">

			</td>
	</tr>
	<tr>
		<td colspan="3" background="images/logeo/loginsicca_13.jpg" width="373" height="262" valign="top" align="center"><br />
			<? if (isset($_SESSION["mensaje"])) { echo "<span class=\"mensaje_fallo\">".$_SESSION["mensaje"]."</span>"; }?>
		</td>
	</tr>
</table>		

<!--<table width="80%" border="0" align="center">
	<tr>
		<td align="center" height="300">
			<table border="0">
				<tr>
					<td><? if (isset($_SESSION["mensaje"])) { echo $_SESSION["mensaje"]; }?></td>
				</tr>
				<tr>
					<td>
						Usuario:
					</td>
					<td><input type="text" name="usuario" id="usuario" /></td>
				</tr>
				<TR><td colspan="2" height="5"></td></TR>
				<tr>
					<td>
						Clave:
					</td>
					<td><input type="password" name="clave" id="clave" /></td>
				</tr>
				<TR><td colspan="2" height="20"></td></TR>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Iniciar" />
						&nbsp;&nbsp;&nbsp;
						<input type="reset" value="Cancelar" />
					</td>
				</tr>		
			</table>
		</td>
	</tr>
</table>-->
</form>
<script language="javascript" type="text/javascript">document.getElementById("usuario").focus();</script>
</body>
</html>