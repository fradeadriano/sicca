<? 
	require_once("bil.php");
?>
<script language="javascript" type="text/javascript">
	aut('<? echo $_POST["elegido"]; ?>');
</script>
<script type="text/javascript" src="librerias/jq.js"></script>
<script type="text/javascript" src="librerias/jquery.autocomplete.js"></script>
<table border="0" align="center" width="700">
	<tr>
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="45px"><img src="images/recepcion1.png"/></td>
					<td class="titulomenu" valign="middle">Editar Oficios Enviados</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="barra" /></td>
				</tr>
			</table>
		</td>
	</tr>		
	<tr>
		<td align="center">
			<table width="99%" border="0" class="b_table" cellpadding="3" cellspacing="3">
				<tr>
					<td align="center">
						Buscar Oficio:&nbsp;<input type="button" onclick="dosearch();" name="bsq" id="bsq" value="--" title="Buscar Oficio" />
					</td>
				</tr>
				<tr>
					<td><hr class="barra" /></td>
				</tr>				
				<tr id="mostrar" style="display:">
					<td>
						<iframe src="modulos/contingencia/oficio_externo/form.php" name="framo" id="framo" width="100%" height="400" frameborder="0"></iframe>
					</td>
				</tr>
			</table>				
		</td>
	</tr>
</table>