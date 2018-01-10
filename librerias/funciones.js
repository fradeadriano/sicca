var letras=' ABCÇDEFGHIJKLMNÑOPQRSTUVWXYZabcçdefghijklmnñopqrstuvwxyzàáÀÁéèÈÉíìÍÌïÏóòÓÒúùÚÙüÜ' 
var numeros='1234567890' 
var ac='´'; 
var signos=',.:;@-_' 
var signosmatematicos='+-=()*/' 
var personal='<>#$%&?¿{}!¡';
var especiales = '\'\"';
var sololetras = numeros+signos+signosmatematicos+personal+especiales;
var sololetrasnum = signos+signosmatematicos+personal+especiales;
var re = '1234567890-';

function validar(evnt,tipo) { 
	var temporal; 
	temporal = document.all?parseInt(evnt.keyCode): parseInt(evnt.which);
	if (temporal == 13 || temporal == 8 || temporal == 0 || temporal == 9) return true;
	return (tipo.indexOf(String.fromCharCode(temporal)) != -1);
}

function acentos(x) {
	// version 040623
	// Spanish - Español
	// Portuguese - Portugués - Português
	// Italian - Italiano
	// French - Francés - Français
	// Also accepts and converts single and double quotation marks, square and angle brackets
	// and miscelaneous symbols.
	// Also accepts and converts html entities for all the above.
//	if (navigator.appVersion.toLowerCase().indexOf("windows") != -1) {return x}
	x = x.replace(/¡/g,"\xA1");	x = x.replace(/&iexcl;/g,"\xA1")
	x = x.replace(/¿/g,"\xBF");	x = x.replace(/&iquest;/g,"\xBF")
	x = x.replace(/À/g,"\xC0");	x = x.replace(/&Agrave;/g,"\xC0")
	x = x.replace(/à/g,"\xE0");	x = x.replace(/&agrave;/g,"\xE0")
	x = x.replace(/Á/g,"\xC1");	x = x.replace(/&Aacute;/g,"\xC1")
	x = x.replace(/á/g,"\xE1");	x = x.replace(/&aacute;/g,"\xE1")
	x = x.replace(/Â/g,"\xC2");	x = x.replace(/&Acirc;/g,"\xC2")
	x = x.replace(/â/g,"\xE2");	x = x.replace(/&acirc;/g,"\xE2")
	x = x.replace(/Ã/g,"\xC3");	x = x.replace(/&Atilde;/g,"\xC3")
	x = x.replace(/ã/g,"\xE3");	x = x.replace(/&atilde;/g,"\xE3")
	x = x.replace(/Ä/g,"\xC4");	x = x.replace(/&Auml;/g,"\xC4")
	x = x.replace(/ä/g,"\xE4");	x = x.replace(/&auml;/g,"\xE4")
	x = x.replace(/Å/g,"\xC5");	x = x.replace(/&Aring;/g,"\xC5")
	x = x.replace(/å/g,"\xE5");	x = x.replace(/&aring;/g,"\xE5")
	x = x.replace(/Æ/g,"\xC6");	x = x.replace(/&AElig;/g,"\xC6")
	x = x.replace(/æ/g,"\xE6");	x = x.replace(/&aelig;/g,"\xE6")
	x = x.replace(/Ç/g,"\xC7");	x = x.replace(/&Ccedil;/g,"\xC7")
	x = x.replace(/ç/g,"\xE7");	x = x.replace(/&ccedil;/g,"\xE7")
	x = x.replace(/È/g,"\xC8");	x = x.replace(/&Egrave;/g,"\xC8")
	x = x.replace(/è/g,"\xE8");	x = x.replace(/&egrave;/g,"\xE8")
	x = x.replace(/É/g,"\xC9");	x = x.replace(/&Eacute;/g,"\xC9")
	x = x.replace(/é/g,"\xE9");	x = x.replace(/&eacute;/g,"\xE9")
	x = x.replace(/Ê/g,"\xCA");	x = x.replace(/&Ecirc;/g,"\xCA")
	x = x.replace(/ê/g,"\xEA");	x = x.replace(/&ecirc;/g,"\xEA")
	x = x.replace(/Ë/g,"\xCB");	x = x.replace(/&Euml;/g,"\xCB")
	x = x.replace(/ë/g,"\xEB");	x = x.replace(/&euml;/g,"\xEB")
	x = x.replace(/Ì/g,"\xCC");	x = x.replace(/&Igrave;/g,"\xCC")
	x = x.replace(/ì/g,"\xEC");	x = x.replace(/&igrave;/g,"\xEC")
	x = x.replace(/Í/g,"\xCD");	x = x.replace(/&Iacute;/g,"\xCD")
	x = x.replace(/í/g,"\xED");	x = x.replace(/&iacute;/g,"\xED")
	x = x.replace(/Î/g,"\xCE");	x = x.replace(/&Icirc;/g,"\xCE")
	x = x.replace(/î/g,"\xEE");	x = x.replace(/&icirc;/g,"\xEE")
	x = x.replace(/Ï/g,"\xCF");	x = x.replace(/&Iuml;/g,"\xCF")
	x = x.replace(/ï/g,"\xEF");	x = x.replace(/&iuml;/g,"\xEF")
	x = x.replace(/Ñ/g,"\xD1");	x = x.replace(/&Ntilde;/g,"\xD1")
	x = x.replace(/ñ/g,"\xF1");	x = x.replace(/&ntilde;/g,"\xF1")
	x = x.replace(/Ò/g,"\xD2");	x = x.replace(/&Ograve;/g,"\xD2")
	x = x.replace(/ò/g,"\xF2");	x = x.replace(/&ograve;/g,"\xF2")
	x = x.replace(/Ó/g,"\xD3");	x = x.replace(/&Oacute;/g,"\xD3")
	x = x.replace(/ó/g,"\xF3");	x = x.replace(/&oacute;/g,"\xF3")
	x = x.replace(/Ô/g,"\xD4");	x = x.replace(/&Ocirc;/g,"\xD4")
	x = x.replace(/ô/g,"\xF4");	x = x.replace(/&ocirc;/g,"\xF4")
	x = x.replace(/Õ/g,"\xD5");	x = x.replace(/&Otilde;/g,"\xD5")
	x = x.replace(/õ/g,"\xF5");	x = x.replace(/&otilde;/g,"\xF5")
	x = x.replace(/Ö/g,"\xD6");	x = x.replace(/&Ouml;/g,"\xD6")
	x = x.replace(/ö/g,"\xF6");	x = x.replace(/&ouml;/g,"\xF6")
	x = x.replace(/Ø/g,"\xD8");	x = x.replace(/&Oslash;/g,"\xD8")
	x = x.replace(/ø/g,"\xF8");	x = x.replace(/&oslash;/g,"\xF8")
	x = x.replace(/Ù/g,"\xD9");	x = x.replace(/&Ugrave;/g,"\xD9")
	x = x.replace(/ù/g,"\xF9");	x = x.replace(/&ugrave;/g,"\xF9")
	x = x.replace(/Ú/g,"\xDA");	x = x.replace(/&Uacute;/g,"\xDA")
	x = x.replace(/ú/g,"\xFA");	x = x.replace(/&uacute;/g,"\xFA")
	x = x.replace(/Û/g,"\xDB");	x = x.replace(/&Ucirc;/g,"\xDB")
	x = x.replace(/û/g,"\xFB");	x = x.replace(/&ucirc;/g,"\xFB")
	x = x.replace(/Ü/g,"\xDC");	x = x.replace(/&Uuml;/g,"\xDC")
	x = x.replace(/ü/g,"\xFC");	x = x.replace(/&uuml;/g,"\xFC")
	
	x = x.replace(/\"/g,"\x22")
	x = x.replace(/\'/g,"\x27")
	x = x.replace(/\</g,"\x3C")
	x = x.replace(/\>/g,"\x3E")
	x = x.replace(/\[/g,"\x5B")
	x = x.replace(/\]/g,"\x5D")

	x = x.replace(/¢/g,"\xA2");	x = x.replace(/&cent;/g,"\xA2") 
	x = x.replace(/£/g,"\xA3");	x = x.replace(/&pound;/g,"\xA3")
	x = x.replace(/€/g,"\u20AC");	x = x.replace(/&euro;/g,"\u20AC") 
	x = x.replace(/©/g,"\xA9");	x = x.replace(/&copy;/g,"\xA9") 
	x = x.replace(/®/g,"\xAE");	x = x.replace(/&reg;/g,"\xAE") 
	x = x.replace(/ª/g,"\xAA");	x = x.replace(/&ordf;/g,"\xAA") 
	x = x.replace(/º/g,"\xBA");	x = x.replace(/&ordm;/g,"\xBA") 
	x = x.replace(/°/g,"\xB0");	x = x.replace(/&deg;/g,"\xB0") 
	x = x.replace(/±/g,"\xB1");	x = x.replace(/&plusmn;/g,"\xB1")
	x = x.replace(/×/g,"\xD7");	x = x.replace(/&times;/g,"\xD7") 
	
		
	return x
}

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

function validarFecha(fecha,signo,hora){
	if(!signo)
		var signo = "/";
	if(hora)
		var datos = hora.split(":");
	var valor = fecha.split(signo);
	if(valor.length < 3)
		return false;
	if(valor[2].length < 4)
		return false;
	if(!datos){
		return new Date(parseInt(valor[2],10),(parseInt(valor[1],10) - 1),parseInt(valor[0],10));
	}else{
		if(datos.length < 3){
			return new Date(parseInt(valor[2],10),(parseInt(valor[1],10) - 1),parseInt(valor[0],10),parseInt(datos[0],10),parseInt(datos[1],10));
		}else{
			return new Date(parseInt(valor[2],10),(parseInt(valor[1],10) - 1),parseInt(valor[0],10),parseInt(datos[0],10),parseInt(datos[1],10),parseInt(datos[2],10));
		}
	}
}

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

var primerslap=false; 
var segundoslap=false; 

function formateafecha(fecha,a_no1,a_no2) 
{ 
	var long = fecha.length; 
	var dia; 
	var mes; 
	var ano; 

	if ((long>=2) && (primerslap==false)) { dia=fecha.substr(0,2); 
	if ((IsNumeric(dia)==true) && (dia<=31) && (dia!="00")) { fecha=fecha.substr(0,2)+"/"+fecha.substr(3,7); primerslap=true; } 
	else { fecha=""; primerslap=false;} 
	} 
	else 
	{ dia=fecha.substr(0,1); 
	if (IsNumeric(dia)==false) 
	{fecha="";} 
	if ((long<=2) && (primerslap=true)) {fecha=fecha.substr(0,1); primerslap=false; } 
	} 
	if ((long>=5) && (segundoslap==false)) 
	{ mes=fecha.substr(3,2); 
	if ((IsNumeric(mes)==true) &&(mes<=12) && (mes!="00")) { fecha=fecha.substr(0,5)+"/"+fecha.substr(6,4); segundoslap=true; } 
	else { fecha=fecha.substr(0,3);; segundoslap=false;} 
	} 
	else { if ((long<=5) && (segundoslap=true)) { fecha=fecha.substr(0,4); segundoslap=false; } } 
	if (long>=7) 
	{ ano=fecha.substr(6,4); 
	if (IsNumeric(ano)==false) { fecha=fecha.substr(0,6); } 
	else { if (long==10){ if ((ano==0) || (ano<a_no2) || (ano>a_no1)) { fecha=fecha.substr(0,6); } } } 
	} 

	if (long>=10) 
	{ 
	fecha=fecha.substr(0,10); 
	dia=fecha.substr(0,2); 
	mes=fecha.substr(3,2); 
	ano=fecha.substr(6,4); 
	// Año no viciesto y es febrero y el dia es mayor a 28 
	if ( (ano%4 != 0) && (mes ==02) && (dia > 28) ) { fecha=fecha.substr(0,2)+"/"; } 
	} 
	return (fecha); 
} 

/**************************************************************
Máscara de entrada para las Horas
****************************************************************/
var patron = new Array(2,2)
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


function evitarBackHistory(evnt){
	var temporal = document.all?parseInt(evnt.keyCode): parseInt(evnt.which);
	if (temporal == 8 ) return false;
	return true;
}

function formatotexto(texto)
{
	var textos = new Array("de","del","la","el", "en", "y", "demas", "con", "los", "al", "a");
	var textosmayus = new Array("c.c","c.c.","c/c","i", "ii","iii","iv","v","vi","vii","viii","ix","x","c.a","c.a.","s.a","s.a.","s.r.l","s.r.l.");
	var articulo;
	var count;
	var newtext = texto.value.toLowerCase();
	var arraytext = newtext.split(" ");
	var auxtext;
	
	for(i = 0; i <= arraytext.length - 1; i++)
	{
		articulo = false;
		count = 0;
		while(articulo == false && count <= textos.length - 1)
		{
			if(arraytext[i] == textos[count] && i > 0) articulo = true;
			count++;
		} 
		if(articulo == false)
		{
			articulo = false;
			count = 0;
			while(articulo == false && count <= textosmayus.length - 1)
			{
				if(arraytext[i] == textosmayus[count])
				{
					articulo = true;
					arraytext[i] = arraytext[i].toUpperCase();
				}
				count++;
			} 
			if(articulo == false)
			{
				if(arraytext[i].length > 1)
				{
					auxtext = arraytext[i].substring(0,1);
					arraytext[i] = auxtext.toUpperCase() + arraytext[i].substring(1,arraytext[i].length);
				} else {
					auxtext = arraytext[i].toUpperCase();
					arraytext[i] = auxtext;
				}
			}
		}
	}
	texto.value = arraytext.join(" ");
}