<form  name="busqueda" autocomplete="off">        
<table width="90%" border="0" align="center">
	<tr>
		<td align="center">
			<fieldset class="fieldset">
			<legend class="titulomenu">B&uacute;squeda Por</legend>            
			<table class="texto" width="500"  align="center" border="0">
				<tr>
					<td align="center"> 
					<td> 
						Usuario:<input type="radio" name="selec" id="user" checked="checked" />
						&nbsp;Apellido:<input type="radio" name="selec" id="apellido" />
						&nbsp;&nbsp;
						Nombre:&nbsp;<input type="radio" name="selec" id="nombre"/>
                        &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="text" name="cadena"  class="caja_de_texto" style="width:200px" id="cadena" />
					</td>
					</td>
				</tr>
				<tr><td height="10" colspan="2"></td></tr>
                <tr>
					<td colspan="2" align="center">
						<input type="button" class="botones" value="Buscar" title="Buscar" onclick="eje();" />
						&nbsp;
						<input type="button" class="botones" onclick="cancel();" name="cancelar" value="Cancelar" title="Cancelar" />
						&nbsp;
						<input type="button" class="botones" onclick="closeMessage();" id="regresar" name="regresar" value="Regresar" title="Regresar" />
						<input type="hidden" name="pagina" value="1" />
					</td>
				</tr>    
			</table>
			</fieldset>
        </td>
    </tr>
	<tr>
		<td align="center" >
			<fieldset>
			<legend class="titulomenu">&nbsp;Listado de Usuarios&nbsp;</legend>										
			<table width="100%" border="0">
				<tr>
					<td id="ajaxtd">&nbsp;</td>
				</tr>
			</table>
			</fieldset>										
		</td>
	</tr>    
</table>
</form>
<? echo '<script language="javascript" type="text/javascript">cargar_lista_bsq("'.'modulos/seguridad/usuarios/bsq_list.php?pagina=1'.'");</script>'; ?>