<?php
/*$host_name = 'bG9jYWxob3N0';
$user_name = 'cm9vdA==';
$pass_word = 'MTIzNA==';
$database_name = 'c2VndXJpZGFkX3Byb3llY3Rv';*/


$host_name = 'bG9jYWxob3N0';
$user_name = 'c2ljY2E=';
$pass_word = 'MTIzNA=='; 
$database_name = 'c2ljY2E=';

$conn = mysql_connect(base64_decode($host_name), base64_decode($user_name), base64_decode($pass_word)) or die ('Error connecting to mysql');
mysql_select_db(base64_decode($database_name));

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "select organismo, id_organismo from organismo where cgr <> 1 AND organismo LIKE '%$q%'";
$rsd = mysql_query($sql);
while($rs = mysql_fetch_array($rsd)) {
	$cid = $rs['id_organismo'];
	$cname = html_entity_decode($rs['organismo'], ENT_COMPAT, 'UTF-8');
	echo "$cname|$cid\n";
}echo "<span style='font-weight:bold; color:#990000;'>".html_entity_decode("Si no Ex&iacute;ste.! Agreguelo desde el menu Mantenimiento seguido la opcion Organ&iacute;smos", ENT_COMPAT, 'UTF-8')."</span>"; 
?>
