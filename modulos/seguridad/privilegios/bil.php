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

//  4
function devolver(id,usu,nom,ape,idds){ 
	window.top.document.getElementById("usuario").value = usu;
	window.top.document.getElementById("nombres").value = nom;
	window.top.document.getElementById("apellidos").value = ape;
	window.top.document.getElementById("idusu").value = id;
	iniciarM(idds);	
}

// 5 www.javascriptya.com.ar

//6
function crea(c){
	if(document.getElementById("idusu").value!="")
	{
		if(document.getElementById(c).checked == true) 
		{	
			window.frames.fra.location.href="modulos/seguridad/privilegios/alma.php?id="+c+"&modo=insert&usu="+document.getElementById("idusu").value;		
			alert(acentos("Permiso Asignado!"));		
		} else {
			window.frames.fra.location.href="modulos/seguridad/privilegios/alma.php?id="+c+"&modo=delete&usu="+document.getElementById("idusu").value;		
			alert(acentos("Permiso Denegado!"));		
		}
	} else {
		alert(acentos("Debe Seleccionar un Usuario para Asignar Privilegios!"));		
	}
}

function iniciarM(dd){

	var contenedor= "";
	contenedor = dd.split("-");
	var checkboxes = document.getElementById("form").checkbox;
	
	for (i=0;i<contenedor.length;i++)
	{
		for(a=1; a < checkboxes.length; a++) 
		{
			if(contenedor[i]==checkboxes[a].value){
				checkboxes[a].checked=true;
				
			}
		}
	}	
}

function cancel(){
	document.getElementById("usuario").value = "";
	document.getElementById("nombres").value = "";
	document.getElementById("apellidos").value = "";
	document.getElementById("idusu").value = "";	
	cargar_lista("modulos/seguridad/privilegios/privilegios_d.php?pagina=1");
	var checkboxes = document.getElementById("form").checkbox;
	
	for(a=1; a < checkboxes.length; a++) 
	{
		checkboxes[a].checked=false;
	}	
}
</script>
<?
function List_pri(){
	$searchFather = new Recordset();
	$searchFather->sql = "SELECT id_modulo, modulo, id_modulo_padre, imagen FROM seg_modulo WHERE id_modulo_padre = 0 order by orden";		
	$searchFather->abrir();
	if($searchFather->total_registros != 0) 
	{
		$mEnU_OptIOns = '<table border="0" width="100%" align="left" class="b_table1" cellpadding="0" cellspacing="2"><tr valign="top" >';
		$tamcolumna = (100 / $searchFather->total_registros); 
		for ($i=1;$i <= $searchFather->total_registros; $i++)
			{
				$searchFather->siguiente();
				$mEnU_OptIOns = $mEnU_OptIOns. '<td width="'.$tamcolumna.'%" align="left" ><b><input type="checkbox" name="checkbox" id="'.$searchFather->fila["id_modulo"].'" value="'.$searchFather->fila["id_modulo"].'" onclick="crea('.$searchFather->fila["id_modulo"].');"/>&nbsp;'.$searchFather->fila["modulo"].'</b>';
				$searchFirstGeneration = new Recordset();
				$searchFirstGeneration->sql = "SELECT id_modulo, modulo, id_modulo_padre, acronimo FROM seg_modulo WHERE (id_modulo_padre = '".$searchFather->fila["id_modulo"]."') order by orden;";
				$searchFirstGeneration->abrir();
				if($searchFirstGeneration->total_registros != 0)
				{				
					$mEnU_OptIOns = $mEnU_OptIOns. '<table border="0" bgcolor="#E7F0F8">';
					for ($j=1;$j <= $searchFirstGeneration->total_registros; $j++)
						{				
							$searchFirstGeneration->siguiente();						
							$searchSecondGeneration = new Recordset();
							$searchSecondGeneration->sql = "SELECT id_modulo, modulo, id_modulo_padre, acronimo FROM seg_modulo WHERE (id_modulo_padre = '".$searchFirstGeneration->fila["id_modulo"]."') order by orden;";
							$searchSecondGeneration->abrir();	
//							$acro1 = "document.getElementById('elegido').value='".$searchFirstGeneration->fila["acronimo"]."';do_it()";
							$mEnU_OptIOns = $mEnU_OptIOns. "<tr><td align='left'>&nbsp;&nbsp;<input type='checkbox' name='checkbox' id=".$searchFirstGeneration->fila["id_modulo"]." value=".$searchFirstGeneration->fila["id_modulo"]." onclick='crea(".$searchFirstGeneration->fila["id_modulo"].");' /><span class='first'>".$searchFirstGeneration->fila["modulo"]."</span>";
							if($searchSecondGeneration->total_registros != 0)
							{	
								$mEnU_OptIOns = $mEnU_OptIOns. '<table border="0" bgcolor="#B7FFB7">';
								for ($z=1;$z <= $searchSecondGeneration->total_registros; $z++)
									{
										$searchSecondGeneration->siguiente();
										//$acro2 = "document.getElementById('elegido').value='".$searchSecondGeneration->fila["acronimo"]."';do_it()";
										$mEnU_OptIOns = $mEnU_OptIOns. "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='checkbox' id=".$searchSecondGeneration->fila["id_modulo"]." value=".$searchSecondGeneration->fila["id_modulo"]." onclick='crea(".$searchSecondGeneration->fila["id_modulo"].");'/><span class='second'>".$searchSecondGeneration->fila["modulo"]."</span>";
										$searchThirdGeneration = new Recordset();
										$searchThirdGeneration->sql = "SELECT id_modulo, modulo, id_modulo_padre, acronimo FROM seg_modulo WHERE (id_modulo_padre = '".$searchSecondGeneration->fila["id_modulo"]."') order by orden;";
										$searchThirdGeneration->abrir();											
										if($searchThirdGeneration->total_registros != 0)
										{
											$mEnU_OptIOns = $mEnU_OptIOns. '<table border="0">';
											for ($b=1;$b <= $searchThirdGeneration->total_registros; $b++)
												{
													$searchThirdGeneration->siguiente();
													//$acro3 = "document.getElementById('elegido').value='".$searchThirdGeneration->fila["acronimo"]."';do_it()";
													$mEnU_OptIOns = $mEnU_OptIOns. "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='checkbox' id=".$searchThirdGeneration->fila["id_modulo"]." value=".$searchThirdGeneration->fila["id_modulo"]." onclick='crea(".$searchThirdGeneration->fila["id_modulo"].");' /><span class='third'>".$searchThirdGeneration->fila["modulo"]."</span></td></tr>";													
												}
											$mEnU_OptIOns = $mEnU_OptIOns. '</table>';																								
										} else {
											$mEnU_OptIOns  = $mEnU_OptIOns. '</td>';
										}
									}	
								$mEnU_OptIOns = $mEnU_OptIOns. '</table>';								
							} else {
								$mEnU_OptIOns  = $mEnU_OptIOns. '</td>';	
							}
						}
					$mEnU_OptIOns = $mEnU_OptIOns. '</table>';
				} else {
					$mEnU_OptIOns  = $mEnU_OptIOns. '</td>';
				}
			}
		//$acro4 = "document.getElementById('elegido').value='cl';do_it()";
		$mEnU_OptIOns  = $mEnU_OptIOns. "</tr></table>";
		echo $mEnU_OptIOns;
	}	
}
?>