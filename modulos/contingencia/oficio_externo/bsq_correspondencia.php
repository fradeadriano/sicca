<script type="text/javascript" src="../../../librerias/jq.js"></script>
<script type="text/javascript" src="../../../librerias/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../../librerias/dhtml/ajax.js"></script>
<? //include("bil.php"); ?>
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<fieldset style="width:675px; border-color:#EFEFEF"> 
<legend class="titulomenu">Opciones de Busqueda</legend>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<table border="0" width="100%">
					<tr align="center">
						<td align="right" valign="bottom" width="290">
							N&deg; Oficio:		
						</td>
						<td align="left">
							<input type="text" id="Boficio" name="Boficio" />
						</td>
					</tr>
					<tr><td></td></tr>
					<tr>
						<td colspan="2" align="center">
							<input type="button" name="bus" id="bus" value="Buscar" title="Buscar" onclick="iniciar(this.id);" />
							&nbsp;
							<input type="button" class="botones" onclick="blan();" id="lim" name="lim" value="Limpiar" title="Limpiar" />
							&nbsp;
							<input type="button" class="botones" onclick="window.parent.closeMessage();" id="regresar" name="regresar" value="Regresar" title="Regresar" />							
						</td>
					</tr>
					<tr><td height="5"></td></tr>
				</table>											
			</td>
		</tr>
		<tr>
			<td id="ajaxtd">&nbsp;</td>
		</tr>
	</table>
</fieldset>
<script language="javascript" type="text/javascript">
	function orto(x){
		x = x.replace(/ó/g,"\xF3");	x = x.replace(/&oacute;/g,"\xF3");
		x = x.replace(/á/g,"\xE1");	x = x.replace(/&aacute;/g,"\xE1");	
		return x;
	}

	function blan(){
		document.getElementById("Boficio").value = "";
		llamarlistado("bsq_correspondencia_list.php?pagina=1");
	}

	function iniciar(){ 
		if(document.getElementById("Boficio").value==""){
			alert(orto("Debe Agregar un N&deg; de oficio!!"));
			return;
		}
		
		e = "bsq_correspondencia_list.php?pagina=1&id="+document.getElementById("Boficio").value;
		llamarlistado(e);
	}
	// 20
	function mostrarContenido1(){
		document.getElementById("ajaxtd").innerHTML = ajax.response;	
	}
	//21
	function llamarlistado(t){
		ajax = new sack();
		ajax.requestFile = t
		ajax.onCompletion = mostrarContenido1;
		ajax.runAJAX();
	}
	
	function la(q){
		window.parent.frames.framo.location.href='form.php?id_recepcion='+q;
		window.parent.document.getElementById("mostrar").style.display="";
	//	window.frames.corres.location.href='modulos/correspondencia/procesar/procesar.php?id_recepcion=7';
		window.parent.closeMessage();	
	}	
</script>

<? echo '<script language="javascript" type="text/javascript">llamarlistado("'.'bsq_correspondencia_list.php?pagina=1");</script>'; ?>