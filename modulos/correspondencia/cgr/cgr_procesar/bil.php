<script language="javascript" type="text/javascript">
messageObj = new DHTMLSuite.modalMessage();
messageObj.setWaitMessage('Cargando Pantalla..!');
messageObj.setShadowOffset(0);
DHTMLSuite.commonObj.setCssCacheStatus(false);
// 1
function llamarlistado(ruta,spasc){
	ajax = new sack();
	ajax.requestFile = ruta;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}
// 2
function mostrarContenido2(){
	document.getElementById("divresult").innerHTML = ajax1.response;	
}
// 3
function dosearch(){
var res = val_Asi();		
var r = "";
	if(res!=false){
		r = "modulos/correspondencia/cgr/cgr_procesar/bsq_correspondencia.php?pagina=1&condicion="+res;
		displayMessage(r,'700','450');
	}	
}
//4
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
//5
function val_Asi(){
	var evaluador = 0;
	var cadenas = ""
	
	if (document.getElementById("unidad").value == null || document.getElementById("unidad").value.length == 0 || /^\s+$/.test(document.getElementById("unidad").value)){
		evaluador = evaluador + 1;
	} else {
		// campo9 = unidad	
		cadenas = "campo1:"+document.getElementById("unidad").value;				
	}	
	
	if (document.getElementById("organismo").value == null || document.getElementById("organismo").value.length == 0 || /^\s+$/.test(document.getElementById("organismo").value)){
		evaluador = evaluador + 1;
	} 		

	if (document.getElementById("id_organismo").value == null || document.getElementById("id_organismo").value.length == 0 || /^\s+$/.test(document.getElementById("id_organismo").value)){
		evaluador = evaluador + 1;
	} else {
		// campo9 = unidad	
		if (cadenas==""){
			cadenas = "campo2:"+document.getElementById("id_organismo").value;				
		} else {
			cadenas = cadenas+"!campo2:"+document.getElementById("id_organismo").value;							
		}					
	}
	
	if(evaluador==3){
		alert(acentos("Ingrese al menos un criterio de b&uacute;squeda v&aacute;lido para realizar el filtrado!!"));
		return false;		
	} 	
		
	return cadenas;		
}

