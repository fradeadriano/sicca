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
						<td align="right" valign="bottom" width="170">
							Organismo:		
						</td>
						<td align="left">
							<textarea name="organismo" id="organismo" style="width:400px; height:50px;" ></textarea>
							<input type="hidden" name="id_organismo" id="id_organismo">		
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
	$("#organismo").autocomplete("lista.php", { 
		width: 400,
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
	
	function blan(){
		document.getElementById("organismo").value = "";
		document.getElementById("id_organismo").value = "";
		llamarlistado("bsq_correspondencia_list.php?pagina=1");
	}


	function iniciar(){ 
		if(document.getElementById("id_organismo").value==""){
			alert("Debe seleccionar un organismo!!")
			return;
		}
		
		if(document.getElementById("organismo").value==""){
			alert("Debe seleccionar un organismo!!")
			return;
		}		
		e = "bsq_correspondencia_list.php?pagina=1&id="+document.getElementById("id_organismo").value;
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