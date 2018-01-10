<script language="javascript" type="text/javascript">	
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
//10
var param = "";
function doit(){ //si
	if(validacion()==false){
			return;
	} 	
	var ruta = "modulos/reportes/bateria1/tot_correspondencia/reporte_list.php?condiciones="+param;
	//alert(ruta);	
	cargar_lista_corres(ruta);
}

//11
function validacion() {
param = "";
	
	if (document.getElementById("sel_fecha").value == null || document.getElementById("sel_fecha").value.length == 0 || /^\s+$/.test(document.getElementById("sel_fecha").value))
	{		
			alert(acentos("Seleccione una fecha documento &oacute; registro !!"));
			//document.getElementById("sel_fecha").select();	
			return false;
	} else {
		if (param==""){
			param = "campo1:"+document.getElementById("sel_fecha").value+"_";				
		} else {
			param = param+"!campo1:"+document.getElementById("sel_fecha").value+"_";
		}	
	}
	
	if (document.getElementById("desde").value == null || document.getElementById("desde").value.length == 0 || /^\s+$/.test(document.getElementById("desde").value)){
			alert(acentos("Seleccione una fecha Desde V&aacute;lida!!"));
			document.getElementById("desde").select();	
			return false;
	} else {
		if(validarFecha(document.getElementById("desde").value) == false) {
			alert(acentos("Ingrese una Fecha Desde v&aacute;lida!!"));
			document.getElementById("desde").select();	
			return false;
			}		
		param = param+document.getElementById("desde").value+"_";
	}	
	
	if (document.getElementById("hasta").value == null || document.getElementById("hasta").value.length == 0 || /^\s+$/.test(document.getElementById("hasta").value)){
			alert(acentos("Seleccione una fecha Hasta V&aacute;lida!!"));
			document.getElementById("hasta").select();	
			return false;
	} else {
		if(validarFecha(document.getElementById("hasta").value) == false) {
			alert(acentos("Ingrese una Fecha Hasta v&aacute;lida!!"));
			document.getElementById("hasta").select();	
			return false;
		}	
		param = param+document.getElementById("hasta").value;
	} 
	
	if (document.getElementById("sel_fecha").value.length != 0 && (document.getElementById("desde").value.length == 0 || document.getElementById("hasta").value.length == 0)){
		alert(acentos("Ingresa una fecha desde y hasta!!"));	
		return false;		
	}	

	if(document.getElementById("todo").checked == true){
		param = param+"!campo2:todos";			
	} else if (document.getElementById("especi").checked == true)
	{  
	   var t="";
	   var g=0;
	   for (i=0;i<document.tipos_es.elements.length;i++)
	   {
		  if(document.tipos_es.elements[i].type == "radio")
		  {
			t = document.tipos_es.elements[i].id;
			  if(document.getElementById(t).checked == true)
				{
					param = param+"!campo2:"+t;
					return;
				} else {
					g = g +1;
				}
		  }
		}	
		if(g==4){
			alert(acentos("Debe especificar un par&aacute;metro para efectuar la Totalizaci&oacute;n!!"));
			return false;		
		}
	}
	return param;	
}

//38 
function habil(az){
	if(az=="todo"){
		document.getElementById("estatus").disabled=true;
		document.getElementById("organismo").disabled=true;		
		document.getElementById("unidad").disabled=true;
		document.getElementById("prioridad").disabled=true;		

		document.getElementById("estatus").checked=false;
		document.getElementById("organismo").checked=false;		
		document.getElementById("unidad").checked=false;
		document.getElementById("prioridad").checked=false;				
	} if(az=="especi"){
		document.getElementById("estatus").disabled=false;
		document.getElementById("organismo").disabled=false;		
		document.getElementById("unidad").disabled=false;
		document.getElementById("prioridad").disabled=false;			
	}
}

//39
function resta(){
	document.getElementById("estatus").checked=false;
	document.getElementById("organismo").checked=false;		
	document.getElementById("unidad").checked=false;
	document.getElementById("prioridad").checked=false;				
	document.getElementById("estatus").disabled=true;
	document.getElementById("organismo").disabled=true;		
	document.getElementById("unidad").disabled=true;
	document.getElementById("prioridad").disabled=true;			
	document.getElementById("desde").value="";
	document.getElementById("sel_fecha").value="";	
	document.getElementById("hasta").value="";				
	document.getElementById("todo").checked=true;
}

//40
function exprt(){	
	if (document.getElementById("condiciones").value == null || document.getElementById("condiciones").value.length == 0 || /^\s+$/.test(document.getElementById("condiciones").value)){
			alert(acentos("Ha ocurrido un fallo, por favor vuelva a cargar el Modulo!"));
			document.getElementById("condiciones").focus();
			return false;
	} 				
	document.getElementById("rep").action = "modulos/reportes/bateria1/tot_correspondencia/excel.php";;
	document.getElementById("rep").submit();
}

//41
function graphi_s(){	
	if (document.getElementById("condiciones").value == null || document.getElementById("condiciones").value.length == 0 || /^\s+$/.test(document.getElementById("condiciones").value)){
			alert(acentos("Ha ocurrido un fallo, por favor vuelva a cargar el Modulo!"));
			document.getElementById("condiciones").focus();
			return false;
	} 				
	document.getElementById("gra").action = "modulos/reportes/bateria1/tot_correspondencia/titulo.php";
	document.getElementById("gra").target="_blank";
	document.getElementById("gra").submit();
}
</script>