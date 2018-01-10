<script language="javascript" type="text/javascript">
messageObj = new DHTMLSuite.modalMessage();
messageObj.setWaitMessage('Cargando Pantalla..!');
messageObj.setShadowOffset(0);
DHTMLSuite.commonObj.setCssCacheStatus(false);
// 1
function hacer_llamados(rt){ 
	window.frames.iresult.location.href=rt;
}

// 2
function displayMessage(url,ancho,largo){
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(ancho,largo);
	messageObj.setShadowDivVisible(false);
	messageObj.display();
}
//3
function closeMessage(){
	messageObj.close();	
}

// 4
var p_telefonico = new Array(4,7)
var patron2 = new Array(1,3,3,3,3)
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

// 5
function validacion() {
	if (document.getElementById("cedula").value.trim().lenght==0){
		alert("El campo c&eacute;dula est&aacute; vacio, por favor completelo")
		document.getElementById("cedula").focus();
		return false;
	} 

	if (document.getElementById("nombre").value.trim().length==0){
		alert(acentos("El campo nombre y apellido est&aacute; vacio, por favor completelo"));
		document.getElementById("nombre").focus();
		return false;
	}

	if (document.getElementById("telef").value.trim().length==0){
		alert(acentos("El campo tel&eacute;fono contacto est&aacute; vacio, por favor completelo"));
		document.getElementById("telef").focus();
		return false;
	}
	
	var t = document.getElementById("telef").value;
	otra = t.split('-');
	
	if(otra[0].length !=4){
		alert(acentos("N&uacute;mero de Tel&eacute;fono no Valido"));
		document.getElementById("telef").select();
		return false;
	}
	
	if(otra[1].length !=7){
		alert(acentos("N&uacute;mero de Tel&eacute;fono no Valido"));
		document.getElementById("telef").select();		
		return false;
	}		
}

// 6
function mostrarContenido1(){
	document.getElementById("do_up").innerHTML = ajax.response;	
}

// 7
function llamarlistado(ruta,spasc,c){
	ajax = new sack();
	ajax.requestFile = ruta;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
	var w = "modulos/reg_visitas/visitas/busq.php?accion=buscar&ce="+c;
	alert(acentos("El visitante ha sido registrado correctamente!"));
	hacer_llamados(w);	
//	window.setTimeout("closeMessage();",1000);
	closeMessage();
}

// 8
function llamar(){ 
	if(validacion()==false){
			return;
	}	
	var d = document.getElementById("cedula").value;
	var param = "?cedula="+document.getElementById("cedula").value+"&nombre="+document.getElementById("nombre").value+"&telef="+document.getElementById("telef").value;
	var rt = "modulos/reg_visitas/visitas/regi.php"+param;
	var vh = mostrarContenido1;
	//alert(rt);
	llamarlistado(rt,vh,d);
}

// 9
function validar_organismo() {
	if (document.getElementById("organismo_txt").value.trim().lenght==0){
		alert(acentos("El campo organ&iacute;smo est&aacute; vacio, por favor completelo"));
		document.getElementById("organismo_txt").focus();
		return false;
	}
}

// 10
function creacion_orga(){ 
	if(validar_organismo()==false){
		return;
	}
	var d = "?organismo_tt="+document.getElementById("organismo_txt").value;	
	window.frames.ifrm_orga.location.href = "modulos/reg_visitas/visitas/regi_or.php"+d;
}

// 11
function registrarV(){
	window.frm_visita.submit();
}
</script>