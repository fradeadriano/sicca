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
function entsub(event) {
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
//3
function rpts(pa){
	if (pa=="positivo"){
		document.getElementById("uno").style.display="";
		document.getElementById("dos").style.display="";	
/*					
		document.getElementById("cinco").style.display="";*/						
		document.getElementById("positivo").value =  "rsp_positiva";
		document.getElementById("negativo").value = "";
		document.getElementById("tipo_respuesta").value="";
		document.getElementById("correlativo_padre").value=""
	}

	if (pa=="negativo"){
		document.getElementById("uno").style.display="none";
		document.getElementById("dos").style.display="none";			
		
					
		document.getElementById("cinco").style.display="none";								
		document.getElementById("negativo").value = "rsp_negativa";
		document.getElementById("positivo").value =  "";		
		
	}

}
//4

function Ap_co(f){
	if(f=="positivo"){
		document.getElementById("list_apoyos").style.display = "";		
		inabilitar(launidad);
	} else {
		document.getElementById("list_apoyos").style.display = "none";	
		marcar('');
		document.getElementById("cont_marcados").value = "";

	}	
}

//18
function inabilitar(t){
	if(t!="")
	{
	   for (i=0;i<document.recep.elements.length;i++)
	   {
		  if(document.recep.elements[i].type == "checkbox")
		  {
			  document.recep.elements[i].checked = false;
			  if(document.recep.elements[i].id == t)
				{
					document.recep.elements[i].disabled=true;
				} else {
					document.recep.elements[i].disabled=false;				
				}
		  }
		}	 // se debe hacer una reconsideracion con el var repo
	} 
}
// 5
function editar(p){
	if(validacion()==false){
			return;
	}	
	document.getElementById("accion").value = p;

	//alert(document.getElementById("observacion").value);
	document.recep.submit();

}
//6
function validacion() {
	if(document.getElementById("procesar").checked == true){  ///////procesar
		if (document.getElementById("cmbunidad").value == null || document.getElementById("cmbunidad").value.length == 0 || /^\s+$/.test(document.getElementById("cmbunidad").value)){
				alert(acentos("El campo Asignar a est&aacute; vacio, por favor completelo"));
				document.getElementById("cmbunidad").focus();
				return false;
			} 
			
			if(document.getElementById("positivo").checked == true){
				if (document.getElementById("cont_marcados").value == null || document.getElementById("cont_marcados").value.length == 0 || /^\s+$/.test(document.getElementById("cont_marcados").value)){
					alert(acentos("Debido a que Usted indica que la asignaci&oacute;n cuenta con apoyo, debe seleccionar al menos una unidad administrativa"));
					return false;
				} 
			}

			if(document.getElementById("si_requiere").checked == true)
				{
					if (document.getElementById("prioridad").value == null || document.getElementById("prioridad").value.length == 0 || /^\s+$/.test(document.getElementById("prioridad").value))
					{
						alert(acentos("El campo Prioridad a est&aacute; vacio, por favor completelo"));
						document.getElementById("prioridad").focus();
						return false;
					} 
							
					if (document.getElementById("prioridad").value == "1"){
						if (document.getElementById("plazo").value == 0 || document.getElementById("plazo").value == null || document.getElementById("plazo").value.length == 0 || /^\s+$/.test(document.getElementById("plazo").value)){
								alert(acentos("El campo Plazo a est&aacute; vacio, o posee un n&uacute;mero menor a 1 por favor completelo"));
								document.getElementById("plazo").select();
								return false;
							} 			
					}							
				}				
	} else if(document.getElementById("archivar").checked == true) { ///////archivar
		if (document.getElementById("cont_marcados").value == null || document.getElementById("cont_marcados").value.length == 0 || /^\s+$/.test(document.getElementById("cont_marcados").value)){
			alert(acentos("Marque las unidades administrativas la cuales le sera entregada una copia de la correspondencia"));
			return false;
		} 
		
	}

	if (document.getElementById("observacion").value == null || document.getElementById("observacion").value.length == 0 || /^\s+$/.test(document.getElementById("observacion").value)){
			alert(acentos("El campo Observaci&oacute;n a est&aacute; vacio, por favor completelo"));
			document.getElementById("observacion").focus();
			return false;
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
		}
			
	} catch(e) {
		e.name;		
	}
	 

}
// 7
function IsNumeric(valor){ 
	var log=valor.length; var sw="S"; 
	for (x=0; x<log; x++) 
	{ v1=valor.substr(x,1); 
	v2 = parseInt(v1); 
	//Compruebo si es un valor numérico 
	if (isNaN(v2)) { sw= "N";} 
	} 
	if (sw=="S") {return true;} else {return false; } 
} 
// 8
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

// 9 
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
//10
function cancelarT(){
	window.parent.frames.framo.location.href='form.php';	
}
// 11
function accion_corres(a){
	for (i=0;i<document.recep.elements.length;i++)
	{
	  if(document.recep.elements[i].type == "checkbox")
	  {
		document.recep.elements[i].disabled=false;
		document.recep.elements[i].checked = false;				
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
//12
function informe (f){
	if(f=="1" || f=="2"){
		
		document.getElementById("cinco").style.display="";		
	} else {
		
		document.getElementById("cinco").style.display="none";			
	   for (i=0;i<document.recep.elements.length;i++)
	   {
		  if(document.recep.elements[i].type == "checkbox")
		  {
			 document.recep.elements[i].checked=0;	
		  }
		}		
	}
}
// 13
function validar_reque_ofi(g){
	if(g=="si_requiere"){
		document.getElementById("most_prioridad").style.display = "";	
	} else if(g=="no_requiere") {
		document.getElementById("most_prioridad").style.display = "none";	
		document.getElementById("prioridad").value ="";
		document.getElementById("plazo").value="";	
	}
}
//14
function alone_marcacion(p){
	if(document.getElementById("cont_marcados").value!=""){
		if (document.getElementById("cont_marcados").value.indexOf(p)==-1){
			document.getElementById("cont_marcados").value = document.getElementById("cont_marcados").value+"-"+p;	
		} else {
			var sui = 0;
			var valor1 = document.getElementById("cont_marcados").value.substr(document.getElementById("cont_marcados").value.indexOf(p),4);
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

// 15
function dosearch(){
	var r = "modulos/contingencia/asig_accion/busq.php";
	displayMessage(r,700,450);

}

//16
function displayMessage(url,ancho,largo){
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(ancho,largo);
	messageObj.setShadowDivVisible(false);
	messageObj.display();
}
//17
function closeMessage(){
	messageObj.close();	
}
// 18
function aut(af){	r = "modulos/contingencia/consultar.php?m="+af; displayMessage(r,'800','500'); }
//19
function cargar_lista(rt){ 
	var My_path = rt;
	var spasc = mostrarContenido1;
	llamarlistado(My_path,spasc);
}
// 20
function mostrarContenido1(){
	document.getElementById("ajaxtd").innerHTML = ajax.response;	
}
//21
function llamarlistado(ruta,spasc){
	ajax = new sack();
	ajax.requestFile = ruta;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}
// 22
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
//23
function orto(x){
	x = x.replace(/ó/g,"\xF3");	x = x.replace(/&oacute;/g,"\xF3");
	x = x.replace(/á/g,"\xE1");	x = x.replace(/&aacute;/g,"\xE1");	
	return x;
}

//24
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
</script>