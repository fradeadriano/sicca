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
function enviar_in(a){
	if( document.getElementById("usuario").value.length == 0)
	{
		document.getElementById("usuario").value = a;
	}
	
}

//5
function enviar_on(a){
	var primer = document.getElementById("nombres").value;
	var inicial = primer.charAt(0);
	
	var segundo = document.getElementById("apellidos").value;

	document.getElementById("usuario").value = inicial+segundo;
}

//6
function subb()
{
	if (document.getElementById("nombres").value == ""){
		alert(acentos("Debe colocar el nombre del Usuario"));
		return document.getElementById("nombres").focus();
	}

	if (document.getElementById("apellidos").value == ""){
		alert(acentos("Debe colocar el apellido del Usuario"));
		return document.getElementById("apellidos").focus();
	}

	if (document.getElementById("cedula").value == ""){
		alert(acentos("Debe colocar la c&eacute;dula del Usuario"));
		return document.getElementById("cedula").focus();
	}

	if (document.getElementById("usuario").value == ""){
		alert(acentos("Debe colocar el Alias del Usuario"));
		return document.getElementById("usuario").focus();
	}

	if (document.getElementById("cclave").value == ""){
		alert(acentos("Debe colocar una clave"));
		return document.getElementById("cclave").focus();
	}		

	if (document.getElementById("cclave").value != document.getElementById("rep_clave").value){
		alert(acentos("La Clave debe ser Exactamente Igual"));
		return document.getElementById("cclave").focus();		
	}

	document.form_usu.accion.value = document.form_usu.registrar.value;
	document.form_usu.submit();			
	
}

messageObj = new DHTMLSuite.modalMessage();
messageObj.setWaitMessage('Cargando Pantalla..!');
messageObj.setShadowOffset(0);
DHTMLSuite.commonObj.setCssCacheStatus(false);
//7
function displayMessage(url,ancho,largo){
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(ancho,largo);
	messageObj.setShadowDivVisible(false);
	messageObj.display();
}
//8
function closeMessage(){
	messageObj.close();	
}

//9
function cargar_lista_bsq(tr){
	var My_path = tr;
	var spasc = mostrarContenido2;		
	llamarlistado(My_path,spasc);
}
// 10
function mostrarContenido2(){
	document.getElementById("ajaxtd").innerHTML = ajax.response;
}

// 11
function llamarlistado(ruta,spasc){
	ajax = new sack();
	ajax.requestFile = ruta;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}

// 12 
function devolver(id){
	var rut = "modulos/seguridad/usuarios/usuarios_d.php?pagina=1&b_id="+id;
	var spasc = mostrarContenido1;
	llamarlistado(rut,spasc);
	closeMessage();	
}

// 13
function cancel_principal() 
{
	document.getElementById("registrar").value = "Registrar";
	document.getElementById("registrar").title = "Registrar";
	cargar_lista("modulos/seguridad/usuarios/usuarios_d.php?pagina=1");	
}
// 14
function subir(valor,id,uusu,esta,nom,apell,ced){
		document.getElementById("id_usuario").value = id;
		document.getElementById("usuario").value = uusu;	
		document.getElementById("apellidos").value = apell;
		document.getElementById("cedula").value = ced;	
		document.getElementById("estatus").value = esta;				
		document.getElementById("nombres").value = nom;
		document.getElementById("registrar").value = valor;
		document.getElementById("registrar").title = valor;

		document.getElementById("cclave").value = "000000";
		document.getElementById("rep_clave").value = "000000";		
		
}


// 15
function eje(){
		if (document.getElementById("cadena").value!="")
			{	
				var vr = document.getElementById("cadena").value;
				
				if(document.getElementById("user").checked == true){
					var vn = "user";
				} 
				
				if(document.getElementById("apellido").checked == true){
					var vn = "apellido";
				}
				
				if(document.getElementById("nombre").checked == true){
					var vn = "nombre";
				}
				busq_formal(vr,vn);
			} else {
				document.getElementById("cadena").focus();	
			}
}
// 16
function cancel() 
{
	document.getElementById("user").checked = true;
	document.getElementById("cadena").value = "";
	cargar_lista_bsq("modulos/seguridad/usuarios/bsq_list.php?pagina=1");	
}

// 17
function busq_formal(a1,a2){ 
	var My_path = "modulos/seguridad/usuarios/bsq_list.php?pagina=1&pa1="+a1+"&pa2="+a2;
	var spasc = mostrarContenido2;
	llamarlistado(My_path,spasc);
}

// 18

</script>