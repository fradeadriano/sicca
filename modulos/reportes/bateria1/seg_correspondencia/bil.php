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
	var ruta = "modulos/reportes/bateria1/seg_correspondencia/reporte_list.php?condicion="+param;
	//alert(ruta);	
	cargar_lista_corres(ruta);
}

//11
function validacion() {
param = "";
	
	if(document.getElementById("op_organismo").checked == true){
		if (document.getElementById("organismo").value == null || document.getElementById("organismo").value.length == 0 || /^\s+$/.test(document.getElementById("organismo").value))
		{		
				alert(acentos("El campo Organ&iacute;smo no puede estar vac&iacute;o!!"));
				return false;
		} 
		
		if (document.getElementById("id_organismo").value == null || document.getElementById("id_organismo").value.length == 0 || /^\s+$/.test(document.getElementById("id_organismo").value))
		{		
				alert(acentos("Ha ocurrido un fallo!!. Contacte con el Administrador del Sistema"));
				return false;
		}

		param = "campo1:"+document.getElementById("id_organismo").value;				

	} else if (document.getElementById("op_unidad").checked == true) {  

		if (document.getElementById("unidad").value == null || document.getElementById("unidad").value.length == 0 || /^\s+$/.test(document.getElementById("unidad").value))
		{		
				alert(acentos("El campo Unidad no puede estar vac&iacute;o!!"));
				return false;
		}

		param = "campo2:"+document.getElementById("unidad").value;				
	}
	
	if (document.getElementById("anno").value == null || document.getElementById("anno").value.length == 0 || /^\s+$/.test(document.getElementById("anno").value))
	{		
		alert(acentos("El campo A&ntilde;o no puede estar vac&iacute;o!!"));
		return false;
	} else {
		param = param+"!campo3:"+document.getElementById("anno").value;
	}	
	
	return param;	
}

//38 
function habil(az){
	if(az=="op_organismo"){
		document.getElementById("di_organismo").style.display="";
		document.getElementById("di_unidad").style.display="none";		
		document.getElementById("id_organismo").value="";		
		document.getElementById("organismo").value="";
		document.getElementById("unidad").value="";

	} if(az=="op_unidad"){
		document.getElementById("di_organismo").style.display="none";
		document.getElementById("di_unidad").style.display="";		
		document.getElementById("id_organismo").value="";		
		document.getElementById("organismo").value="";
		document.getElementById("unidad").value="";
	}
}

//39
function resta(){
	document.getElementById("di_organismo").style.display="none";
	document.getElementById("di_unidad").style.display="";					
	document.getElementById("op_unidad").checked=true;
	document.getElementById("id_organismo").value="";		
	document.getElementById("organismo").value="";
	document.getElementById("unidad").value="";

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
function graphi_s(o){	
	document.getElementById("condiciones").value = o;
	if (document.getElementById("condiciones").value == null || document.getElementById("condiciones").value.length == 0 || /^\s+$/.test(document.getElementById("condiciones").value)){
			alert(acentos("Ha ocurrido un fallo, por favor vuelva a cargar el Modulo!"));
			document.getElementById("condiciones").focus();
			return false;
	} 	
	document.getElementById("gra").action = "modulos/reportes/bateria1/seg_correspondencia/titulo.php";
	document.getElementById("gra").target="_blank";
	document.getElementById("gra").submit();
}
</script>