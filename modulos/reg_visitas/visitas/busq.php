<? session_start(); ?>
<script type="text/javascript" src="../../../librerias/jq.js"></script>
<script type="text/javascript" src="../../../librerias/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../../librerias/funciones.js"></script>	
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<?
require_once("../../../librerias/Recordset.php");
require_once("../../../librerias/bitacora.php");
//require_once("bil.php");
$motivo = stripslashes($_REQUEST["accion"]);
if(isset($motivo) && $motivo=="registrar"){
	if(ctype_alpha($motivo)){
		$id_visitante = stripslashes($_POST["id_visitante"]); $id_organismo = stripslashes($_POST["id_organismo"]); 
		$unidad = stripslashes($_POST["unidad"]); $accion = stripslashes($_POST["motivo"]);
		if(ctype_digit($id_visitante) && ctype_digit($id_organismo) && ctype_digit($unidad)) 
		{
			$insert = new Recordset();
			$insert->sql = "insert into rec_visita (id_visitante, fecha, hora, id_unidad, id_organismo, motivo) values ('".$id_visitante."', '".date('Y-m-d')."', '".date('H:i:s')."', '".$unidad."', '".$id_organismo."', '".$accion."');";
			$insert->abrir();
			$insert->cerrar();
			unset($insert);		
			unset($_POST["id_visitante"]); unset($_POST["id_organismo"]); unset($_POST["unidad"]); unset($_POST["motivo"]); unset($_POST["accion"]);
			/*bitacora*/bitacora ($_SESSION["usuario"],date("Y-m-d"),date("h:i:s"),"Registro de visita", "Registro de visita: El visitante identificado con el &deg; ".$id_visitante.", proveniente del organ&iacute;smo con el &deg;:".$id_organismo.", visit&oacute; la unidad: ".$unidad." de la Contraloria del estado Aragua, con motivo de: ".$accion);		
		}
	}
} else if (isset($motivo) && $motivo=="buscar"){
	$qdate = stripslashes($_GET["ce"]);
		if(isset($qdate) && $qdate !="") {  
			if(ctype_digit($qdate)){	
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
?>					
					<form action="" name="frm_visita" id="frm_visita" onkeypress="return entsub(event);" method="post">		
					<table border="0" class="tabla_bsq1" width="100%" cellspacing="0">
						<tr bgcolor="#FFC1C1">
							<td align="right" width="270">
								Nombre y Apellido:&nbsp;                                  
							</td>
							<td align="left"><u><? echo $search->fila["visitante"]; ?></u></td>
						</tr>
						<tr>
							<td height="20px" colspan="2">
							</td>
						</tr>																
						<tr bgcolor="#FFC1C1">
							<td align="right">
								Tel&eacute;fono:&nbsp;	
							</td>
							<td align="left"><u><? echo $search->fila["telefono"]; ?></u></td>									
						</tr>
						<tr>
							<td height="20px" colspan="2">
							</td>
						</tr>							
						<tr bgcolor="#FFC1C1">
							<td align="right" >
								Organ&iacute;smo Procedencia:&nbsp;	 
							</td>
							<td align="left">
							<textarea name="organismo" id="organismo" style="width:300px; height:55px; font-weight:bold; font-size:13px;" ><? echo $search->fila["organismo"]; ?></textarea>
							<input type="button" name="crear_org" id="crear_org" style="font-weight:bold" value="..." onclick="window.top.displayMessage('modulos/reg_visitas/visitas/new_organismo.php','500','160');" title="Registrar Nuevo Organ&iacute;smo" />
<!--							&nbsp;&nbsp;
							<a style="cursor:help">
								<img src="../../../images/help2.png" border="0" /><span class="tooltip" style="border:0">Si</span>
							</a>-->							
														
							</td>
						</tr>
						<tr>
							<td height="20px" colspan="2">
							</td>
						</tr>																
						<tr bgcolor="#FFC1C1">
							<td align="right">
								Unidad Administrativa:&nbsp;	
							</td>
							<td align="left">
							<? 
								$rsun = new Recordset();
								$rsun->sql = "SELECT id_unidad, unidad FROM unidad"; 
								$rsun->llenarcombo($opciones = "\"unidad\"", $checked = $search->fila["id_unidad"], $fukcion = "" , $diam = "style=\"width:300px; Height:20px; font-weight:bold; font-size:13px;\""); 
								$rsun->cerrar(); 
								unset($rsun);								
								
							?></td>	 								
						</tr>	
						<tr>
							<td height="20px" colspan="2">
							</td>
						</tr>																
						<tr bgcolor="#FFC1C1">
							<td align="right">
								Motivo:&nbsp;	
							</td>
							<td align="left">
								<textarea name="motivo" id="motivo" style="width:300px; height:60px;font-weight:bold; font-size:13px;" onKeyUp="return maximaLongitud(this.id,300);"></textarea>
								<br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span>
							</td>	 								
						</tr>											
						<tr>
							<td height="20px" colspan="2">
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input type="hidden" name="id_visitante" id="id_visitante" value="<? echo $search->fila["id_visitante"]; ?>" />
								<input type="hidden" name="id_organismo" id="id_organismo" value="<? echo $search->fila["id_organismo"]; ?>"  />								
								<input type="hidden" name="accion" id="accion"/>								
								<input type="button" name="registrar" id="registrar" value="Registrar" title="Registrar" onclick="registrarV(this.id);" />
								&nbsp;
								<input type="button" name="limpiar" id="limpiar" value="Limpiar" title="Limpiar" onclick="limp();" />								
								&nbsp;								
								<input type="button" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" onclick="cancelarT();" />																
							</td>
						</tr>
						<tr>
							<td height="5px" colspan="2">
							</td>
						</tr>												
					</table>
					</form>
<?
			} else {
				echo "<table align=\"center\" border=\"0\"><tr><td><a onclick=\"window.top.displayMessage('modulos/reg_visitas/visitas/busqV.php?fcedu=".$qdate."','500','220');\" class=\"agregar\" title=\"Clic para Agregar Visitante\">Agregar Visitante</a></td></tr></table>";					
			}
		}
	} 
}
unset($qdate); unset($_GET["ce"]);
?>
<script language="javascript" type="text/javascript">
	$("#organismo").autocomplete("get_course_list2.php", { 
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
	
function maximaLongitud(texto,maxlong) {
//var tecla, in_value, out_value;

	if (document.getElementById(texto).value.length > maxlong) {
		in_value = document.getElementById(texto).value;
		out_value = in_value.substring(0,maxlong);
		document.getElementById(texto).value = out_value;
		return false;
	}
		return true;
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
function registrarV(obj){
	if(valid_form()==false){
		return;
	}
	document.getElementById("accion").value = obj;
	alert("La visita ha sido registrada exitosamente!");
	frm_visita.submit();
	window.top.document.getElementById("cedula").value = "";
}	

// 5
function valid_form() {
	if (document.getElementById("id_visitante").value.trim().lenght==0){
		alert("Disculpe.!, vuelva a realizar la busqueda del visitante")
		//document.getElementById("cedula").focus();
		return false;
	} 

	if (document.getElementById("organismo").value.trim().length==0){
		alert(acentos("El campo organ&iacute;smo est&aacute; vacio, por favor completelo"));
		document.getElementById("organismo").focus();
		return false;
	}

	if (document.getElementById("unidad").value.trim().length==0){
		alert(acentos("El campo unidad est&aacute; vacio, por favor completelo"));
		document.getElementById("unidad").focus();
		return false;
	}
	
	if (document.getElementById("motivo").value.trim().length==0){
		alert(acentos("El campo motivo est&aacute; vacio, por favor completelo"));
		document.getElementById("motivo").focus();
		return false;
	}	
}

function limp(){
	document.getElementById("organismo").value = "";
	document.getElementById("unidad").value = "";
	document.getElementById("motivo").value = "";
	document.getElementById("id_visitante").value = "";	
	document.getElementById("id_organismo").value = "";
	document.getElementById("accion").value = "";	


}

function cancelarT(){
	frm_visita.submit();
	window.top.document.getElementById("cedula").value = "";
}

</script>