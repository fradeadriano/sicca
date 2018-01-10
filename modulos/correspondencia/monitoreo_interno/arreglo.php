<?
require_once("../../../librerias/Recordset.php");

for ($i=669;$i<1176;$i++)
{
	$searchD = new Recordset();
	$searchD->sql = "INSERT INTO crp_ruta_correspondencia_ext (id_estatus, id_correspondencia_externa, fecha_recepcion) VALUES (5,".$i.",'2013-06-12 00:00:00')";
	$searchD->abrir();
	$searchD->cerrar();
	unset($searchD);
}										
										
?>