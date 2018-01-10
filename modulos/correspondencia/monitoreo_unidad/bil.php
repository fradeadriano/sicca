<script language="javascript" type="text/javascript">	
messageObj = new DHTMLSuite.modalMessage();
messageObj.setWaitMessage('Cargando Pantalla..!');
messageObj.setShadowOffset(0);
DHTMLSuite.commonObj.setCssCacheStatus(false);

//1
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
//2
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
// 3
function llamarlistado(ruta,spasc){
	ajax = new sack();
	ajax.requestFile = ruta;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}
// 4
function mostrarContenido1(){
	document.getElementById("zone").innerHTML = ajax.response;	
}
//5
function cargar_lista_corres(rt){ 
	var spasc = mostrarContenido1;
	llamarlistado(rt,spasc);
}	
//6
function filtrar(co){
	var spasc = mostrarContenido1;
	var metod = "";
	if(document.getElementById("asc").checked == true){
		var metod = "ASC";	
	} else if(document.getElementById("des").checked == true) {
		var metod = "DESC";		
	}	
	var res = validar_campos();		
	if(res==""){
		rt = "modulos/correspondencia/monitoreo_unidad/monitoreo_list.php?pagina=1&Uunidad="+document.getElementById("valorUnidad").value+"&p_orden="+co+"&met="+metod; 
	} else {
		rt = "modulos/correspondencia/monitoreo_unidad/monitoreo_list.php?pagina=1&Uunidad="+document.getElementById("valorUnidad").value+"&p_orden="+co+"&met="+metod+"&condiciones="+res; 	
	}	
	llamarlistado(rt,spasc);
}
//7
var patron = new Array(2,2)
var p_correlativo = new Array(4,5)
function mascara(d,sep,pat,nums){
if(d.valant != d.value){
	val = d.value
	largo = val.length
	val = val.split(sep)
	val2 = ''
	for(r=0;r<val.length;r++){
		val2 += val[r]	
	}
	if(nums){
		for(z=0;z<val2.length;z++){
			if(isNaN(val2.charAt(z))){
				letra = new RegExp(val2.charAt(z),"g")
				val2 = val2.replace(letra,"")
			}
		}
	}
	val = ''
	val3 = new Array()
	for(s=0; s<pat.length; s++){
		val3[s] = val2.substring(0,pat[s])
		val2 = val2.substr(pat[s])
	}
	for(q=0;q<val3.length; q++){
		if(q ==0){
			val = val3[q]
		}
		else{
			if(val3[q] != ""){
				val += sep + val3[q]
				}
		}
	}
	d.value = val
	d.valant = val
	}
}
//8
function mostrar_detalles(k,f){
	var s = ""+k+"";
	var q = ""+f+"";	
	document.getElementById(s).style.display="";
	document.getElementById(q).style.display="none";
}
//9
function ocultar_detalles(l){
	var d = ""+l+"";
	var u;
	u = l.split("_");
	var t;
	t = "img_mas"+u[1];
	var o = ""+t+"";
	document.getElementById(d).style.display="none";
	document.getElementById(o).style.display="";
}
//10
var param = "";
function doit(Uu){
	if(validacion()==false){
			return;
	}	
	var ruta = "modulos/correspondencia/monitoreo_unidad/monitoreo_list.php?pagina=1&Uunidad="+Uu+"&condiciones="+param+"&met=DESC";
	//alert(ruta);	
	cargar_lista_corres(ruta);
}

