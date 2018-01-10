<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
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
?>
<script type="text/javascript" src="librerias/jq.js"></script>
<script type="text/javascript" src="librerias/jquery.autocomplete.js"></script>
<table border="0" align="center" width="1000">
	<tr> 
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="45px"><img src="images/seguimiento.png"/></td>
					<td class="titulomenu" valign="middle">Seguimiento Correspondencia de la CGR</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center">
			<table border="0" class="b_table">
				<tr>
					<td align="center">
						<fieldset style="width:90%; border-color:#EFEFEF"> 
						<legend class="titulomenu">Opciones Totalizaci&oacute;n</legend>
						<table border="0" width="100%" class="b_table_b" bgcolor="#F2F9FF"  cellpadding="2" cellspacing="0">
							<tr>
								<td align="center" colspan="2">
									Direcci&oacute;n&nbsp;<input type="radio" name="type_to" value="op_organismo" id="op_organismo"  onclick="habil(this.id);"/>
									&nbsp;
									Unidad Administrativa&nbsp;<input type="radio" name="type_to"  value="op_unidad" id="op_unidad" onclick="habil(this.id);" checked="checked"/>
									&nbsp;&nbsp;
								</td>
							</tr>			
							<tr><td height="10" colspan="2" ></td></tr>		
							<tr>															
								<td valign="top" align="right" width="320">
									A&ntilde;o:&nbsp;
								</td>
								<td valign="bottom" colspan="5">
									<? $rsun = new Recordset();	$rsun->sql = "SELECT LEFT(crp_recepcion_correspondencia.`n_correlativo`,4) AS anno, LEFT(crp_recepcion_correspondencia.`n_correlativo`,4) AS id_anno  FROM crp_recepcion_correspondencia GROUP BY anno ORDER BY anno DESC"; 
									$rsun->llenarcombo($opciones = "\"anno\"", $checked = "", $fukcion = "" , $diam = "style=\"width:100px; Height:20px;\""); 
									$rsun->cerrar(); 
									unset($rsun);																						
									?>&nbsp;<span class="mensaje">*</span>
								</td>									
							</tr>																			
							<tr><td height="10" colspan="2" ></td></tr>		
							<tr id="di_organismo" style="display:none">															
								<td valign="top" align="right" width="320">
									Direcci&oacute;n:&nbsp;
								</td>
								<td valign="bottom" colspan="5">
									<textarea name="organismo" id="organismo" style="width:290px; height:60px;" ></textarea>&nbsp;<span class="mensaje">*</span>											
									<input type="hidden" name="id_organismo" id="id_organismo"  />									
								</td>									
							</tr>													
							<tr id="di_unidad">
								<td valign="top" align="right" width="320">
									Unidad Administrativa:&nbsp;
								</td>								
								<td valign="bottom" align="left">
									<? $rsun = new Recordset();	$rsun->sql = "SELECT id_unidad, unidad FROM unidad WHERE id_unidad <> 8  order by unidad"; 
									$rsun->llenarcombo($opciones = "\"unidad\"", $checked = "", $fukcion = "" , $diam = "style=\"width:240px; Height:20px;\""); 
									$rsun->cerrar(); 
									unset($rsun);																						
									?>&nbsp;<span class="mensaje">*</span>																				
								</td>								
							</tr>
							<tr><td height="10" colspan="2" ></td></tr>																							
							<tr>
								<td colspan="4" align="center">
									<input type="button" name="btnFiltra" id="btnFiltra" value="Filtrar" title="Filtrar" onclick="doit();" />
									&nbsp;&nbsp;
									<input type="reset" name="btnCancelar" id="btnCancelar" value="Cancelar" title="Cancelar" onclick="resta();" />								
								</td>								
							</tr>
							<tr><td colspan="3" align="right" class="mensaje">* Campo Obligatorio&nbsp;&nbsp;</td></tr>														
						</table>
						</fieldset>
					</td>
				</tr>
				<tr><td height="7"></td></tr>
				<tr>
					<td align="center">
						<table border="0" class="b_table" width="980" cellpadding="0" cellspacing="0">	
							<tr>
								<td id="zone" colspan="2" align="center" height="20">
									No Ex&iacute;sten datos a mostrar!!
								</td>
							</tr>
						</table>
					</td>
				</tr>								
			</table>
		
		</td>
	</tr>	
</table>
<script language="javascript" type="text/javascript">
	$("#organismo").autocomplete("modulos/reportes/bateria2/seg_correspondencia/lista.php", { 
		width: 290,
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