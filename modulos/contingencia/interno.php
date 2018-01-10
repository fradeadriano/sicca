<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
//1
function sfg(){
	if(validacion()==false){
			return;
	}	
	bhj.submit();	
} 	
//2
function validacion (){
	if(document.getElementById("comp1").value == null || document.getElementById("comp1").value.length == 0 || /^\s+$/.test(document.getElementById("comp1").value))
	{
		alert(orto("El campo usuario est&aacute; vacio, por favor completelo"));
		document.getElementById("comp1").focus();
		return false;	
	}

	if(document.getElementById("comp2").value == null || document.getElementById("comp2").value.length == 0 || /^\s+$/.test(document.getElementById("comp2").value))
	{
		alert(orto("El campo Clave est&aacute; vacio, por favor completelo"));
		document.getElementById("comp2").focus();
		return false;	
	}

	if (document.getElementById("comp2").value.length < 6 || document.getElementById("comp2").value.length > 12 ){
		alert(orto("La clave debe estar comprendia entre 6 y 12 caracteres"));
		document.getElementById("comp2").focus();
		return false;
	}		
}
//3
function devol(){
	window.parent.messageObj.close();	
}
//4
function orto(x){
	x = x.replace(/ó/g,"\xF3");	x = x.replace(/&oacute;/g,"\xF3");
	x = x.replace(/á/g,"\xE1");	x = x.replace(/&aacute;/g,"\xE1");	
	return x;
}	
</script>
<?
require_once("../../librerias/Recordset.php");
require_once("../../librerias/Recordset.php");
$X1 = stripslashes($_POST["comp1"]);
$X2 = stripslashes($_POST["comp2"]);
$X3 = stripslashes($_POST["op"]);
$var1 = 0;
	if(isset($X1) && $X1!="" && isset($X2) && $X2!="")
	{
		if(ctype_alpha($X3))
		{		
			$search = new Recordset();
			$search->sql = "SELECT id_usuario, usuario, estatus, power_administrator, campo FROM seg_usuario WHERE (usuario = '".trim($X1)."' AND clave = md5('".trim($X2)."')) AND estatus = '0'";
			$search->abrir();
				if($search->total_registros == 1)
				{
					switch($X3){
						case 'ContRecep':
							$var1 = 1;	
						break;
						case 'ContAccion':
							$var1 = 1;	
						break;
						case 'ContOficio':
							$var1 = 1;	
						break;												
					}

				} else {
					$var1=10;
				}

		} else {
					$var1=9;
		}	
	} 
?>
<table width="800" height="500" border="0" bgcolor="#F9F9F9">
	<tr>
		<td valign="middle">
			<form name="bhj" id="bhj" method="post">			
			<table border="0" width="50%" height="50%" class="b_table_w" cellpadding="3" align="center">
				<tr>
					<td valign="top" colspan="2" align="center">
						<table width="99%" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td width="40px" align="left"><img src="../../images/usuario.png"/></td>
								<td class="titulomenu" valign="middle">Validar Usuario</td>
							</tr>
							<tr>
								<td colspan="2"><hr class="barra" /></td>
							</tr>
						</table>			
					</td>
				</tr>
				<tr>
					<td align="center">
						
						<table cellpadding="3" cellspacing="3" border="0" width="60%">
							<tr>
								<td align="right">
									Usuario:
								</td>
								<td>
									<input type="text" name="comp1" id="comp1" maxlength="10">
								</td>
							</tr>
							<tr>
								<td align="right">
									Clave:
								</td>
								<td>
									<input type="password" name="comp2" id="comp2" maxlength="12">
								</td>
							</tr>			
						</table>
							<input type="hidden" name="op" id="op" value="<? echo $_GET["me"]; ?>" autocomplete="off"/>
						
					</td>
				</tr>
				<tr>
					<td align="center">
						<table width="80%">
							<tr>
								<td>
								<p align="justify" class="mensaje">Usted Debe Validarse para Ingresar a esta Secci&oacute;n del sistema.</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>	
				<tr>
					<td align="center" id="botoneras" style="display:">
						<? if ($var1==1)
						{
						?>
							<script language="javascript" type="text/javascript">
								alert(orto("Validaci&oacute;n Correcta!!"));
								devol();
							</script>
						<? } else if ($var1==10) { ?>
							<script language="javascript" type="text/javascript">
								alert(orto("Validaci&oacute;n Incorrecta!!"));
							</script>
							<input type="button" class="botones" onclick="sfg();" id="ir" name="ir" value="Validar" title="Validar" />&nbsp;
							<input type="button" class="botones" onclick="javascript:window.parent.vol();" id="re" name="re" value="Regresar" title="Regresar" />
						<? } else { ?>
							<input type="button" class="botones" onclick="sfg();" id="ir" name="ir" value="Validar" title="Validar" />&nbsp;	
							<input type="button" class="botones" onclick="javascript:window.parent.vol();" id="re" name="re" value="Regresar" title="Regresar" />	
						<? } ?>
					</td>
				</tr>
				<tr>
					<td align="center">
						<div id="ver"></div>
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
	