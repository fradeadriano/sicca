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

if (!isset($_SESSION["spam"]))
    $_SESSION["spam"] = rand(1, 99999999);
	if ((isset($_POST["spam"]) && isset($_SESSION["spam"])) && $_POST["spam"] == $_SESSION["spam"]) 
		{
			$correspondencia = stripslashes($_POST["correspondencia"]);
			if($correspondencia!="" && $correspondencia=="tip_inst")
				{
					$n_documento = stripslashes($_POST["n_documento"]);
					$id_organismo = stripslashes($_POST["id_organismo"]);
					$fe_documento = stripslashes($_POST["fe_documento"]);				
					$respuesta = stripslashes($_POST["respuesta"]);
					if ($respuesta!="" && $respuesta == "rsp_positiva"){
						$correlativo_padre = $_POST["correlativo_padre"];
					}
				}
			$remitente = stripslashes($_POST["remitente"]);
			$tipo_documento = stripslashes($_POST["tipo_documento"]);
			$fe_recepcion = stripslashes($_POST["fe_recepcion"]);
			$ho_documento = stripslashes($_POST["ho_documento"]);
			$doc_anexo = stripslashes($_POST["doc_anexo"]);
			$observacion = stripslashes($_POST["observacion"]);
			$accion = stripslashes($_POST["accion"]);
			if(isset($accion) && $accion!=""){
				$search = new Recordset();
				$search->sql = "SELECT rec_visitante.visitante, rec_visitante.id_visitante, rec_visitante.cedula, rec_visitante.telefono, organismo.organismo, organismo.id_organismo, unidad.unidad, rec_visita.id_unidad
								FROM rec_visitante  LEFT JOIN rec_visita ON (rec_visitante.id_visitante = rec_visita.id_visitante) 
													LEFT JOIN organismo  ON (rec_visita.id_organismo = organismo.id_organismo) 
													LEFT JOIN unidad ON (rec_visita.id_unidad = unidad.id_unidad)
								WHERE rec_visitante.cedula = '".$qdate."' ORDER BY rec_visita.id_visita DESC LIMIT 1";
					$search->abrir();
					if($search->total_registros != 0)
					{
						$search->siguiente();
						
										
						$insert = new Recordset();
						$insert->sql = "insert into rec_visita (id_visitante, fecha, hora, id_unidad, id_organismo, motivo) values ('".$id_visitante."', '".date('Y-m-d')."', '".date('H:i:s')."', '".$unidad."', '".$id_organismo."', '".$accion."');";
						$insert->abrir();
						$insert->cerrar();
						unset($insert);		
						unset($_POST["id_visitante"]); unset($_POST["id_organismo"]); unset($_POST["unidad"]); unset($_POST["motivo"]); unset($_POST["accion"]);
						/*bitacora*/bitacora ($_SESSION["usuario"],date("Y-m-d"),date("h:i:s"),"Registro de visita: El visitante identificado con el &deg; ".$id_visitante.", proveniente del organ&iacute;smo con el &deg;:".$id_organismo.", visit&oacute; la unidad: ".$unidad." de la Contraloria del estado Aragua, con motivo de: ".$accion);		
					}
			
			}
			$_SESSION["spam"] = rand(1, 99999999);
		} else {
			$_SESSION["spam"] = rand(1, 99999999);
		}

?>
<script type="text/javascript" src="librerias/jq.js"></script>
<script type="text/javascript" src="librerias/jquery.autocomplete.js"></script>
<table border="0" align="center" width="700">
<!--	<tr>
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="40px"><img src="images/recepcion.png"/></td>
					<td class="titulomenu" valign="middle">Recepci&oacute;n Correspondencia</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>-->
	<tr>
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="60px"><img src="images/1recepcion.png"/></td>
					<td class="titulomenu" valign="middle">Recepci&oacute;n Correspondencia CGR</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td align="center">
			<form method="post" name="recep" id="recep"><input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" />
			<table width="99%" border="0" class="b_table" cellpadding="2" cellspacing="0">
				<tr><td height="10" colspan="2"></td></tr>				
				<tr> 
					<td width="20"></td>				
					<td align="right"  width="180">N&deg; Oficio / Circular:&nbsp;</td>
					<td><input type="text" name="n_documento" id="n_documento" onkeypress="return validar(event,numeros+'-')">&nbsp;<span class="mensaje">*</span></td>					
				</tr>							
				<tr><td height="5" colspan="3"></td></tr>
				<tr>
					<td width="20"></td>				
					<td align="right" valign="top">Direcci&oacute;n Remitente:&nbsp;</td>
					<td>
						<textarea name="direcc_remitente" id="direcc_remitente" style="width:300px; height:30px;" ></textarea>&nbsp;<span class="mensaje">*</span>
						<input type="hidden" name="id_direcc_remitente" id="id_direcc_remitente" value="<? echo $search->fila["id_organismo"]; ?>"  />
						<? 
