<script language="javascript" type="text/javascript">
//1
function mostrarContenido1(){
	document.getElementById("lista").innerHTML = ajax.response;	
}

//2
function subb()
{
	var parametros;
	
	if (document.getElementById("desde").value == null || document.getElementById("desde").value.length == 0 || /^\s+$/.test(document.getElementById("desde").value))
	{
		alert(acentos("El campo fecha Desde est&aacute; vacio, por favor completelo"));
		document.getElementById("desde").focus();
		return;
	} else {
		parametros = "dsd:"+document.getElementById("desde").value; 
	}				
				
	if(validarFecha(document.getElementById("desde").value) == false) 
	{
		alert(acentos("Ingrese una Fecha Desde v&aacute;lida!!"));
		document.getElementById("desde").select();	
		return;
	}
	
	if (document.getElementById("hasta").value == null || document.getElementById("hasta").value.length == 0 || /^\s+$/.test(document.getElementById("hasta").value))
	{
			alert(acentos("El campo fecha Hasta est&aacute; vacio, por favor completelo"));
			document.getElementById("hasta").focus();
			return;
	} else {
		parametros = parametros+"_hst:"+document.getElementById("hasta").value; 
	}				
							
	if(validarFecha(document.getElementById("hasta").value) == false) 
	{
		alert(acentos("Ingrese una Fecha Hasta v&aacute;lida!!"));
		document.getElementById("hasta").select();	
		return;
	}
	
	
	if (document.getElementById("usuario").value != "")
	{
		parametros = parametros+"_usu:"+document.getElementById("usuario").value;
	}				

	var My_path = "modulos/seguridad/auditoria/auditoria_d.php?parametros1="+parametros;
	var spasc = mostrarContenido1;
	llamarlistado(My_path,spasc);


}

//3
function llamarlistado(ruta,spasc){
	ajax = new sack();
	ajax.requestFile = ruta;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}

//4
function cargar_lista(rt){ 
	var My_path = rt;
	var spasc = mostrarContenido1;		
	llamarlistado(My_path,spasc);
}
</script>