//6
function displayMessage(url,ancho,largo){
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(ancho,largo);
	messageObj.setShadowDivVisible(false);
	messageObj.display();
}
//7
function closeMessage(){
	messageObj.close();	
}
// 8
function cargar_lista(rt){ 
	var My_path = rt;
	var spasc = mostrarContenido1;
	llamarlistado(My_path,spasc);
}
//9
function la(q){
	window.frames.corres.location.href='modulos/correspondencia/cgr/cgr_procesar/procesar.php?id_recepcion='+q;
	closeMessage();	
}
// 10
function mostrarContenido1(){
	document.getElementById("ajaxtd").innerHTML = ajax.response;	
}
//11
function invo(h){
	if(h=="si"){document.getElementById("uno").style.display="";} else {document.getElementById("uno").style.display="none";}
}
//12
function age(y){
	if(document.getElementById("si").checked == true){	
		if(document.getElementById("id_organismo_reci").value == null || document.getElementById("id_organismo_reci").value.length == 0 || /^\s+$/.test(document.getElementById("id_organismo_reci").value)){
			alert(acentos("Debe Ingresar el nombre de un organismo!!"));
			document.getElementById("organismo_reci").select();	
			return false;
		} else {
			var My_path = "lis_organismos.php?acc=agregar&id_or="+y;
			var spasc = mostrarContenido3;
			llamarlistado(My_path,spasc);	
			document.getElementById("organismo_reci").value = "";
			document.getElementById("id_organismo_reci").value = "";		
		}
	}
}
// 13
function mostrarContenido3(){
	document.getElementById("llint").innerHTML = ajax.response;	
}
//14
function reg(){
var res = val_Reg();
var r = "";
	if(res!=false){
		document.getElementById("metodo").value="asignar";
		window.document.FormPro.submit();
		}
}
//15
function val_Reg(){
	
	if (document.getElementById("n_oficio_ext").value == null || document.getElementById("n_oficio_ext").value.length == 0 || /^\s+$/.test(document.getElementById("n_oficio_ext").value)){
			alert(acentos("El campo N&deg; Oficio est&aacute; vacio, por favor completelo"));
			document.getElementById("n_oficio_ext").focus();
			return false;
		}	

	if (document.getElementById("tipo_documento").value == null || document.getElementById("tipo_documento").value.length == 0 || /^\s+$/.test(document.getElementById("tipo_documento").value)){
			alert(acentos("El campo Tipo Documento est&aacute; vacio, por favor completelo"));
			document.getElementById("tipo_documento").focus();
			return false;
		}
		
	if (document.getElementById("tipo_documento").value ==1){		
		if (document.getElementById("tipo_informe").value == null || document.getElementById("tipo_informe").value.length == 0 || /^\s+$/.test(document.getElementById("tipo_informe").value)){
				alert(acentos("El campo Tipo Oficio est&aacute; vacio, por favor completelo"));
				document.getElementById("tipo_informe").focus();
				return false;
			}				
		}
			
/*	if (document.getElementById("plazo").value == null || document.getElementById("plazo").value.length == 0 || /^\s+$/.test(document.getElementById("plazo").value)){
			alert(acentos("El campo Plazo est&aacute; vacio, por favor completelo"));
			document.getElementById("plazo").focus();
			return false;
		}*/ 	
	
/*	if (document.getElementById("mensaje").value == null || document.getElementById("mensaje").value.length == 0 || /^\s+$/.test(document.getElementById("mensaje").value)){
			alert(acentos("El campo Mensajero est&aacute; vacio, por favor completelo"));
			document.getElementById("mensaje").focus();
			return false;
		} */	
	
/*	if(document.getElementById("org_cgr").checked == true)
	{	
		if(document.getElementById("no").checked == true)
			{*/	
				if (document.getElementById("organismo_reci").value == null || document.getElementById("organismo_reci").value.length == 0 || /^\s+$/.test(document.getElementById("organismo_reci").value)){
						alert(acentos("El campo Organismo est&aacute; vacio, por favor completelo"));
						document.getElementById("organismo_reci").focus();
						return false;
					} 	
			
				if (document.getElementById("id_organismo_reci").value == null || document.getElementById("id_organismo_reci").value.length == 0 || /^\s+$/.test(document.getElementById("id_organismo_reci").value)){
						alert(acentos("El campo Organismo est&aacute; vacio, por favor completelo"));
						document.getElementById("organismo_reci").focus();
						return false;
					}	
	
/*			}
		
		if(document.getElementById("si").checked == true)
			{	
				if (document.getElementById("can").value == null || document.getElementById("can").value.length == 0 || /^\s+$/.test(document.getElementById("can").value)){
						alert(acentos("Debe agregar al menos un organismo para efectuar el registro"));
						document.getElementById("organismo_reci").focus();
						return false;
					} 	
			}*/	
	//}
	
/*	if (document.getElementById("plazo").value.length != 0){	
		if (document.getElementById("plazo").value <= 1 || document.getElementById("plazo").value >= 50){
				alert(acentos("El valor del Plazo es muy corto o elevado, verifique!!"));
				document.getElementById("plazo").select();
				return false;
			}
	}*/	
	
	if (document.getElementById("SiAnex").checked == true)
	{	
		if (document.getElementById("listAnexo").value == null || document.getElementById("listAnexo").value.length == 0 || /^\s+$/.test(document.getElementById("listAnexo").value)){
			alert(acentos("El campo Anexo est&aacute; vacio, por favor completelo"));
			document.getElementById("listAnexo").focus();
			return false;
		}	
	}	
		
	if (document.getElementById("contenido").value == null || document.getElementById("contenido").value.length == 0 || /^\s+$/.test(document.getElementById("contenido").value)){
			alert(acentos("El campo Contenido est&aacute; vacio, por favor completelo"));
			document.getElementById("contenido").focus();
			return false;
		}	
	
	// validar oficio padre	
	var con = life(document.getElementById("n_oficio_ext").value,'accion');
	if(con==0){
		alert(acentos("El N&deg; Oficio ya ha sido utilizado!!, por favor use otro.")); 
		document.getElementById("n_oficio_ext").select(); 
		return false;
	} else if(con==1){
		document.getElementById("n_oficio_ext").select(); 
		return false;		
	}		
					
	return true;		
} 
//16
function devo(k){
	document.getElementById("can").value = k;
}
//17
function eli(v){
	var My_path = "lis_organismos.php?acc=eliminar&id_or="+v;
	var spasc = mostrarContenido3;
	llamarlistado(My_path,spasc);	
}
//18
function limp(){
	document.getElementById("n_oficio_ext").value = "";
	//document.getElementById("plazo").value = "";
	//document.getElementById("mensaje").value = "";
	document.getElementById("organismo_reci").value = "";
	document.getElementById("tipo_documento").value = "";	
	document.getElementById("tipo_informe").value = "";		
	document.getElementById("id_organismo_reci").value = "";
	document.getElementById("listAnexo").value = "";	
	
}

