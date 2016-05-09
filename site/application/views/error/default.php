<?php defined('SYSPATH') or die('No direct script access.'); ?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title><?= $error?></title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="" />
	<meta name="description" content="" />
	
</head>
<body>

<p>Wystąpił następujący błąd podczas realizacji Twojego żądania. </p>
<p><?= $error ;?></p>

</body>
</html>