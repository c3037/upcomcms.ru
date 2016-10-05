<?php header('Content-Type: text/html; charset=utf-8'); ?>
<strong>Генератор лицензионных ключей для UpComCMS.</strong>
<br />
<hr />
<br />
<?php

if(isset($_POST) and count($_POST) > 0){
	$app_version = $_POST['app_version'];
	$app_id = $_POST['app_id'];
	$license_expiration = date( 'Y-m-d', strtotime('+40 days') ); //$_POST['license_expiration'];
	
	switch ($app_version) {
		case "1.00":
			$salt = "12876c0b23c5fc70125874";
		break;
        case "1.01":
			$salt = "12876c0b23c5fc70125874";
		break;
        case "1.02":
			$salt = "12876c0b23c5fc70125874";
		break;
	}
    
    $key = sha1($app_id.$salt.$license_expiration);
    
	echo "<strong>AppVersion:</strong> ",$app_version;
	echo "<br />";
	echo "<strong>AppID:</strong> ",$app_id;
	echo "<br /><br />";
	echo "<strong>LicenseExpiration:</strong> ",$license_expiration;
	echo "<br />";
	echo "<strong>LicenseKey:</strong> ",$key;
	echo "<br /><br /><hr /><br />";
}
?>
<form autocomplete="off" action="" method="post">
<strong>App_version:</strong> <input type="text" name="app_version" /><br /><br />
<strong>App_id:</strong> <input type="text" name="app_id" /><br /><br />
<!-- <strong>License_expiration:</strong> <input type="text" name="license_expiration" /><br /><br /> -->
<input type="submit" />
</form>