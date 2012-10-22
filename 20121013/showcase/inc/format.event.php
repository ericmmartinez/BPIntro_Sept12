<?php
include_once 'functions.inc.php';
//date_default_timezone_set('UTC');

function getEventHeader ($event) {
	$summary = $event['summary'];
	$properties = $summary['properties'];

	$id = $summary['id'];
	$mag = number_format(floatval($summary['magnitude']), 1);
	$magtype = $properties['magnitude_type'];
	$place = $properties['region'];
	$date = '<span class="date">' .
		date('c', intval(substr($summary['time'], 0, -3))) . '</span>';
	$coords = '<span class="coords">' . getCoords($summary, true) . '</span>';
	$tellus = '<a href="http://earthquake.usgs.gov/earthquakes/eventpage/' .
			$id . '#dyfi_form">Did You Feel It? Tell Us!</a>';

	return "${mag}${magtype} - ${place} ${date} ${coords} ${tellus}";
}

function getEventImpact ($event) {
	static $ROMANS = array('I', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII',
			'IX', 'X', 'XI', 'XII');

	$summary = $event['summary'];
	$properties = $summary['properties'];
	$products = $event['products'];

	$id = $summary['id'];
	$pager = '';
	$shakemap = '';
	$dyfi = '';

	if (isset($products['losspager'])) {
		$pager_product = $products['losspager'][0];
		$pager_properties = $pager_product['properties'];

		$pager_link = $pager_product['contents']['exposure.png']['url'];
		$pager_alert = $pager_properties['alertlevel'];

		$pager = '<li class="losspager">' .
				'<a class="imagelink alert-' . $pager_alert . '" href="' .
					$pager_link . '">Alert Level ' . ucfirst($pager_alert) . '</a>' .
			'</li>';
	}

	if (isset($products['shakemap'])) {
		$shakemap_product = $products['shakemap'][0];
		$shakemap_properties = $shakemap_product['properties'];

		$shakemap_link =
				$shakemap_product['contents']['download/intensity.jpg']['url'];
		$shakemap_felt = round(floatval($properties['maxmmi']));
		$shakemap_roman = $ROMANS[$shakemap_felt];

		$shakemap = '<li class="shakemap">' .
				'<a class="imagelink mmi-' . $shakemap_roman . '" href="' .
					$shakemap_link . '">Instrumental Intensity: ' .
					'<span class="roman">' . $shakemap_roman . '</span>' .
				'</a>' .
			'</li>';
	}

	if (isset($products['dyfi'])) {
		$dyfi_product = $products['dyfi'][0];
		$dyfi_properties = $dyfi_product['properties'];

		$dyfi_link = $dyfi_product['contents'][$id.'_ciim.jpg']['url'];
		$dyfi_felt = round(floatval($dyfi_properties['maxmmi']));
		$dyfi_roman = $ROMANS[$dyfi_felt];
		$dyfi_count = $dyfi_properties['numResp'];

		$dyfi = '<li class="dyfi">' .
				'<a class="imagelink mmi-'.$dyfi_roman.'" href="'.$dyfi_link.'">' .
				'Reported Intensity: <span class="roman">' .
				$dyfi_roman . '</span> (based on ' . $dyfi_count . ' reports)</a>' .
			'</li>';
	}

	return "<ul>${pager} ${shakemap} ${dyfi}</ul>";
}

function getEventCommentary ($event) {
	$products = $event['products'];
	$tectonic = '';
	
	if (isset($products['tectonic-summary'])) {
		$tectonic_product = $products['tectonic-summary'][0];
		$file = $tectonic_product['contents']['tectonic-summary.inc.html'];
		$tectonic = @file_get_contents($file['url']);
		if ($tectonic === false) {
			$tectonic = '<a href="' . $file['url'] . '">Tectonic Summary</a>';
		} else {
			$tectonic = '<h3>Tectonic Summary</h3><article>' .
				preg_replace('/<img[^>]+\/>/', '', $tectonic) . '</article>';
		}
	}

	return $tectonic;
}

function getEventFooter ($event) {
	$id = $event['summary']['id'];

	return '<a href="http://earthquake.usgs.gov/earthquakes/eventpage/' .
			$id . '">More Information from the U.S. Geological Survey</a>';
}
