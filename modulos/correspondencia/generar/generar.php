<?
session_start();
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

unset($_SESSION["motivos"]);
unset($_SESSION["anexoss"]);
if (!isset($_SESSION["spam"]))
    $_SESSION["spam"] = rand(1, 99999999);
	if ((isset($_POST["spam"]) && isset($_SESSION["spam"])) && $_POST["spam"] == $_SESSION["spam"]) 
		{
			$esxte = $_POST["n_oficio_ext"];
			if ((isset($esxte) && $esxte !=""))
			{	
				if(ctype_digit($esxte))
				{	
					$nuevooficio = $esxte."-".date('Y');
					$search = new Recordset();
					$search->sql = "SELECT crp_correspondencia_externa.n_oficio_externo FROM crp_correspondencia_externa WHERE crp_correspondencia_externa.n_oficio_externo = '".$esxte."' AND DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%Y') = '".date('Y')."'";
						$search->abrir();
						if($search->total_registros == 0)
						{
							$asig = $_POST["metodo"];
							if(isset($asig) && $asig =="asignar")
							{
								$plaz = $_POST["plazo"];
								//$mensajero = $_POST["mensaje"];
								$salida = $_POST["salid"];

								$f_registro = $_POST["f_registro"];								
								$hhora = date("h:i:s");
								$newfecha = $search->formatofecha($f_registro)." ".$hhora;
								
								$Tip_Documen = $_POST["tipo_documento"];
								$Tip_ofic = $_POST["tipo_informe"];
								$contenido_ofic = $search->codificar(stripslashes($_POST["contenido"]));								
								$almacenar_contenido = $_POST["rep"];								
								$Anexo = $search->codificar(stripslashes($_POST["listAnexo"]));														
								
								if (isset($Anexo) && $Anexo!=""){
									$campos = ", anexos";
									$valor = ", '".$Anexo."'";
									$bita = ". Posee estos anexos: ".$Anexo;						
								}								

								if($almacenar_contenido =="Sirep"){
									$_SESSION["motivos"] = $contenido_ofic;									
									if($Anexo!="")
									{
										$_SESSION["anexoss"] = $Anexo;																		
										$St = "document.getElementById(\"danex2\").style.display=\"\";
										document.getElementById(\"SiAnex\").checked = true; document.getElementById(\"Sirep\").checked = true;";
									}
									
								} else if ($almacenar_contenido =="Norep") {
									unset($_SESSION["motivos"]);
									unset($_SESSION["anexoss"]);									
								}

								$mensaje = 0;	
									if(isset($salida) && $salida =="sel_org") 
									{
										$organis = $_POST["id_organismo_reci"];
//										if((isset($esxte) && $esxte !="") && (isset($mensajero) && $mensajero !=""))

										$searchP = new Recordset();
										/*$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, id_mensajero, n_oficio_externo, plazo, fecha_registro) 
														values('0', '".$mensajero."', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."');";*/
										if($Tip_Documen==1){
											//$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, n_oficio_externo, plazo, fecha_registro, id_documento_cgr, id_documento_cgr_desgloce, contenido $campos) 
											$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, n_oficio_externo, fecha_registro, id_documento_cgr, contenido $campos) 
															values('0', '".$esxte."', '".$newfecha."', $Tip_Documen, '$contenido_ofic' $valor);";															
															//values('0', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."', $Tip_Documen, $Tip_ofic, '$contenido_ofic' $valor);";															
										} else {
											$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, n_oficio_externo, plazo, fecha_registro, id_documento_cgr, contenido $campos) 
															values('0', '".$esxte."', '".$plaz."', '".$newfecha."', $Tip_Documen, '$contenido_ofic' $valor);";																											
															//values('0', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."', $Tip_Documen, '$contenido_ofic' $valor);";																											
										}
										$searchP->abrir();
										$searchP->cerrar();
										unset($searchP);
										
										$searchB = new Recordset();
										$searchB->sql = "SELECT id_correspondencia_externa FROM crp_correspondencia_externa order by id_correspondencia_externa DESC LIMIT 1";
										$searchB->abrir();					
											if($searchB->total_registros != 0)
											{					
												$searchB->siguiente();
												$id_externo = $searchB->fila["id_correspondencia_externa"];	
											}
										$searchB->cerrar();
										unset($searchB);
					
										$searchD = new Recordset();
										$searchD->sql = "insert into crp_correspondencia_externa_det (id_correspondencia_externa,id_organismo) 
														values('".$id_externo."', '".$organis."');";
										$searchD->abrir();
										$searchD->cerrar();
										unset($searchD);
															
										bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia externa'","Registro de Correspondencia externa con oficio n&deg; '".$esxte."'para organismo identificado con '".$organis."' $bita");											
										$mensaje = 1;

									} else if(isset($salida) && $salida =="sel_otro"){
										
										$searchP = new Recordset();
										$desti = $search->codificar(stripslashes($_POST["destina"]));
										/*$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, id_mensajero, n_oficio_externo, plazo, fecha_registro) 
														values('0', '".$mensajero."', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."');";*/
										if($Tip_Documen==1){
											$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, n_oficio_externo, plazo, fecha_registro, id_documento_cgr, id_documento_cgr_desgloce, contenido, destinatario $campos) 
															values('0', '".$esxte."', '".$plaz."', '".$newfecha."', $Tip_Documen, '', '$contenido_ofic', '$desti' $valor);";													
															//values('0', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."', $Tip_Documen, $Tip_ofic, '$contenido_ofic', '$desti' $valor);";													
											} else {																											
											$searchP->sql = "insert into crp_correspondencia_externa (id_recepcion_correspondencia, n_oficio_externo, plazo, fecha_registro, id_documento_cgr, contenido, destinatario $campos)  
															values('0', '".$esxte."', '".$plaz."', '".$newfecha."', $Tip_Documen, '$contenido_ofic', '$desti' $valor);";													
															//values('0', '".$esxte."', '".$plaz."', '".date("Y-m-d H:i:s")."', $Tip_Documen, '$contenido_ofic', '$desti' $valor);";													
											}												
										$searchP->abrir();
										$searchP->cerrar();
										unset($searchP);
										bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia externa'","Registro de Correspondencia externa con oficio n&deg; '".$esxte."'para organismo identificado con '".$organis."' $bita");											
										$mensaje = 1;											

									}
									
									$searchB = new Recordset();
									$searchB->sql = "SELECT id_correspondencia_externa FROM crp_correspondencia_externa order by id_correspondencia_externa DESC LIMIT 1";
									$searchB->abrir();					
										if($searchB->total_registros != 0)
										{					
											$searchB->siguiente();
											$id_externo = $searchB->fila["id_correspondencia_externa"];	
										}
									$searchB->cerrar();
									unset($searchB);
									
									
									$searchDa = new Recordset();
//									$searchDa->sql = "INSERT INTO crp_ruta_correspondencia_ext (id_estatus, id_correspondencia_externa, fecha_recepcion) VALUES (5, $id_externo,'".date("Y-m-d H:i:s")."')";
									$searchDa->sql = "INSERT INTO crp_ruta_correspondencia_ext (id_estatus, id_correspondencia_externa, fecha_recepcion) VALUES (5, $id_externo,'".$newfecha."')";
									$searchDa->abrir();
									$searchDa->cerrar();
									unset($searchDa);									
													

									$searchD = new Recordset();
									$searchD->sql = "DELETE FROM temp";
									$searchD->abrir();
									$searchD->cerrar();
									unset($searchD);
									
							}
						}
				}
			}

			$_SESSION["spam"] = rand(1, 99999999);
		} else {
			$_SESSION["spam"] = rand(1, 99999999);
/*			$searchD = new Recordset();
			$searchD->sql = "DELETE FROM temp";
			$searchD->abrir();
			$searchD->cerrar();
			unset($searchD);*/
		}
