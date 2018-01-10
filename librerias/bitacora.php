<?
function bitacora ($use,$fecha,$hora,$titulo,$acc){	
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

	$iip = $realip;
	$cc = base64_encode($acc);
	$tt = base64_encode($titulo);
	$searchB = new Recordset();
	$searchB->sql = "INSERT INTO seg_bitacora (usuario,fecha,hora,ip,titulo_accion,accion) VALUES ('".$use."','".$fecha."', '".$hora."', '".$iip."', '".$tt."', '".$cc."');";
	$searchB->abrir();
	$searchB->cerrar();
	unset($searchB);		
}
?>