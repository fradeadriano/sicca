<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado de Usuarios</title>
</head>
<body>
<form action="nprivilegio.php" name="ilegal" id="ilegal" method="post">
	<input type="hidden" name="archivo" value="'.$_SERVER['SCRIPT_NAME'].'" />
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
	document.getElementById("ilegal").submit();
</script>';
	die($hmtl);
}
require_once("librerias/Recordset.php");




function obtenerIP(){ 
	if ($_SERVER) {
		if ( $_SERVER["HTTP_X_FORWARDED_FOR"] ) {
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} elseif ( $_SERVER["HTTP_CLIENT_IP"] ) {
			$realip = $_SERVER["HTTP_CLIENT_IP"];
		} else {
			$realip = $_SERVER["REMOTE_ADDR"];
		}
	} else {
		if ( getenv( "HTTP_X_FORWARDED_FOR" ) ) {
			$realip = getenv( "HTTP_X_FORWARDED_FOR" );
		} elseif ( getenv( "HTTP_CLIENT_IP" ) ) {
			$realip = getenv( "HTTP_CLIENT_IP" );
		} else {
			$realip = getenv( "REMOTE_ADDR" );
		}
	}
	return $realip;
}

function place($p) {
	$mYiP = obtenerIP();
	$searchA = new Recordset();
	$searchA->sql = "SELECT ip FROM seg_usuario WHERE (usuario = '".trim($p)."' AND id_sesion = '".trim($_SESSION["Id"])."')";
	$searchA->abrir();
		if($searchA->total_registros == 0)
		{
			$searchP = new Recordset();
			$searchP->sql = "UPDATE seg_usuario SET ip = '".$mYiP."', id_sesion = '".trim($_SESSION["Id"])."' WHERE usuario = '".$p."'";
			$searchP->abrir();
			$searchP->cerrar();
			unset($searchP);
		}
}

function destruir($d){
	$searchD = new Recordset();
	$searchD->sql = "SELECT ip FROM seg_usuario WHERE (usuario = '".trim($d)."' AND id_sesion = '".trim($_SESSION["Id"])."')";
	$searchD->abrir();
		if($searchD->total_registros == 0)
		{
			$road = "http://".$_SERVER['HTTP_HOST']."/".basename(dirname(__FILE__))."/cerrar.php";
			header("Location: $road");
		}
}

function creacion($ruta){
   if (is_dir($ruta)) {
      if ($dh = opendir($ruta)) {
         while (($file = readdir($dh)) !== false) {
            if (is_dir($ruta . $file) && $file!="." && $file!=".."){
				creacion($ruta . $file . "/");
				if(file_exists($ruta . $file . "/conf.xml"))
				{
					busqueda($ruta . $file . "/conf.xml");
				}
			}
         }
      closedir($dh);
      }
   }
}

