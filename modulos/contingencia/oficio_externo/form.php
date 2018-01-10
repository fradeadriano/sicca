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
if(ctype_digit($id))
{

	$bsqcor = new Recordset();
	$bsqcor->sql = "SELECT crp_correspondencia_externa.n_oficio_externo, organismo.organismo, crp_correspondencia_externa.contenido, 
						DATE_FORMAT(crp_correspondencia_externa.fecha_registro,'%d/%m/%Y') as fecha_registro, crp_correspondencia_externa_det.id_organismo 
					FROM crp_correspondencia_externa 
					 INNER JOIN crp_correspondencia_externa_det 
					  ON (crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa) 
					 INNER JOIN organismo ON (crp_correspondencia_externa_det.id_organismo = organismo.id_organismo)
					WHERE crp_correspondencia_externa.id_correspondencia_externa=".$id;
	$bsqcor->abrir();
	if($bsqcor->total_registros > 0)
		{
			$bsqcor->siguiente();
			$n_oficio_externo1 = $bsqcor->fila["n_oficio_externo"];
			$organismo1 = $bsqcor->fila["organismo"];
			$contenido1 = $bsqcor->fila["contenido"];
			$fecha_registro1 = $bsqcor->fila["fecha_registro"];
			$organismo1 = $bsqcor->fila["organismo"];
			$id_organismo1 = $bsqcor->fila["id_organismo"];													
		}					

		if(isset($accion) && $accion=="modificar")
			{		
				$idd = stripslashes($_POST["ioficio"]);
				if(ctype_digit($idd))
				{						
						$rsverif = new Recordset();
						$rsverif->sql = "SELECT crp_correspondencia_externa.n_oficio_externo, organismo.organismo, crp_correspondencia_externa.contenido, 
											DATE_FORMAT(crp_correspondencia_externa.fecha_registro,'%d/%m/%Y') as fecha_reg, crp_correspondencia_externa.fecha_registro,  crp_correspondencia_externa_det.id_organismo 
										FROM crp_correspondencia_externa 
										 INNER JOIN crp_correspondencia_externa_det 
										  ON (crp_correspondencia_externa.id_correspondencia_externa = crp_correspondencia_externa_det.id_correspondencia_externa) 
										 INNER JOIN organismo ON (crp_correspondencia_externa_det.id_organismo = organismo.id_organismo)
										WHERE crp_correspondencia_externa.id_correspondencia_externa=".$idd;
						$rsverif->abrir();
							if($rsverif->total_registros != 0)
							{
								$rsverif->siguiente();
								$change = 1;
								$otra = 1;
								$consul = "";
								
								if (strcasecmp($rsverif->fila["id_organismo"],stripslashes($_POST["id_organismo"])) != 0)
									{
										$otra = 0;
										$sqlll= "update crp_correspondencia_externa_det set id_organismo = '".trim(stripslashes($_POST["id_organismo"]))."' where id_correspondencia_externa = $idd";
									}
							
								if (strcasecmp($search->fila["fecha_registro"],stripslashes($_POST["fregistro"])) != 0)
									{
										$change = 0;
										$a = explode("/",$_POST["fregistro"]);
										$fe = $a[2]."-".$a[1]."-".$a[0];
										
										if ($consul!=""){
											$consul = $consul.", fecha_registro = '".$fe."'";
										} else { 
											$consul = "fecha_registro = '".$fe."'";
										}						
									}
									
								if (strcasecmp($search->fila["contenido"],stripslashes($_POST["contenido"])) != 0)
									{
										$change = 0;
										if ($consul!=""){
											$consul = $consul.", contenido = '".trim(stripslashes($_POST["contenido"]))."'";
										} else { 
											$consul = "contenido = '".trim(stripslashes($_POST["contenido"]))."'";
										}							
									}
																	
								if ($change == 0)
									{
										$modi = new Recordset();
										$modi->sql = "UPDATE crp_correspondencia_externa SET $consul WHERE id_correspondencia_externa = ".$idd;
										$modi->abrir();
										$modi->cerrar();
										unset($modi);
										bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Modificaci&oacute;n de Oficio ","Modificaci&oacute;n de Oficio Externo identificado con el n&deg; '".$idd."'");
									}
										
								if ($otra == 0)
									{
										$modi1 = new Recordset();
										$modi1->sql = $sqlll;
										$modi1->abrir();
										$modi1->cerrar();
										unset($modi1);
									}	
																	
								echo '<script language="javascript" type="text/javascript">alert(orto("Modificaci&oacute;n Exitosa!!"));window.parent.frames.framo.location.href="form.php";</script>';
							
							}
				}
			
			}
?>



<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<form method="post" name="recep" id="recep" autocomplete="off">
<table width="100%">
	<tr>
		<td>
			<fieldset style="width:97%; border-color:#EFEFEF"> 
			<legend class="titulomenu">Generacion Oficio Externo</legend>		
			<table cellspacing="3" cellpadding="2" border="0" width="100%">
				<tr>
					<td align="right" width="150">
						<b>N&deg; de Oficio:</b>
					</td>
					<td>
						<input type="text" name="noficio" id="noficio" value="<? echo $n_oficio_externo1; ?>" disabled="disabled" />
					</td>
				</tr>
				<tr>
					<td align="right" width="150">
						<b>Fecha Registro:</b>
					</td>
					<td>
						<input type="text" name="fregistro" id="fregistro" value="<? echo $fecha_registro1; ?>"/>&nbsp;<span class="mensaje">*</span>
					</td>
				</tr>				
				<tr>			
					<td align="right" valign="top"><b>Organismo:</b>&nbsp;</td>
					<td>
						<textarea name="organismo" id="organismo" style="width:300px; height:55px;" ><? echo $organismo1; ?></textarea>&nbsp;<span class="mensaje">*</span>
						<input type="hidden" name="id_organismo" id="id_organismo" value="<? echo $id_organismo1; ?>"  />					
					</td>					
				</tr>				
				<tr>
					<td valign="top" align="right"><b>Contenido:</b></td>
					<td>
						<textarea name="contenido" id="contenido" style="width:400px; height:60px" onkeyup="return maximaLongitud(this.id,300);"><? echo $contenido1; ?></textarea>&nbsp;<span class="mensaje">*</span>
						<br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span>
					</td>
				</tr>																				
				<tr><td align="right" class="mensaje" colspan="2">* Campos Obligatorios&nbsp;&nbsp;</td></tr>							
				<tr>
					<td align="center" colspan="2">
						<input type="button" name="modificar" id="modificar" value="Modificar" title="Modificar" onclick="editar(this.id);" />
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" onclick="cancelarT();" />																
					</td>
				</tr>																								
			</table>
			</fieldset>									
		
		</td>
	</tr>
</table>
<input type="hidden" name="accion" id="accion" /><input type="hidden"  name="ioficio" id="ioficio" value="<? echo $id; ?>"/>
</form>
<? 
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