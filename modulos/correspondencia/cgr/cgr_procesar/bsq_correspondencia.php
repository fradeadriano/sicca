<fieldset style="width:675px; border-color:#EFEFEF"> 
<legend class="titulomenu">Lista Correspondencias</legend>	
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td id="ajaxtd">&nbsp;</td>
	</tr>
</table>
</fieldset>
<? $condi = $_GET["condicion"]; echo '<script language="javascript" type="text/javascript">cargar_lista("'.'modulos/correspondencia/cgr/cgr_procesar/bsq_correspondencia_list.php?pagina=1&condicion='.$condi.'");</script>'; ?>