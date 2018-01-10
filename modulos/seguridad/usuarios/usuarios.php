<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ciudadanos</title>
</head>
<body>
<form action="../../../nprivilegio.php" name="ilegal" id="ilegal" method="post">
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
require("bil.php");


if (!isset($_SESSION["spam"]))
    $_SESSION["spam"] = rand(1, 99999999);
	if ((isset($_POST["spam"]) && isset($_SESSION["spam"])) && $_POST["spam"] == $_SESSION["spam"]) 
		{
		$var_accion = stripslashes($_POST["accion"]);
			if(isset($_POST["accion"]))
			{
				switch($_POST["accion"])
				{
					case "Registrar":
						$nombres = stripslashes($_POST["nombres"]);
						$apellidos = stripslashes($_POST["apellidos"]);					
						$cedula = stripslashes($_POST["cedula"]);
						$guarusuario = stripslashes($_POST["usuario"]);
						$clave = stripslashes($_POST["cclave"]);
						$guarestatus = stripslashes($_POST["estatus"]);						

/*						function obtenerIP(){ 
							if ($_SERVER) {
								if ( $_SERVER["HTTP_X_FORWARDED_FOR"] ) {
									$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
								} elseif ( $_SERVER["HTTP_CLIENT_IP"] ) {
									$realip = $_SERVER["HTTP_CLIENT_IP"];
								} else {
									$realip = $_SERVER["REMOTE_ADDR"];
								}
							} else {
								if ( getenv( "HTTP_X_FORWARDED_FOR" ) ) {
									$realip = getenv( "HTTP_X_FORWARDED_FOR" );
								} elseif ( getenv( "HTTP_CLIENT_IP" ) ) {
									$realip = getenv( "HTTP_CLIENT_IP" );
								} else {
									$realip = getenv( "REMOTE_ADDR" );
								}
							}
							return $realip;
						}*/						
							$search = new Recordset();
							$search->sql = "SELECT * FROM seg_usuario WHERE usuario = '".$guarusuario."'";
							$search->abrir();
							if($search->total_registros == 0)
							{
								$ins = new Recordset();
								$ins->sql = "INSERT INTO seg_usuario(cedula, nombres, apellidos, usuario, clave, estatus, power_administrator, ip, fecha_registro, campo )
												VALUES ('".$cedula."', '".$nombres."', '".$apellidos."', '".$guarusuario."', md5(\"".$clave."\"), ".$guarestatus.", 0, '".$realip."', '".date("Y-m-d")."', 'aW1hZ2VzL3RvcGUucG5n' )";
								$ins->abrir();
								$ins->cerrar();
								unset($ins);		
								/*bitacora*/ 
									$descrp_bitacora="C&eacute;dula: ".$cedula.", Nombre y Apellido: ".$nombres.", ".$apellidos.", usuario: ".$guarusuario.", Estatus: ".$guarestatus.", ip: ".$realip;
									bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Usuario","Se registro un Usuario con los siguientes datos: '".$descrp_bitacora."'.");
								/*bitacora*/ 

								$rsusuario = new Recordset();
								$rsusuario->sql = "SELECT id_usuario FROM seg_usuario order by id_usuario desc limit 1";
								$rsusuario->abrir();
									if($rsusuario->total_registros != 0)
									{
										$rsusuario->siguiente();								
										$idsusu = $rsusuario->fila["id_usuario"]; 
									}
								$rsusuario->cerrar();
								unset($rsusuario);								
								
								$agre = new Recordset();
								$agre->sql = "SELECT id_modulo FROM seg_modulo WHERE id_modulo <> 1 ORDER BY id_modulo ASC";
								$agre->abrir();
								if($agre->total_registros != 0)
								{								
									for ($n=0; $n < $agre->total_registros; $n++)
									{
										$agre->siguiente();
										if($sqqll==""){
											$sqqll = "($idsusu,".$agre->fila["id_modulo"].")";
										} else {
											$sqqll = $sqqll.", ($idsusu,".$agre->fila["id_modulo"].")";
										}
									} 

									$inc = new Recordset();
									$inc->sql = "INSERT INTO seg_acceso_modulo (id_usuario, id_modulo) VALUE $sqqll";
									$inc->abrir();
									$inc->cerrar();
									unset($inc);									
									
								}
								$mensaje = 1;															
							} else {
								$mensaje = 2;
							}
							
						
					break;
					case "Modificar":
						if (isset($_POST["id_usuario"]) && $_POST["id_usuario"]!=""){
							$rsagregar1 = new Recordset();
							$rsagregar1->sql = "SELECT cedula, nombres, apellidos, estatus, usuario FROM seg_usuario WHERE id_usuario = '".$_POST["id_usuario"]."'";
							$rsagregar1->abrir();
							if($rsagregar1->total_registros != 0)
							{
								$rsagregar1->siguiente();
								$rsverif= new Recordset();
								$rsverif->sql = "SELECT seg_bitacora.`id_bitacora` FROM seg_bitacora WHERE usuario = '".$rsagregar1->fila["usuario"]."'";
								$rsverif->abrir();
									if($rsverif->total_registros == 0)
									{

										$consul = "";
										if (strcasecmp($rsagregar1->fila["cedula"],stripslashes($_POST["cedula"])) != 0)
											{
												
												$consul = "cedula = '".trim(stripslashes($_POST["cedula"]))."'";
												$bi = "cedula=".stripslashes($_POST["cedula"]).", ";
											}
		
										if (strcasecmp($rsagregar1->fila["nombres"],stripslashes($_POST["nombres"])) != 0)
											{
												
												if ($consul!=""){
													$consul = $consul .", nombres = '".trim(stripslashes($_POST["nombres"]))."'";
												} else { 
													$consul = "nombres = '".trim(stripslashes($_POST["nombres"]))."'";
												}										
												$bi = "nombres=".stripslashes($_POST["nombres"]).", ";
												
											}
											
										if (strcasecmp($rsagregar1->fila["usuario"],stripslashes($_POST["usuario"])) != 0)
											{
												
												if ($consul!=""){
													$consul = $consul .", usuario = '".trim(stripslashes($_POST["usuario"]))."'";
												} else { 
													$consul = "usuario = '".trim(stripslashes($_POST["usuario"]))."'";
												}										
												$bi = "usuario=".stripslashes($_POST["usuario"]).", ";
												
											}											
		
										if (strcasecmp($rsagregar1->fila["apellidos"],stripslashes($_POST["apellidos"])) != 0)
											{
												
												if ($consul!=""){
													$consul = $consul . ", apellidos = '".trim(stripslashes($_POST["apellidos"]))."'";
												} else { 
													$consul = "apellidos = '".trim(stripslashes($_POST["apellidos"]))."'";
												}										
												$bi = "apellidos=".stripslashes($_POST["apellidos"]).", ";
											}
											
										if (strcasecmp($rsagregar1->fila["estatus"],stripslashes($_POST["estatus"])) != 0)
											{
												
												if ($consul!=""){
													$consul = $consul . ", estatus = '".trim(stripslashes($_POST["estatus"]))."'";
												} else { 
													$consul = "estatus = '".trim(stripslashes($_POST["estatus"]))."'";
												}																
												$bi = "estatus=".stripslashes($_POST["estatus"]).", ";
											}
											
										if ($consul!="")
											{
												$consul = $consul . ", clave = md5(\"".trim(stripslashes($_POST["cclave"]))."\")";
											} else { 
												$consul = "clave = md5(\"".trim(stripslashes($_POST["cclave"]))."\")";
											}																
											$bi = "clave=".stripslashes($_POST["cclave"]).", ";
												
						
											$rsagregar2 = new Recordset();
											$rsagregar2->sql = "UPDATE seg_usuario SET $consul WHERE (id_usuario = ".$_POST["id_usuario"].");";
											$rsagregar2->abrir();
											$mensaje = 4;
											bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Modificaci&oacute;n del Usuario", "Se modific&oacute; el Usuario identificado n&uacute;mero: &ldquo;(".stripslashes($_POST["id_usuario"]).")&rdquo; Los datos modificados fueron: $bi");
											$rsagregar2->cerrar();
											unset($rsagregar2);

									} else {
										$consul = "";											
										if (strcasecmp($rsagregar1->fila["estatus"],stripslashes($_POST["estatus"])) != 0)
											{
												
												if ($consul!=""){
													$consul = $consul . ", estatus = '".trim(stripslashes($_POST["estatus"]))."'";
												} else { 
													$consul = "estatus = '".trim(stripslashes($_POST["estatus"]))."'";
												}																
												$bi = "estatus=".stripslashes($_POST["estatus"]).", ";
											}
											
										if ($consul!="")
											{
												$consul = $consul . ", clave = md5(\"".trim(stripslashes($_POST["cclave"]))."\")";
											} else { 
												$consul = "clave = md5(\"".trim(stripslashes($_POST["cclave"]))."\")";
											}																
											$bi = "clave=".md5($_POST["cclave"]).", ";
											$rsagregar2 = new Recordset();
											$rsagregar2->sql = "UPDATE seg_usuario SET $consul WHERE (id_usuario = ".$_POST["id_usuario"].");";
											$rsagregar2->abrir();
											$mensaje = 4;
											bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Modificaci&oacute;n del Usuario", "Se modific&oacute; el Usuario identificado n&uacute;mero: &ldquo;(".stripslashes($_POST["id_usuario"]).")&rdquo; Los datos modificados fueron: $bi");
											$rsagregar2->cerrar();
											unset($rsagregar2);
									}	
							} else {
								$mensaje = 3;
							}
							$rsagregar1->cerrar();
							unset($rsagregar1);
						} else {
								$mensaje = 5;
						}
					break;	

					case "Eliminar":
						if (isset($_POST["id_usuario"]) && stripslashes($_POST["id_usuario"])!="")
						{					
							$rsbus = new Recordset();
							$rsbus->sql = "SELECT usuario FROM seg_usuario WHERE id_usuario = '".$_POST["id_usuario"]."'";
							$rsbus->abrir();
							if($rsbus->total_registros != 0)
							{
								$rsbus->siguiente();
								$fgh = $rsbus->fila["usuario"];							
							}
							$rsbus->cerrar();
							unset($rsbus);

							$rsverif= new Recordset();
							$rsverif->sql = "SELECT seg_bitacora.`id_bitacora` FROM seg_bitacora WHERE usuario = '$fgh'"; 
							$rsverif->abrir();
							if($rsverif->total_registros == 0){
							
								$rsinsert= new Recordset();
								$rsinsert->sql = "DELETE FROM seg_usuario WHERE id_usuario = '".stripslashes($_POST["id_usuario"])."'";
								$rsinsert->abrir();
								bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Eliminaci&oacute;n del Usuario", "Se elimin&oacute; el Usuario &rdquo;".stripslashes($_POST["id_usuario"])."&bdquo;");
								$mensaje = "6";
							
							}else{
								$mensaje = "7";
							}
						} else {
							$mensaje = "8";
						}
					break;
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
					<td class="titulomenu" valign="middle">Registro Usuarios</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="pintar_linea" /></td>
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
							<form action="" method="post" name="form_usu" id="form_usu" autocomplete="off">
							<input type="hidden"  name="spam" value="<? echo $_SESSION["spam"]; ?>"/>
							<input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" />
							<table align="center" border="0" cellspacing="3"  cellpadding="2" class="b_table_b">			
								<tr>
									<td colspan="3" align="center" height="30px">
										<input type="hidden" name="ms" id="ms" value="<? echo $mensaje; ?>"/>
										<div id="mensa"  name="mensa" class="escuela" style="width:100%;float:center; font-size:12px;font-weight:bold;"></div>									</td>
								</tr>	
                                <tr >
                                    <td align="right" height="20" width="150">
										Nombre:                                    </td>
									<td colspan="4"  width="200">
										<input type="text" name="nombres" style="width:170px" id="nombres" />									</td>
								</tr>

								<tr>
                                    <td align="right" height="20">
										Apellido:                                    </td>
									<td colspan="4">
										<input type="text" name="apellidos" id="apellidos" style="width:170px" onkeypress="enviar_on(this.value);"  />									</td>
                                </tr>

                                <tr >
                                    <td align="right" height="20">
										C&eacute;dula:                                    </td>
									<td colspan="4">
										<input type="text" name="cedula" id="cedula" style="width:170px" onkeypress="enviar_on(this.value);"/>&nbsp;<span style="font-size:9px">Ejm. 10123456</span>									</td>
								</tr>

								<tr>
                                    <td align="right" height="20">
										Usuario:                                    </td>
									<td colspan="5"><input type="text" name="usuario" id="usuario" style="width:170px" readonly="true"/></td>
                                </tr>								
								
                                <tr >
                                    <td align="right" height="20">
										Clave:                                    </td>
									<td width="55px">
										<input type="password" name="cclave" id="cclave" style="width:90px" maxlength="12" onkeypress="return validar(event,numeros+letras)"/>									</td>
									<td rowspan="2" valign="top">
										<span style="font-size:9px">
											<div id="contenedor_btn" style="width:150px; height:30px" align="center">Clave acepta caracteres alfanum&eacute;ricos, M&iacute;nimo 6 M&aacute;ximo 12.</div>
										</span>									</td>
                                </tr>
								<tr>
									<td align="right" height="20">
										Repetir Clave:                                    </td>
									<td width="95px">
										<input type="password"  name="rep_clave" id="rep_clave" style="width:90px" maxlength="12" onkeypress="return validar(event,numeros+letras)"/>									</td>
								</tr>
                                <tr >
                                    <td align="right" height="20">
										Estatus:                                    </td>
									<td>
										<select name="estatus" id="estatus" style="width:174px">
											<option></option>
											<option value="1" selected="selected">Activo</option>
											<option value="0">Inactivo</option>																						
										</select>									</td>
                                </tr>
								<tr><td height="20"></td></tr>
								<tr><td height="5" colspan="5" align="right" class="mensaje">Todos los Campos son obligatorios</td></tr>																
								<tr><td height="30" colspan="5"></td></tr>								
								<tr>
									<td align="center" colspan="5">
										<input type="hidden" name="accion" id="accion" />
										<input type="hidden" name="id_usuario" id="id_usuario" />
										<input type="button" name="registrar" id="registrar" value="Registrar" title="Registrar" onclick="subb();" />
										&nbsp;
										<input type="button" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" />										
										&nbsp;
										<input type="button" name="buscar" id="buscar" value="Buscar" title="Buscar" onclick="displayMessage('modulos/seguridad/usuarios/bsq.php','750','500');" />																				
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
<? echo '<script language="javascript" type="text/javascript">cargar_lista("'.'modulos/seguridad/usuarios/usuarios_d.php?pagina=1'.'");</script>'; ?>
<script language="javascript" type="text/javascript">
$(document).ready(function()
{
	valor=$('#ms').val();
	if(valor==1){

		mensaje=acentos('&iexcl;El Usuario ha sido registrado exitosamente!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}
    
	if(valor==2){

		mensaje=acentos('&iexcl;Registro Rechazado, el Usuario ha sido registrado anteriormente!')
		$("#mensa").addClass('fallo');
		$('#mensa').html(mensaje);
	}
	
	if(valor==3){

		mensaje=acentos('&iexcl;Actualizaci&oacute;n Fallida, el Usuario ya se encuentra registrado!')
		$("#mensa").addClass('fallo');
		$('#mensa').html(mensaje);
	}	
	
	if(valor==4){

		mensaje=acentos('&iexcl;Actualizaci&oacute;n Exitosa, el Usuario fue registrado exitosamente!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}		
	
	if(valor==5){

		mensaje=acentos('&iexcl;Verifique, No ha realizado ningun cambio sobre el registro seleccionado!')
		$("#mensa").addClass('alerta');
		$('#mensa').html(mensaje);
	}		
	
	if(valor==6){

		mensaje=acentos('&iexcl;Eliminaci&oacute;n del Usuario exitosa!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}		
	
	if(valor==7){

		mensaje=acentos('&iexcl;El Usuario no se elimino por estar vinculado con otra entidad!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}
	
	if(valor==8){

		mensaje=acentos('&iexcl;Verifique, No ha realizado ninguna eliminaci&oacute;n del Usuario!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}
	
	if(valor==9){

		mensaje=acentos('&iexcl;El Usuario no se modific&oacute; por tener registros en la Bitacora del Sistema!')
		$("#mensa").addClass('alerta');
		$('#mensa').html(mensaje);
	}			
	setTimeout(function(){$(".escuela").fadeOut(6000);},1000); 


});	
</script>