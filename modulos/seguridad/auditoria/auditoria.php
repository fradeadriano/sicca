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
//require_once("librerias/bitacora.php");
require_once("bil.php");
?>
<table width="790px" align="center">
	<tr>
		<td align="center">
			<table width="99%" align="center" cellpadding="2" cellspacing="0" border="0">
				<tr>
					<td width="30px"><img src="images/bitacora.png"/></td>
					<td class="titulomenu" valign="middle">&nbsp;Auditoria Sistema</td>
				</tr>
				<tr>
					<td colspan="2" valign="top"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td align="center" valign="top">
			<form method="post" action="" name="FormPro" id="Formord" autocomplete="off"><input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" />
			<input type="hidden" name="metodo" id="metodo" />
				<table border="0" align="center" class="b_table" cellpadding="3" cellspacing="3" width="99%">			
					<tr valign="top">
						<td align="center">
							<fieldset style="width:90%; border-color:#EFEFEF"> 
							<legend class="titulomenu">Busqueda de Acciones</legend>
							<table border="0" width="100%" class="b_table_b" bgcolor="#F8F8F8"  cellpadding="2" cellspacing="4">
								<tr>
									<td valign="bottom"  align="right" width="250">
										Usuario:
									</td>
									<td valign="bottom">
										<? 
										$rsun = new Recordset();
										$rsun->sql = "SELECT IF(usuario='','Sin Usuario',usuario) AS idusuario, IF(usuario='','Sin Usuario',usuario) AS usuario FROM seg_bitacora WHERE usuario <> 'admin' GROUP BY usuario"; 
										$rsun->llenarcombo($opciones = "\"usuario\"", $checked = "", $fukcion = "" , $diam = "style=\"width:160px; Height:20px;\""); 
										$rsun->cerrar(); 
										unset($rsun);																						
										?>
									</td>							
								</tr>
								<tr>
									<td align="right">
										Fechas Entre:
									</td>		
									<td>
										<input type="text" name="desde" id="desde" style="width:70px" onkeyup="this.value=formateafecha(this.value,'2017','2013');" />&nbsp;y&nbsp;<input type="text" name="hasta" id="hasta" onkeyup="this.value=formateafecha(this.value,'2017','2013');" style="width:70px"/>
										<span class="mensaje">*</span>
										&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span>
									</td>								
								</tr>
								<tr><td height="10"></td></tr>
								<tr><td height="5" colspan="2" align="right" class="mensaje">* Campo Obligatorio</td></tr>								

								<tr>
									<td colspan="2" align="center">
										<input type="hidden" name="accion" id="accion" />
										<input type="button" name="buscar" id="buscar" value="Buscar" title="Buscar" onclick="subb();" />
										&nbsp;
										<input type="reset" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" />										
									</td>								
								</tr>								
							</table>
							</fieldset>
						</td>
					</tr>
					<tr><td height="10px"></td></tr>
					<tr valign="top">
						<td align="center">
							<fieldset style="width:95%; border-color:#EFEFEF"> 
							<legend class="titulomenu">Listado</legend>
							<table border="0" width="100%" class="b_table_b" bgcolor="#F8F8F8" id="lista">
								<tr><td align="center">No Ex&iacute;sten Datos a Mostrar</td></tr>
							</table>
							</fieldset>
						</td>
					</tr>					
				</table>
			</form>
		</td>
	</tr>
</table>
<? echo '<script language="javascript" type="text/javascript">cargar_lista("'.'modulos/seguridad/auditoria/auditoria_d.php?pagina=1&parametros1='.'");</script>'; ?>