/*						$rsun = new Recordset();
						$rsun->sql = "SELECT id_organismo, organismo FROM organismo"; 
						$rsun->llenarcombo($opciones = "\"unidad\"", $checked = "", $fukcion = "" , $diam = "style=\"width:300px; Height:20px;\""); 
						$rsun->cerrar(); 
						unset($rsun);	*/																					
						?>					</td>					
				</tr>		
				<tr><td height="8" colspan="2"></td></tr>			
				<tr>
					<td width="20"></td>				
					<td align="right">Fecha:&nbsp;</td>
					<td><input type="text" name="fe_documento" id="fe_documento" onkeyup="this.value=formateafecha(this.value,'2014','2014');">&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span></td>					
				</tr>
				<tr style="display:none"><td height="8" colspan="3"></td></tr>
				<tr><td height="8" colspan="3"></td></tr>
				<tr>
					<td width="20"></td>				
					<td align="right">Tipo Comunicaci&oacute;n:&nbsp;</td>
					<td>
						<? 
						$rsun = new Recordset();
						$rsun->sql = "SELECT id_tipo_documento, tipo_documento FROM tipo_documento WHERE cgr = 1 order by tipo_documento"; 
						$rsun->llenarcombo($opciones = "\"tcomunicacion\"", $checked = "", $fukcion = "onchange=\"campos(this.value)\"" , $diam = "style=\"width:135px; Height:20px;\""); 
						$rsun->cerrar(); 
						unset($rsun);																						
						?>&nbsp;<span class="mensaje">*</span>
					</td>					
				</tr>
				<tr id="espacio" style="display:none"><td height="8" colspan="3"></td></tr>
				<tr id="di_notificacion" style="display:none">
					<td width="20"></td>
					<td id="a" valign="top">
						<table align="center" border="0"  class="b_table" bgcolor="#F5F5F5">
							<tr>
								<td>
									<table border="0" align="left"  cellpadding="0" cellspacing="0">
										<tr>
											<td>
												Organ&iacute;smo&nbsp;<input type="radio" name="noti" id="notiOrga" checked="checked" onclick="ocultar_selec(this.id);"/>&nbsp;
												Ciudadano&nbsp;<input type="radio" name="noti" id="notiCiu" onclick="ocultar_selec(this.id);"/>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr><TD height="8"></TD></tr>
							<tr>
								<td>
									<table border="0" align="left" cellpadding="0" cellspacing="0">
										<tr>
											<td width="100" valign="top" align="right">
												N&deg; Notificaci&oacute;n:&nbsp;								
											</td>
											<td width="320">
												<input type="text" name="n_notificacion" id="n_notificacion" />&nbsp;<span class="mensaje">*</span>
											</td>
										</tr>
										<tr><td height="8" colspan="2"></td></tr>									
										<tr id="div_organismo" style="display:">
											<td width="90" valign="top" align="right">Organ&iacute;smo:&nbsp;</td>
											<td >
												<textarea name="organismo" id="organismo" style="width:300px; height:40px;" ></textarea>&nbsp;<span class="mensaje">*</span>
												<input type="hidden" name="id_organismo" id="id_organismo" value="<? echo $search->fila["id_organismo"]; ?>"  />								
											</td>
										</tr>										
										<tr>
											<td id="div_ciudadano" style="display:none" align="center" colspan="2">
												<table cellpadding="0" cellspacing="0" width="100%" border="0">
													<tr>
														<td width="100" align="right">Nombre:&nbsp;</td>
														<td>
															<input type="text" maxlength="40" name="ciudadano" id="ciudadano" onkeypress="return validar(event,letras)" style="width:180px"/>&nbsp;<span class="mensaje">*</span>
														</td>
													</tr>
													<tr><td height="8"></td></tr>								
													<tr>
														<td valign="top" align="right">Direcci&oacute;n:&nbsp;</td>
														<td>
															<textarea name="direccion" id="telefono" style="width:300px; height:50px" onkeyup="return maximaLongitud(this.id,200);"></textarea>&nbsp;<span class="mensaje">*</span>
															<br /><span style="font-size:9px">M&aacute;ximo 200 Caracteres</span>
														</td>
													</tr>
													<tr><td height="8"></td></tr>																		
													<tr>
														<td valign="top" align="right">Tel&eacute;fono:&nbsp;</td>
														<td>
															<input type="text" name="telefono" id="telefono" onkeypress="return validar(event,numeros+'-')" maxlength="12" onkeyup="mascara(this,'-',p_telefonico,false)" style="width:120px"/>&nbsp;<span class="mensaje">*</span>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr><TD height="8"></TD></tr>
						</table>
					</td> 
				</tr>				
				<tr id="di_respuesta" style="display:none">
					<td width="20"></td>
					<td align="right" valign="botton">
						Respuesta N&deg;:&nbsp;
					</td>
					<td align="left">
						<input type="text" name="fecha_resp" id="fecha_resp" maxlength="10" onkeypress="return validar(event,numeros)"/>&nbsp;<span class="mensaje">*</span>
					</td>										
				</tr>
				<tr id="espacio2" style="display:none"><td height="8" colspan="3"></td></tr>								
				<tr id="di_solicitud" style="display:none">
					<td width="20"></td>
					<td align="right" valign="botton">
						Unidad Administrativa:&nbsp;					</td>
					<td align="left">
					<? 
						$rsun = new Recordset();
						$rsun->sql = "SELECT id_unidad, unidad FROM unidad"; 
						$rsun->llenarcombo($opciones = "\"unidad\"", $checked = $search->fila["id_unidad"], $fukcion = "" , $diam = "style=\"width:304px; Height:20px;\""); 
						$rsun->cerrar(); 
						unset($rsun);								
					?>&nbsp;<span class="mensaje">*</span></td>										
				</tr>				
				<tr id="espacio1" style="display:none"><td height="8" colspan="3"></td></tr>				
				<tr id="di_plazo" style="display:none">
					<td width="20"></td>
					<td align="right">
						Plazo:					
					</td>
					<td>
						<input type="text" name="plazo" id="plazo" onkeypress="return validar(event,numeros)" maxlength="2"  />&nbsp;<span class="mensaje">*</span>					
					</td>
				</tr>				
				<tr><td height="8" valign="middle" colspan="3"></td></tr>
				<tr>
					<td width="20"></td>				
					<td align="right" valign="top">Observaci&oacute;n:&nbsp;</td>
					<td><textarea name="observacion" id="observacion" style="width:300px; height:110px" onkeyup="return maximaLongitud(this.id,300);"></textarea>					  &nbsp;<span class="mensaje">*</span><br />
				  <span style="font-size:9px">M&aacute;ximo 300 Caracteres</span></td></tr>									
				<tr><td height="8" colspan="3"></td></tr>
				<tr>
					<td width="20"></td>				
					<td align="right" valign="botton">Con Anexo:&nbsp;</td>
					<td>Si&nbsp;<input type="radio" name="anex" id="SiAnex" onclick="vee_anex(this.id);"/>&nbsp;&nbsp;No&nbsp;<input type="radio" name="anex" id="NoAnex" checked="checked" onclick="vee_anex(this.id);"/></td>					
				</tr>	
				<tr id="danex1" style="display:none">
					<td height="8" colspan="3"></td>
				</tr>				
				<tr id="danex2" style="display:none">
					<td width="20"></td>				
					<td align="right" valign="top">Especifique los Anexos:</td>
					<td>
						<textarea name="listAnexo" id="listAnexo" style="width:300px; height:100px" onKeyUp="return maximaLongitud(this.id,300);"></textarea>&nbsp;<span class="mensaje">*</span>
						<br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span>
					</td>					
				</tr>					
				<tr><td height="20" colspan="3"></td></tr>
				<tr><td colspan="3" align="right" class="mensaje">* Campos Obligatorios&nbsp;&nbsp;</td></tr>														
				<tr><td height="20" colspan="2"></td></tr>				
				<tr>
					<td colspan="3" align="center">
						<input type="button" name="registrar" id="registrar" value="Registrar" title="Registrar" onclick="doit(this.id);" />					
						&nbsp;								
						<input type="button" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" onclick="cancelarT();" />					</td>
				</tr>
				<tr><td height="10" colspan="2"></td></tr>				
			</table>
			<input type="hidden" name="accion" id="accion" /><input type="hidden"  name="spam" value="<? echo $_SESSION["spam"]; ?>"/>
			</form>
		</td>
	</tr>
	<tr><td height="30"></td></tr>
</table>
<script language="javascript" type="text/javascript">
	$("#direcc_remitente").autocomplete("modulos/correspondencia/cgr/recepcion/lista.php?op=ccgr", { 
		width: 300,
		matchContains: true,
		mustMatch: false,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});

	$("#direcc_remitente").result(function(event, data, formatted) {
		try {
			$("#id_direcc_remitente").val(data[1]);
		} catch(e) {
			e.name;		
		}
	});
	
	$("#organismo").autocomplete("modulos/correspondencia/cgr/recepcion/lista.php?op=ext", { 
		width: 300,
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
