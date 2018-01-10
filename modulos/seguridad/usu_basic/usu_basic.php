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
require_once("librerias/bitacora.php");
require_once("bil.php");
	$var1 = $_SESSION["usuario"];
	$var2 = base64_decode($_SESSION["MyIdUser"]);
	$var222 = $_SESSION["MyIdUser"];	
	$var3 = "0";
	
	$searchD = new Recordset();
	$searchD->sql = "SELECT usuario FROM seg_usuario WHERE id_usuario = '".$var2."'";
	$searchD->abrir();
		if($searchD->total_registros != 0)
		{
			$searchD->siguiente();
			$var4 = $searchD->fila["usuario"];
		} else {
			$var3 = "1";
		}
	$searchD->cerrar();
	unset($searchD);
	
if (!isset($_SESSION["spam"]))
    $_SESSION["spam"] = rand(1, 99999999);
	if ((isset($_POST["spam"]) && isset($_SESSION["spam"])) && $_POST["spam"] == $_SESSION["spam"]) 
		{
			$acion = $_POST["acc"];
			$hjjui = $_POST["hjju"];
			$ggyb = $_POST["clave"];
			$vjji = $_POST["repetir"];			
			if($acion == "registrar" && $hjjui!="")
			{			
				$comp = base64_decode($hjjui);
				if(strcmp($comp,$var2) == 0) 
				{
					if(strcmp($ggyb,$vjji) == 0) 
					{				
						$consul = new Recordset();
						$consul->sql = "SELECT usuario FROM seg_usuario WHERE id_usuario = '".$comp."'";
							$consul->abrir();
							if($consul->total_registros != 0)
							{
								$searchD = new Recordset();
								$searchD->sql = "update seg_usuario set clave = md5('".$ggyb."') where seg_usuario.id_usuario = '".$comp."';";
								$searchD->abrir();
								$searchD->cerrar();
								unset($searchD);																								
								bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Cambio de Clave","Registro de Cambio de Clave Exitosa!");																						
								$mensaje = 1;											
							} else {
								$mensaje = 2;
							}
						$consul->cerrar();
						unset($consul);							
						
					} else {
						$mensaje = 3;
					}				
								
				} else {
					$mensaje = 2;
				}				
			}
			$_SESSION["spam"] = rand(1, 99999999);
		} else {
			$_SESSION["spam"] = rand(1, 99999999);
		}

?>
<table border="0" align="center" width="700">
	<tr>
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="45px"><img src="images/cambio.png"/></td>
					<td class="titulomenu" valign="middle">Cambio de Clave</td>
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
						<fieldset>
						<legend class="titulomenu">&nbsp;Datos del Usuario</legend>
							<form action="" method="post" name="form" autocomplete="off"><input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" />
							<table align="center"  border="0" cellspacing="2" width="80%"  cellpadding="2">			
								<tr>
									<td colspan="3" align="center">
										<input type="hidden"  name="ms" id="ms" value="<? echo $mensaje;?>"/>
										<div id="mensa"  name="mensa" class="escuela" style="width:90%;float:center; font-size:12px;font-weight:bold;"></div>								
									</td>
								</tr>								
								<tr>
									<td height="15px" colspan="2">
									</td>
								</tr>	
                                <tr >
                                    <td align="right" height="20" width="180">
										Usuario:                                  
                                    </td>
									<td>
										<? echo "<b><u>".$var4."</u></b>"; ?>
									</td>
									<td></td>
                                </tr>
								<tr><td height="5"></td></tr>
                                <tr >
                                    <td align="right" height="20">
										Clave Anterior:                                  
                                    </td>
									<td>
										<? echo "<b><span class=\"mensaje\">|||||||||||||||</span></b>";?>
									</td>
									<td></td>									
                                </tr>								
								<tr><td height="5"></td></tr>
                                <tr >
                                    <td align="right" height="20">
										Nueva Clave:                                  
                                    </td>
									<td>
										<input type="password" maxlength="12" onkeypress="return validar(event,numeros+letras)" name="clave" id="clave" style="width:170px"/>
										
									</td>
									<td rowspan="3" width="150" align="left" valign="bottom">
										<table class="b_table">
											<tr><TD>
											<span style="font-size:9px">Clave acepta caracteres alfanum&eacute;ricos, <br />M&iacute;nimo 6 M&aacute;ximo 12.</span>
											</TD></tr></table>
									</td>											
                                </tr>
								<tr><td height="5" colspan="2"></td></tr>								
                                <tr >
									<td align="right" height="20">
										Repetir Clave:                                  
                                    </td>
									<td>
										<input type="password" name="repetir" id="repetir" style="width:170px" maxlength="12" onkeypress="return validar(event,numeros+letras)" />
									</td>									
                                </tr>
								<tr><td height="5"></td></tr>
								<tr><td height="20" colspan="2" align="right">
								</td></tr>								
								
								
								<tr><td height="20"></td></tr>
								<tr><td height="5" colspan="5" align="right" class="mensaje">Todos los Campos son obligatorios</td></tr>																
								<tr><td height="30" colspan="5"></td></tr>								
								<tr>
									<td align="center" colspan="5">
										<input type="button" name="registrar" id="registrar" value="Registrar" title="Registrar" onclick="ver();" />
										&nbsp;
										<input type="reset" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" />
										<input type="hidden" name="acc" id="acc" />							
										<input type="hidden"  name="spam" value="<? echo $_SESSION["spam"]; ?>"/>																						
										<input type="hidden" name="hjju" id="hjju" value="<? echo $var222; ?>" />
									</td>
								</tr>																																								
							</table>
							</form>
						</fieldset>						
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script language="javascript">
$(document).ready(function()
{
	valor=$('#ms').val();
	if(valor==1){

		mensaje=acentos('&iexcl;Cambio de Clave registrado exitosamente!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}
    
	if(valor==2){

		mensaje=acentos('&iexcl;Cambio Rechazado, <br>Existe un error con el usuario, Comuniquese con el administrador del sistema!')
		$("#mensa").addClass('fallo');
		$('#mensa').html(mensaje);
	}
	
	if(valor==3){

		mensaje=acentos('&iexcl;Cambio Rechazado, <br>La clave posee un error, Comuniquese con el administrador del sistema!')
		$("#mensa").addClass('fallo');
		$('#mensa').html(mensaje);
	}
		
	setTimeout(function(){$(".escuela").fadeOut(6000);},1000); 
}); 
</script>