$hp = new Recordset();
$hp->sql = "SELECT crp_correspondencia_externa.n_oficio_externo FROM crp_correspondencia_externa WHERE DATE_FORMAT(crp_correspondencia_externa.fecha_registro, '%Y') = '".date('Y')."' ORDER BY crp_correspondencia_externa.id_correspondencia_externa DESC LIMIT 1";			
$hp->abrir();
	if($hp->total_registros != 0)
	{			
		$hp->siguiente();
		$elultimo = $hp->fila["n_oficio_externo"];
		$transi=(int)$elultimo;
		$transi++;		
		$elnuevovalor = str_pad($transi, 5, "0", STR_PAD_LEFT);		
	} else {
		$elnuevovalor = str_pad("1", 5, "0", STR_PAD_LEFT);		
	}
$hp->cerrar();
unset($hp);
require_once("bil.php");	
?>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<table width="700px" align="center">
	<tr>
		<td align="center">
			<table width="99%" align="center" cellpadding="2" cellspacing="0">
				<tr>
					<td width="30px"><img src="images/oficio.png"/></td>
					<td class="titulomenu" valign="middle">Generar Oficio Externo</td>
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
			<table border="0" align="center" class="b_table" cellpadding="3" cellspacing="3" width="100%" height="300px">			
				<tr valign="top">
					<td align="center">	
						<table border="0" width="100%" cellpadding="3" cellspacing="2">
							<tr>
								<td colspan="2" align="center">
									<input type="hidden"  name="ms" id="ms" value="<? echo $mensaje;?>"/>
									<div id="mensa"  name="mensa" class="escuela" style="width:90%;float:center; font-size:12px;font-weight:bold;"></div>								</td>
							</tr>							
							<tr>
								<td colspan="4" align="center">
									Organismo/Cgr&nbsp;<input type="radio" name="salid" id="org_cgr" checked="checked"  onclick="sali(this.id);" value="sel_org" />&nbsp;&nbsp;&nbsp;&nbsp;
											Otros&nbsp;<input type="radio" value="sel_otro" name="salid" id="otro" onclick="sali(this.id);" />															
								</td>
							</tr>							
							<tr id="salida_1">
								<td width="150" align="right" valign="top">
									Organismo &oacute; Direcci&oacute;n:								
								</td>
								<td width="200">
									<textarea name="organismo_reci" id="organismo_reci" style="width:300px; height:55px;" ></textarea>&nbsp;<span class="mensaje">*</span>
									<input type="hidden" name="id_organismo_reci" id="id_organismo_reci"  />								
								</td>
							</tr>	
							<tr id="salida_2" style="display:none">
								<td width="150" align="right" valign="top">
									Destinatario:								
								</td>
								<td width="200">
									<textarea name="destina" id="destina" onKeyUp="return maximaLongitud(this.id,200);" onkeypress="return validar(event,numeros+letras+',ñóáéíú')" style="width:300px; height:35px;" ></textarea>&nbsp;<span class="mensaje">*</span>
								</td>
							</tr>													
							<tr>
								<td width="150" align="right">
									N&deg; Oficio / Circular:								
								</td>
								<td>
									<input type="text" name="n_oficio_ext" id="n_oficio_ext" style="width:120px" value="<? echo $elnuevovalor; ?>" maxlength="5" onkeypress="return validar(event,numeros)" onchange="life(this.value,'objeto');"/>&nbsp;<span class="mensaje">*</span>&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/Help_16x16.png" style="cursor:help" title="EL n&uacute;mero de oficio que corresponden es: <? echo $elnuevovalor; ?>" />								
								</td>
							</tr>
							<tr>
								<td width="150" align="right">
									Fecha Registro:								
								</td>
								<td>
									<input type="text" name="f_registro" id="f_registro" onkeyup="this.value=formateafecha(this.value);"/>
									<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span>
								</td>
							</tr>							
