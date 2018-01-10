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
function tipo_corres(ma){
	if (ma=="institucional"){
		document.getElementById("secc_institucional1").style.display="none";
		document.getElementById("secc_institucional2").style.display="none";
		document.getElementById("secc_institucional9").style.display="";		
		document.getElementById("secc_institucional3").style.display="";
		
		
		document.getElementById("secc_institucional7").style.display="none";
	
		document.getElementById("institucional").value = "0";
		document.getElementById("personal").value = "";		
		document.getElementById("tipo_documento").value="";		
		document.getElementById("tipo_documento").disabled=false;		
	}
	if (ma=="personal"){
		document.getElementById("secc_institucional1").style.display="none";
		document.getElementById("secc_institucional2").style.display="none";
		document.getElementById("secc_institucional3").style.display="none";
		

//		document.getElementById("tipo_documento").value="6";		
//		document.getElementById("tipo_documento").disabled=true;
		document.getElementById("dos").style.display="none";
			
		document.getElementById("cinco").style.display="none";			
		document.getElementById("tipo_documento").value="";	
		
		document.getElementById("secc_institucional7").style.display="";			
		document.getElementById("institucional").value = "";
		document.getElementById("personal").value = "1";
		
		document.getElementById("siete").style.display="none";			
		
		document.getElementById("nueve").style.display="none";	
					
		document.getElementById("once").style.display="none";					
		
		
	}
}
// 5
function doit(p){
	if(validacion()==false){
			return;
	}	
	document.getElementById("accion").value = p;
	document.getElementById("elegido").value = document.getElementById("elegido").value; 
	//alert(document.getElementById("observacion").value);
	document.recep.submit();

}
//6
function validacion() {
	if (document.getElementById("institucional").checked == true) /// institucional
	{
		if (document.getElementById("organismo").value == null || document.getElementById("organismo").value.length == 0 || /^\s+$/.test(document.getElementById("organismo").value)){
				alert(acentos("El campo Organ&iacute;smo est&aacute; vacio, por favor completelo"));
				document.getElementById("organismo").focus();
				return false;
			}	
			
		if (document.getElementById("id_organismo").value == null || document.getElementById("id_organismo").value.length == 0 || /^\s+$/.test(document.getElementById("id_organismo").value)){
				alert(acentos("El campo Organ&iacute;smo est&aacute; vacio, por favor completelo"));
				document.getElementById("organismo").focus();
				return false;
			}	
						
		if (document.getElementById("tipo_documento").value == "5") {

			if (document.getElementById("n_documento").value == null || document.getElementById("n_documento").value.length == 0 || /^\s+$/.test(document.getElementById("n_documento").value)){
					alert(acentos("El campo N&deg; Documento est&aacute; vacio, por favor completelo"));
					document.getElementById("n_documento").focus();
					return false;
				}			
			
			if (document.getElementById("positivo").checked==true)
			{
				if (document.getElementById("tipo_respuesta").value == ""){
						alert(acentos("El campo Tipo de respuesta est&aacute; vacio, por favor completelo"));
						document.getElementById("tipo_respuesta").focus();
						return false;
					}
			}
		}			

/*		if (document.getElementById("tipo_respuesta").value == "1" || document.getElementById("tipo_respuesta").value == "2"){
		   var cont = 0;
		   for (i=0;i<document.recep.elements.length;i++)
		   {
			  if(document.recep.elements[i].type == "checkbox")
			  {
				  if(document.recep.elements[i].checked)
					{
						cont = cont+1;
					}
			  }
			}	
			if (cont<1){
				alert(acentos("Debe seleccionar al menos un ejercicio fiscal"));
				return false;
			}
		}*/


		if (document.getElementById("tipo_documento").value == "11") {
			if (document.getElementById("n_gaceta").value == null || document.getElementById("n_gaceta").value.length == 0 || /^\s+$/.test(document.getElementById("n_gaceta").value)){
					alert(acentos("El campo N&deg; de gaceta est&aacute; vacio, por favor completelo"));
					document.getElementById("n_gaceta").focus();
					return false;
				}
				
			if (document.getElementById("f_gaceta").value == null || document.getElementById("f_gaceta").value.length == 0 || /^\s+$/.test(document.getElementById("f_gaceta").value)){
					alert(acentos("El campo fecha de la gaceta est&aacute; vacio, por favor completelo"));
					document.getElementById("f_gaceta").focus();
					return false;
				}						
			if(validarFecha(document.getElementById("f_gaceta").value) == false) {
				alert(acentos("Ingrese una Fecha de gaceta v&aacute;lida!!"));
				document.getElementById("f_gaceta").select();	
				return false;
			}
		}		
	}
	
	if (document.getElementById("personal").checked == true) //// personal
	{
		if (document.getElementById("remitente").value == null || document.getElementById("remitente").value.length == 0 || /^\s+$/.test(document.getElementById("remitente").value)){
			alert(acentos("El campo Remitente est&aacute; vacio, por favor completelo"));
			document.getElementById("remitente").focus();
			return false;
		}	
			
		if (document.getElementById("tipo_documento").value == "4" || document.getElementById("tipo_documento").value == "5" || document.getElementById("tipo_documento").value == "11") {
			alert(acentos("El campo Tipo de documento para correspondencia del tipo personal debe corresponder con una Donaci&oacute;n o Denuncia, por favor cambielo"));
			document.getElementById("tipo_documento").focus();
			return false;
		}
			
	} 
//__________________________________________________________	

	if (document.getElementById("tipo_documento").value == ""){
			alert(acentos("El campo Tipo de Documento est&aacute; vacio, por favor completelo"));
			document.getElementById("tipo_documento").focus();
			return false;
	} 
	
	if (document.getElementById("fe_documento").value == null || document.getElementById("fe_documento").value.length == 0 || /^\s+$/.test(document.getElementById("fe_documento").value)){
		alert(acentos("El campo Fecha Documento est&aacute; vacio, por favor completelo"));
		document.getElementById("fe_documento").focus();
		return false;
	} 
	
	if(validarFecha(document.getElementById("fe_documento").value) == false) {
		alert(acentos("Ingrese una Fecha de Documento v&aacute;lida!!"));
		document.getElementById("fe_documento").select();	
		return false;
	}
	
	if (document.getElementById("observacion").value == null || document.getElementById("observacion").value.length == 0 || /^\s+$/.test(document.getElementById("observacion").value)){
		alert(acentos("El campo Motivo est&aacute; vacio, por favor completelo"));
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
	
	var con = life(document.getElementById("correlativo_padre").value,'accion');
	if(con==false){
		alert(acentos("El N&deg; Oficio ya ha sido utilizado!!, por favor use otro.")); 
		document.getElementById("correlativo_padre").select(); 
		return false;
	}
	
	if (document.getElementById("observacion").value.length < 30 ){
		alert(acentos("El contenido del campo Motivo debe ser mayor a 30 caracteres"));
		document.getElementById("observacion").focus();
		return false;
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
		document.getElementById("danex2").style.display="";
		document.getElementById("SiAnex").value = "SiAnex";
		document.getElementById("NoAnex").value = "";		
	}
	if (q=="NoAnex"){
		document.getElementById("danex2").style.display="none";
		document.getElementById("SiAnex").value = "";
		document.getElementById("NoAnex").value = "NoAnex";	
	}
}
//10
function cancelarT(){
	document.getElementById("n_documento").value="";
	document.getElementById("organismo").value="";
	document.getElementById("id_organismo").value="";
	document.getElementById("correlativo_padre").value="";
	document.getElementById("tipo_respuesta").value="";
	document.getElementById("fe_documento").value="";
	document.getElementById("remitente").value="";
	document.getElementById("tipo_documento").value="";
	document.getElementById("listAnexo").value="";
	document.getElementById("observacion").value="";	
}
// 11
function mostrar_ofi(u){
	if(u==5){
		if (document.getElementById("personal").checked == true) //// personal
			{
				alert("Este tipo de documento no corresponden a la correspondencia seleccionada, Verifique!");
				document.getElementById("tipo_documento").value="";
			} else {		
				document.getElementById("negativo").checked=true
				rpts('negativo');
				document.getElementById("correlativo_padre").value="";
				document.getElementById("tipo_respuesta").value="";		
				document.getElementById("secc_institucional1").style.display="";		
				document.getElementById("secc_institucional2").style.display="";
				document.getElementById("secc_institucional9").style.display="";				
				document.getElementById("siete").style.display="none";			
				document.getElementById("nueve").style.display="none";	
				document.getElementById("once").style.display="none";
				document.getElementById("campo_obli").style.display="";						
			}
	} else if (u==4) {
		if (document.getElementById("personal").checked == true) //// personal
			{
				alert("Este tipo de documento no corresponden a la correspondencia seleccionada, Verifique!");
				document.getElementById("tipo_documento").value="";
			} else {
				document.getElementById("secc_institucional9").style.display="";
				document.getElementById("secc_institucional1").style.display="none";
				document.getElementById("secc_institucional2").style.display="none";					
				document.getElementById("cinco").style.display="none";		
				document.getElementById("siete").style.display="none";			
				document.getElementById("nueve").style.display="none";	
				document.getElementById("once").style.display="none";
				document.getElementById("campo_obli").style.display="none";							
			}
	} else if (u==11) {
		if (document.getElementById("personal").checked == true) //// personal
			{
				alert("Este tipo de documento no corresponden a la correspondencia seleccionada, Verifique!");
				document.getElementById("tipo_documento").value="";				
			} else {	
				document.getElementById("siete").style.display="";			
				document.getElementById("nueve").style.display="";	
				document.getElementById("once").style.display="";					
				document.getElementById("dos").style.display="none";
				document.getElementById("cinco").style.display="none";					
				document.getElementById("secc_institucional1").style.display="none";
				document.getElementById("secc_institucional2").style.display="none";			
				document.getElementById("n_gaceta").value="";								
				document.getElementById("f_gaceta").value="";	
				document.getElementById("campo_obli").style.display="none";		
			}
	} else if (u==12) {	
		if (document.getElementById("personal").checked == true) //// personal
			{	
				//document.getElementById("secc_institucional2").style.display="";
				document.getElementById("siete").style.display="none";			
				document.getElementById("nueve").style.display="none";	
				document.getElementById("once").style.display="none";					
				document.getElementById("cinco").style.display="none";
				document.getElementById("secc_institucional1").style.display="none";
				document.getElementById("dos").style.display="none";
				document.getElementById("secc_institucional9").style.display="";
				document.getElementById("negativo").checked=true
				rpts('negativo');
				document.getElementById("correlativo_padre").value="";
				document.getElementById("tipo_respuesta").value="";	
				document.getElementById("campo_obli").style.display="none";	
			} else {
				document.getElementById("secc_institucional2").style.display="";
				document.getElementById("siete").style.display="none";			
				document.getElementById("nueve").style.display="none";	
				document.getElementById("once").style.display="none";					
				document.getElementById("cinco").style.display="none";
				document.getElementById("secc_institucional1").style.display="none";
				document.getElementById("dos").style.display="none";
				document.getElementById("secc_institucional9").style.display="";
				document.getElementById("negativo").checked=true
				rpts('negativo');
				document.getElementById("correlativo_padre").value="";
				document.getElementById("tipo_respuesta").value="";	
				document.getElementById("campo_obli").style.display="none";				
			}		
	} else if (u==6) {	
		if (document.getElementById("personal").checked == true) //// personal
			{	
				document.getElementById("secc_institucional2").style.display="none";
				document.getElementById("siete").style.display="none";			
				document.getElementById("nueve").style.display="none";	
				document.getElementById("once").style.display="none";					
				document.getElementById("cinco").style.display="none";
				document.getElementById("secc_institucional1").style.display="none";
				document.getElementById("dos").style.display="none";
				document.getElementById("secc_institucional9").style.display="";
				document.getElementById("negativo").checked=true
				rpts('negativo');
				document.getElementById("correlativo_padre").value="";
				document.getElementById("tipo_respuesta").value="";	
				document.getElementById("campo_obli").style.display="none";																						
			} else {
				document.getElementById("secc_institucional2").style.display="";
				document.getElementById("siete").style.display="none";			
				document.getElementById("nueve").style.display="none";	
				document.getElementById("once").style.display="none";					
				document.getElementById("cinco").style.display="none";
				document.getElementById("secc_institucional1").style.display="none";
				document.getElementById("dos").style.display="none";
				document.getElementById("secc_institucional9").style.display="";
				document.getElementById("negativo").checked=true
				rpts('negativo');
				document.getElementById("correlativo_padre").value="";
				document.getElementById("tipo_respuesta").value="";	
				document.getElementById("campo_obli").style.display="none";																						
			}
	} else {
		document.getElementById("secc_institucional2").style.display="none";	
		document.getElementById("siete").style.display="none";			
		document.getElementById("nueve").style.display="none";	
		document.getElementById("once").style.display="none";					
		document.getElementById("cinco").style.display="none";
		document.getElementById("secc_institucional1").style.display="none";
		document.getElementById("dos").style.display="none";
		document.getElementById("secc_institucional9").style.display="";
		document.getElementById("negativo").checked=true
		rpts('negativo');
		document.getElementById("correlativo_padre").value="";
		document.getElementById("tipo_respuesta").value="";
		document.getElementById("campo_obli").style.display="none";								
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
function va(){
   var cont = 0;
   for (i=0;i<document.recep.elements.length;i++)
   {
	  if(document.recep.elements[i].type == "checkbox")
	  {
		  if(document.recep.elements[i].checked)
			{
				cont = cont+1;
			}
	  }
	}	
	if (cont>2){
		alert("Informacion: Tiene Chequeado mas de 2 ejercicios fiscales");
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
</script>