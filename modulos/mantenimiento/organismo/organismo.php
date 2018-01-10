<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado de Organismos</title>
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


if (!isset($_SESSION["spam"]))
    $_SESSION["spam"] = rand(1, 99999999);
	if ((isset($_POST["spam"]) && isset($_SESSION["spam"])) && $_POST["spam"] == $_SESSION["spam"]) 
		{
			$var_accion = stripslashes($_POST["accion"]);
			if(isset($var_accion) && $var_accion=="registrar")
				{		
					$var_orga = stripslashes($_POST["organismo"]);
					$search = new Recordset();
					$search->sql = "SELECT organismo.id_organismo FROM organismo WHERE organismo.organismo = '".$var_orga."'";
						$search->abrir();
						if($search->total_registros == 0)
						{
							$ins = new Recordset();
							$ins->sql = "INSERT INTO organismo (organismo)"." VALUES ('$var_orga')";
							$ins->abrir();
							$ins->cerrar();
							unset($ins);		
							/*bitacora*/bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Organismo","Se registro un organismo denominado: '".$var_orga."'.");
							$mensaje = 1;															
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
					<td width="45px"><img src="images/usuario.png"/></td>
					<td class="titulomenu" valign="middle">Registro Organismo</td>
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
						<legend class="titulomenu">&nbsp;Datos del Organismo</legend>
							<form action="" method="post" name="form_or" id="form_or" autocomplete="off">
							<input type="hidden"  name="spam" value="<? echo $_SESSION["spam"]; ?>"/>
							<input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" />
							<table align="center" width="80%"  border="0" cellspacing="0"  cellpadding="2">			
								<tr>
									<td colspan="2" align="center">
										<input type="hidden"  name="ms" id="ms" value="<? echo $mensaje; ?>"/>
										<div id="mensa"  name="mensa" class="escuela" style="width:100%;float:center; font-size:12px;font-weight:bold;"></div>                                    
									</td>
								</tr>
								<tr>
									<td height="15px" colspan="5">
									</td>
								</tr>	
                                <tr >
                                    <td align="right" height="20" width="140" valign="top">
										Organismo:                                  
                                    </td>
									<td>
										<textarea name="organismo" id="organismo" onblur="formatotexto(this);" style="width:300px; height:50px"></textarea>
									</td>
                                </tr>
								<tr><td height="20"></td></tr>
								<tr><td height="5" colspan="5" align="right" class="mensaje">Todos los Campos son obligatorios</td></tr>																
								<tr><td height="30" colspan="5"></td></tr>								
								<tr>
									<td align="center" colspan="5">
										<input type="hidden" name="accion" id="accion" />
										<input type="button" name="registrar" id="registrar" value="Registrar" title="Registrar" onclick="subb(this.id);" />
										&nbsp;
										<input type="reset" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" />										
<!--										&nbsp;
										<input type="button" name="buscar" id="buscar" value="Buscar" title="Buscar" />	-->																			
									</td>
								</tr>																																								
							</table>
							</form>
							<BR /><BR />
							<table class="b_table" align="center" width="90%">
								<tr>
									<td id="listusuarios">
									</td>
								</tr>
							</table>
							<BR />									
						</fieldset>						
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? echo '<script language="javascript" type="text/javascript">cargar_lista("'.'modulos/mantenimiento/organismo/organismo_d.php?pagina=1'.'");</script>'; ?>
<script language="javascript" type="text/javascript">
$(document).ready(function()
{
	valor=$('#ms').val();
	if(valor==1){
		mensaje=acentos('&iexcl;El Organismo ha sido registrado exitosamente!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}
    
	if(valor==2){
		mensaje=acentos('&iexcl;Registro Rechazado, este Organismo ha sido registrado anteriormente!')
		$("#mensa").addClass('fallo');
		$('#mensa').html(mensaje);
	}
	setTimeout(function(){$(".escuela").fadeOut(6000);},1000); 
});	
</script>