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
		rt = "modulos/correspondencia/monitoreo_externo/monitoreo_list.php?pagina=1&p_orden="+co+"&met="+metod; 
	} else {
		rt = "modulos/correspondencia/monitoreo_externo/monitoreo_list.php?pagina=1&p_orden="+co+"&met="+metod+"&condiciones="+res; 	
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
function doit(){
	if(validacion()==false){
			return;
	}	
	var ruta = "modulos/correspondencia/monitoreo_externo/monitoreo_list.php?pagina=1&condiciones="+param+"&met=DESC";
//	alert(ruta);	
	cargar_lista_corres(ruta);
}

//11
function validacion() {
var evaluador =0;
param = "";
var f1 = "";
var f2 = "";
		
	if (document.getElementById("estatus").value == null || document.getElementById("estatus").value.length == 0 || /^\s+$/.test(document.getElementById("estatus").value)){
			evaluador = evaluador + 1;
		} else {
			// campo1 = estatus
			if (param==""){
				param = "campo1:"+document.getElementById("estatus").value;				
			} else {
				param = param+"!campo1:"+document.getElementById("estatus").value;							
			}		
		}			
	
	if (document.getElementById("tipOficio").value == null || document.getElementById("tipOficio").value.length == 0 || /^\s+$/.test(document.getElementById("tipOficio").value)){		
			evaluador = evaluador + 1;
		} else {
			// campo2 = noficio
			if (param==""){
				param = "campo2:"+document.getElementById("tipOficio").value;				
			} else {
				param = param+"!campo2:"+document.getElementById("tipOficio").value;							
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
		// campo4 = sel_fecha	
		var f1 = document.getElementById("desde").value;
	}	
	
	if (document.getElementById("hasta").value == null || document.getElementById("hasta").value.length == 0 || /^\s+$/.test(document.getElementById("hasta").value)){
			evaluador = evaluador + 1;
	} else {
		if(validarFecha(document.getElementById("hasta").value) == false) {
			alert(acentos("Ingrese una Fecha Hasta v&aacute;lida!!"));
			document.getElementById("hasta").select();	
			return false;
		}	
		// campo4 = sel_fecha	
		var f2 = document.getElementById("hasta").value;
	} 

	if ((f1.length != 0 && f2.length != 0)){
		if (param==""){
			param = "campo3:"+f1+"_"+f2;				
		} else {
			param = param+"campo3:"+f1+"_"+f2;											
		}		
	}	

	if (document.getElementById("organismo").value == null || document.getElementById("organismo").value.length == 0 || /^\s+$/.test(document.getElementById("organismo").value)){
		evaluador = evaluador + 1;
	} 
	
	if (document.getElementById("id_organismo").value == null || document.getElementById("id_organismo").value.length == 0 || /^\s+$/.test(document.getElementById("id_organismo").value)){
		evaluador = evaluador + 1;
	} else {
		// campo5 = id_organismo	
		if (param==""){
			param = "campo4:"+document.getElementById("id_organismo").value;				
		} else {
			param = param+"!campo4:"+document.getElementById("id_organismo").value;							
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
				param = "campo5:"+document.getElementById("ncorrelativo").value;				
			} else {
				param = param+"!campo5:"+document.getElementById("ncorrelativo").value;							
			}				
		} else {
			alert(acentos("Ingrese un n&deg; correlativo v&aacute;lido!!"));
			document.getElementById("ncorrelativo").select();
			return false;				
		} 
	}			
	
	if (document.getElementById("unidad").value == null || document.getElementById("unidad").value.length == 0 || /^\s+$/.test(document.getElementById("unidad").value)){
		evaluador = evaluador + 1;
	} else {
		// campo9 = unidad	
		if (param==""){
			param = "campo6:"+document.getElementById("unidad").value;				
		} else {
			param = param+"!campo6:"+document.getElementById("unidad").value;							
		}		
	}
	
/*	if (document.getElementById("mensajero").value == null || document.getElementById("mensajero").value.length == 0 || /^\s+$/.test(document.getElementById("mensajero").value)){
			evaluador = evaluador + 1;
		} else {
			// campo1 = estatus
			if (param==""){
				param = "campo7:"+document.getElementById("mensajero").value;				
			} else {
				param = param+"!campo7:"+document.getElementById("mensajero").value;							
			}		
		}*/
		
	if (document.getElementById("noficio").value == null || document.getElementById("noficio").value.length == 0 || /^\s+$/.test(document.getElementById("noficio").value)){
			evaluador = evaluador + 1;
		} else {
			// campo1 = estatus
			if (param==""){
				param = "campo8:"+document.getElementById("noficio").value;				
			} else {
				param = param+"!campo8:"+document.getElementById("noficio").value;							
			}		
		}		
				
	if(evaluador==9){
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
var f1 = "";
var f2 = "";
	if (document.getElementById("estatus").value != "" || document.getElementById("estatus").value.length != 0){		
			// campo1 = tipo_documento
			param = "campo1:"+document.getElementById("estatus").value;	
		}
		
	if (document.getElementById("noficio").value != "" || document.getElementById("noficio").value.length != 0)
	{
		// campo2 = estatus
		if (param==""){
			param = "campo2:"+document.getElementById("noficio").value;				
		} else {
			param = param+"!campo2:"+document.getElementById("noficio").value;							
		}		
	}			
	
	if (document.getElementById("desde").value != "" || document.getElementById("desde").value.length != 0 )
	{
		if(validarFecha(document.getElementById("desde").value) == false) {
			alert(acentos("Ingrese una Fecha Desde v&aacute;lida!!"));
			document.getElementById("desde").select();	
			return false;
		}		
		// campo4 = sel_fecha	
		var f1 = document.getElementById("desde").value;
	}	
	
	if (document.getElementById("hasta").value != "" || document.getElementById("hasta").value.length != 0)
	{
		if(validarFecha(document.getElementById("hasta").value) == false) {
			alert(acentos("Ingrese una Fecha Hasta v&aacute;lida!!"));
			document.getElementById("hasta").select();	
			return false;
		}	
		// campo4 = sel_fecha	
		var f2 = document.getElementById("hasta").value;
	} 

	if ((f1.length != 0 && f2.length != 0)){
		if (param==""){
			param = "campo3:"+f1+"_"+f2;				
		} else {
			param = param+"campo3:"+f1+"_"+f2;											
		}		
	}	

	if (document.getElementById("id_organismo").value != "" || document.getElementById("id_organismo").value.length != 0)
	{
		// campo7 = id_organismo	
		if (param==""){
			param = "campo4:"+document.getElementById("id_organismo").value;				
		} else {
			param = param+"!campo4:"+document.getElementById("id_organismo").value;							
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
				param = "campo5:"+document.getElementById("ncorrelativo").value;				
			} else {
				param = param+"!campo5:"+document.getElementById("ncorrelativo").value;							
			}				
		} else {
			alert(acentos("Ingrese un n&deg; correlativo v&aacute;lido!!"));
			document.getElementById("ncorrelativo").select();
			return;				
		} 	
	}		
		
	if (document.getElementById("unidad").value != "" || document.getElementById("unidad").value.length != 0)
	{
		// campo2 = estatus
		if (param==""){
			param = "campo6:"+document.getElementById("unidad").value;				
		} else {
			param = param+"!campo6:"+document.getElementById("unidad").value;							
		}		
	}			
	
/*	if (document.getElementById("mensajero").value != "" || document.getElementById("mensajero").value.length != 0)
	{
		// campo2 = estatus
		if (param==""){
			param = "campo7:"+document.getElementById("mensajero").value;				
		} else {
			param = param+"!campo7:"+document.getElementById("mensajero").value;							
		}		
	}*/	
	
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
//23
function recibir(){
	var rt = "";
	var spasc = mostrarContenido2;				
	if(document.getElementById("id_corre_ex").value == null || document.getElementById("id_corre_ex").value.length == 0 || /^\s+$/.test(document.getElementById("id_corre_ex").value))
	{
		alert(acentos("Ex&iacute;ste un Fallo, contacte al administrador!!"));
		return false;	
	}
	
	if(document.getElementById("id_re").value == null || document.getElementById("id_re").value.length == 0 || /^\s+$/.test(document.getElementById("id_re").value))
	{
		alert(acentos("Ex&iacute;ste un Fallo, contacte al administrador!!"));
		return false;	
	}	
	
	if (document.getElementById("fentrega").value != "" || document.getElementById("fentrega").value.length != 0 )
	{
		if(validarFecha(document.getElementById("fentrega").value) == false) {
			alert(acentos("Ingrese una Fecha de Entrega v&aacute;lida!!"));
			document.getElementById("fentrega").select();	
			return false;
		}		
	} else {
		alert(acentos("Ingrese una Fecha de Entrega !!"));
		return false;
	}	
	
/*	if (document.getElementById("hentrega").value == "" || document.getElementById("hentrega").value.length == 0)
		{
				alert(acentos("Seleccione una Hora de Entrega v&aacute;lida!!"));
				return false;
		}	
		
	if (document.getElementById("mentrega").value == "" || document.getElementById("mentrega").value.length == 0)
		{
				alert(acentos("Seleccione el Minuto de Entrega v&aacute;lida!!"));
				return false;

		}	
*/	var inff = "";
	//inff = "&fecha="+document.getElementById("fentrega").value+"&hora="+document.getElementById("hentrega").value+"&minuto="+document.getElementById("mentrega").value;
	inff = "&fecha="+document.getElementById("fentrega").value;	
	
	if(window.confirm(acentos('Desea registrar la entrega de la correspondencia?'))) 
		{	
			rt = "modulos/correspondencia/monitoreo_externo/reg_asignacion.php?recep="+document.getElementById("id_corre_ex").value+"&modo=recibir"+"&corres="+document.getElementById("id_re").value+inff; 	
			llamarlistado(rt,spasc);
			alert(acentos("Ha finalizado satisfactoriamente el registro de la entrega!"));
			cargar_lista_corres('modulos/correspondencia/monitoreo_externo/monitoreo_list.php?pagina=1&met=DESC');
			closeMessage();		
		}
}

//26
function mostrarContenido2(){
	document.getElementById("divi").innerHTML = ajax.response;	
}

//27
function anular(){
	var rt = "";
	var spasc = mostrarContenido2;				
	
	if(document.getElementById("id_corre_ex").value == null || document.getElementById("id_corre_ex").value.length == 0 || /^\s+$/.test(document.getElementById("id_corre_ex").value))
	{
		alert(acentos("Ex&iacute;ste un Fallo, contacte al administrador!!"));
		return false;	
	}	
	
	if(window.confirm(acentos('Desea Anular el Oficio?'))) 
		{	
			rt = "modulos/correspondencia/monitoreo_externo/reg_asignacion.php?recep="+document.getElementById("id_corre_ex").value+"&modo=anular"; 	
			llamarlistado(rt,spasc);
			alert(acentos("Ha Anulado satisfactoriamente el Oficio!"));
			cargar_lista_corres('modulos/correspondencia/monitoreo_externo/monitoreo_list.php?pagina=1&met=DESC');
			closeMessage();		
		}
}
</script>