function busqueda($laruta){
	$biblioteca = new domdocument;
	$biblioteca->preserveWhiteSpace = false;
	$biblioteca->load($laruta);
	$biblioteca->documentElement;
	$ac = $biblioteca->getElementsByTagname("identificador");
		foreach ($ac as $ide) 
		{
			$KeY = $ide->firstChild->nodeValue;
		}
	if (trim($KeY)==base64_encode("benfica"))
	{
		$modulo = $biblioteca->getElementsByTagname("father");
		foreach ($modulo as $menu) 
		{
			
			//busqueda y guardado PADRE
			$search1 = new Recordset();
			$search1->sql = "SELECT id_modulo, modulo FROM seg_modulo WHERE (modulo = '".trim(utf8_decode($menu->getAttribute("id")))."')";
			$search1->abrir();		
			if($search1->total_registros == 0)
			{		
				$searchS = new Recordset();
				$searchS->sql = "INSERT INTO seg_modulo (modulo,id_modulo_padre, orden) VALUES ('".utf8_decode(trim($menu->getAttribute("id")))."', '0', '".trim($menu->getAttribute("orden"))."')";
				$searchS->abrir();
				$searchS->cerrar();
				unset($searchS);	

				$searchBP = new Recordset();
				$searchBP->sql = "SELECT id_modulo FROM seg_modulo WHERE (modulo = '".trim(utf8_decode($menu->getAttribute("id")))."')";
				$searchBP->abrir();	
				if($searchBP->total_registros != 0)
				{				
					$searchBP->siguiente();
					$id_padre = $searchBP->fila["id_modulo"];				
				
				}				
				$searchBP->cerrar();
				unset($searchBP);

			} else {
				$search1->siguiente();
				$id_padre = $search1->fila["id_modulo"];
				
			}		
			$search1->cerrar();
			unset($search1);
			//busqueda y guardado *******************************************************			
			//echo "<b>Modulo:</b> " . $menu->getAttribute("id") . "<br>";
			//return $menu->getAttribute("id");
			$fg = $menu->getElementsByTagname("FirstGeneration");
				foreach ($fg as $wfg) 
				{
					//BUSQUEDA Y GUARDARO PRIMERA GENERACION
					$search2 = new Recordset();
					$search2->sql = "SELECT id_modulo, modulo FROM seg_modulo WHERE (modulo = '".trim(utf8_decode($wfg->firstChild->nodeValue))."' AND id_modulo_padre = '$id_padre')";
					$search2->abrir();		
					if($search2->total_registros == 0)
					{		
						$searchS = new Recordset();
						$searchS->sql = "INSERT INTO seg_modulo (modulo,id_modulo_padre, ruta, imagen, acronimo, orden) VALUES ('".trim(utf8_decode($wfg->firstChild->nodeValue))."', '$id_padre', '".trim($wfg->getAttribute("ruta"))."', '".trim($wfg->getAttribute("imagen"))."', '".trim($wfg->getAttribute("acronimo"))."', '".trim($wfg->getAttribute("orden"))."')";
						$searchS->abrir();
						$searchS->cerrar();
						unset($searchS);
						
						
						$searchBF = new Recordset();
						$searchBF->sql = "SELECT id_modulo FROM seg_modulo WHERE (modulo = '".trim(utf8_decode($wfg->firstChild->nodeValue))."')";
						$searchBF->abrir();	
						if($searchBF->total_registros != 0)
						{				
							$searchBF->siguiente();
							$id_padre_FirstGeneration = $searchBF->fila["id_modulo"];				
						
						}				
						$searchBF->cerrar();
						unset($searchBF);						
										
					} else {
						$search2->siguiente();
						$id_padre_FirstGeneration = $search2->fila["id_modulo"];
					}		
					$search2->cerrar();
					unset($search2);

					//BUSQUEDA Y GUARDARO PRIMERA GENERACION				
					//echo "</br><b>Sub_Modulo:</b>"; 
					
					if($wfg->hasChildNodes())
						{
							$sg = $wfg->getElementsByTagname("SecondGeneration");
							foreach ($sg as $wsg) 
							{
								//BUSQUEDA Y GUARDARO segunda GENERACION
								$search3 = new Recordset();
								$search3->sql = "SELECT id_modulo, modulo FROM seg_modulo WHERE (modulo = '".trim(utf8_decode($wsg->firstChild->nodeValue))."' AND id_modulo_padre = '$id_padre_FirstGeneration')";
								$search3->abrir();		
								if($search3->total_registros == 0)
								{		
									$searchS = new Recordset();
									$searchS->sql = "INSERT INTO seg_modulo (modulo,id_modulo_padre, ruta, imagen, acronimo, orden) VALUES ('".trim(utf8_decode($wsg->firstChild->nodeValue))."', '$id_padre_FirstGeneration', '".trim($wsg->getAttribute("ruta"))."', '".trim($wsg->getAttribute("imagen"))."', '".trim($wsg->getAttribute("acronimo"))."', '".trim($wsg->getAttribute("orden"))."')";
									$searchS->abrir();
									$searchS->cerrar();
									unset($searchS);				
	
									$searchBS = new Recordset();
									$searchBS->sql = "SELECT id_modulo FROM seg_modulo WHERE (modulo = '".trim(utf8_decode($wsg->firstChild->nodeValue))."')";
									$searchBS->abrir();	
									if($searchBS->total_registros != 0)
									{				
										$searchBS->siguiente();
										$id_padre_SecondGeneration = $searchBS->fila["id_modulo"];				
									
									}				
									$searchBS->cerrar();
									unset($searchBS);							
								
								
								} else {
									$search3->siguiente();
									$id_padre_SecondGeneration = $search3->fila["id_modulo"];
								}		
								$search3->cerrar();
								unset($search3);
								//BUSQUEDA Y GUARDARO segunda GENERACION							
								//echo "<b>_____Sub_Sub_Modulo:</b>".$wsg->firstChild->nodeValue . "<br>";
								
								if($wsg->hasChildNodes())
									{
										$tg = $wsg->getElementsByTagname("ThirdGeneration");
										foreach ($tg as $wtg) 
										{
											//BUSQUEDA Y GUARDARO TERCERA GENERACION
											$search4 = new Recordset();
											$search4->sql = "SELECT id_modulo, modulo FROM seg_modulo WHERE (modulo = '".trim(utf8_decode($wtg->firstChild->nodeValue))."' AND id_modulo_padre = '$id_padre_SecondGeneration')";
											$search4->abrir();		
											if($search4->total_registros == 0)
											{		
												$searchS = new Recordset();
												$searchS->sql = "INSERT INTO seg_modulo (modulo,id_modulo_padre, ruta, imagen, acronimo, orden) VALUES ('".trim(utf8_decode($wtg->firstChild->nodeValue))."', '$id_padre_SecondGeneration', '".trim($wtg->getAttribute("ruta"))."', '".trim($wtg->getAttribute("imagen"))."', '".trim($wtg->getAttribute("acronimo"))."', '".trim($wtg->getAttribute("orden"))."')";
												$searchS->abrir();
												$searchS->cerrar();
												unset($searchS);										
											} /*else {
												$search4->siguiente();
												$id_padre = $search4->fila["id_modulo"];
											}*/		
											$search4->cerrar();
											unset($search4);
											//BUSQUEDA Y GUARDARO TERCERA GENERACION									
											//echo "<b>_____________Sub_Sub_Sub_Modulo:</b>".$wtg->firstChild->nodeValue . "<br>";
										}
									} 						
							}
						} 
				}
		}
	} 
}

