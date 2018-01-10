<?php
$host_name = 'localhost';
$user_name = 'root';
$pass_word = '1234';
$database_name = 'sicca';


/*$host_name = 'bG9jYWxob3N0';
$user_name = 'c2ljY2E=';
$pass_word = 'MTIzNA==';
$database_name = 'c2ljY2E=';*/

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
}echo "<span style='font-weight:bold; color:#990000;'>".html_entity_decode("No Ex&iacute;ste el Organismo", ENT_COMPAT, 'UTF-8')."</span>"; 
?>
