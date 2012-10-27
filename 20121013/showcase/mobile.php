<!DOCTYPE html>
<html lang="en">
<head>
	<title>Recent Earthquakes</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta charset="UTF-8"/>

	<!-- CSS goes here -->
	<link rel="stylesheet" href="css3/mobile.css"/>

	<!--[if lt IE 9]><script src="/js/html5shiv.js"></script><![endif]-->
</head>
<body>
<?php
	// Suppress the ajax output. We just want the $events and $next_link
	$as_include_file = true;
	
	// We now have access to $events and $next_link
	include_once 'ajax/dataminer.ajax.php';
	include_once 'inc/format.mobile.php';
?>

	<header id="header">
		Recent Earthquakes
		<a href="?view=desktop" id="todesktop">Desktop Version</a>
	</header>

	<section id="events">
	<ol><?php
		foreach ($events as $event) {
			print getEventItem($event);
		}
	?></ol>
	</section>

	<footer>
		<a href="<?php print $next_link; ?>">More Earthquakes</a>
	</footer>
	
</body>
</html>
