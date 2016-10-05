<?php
	$website = "upcomcms.ru";
	$protocol = "https";
	$address = $protocol."://cab.".$website;
	header('HTTP/1.1 302 Moved Temporarily');
	header("Location: $address");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $website; ?></title>
</head>
<body>
<a href="<?php echo $address; ?>" title="Перейти в личный кабинет.">Перейти в личный кабинет.</a>
</body>
</html>