<!--							<tr>
								<td width="190" align="right">
									Plazo:								
								</td>
								<td>
									<input type="text" name="plazo" id="plazo" style="width:20px" maxlength="2" onkeypress="return validar(event,numeros)"/>&nbsp;&nbsp;d&iacute;as	
								</td>							
							</tr>-->
							<tr>
								<td width="150" align="right">
									Tipo Documento:								
								</td>
								<td>
									<?
									$rsmen = new Recordset();
									$rsmen->sql = "SELECT id_tipo_documento_cgr, tipo_documento_cgr FROM tipo_documento_cgr"; 
									$rsmen->llenarcombo($opciones = "\"tipo_documento\"", $checked = "Oficio", $fukcion = "" , $diam = "style=\"width:124px; Height:20px;\""); 
									$rsmen->cerrar(); 
									unset($rsmen);									
									?>&nbsp;<span class="mensaje">*</span>
								</td>							
							</tr>
<!--							<tr id="infm" style="display:none">
								<td width="150" align="right">
									Tipo Oficio:								
								</td>
								<td>
									<?
									/*$rsmen = new Recordset();
									$rsmen->sql = "SELECT documento_cgr_desgloce.id_documento_cgr_desgloce, documento_cgr_desgloce.documento_cgr_desgloce FROM documento_cgr_desgloce WHERE documento_cgr_desgloce.id_tipo_documento_cgr = 1"; 
									$rsmen->llenarcombo($opciones = "\"tipo_informe\"", $checked = "", $fukcion = "" , $diam = "style=\"width:160px; Height:20px;\""); */
									/*$rsmen->cerrar(); 
									unset($rsmen);*/									
									?>&nbsp;<span class="mensaje">*</span>
								</td>							
							</tr>-->																											
							<tr>				
								<td align="right" valign="botton">Con Anexo:</td>
								<td>Si&nbsp;<input type="radio" name="anex" id="SiAnex" onclick="vee_anex(this.id);"/>&nbsp;&nbsp;No&nbsp;<input type="radio" name="anex" id="NoAnex" checked="checked" onclick="vee_anex(this.id);"/></td>					
							</tr>	
							<tr id="danex2" style="display:none">
								<td align="right" valign="top">Especifique los Anexos:</td>
								<td>
									<textarea name="listAnexo" onblur="formatotexto(this)" id="listAnexo" style="width:300px; height:105px" onKeyUp="return maximaLongitud(this.id,300);"><? echo $_SESSION["anexoss"]; ?></textarea>&nbsp;<span class="mensaje">*</span>
									<br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span>					</td>					
							</tr>					
							<tr>
								<td width="150" align="right" valign="top">
									Contenido:								
								</td>
								<td>
									<textarea id="contenido" name="contenido" onblur="formatotexto(this)" style="width:300px; height:105px" onKeyUp="return maximaLongitud(this.id,300);"><? echo $_SESSION["motivos"]; ?></textarea>&nbsp;<span class="mensaje">*</span><br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span>
								</td>							
							</tr>					
							<tr>				
								<td align="right" valign="botton">Repetir Contenido:</td>
								<td>Si&nbsp;<input type="radio" name="rep" id="Sirep" value="Sirep"/>&nbsp;&nbsp;No&nbsp;<input type="radio" name="rep" id="Norep" value="Norep" checked="checked"/></td>					
							</tr>																																							
							<tr height="25" valign="bottom"><td align="right" class="mensaje" colspan="4">* Campos Obligatorios&nbsp;&nbsp;</td></tr>																														
						</table>								
					</td>
				</tr>							
				<tr>
					<td align="center">
						<input type="button" name="btnRegistrar" id="btnRegistrar" value="Registrar Envio" title="Registrar Envio" onclick="reg();" />
						&nbsp;&nbsp;
						<input type="button" class="botones" id="limpiar" name="limpiar" value="Cancelar" title="Cancelar" onclick="limp();" />																

						<input type="hidden"  name="spam" value="<? echo $_SESSION["spam"]; ?>"/>																						
					</td>
				</tr>
				<tr>
					<td height="10"></td>
				</tr>							
			</table><br>
		</form>
		</td>
	</tr>
</table>
<script type="text/javascript" src="librerias/jq.js"></script>
<script type="text/javascript" src="librerias/jquery.autocomplete.js"></script>
<script language="javascript" type="text/javascript">
	$("#organismo_reci").autocomplete("modulos/correspondencia/generar/lista.php", { 
		width: 400,
		matchContains: true,
		mustMatch: false,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});

	$("#organismo_reci").result(function(event, data, formatted) {
		try {
			$("#id_organismo_reci").val(data[1]);
		} catch(e) {
			e.name;		
		}
	});	
	
$(document).ready(function()
{
	valor=$('#ms').val();
	if(valor==1){

		mensaje=acentos('&iexcl;El oficio externo ha sido registrado exitosamente!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}
    
	if(valor==2){

		mensaje=acentos('&iexcl;Registro Rechazado, <br>esta correspondencia ha sido registrada anteriormente!')
		$("#mensa").addClass('fallo');
		$('#mensa').html(mensaje);
	}
	setTimeout(function(){$(".escuela").fadeOut(6000);},1000); 
}); 	
<?
	if($St!=""){
		echo $St;
		}
?>
</script>