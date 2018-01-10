<?
require_once("../../../librerias/Recordset.php");
	$search = new Recordset();
					//$search->sql = "SELECT titulo_accion, accion FROM seg_bitacora WHERE id_bitacora = 696";
					$search->sql = "SELECT motivo FROM crp_devolucion_correspondencia WHERE id_devolucion_correspondencia = 5";
						$search->abrir();
							$search->siguiente();
								//$a = $search->fila["titulo_accion"];
								//$b = $search->fila["accion"];
								$b = $search->fila["motivo"];
								echo base64_decode($a); 
								echo base64_decode($b); 
								echo "<br>";
								echo base64_encode("images/top-siccaBK.jpg");

?>