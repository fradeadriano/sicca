<script type="text/javascript" src="../../../librerias/dhtml/dhtmlSuite-common.js"></script>
<script language="javascript" type="text/javascript" src="../../../librerias/dhtml/ajax.js"></script>
<script language="javascript" type="text/javascript" src="../../../librerias/funciones.js"></script>							
<script type="text/javascript" src="../../../librerias/jq.js"></script>
<script type="text/javascript" src="../../../librerias/jquery.autocomplete.js"></script>
<script type="text/javascript">
	DHTML_SUITE_JS_FOLDER = "../../../librerias/dhtml/";
	DHTML_SUITE_THEME_FOLDER = "../../../librerias/dhtml/themes/";
	DHTMLSuite.include("modalMessage");
</script>
<? 
require_once("../../../librerias/Recordset.php"); 
require_once("../../../librerias/bitacora.php"); 
require_once("bil.php");
$id = stripslashes($_GET["id_recepcion"]);
if(ctype_digit($id)){

	$bsqcor = new Recordset();
	$bsqcor->sql = "SELECT crp_recepcion_correspondencia.id_recepcion_correspondencia, crp_recepcion_correspondencia.tipo_correspondencia, organismo.organismo, 
				organismo.id_organismo, crp_recepcion_correspondencia.id_tipo_documento, tipo_documento.tipo_documento, crp_recepcion_correspondencia.n_documento,
				DATE_FORMAT(crp_recepcion_correspondencia.fecha_documento, '%d/%m/%Y') AS fecha_do, crp_recepcion_correspondencia.anexo, crp_recepcion_correspondencia.observacion,
				crp_recepcion_correspondencia.id_tipo_respuesta, crp_recepcion_correspondencia.n_correlativo_padre, crp_recepcion_correspondencia.anfiscal, 
				DATE_FORMAT(crp_recepcion_correspondencia.gaceta_fecha, '%d/%m/%Y') AS fecha_ga, crp_recepcion_correspondencia.gaceta_n, crp_recepcion_correspondencia.remitente,
				crp_recepcion_correspondencia.gaceta_tipo
					FROM crp_recepcion_correspondencia 
					 INNER JOIN organismo ON (crp_recepcion_correspondencia.id_organismo = organismo.id_organismo) 
					 INNER JOIN tipo_documento ON (crp_recepcion_correspondencia.id_tipo_documento = crp_recepcion_correspondencia.id_tipo_documento)
					 WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = ".$id."
					GROUP BY crp_recepcion_correspondencia.id_recepcion_correspondencia";
	$bsqcor->abrir();
	if($bsqcor->total_registros > 0)
		{
			$bsqcor->siguiente();
			$tipo_correspondencia1 = $bsqcor->fila["tipo_correspondencia"];
			$organismo1 = $bsqcor->fila["organismo"];
			$idorganismo1 = $bsqcor->fila["id_organismo"];
			$id_tipo_documento1 = $bsqcor->fila["id_tipo_documento"];
			$n_documento1 = $bsqcor->fila["n_documento"];			
			$id_tipo_respuesta1 = $bsqcor->fila["id_tipo_respuesta"];			
			$n_correlativo_padre1 = $bsqcor->fila["n_correlativo_padre"];						
			$anfiscal1 = $bsqcor->fila["anfiscal"];									
			$fecha_do1 = $bsqcor->fila["fecha_do"];												
			$anexo1 = $bsqcor->fila["anexo"];		
			$observacion1 = $bsqcor->fila["observacion"];																		
			$fecha_ga1 = $bsqcor->fila["fecha_ga"];																		
			$gaceta_n1 = $bsqcor->fila["gaceta_n"];	
			$remitente1 = $bsqcor->fila["remitente"];	
			$gaceta_tipo1 = $bsqcor->fila["gaceta_tipo"];				
																													
//			id_tipo_documento
		}
	$accion = stripslashes($_POST["accion"]);
	$recepcion = stripslashes($_POST["irecepcion"]);	
	
	if(isset($accion) && $accion=="modificar")
		{
			$rsverif = new Recordset();
			$rsverif->sql = "SELECT crp_recepcion_correspondencia.id_recepcion_correspondencia, crp_recepcion_correspondencia.tipo_correspondencia, organismo.organismo, 
				organismo.id_organismo, crp_recepcion_correspondencia.id_tipo_documento, tipo_documento.tipo_documento, crp_recepcion_correspondencia.n_documento,
				DATE_FORMAT(crp_recepcion_correspondencia.fecha_documento, '%d/%m/%Y') AS fecha_do, crp_recepcion_correspondencia.anexo, crp_recepcion_correspondencia.observacion,
				crp_recepcion_correspondencia.id_tipo_respuesta, crp_recepcion_correspondencia.n_correlativo_padre, crp_recepcion_correspondencia.anfiscal, 
				DATE_FORMAT(crp_recepcion_correspondencia.gaceta_fecha, '%d/%m/%Y') AS fecha_ga, crp_recepcion_correspondencia.gaceta_n, crp_recepcion_correspondencia.remitente, 
				crp_recepcion_correspondencia.fecha_documento, crp_recepcion_correspondencia.gaceta_fecha, crp_recepcion_correspondencia.gaceta_tipo
					FROM crp_recepcion_correspondencia 
					 INNER JOIN organismo ON (crp_recepcion_correspondencia.id_organismo = organismo.id_organismo) 
					 INNER JOIN tipo_documento ON (crp_recepcion_correspondencia.id_tipo_documento = crp_recepcion_correspondencia.id_tipo_documento)
					 WHERE crp_recepcion_correspondencia.id_recepcion_correspondencia = ".$recepcion."
					GROUP BY crp_recepcion_correspondencia.id_recepcion_correspondencia";
			$rsverif->abrir();
				if($rsverif->total_registros != 0)
				{
					$rsverif->siguiente();
					$change = 1;
					$consul = "";
					if (strcasecmp($rsverif->fila["tipo_correspondencia"],stripslashes($_POST["correspondencia"])) != 0)
						{
							$change = 0;
							$consul = "tipo_correspondencia = '".trim(stripslashes($_POST["correspondencia"]))."'";
						}
						
					if (strcasecmp($rsverif->fila["id_organismo"],stripslashes($_POST["id_organismo"])) != 0)
						{
							$change = 0;
							if ($consul!=""){
								$consul = $consul.", id_organismo = '".trim(stripslashes($_POST["id_organismo"]))."'";
							} else { 
								$consul = "id_organismo = '".trim(stripslashes($_POST["id_organismo"]))."'";
							}							
						}
						
					if (strcasecmp($rsverif->fila["id_tipo_documento"],stripslashes($_POST["tipo_documento"])) != 0)
						{
							$change = 0;
							if ($consul!=""){
								$consul = $consul.", id_tipo_documento = '".stripslashes($_POST["tipo_documento"])."'";
							} else { 
								$consul = "id_tipo_documento = '".stripslashes($_POST["tipo_documento"])."'";
							}							
						}
						
					if (strcasecmp($rsverif->fila["n_documento"],stripslashes($_POST["n_documento"])) != 0)
						{
							$change = 0;
							if ($consul!=""){
								$consul = $consul.", n_documento = '".trim(stripslashes($_POST["n_documento"]))."'";
							} else { 
								$consul = "n_documento = '".trim(stripslashes($_POST["n_documento"]))."'";
							}							
						}
						
					if (strcasecmp($rsverif->fila["remitente"],stripslashes($_POST["remitente"])) != 0)
						{
							$change = 0;
							if ($consul!=""){
								$consul = $consul.", remitente = '".trim(stripslashes($_POST["remitente"]))."'";
							} else { 
								$consul = "remitente = '".trim(stripslashes($_POST["remitente"]))."'";
							}							
						}
												
					if (strcasecmp($rsverif->fila["fecha_documento"],$rsverif->formatofecha($_POST["fe_documento"])) != 0)
						{
							$change = 0;
							if ($consul!=""){
								$consul = $consul.", fecha_documento = '".trim($rsverif->formatofecha($_POST["fe_documento"]))."'";
							} else { 
								$consul = "fecha_documento = '".trim($rsverif->formatofecha($_POST["fe_documento"]))."'";
							}							
						}	
						
					if (strcasecmp($rsverif->fila["observacion"],stripslashes($_POST["observacion"])) != 0)
						{
							$change = 0;
							if ($consul!=""){
								$consul = $consul.", observacion = '".trim(stripslashes($_POST["observacion"]))."'";
							} else { 
								$consul = "observacion = '".trim(stripslashes($_POST["observacion"]))."'";
							}							
						}	
						
					if (strcasecmp($rsverif->fila["id_tipo_respuesta"],stripslashes($_POST["tipo_respuesta"])) != 0)
						{
							$change = 0;
							if ($consul!=""){
								$consul = $consul.", id_tipo_respuesta = '".trim(stripslashes($_POST["tipo_respuesta"]))."'";
							} else { 
								$consul = "id_tipo_respuesta = '".trim(stripslashes($_POST["tipo_respuesta"]))."'";
							}							
						}																																										
									
					if (strcasecmp($rsverif->fila["n_correlativo_padre"],stripslashes($_POST["correlativo_padre"])) != 0)
						{
							$change = 0;
							if ($consul!=""){
								$consul = $consul.", n_correlativo_padre = '".trim(stripslashes($_POST["correlativo_padre"]))."'";
							} else { 
								$consul = "n_correlativo_padre= '".trim(stripslashes($_POST["correlativo_padre"]))."'";
							}							
						}				
						
						
					if (strcasecmp($rsverif->fila["anfiscal"],stripslashes($_POST["cont_marcados"])) != 0)
						{
							$change = 0;
							if ($consul!=""){
								$consul = $consul.", anfiscal = '".trim(stripslashes($_POST["cont_marcados"]))."'";
							} else { 
								$consul = "anfiscal= '".trim(stripslashes($_POST["cont_marcados"]))."'";
							}							
						}
						
					if (strcasecmp($rsverif->fila["anexo"],$_POST["listAnexo"]) != 0)
						{
							$change = 0;
							if ($consul!=""){
								$consul = $consul.", anexo = '".trim(($_POST["listAnexo"]))."'";
							} else { 
								$consul = "anexo= '".trim(($_POST["listAnexo"]))."'";
							}							
						}						


					if ($_POST["tipo_documento"] == 11)
					{						
						if (strcasecmp($rsverif->fila["gaceta_n"],stripslashes($_POST["n_gaceta"])) != 0)
							{
								$change = 0;
								if ($consul!=""){
									$consul = $consul.", gaceta_n = '".trim(stripslashes($_POST["n_gaceta"]))."'";
								} else { 
									$consul = "gaceta_n= '".trim(stripslashes($_POST["n_gaceta"]))."'";
								}							
							}

						if(isset($_POST["f_gaceta"]) && $_POST["f_gaceta"]!="")
							{	
							if (strcasecmp($rsverif->fila["gaceta_fecha"],$rsverif->formatofecha($_POST["f_gaceta"])) != 0)
								{
									$change = 0;
									if ($consul!=""){
										$consul = $consul.", gaceta_fecha = '".trim($rsverif->formatofecha($_POST["f_gaceta"]))."'";
									} else { 
										$consul = "gaceta_fecha= '".trim($rsverif->formatofecha($_POST["f_gaceta"]))."'";
									}							
								}		
							}

						if (strcasecmp($rsverif->fila["gaceta_tipo"],$_POST["tipo_gaceta"]) != 0)
							{
								$change = 0;
								if ($consul!=""){
									$consul = $consul.", gaceta_tipo = '".trim($_POST["tipo_gaceta"])."'";
								} else { 
									$consul = "gaceta_tipo= '".trim($_POST["tipo_gaceta"])."'";
								}							
							}							
					}	
					
					if ($change == 0)
						{
							$modi = new Recordset();
							$modi->sql = "UPDATE crp_recepcion_correspondencia SET $consul WHERE id_recepcion_correspondencia = '".$id."'";
							$modi->abrir();
							$modi->cerrar();
							unset($modi);
							bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Modificaci&oacute;n de Correspondencia ","Modificaci&oacute;n de Correspondencia identificada con el n&deg; '".$id."'");
						}						
						echo '<script language="javascript" type="text/javascript">alert(orto("Modificaci&oacute;n Exitosa!!"));window.parent.frames.framo.location.href="form.php";</script>';
																																													
				} 
		}
?>



<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<form method="post" name="recep" id="recep" autocomplete="off">
<table width="99%" border="0" class="b_table" cellpadding="3" cellspacing="3">
	<tr>
		<td colspan="3" align="center">
			<input type="hidden"  name="ms" id="ms" value="<? echo $mensaje; ?>"/>
			<div id="mensa"  name="mensa" class="escuela" style="width:90%;float:center; font-size:12px;font-weight:bold;"></div>                                    
		</td>
	</tr>			
	<tr>
		<td width="20"></td>
		<td align="right" width="200">
			Correspondencia:					
		</td>
		<td>
			Institucional&nbsp;<input type="radio" name="correspondencia" checked="checked" id="institucional" onclick="tipo_corres(this.id);"  value="<? if ($tipo_correspondencia1==0){ echo $tipo_correspondencia1; } ?>">
			Personal&nbsp;<input type="radio" name="correspondencia" id="personal"  onclick="tipo_corres(this.id);" value="<? if ($tipo_correspondencia1==1){ echo $tipo_correspondencia1; }?>">
		</td>
	</tr>	
	<tr id="secc_institucional3">
		<td width="20"></td>				
		<td align="right" valign="top">Organismo:&nbsp;</td>
		<td>
			<textarea name="organismo" id="organismo" style="width:300px; height:55px;" ><? echo $organismo1; ?></textarea>&nbsp;<span class="mensaje">*</span>
			<input type="hidden" name="id_organismo" id="id_organismo" value="<? echo $idorganismo1; ?>"  />					
		</td>					
	</tr>	
	<tr>
		<td width="20"></td>				
		<td align="right">Tipo Documento:&nbsp;</td>
		<td>
			<? 
			$rsun = new Recordset();
			$rsun->sql = "SELECT id_tipo_documento, tipo_documento FROM tipo_documento WHERE cgr <> 1 order by tipo_documento"; 
			$rsun->llenarcombo($opciones = "\"tipo_documento\"", $checked = "$id_tipo_documento1", $fukcion = "onchange=\"mostrar_ofi(this.value)\"" , $diam = "style=\"width:304px; Height:20px;\""); 
			$rsun->cerrar(); 
			unset($rsun);																						
			?>&nbsp;<span class="mensaje">*</span>					
		</td>					
	</tr>					
	<tr id="secc_institucional2" style="display:none"> 
		<td width="20"></td>				
		<td align="right">N&deg; Documento:&nbsp;</td>
		<td>
			<input type="text" name="n_documento" id="n_documento" onkeypress="return validar(event,numeros+letras+'-/.')" maxlength="30" value="<? echo $n_documento1; ?>" style="width:213px;" />
			&nbsp;<span class="mensaje" id="campo_obli" style="display:none">*</span>
		</td>					
	</tr>											
	<tr id="secc_institucional1" style="display:none">
		<td width="20"></td>
		<td align="right" width="200">
			Originado por respuesta:					
		</td>
		<td>
			Si&nbsp;<input type="radio" name="respuesta" id="positivo" onclick="rpts(this.id);">
			No&nbsp;<input type="radio" name="respuesta" id="negativo" checked="checked" onclick="rpts(this.id);">	
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="uno" style="display:none">Respuesta Oficio N&deg;:&nbsp;<input type="text" name="correlativo_padre" style="width:50px" id="correlativo_padre" maxlength="6" onkeypress="return validar(event,numeros)" onchange="life(this.value,'objeto');" ></span>					
		</td>
	</tr>				
	<tr id="dos" style="display:none">
		<td width="20"></td>
		<td align="right" width="200">
			Tipo Respuesta:					
		</td>
		<td>
			<? 
			$rsun = new Recordset();
			$rsun->sql = "SELECT id_tipo_respuesta, tipo_respuesta FROM tipo_respuesta order by tipo_respuesta"; 
			$rsun->llenarcombo($opciones = "\"tipo_respuesta\"", $checked = "$id_tipo_respuesta1", $fukcion = "onchange=\"informe(this.value)\"" , $diam = "style=\"width:304px; Height:20px;\""); 
			$rsun->cerrar(); 
			unset($rsun);																						
			?>&nbsp;&nbsp;<span class="mensaje">*</span>					
		</td>
	</tr>
	<tr id="cinco" style="display:none">
		<td width="20"></td>
		<td align="right" width="200">
			Ejercicio Fiscal:					
		</td>
		<td>
			<? 
				$anno = date('Y');
				$list = $anno-5;
				for ($i = $list; $i<=$anno-1;$i++){
					echo  "<input type=\"checkbox\" name=\"$i\" id=\"$i\" value=\"$i\" onclick=\"va();alone_marcacion(this.value);\" />$i&nbsp;";
				}															
			?>
			<input type="text" name="cont_marcados" id="cont_marcados"/>
		</td>
	</tr>
	<tr id="siete" style="display:none">
		<td width="20"></td>
		<td align="right" width="200">
			Gaceta N&deg;:					
		</td>
		<td>
			<input type="text" name="n_gaceta" id="n_gaceta" maxlength="10" onkeypress="return validar(event,numeros+'.')" value="<? echo $gaceta_n1; ?>" />
			<span class="mensaje">*</span>					
		</td>
	</tr>	
	<tr id="nueve" style="display:none">
		<td width="20"></td>
		<td align="right" width="200">
			Fecha:					
		</td>
		<td>
			<input type="text" name="f_gaceta" id="f_gaceta" onkeyup="this.value=formateafecha(this.value);" value="<? echo $fecha_ga1; ?>"/>
			<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span>					
		</td>
	</tr>					
	<tr id="once" style="display:none">
		<td width="20"></td>
		<td align="right" width="200">
			Gaceta:					
		</td>
		<td>
			Ordinaria&nbsp;<input type="radio" name="tipo_gaceta" id="ordinaria" checked="checked" value="ordinaria" />&nbsp;&nbsp;&nbsp;
			Extraordinaria&nbsp;<input type="radio" name="tipo_gaceta" id="extraordinaria" value="extraordinaria" />
		</td>
	</tr>																						
	<tr id="secc_institucional9">
		<td width="20"></td>				
		<td align="right">Fecha Documento:&nbsp;</td>
		<td><input type="text" name="fe_documento" id="fe_documento" onkeyup="this.value=formateafecha(this.value);" value="<? echo $fecha_do1; ?>">&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span></td>					
	</tr>
	<tr id="secc_institucional7" style="display:none">
		<td width="20"></td>				
		<td align="right"  width="180">Remitente:&nbsp;</td>
		<td><input type="text" onblur="formatotexto(this)" name="remitente" id="remitente" style="width:300px" value="<? echo $remitente1; ?>" onkeypress="return validar(event,letras)" maxlength="190">&nbsp;<span class="mensaje">*</span></td>					
	</tr>											
	<tr>
		<td width="20"></td>				
		<td align="right" valign="botton">Con Anexo:&nbsp;</td>
		<td>Si&nbsp;<input type="radio" name="anex" id="SiAnex" onclick="vee_anex(this.id);"/>&nbsp;&nbsp;No&nbsp;<input type="radio" name="anex" id="NoAnex" checked="checked" onclick="vee_anex(this.id);"/></td>					
	</tr>	
	<tr id="danex2" style="display:none">
		<td width="20"></td>				
		<td align="right" valign="top" width="180">Especifique los Anexos:</td>
		<td>
			<textarea name="listAnexo" onblur="formatotexto(this)" id="listAnexo" style="width:300px; height:105px" onKeyUp="return maximaLongitud(this.id,300);"></textarea>&nbsp;<span class="mensaje">*</span>
			<br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span>					</td>					
	</tr>					
	<tr>
		<td width="20"></td>				
		<td align="right" valign="top">Motivo Correspondencia:&nbsp;</td>
		<td><textarea name="observacion" onblur="formatotexto(this)" id="observacion" style="width:300px; height:105px" onKeyUp="return maximaLongitud(this.id,300);"><? echo $observacion1;?></textarea>&nbsp;<span class="mensaje">*</span><br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span></td>					
	</tr>									
	<tr><td height="20" colspan="3"></td></tr>
	<tr><td colspan="3" align="right" class="mensaje">* Campos Obligatorios&nbsp;&nbsp;</td></tr>														
	<tr><td height="20" colspan="2"></td></tr>				
	<tr>
		<td colspan="3" align="center">
			<input type="button" name="modificar" id="modificar" value="Modificar" title="Modificar" onclick="doit(this.id);" />					
			&nbsp;								
			<input type="button" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" onclick="cancelarT();" />					</td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>				
</table>
<input type="hidden" name="accion" id="accion" /><input type="hidden"  name="irecepcion" id="irecepcion" value="<? echo $id; ?>"/>
</form>
<? 
			if($tipo_correspondencia1==0){
				echo '<script language="javascript" type="text/javascript"> tipo_corres("institucional"); document.getElementById("institucional").checked = true; </script>';
			} else {
				echo '<script language="javascript" type="text/javascript">tipo_corres("personal"); document.getElementById("personal").checked = true;</script>';
			}
			echo '<script language="javascript" type="text/javascript">document.getElementById("tipo_documento").value='.$id_tipo_documento1.';</script>'; 
			echo '<script language="javascript" type="text/javascript">mostrar_ofi('.$id_tipo_documento1.');</script>'; 
			if (isset($id_tipo_respuesta1)){
				echo '<script language="javascript" type="text/javascript">rpts("positivo"); document.getElementById("positivo").checked = true; document.getElementById("correlativo_padre").value='.$n_correlativo_padre1.'; document.getElementById("tipo_respuesta").value='.$id_tipo_respuesta1.';</script>'; 
			}
			if (isset($id_tipo_respuesta1) && ($id_tipo_respuesta1==1 || $id_tipo_respuesta1==2)){
				echo '<script language="javascript" type="text/javascript">informe('.$id_tipo_respuesta1.'); document.getElementById("cont_marcados").value='.$anfiscal1.'; document.getElementById("'.$anfiscal1.'").checked = true;</script>';  
			}
			if (isset($anexo1)){
				echo '<script language="javascript" type="text/javascript">vee_anex("SiAnex"); document.getElementById("SiAnex").checked = true; document.getElementById("listAnexo").value="'.$anexo1.'";</script>';  
			}						
			if (isset($gaceta_tipo1) && $gaceta_tipo1=="extraordinaria"){
				echo '<script language="javascript" type="text/javascript">document.getElementById("extraordinaria").checked = true;</script>';  
			}  												
			if (isset($gaceta_tipo1) && $gaceta_tipo1=="ordinaria"){
				echo '<script language="javascript" type="text/javascript">document.getElementById("ordinaria").checked = true;</script>';  
			} 
	} 
?>	 
<script language="javascript" type="text/javascript">
	$("#organismo").autocomplete("lista.php", { 
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
			