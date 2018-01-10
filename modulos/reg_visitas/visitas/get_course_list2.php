<?php
/*$host_name = 'bG9jYWxob3N0';
$user_name = 'cm9vdA==';
$pass_word = 'c3lzbG9nYWRtaW4=';
$database_name = 'c2VndXJpZGFkX3Byb3llY3Rv';*/
$host_name = 'localhost';
$user_name = 'root';
$pass_word = '1234';
$database_name = 'seguridad_proyecto';

/*
$conn = mysql_connect(base64_decode($host_name), base64_decode($user_name), base64_decode($pass_word)) or die ('Error connecting to mysql');
mysql_select_db(base64_decode($database_name));
*/
$conn = mysql_connect(($host_name), ($user_name), ($pass_word)) or die ('Error connecting to mysql');
mysql_select_db(($database_name));


$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "select organismo, id_organismo from organismo where organismo LIKE '%$q%'";
$rsd = mysql_query($sql);
while($rs = mysql_fetch_array($rsd)) {
	$cid = $rs['id_organismo'];
	$cname = html_entity_decode($rs['organismo'], ENT_COMPAT, 'UTF-8');
	echo "$cname|$cid\n";
}echo "<span style='font-weight:bold; color:#990000;'>".html_entity_decode("Si no Ex&iacute;ste.! Haga Clic en el Boton Justo al lado de esta caja de texto para agregarlo", ENT_COMPAT, 'UTF-8')."</span>"; 
/*
$q = strtolower($_GET["q"]);
if (!$q) return;
$search = new Recordset();
$search->sql = "select id_organismo, organismo from organismo where organismo LIKE '%$q%'";
$search->abrir();
	if($search->total_registros!=0){
		while ($search->total_registros!=0)
		{
			$search->siguiente();
			$cid = $search->fila['id_organismo'];
			$cname = html_entity_decode($search->fila['organismo'], ENT_COMPAT, 'UTF-8');
			echo "$cname|$cid\n";				
		}	
	} else {
		$cname = html_entity_decode("No Ex&iacute;ste.! Haga Clic en el Boton Justo al lado de esta caja de texto", ENT_COMPAT, 'UTF-8');
		$cid = "";
		echo "$cname|$cid\n";			 		
	}
	*/
	

?>