//19
function canc(){
	window.top.document.formB.submit();
}
//20
function life(zi,desvio){
var contenedor = "";
<? 
	$ma = new Recordset();
	$ma->sql = "SELECT crp_correspondencia_externa.n_oficio_externo FROM crp_correspondencia_externa WHERE DATE_FORMAT(crp_correspondencia_externa.fecha_registro,'%Y') = '".date('Y')."'";			
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
		$elultimo = $ma->fila["n_oficio_externo"];
		$transi=(int)$elultimo;
		$transi++;		
		$elnuevovalor = str_pad($transi, 5, "0", STR_PAD_LEFT);		
	}
	$ma->cerrar();
	unset($ma);
?>
var nuevo = "<? echo $elnuevovalor; ?>";
if(nuevo==""){ nuevo = "00001"; }
var i = ""; 
	for (i=0;i<contenedor.length;i++){
		if(zi==contenedor[i]){
			if(desvio =="accion"){
				return 0;
			} else if (desvio=="objeto") {
				alert(acentos("El n&deg; de oficio que introdujo ya ha sido utilizado, por favor verifique!!"));
				return;
			}
		}
	}  
	
	if(nuevo != zi){
		alert(acentos("El n&deg; de oficio que introdujo no sigue el correlativo establecido, por favor verifique!!"));				
		return 1;
	}	
}
// function 21
function cagr(bnb){
	if(bnb == 1){
		document.getElementById("infm").style.display="";		
	} else {
		document.getElementById("infm").style.display="none";
		document.getElementById("tipo_informe").value = "";
	}
}

// 22
function sali(q){
	if(q=="org_cgr"){
		document.getElementById("salida_1").style.display="";			
	} else if (q=="otro") {
		document.getElementById("salida_1").style.display="none";			
		var My_path = "lis_organismos.php?acc=cancelar";
		var spasc = mostrarContenido3;
		llamarlistado(My_path,spasc);	
		document.getElementById("organismo_reci").value = "";
		document.getElementById("id_organismo_reci").value = "";			
	}
}

// 23
function vee_anex(q){
	if (q=="SiAnex"){
		document.getElementById("danex2").style.display="";
		document.getElementById("SiAnex").value = "SiAnex";
		document.getElementById("NoAnex").value = "";		
	}
	if (q=="NoAnex"){
		document.getElementById("danex2").style.display="none";
		document.getElementById("SiAnex").value = "";
		document.getElementById("NoAnex").value = "NoAnex";	
		document.getElementById("listAnexo").value = "";		
	}
}
</script>