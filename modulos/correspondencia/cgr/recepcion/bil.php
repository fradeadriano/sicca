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
//4
function tipo_corres(ma){
	if (ma=="institucional"){
		ocultar_selec ("notiOrga");	
		document.getElementById("secc_institucional1").style.display="";
		document.getElementById("secc_institucional2").style.display="";
		document.getElementById("secc_institucional3").style.display="";
		document.getElementById("secc_institucional4").style.display="";
		document.getElementById("secc_institucional5").style.display="";
		document.getElementById("secc_institucional6").style.display="";
		document.getElementById("secc_institucional7").style.display="none";
		document.getElementById("secc_institucional8").style.display="none";		
		document.getElementById("institucional").value = "tip_inst";
		document.getElementById("personal").value = "";		
	}
	if (ma=="personal"){
		document.getElementById("secc_institucional1").style.display="none";
		document.getElementById("secc_institucional2").style.display="none";
		document.getElementById("secc_institucional3").style.display="none";
		document.getElementById("secc_institucional4").style.display="none";
		document.getElementById("secc_institucional5").style.display="none";
		document.getElementById("secc_institucional6").style.display="none";
		document.getElementById("secc_institucional7").style.display="";
		document.getElementById("secc_institucional8").style.display="";	
		document.getElementById("tipo_documento").value="6";		
		document.getElementById("tipo_documento").disabled = "true";	
		document.getElementById("institucional").value = "";
		document.getElementById("personal").value = "tip_per";
		
	}
}
// 5
function doit(p){
	if(validacion()==false){
			return;
	}	
	document.getElementById("accion").value = p;
	document.getElementById("elegido").value = document.getElementById("elegido").value; 
	document.recep.submit();

}
//6
function validacion() {

	if (document.getElementById("id_direcc_remitente").value == null || document.getElementById("id_direcc_remitente").value.length == 0 || /^\s+$/.test(document.getElementById("id_direcc_remitente").value)){
			alert(acentos("El campo Direcci&oacute;n Remitente est&aacute; vacio, por favor completelo"));
			document.getElementById("direcc_remitente").focus();
			return false;
		}
			
	if (document.getElementById("direcc_remitente").value == null || document.getElementById("direcc_remitente").value.length == 0 || /^\s+$/.test(document.getElementById("direcc_remitente").value)){
			alert(acentos("El campo Direcci&oacute;n Remitente est&aacute; vacio, por favor completelo"));
			document.getElementById("direcc_remitente").focus();
			return false;
		}

	if (document.getElementById("fe_documento").value == null || document.getElementById("fe_documento").value.length == 0 || /^\s+$/.test(document.getElementById("fe_documento").value)){
		alert(acentos("El campo Fecha est&aacute; vacio, por favor completelo"));
		document.getElementById("fe_documento").focus();
		return false;
		} 
	
	if(validarFecha(document.getElementById("fe_documento").value) == false) {
		alert(acentos("Ingrese una Fecha v&aacute;lida!!"));
		document.getElementById("fe_documento").select();	
		return false;
		}
	
/*	if (document.getElementById("fe_registro").value == null || document.getElementById("fe_registro").value.length == 0 || /^\s+$/.test(document.getElementById("fe_registro").value)){
		alert(acentos("El campo Fecha est&aacute; vacio, por favor completelo"));
		document.getElementById("fe_registro").focus();
		return false;
		} 
	
	if(validarFecha(document.getElementById("fe_registro").value) == false) {
		alert(acentos("Ingrese una Fecha v&aacute;lida!!"));
		document.getElementById("fe_registro").select();	
		return false;
		}	*/

	if (document.getElementById("observacion").value == null || document.getElementById("observacion").value.length == 0 || /^\s+$/.test(document.getElementById("observacion").value)){
		alert(acentos("El campo Observaci&oacute;n est&aacute; vacio, por favor completelo"));
		document.getElementById("observacion").focus();
		return false;
		} 

	if (document.getElementById("SiAnex").checked == true)
	{	
		if (document.getElementById("listAnexo").value == null || document.getElementById("listAnexo").value.length == 0 || /^\s+$/.test(document.getElementById("listAnexo").value)){
			alert(acentos("El campo Anexo est&aacute; vacio, por favor completelo"));
			document.getElementById("listAnexo").focus();
			return false;
		}	
	}

	if (document.getElementById("tcomunicacion").value == null || document.getElementById("tcomunicacion").value.length == 0 || /^\s+$/.test(document.getElementById("tcomunicacion").value)){
		alert(acentos("El campo Tipo comunicaci&oacute;n est&aacute; vacio, por favor completelo"));
		document.getElementById("tcomunicacion").focus();
		return false;
	}

	if (document.getElementById("tcomunicacion").value == "8") 
	{
			if (document.getElementById("n_documento").value == null || document.getElementById("n_documento").value.length == 0 || /^\s+$/.test(document.getElementById("n_documento").value)){
				alert(acentos("El campo N&deg; Oficio / Circular est&aacute; vacio, por favor completelo"));
				document.getElementById("n_documento").focus();
				return false;
			}			
			
/*			if (document.getElementById("n_notificacion").value == null || document.getElementById("n_notificacion").value.length == 0 || /^\s+$/.test(document.getElementById("n_notificacion").value)){
				alert(acentos("El campo N&deg; de notificaci&oacute;n est&aacute; vacio, por favor completelo"));
				document.getElementById("n_notificacion").focus();
				return false;
			}*/
			
			if (document.getElementById("notiOrga").checked == true) //// personal
				{			
/*					if (document.getElementById("organismo").value == null || document.getElementById("organismo").value.length == 0 || /^\s+$/.test(document.getElementById("organismo").value)){
							alert(acentos("El campo Organ&iacute;smo est&aacute; vacio, por favor completelo"));
							document.getElementById("organismo").focus();
							return false;
						}	
						
					if (document.getElementById("id_organismo").value == null || document.getElementById("id_organismo").value.length == 0 || /^\s+$/.test(document.getElementById("id_organismo").value)){
							alert(acentos("El campo Organ&iacute;smo est&aacute; vacio, por favor completelo"));
							document.getElementById("organismo").focus();
							return false;
						}*/	
					
					if (document.getElementById("cargar_orga").value == null || document.getElementById("cargar_orga").value.length == 0 || /^\s+$/.test(document.getElementById("cargar_orga").value))
					{
						alert(acentos("Falta agregar al menos un Organ&iacute;smo para la notificaci&oacute;n, por favor H&aacute;galo"));
						document.getElementById("n_notificacion_o").focus();
						return false;
					}														
				}

			if (document.getElementById("notiCiu").checked == true) //// personal
				{	
				
					if (document.getElementById("cargar_ciuda").value == null || document.getElementById("cargar_ciuda").value.length == 0 || /^\s+$/.test(document.getElementById("cargar_ciuda").value))
					{
						alert(acentos("Falta agregar al menos un Ciudadano para la notificaci&oacute;n, por favor H&aacute;galo"));
						document.getElementById("n_notificacion_c").focus();
						return false;
					}				
						
/*					if (document.getElementById("ciudadano").value == null || document.getElementById("ciudadano").value.length == 0 || /^\s+$/.test(document.getElementById("ciudadano").value)){
							alert(acentos("El campo Nombre est&aacute; vacio, por favor completelo"));
							document.getElementById("organismo").focus();
							return false;
						}	
						
					if (document.getElementById("direccion").value == null || document.getElementById("direccion").value.length == 0 || /^\s+$/.test(document.getElementById("direccion").value)){
							alert(acentos("El campo direcci&oacute;n est&aacute; vacio, por favor completelo"));
							document.getElementById("direccion").focus();
							return false;
						}			
		
					if (document.getElementById("telefono").value == null || document.getElementById("telefono").value.length == 0 || /^\s+$/.test(document.getElementById("telefono").value)){
							alert(acentos("El campo tel&eacute;fono est&aacute; vacio, por favor completelo"));
							document.getElementById("telefono").focus();
							return false;
						}*/				
				}

/*			if (document.getElementById("plazo").value == null || document.getElementById("plazo").value.length == 0 || /^\s+$/.test(document.getElementById("plazo").value)){
					alert(acentos("El campo Plazo est&aacute; vacio, por favor completelo"));
					document.getElementById("plazo").focus();
					return false;
				}*/
	}
	
	if (document.getElementById("tcomunicacion").value == "10") 
	{
		
		if (document.getElementById("n_documento").value == null || document.getElementById("n_documento").value.length == 0 || /^\s+$/.test(document.getElementById("n_documento").value)){
			alert(acentos("El campo N&deg; Oficio / Circular est&aacute; vacio, por favor completelo"));
			document.getElementById("n_documento").focus();
			return false;
		}
				
		if (document.getElementById("n_respuesta").value == null || document.getElementById("n_respuesta").value.length == 0 || /^\s+$/.test(document.getElementById("n_respuesta").value)){
				alert(acentos("El campo respuesta oficio n&deg; est&aacute; vacio, por favor completelo"));
				document.getElementById("n_respuesta").focus();
				return false;
			}			
		
/*		if (document.getElementById("unidad").value == null || document.getElementById("unidad").value.length == 0 || /^\s+$/.test(document.getElementById("unidad").value)){
				alert(acentos("El campo unidad administrativa est&aacute; vacio, por favor completelo"));
				document.getElementById("unidad").focus();
				return false;
			}*/		
	
	}
	
	if (document.getElementById("tcomunicacion").value == "9") 
	{
		if (document.getElementById("n_documento").value == null || document.getElementById("n_documento").value.length == 0 || /^\s+$/.test(document.getElementById("n_documento").value)){
			alert(acentos("El campo N&deg; Oficio / Circular est&aacute; vacio, por favor completelo"));
			document.getElementById("n_documento").focus();
			return false;
		}		
	
		if (document.getElementById("unidad").value == null || document.getElementById("unidad").value.length == 0 || /^\s+$/.test(document.getElementById("unidad").value)){
				alert(acentos("El campo unidad administrativa est&aacute; vacio, por favor completelo"));
				document.getElementById("unidad").focus();
				return false;
			}
			
/*		if (document.getElementById("plazo").value == null || document.getElementById("plazo").value.length == 0 || /^\s+$/.test(document.getElementById("plazo").value)){
				alert(acentos("El campo Plazo est&aacute; vacio, por favor completelo"));
				document.getElementById("plazo").focus();
				return false;
			}*/			
	}		

	if (document.getElementById("tcomunicacion").value == "13") 
	{

		if (document.getElementById("con_ofi").checked == true) //// personal
			{			
			if (document.getElementById("n_documento").value == null || document.getElementById("n_documento").value.length == 0 || /^\s+$/.test(document.getElementById("n_documento").value)){
				alert(acentos("El campo N&deg; Oficio / Circular est&aacute; vacio, por favor completelo"));
				document.getElementById("n_documento").focus();
				return false;
				}				
			} 
		if (document.getElementById("unidad").value == null || document.getElementById("unidad").value.length == 0 || /^\s+$/.test(document.getElementById("unidad").value)){
				alert(acentos("El campo unidad administrativa est&aacute; vacio, por favor completelo"));
				document.getElementById("unidad").focus();
				return false;
			}
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
var p_telefonico = new Array(4,7)
var p_cgr = new Array(2,2,6)
var p_hora = new Array(2,2)
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

// 9 

function vee_anex(q){
	if (q=="SiAnex"){
//		document.getElementById("danex1").style.display="";
		document.getElementById("danex2").style.display="";
		document.getElementById("SiAnex").value = "SiAnex";
		document.getElementById("NoAnex").value = "";		
	}
	if (q=="NoAnex"){
//		document.getElementById("danex1").style.display="none";
		document.getElementById("danex2").style.display="none";
		document.getElementById("SiAnex").value = "";
		document.getElementById("NoAnex").value = "NoAnex";	
	}
}

// 10

function campos(l){
	switch(l)
	{
		case "7": // Invitacion		
			document.getElementById("di_correo").style.display="none";	
			document.getElementById("di_correo_edf").style.display="none";					
			document.getElementById("di_notificacion").style.display="none";
			document.getElementById("di_solicitud").style.display="none";	
			document.getElementById("di_plazo").style.display="none";	
			document.getElementById("di_respuesta").style.display="none";			
			//document.getElementById("espacio").style.display="none";
			document.getElementById("div_ciudadano").style.display="none";
			document.getElementById("list_ciudadano").style.display="none";
			
			document.getElementById("div_organismo").style.display="none";
			document.getElementById("list_organismo").style.display="none";
			
			document.getElementById("camp_oblo_ofi").style.display="none";			
			
			//document.getElementById("div_accion").style.display="";			
			//document.getElementById("archivar").checked = true;
			//document.getElementById("procesar").disabled=true;
			//document.getElementById("archivar").disabled=false;			
			document.getElementById("plazo").value="";		
			document.getElementById("n_notificacion_o").value="";
			document.getElementById("n_notificacion_c").value="";			
			document.getElementById("ciudadano").value="";
			document.getElementById("direccion").value="";
			document.getElementById("telefono").value="";
			document.getElementById("n_respuesta").value="";									
			document.getElementById("organismo").value="";
			document.getElementById("id_organismo").value="";
			document.getElementById("unidad").value="";
			document.getElementById("plazo").value="";													
		break;
		case "8": // notificacion a	
			document.getElementById("di_correo").style.display="none";	
			document.getElementById("di_correo_edf").style.display="none";					
			document.getElementById("camp_oblo_ofi").style.display="";			
			//document.getElementById("espacio").style.display="";					
			document.getElementById("div_organismo").style.display="";
			document.getElementById("list_organismo").style.display="";				
			document.getElementById("di_notificacion").style.display="";	
			document.getElementById("di_solicitud").style.display="none";	
			document.getElementById("di_respuesta").style.display="none";
			document.getElementById("di_plazo").style.display="";	
			document.getElementById("unidad").value="";
			document.getElementById("n_respuesta").value="";			
			document.getElementById("plazo").value="";
/*			document.getElementById("div_accion").style.display="";			
			document.getElementById("procesar").checked = true;
			document.getElementById("procesar").disabled=false;
			document.getElementById("archivar").disabled=true;*/
			
			document.getElementById("n_notificacion_o").value="";
			document.getElementById("n_notificacion_c").value="";			
			document.getElementById("ciudadano").value="";
			document.getElementById("direccion").value="";
			document.getElementById("telefono").value="";
			document.getElementById("n_respuesta").value="";									
			document.getElementById("organismo").value="";
			document.getElementById("id_organismo").value="";
			document.getElementById("unidad").value="";
			document.getElementById("plazo").value="";	
		break;	
		case "9": // Solicitud	
			document.getElementById("di_correo").style.display="none";
			document.getElementById("di_correo_edf").style.display="none";				
			document.getElementById("camp_oblo_ofi").style.display="";					
			document.getElementById("unidad").value="";
			document.getElementById("plazo").value="";		
			document.getElementById("organismo").value="";
			document.getElementById("id_organismo").value="";				
			document.getElementById("n_respuesta").value="";			
			//document.getElementById("espacio").style.display="none";		
			document.getElementById("di_notificacion").style.display="none";
			document.getElementById("di_respuesta").style.display="none";
			document.getElementById("div_organismo").style.display="none";			
			document.getElementById("di_solicitud").style.display="";								
			document.getElementById("di_plazo").style.display="";
//			document.getElementById("div_accion").style.display="";			
			document.getElementById("div_ciudadano").style.display="none";	
			
			document.getElementById("list_ciudadano").style.display="none";		
			document.getElementById("list_organismo").style.display="none";
			
		
/*			document.getElementById("procesar").checked = true;
			document.getElementById("procesar").disabled=false;
			document.getElementById("archivar").disabled=false;	*/										
		break;
		case "10": // respuestas	
			document.getElementById("di_correo").style.display="none";
			document.getElementById("di_correo_edf").style.display="none";	
			document.getElementById("camp_oblo_ofi").style.display="";					
			//document.getElementById("espacio").style.display="none";	
			document.getElementById("div_organismo").style.display="none";
			document.getElementById("di_notificacion").style.display="none";
			//document.getElementById("di_solicitud").style.display="";		
			document.getElementById("div_ciudadano").style.display="none";	
			document.getElementById("di_respuesta").style.display="";
			document.getElementById("di_plazo").style.display="none";	
			document.getElementById("organismo").value="";
			document.getElementById("id_organismo").value="";			
			document.getElementById("unidad").value="";
			document.getElementById("n_respuesta").value="";			
			document.getElementById("plazo").value="";

			document.getElementById("list_ciudadano").style.display="none";
			

			document.getElementById("list_organismo").style.display="none";
			
/*			document.getElementById("div_accion").style.display="";			
			document.getElementById("procesar").checked = true;
			document.getElementById("procesar").disabled=false;
			document.getElementById("archivar").disabled=false;	*/								
		break;
		case "13": // Solicitud	
			document.getElementById("camp_oblo_ofi").style.display="";	
			document.getElementById("di_correo").style.display="";				
			document.getElementById("di_correo_edf").style.display="";							
							
			document.getElementById("unidad").value="";
			document.getElementById("plazo").value="";		
			document.getElementById("organismo").value="";
			document.getElementById("id_organismo").value="";				
			document.getElementById("n_respuesta").value="";			
			//document.getElementById("espacio").style.display="none";		
			document.getElementById("di_notificacion").style.display="none";
			document.getElementById("di_respuesta").style.display="none";

			document.getElementById("di_solicitud").style.display="";								
			document.getElementById("di_plazo").style.display="";
//			document.getElementById("div_accion").style.display="";			

			document.getElementById("div_organismo").style.display="none";			
			document.getElementById("list_organismo").style.display="none";						
			
			document.getElementById("div_ciudadano").style.display="none";	
			document.getElementById("list_ciudadano").style.display="none";
			
		
/*			document.getElementById("procesar").checked = true;
			document.getElementById("procesar").disabled=false;
			document.getElementById("archivar").disabled=false;	*/										
		break;
		case "14": // comunicado		
			document.getElementById("di_correo").style.display="none";	
			document.getElementById("di_correo_edf").style.display="none";					
			document.getElementById("di_notificacion").style.display="none";
			document.getElementById("di_solicitud").style.display="none";	
			document.getElementById("di_plazo").style.display="none";	
			document.getElementById("di_respuesta").style.display="none";			
			//document.getElementById("espacio").style.display="none";
			document.getElementById("div_ciudadano").style.display="none";
			document.getElementById("list_ciudadano").style.display="none";
			
			document.getElementById("div_organismo").style.display="none";
			document.getElementById("list_organismo").style.display="none";
			
			document.getElementById("camp_oblo_ofi").style.display="none";			
			
			//document.getElementById("div_accion").style.display="";			
			//document.getElementById("archivar").checked = true;
			//document.getElementById("procesar").disabled=true;
			//document.getElementById("archivar").disabled=false;			
			document.getElementById("plazo").value="";		
			document.getElementById("n_notificacion_o").value="";
			document.getElementById("n_notificacion_c").value="";			
			document.getElementById("ciudadano").value="";
			document.getElementById("direccion").value="";
			document.getElementById("telefono").value="";
			document.getElementById("n_respuesta").value="";									
			document.getElementById("organismo").value="";
			document.getElementById("id_organismo").value="";
			document.getElementById("unidad").value="";
			document.getElementById("plazo").value="";													
		break;				
		default:
			document.getElementById("camp_oblo_ofi").style.display="";					
			document.getElementById("unidad").value="";
			document.getElementById("n_respuesta").value="";					
			document.getElementById("di_notificacion").style.display="none";
			document.getElementById("di_solicitud").style.display="none";	
			document.getElementById("di_plazo").style.display="none";	
			document.getElementById("di_respuesta").style.display="none";
			document.getElementById("div_organismo").style.display="none";			
			//document.getElementById("espacio").style.display="none";										
					
			document.getElementById("div_ciudadano").style.display="none";	
/*			document.getElementById("div_accion").style.display="none";			
			document.getElementById("archivar").checked = true;
			document.getElementById("procesar").disabled=false;	*/	
			document.getElementById("n_notificacion").value="";
			document.getElementById("ciudadano").value="";
			document.getElementById("direccion").value="";
			document.getElementById("telefono").value="";
			document.getElementById("n_respuesta").value="";									
			document.getElementById("organismo").value="";
			document.getElementById("id_organismo").value="";
			document.getElementById("unidad").value="";
			document.getElementById("plazo").value="";	

			document.getElementById("list_ciudadano").style.display="none";
			
			document.getElementById("list_organismo").style.display="none";			
	}	
}

// 11
function ocultar_selec (k){ 
	if (k=="notiOrga"){
		//document.getElementById("espacio").style.display="";	
		document.getElementById("div_organismo").style.display="";			
		document.getElementById("div_ciudadano").style.display="none";		
		document.getElementById("di_plazo").style.display="";				
		document.getElementById("list_organismo").style.display="";		
		document.getElementById("list_ciudadano").style.display="none";		
		document.getElementById("organismo").value="";
		document.getElementById("id_organismo").value="";
		document.getElementById("n_notificacion_o").value="";
		document.getElementById("plazo").value="";	
		document.getElementById("cargar_orga").value="";
		document.getElementById("cargar_ciuda").value="";	
	
		var My_path = "modulos/correspondencia/cgr/recepcion/lis_organismos.php?acc=cancelar";	
		var spasc = mostrarContenido3;
		llamarlistado(My_path,spasc);		
	} else if (k=="notiCiu") {		
		//document.getElementById("espacio").style.display="";	
		document.getElementById("div_organismo").style.display="none";			
		document.getElementById("div_ciudadano").style.display="";	
		document.getElementById("di_plazo").style.display="";				
		document.getElementById("n_notificacion_c").value="";
		document.getElementById("ciudadano").value="";
		document.getElementById("direccion").value="";
		document.getElementById("telefono").value="";
		document.getElementById("plazo").value="";				
		document.getElementById("list_organismo").style.display="none";		
		document.getElementById("list_ciudadano").style.display="";		
		document.getElementById("cargar_orga").value="";
		document.getElementById("cargar_ciuda").value="";	

		var My_path = "modulos/correspondencia/cgr/recepcion/lis_ciudadano.php?acc=cancelar";	
		var spasc = mostrarContenido4;
		llamarlistado(My_path,spasc);		
			
	}
}

//12
function cancelarT(){
	document.getElementById("n_documento").value="";
	document.getElementById("id_direcc_remitente").value="";
	document.getElementById("direcc_remitente").value="";
	document.getElementById("organismo").value="";
	document.getElementById("id_organismo").value="";
	document.getElementById("fe_documento").value="";
	document.getElementById("tcomunicacion").value="";
	document.getElementById("fecha_resp").value="";
	document.getElementById("unidad").value="";
	document.getElementById("plazo").value="";
	document.getElementById("NoAnex").checked=true;
	document.getElementById("tcomunicacion").value="";
	campos('');
	document.getElementById("observacion").value="";
	document.getElementById("listAnexo").value="";	
}

//13
function ocultar_selec_email (k){ 
	if (k=="con_ofi"){
		document.getElementById("n_documento").disabled=false;											
	} else if (k=="sin_ofi") {		
		document.getElementById("n_documento").disabled=true;											
	}
}

//14
function age(y){
	if(y=="organismo"){
		if(document.getElementById("id_organismo").value == null || document.getElementById("id_organismo").value.length == 0 || /^\s+$/.test(document.getElementById("id_organismo").value)){
			alert(acentos("Debe Ingresar el nombre de un organismo!!"));
			document.getElementById("id_organismo").select();	
			return;	
			}			
		if(document.getElementById("n_notificacion_o").value == null || document.getElementById("n_notificacion_o").value.length == 0 || /^\s+$/.test(document.getElementById("n_notificacion_o").value)){
			alert(acentos("Debe Ingresar el n&deg; de Notificaci&oacute;n!!"));
			document.getElementById("n_notificacion_o").select();	
			return;			
			}	
			
			var cad = document.getElementById("n_notificacion_o").value.split("-");
			if (cad.length==3)
			{
			
				if(cad[0] !="" && cad[0].length !=2){
					alert(acentos("Ingrese el n&deg; de notificaci&oacute;n con toda la cantidad de caracteres!!"));
					document.getElementById("n_notificacion_o").select();	
					return;		
				}
		
				if(cad[1] !="" && cad[1].length != 2){
					alert(acentos("Ingrese el n&deg; de notificaci&oacute;n con toda la cantidad de caracteres!!"));
					document.getElementById("n_notificacion_o").select();
					return;		
				}
					
				if(cad[2] !="" && cad[2].length < 1){
					alert(acentos("Ingrese el n&deg; de notificaci&oacute;n con toda la cantidad de caracteres!!"));
					document.getElementById("n_notificacion_o").select();
					return;		
				}
				
			} else {
				alert(acentos("Ingrese un n&deg; notificaci&oacute;n v&aacute;lido!!"));
				document.getElementById("n_notificacion_o").select();
				return;				
			} 	
					
		var My_path = "modulos/correspondencia/cgr/recepcion/lis_organismos.php?acc=agregar&id_or="+document.getElementById("id_organismo").value+"&nono="+document.getElementById("n_notificacion_o").value;	
		var spasc = mostrarContenido3;
		
	} else if (y=="ciudadano"){
		if(document.getElementById("n_notificacion_c").value == null || document.getElementById("n_notificacion_c").value.length == 0 || /^\s+$/.test(document.getElementById("n_notificacion_c").value)){
			alert(acentos("Debe Ingresar el n&deg; de Notificaci&oacute;n!!"));
			document.getElementById("n_notificacion_c").select();	
			return;				
			}
		
		var cad = document.getElementById("n_notificacion_c").value.split("-");
		if (cad.length==3)
		{
		
			if(cad[0] !="" && cad[0].length !=2){
				alert(acentos("Ingrese el n&deg; de notificaci&oacute;n con toda la cantidad de caracteres!!"));
				document.getElementById("n_notificacion_c").select();	
				return;		
			}
	
			if(cad[1] !="" && cad[1].length != 2){
				alert(acentos("Ingrese el n&deg; de notificaci&oacute;n con toda la cantidad de caracteres!!"));
				document.getElementById("n_notificacion_c").select();
				return;		
			}
				
			if(cad[2] !="" && cad[2].length < 1){
				alert(acentos("Ingrese el n&deg; de notificaci&oacute;n con toda la cantidad de caracteres!!"));
				document.getElementById("n_notificacion_c").select();
				return;		
			}
			
		} else {
			alert(acentos("Ingrese un n&deg; notificaci&oacute;n v&aacute;lido!!"));
			document.getElementById("n_notificacion_c").select();
			return;				
		} 	
		
		if (document.getElementById("ciudadano").value == null || document.getElementById("ciudadano").value.length == 0 || /^\s+$/.test(document.getElementById("ciudadano").value)){
				alert(acentos("El campo Nombre est&aacute; vacio, por favor completelo"));
				document.getElementById("organismo").focus();
				return;
			}	
			
		if (document.getElementById("direccion").value == null || document.getElementById("direccion").value.length == 0 || /^\s+$/.test(document.getElementById("direccion").value)){
				alert(acentos("El campo direcci&oacute;n est&aacute; vacio, por favor completelo"));
				document.getElementById("direccion").focus();
				return;
			}			

/*		if (document.getElementById("telefono").value == null || document.getElementById("telefono").value.length == 0 || /^\s+$/.test(document.getElementById("telefono").value)){
				alert(acentos("El campo tel&eacute;fono est&aacute; vacio, por favor completelo"));
				document.getElementById("telefono").focus();
				return;
			}*/	
			
		if (document.getElementById("telefono").value.length != 0)
		{		
			var cad = document.getElementById("telefono").value.split("-");
			if (cad.length==2)
			{
				if(cad[0] !="" && cad[0].length !=4){
					alert(acentos("Ingrese un  n&deg; de tel&eacute;fono v&aacute;lido!!"));
					document.getElementById("telefono").select();	
					return;		
				}
	
				if( cad[0] !="0412" && cad[0] !="0414" && cad[0] !="0416" && cad[0] !="0424" && cad[0] !="0426" ) {
					alert(acentos("Ingrese un  n&deg; de tel&eacute;fono v&aacute;lido!!"));
					document.getElementById("telefono").select();	
					return;		
				}
		
				if(cad[1] !="" && cad[1].length != 7){
					alert(acentos("Ingrese el n&deg; de notificaci&oacute;n con toda la cantidad de caracteres!!"));
					document.getElementById("telefono").select();
					return;		
				}		
			} else {
				alert(acentos("Ingrese un n&deg; telef&oacute;nico v&aacute;lido!!"));
				document.getElementById("telefono").select();
				return;				
			}			
		}
			
		var My_path = "modulos/correspondencia/cgr/recepcion/lis_ciudadano.php?acc=agregar&nonc="+document.getElementById("n_notificacion_c").value+"&ciu="+document.getElementById("ciudadano").value+"&dir="+document.getElementById("direccion").value+"&tel="+document.getElementById("telefono").value;	
		var spasc = mostrarContenido4;
	}

	llamarlistado(My_path,spasc);	
	document.getElementById("n_notificacion_o").value = "";
	document.getElementById("id_organismo").value = "";	
	document.getElementById("organismo").value = "";		
	document.getElementById("n_notificacion_c").value = "";
	document.getElementById("ciudadano").value = "";
	document.getElementById("direccion").value = "";
	document.getElementById("telefono").value = "";		
}

// 15
function mostrarContenido3(){
	document.getElementById("list_organismo").innerHTML = ajax.response;	
}

// 16
function mostrarContenido4(){
	document.getElementById("list_ciudadano").innerHTML = ajax.response;	
}

//17
function llamarlistado(ruta,spasc){
	ajax = new sack();
	ajax.requestFile = ruta;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}

//18
function eli(v){
	var My_path = "modulos/correspondencia/cgr/recepcion/lis_organismos.php?acc=eliminar&id_or="+v;
	var spasc = mostrarContenido3;
	llamarlistado(My_path,spasc);	
}

//19
function eliciu(v){
	var My_path = "modulos/correspondencia/cgr/recepcion/lis_ciudadano.php?acc=eliminar&id_te="+v;
	var spasc = mostrarContenido4;
	llamarlistado(My_path,spasc);	
}
</script>