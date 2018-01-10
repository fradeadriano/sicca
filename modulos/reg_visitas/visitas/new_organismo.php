<?
require_once("../../../librerias/Recordset.php");
//require_once("bil.php");
?>
<table width="100%" border="0">
	<tr><td height="20"></td></tr>
	<tr>
		<td>
			<fieldset>
			<legend class="titulomenu">&nbsp;Registro de Organ&iacute;smo</legend>	
			<form name="form_agregar" id="form_agregar">	
				<table border="0" class="te_1" width="100%" cellspacing="0">
					<tr>
						<td align="right">
							Organ&iacute;smo:&nbsp;						
						</td>
						<td align="left">
							<textarea name="organismo_txt" id="organismo_txt" style="width:360px; height:30px;" onkeypress="return validar(event,letras)"></textarea>
						</td>
					</tr>
					<tr>
						<td height="20px" colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="button" name="registrar" id="registrar" value="Registrar" title="Registrar" onclick="creacion_orga();" />
						  &nbsp;
							<input type="reset" name="cancelar" id="cancelar" value="Limpiar" title="Limpiar" />								
							&nbsp;
							<input type="button" class="botones" onclick="closeMessage();" id="regresar" name="regresar" value="Regresar" title="Regresar" />					  </td>
					</tr>
					<tr ><td >
						<iframe name="ifrm_orga" id="ifrm_orga" width="0" height="0" frameborder="0" src="modulos/reg_visitas/visitas/regi_or.php"></iframe>
					</td></tr>
				</table>
			</form>
			</fieldset>						
		</td>
	</tr>				
</table>
