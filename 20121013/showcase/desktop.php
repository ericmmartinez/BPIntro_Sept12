<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="ie ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en">         <!--<![endif]-->
<head>
	<title>Recent Earthquakes</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

	<!-- CSS goes here -->
	<link rel="stylesheet" href="css1/desktop.css"/>

	<!--[if lt IE 9]><script src="/js/html5shiv.js"></script><![endif]-->
</head>
<body>
	<?php
		// Up the defaults because we're on desktop
		if (!isset($_GET['feed'])) { $_GET['feed'] = 'all'; }
		if (!isset($_GET['count'])) { $_GET['count'] = 100; }

		// Suppress the ajax output. We just want the $events and $next_link
		$as_include_file = true;

		// We now have access to $events and $next_link
		include_once 'ajax/dataminer.ajax.php';
		include_once 'inc/format.desktop.php';
	?>

	<header id="header">
		Recent Earthquakes
		<a href="?view=mobile" id="tomobile">Mobile Version</a>
	</header>
	<section id="events">
		<table>
			<thead>
				<tr>
					<th class="magnitude" scope="col">
							<abbr title="Magnitude">M</abbr></th>
					<th class="region" scope="col">Region Name</th>
					<th class="time" scope="col">UTC Time</th>
					<th class="depth" scope="col">Depth</th>
					<th class="dyfi" scope="col">Reported Intensity</th>
					<th class="shakemap" scope="col">Instrumental Intensity</th>
					<th class="pager" scope="col">Alert Level</th>
				</tr>
			</thead>
			<tbody id="eventsContent">
				<?php foreach ($events as $event) { ?>
					<tr id="event-<?php print $event['net'] . $event['code']; ?>"
							class="<?php print getClasses($event); ?>">
						<td class="magnitude"><?php
								print number_format($event['mag'], 1); ?></td>
						<td class="region">
							<a href="<?php print $event['url']; ?>">
								<?php print $event['place']; ?>
							</a>
							<span class="coords">
								<?php print getCoords($event); ?>
							</span>
						</td>
						<td class="time"><?php print getTime($event); ?></td>
						<td class="depth"><?php print $event['depth']; ?></td>
						<td class="dyfi"><?php print getFeltInt($event); ?></td>
						<td class="shakemap"><?php print getInstInt($event); ?></td>
						<td class="pager"><?php print getAlertLvl($event); ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</section>

	<footer>
		<a id="nextLink" href="<?php print htmlspecialchars($next_link); ?>"
				>More Earthquakes</a>
	</footer>

	<!--[if !IE]><!-->
		<script src="js1/desktop.js"></script>
	<!--<![endif]-->
</body>
</html>
