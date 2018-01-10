<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado de Usuarios</title>
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
require_once("bil.php");

//setlocale(LC_ALL, 'es_VE');
// Setea el huso horario del servidor...
//date_default_timezone_set('America/Caracas');
// Imprime la fecha, hora y huso horario.
//echo date("d/m/Y h:m:s a P");



if (!isset($_SESSION["spam"]))
    $_SESSION["spam"] = rand(1, 99999999);
	if ((isset($_POST["spam"]) && isset($_SESSION["spam"])) && $_POST["spam"] == $_SESSION["spam"]) 
		{
		//------------------------------------------------------
		$tipo = "";
		$rssolicitud = new Recordset();
		$rssolicitud->sql = "SELECT n_correlativo FROM crp_recepcion_correspondencia WHERE n_correlativo like '".date("Y")."%' order by id_recepcion_correspondencia desc limit 1";
		$rssolicitud->abrir();
		if($rssolicitud->total_registros > 0)
			{	
				$rssolicitud->siguiente();
				$codviejo = explode("-",$rssolicitud->fila["n_correlativo"]);
//				$fecha = explode("/",date("d/m/Y"));
				$fechanueva = date("Y");
				if ($codviejo[0] == $fechanueva)
				{
					$nuevovalor=(int)$codviejo[1];
					$nuevovalor++;
					$nuevovalor = str_pad($nuevovalor, 5, "0", STR_PAD_LEFT);
					$codnuevo= $fechanueva."-".$nuevovalor;
				}
				else
				{
					$nuevovalor= str_pad("1", 5, "0", STR_PAD_LEFT);
					$codnuevo= $fechanueva."-".$nuevovalor;
				}
			}
			else
			{
//				$fecha = explode("/",date("d/m/Y"));
				$fechanueva = date("Y");
				$nuevovalor= str_pad("1", 5, "0", STR_PAD_LEFT);
				$codnuevo= $fechanueva."-".$nuevovalor;
			}				
		//------------------------------------------------------			
			$ins = new Recordset();
			$accion = stripslashes($_POST["accion"]);
			if(isset($accion) && $accion=="registrar")
				{
					$campos = "";
					$valores = "";
					$correspondencia = stripslashes($_POST["correspondencia"]);
					if($correspondencia!= "" && $correspondencia==0)
						{
							
							$n_documento = stripslashes($_POST["n_documento"]);
							$id_organismo = stripslashes($_POST["id_organismo"]);
							$tipo_documento = stripslashes($_POST["tipo_documento"]);
							
							$respuesta = stripslashes($_POST["respuesta"]);
							$tipo = "Institucional, la cual proviene del organ&iacute;smo ".utf8_decode($_POST["organismo"]).", trajo documento de tipo ".$tipo_documento;							
							//echo stripslashes($_POST["respuesta"]);
							// **							
							$campos = "id_organismo, id_tipo_documento, n_correlativo";
							$valores = "$id_organismo, $tipo_documento, '$codnuevo'";
							// **														
							if ($tipo_documento!="" && $tipo_documento== "5")
							{													
								if ($respuesta!="" && $respuesta == "rsp_positiva")
								{
									$correlativo_padre = $_POST["correlativo_padre"];
									$tipo_respuesta = $_POST["tipo_respuesta"];
									if ($correlativo_padre!="")
									{									
										// **
										$campos = $campos.", n_correlativo_padre";
										$valores = $valores.", '$correlativo_padre'";
										// **
										$tipo = $tipo.", es una respuesta a oficio n:".$correlativo_padre;
									}								
									if ($tipo_respuesta!="" && ($tipo_respuesta== "1" || $tipo_respuesta== "2"))
									{
										$annfis =  stripslashes($_POST["cont_marcados"]);
										if(isset($annfis) && $annfis!="" ){
											$tipo = $tipo.", es una respuesta de tipo: ".$tipo_respuesta.", que corresponde al ejercicio fiscal: ".$annfis;
											// **
											$campos = $campos.", id_tipo_respuesta, anfiscal";
											$valores = $valores.", $tipo_respuesta, '$annfis'";
											// **
										}
									} else { 
										// **
										$campos = $campos.", id_tipo_respuesta";
										$valores = $valores.", $tipo_respuesta";
										// **		
										$tipo = $tipo.", es una respuesta de tipo: ".$tipo_respuesta;							
									}
								}
							} else if ($tipo_documento!="" && $tipo_documento== "11"){
								$n_gaceta = $_POST["n_gaceta"];
								$f_gaceta = $ins->formatofecha($_POST["f_gaceta"]);	
								$tipo_gaceta = $_POST["tipo_gaceta"];
																
								if ($n_gaceta!=""){
									// **
									$campos = $campos.", gaceta_n";
									$valores = $valores.", '$n_gaceta'";
									// **	
								}						
								if ($f_gaceta!=""){
									// **
									$campos = $campos.", gaceta_fecha";
									$valores = $valores.", '$f_gaceta'";
									// **
								}													
								if ($tipo_gaceta!=""){
									// **
									$campos = $campos.", gaceta_tipo";
									$valores = $valores.", '$tipo_gaceta'";
									// **
								}													
								$tipo = $tipo.", datos de la gaceta son: ".$n_gaceta.", ".$f_gaceta.", ".$tipo_gaceta;		
							}						
							
							if ($n_documento!=""){
								// **
								$campos = $campos.", n_documento";
								$valores = $valores.", '$n_documento'";
								// **
								$tipo = $tipo.", el documento esta identificado como n: ".$n_documento;
							}					
						}
						
					if($correspondencia!="" && $correspondencia==1)
						{		
							$tipo = "Personal, el remitente responde a: ".$remitente.", el tipo de documento es: ".$tipo_documento.", su correlativo es: ".$codnuevo;
							$remitente = stripslashes($_POST["remitente"]);
							$tipo_documento = stripslashes($_POST["tipo_documento"]);

							$campos = "remitente, id_tipo_documento, n_correlativo";
							$valores = "'$remitente', $tipo_documento, '$codnuevo'";							
					}
					$tipo = $tipo.". El documento tiene fecha: ".$fe_documento;
					$fe_documento = $ins->formatofecha($_POST["fe_documento"]);																			
					$observacion = $ins->codificar(stripslashes($_POST["observacion"]));
					$listAnexo = $ins->codificar(stripslashes($_POST["listAnexo"]));					
					
					if (isset($fe_documento) && $fe_documento!=""){
						// **
						$campos = $campos.", fecha_documento";
						$valores = $valores.", '$fe_documento'";
						// **
					}
					
					if (isset($listAnexo) && $listAnexo!=""){
						// **
						$campos = $campos.", anexo";
						$valores = $valores.", '$listAnexo'";
						// **
						$tipo = $tipo.". Posee estos anexos: ".$listAnexo;						
					}
					
					if (isset($observacion) && $observacion!=""){
						// **

						$campos = $campos.", observacion";
						$valores = $valores.", '$observacion'";
						// **
						$tipo = $tipo.". Posee estas observaciones: ".$observacion;												
					}
					

					if($n_documento!="") {
						if(strtoupper($n_documento)!="S/N") 
						{						
							$search = new Recordset();
							$search->sql = "SELECT id_recepcion_correspondencia FROM crp_recepcion_correspondencia WHERE id_organismo = ".$id_organismo." AND n_documento = '".$n_documento."' AND DATE_FORMAT(fecha_registro,'%Y') = DATE_FORMAT(CURRENT_DATE(),'%Y')";
								$search->abrir();
								if($search->total_registros == 0)
								{
									$ins = new Recordset();
									$ins->sql = "INSERT INTO crp_recepcion_correspondencia ( ".$campos.", tipo_correspondencia, fecha_registro )"." VALUES ( ".$valores.", $correspondencia, '".date("Y-m-d H:i:s")."' )";
									$ins->abrir();
									$ins->cerrar();
									unset($ins);		
									/*bitacora*/bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia n&deg; '".$codnuevo."'","Se registro una Correspondencia de tipo ".$tipo.".");
									
									if(isset($_POST["correlativo_padre"]) && $_POST["correlativo_padre"]!=""){
										$xsxd = stripslashes($_POST["correlativo_padre"]);
										$bsext = new Recordset();
										$bsext->sql = "SELECT crp_correspondencia_externa.n_oficio_externo, crp_correspondencia_externa.id_correspondencia_externa FROM crp_correspondencia_externa WHERE crp_correspondencia_externa.procesado = 1 AND crp_correspondencia_externa.n_oficio_externo = ".$xsxd;
										$bsext->abrir();
										if($bsext->total_registros == 0)
											{	
												$insex = new Recordset();
												$insex->sql = "UPDATE crp_correspondencia_externa SET crp_correspondencia_externa.procesado = 1 WHERE crp_correspondencia_externa.n_oficio_externo = ".$xsxd;
												$insex->abrir();
												$insex->cerrar();
												unset($insex);												
											}
										$bsext->cerrar();
										unset($bsext);																											
									}								
									
									$bsqcor = new Recordset();
									$bsqcor->sql = "SELECT id_recepcion_correspondencia FROM crp_recepcion_correspondencia WHERE n_correlativo ='".$codnuevo."' order by id_recepcion_correspondencia desc limit 1";
									$bsqcor->abrir();
									if($bsqcor->total_registros > 0)
										{	
	
											$bsqcor->siguiente();
											$idrecp = $bsqcor->fila["id_recepcion_correspondencia"];
											$ins1 = new Recordset();
											$ins1->sql = "INSERT INTO crp_ruta_correspondencia ( id_recepcion_correspondencia, id_estatus, fecha_cambio_estatus, fecha_recepcion_digital)"." VALUES ( $idrecp, 7, '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')";
											$ins1->abrir();
											$ins1->cerrar();
											unset($ins1);		
											/*bitacora*/bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Ruta Correspondencia n&deg; '".$codnuevo."'","Se registro un tramo de ruta de la Correspondencia con identificador n&deg;".$idrecp.".");
	
											$ins2 = new Recordset();
											$ins2->sql = "INSERT INTO crp_asignacion_correspondencia ( id_recepcion_correspondencia, id_estatus, fecha_registro)"." VALUES ( $idrecp, 7, '".date("Y-m-d H:i:s")."')";
											$ins2->abrir();
											$ins2->cerrar();
											unset($ins2);		
											/*bitacora*/bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Procesos Internos en Base Datos con n&deg; '".$codnuevo."'","Se registro en la tabla asignaci&oacute;n correspondencia datos correspondientes a los procesos internos, identificador ".$idrecp.".");									
											
											$bg = new Recordset();
											$bg->sql = "SELECT id_ruta_correspondencia FROM crp_ruta_correspondencia WHERE id_recepcion_correspondencia ='".$idrecp."' order by id_recepcion_correspondencia desc limit 1";
											$bg->abrir();
											if($bg->total_registros > 0)
												{
													$bg->siguiente();
													$idruta = $bg->fila["id_ruta_correspondencia"];											
																								
												}
											$ins22 = new Recordset();
											$ins22->sql = "INSERT INTO crp_ubicacion_correspondencia (id_recepcion_correspondencia, id_unidad_recibe, fecha_recepcion_digital, id_ruta_correspondencia)"." VALUES ( $idrecp, 1, '".date("Y-m-d H:i:s")."', $idruta)";
											$ins22->abrir();
											$ins22->cerrar();
											unset($ins22);		
										}
									$bsqcor->cerrar();
									unset($bsqcor);											
									$mensaje = 1;
									
								} else {
									$mensaje = 2;
								}
							$search->cerrar();
							unset($search);											
						} else {
							$ins = new Recordset();
							$ins->sql = "INSERT INTO crp_recepcion_correspondencia ( ".$campos.", tipo_correspondencia, fecha_registro )"." VALUES ( ".$valores.", $correspondencia, '".date("Y-m-d H:i:s")."' )";
							$ins->abrir();
							$ins->cerrar();
							unset($ins);		
							/*bitacora*/bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia n&deg; '".$codnuevo."'","Se registro una Correspondencia de tipo ".$tipo.".");
							
							if(isset($_POST["correlativo_padre"]) && $_POST["correlativo_padre"]!=""){
								$xsxd = stripslashes($_POST["correlativo_padre"]);
								$bsext = new Recordset();
								$bsext->sql = "SELECT crp_correspondencia_externa.n_oficio_externo, crp_correspondencia_externa.id_correspondencia_externa FROM crp_correspondencia_externa WHERE crp_correspondencia_externa.procesado = 1 AND crp_correspondencia_externa.n_oficio_externo = ".$xsxd;
								$bsext->abrir();
								if($bsext->total_registros == 0)
									{	
										$insex = new Recordset();
										$insex->sql = "UPDATE crp_correspondencia_externa SET crp_correspondencia_externa.procesado = 1 WHERE crp_correspondencia_externa.n_oficio_externo = ".$xsxd;
										$insex->abrir();
										$insex->cerrar();
										unset($insex);												
									}
								$bsext->cerrar();
								unset($bsext);																											
							}								
							
							$bsqcor = new Recordset();
							$bsqcor->sql = "SELECT id_recepcion_correspondencia FROM crp_recepcion_correspondencia WHERE n_correlativo ='".$codnuevo."' order by id_recepcion_correspondencia desc limit 1";
							$bsqcor->abrir();
							if($bsqcor->total_registros > 0)
								{	

									$bsqcor->siguiente();
									$idrecp = $bsqcor->fila["id_recepcion_correspondencia"];
									$ins1 = new Recordset();
									$ins1->sql = "INSERT INTO crp_ruta_correspondencia ( id_recepcion_correspondencia, id_estatus, fecha_cambio_estatus, fecha_recepcion_digital)"." VALUES ( $idrecp, 7, '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')";
									$ins1->abrir();
									$ins1->cerrar();
									unset($ins1);		
									/*bitacora*/bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Ruta Correspondencia n&deg; '".$codnuevo."'","Se registro un tramo de ruta de la Correspondencia con identificador n&deg;".$idrecp.".");

									$ins2 = new Recordset();
									$ins2->sql = "INSERT INTO crp_asignacion_correspondencia ( id_recepcion_correspondencia, id_estatus, fecha_registro)"." VALUES ( $idrecp, 7, '".date("Y-m-d H:i:s")."')";
									$ins2->abrir();
									$ins2->cerrar();
									unset($ins2);		
									/*bitacora*/bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Procesos Internos en Base Datos con n&deg; '".$codnuevo."'","Se registro en la tabla asignaci&oacute;n correspondencia datos correspondientes a los procesos internos, identificador ".$idrecp.".");									
									
									$bg = new Recordset();
									$bg->sql = "SELECT id_ruta_correspondencia FROM crp_ruta_correspondencia WHERE id_recepcion_correspondencia ='".$idrecp."' order by id_recepcion_correspondencia desc limit 1";
									$bg->abrir();
									if($bg->total_registros > 0)
										{
											$bg->siguiente();
											$idruta = $bg->fila["id_ruta_correspondencia"];											
																						
										}
									$ins22 = new Recordset();
									$ins22->sql = "INSERT INTO crp_ubicacion_correspondencia (id_recepcion_correspondencia, id_unidad_recibe, fecha_recepcion_digital, id_ruta_correspondencia)"." VALUES ( $idrecp, 1, '".date("Y-m-d H:i:s")."', $idruta)";
									$ins22->abrir();
									$ins22->cerrar();
									unset($ins22);		
								}
							$bsqcor->cerrar();
							unset($bsqcor);											
							$mensaje = 1;
				
						}
					} else {
						$ins = new Recordset();
						$ins->sql = "INSERT INTO crp_recepcion_correspondencia ( ".$campos.", tipo_correspondencia, fecha_registro )"." VALUES ( ".$valores.", $correspondencia, '".date("Y-m-d H:i:s")."' )";
						$ins->abrir();
						$ins->cerrar();
						unset($ins);		
						/*bitacora*/bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Correspondencia n&deg; '".$codnuevo."'","Se registro una Correspondencia de tipo ".$tipo.".");
						$bsqcor = new Recordset();
						$bsqcor->sql = "SELECT id_recepcion_correspondencia FROM crp_recepcion_correspondencia WHERE n_correlativo ='".$codnuevo."' order by id_recepcion_correspondencia desc limit 1";
						$bsqcor->abrir();
						if($bsqcor->total_registros > 0)
							{	
								$bsqcor->siguiente();
								$idrecp = $bsqcor->fila["id_recepcion_correspondencia"];
								$ins1 = new Recordset();
								$ins1->sql = "INSERT INTO crp_ruta_correspondencia ( id_recepcion_correspondencia, id_estatus, fecha_cambio_estatus, fecha_recepcion_digital)"." VALUES ( $idrecp, 7, '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')";
								$ins1->abrir();
								$ins1->cerrar();
								unset($ins1);		
								/*bitacora*/bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Ruta Correspondencia n&deg; '".$codnuevo."'","Se registro un tramo de ruta de la Correspondencia con identificador n&deg;".$idrecp.".");

								$ins2 = new Recordset();
								$ins2->sql = "INSERT INTO crp_asignacion_correspondencia ( id_recepcion_correspondencia, id_estatus, fecha_registro)"." VALUES ( $idrecp, 7, '".date("Y-m-d H:i:s")."')";
								$ins2->abrir();
								$ins2->cerrar();
								unset($ins2);		
								/*bitacora*/bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Procesos Internos en Base Datos con n&deg; '".$codnuevo."'","Se registro en la tabla asignaci&oacute;n correspondencia datos correspondientes a los procesos internos, identificador ".$idrecp.".");									
							
							}
						$bsqcor->cerrar();
						unset($bsqcor);											
						$mensaje = 1;
					}
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
	<tr>
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="45px"><img src="images/recepcion1.png"/></td>
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
			<form method="post" name="recep" id="recep" autocomplete="off"><input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" autocomplete="off"/>
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
						Institucional&nbsp;<input type="radio" name="correspondencia" checked="checked" id="institucional" onclick="tipo_corres(this.id);"  value="0">
						Personal&nbsp;<input type="radio" name="correspondencia" id="personal"  onclick="tipo_corres(this.id);">
					</td>
				</tr>
				<tr id="secc_institucional3">
					<td width="20"></td>				
					<td align="right" valign="top">Organismo:&nbsp;</td>
					<td>
						<textarea name="organismo" id="organismo" style="width:300px; height:55px;" ></textarea>&nbsp;<span class="mensaje">*</span>
						<input type="hidden" name="id_organismo" id="id_organismo" value="<? echo $search->fila["id_organismo"]; ?>"  />					</td>					
				</tr>	
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
						?>&nbsp;<span class="mensaje">*</span>					
					</td>					
				</tr>					
				<tr id="secc_institucional2" style="display:none"> 
					<td width="20"></td>				
					<td align="right">N&deg; Documento:&nbsp;</td>
				    <td>
						<input type="text" name="n_documento" id="n_documento" onkeypress="return validar(event,numeros+letras+'-/.')" maxlength="30" style="width:213px;" />
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
						$rsun->llenarcombo($opciones = "\"tipo_respuesta\"", $checked = "", $fukcion = "onchange=\"informe(this.value)\"" , $diam = "style=\"width:304px; Height:20px;\""); 
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
						<input type="hidden" name="cont_marcados" id="cont_marcados"/>
					</td>
				</tr>
				<tr id="siete" style="display:none">
					<td width="20"></td>
					<td align="right" width="200">
						Gaceta N&deg;:					
					</td>
					<td>
						<input type="text" name="n_gaceta" id="n_gaceta" maxlength="10" onkeypress="return validar(event,numeros+'.')"  />
						<span class="mensaje">*</span>					
					</td>
				</tr>	
				<tr id="nueve" style="display:none">
					<td width="20"></td>
					<td align="right" width="200">
						Fecha:					
					</td>
					<td>
						<input type="text" name="f_gaceta" id="f_gaceta" onkeyup="this.value=formateafecha(this.value);"/>
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
					<td><input type="text" name="fe_documento" id="fe_documento" onkeyup="this.value=formateafecha(this.value,'2017','2013');">&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span></td>					
				</tr>
				<tr id="secc_institucional7" style="display:none">
					<td width="20"></td>				
					<td align="right"  width="180">Remitente:&nbsp;</td>
					<td><input type="text" onblur="formatotexto(this)" name="remitente" id="remitente" style="width:300px" onkeypress="return validar(event,letras)" maxlength="190">&nbsp;<span class="mensaje">*</span></td>					
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
					<td><textarea name="observacion" onblur="formatotexto(this)" id="observacion" style="width:300px; height:105px" onKeyUp="return maximaLongitud(this.id,300);"></textarea>&nbsp;<span class="mensaje">*</span><br /><span style="font-size:9px">M&aacute;ximo 300 Caracteres</span></td>					
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

$(document).ready(function()
{
	valor=$('#ms').val();
	if(valor==1){

		mensaje=acentos('&iexcl;La correspondencia ha sido registrada exitosamente!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
		alert(acentos("El N&uacute;mero Correlativo asignado a la correspondencia es: <? echo $codnuevo; ?>"));
	}
    
	if(valor==2){

		mensaje=acentos('&iexcl;Registro Rechazado, esta correspondencia ha sido registrada anteriormente!')
		$("#mensa").addClass('fallo');
		$('#mensa').html(mensaje);
	}
	setTimeout(function(){$(".escuela").fadeOut(6000);},1000); 
});	
</script>
