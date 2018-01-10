<script language="javascript" type="text/javascript">

// 1
function ver(){
var res = val_Asi();		
	if(res!=false){
		document.getElementById("acc").value = "registrar";
		document.form.submit();
	}	
}

function val_Asi(){
	if (document.getElementById("clave").value == null || document.getElementById("clave").value.length == 0 || /^\s+$/.test(document.getElementById("clave").value)){
			alert(acentos("El campo Nueva Clave est&aacute; vacio, por favor completelo"));
			document.getElementById("clave").focus();
			return false;
		}

	if (document.getElementById("repetir").value == null || document.getElementById("repetir").value.length == 0 || /^\s+$/.test(document.getElementById("repetir").value)){
			alert(acentos("El campo Repetir Clave est&aacute; vacio, por favor completelo"));
			document.getElementById("repetir").focus();
			return false;
		}

	if (document.getElementById("clave").value.length < 6 || document.getElementById("clave").value.length > 12){
			alert(acentos("El campo Nueva Clave debe ser mayor a 6 caracteres!"));
			document.getElementById("clave").focus();
			return false;
		}

	if (document.getElementById("repetir").value.length < 6 || document.getElementById("repetir").value.length > 12){
			alert(acentos("EL campo Repetir Clave debe ser mayor a 6 caracteres!"));
			document.getElementById("repetir").focus();
			return false;
		}

	if (document.getElementById("clave").value != document.getElementById("repetir").value){
			alert(acentos("El campo Nueva Clave y Repetir Clave no coinciden, Verifique!! deben ser Iguales."));
			document.getElementById("clave").select();
			return false;
		}
		
}

</script>