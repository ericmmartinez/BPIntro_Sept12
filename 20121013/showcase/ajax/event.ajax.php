<?php
	$eventid = $_GET['id'];

	$event = file_get_contents(
		"http://earthquake.usgs.gov/earthquakes/eventpage/${eventid}.json");

	if (!$as_include_file) {
		// This is not a part of an include file. Send a header and encode the
		// results as JSON

		if (isset($_GET['callback'])) {
			header('Content-Type: text/javascript');
			print htmlspecialchars($_GET['callback']) . '(' .
					$event . ');';
		} else {
			header('Content-Type: application/json');
			print $event;
		}
	} else {
		$event = json_decode($event, true);
	}
?>
