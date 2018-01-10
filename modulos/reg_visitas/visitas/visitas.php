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
<table border="0" align="center" width="700">
	<tr>
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="60px"><img src="images/usuario.png"/></td>
					<td class="titulomenu" valign="middle">Registro Visitas</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table align="center" width="100%" border="0">
				<tr>
					<td>
<!--						<fieldset>
						<legend class="titulomenu">&nbsp;Datos del Visitante</legend>-->
							<form action="" method="post" name="form" id="form" onkeypress="return entsub(event);" >
                             <input type="hidden"  name="ms" id="ms" value="<? echo $mensaje; ?>"/>
							<table align="center" width="100%" border="0" cellspacing="0"  cellpadding="2" class="tabla_bsq">			
								<tr>
									<td height="15px" colspan="3">
									</td>
								</tr>	
                                <tr bgcolor="#0080C0" height="20">
                                    <td align="right" width="213">
										<span class="te">C&eacute;dula:</span>
                                    </td>
									<td width="250" align="center">
										<input type="text" name="cedula" maxlength="8" style="width:240px; height:40px; font-size:24px; text-align:center; font-weight:bold; color:#990000;" id="cedula" onkeypress="return validar(event,numeros)"/>
									</td>
									<td valign="middle">
										<a style="cursor:help">
											<img src="images/help2.png" border="0" /><span class="tooltip"><center>Ingrese los digitos del n&uacute;mero de c&eacute;dula <br />y pulse la tecla enter</center></span>
										</a>								
									</td>
                                </tr>
								<tr>
									<td height="20px" colspan="3">
									</td>
								</tr>								
								<tr>
									<td colspan="3" align="center">
										<iframe name="iresult" id="iresult" width="100%" frameborder="0" scrolling="no" height="400"></iframe>
									</td>
								</tr>
								<tr>
									<td height="20px" colspan="3">
									</td>
								</tr>								
							</table>
							</form>
						<!--</fieldset>-->
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
	document.getElementById("cedula").focus();
	document.onkeypress=function(e){
	var esIE=(document.all);
	var esNS=(document.layers);
	tecla=(esIE) ? event.keyCode : e.which;
	var q = document.getElementById("cedula").value;
	if(tecla==13){
		if (q.length>= 7 || q.length <= 8){
				var ts = "modulos/reg_visitas/visitas/busq.php?accion=buscar&ce="+document.getElementById("cedula").value;
				hacer_llamados(ts);
		}
	  }
	}	
	
	function entsub(event)
	{
	// para ie
		if(window.event && window.event.keyCode == 13)
		{
			return false;
		}
	
	// para firefox
		if (event && event.which == 13)
		{
			return false;
		}
	}	
</script>