function crear_menu($id,$snad)
{
	if ($snad==base64_encode("1"))
	{
		$searchFather = new Recordset();
		$searchFather->sql = "SELECT id_modulo, modulo, id_modulo_padre, imagen FROM seg_modulo WHERE id_modulo_padre = 0 order by orden";		
		$searchFather->abrir();
		if($searchFather->total_registros != 0)
		{
			$mEnU_OptIOns = '<form method="post" name="form_prime" id="form_prime"><table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"><tr><td background="'.$_SESSION["x"].'" height="100"></td></tr><tr><td background="../images/header.gif"><input type="hidden" name="elegido" id="elegido"/><ul class="menu" id="menu"><li><a style="cursor:pointer" class="menulink" onclick="do_it();" style="cursor:pointer">Panel</a></li>';
			for ($i=1;$i <= $searchFather->total_registros; $i++)
				{
					$searchFather->siguiente();
					$mEnU_OptIOns = $mEnU_OptIOns. '<li><a style="cursor:auto" class="menulink">'.$searchFather->fila["modulo"].'</a>';
					$searchFirstGeneration = new Recordset();
					$searchFirstGeneration->sql = "SELECT id_modulo, modulo, id_modulo_padre, acronimo FROM seg_modulo WHERE (id_modulo_padre = '".$searchFather->fila["id_modulo"]."') order by orden;";
					$searchFirstGeneration->abrir();
					if($searchFirstGeneration->total_registros != 0)
					{				
						$mEnU_OptIOns = $mEnU_OptIOns. '<ul>';
						for ($j=1;$j <= $searchFirstGeneration->total_registros; $j++)
							{				
								$searchFirstGeneration->siguiente();						
								$searchSecondGeneration = new Recordset();
								$searchSecondGeneration->sql = "SELECT id_modulo, modulo, id_modulo_padre, acronimo FROM seg_modulo WHERE (id_modulo_padre = '".$searchFirstGeneration->fila["id_modulo"]."') order by orden;";
								$searchSecondGeneration->abrir();	
								$acro1 = "document.getElementById('elegido').value='".$searchFirstGeneration->fila["acronimo"]."';do_it()";
								$mEnU_OptIOns = $mEnU_OptIOns. "<li><a class='sub1' onclick=".$acro1." style='cursor:pointer'>".$searchFirstGeneration->fila["modulo"]."</a>";
								if($searchSecondGeneration->total_registros != 0)
								{	
									$mEnU_OptIOns = $mEnU_OptIOns. '<ul>';
									for ($z=1;$z <= $searchSecondGeneration->total_registros; $z++)
										{
											$searchSecondGeneration->siguiente();
											$acro2 = "document.getElementById('elegido').value='".$searchSecondGeneration->fila["acronimo"]."';do_it()";
											$mEnU_OptIOns = $mEnU_OptIOns. "<li><a onclick=".$acro2." style='cursor:pointer'>".$searchSecondGeneration->fila["modulo"]."</a>";
											$searchThirdGeneration = new Recordset();
											$searchThirdGeneration->sql = "SELECT id_modulo, modulo, id_modulo_padre, acronimo FROM seg_modulo WHERE (id_modulo_padre = '".$searchSecondGeneration->fila["id_modulo"]."') order by orden;";
											$searchThirdGeneration->abrir();											
											if($searchThirdGeneration->total_registros != 0)
											{
												$mEnU_OptIOns = $mEnU_OptIOns. '<ul>';
												for ($b=1;$b <= $searchThirdGeneration->total_registros; $b++)
													{
														$searchThirdGeneration->siguiente();
														$acro3 = "document.getElementById('elegido').value='".$searchThirdGeneration->fila["acronimo"]."';do_it()";
														$mEnU_OptIOns = $mEnU_OptIOns. "<li class='topline'><a style='cursor:pointer' onclick=".$acro3.">".$searchThirdGeneration->fila["modulo"]."</a></li>";													
													}
												$mEnU_OptIOns = $mEnU_OptIOns. '</ul>';																								
											} else {
												$mEnU_OptIOns  = $mEnU_OptIOns. '</li>';
											}
										}	
									$mEnU_OptIOns = $mEnU_OptIOns. '</ul>';								
								} else {
									$mEnU_OptIOns  = $mEnU_OptIOns. '</li>';	
								}
							}
						$mEnU_OptIOns = $mEnU_OptIOns. '</ul>';
					} else {
						$mEnU_OptIOns  = $mEnU_OptIOns. '</li>';
					}
				}
			$acro4 = "document.getElementById('elegido').value='cl';do_it()";
			$mEnU_OptIOns  = $mEnU_OptIOns. "<li><a onclick=".$acro4." style='cursor:pointer' class='menulink'>Cerrar</a></li></ul></td></tr><tr><td height='20'></td></tr></table></form>";
			echo $mEnU_OptIOns;
		}	
	} else {
		$searchFather = new Recordset();
		$searchFather->sql = "SELECT seg_modulo.id_modulo, seg_modulo.modulo, seg_modulo.ruta, seg_modulo.acronimo, seg_modulo.id_modulo_padre 
							FROM seg_modulo 
							WHERE seg_modulo.id_modulo NOT IN (SELECT seg_acceso_modulo.id_modulo FROM seg_acceso_modulo WHERE seg_acceso_modulo.id_usuario = '".base64_decode($id)."') AND
								seg_modulo.id_modulo_padre = 0 order by orden";		
		$searchFather->abrir();
		if($searchFather->total_registros != 0)
		{
			$mEnU_OptIOns = '<form method="post" name="form_prime" id="form_prime"><table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"><tr><td background="'.$_SESSION["x"].'" height="100"></td></tr><tr><td background="images/header.gif"><input type="hidden" name="elegido" id="elegido" /><ul class="menu" id="menu">';
			for ($i=1;$i <= $searchFather->total_registros; $i++)
				{
					$searchFather->siguiente();			
					$searchFirstGeneration = new Recordset();
					$searchFirstGeneration->sql = "SELECT seg_modulo.id_modulo, seg_modulo.modulo, seg_modulo.ruta, seg_modulo.acronimo, seg_modulo.id_modulo_padre 
					 FROM seg_modulo 
					 WHERE seg_modulo.id_modulo NOT IN (SELECT seg_acceso_modulo.id_modulo FROM seg_acceso_modulo WHERE seg_acceso_modulo.id_usuario = '".base64_decode($id)."') AND 
					 		seg_modulo.id_modulo_padre = '".$searchFather->fila["id_modulo"]."' order by orden";
					$searchFirstGeneration->abrir();
					if($searchFirstGeneration->total_registros != 0)
					{	
						$mEnU_OptIOns = $mEnU_OptIOns. '<li><a style="cursor:auto" class="menulink">'.$searchFather->fila["modulo"].'</a>';
						$mEnU_OptIOns = $mEnU_OptIOns. '<ul>';
						for ($j=1;$j <= $searchFirstGeneration->total_registros; $j++)
							{				
								$searchFirstGeneration->siguiente();						
								$acro1 = "document.getElementById('elegido').value='".$searchFirstGeneration->fila["acronimo"]."';do_it()";
								$mEnU_OptIOns = $mEnU_OptIOns. "<li><a class='sub1' onclick=".$acro1." style='cursor:pointer'>".$searchFirstGeneration->fila["modulo"]."</a>";
								$searchSecondGeneration = new Recordset();
								$searchSecondGeneration->sql = "SELECT seg_modulo.id_modulo, seg_modulo.modulo, seg_modulo.ruta, seg_modulo.acronimo, seg_modulo.id_modulo_padre 
									FROM seg_modulo 
									WHERE seg_modulo.id_modulo NOT IN (SELECT seg_acceso_modulo.id_modulo FROM seg_acceso_modulo WHERE seg_acceso_modulo.id_usuario = '".base64_decode($id)."') 
									AND seg_modulo.id_modulo_padre = '".$searchFirstGeneration->fila["id_modulo"]."' order by orden";
								$searchSecondGeneration->abrir();	
								if($searchSecondGeneration->total_registros != 0)
								{	
									$mEnU_OptIOns = $mEnU_OptIOns. '<ul>';
									for ($z=1;$z <= $searchSecondGeneration->total_registros; $z++)
										{
											$searchSecondGeneration->siguiente();
											$acro2 = "document.getElementById('elegido').value='".$searchSecondGeneration->fila["acronimo"]."';do_it()";
											$mEnU_OptIOns = $mEnU_OptIOns. "<li><a onclick=".$acro2." style='cursor:pointer'>".$searchSecondGeneration->fila["modulo"]."</a></li>";
											$searchThirdGeneration = new Recordset();
											$searchThirdGeneration->sql = "SELECT seg_modulo.id_modulo, seg_modulo.modulo, seg_modulo.ruta, seg_modulo.acronimo, seg_modulo.id_modulo_padre 
																			FROM seg_modulo 
																			WHERE seg_modulo.id_modulo NOT IN (SELECT seg_acceso_modulo.id_modulo FROM seg_acceso_modulo WHERE seg_acceso_modulo.id_usuario = '".base64_decode($id)."') 
																			AND seg_modulo.id_modulo_padre = '".$searchSecondGeneration->fila["id_modulo"]."' order by orden";
											$searchThirdGeneration->abrir();											
											if($searchThirdGeneration->total_registros != 0)
											{
												$mEnU_OptIOns = $mEnU_OptIOns. '<ul>';
												for ($b=1;$b <= $searchThirdGeneration->total_registros; $b++)
													{
														$searchThirdGeneration->siguiente();
														$acro3 = "document.getElementById('elegido').value='".$searchThirdGeneration->fila["acronimo"]."';do_it()";
														$mEnU_OptIOns = $mEnU_OptIOns. "<li class='topline'><a style='cursor:pointer' onclick=".$acro3.">".$searchThirdGeneration->fila["modulo"]."</a></li>";													
													}
												$mEnU_OptIOns = $mEnU_OptIOns. '</ul>';																								
											} else {
												$mEnU_OptIOns  = $mEnU_OptIOns. '</li>';
											}
										}
									$mEnU_OptIOns = $mEnU_OptIOns. '</ul>';		
								} else {								
								$mEnU_OptIOns = $mEnU_OptIOns. '</li>';
								}	
							}
						$mEnU_OptIOns = $mEnU_OptIOns. '</ul>';
					} 					
				}
			$mEnU_OptIOns  = $mEnU_OptIOns. '<li><a href="cerrar.php" style="cursor:pointer" class="menulink">Cerrar</a></li></ul></td></tr><tr><td height="20"></td></tr></table></form>';
			echo $mEnU_OptIOns;
		}
	}
}
function ins_bitacora ($use,$fecha,$hora,$dir_ip,$acc,$titulo){	
	
	$cc = base64_encode($acc);
	$tc = base64_encode($titulo);
	$searchB = new Recordset();
	$searchB->sql = "INSERT INTO seg_bitacora (usuario,fecha,hora,ip,titulo_accion,accion) VALUES ('".$use."','".$fecha."', '".$hora."', '".$dir_ip."', '".$tc."', '".$cc."');";
	$searchB->abrir();
	$searchB->cerrar();
	unset($searchB);		
}
?>
