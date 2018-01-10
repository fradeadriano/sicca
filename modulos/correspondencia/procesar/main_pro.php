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
					<td width="40px" align="left"><img src="images/enviar.png"/></td>
					<td class="titulomenu" valign="middle">Procesar Envio Correspondencia</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table align="center" width="99%" border="0" class="b_table">
				<tr>
					<td align="center">
						<form action="" method="post" name="formB" id="formB" onkeypress="return entsub(event);" >
						<input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" autocomplete="off"/>
						<fieldset style="width:90%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Buscar Correspondencia</legend>						
						<table align="center" width="100%" border="0" cellspacing="2"  cellpadding="2" >			
							<tr>
								<td valign="bottom" align="right">
									Unidad Administrativa:&nbsp;								</td>							
								<td valign="bottom" align="left" width="245">
									<? $rsun = new Recordset();	
									$rsun->sql = "SELECT id_unidad, unidad FROM unidad WHERE id_unidad <> 8 AND id_unidad <> 1 order by unidad"; 
									$rsun->llenarcombo($opciones = "\"unidad\"", $checked = "", $fukcion = "" , $diam = "style=\"width:240px; Height:20px;\""); 
									$rsun->cerrar(); 
									unset($rsun);																						
									?>								</td>
								<td><img src="images/Help_16x16.png" style="cursor:pointer" title="El campo Unidad Administrativa corresponde a la gerencia que se encargo del desarrollar el documento" /></td>															
							</tr>
							<tr>
								<td valign="top" align="right">
									Organismo:&nbsp;								</td>
								<td valign="bottom" colspan="2">
									<textarea name="organismo" id="organismo" style="width:400px; height:40px;" ></textarea>											
									<input type="hidden" name="id_organismo" id="id_organismo"  />								</td>															
							</tr>
							<tr>
								<td height="10px" colspan="3">								</td>
							</tr>							
							<tr>
								<td width="250" align="center" colspan="3">
									<input type="button" name="btnBsq" id="btnBsq" value="Buscar Correspondencia" title="Buscar Correspondencia"  onclick="dosearch();" />
									&nbsp;
									<input type="reset" class="botones" name="cancelar" value="Limpiar" title="Limpiar" />								</td>
							</tr>
							<tr>
								<td height="20px" colspan="3">								</td>
							</tr>																
						</table>
						</fieldset>
						</form>
					</td>
				</tr>
				<tr>
					<td align="center">
						<iframe name="corres" id="corres" frameborder="0" width="95%" height="900"></iframe>
					</td>
				</tr>				
				<tr>
					<td height="20"></td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
<script language="javascript" type="text/javascript">
	$("#organismo").autocomplete("modulos/correspondencia/procesar/lista.php", { 
		width: 400,
		matchContains: true,
		mustMatch: false,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});

	$("#organismo").result(function(event, data, formatted) {
		try {
			$("#id_organismo").val(data[1]);
		} catch(e) {
			e.name;		
		}
	});

	
</script>