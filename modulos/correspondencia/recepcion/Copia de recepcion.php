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
	if ((isset($_POST["spam"]) && isset($_SESSION["spam"]) && $_POST["spam"] == $_SESSION["spam"]))
		{
			if(isset($_POST["accion"]) && $_POST["accion"]=="Registrar")
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
/*					if(isset($accion) && $accion!=""){
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
					
					}*/
				}
			$_SESSION["spam"] = rand(1, 99999999);
		} else {
			$_SESSION["spam"] = rand(1, 99999999);
		}
/*setlocale(LC_TIME, 'spanish');
print "<strong style='color: blue;'>".strftime("&nbsp;  %A %#d de %B del %Y")."";*/
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
					<td class="titulomenu" valign="middle">Recepci&oacute;n Correspondencia</td>
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
					<td align="right" width="220">
						Correspondencia:					</td>
					<td>
						Institucional&nbsp;<input type="radio" name="correspondencia" checked="checked" id="institucional" onclick="tipo_corres(this.id);" value="tip_inst">
						Personal&nbsp;<input type="radio" name="correspondencia" id="personal"  onclick="tipo_corres(this.id);">					</td>
				</tr>
				<tr><td height="8" colspan="2" id="secc_institucional6"></td></tr>
				<tr id="secc_institucional2"> 
					<td width="20"></td>				
					<td align="right">N&deg; Documento:&nbsp;</td>
				  <td><input type="text" name="n_documento" id="n_documento" onkeypress="return validar(event,numeros+letras+'-/')"  maxlength="18" />				    &nbsp;<span class="mensaje">*</span></td>					
				</tr>							
				<tr id="secc_institucional5"><td height="8" colspan="3"></td></tr>
				<tr id="secc_institucional3">
					<td width="20"></td>				
					<td align="right" valign="top">Organ&iacute;smo:&nbsp;</td>
					<td>
						<textarea name="organismo" id="organismo" style="width:300px; height:55px;" ></textarea>&nbsp;<span class="mensaje">*</span>
						<input type="text" name="id_organismo" id="id_organismo" value="<? echo $search->fila["id_organismo"]; ?>"  />					</td>					
				</tr>	
				<tr><td height="8" colspan="3"></td></tr>
				<tr>
					<td width="20"></td>				
					<td align="right">Tipo Documento:&nbsp;</td>
					<td>
						<? 
						$rsun = new Recordset();
						$rsun->sql = "SELECT id_tipo_documento, tipo_documento FROM tipo_documento WHERE cgr <> 1 order by tipo_documento"; 
						$rsun->llenarcombo($opciones = "\"tipo_documento\"", $checked = "", $fukcion = "onchange=\"mostrar_ofi(this.value)\"" , $diam = "style=\"width:304px; Height:20px;\""); 
						$rsun->cerrar(); 
						unset($rsun);																						
						?>&nbsp;<span class="mensaje">*</span>					</td>					
				</tr>					
				<tr id="secc_institucional4" style="display:none"><td height="8" colspan="2"></td></tr>
				<tr id="secc_institucional1" style="display:none">
					<td width="20"></td>
					<td align="right" width="220">
						Originado por respuesta:					</td>
					<td>
						Si&nbsp;<input type="radio" name="respuesta" id="positivo" onclick="rpts(this.id);">
						No&nbsp;<input type="radio" name="respuesta" id="negativo" checked="checked" onclick="rpts(this.id);" value="rsp_negativa">	
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="uno" style="display:none">Respuesta Oficio N&deg;:&nbsp;<input type="text" name="correlativo_padre" style="width:50px" id="correlativo_padre" maxlength="6" onkeypress="return validar(event,numeros)" ></span>					</td>
				</tr>	
				<tr id="tres" style="display:none"><td height="8" colspan="2"></td></tr>				
				<tr id="dos" style="display:none">
					<td width="20"></td>
					<td align="right" width="220">
						Tipo Respuesta:					</td>
					<td>
						<? 
						$rsun = new Recordset();
						$rsun->sql = "SELECT id_tipo_respuesta, tipo_respuesta FROM tipo_respuesta order by tipo_respuesta"; 
						$rsun->llenarcombo($opciones = "\"tipo_respuesta\"", $checked = "", $fukcion = "onchange=\"informe(this.value)\"" , $diam = "style=\"width:304px; Height:20px;\""); 
						$rsun->cerrar(); 
						unset($rsun);																						
						?>&nbsp;&nbsp;<span class="mensaje">*</span>					</td>
				</tr>
				<tr id="cuatro" style="display:none"><td height="8" colspan="2"></td></tr>				
				<tr id="cinco" style="display:none">
					<td width="20"></td>
					<td align="right" width="220">
						Ejercicio Fiscal:					</td>
					<td>
						<? 
							$anno = date('Y');
							$list = $anno-5;
							for ($i = $list; $i<=$anno-1;$i++){
								echo  "<input type=\"checkbox\" name=\"$i\" id=\"$i\" onclick=\"va();\" />$i&nbsp;";
							}															
						?><span class="mensaje">*</span>					</td>
				</tr>
				<tr id="seis" style="display:none"><td height="8" colspan="2"></td></tr>	
				<tr id="siete" style="display:none">
					<td width="20"></td>
					<td align="right" width="220">
						Gaceta N&deg;:					</td>
					<td>
						<input type="text" name="n_gaceta" id="n_gaceta" maxlength="10" onkeypress="return validar(event,numeros+'.')"  />
						<span class="mensaje">*</span>					</td>
				</tr>	
				<tr id="ocho" style="display:none"><td height="8" colspan="2"></td></tr>
				<tr id="nueve" style="display:none">
					<td width="20"></td>
					<td align="right" width="220">
						Fecha:					</td>
					<td>
						<input type="text" name="f_gaceta" id="f_gaceta" onkeyup="this.value=formateafecha(this.value);"/>
						<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span>					</td>
				</tr>		
				<tr id="diez" style="display:none"><td height="8" colspan="2"></td></tr>				
				<tr id="once" style="display:none">
					<td width="20"></td>
					<td align="right" width="220">
						Gaceta:					</td>
					<td>
						Ordinaria&nbsp;<input type="radio" name="tipo_gaceta" id="ordinaria" checked="checked" />&nbsp;&nbsp;&nbsp;
						Extraordinaria&nbsp;<input type="radio" name="tipo_gaceta" id="extraordinaria" />					</td>
				</tr>															
				<tr><td height="8" colspan="2"></td></tr>								
				<tr id="secc_institucional9">
					<td width="20"></td>				
					<td align="right">Fecha Documento:&nbsp;</td>
					<td><input type="text" name="fe_documento" id="fe_documento" onkeyup="this.value=formateafecha(this.value);">&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span></td>					
				</tr>
				<tr id="secc_institucional8" style="display:none"><td height="8" colspan="3"></td></tr>
				<tr id="secc_institucional7" style="display:none">
					<td width="20"></td>				
					<td align="right"  width="180">Remitente:&nbsp;</td>
					<td><input type="text" name="remitente" id="remitente" style="width:300px" onkeypress="return validar(event,letras)" maxlength="190">&nbsp;<span class="mensaje">*</span></td>					
				</tr>
 <!--<hr style="width:450px; color:#DFDFDF;"/>-->
