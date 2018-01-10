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
require_once("librerias/Recordset.php");
require_once("bil.php");

?>
<table border="0" align="center" width="850">
	<tr>
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="60px"><img src="images/privilegios.png"/></td>
					<td class="titulomenu" valign="middle">Asignaci&oacute;n Privilegios a Usuarios</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
	<tr>
		<td>
			<table align="center" width="100%" border="0">
				<tr>
					<td>
						<fieldset>
						<legend class="titulomenu">&nbsp;Datos del Usuario</legend>
							<form action="" method="post" name="form" id="form">
							<input type="hidden"  name="spam" value="<? echo $_SESSION["spam"]; ?>"/>
							<input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" />							
							<table align="center"  border="0" cellspacing="0"  cellpadding="2" width="90%">			
								<tr>
									<td height="15px" colspan="8">
									</td>
								</tr>									
                                <tr bgcolor="#E9E9E9">
                                    <td align="right" height="20" bgcolor="#CCCCCC">
										<b>Usuario:</b>                                  
                                    </td>
									<td bgcolor="#CCCCCC">
										<input type="text"  readonly="true" name="usuario" id="usuario" style="width:170px;border:#FFFFFF; background-color:#CCCCCC; text-decoration:underline; color:#FF0000; font-weight:bold;"/>
									</td> 
									<td width="40"></td>                                   
									<td align="right" height="20" bgcolor="#CCCCCC">
										<b>Nombre:</b>
                                    </td>
									<td bgcolor="#CCCCCC">
										<input type="text" readonly="true" name="nombres" id="nombres" style="width:170px;border:#FFFFFF; background-color:#CCCCCC; text-decoration:underline; color:#FF0000; font-weight:bold;"/>
										
									</td>
									<td width="40"></td>
                                    <td align="right" height="20" bgcolor="#CCCCCC">
										<b>Apellido:</b>                                 
                                    </td>
									<td bgcolor="#CCCCCC">
										<input type="text" name="apellidos" readonly="true" id="apellidos" style="width:170px;border:#FFFFFF; background-color:#CCCCCC; text-decoration:underline; color:#FF0000; font-weight:bold;"/>
									</td>
                                </tr>
								<tr><td height="5"></td></tr>
								<tr><td height="30" colspan="8"></td></tr>																																																
							</table>
							<table width="100%" border="0" >
								<tr>
									<td align="center">
										<fieldset style="width:790px">
										<legend class="titulomenu">&nbsp;Privilegios</legend>
											<? echo List_pri(); ?>							
										</fieldset>
									</td>
								</tr>
								<tr><td height="20"></td></tr>
								<tr>
									<td align="center">
										<input type="hidden" name="pri" id="pri" />										
										<input type="hidden" id="idusu" name="idusu" />
										<input type="button" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" onclick="cancel();" />																													
									</td>
								</tr>								
							</table>
							</form>
							<BR /><BR />
							<table class="b_table" align="center" width="90%" border="0">
								<tr>
									<td id="listusuarios" align="center">
									</td>
								</tr>
							</table>
							<table style="display:none"><tr><td><iframe name="fra" id="fra" src="modulos/seguridad/privilegios/alma.php" width="0" height="0"></iframe></td></tr></table>
							<BR />							
						</fieldset>		
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? echo '<script language="javascript" type="text/javascript">cargar_lista("'.'modulos/seguridad/privilegios/privilegios_d.php?pagina=1'.'");</script>'; ?>
