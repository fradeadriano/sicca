<script language="javascript" type="text/javascript">
var ajax = new sack();
// 1 
function mostrarContenido1(){
	document.getElementById("listusuarios").innerHTML = ajax.response;	
}

// 2
function llamarlistado(ruta,spasc){
	ajax = new sack();
	ajax.requestFile = ruta;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}

// 3
function cargar_lista(rt){ 
	var My_path = rt;
	var spasc = mostrarContenido1;		
	llamarlistado(My_path,spasc);
}

//4
function subb(h){
	
	if(validacion()==false){
			return;
	}	
	document.getElementById("accion").value = h;
	document.getElementById("elegido").value = document.getElementById("elegido").value; 
	document.form_or.submit();
}

function validacion(){
	if (document.getElementById("organismo").value == null || document.getElementById("organismo").value.length == 0 || /^\s+$/.test(document.getElementById("organismo").value))
		{
			alert(acentos("El campo Organ&iacute;smo est&aacute; vacio, por favor completelo"));
			document.getElementById("organismo").focus();
			return false;
		}
}
</script>