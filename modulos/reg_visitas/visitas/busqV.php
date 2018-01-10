<?
require_once("../../../librerias/Recordset.php");
//require_once("bil.php");
?>
<table width="100%" border="0">
	<tr><td height="20"></td></tr>
	<tr>
		<td>
			<fieldset>
			<legend class="titulomenu">&nbsp;Registro del Visitante</legend>	
			<form name="form_agregar" id="form_agregar">	
				<table border="0" class="te_1" width="100%" cellspacing="0">
					<tr>
						<td align="right">
							C&eacute;dula:&nbsp;                                  
						</td>
						<td align="left"><input type="text" name="cedula" id="cedula" maxlength="10" onkeypress="return validar(event,numeros)" value="<? echo stripslashes($_GET["fcedu"]); ?>"/></td>
					</tr>
					<tr>
						<td height="10px" colspan="2">
						</td>
					</tr>								
					<tr>
						<td align="right">
							Nombre y Apellido:&nbsp;                                  
						</td>
						<td align="left"><input type="text" name="nombre" id="nombre" maxlength="149" style="width:250px;" onkeypress="return validar(event,letras)"/></td>
					</tr>
					<tr>
						<td height="10px" colspan="2">
						</td>
					</tr>																
					<tr>
						<td align="right">
							Tel&eacute;fono Contacto:&nbsp;	
						</td>
						<td align="left"><input type="text" name="telef" id="telef" maxlength="12" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_telefonico,false)"/></td>									
					</tr>
					<tr>
						<td height="20px" colspan="2">
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<input type="button" name="registrar" id="registrar" value="Registrar" title="Registrar" onclick="llamar();" />
							&nbsp;
							<input type="reset" name="cancelar" id="cancelar" value="Limpiar" title="Limpiar" />								
							&nbsp;
							<input type="button" class="botones" onclick="window.top.closeMessage();" id="regresar" name="regresar" value="Regresar" title="Regresar" />

						</td>
					</tr>
					<tr><td id="do_up"></td></tr>
				</table>
				</form>
			</fieldset>						
		</td>
	</tr>				
</table>
