<?php
	if (!function_exists('evt_r')) {
		function evt_r ($e) {
			$event = $e['properties'];
			$coords = $e['geometry']['coordinates'];
			$event['longitude'] = $coords[0];
			$event['latitude'] = $coords[1];
			$event['depth'] = $coords[2];
			$event['url'] = 'event/' . $event['net'] . $event['code'];
			return $event;
		}
	}

	$base_url = ''; //str_replace($_SERVER['DOCUMENT_ROOT'], '', __FILE__);
	$feeds = array('2.5', 'all', 'significant');

	$default_feed = '2.5';
	$default_start = 0;
	$default_count = 50;

	$feed = (isset($_GET['feed'])) ? $_GET['feed'] : $default_feed;
	$start = (isset($_GET['start'])) ? intval($_GET['start']) : $default_start;
	$count = (isset($_GET['count'])) ? intval($_GET['count']) : $default_count;

	if (!in_array($feed, $feeds)) { $feed = $default_feed; }
	$next = $start + $count;

	$data = json_decode(file_get_contents(
		"http://earthquake.usgs.gov/earthquakes/feed/geojson/${feed}/month"),
		true // Using true returns an assoc. array rather than an object.
	);

	$events = array_map("evt_r", array_slice($data['features'], $start, $count));
	$next_link = $base_url . '?feed=' . $feed . '&start=' . $next .
			'&count=' . $count;

	if (!$as_include_file) {
		// This is not a part of an include file. Send a header and encode the
		// results as JSON
		$results = array('next_link' => $next_link, 'events' => $events);

		if (isset($_GET['callback'])) {
			header('Content-Type: text/javascript');
			print htmlspecialchars($_GET['callback']) . '(' .
					json_encode($results) . ');';
		} else {
			header('Content-Type: application/json');
			print json_encode($results);
		}
	}
?>
