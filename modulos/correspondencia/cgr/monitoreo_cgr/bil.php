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
	window.frames.iesta.location.href="modulos/correspondencia/cgr/monitoreo_cgr/estatus.php";
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
		rt = "modulos/correspondencia/cgr/monitoreo_cgr/monitoreo_list.php?pagina=1&p_orden="+co+"&met="+metod; 
	} else {
		rt = "modulos/correspondencia/cgr/monitoreo_cgr/monitoreo_list.php?pagina=1&p_orden="+co+"&met="+metod+"&condiciones="+res; 	
	}	
	llamarlistado(rt,spasc);
}
//7
var patron = new Array(2,2)
var p_correlativo_cgr = new Array(4,5)
var p_cgr = new Array(2,2,4)

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
	var ruta = "modulos/correspondencia/cgr/monitoreo_cgr/monitoreo_list.php?pagina=1&condiciones="+param+"&met=DESC";
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
	
	if (document.getElementById("unidad").value == null || document.getElementById("unidad").value.length == 0 || /^\s+$/.test(document.getElementById("unidad").value)){
		evaluador = evaluador + 1;
	} else {
		// campo9 = unidad	
		if (param==""){
			param = "campo7:"+document.getElementById("unidad").value;				
		} else {
			param = param+"!campo7:"+document.getElementById("unidad").value;							
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
	
	if (document.getElementById("unidad").value != "" || document.getElementById("unidad").value.length != 0)
	{
		// campo9 = unidad	
		if (param==""){
			param = "campo7:"+document.getElementById("unidad").value;				
		} else {
			param = param+"!campo7:"+document.getElementById("unidad").value;							
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
var launidad = "";
function m_apoyo(q){
	//alert(q.length);
	if(q.length==0){
		document.getElementById("mostrar_apoyo").style.display = "none";		
		launidad = q;
		arreglar();	
	} else {
		if(document.getElementById("positivo").checked == true){
			launidad = q;		
			inabilitar(launidad);			
		} else {
			document.getElementById("mostrar_apoyo").style.display = "";	
			launidad = q;				
		}
	}
}

//17
function Ap_co(f){
	if(f=="positivo"){
		document.getElementById("list_apoyos").style.display = "";		
		inabilitar(launidad);
	} else {
		document.getElementById("list_apoyos").style.display = "none";	
	}	
}

//18
function inabilitar(t){
	if(t!="")
	{
	   for (i=0;i<document.FormAsg.elements.length;i++)
	   {
		  if(document.FormAsg.elements[i].type == "checkbox")
		  {
			  document.FormAsg.elements[i].checked = false;
			  if(document.FormAsg.elements[i].id == t)
				{
					document.FormAsg.elements[i].disabled=true;
				} else {
					document.FormAsg.elements[i].disabled=false;				
				}
		  }
		}	 // se debe hacer una reconsideracion con el var repo
	} 
}
//19
function marcar(p){
	if(document.getElementById("cont_marcados").value!="")
	{
		if (document.getElementById("cont_marcados").value.indexOf(p)==-1){
			document.getElementById("cont_marcados").value = document.getElementById("cont_marcados").value+"-"+p;	
		} else {
			var sui = 0;
			var valor1 = document.getElementById("cont_marcados").value.substr(document.getElementById("cont_marcados").value.indexOf(p),2);
			if (document.getElementById("cont_marcados").value.length != 2)
				{
					if ((document.getElementById("cont_marcados").value.length - 1) == document.getElementById("cont_marcados").value.indexOf(p) && sui == 0)
						{
							valor1 = "-"+valor1;
							sui = 1;
						}
											
					if (document.getElementById("cont_marcados").value.indexOf(p) > 0 && document.getElementById("cont_marcados").value.indexOf(p) < document.getElementById("cont_marcados").value.length && sui == 0)
						{
							valor1 = "-"+valor1;
							sui = 1;
						}
	
					if (document.getElementById("cont_marcados").value.indexOf(p) == 0 && sui == 0)
						{
							valor1 = valor1+"-";
						}
						
					if (document.getElementById("cont_marcados").value.length == 2 && sui == 0)
						{
							valor1 = valor1;
						}						
				}												
			var cadena1 = document.getElementById("cont_marcados").value.replace(valor1, "");
//			alert(cadena1);
			document.getElementById("cont_marcados").value = cadena1;
				}
	} else {
		document.getElementById("cont_marcados").value = p;
	}				
}

//20
function arreglar(){
	document.getElementById("list_apoyos").style.display = "none";
	document.getElementById("mostrar_apoyo").style.display = "none";	
	document.getElementById("cont_marcados").value ="";
	document.getElementById("negativo").checked = true;
	for (i=0;i<document.FormAsg.elements.length;i++)
	{
	  if(document.FormAsg.elements[i].type == "checkbox")
	  {
		document.FormAsg.elements[i].disabled=false;
		document.FormAsg.elements[i].checked = false;				
	  }
	}	 
}
//21
function alone_marcacion(p){
	if(document.getElementById("cont_marcados").value!=""){
		if (document.getElementById("cont_marcados").value.indexOf(p)==-1){
			document.getElementById("cont_marcados").value = document.getElementById("cont_marcados").value+"-"+p;	
		} else {
			var sui = 0;
			if(p.length==1){
				var valor1 = document.getElementById("cont_marcados").value.substr(document.getElementById("cont_marcados").value.indexOf(p),1);
			} else if(p.length==2){
				var valor1 = document.getElementById("cont_marcados").value.substr(document.getElementById("cont_marcados").value.indexOf(p),2);
			}
			if (document.getElementById("cont_marcados").value.length != 1)
				{
					if ((document.getElementById("cont_marcados").value.length - 1) == document.getElementById("cont_marcados").value.indexOf(p) && sui == 0)
						{
							valor1 = "-"+valor1;
							sui = 1;
						}
											
					if (document.getElementById("cont_marcados").value.indexOf(p) > 0 && document.getElementById("cont_marcados").value.indexOf(p) < document.getElementById("cont_marcados").value.length && sui == 0)
						{
							valor1 = "-"+valor1;
							sui = 1;
						}
	
					if (document.getElementById("cont_marcados").value.indexOf(p) == 0 && sui == 0)
						{
							valor1 = valor1+"-";
						}
				}												
			var cadena1 = document.getElementById("cont_marcados").value.replace(valor1, "");
//			alert(cadena1);
			document.getElementById("cont_marcados").value = cadena1;
				}
	} else {
		document.getElementById("cont_marcados").value = p;
	}				
}

//22
function accion_corres(a){
	for (i=0;i<document.FormAsg.elements.length;i++)
	{
	  if(document.FormAsg.elements[i].type == "checkbox")
	  {
		document.FormAsg.elements[i].disabled=false;
		document.FormAsg.elements[i].checked = false;				
	  }
	}
	if(a=="procesar"){
		document.getElementById("cont_marcados").value ="";
		document.getElementById("unidad_Asignar").style.display = "";
		document.getElementById("requie_oficio_exter").style.display = "";						
		document.getElementById("cmbunidad").value ="";	
//		document.getElementById("unidad").options[document.getElementById("unidad").selectedIndex].index = "2";		
		document.getElementById("plazo").value="";
		document.getElementById("vent_plazo").style.display = "none";
		document.getElementById("negativo").checked = true;	
		document.getElementById("mostrar_apoyo").style.display = "none";
		document.getElementById("mostrar_cc1").style.display = "none";		
		document.getElementById("list_apoyos").style.display = "none";
		document.getElementById("si_requiere").checked = true;	
		document.getElementById("most_prioridad").style.display = "";								
	} else if (a=="archivar"){
		document.getElementById("unidad_Asignar").style.display = "none";
		document.getElementById("most_prioridad").style.display = "none";	
		document.getElementById("mostrar_apoyo").style.display = "none";
		document.getElementById("requie_oficio_exter").style.display = "none";								
		document.getElementById("mostrar_cc1").style.display = "";		
		document.getElementById("list_apoyos").style.display = "";
		document.getElementById("cont_marcados").value ="";
		document.getElementById("prioridad").value ="";
		document.getElementById("cmbunidad").value ="";	
		document.getElementById("no_requiere").checked = true;		
	}
	
}

//23
function almacenar(t,h){
var rt = "";
var res = val_Asi(t);		
	//alert(res);
	if(res!=false){
		var spasc = mostrarContenido2;				
		if(t=="Modificar"){
			rt = "modulos/correspondencia/monitoreo/reg_asignacion.php?mandato="+t+"&contador="+h+"&condiciones="+res; 
		} else {
			rt = "modulos/correspondencia/monitoreo/reg_asignacion.php?mandato="+t+"&condiciones="+res; 	
		}
		llamarlistado(rt,spasc);
		alert(acentos("Ha finalizado satisfactoriamente la Asignacion de la correspondencia!"));
		cargar_lista_corres('modulos/correspondencia/monitoreo/monitoreo_list.php?pagina=1&met=DESC');
		closeMessage();		
	}
	window.frames.iesta.location.href="modulos/correspondencia/monitoreo/estatus.php";		
}

//24
function val_Asi(s){
var cadenas = "";	
	if(s=="Modificar"){
		if (document.getElementById("cont_modi").value >= 1){
			alert(acentos("Ya ha sobrepasado el l&iacute;mite de modificaciones posibles por favor comun&iacute;quese con el administrador del sistema"));
			return false;
		} 			
	}
	if(document.getElementById("procesar").checked == true){  ///////procesar
		if (document.getElementById("cmbunidad").value == null || document.getElementById("cmbunidad").value.length == 0 || /^\s+$/.test(document.getElementById("cmbunidad").value)){
				alert(acentos("El campo Asignar a est&aacute; vacio, por favor completelo"));
				document.getElementById("cmbunidad").focus();
				return false;
			} else {
				cadenas = "campo1:"+document.getElementById("cmbunidad").value;
			}	
			
			if(document.getElementById("positivo").checked == true){
				if (document.getElementById("cont_marcados").value == null || document.getElementById("cont_marcados").value.length == 0 || /^\s+$/.test(document.getElementById("cont_marcados").value)){
					alert(acentos("Debido a que Usted indica que la asignaci&oacute;n cuenta con apoyo, debe seleccionar al menos una unidad administrativa"));
					return false;
				} else {
					cadenas = cadenas+"!campo2:"+document.getElementById("cont_marcados").value;
				}
			}

			if(document.getElementById("si_requiere").checked == true)
				{
					if (document.getElementById("prioridad").value == null || document.getElementById("prioridad").value.length == 0 || /^\s+$/.test(document.getElementById("prioridad").value))
					{
						alert(acentos("El campo Prioridad a est&aacute; vacio, por favor completelo"));
						document.getElementById("prioridad").focus();
						return false;
					} else {
						cadenas = cadenas+"!campo3:"+document.getElementById("prioridad").value;
					}
							
					if (document.getElementById("prioridad").value == "1"){
						if (document.getElementById("plazo").value == 0 || document.getElementById("plazo").value == null || document.getElementById("plazo").value.length == 0 || /^\s+$/.test(document.getElementById("plazo").value)){
								alert(acentos("El campo Plazo a est&aacute; vacio, o posee un n&uacute;mero menor a 1 por favor completelo"));
								document.getElementById("plazo").select();
								return false;
							} else {
								cadenas = cadenas+"_"+document.getElementById("plazo").value;
							}			
					}							
				}				
			cadenas = cadenas+"!campo8:"+document.getElementById("procesar").value;
	} else if(document.getElementById("archivar").checked == true) { ///////archivar
		if (document.getElementById("cont_marcados").value == null || document.getElementById("cont_marcados").value.length == 0 || /^\s+$/.test(document.getElementById("cont_marcados").value)){
			alert(acentos("Marque las unidades administrativas la cuales le sera entregada una copia de la correspondencia"));
			return false;
		} else {
			cadenas = "campo5:"+document.getElementById("cont_marcados").value;
		}
		cadenas = cadenas+"!campo8:"+document.getElementById("archivar").value;
	}

	if (document.getElementById("observacion").value == null || document.getElementById("observacion").value.length == 0 || /^\s+$/.test(document.getElementById("observacion").value)){
			alert(acentos("El campo Observaci&oacute;n a est&aacute; vacio, por favor completelo"));
			document.getElementById("observacion").focus();
			return false;
	} else {
		cadenas = cadenas+"!campo4:"+document.getElementById("observacion").value;
	}

	try {
		if (document.getElementById("oficio_padre").value == null || document.getElementById("oficio_padre").value.length == 0 || /^\s+$/.test(document.getElementById("oficio_padre").value)){
			alert(acentos("El campo En respuesta a oficio est&aacute; vacio, por favor completelo"));
			document.getElementById("oficio_padre").focus();
			return false;
		} else {
			// validar oficio padre	
			var con = life(document.getElementById("oficio_padre").value,'accion');
			if(con==false){
				alert(acentos("El N&deg; Oficio ya ha sido utilizado!!, por favor use otro.")); 
				document.getElementById("oficio_padre").select(); 
				return false;
			}
			cadenas = cadenas+"!campo6:"+document.getElementById("oficio_padre").value;
		}
			
	} catch(e) {
		e.name;		
	}
	
	if(document.getElementById("si_requiere").checked == true) {
			cadenas = cadenas+"!campo9:1";
		} else if (document.getElementById("no_requiere").checked == true) {
			cadenas = cadenas+"!campo9:0";
	}

	if (document.getElementById("id_recep").value == null || document.getElementById("id_recep").value.length == 0 || /^\s+$/.test(document.getElementById("id_recep").value)){
			alert(acentos("Administrador: Por Favor cargue nuevamente este formulario"));
			document.getElementById("id_recep").focus();
			return false;
	} else {
		cadenas = cadenas+"!campo7:"+document.getElementById("id_recep").value;
	}

	return cadenas;	
}	

//25
function validar_reque_ofi(g){
	if(g=="si_requiere"){
		document.getElementById("most_prioridad").style.display = "";	
	} else if(g=="no_requiere") {
		document.getElementById("most_prioridad").style.display = "none";		
	}
}

//26
function mostrarContenido2(){
	document.getElementById("divi").innerHTML = ajax.response;	
}

//27
function accion_corres_editar(a){
	if(a=="procesar"){
		document.getElementById("unidad_Asignar").style.display = "";
		document.getElementById("requie_oficio_exter").style.display = "";						
//		document.getElementById("unidad").options[document.getElementById("unidad").selectedIndex].index = "2";		
		document.getElementById("vent_plazo").style.display = "";
		document.getElementById("negativo").checked = true;	
		document.getElementById("mostrar_apoyo").style.display = "";
		document.getElementById("mostrar_cc1").style.display = "none";		
		document.getElementById("list_apoyos").style.display = "none";
		document.getElementById("most_prioridad").style.display = "";								
	} else if (a=="archivar"){
		document.getElementById("unidad_Asignar").style.display = "none";
		document.getElementById("most_prioridad").style.display = "none";	
		document.getElementById("mostrar_apoyo").style.display = "none";
		document.getElementById("requie_oficio_exter").style.display = "none";								
		document.getElementById("mostrar_cc1").style.display = "";		
		document.getElementById("list_apoyos").style.display = "";
		document.getElementById("cont_marcados").value ="";
		document.getElementById("prioridad").value ="";
		document.getElementById("cmbunidad").value ="";	
		document.getElementById("no_requiere").checked = true;		
	}
	
}

//28
function Ap_co_editar(f){
	if(f=="positivo"){
		document.getElementById("list_apoyos").style.display = "";		
		//inabilitar(launidad);
	} else {
		document.getElementById("list_apoyos").style.display = "none";	
	}	
}
//29
function editar(){
	var c ="";
	c = document.getElementById("cont_modi").value;
	almacenar('Modificar',c);
}
//30
function transferir()
{
	var rt = "";
	var resp = veri_tra();		
		//alert(res);
		if(resp!=false){
			rt = "modulos/correspondencia/monitoreo/reg_asignacion.php?mandato=transferir&condiciones="+resp; 
			var spasc = mostrarContenido3;
			llamarlistado(rt,spasc);
			alert(acentos("Ha finalizado satisfactoriamente la Transferencia de la correspondencia!")); 
			cargar_lista_corres('modulos/correspondencia/monitoreo/monitoreo_list.php?pagina=1&met=DESC');
			closeMessage();				
		}
	window.frames.iesta.location.href="modulos/correspondencia/monitoreo/estatus.php";	
}
//31
function veri_tra(){
var cadenas="";
	if (document.getElementById("transferencias").value<=0)
	{

		if (document.getElementById("cmbunidad").value == null || document.getElementById("cmbunidad").value.length == 0 || /^\s+$/.test(document.getElementById("cmbunidad").value)){
				alert(acentos("El campo Transferir a esta vac&iacute;o, por favor seleccione la unidad que recibe la transferencia"));
				document.getElementById("cmbunidad").focus();
				return false;
		} else {
			cadenas = "campo1:"+document.getElementById("cmbunidad").value;
		}
		
		if (document.getElementById("motivo").value == null || document.getElementById("motivo").value.length == 0 || /^\s+$/.test(document.getElementById("motivo").value)){
				alert(acentos("El campo Motivo esta vac&iacute;o, por favor coloque alli el motivo de la transferencia"));
				document.getElementById("motivo").focus();
				return false;
		} else {
			cadenas = cadenas+"!campo2:"+document.getElementById("motivo").value;
		}
		
		if (document.getElementById("id_unidad").value == null || document.getElementById("id_unidad").value.length == 0 || /^\s+$/.test(document.getElementById("id_unidad").value)){
				alert(acentos("Administrador: Por Favor cargue nuevamente este formulario"));
				return false;
		} else {
			cadenas = cadenas+"!campo3:"+document.getElementById("id_unidad").value;
		}
		
		if (document.getElementById("id_recep").value == null || document.getElementById("id_recep").value.length == 0 || /^\s+$/.test(document.getElementById("id_recep").value)){
				alert(acentos("Administrador: Por Favor cargue nuevamente este formulario"));
				document.getElementById("id_recep").focus();
				return false;
		} else {
			cadenas = cadenas+"!campo4:"+document.getElementById("id_recep").value;
		}
		
		if(document.getElementById("id_unidad").value == document.getElementById("cmbunidad").value){
			alert(acentos("Imposible hacer la transferencia: La unidad que cede la transferencia y la que recibe es la misma!!"));	
			return false;	
		}
		
		return cadenas;	

	} else {
		alert(acentos("Imposible hacer la transferencia: Esta correspondencia ha sido anteriormente transferida"));
		return false;	
	}
}

//32
function mostrarContenido3(){
	document.getElementById("diviT").innerHTML = ajax.response;	
}

//33
function recibir(){
	if(window.confirm(acentos('Desea registrar la Recepci&oacute;n de la correspondencia?'))) 
		{	
			rt = "modulos/correspondencia/cgr/monitoreo_cgr/reg_asignacion.php?varEnvi=recibir&id_rece="+document.getElementById("id_recep").value; 	
			var spasc = mostrarContenido4;
			llamarlistado(rt,spasc);
			alert(acentos("Ha finalizado satisfactoriamente la Recepci&oacute;n de la correspondencia!"));
			cargar_lista_corres('modulos/correspondencia/cgr/monitoreo_cgr/monitoreo_list.php?pagina=1&met=DESC');
			closeMessage();		
			window.frames.iesta.location.href="modulos/correspondencia/cgr/monitoreo_cgr/estatus.php";
		}
}

//34
function mostrarContenido4(){
	document.getElementById("diviR").innerHTML = ajax.response;	
}

// 35
function life(zi,desvio){
var contenedor = "";
<? 
	$ma = new Recordset();
	$ma->sql = "SELECT crp_correspondencia_externa.n_oficio_externo FROM crp_correspondencia_externa WHERE crp_correspondencia_externa.procesado = 1";			
	$ma->abrir();
	if($ma->total_registros != 0)
	{
?>
		
		contenedor = new Array(<? echo $ma->total_registros ;?>);
<?		
		for($i=0;$i<$ma->total_registros;$i++)
		{
			$ma->siguiente();
?>
			contenedor[<? echo $i; ?>]= "<? echo $ma->fila["n_oficio_externo"]; ?>";
<?
		}
	}
	$ma->cerrar();
	unset($ma);
?>
var i = ""; 
	for (i=0;i<contenedor.length;i++){
		if(zi==contenedor[i]){
			if(desvio =="accion"){
				return false;
			} else if (desvio=="objeto") {
				alert(acentos("El n&deg; de oficio que introdujo ya ha sido utilizado, por favor verifique!!"));
			}
		}
	}  

}

//36 *
function reg_envio(t){	
	var rt;	
	if (t=="Registrar")
	{
		if(window.confirm(acentos('Desea registrar el Envio de la notificaci&oacute;n?'))) 
			{
				var res = verific(t);		
				if(res!=false){
					var spasc = mostrarContenido2;				
					if(t=="Registrar"){
						//var valhora = document.getElementById("hentrega").value+":"+document.getElementById("mentrega").value;
//						rt = "modulos/correspondencia/cgr/monitoreo_cgr/reg_asignacion.php?mandato="+t+"&ddate="+document.getElementById("fentrega").value+"&dhour="+valhora+"&did="+document.getElementById("id_recepcion_cgr").value+"&idetalle="+document.getElementById("id_detalle").value; id_detalle;
						rt = "modulos/correspondencia/cgr/monitoreo_cgr/reg_asignacion.php?mandato="+t+"&ddate="+document.getElementById("fentrega").value+"&did="+document.getElementById("id_recepcion_cgr").value+"&idetalle="+document.getElementById("id_detalle").value; id_detalle;						
					} 
					
					llamarlistado(rt,spasc);
					alert(acentos("Ha finalizado satisfactoriamente el registro de Envio de la Notificaci&oacute;n!"));
					cargar_lista_corres('modulos/correspondencia/cgr/monitoreo_cgr/monitoreo_list.php?pagina=1&met=DESC');
					closeMessage();		
				}
				window.frames.iesta.location.href="modulos/correspondencia/cgr/monitoreo_cgr/estatus.php";		
			}
	} else if (t=="Finalizar") {
		if(window.confirm(acentos('Desea registrar la Entrega de la notificaci&oacute;n?'))) 
			{
				var res = verific(t);		
				if(res!=false){
					var spasc = mostrarContenido2;				
					if(t=="Finalizar"){
						//var valhora = document.getElementById("hentrega").value+":"+document.getElementById("mentrega").value;
//						rt = "modulos/correspondencia/cgr/monitoreo_cgr/reg_asignacion.php?mandato="+t+"&ddate="+document.getElementById("fentrega").value+"&dhour="+valhora+"&did="+document.getElementById("id_recepcion_cgr").value+"&idetalle="+document.getElementById("id_detalle").value; id_detalle; 
						rt = "modulos/correspondencia/cgr/monitoreo_cgr/reg_asignacion.php?mandato="+t+"&ddate="+document.getElementById("fentrega").value+"&did="+document.getElementById("id_recepcion_cgr").value+"&idetalle="+document.getElementById("id_detalle").value; id_detalle; 						
					} 
					
					llamarlistado(rt,spasc);
					alert(acentos("Ha finalizado satisfactoriamente el registro de Entrega de la Notificaci&oacute;n!"));
					cargar_lista_corres('modulos/correspondencia/cgr/monitoreo_cgr/monitoreo_list.php?pagina=1&met=DESC');
					closeMessage();		
				}
				window.frames.iesta.location.href="modulos/correspondencia/cgr/monitoreo_cgr/estatus.php";		
			}
	}
}

// 37 *
function verific(t){
	switch(t){
		case 'Registrar':
			if(document.getElementById("id_recepcion_cgr").value == null || document.getElementById("id_recepcion_cgr").value.length == 0 || /^\s+$/.test(document.getElementById("id_recepcion_cgr").value))
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
				alert(acentos("Ingrese una Fecha de Envio !!"));
				return false;
			}	
			
/*			if (document.getElementById("hentrega").value == "" || document.getElementById("hentrega").value.length == 0)
				{
					alert(acentos("Seleccione una Hora de Entrega v&aacute;lida!!"));
					return false;
				}	
				
			if (document.getElementById("mentrega").value == "" || document.getElementById("mentrega").value.length == 0)
				{
					alert(acentos("Seleccione el Minuto de Entrega v&aacute;lida!!"));
					return false;
		
				}*/	
		break;

		case 'btnRegistrar_varios':
			if(document.getElementById("id_recepcion_cgr").value == null || document.getElementById("id_recepcion_cgr").value.length == 0 || /^\s+$/.test(document.getElementById("id_recepcion_cgr").value))
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
				alert(acentos("Ingrese una Fecha de Envio !!"));
				return false;
			}	

/*			if (document.getElementById("hentrega").value == "" || document.getElementById("hentrega").value.length == 0)
				{
					alert(acentos("Seleccione una Hora de Entrega v&aacute;lida!!"));
					return false;
				}	
				
			if (document.getElementById("mentrega").value == "" || document.getElementById("mentrega").value.length == 0)
				{
					alert(acentos("Seleccione el Minuto de Entrega v&aacute;lida!!"));
					return false;
		
				}*/	
		break;

	}
}

//38 *
function reg_envio_varios(t){	
	var rt;	
	if (t=="btnRegistrar_varios")
	{
		if(window.confirm(acentos('Desea registrar el Envio de la notificaci&oacute;n?'))) 
			{
				var res = verific(t);		
				if(res!=false){
					var spasc = mostrarContenido2;				
					if(t=="btnRegistrar_varios"){
						//var valhora = document.getElementById("hentrega").value+":"+document.getElementById("mentrega").value;
						//rt = "modulos/correspondencia/cgr/monitoreo_cgr/reg_asignacion.php?mandato="+t+"&ddate="+document.getElementById("fentrega").value+"&dhour="+valhora+"&idetalle="+document.getElementById("notificado").value+"&did="+document.getElementById("id_recepcion_cgr").value; 
						rt = "modulos/correspondencia/cgr/monitoreo_cgr/reg_asignacion.php?mandato="+t+"&ddate="+document.getElementById("fentrega").value+"&idetalle="+document.getElementById("notificado").value+"&did="+document.getElementById("id_recepcion_cgr").value; 	
					} 
					
					llamarlistado(rt,spasc);
					alert(acentos("Ha finalizado satisfactoriamente el registro de Envio de la Notificaci&oacute;n!"));
					cargar_lista_corres('modulos/correspondencia/cgr/monitoreo_cgr/monitoreo_list.php?pagina=1&met=DESC');
					closeMessage();		
				}
				window.frames.iesta.location.href="modulos/correspondencia/cgr/monitoreo_cgr/estatus.php";		
			}
	} else if (t=="Finalizar_varios") {
		if(window.confirm(acentos('Desea registrar la Entrega de la notificaci&oacute;n?'))) 
			{
				var res = verific(t);		
				if(res!=false){
					var spasc = mostrarContenido2;				
					if(t=="Finalizar_varios"){
						//var valhora = document.getElementById("hentrega").value+":"+document.getElementById("mentrega").value;
						//rt = "modulos/correspondencia/cgr/monitoreo_cgr/reg_asignacion.php?mandato="+t+"&ddate="+document.getElementById("fentrega").value+"&dhour="+valhora+"&did="+document.getElementById("id_recepcion_cgr").value+"&idetalle="+document.getElementById("notificado").value; 
						//rt = "modulos/correspondencia/cgr/monitoreo_cgr/reg_asignacion.php?mandato="+t+"&ddate="+document.getElementById("fentrega").value+"&did="+document.getElementById("id_recepcion_cgr").value+"&idetalle="+document.getElementById("notificado").value; 						
					
						if(document.getElementById("si").checked == true)
						{						
							rt = "modulos/correspondencia/cgr/monitoreo_cgr/reg_asignacion.php?mandato="+t+"&ddate="+document.getElementById("fentrega").value+"&idetalle="+document.getElementById("notificado").value+"&did="+document.getElementById("id_recepcion_cgr").value+"&desvio=recibido"; 
						} else if(document.getElementById("no").checked == true){
							rt = "modulos/correspondencia/cgr/monitoreo_cgr/reg_asignacion.php?mandato="+t+"&idetalle="+document.getElementById("notificado").value+"&did="+document.getElementById("id_recepcion_cgr").value+"&desvio=NOrecibido"; 						
						}


					
					
					} 
					
					llamarlistado(rt,spasc);
					alert(acentos("Ha finalizado satisfactoriamente el registro de Entrega de la Notificaci&oacute;n!"));
					cargar_lista_corres('modulos/correspondencia/cgr/monitoreo_cgr/monitoreo_list.php?pagina=1&met=DESC');
					closeMessage();		
				}
				window.frames.iesta.location.href="modulos/correspondencia/cgr/monitoreo_cgr/estatus.php";		
			}
	}
}

//39
function habi_fecha_entre(d){
	if(d=="si"){
		document.getElementById("fecha_entrega_notificacion").style.display = "";
	} else if (d=="no"){
		document.getElementById("fecha_entrega_notificacion").style.display = "none";	
	}
}
</script>