//11
function validacion() {
var evaluador =0;
param = "";
	if (document.getElementById("tipo_documento").value == null || document.getElementById("tipo_documento").value.length == 0 || /^\s+$/.test(document.getElementById("tipo_documento").value)){		
			evaluador = evaluador + 1;
		} else {
			// campo1 = tipo_documento
			param = "campo1:"+document.getElementById("tipo_documento").value;	
		}
		
	if (document.getElementById("estatus").value == null || document.getElementById("estatus").value.length == 0 || /^\s+$/.test(document.getElementById("estatus").value)){
			evaluador = evaluador + 1;
		} else {
			// campo2 = estatus
			if (param==""){
				param = "campo2:"+document.getElementById("estatus").value;				
			} else {
				param = param+"!campo2:"+document.getElementById("estatus").value;							
			}		
		}			
	
	if (document.getElementById("ndocumento").value == null || document.getElementById("ndocumento").value.length == 0 || /^\s+$/.test(document.getElementById("ndocumento").value)){		
			evaluador = evaluador + 1;
		} else {
			// campo3 = ndocumento
			if (param==""){
				param = "campo3:"+document.getElementById("ndocumento").value;				
			} else {
				param = param+"!campo3:"+document.getElementById("ndocumento").value;							
			}		
		}			
	
	if (document.getElementById("sel_fecha").value == null || document.getElementById("sel_fecha").value.length == 0 || /^\s+$/.test(document.getElementById("sel_fecha").value))
	{		
			evaluador = evaluador + 1;
			var sw = 1;
	} else {
			// campo4 = sel_fecha	
			if (param==""){
				param = "campo4:"+document.getElementById("sel_fecha").value+"_";				
			} else {
				param = param+"!campo4:"+document.getElementById("sel_fecha").value+"_";
			}		
	}
	
	if (document.getElementById("desde").value == null || document.getElementById("desde").value.length == 0 || /^\s+$/.test(document.getElementById("desde").value)){
		evaluador = evaluador + 1;
	} else {
		if(validarFecha(document.getElementById("desde").value) == false) {
			alert(acentos("Ingrese una Fecha Desde v&aacute;lida!!"));
			document.getElementById("desde").select();	
			return false;
			}		
		if(sw == 1) {
			alert(acentos("Debe indicar si la fecha es de Documento o Registro!!"));
			document.getElementById("sel_fecha").focus();	
			sw = 0;
			return false;
		}		
		// campo4 = sel_fecha	
		param = param+document.getElementById("desde").value+"_";
	}	
	
	if (document.getElementById("hasta").value == null || document.getElementById("hasta").value.length == 0 || /^\s+$/.test(document.getElementById("hasta").value)){
			evaluador = evaluador + 1;
	} else {
		if(validarFecha(document.getElementById("hasta").value) == false) {
			alert(acentos("Ingrese una Fecha Hasta v&aacute;lida!!"));
			document.getElementById("hasta").select();	
			return false;
		}	
		if(sw == 1) {
			alert(acentos("Debe indicar si la fecha es de Documento o Registro!!"));
			document.getElementById("sel_fecha").focus();	
			sw = 0;			
			return false;
		} 		
		// campo4 = sel_fecha	
		param = param+document.getElementById("hasta").value;
	} 
	
	if (document.getElementById("sel_fecha").value.length != 0 && (document.getElementById("desde").value.length == 0 || document.getElementById("hasta").value.length == 0)){
		alert(acentos("Ingresa una fecha desde y hasta!!"));	
		return false;		
	}	

	if (document.getElementById("organismo").value == null || document.getElementById("organismo").value.length == 0 || /^\s+$/.test(document.getElementById("organismo").value)){
		evaluador = evaluador + 1;
	} 
	
	if (document.getElementById("id_organismo").value == null || document.getElementById("id_organismo").value.length == 0 || /^\s+$/.test(document.getElementById("id_organismo").value)){
		evaluador = evaluador + 1;
	} else {
		// campo5 = id_organismo	
		if (param==""){
			param = "campo5:"+document.getElementById("id_organismo").value;				
		} else {
			param = param+"!campo5:"+document.getElementById("id_organismo").value;							
		}		
	}	
	
	if (document.getElementById("ncorrelativo").value == null || document.getElementById("ncorrelativo").value.length == 0 || /^\s+$/.test(document.getElementById("ncorrelativo").value)){
			evaluador = evaluador + 1;
	} else {
		var cad = document.getElementById("ncorrelativo").value.split("-");
		if (cad.length==2)
		{
		
			if(cad[0] !="" && cad[0].length !=4){
				alert(acentos("Ingrese el n&deg; de correlativo con toda la cantidad de caracteres!!"));
				document.getElementById("ncorrelativo").select();	
				return false;		
			}
	
			if(cad[1] !="" && cad[1].length != 5){
				alert(acentos("Ingrese el n&deg; de correlativo con toda la cantidad de caracteres!!"));
				document.getElementById("ncorrelativo").select();
				return false;		
			}
				
			// campo6 = ncorrelativo	
			if (param==""){
				param = "campo6:"+document.getElementById("ncorrelativo").value;				
			} else {
				param = param+"!campo6:"+document.getElementById("ncorrelativo").value;							
			}				
		} else {
			alert(acentos("Ingrese un n&deg; correlativo v&aacute;lido!!"));
			document.getElementById("ncorrelativo").select();
			return false;				
		} 
	}		
	
	if (document.getElementById("prioridad").value == null || document.getElementById("prioridad").value.length == 0 || /^\s+$/.test(document.getElementById("prioridad").value)){
		evaluador = evaluador + 1;
	} else {
		// campo9 = unidad	
		if (param==""){
			param = "campo7:"+document.getElementById("prioridad").value;				
		} else {
			param = param+"!campo7:"+document.getElementById("prioridad").value;							
		}		
	}	
	
	if(evaluador==10){
		alert(acentos("Ingrese al menos un criterio de b&uacute;squeda v&aacute;lido para realizar el filtrado!!"));
		return false;		
	} 	
	return param;	
}
//12
function displayMessage(url,ancho,largo){
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(ancho,largo);
	messageObj.setShadowDivVisible(false);
	messageObj.display();
}
//13
function closeMessage(){
	messageObj.close();	
}
//14
function validar_campos() {
param = "";
sw = 0;
	if (document.getElementById("tipo_documento").value != "" || document.getElementById("tipo_documento").value.length != 0){		
			// campo1 = tipo_documento
			param = "campo1:"+document.getElementById("tipo_documento").value;	
		}
		
	if (document.getElementById("estatus").value != "" || document.getElementById("estatus").value.length != 0)
	{
		// campo2 = estatus
		if (param==""){
			param = "campo2:"+document.getElementById("estatus").value;				
		} else {
			param = param+"!campo2:"+document.getElementById("estatus").value;							
		}		
	}			
	
	if (document.getElementById("ndocumento").value != "" || document.getElementById("ndocumento").value.length != 0)
	{		
		// campo3 = ndocumento
		if (param==""){
			param = "campo3:"+document.getElementById("ndocumento").value;				
		} else {
			param = param+"!campo3:"+document.getElementById("ndocumento").value;							
		}		
	}			
	
	if (document.getElementById("sel_fecha").value != "" || document.getElementById("sel_fecha").value.length != 0)
	{		
		sw = 0;
		// campo4 = sel_fecha	
		if (param==""){
			param = "campo4:"+document.getElementById("sel_fecha").value+"_";				
		} else {
			param = param+"!campo4:"+document.getElementById("sel_fecha").value+"_";
		}		
	}
	
	if (document.getElementById("desde").value != "" || document.getElementById("desde").value.length != 0)
	{
		if(validarFecha(document.getElementById("desde").value) == false) {
			alert(acentos("Ingrese una Fecha Desde v&aacute;lida!!"));
			document.getElementById("desde").select();	
			return;
			}		
		if(sw == 1) {
			alert(acentos("Debe indicar si la fecha es de Documento o Registro!!"));
			document.getElementById("sel_fecha").focus();	
			sw = 0;
			return;
		}		
		// campo4 = sel_fecha	
		param = param+document.getElementById("desde").value+"_";
	}	
	
	if (document.getElementById("hasta").value != "" || document.getElementById("hasta").value.length != 0)
	{
		if(validarFecha(document.getElementById("hasta").value) == false) {
			alert(acentos("Ingrese una Fecha Hasta v&aacute;lida!!"));
			document.getElementById("hasta").select();	
			return;
		}	
		if(sw == 1) {
			alert(acentos("Debe indicar si la fecha es de Documento o Registro!!"));
			document.getElementById("sel_fecha").focus();	
			sw = 0;			
			return;
		} 		
		// campo4 = sel_fecha	
		param = param+document.getElementById("hasta").value;
	} 	 
	
	if (document.getElementById("id_organismo").value != "" || document.getElementById("id_organismo").value.length != 0)
	{
		// campo7 = id_organismo	
		if (param==""){
			param = "campo5:"+document.getElementById("id_organismo").value;				
		} else {
			param = param+"!campo5:"+document.getElementById("id_organismo").value;							
		}		
	}	
	
	if (document.getElementById("ncorrelativo").value != "" || document.getElementById("ncorrelativo").value.length != 0)
	{
		var cad = document.getElementById("ncorrelativo").value.split("-");	
		if (cad.length==2)
		{
			if(cad[0] !="" && cad[0].length !=4){
				alert(acentos("Ingrese el n&deg; de correlativo con toda la cantidad de caracteres!!"));
				document.getElementById("ncorrelativo").select();	
				return;		
			}
	
			if(cad[1] !="" && cad[1].length != 5){
				alert(acentos("Ingrese el n&deg; de correlativo con toda la cantidad de caracteres!!"));
				document.getElementById("ncorrelativo").select();
				return;		
			}
				
			// campo6 = ncorrelativo	
			if (param==""){
				param = "campo6:"+document.getElementById("ncorrelativo").value;				
			} else {
				param = param+"!campo6:"+document.getElementById("ncorrelativo").value;							
			}				
		} else {
			alert(acentos("Ingrese un n&deg; correlativo v&aacute;lido!!"));
			document.getElementById("ncorrelativo").select();
			return;				
		} 	
	}		
	
	if (document.getElementById("prioridad").value != "" || document.getElementById("prioridad").value.length != 0)
	{
		// campo9 = unidad	
		if (param==""){
			param = "campo7:"+document.getElementById("prioridad").value;				
		} else {
			param = param+"!campo7:"+document.getElementById("prioridad").value;							
		}		
	}	
	
	if (document.getElementById("sel_fecha").value.length != 0 && (document.getElementById("desde").value.length == 0 || document.getElementById("hasta").value.length == 0))
	{
		alert(acentos("Ingresa una fecha desde y hasta!!"));	
		return;		
	}	
	
	return param;	
}
//15
function esta_prioridad(f){
	if(f=="1"){
		document.getElementById("vent_plazo").style.display = "";
		document.getElementById("plazo").value="";				
	} else if (f=="2") {
		document.getElementById("vent_plazo").style.display = "none";	
	} else {
		document.getElementById("vent_plazo").style.display = "none";		
	}
}
//16
function recibir(){
	var rt = "";
	var spasc = mostrarContenido2;				
	if(document.getElementById("id_recep").value == null || document.getElementById("id_recep").value.length == 0 || /^\s+$/.test(document.getElementById("id_recep").value))
	{
		alert(acentos("Ex&iacute;ste un Fallo, contacte al administrador!!"));
		return false;	
	}
	
	if(document.getElementById("id_unidad").value == null || document.getElementById("id_unidad").value.length == 0 || /^\s+$/.test(document.getElementById("id_unidad").value))
	{
		alert(acentos("Ex&iacute;ste un Fallo, contacte al administrador!!"));
		return false;	
	}
		
	if(window.confirm(acentos('Desea registrar la recepci&oacute;n de la correspondencia?'))) 
		{	
			rt = "modulos/correspondencia/monitoreo_unidad/reg_asignacion.php?recep="+document.getElementById("id_recep").value+"&unidad="+document.getElementById("id_unidad").value+"&Ha=recib"; 	
			llamarlistado(rt,spasc);
			alert(acentos("Ha finalizado satisfactoriamente la Recepci&oacute;n de la correspondencia!"));
			cargar_lista_corres('modulos/correspondencia/monitoreo_unidad/monitoreo_list.php?pagina=1&Uunidad='+document.getElementById("id_unidad").value+'&met=DESC');
			closeMessage();		
		}
}

