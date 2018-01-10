<?
	session_start();	
	require_once("../../../librerias/Recordset.php");
	require_once("../../../librerias/bitacora.php");	
	$qorga = stripslashes($_GET["organismo_tt"]);
	if ((isset($qorga) && $qorga !="")){	
		//if(ctype_alpha($qorga)){	
			$search = new Recordset();
			$search->sql = "SELECT * FROM organismo WHERE organismo.organismo = '".$qorga."'";
				$search->abrir();
				if($search->total_registros == 0)
				{
					$searchP = new Recordset();
					$searchP->sql = "insert into organismo (organismo) values('".$qorga."');";
					$searchP->abrir();
					$searchP->cerrar();
					unset($searchP);
					/*bitacora*/bitacora ($_SESSION["usuario"],date("Y-m-d"),date("h:i:s"),"Registro de Visitantes","Registro de Visitantes: Se registro un Organ&iacute;smo llamado: ".$qorga);							

					$bus = new Recordset();
					$bus->sql = "SELECT id_organismo, organismo FROM organismo WHERE organismo.organismo = '".$qorga."'";
					$bus->abrir();
					if($bus->total_registros != 0)
					{
					$bus->siguiente();
?>
					<script language="javascript" type="text/javascript"> 
						window.parent.frames.iresult.document.getElementById("id_organismo").value ="<? echo $bus->fila["id_organismo"]; ?>"; 
						window.parent.frames.iresult.document.getElementById("organismo").value="<? echo $bus->fila["organismo"]; ?>"; 
						window.parent.closeMessage();
					</script>
<?
					}					
				}
		//	}
		}
// hacer_llamados("modulos/reg_visitas/visitas/busq.php?ce='.$qdate.'");
?>