<!--				<tr><td height="8" valign="middle" colspan="3"></td></tr>
				<tr>
					<td width="20"></td>				
					<td align="right">Fecha Recepci&oacute;n:&nbsp;</td>
					<td><!--<input type="text" name="fecha_desde" id="fecha_desde" />&nbsp;<img title="Buscar Fecha" style="cursor:pointer" src="images/help1.png" align="absmiddle" onclick="pickDate(this,document.getElementById('fecha_desde'));" />
					<input type="text" name="fe_recepcion" id="fe_recepcion" value="<? echo date('d/m/Y'); ?>" onkeyup="this.value=formateafecha(this.value);">&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(01/05/2012)</span></td>					
				</tr>											
				<tr><td height="8" colspan="3"></td></tr>
				<tr>
					<td width="20"></td>				
					<td align="right">Hora Recepci&oacute;n:&nbsp;</td>
					<td><input type="text" name="ho_documento" id="ho_documento" value="<? echo date('h:i'); ?>" onkeypress="return validar(event,numeros+':')" onkeyup="mascara(this,':',p_hora,false)">&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(08:05)</span></td>					
				</tr>-->											
				
				<tr>
					<td width="20"></td>				
					<td align="right" valign="botton">Con Anexo:&nbsp;</td>
					<td>Si&nbsp;<input type="radio" name="anex" id="SiAnex" onclick="vee_anex(this.id);"/>&nbsp;&nbsp;No&nbsp;<input type="radio" name="anex" id="NoAnex" checked="checked" onclick="vee_anex(this.id);"/></td>					
				</tr>	
				<tr id="danex1" style="display:none"><td height="8" colspan="3"></td></tr>
				<tr id="danex2" style="display:none">
					<td width="20"></td>				
					<td align="right" valign="top" width="180">Especifique los Anexos:</td>
					<td>
						<textarea name="listAnexo" id="listAnexo" style="width:300px; height:105px" onKeyUp="return maximaLongitud(this.id,300);"></textarea>&nbsp;<span class="mensaje">*</span>
						<br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span>					</td>					
				</tr>					
				<tr><td height="8" colspan="3"></td></tr>
				<tr>
					<td width="20"></td>				
					<td align="right" valign="top">Observaci&oacute;n:&nbsp;</td>
					<td><textarea name="observacion" id="observacion" style="width:300px; height:105px" onKeyUp="return maximaLongitud(this.id,300);"></textarea>&nbsp;<span class="mensaje">*</span><br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span></td>					
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
	$("#organismo").autocomplete("modulos/correspondencia/recepcion/lista.php", { 
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