//17
function mostrarContenido2(){
	document.getElementById("divi").innerHTML = ajax.response;	
}

// 18  
function habilitar(){
	var rt = "";
	var spasc = mostrarContenido2;				
	if(document.getElementById("id_recep").value == null || document.getElementById("id_recep").value.length == 0 || /^\s+$/.test(document.getElementById("id_recep").value))
	{
		alert(acentos("Ex&iacute;ste un Fallo, contacte al administrador!!"));
		return false;	
	}
		
	if(window.confirm(acentos('Desea habilitar la correspondencia?'))) 
		{	
			rt = "modulos/correspondencia/monitoreo_unidad/reg_asignacion.php?recep="+document.getElementById("id_recep").value+"&Ha=habilitar";	
			llamarlistado(rt,spasc);
			alert(acentos("Ha finalizado satisfactoriamente la Habilitaci&oacute;n de la correspondencia!"));
			cargar_lista_corres('modulos/correspondencia/monitoreo_unidad/monitoreo_list.php?pagina=1&Uunidad='+document.getElementById("id_unidad").value+'&met=DESC');
			closeMessage();		
		}
}

//19
function recibirCopia(v){
	var rt = "";
	var spasc = mostrarContenido2;				
	if(document.getElementById("id_recep").value == null || document.getElementById("id_recep").value.length == 0 || /^\s+$/.test(document.getElementById("id_recep").value))
	{
		alert(acentos("Ex&iacute;ste un Fallo, contacte al administrador!!"));
		return false;	
	}
	
	if(document.getElementById("id_unidad").value == null || document.getElementById("id_unidad").value.length == 0 || /^\s+$/.test(document.getElementById("id_unidad").value))
	{
		alert(acentos("Ex&iacute;ste un Fallo, contacte al administrador!!"));
		return false;	
	}
		
	if(window.confirm(acentos('Desea registrar la recepci&oacute;n de la correspondencia?'))) 
		{	
			rt = "modulos/correspondencia/monitoreo_unidad/reg_asignacion.php?recep="+document.getElementById("id_recep").value+"&unidad="+document.getElementById("id_unidad").value+"&Ha=copia"; 	
			llamarlistado(rt,spasc);
			alert(acentos("Ha finalizado satisfactoriamente la Recepci&oacute;n de la correspondencia!"));
			cargar_lista_corres('modulos/correspondencia/monitoreo_unidad/monitoreo_list.php?pagina=1&Uunidad='+document.getElementById("id_unidad").value+'&met=DESC');
			closeMessage();		
		}
}
</script>