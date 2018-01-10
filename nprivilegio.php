<?
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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acceso No Autorizado</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="logueo">
    <table id="seguridad" border="0" align="center" cellpadding="2">
        <tr>
			<td height="500"></td>
		</tr>
		<tr>
            <td width="193" align="center" valign="bottom"><strong class="classIP">Accede desde:&nbsp;<? echo $realip; ?></strong></td>
        </tr>
        <tr>
			<td height="40"></td>
		</tr>		
    </table>
</div>
</body>
</html>
<script language="javascript" type="text/javascript">
	var principal = window.location+"";
	window.setTimeout("window.location.href='"+principal.replace("/nprivilegio.php","")+"'",5000)
</script>