<?php
	date_default_timezone_set('UTC');
	$ROMANS = array('I', 'I', 'II', 'III', 'IV', 'V',
			'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');

	/**
	 * @return
	 *      A space-separated list of event-level classes (big, bigger, tsunami,
	 *      etc...)
	 */
	function getClasses ($event) {
		$classes = array();

		$mag = floatval($event['mag']);
		$sig = floatval($event['sig']);

		if ($mag > 6.5) {
			$classes[] = 'bigger';
		} else if ($mag > 4.5) {
			$classes[] = 'big';
		}

		if ($sig > 650) {
			$classes[] = 'significant';
		}

		if ($event['tsunami'] != null) {
			$classes[] = 'tsunami';
		}

		return implode(' ', $classes);
	}

	/**
	 * @return
	 *      A human-readable format of the latitude and longitude coordinates for
	 *      the given event.
	 */
	function getCoords ($event, $withDepth = false) {
		$latitude = floatval($event['latitude']);
		$lat_extra = 'N';
		$longitude = floatval($event['longitude']);
		$lng_extra = 'E';
		$depth_str = '';

		if ($latitude < 0.0) {
			$latitude *= -1.0;
			$lat_extra = 'S';
		}

		if ($longitude < 0.0) {
			$longitude *= -1.0;
			$lng_extra = 'W';
		}

		if ($withDepth) {
			$depth_str .= ', ' . number_format($event['depth'], 1) . 'km deep';
		}

		return number_format($latitude, 2) . '&deg;' . $lat_extra . ', ' .
				number_format($longitude, 2) . '&deg;' . $lng_extra . $depth_str;
	}

	function getTime ($event) {
		$stamp = intval(substr($event['time'], 0, 10));
		return date('c', $stamp); // ISO-8601
	}

	function getFeltInt ($event) {
		global $ROMANS;

		$intensity = $event['cdi'];
		$reports = $event['felt'];
		$markup = '';

		if ($intensity != null && $felt != null) {
			$roman = $ROMANS[round(floatval($intensity))];
			$markup .= '<span class="roman mmi-' . $roman . '">' . $roman .
					'</span> <span class="reports">(based on ' . $reports .
					' reports)</span>';
		} else {
			$markup = '<span class="none">N/A</span>';
		}

		return $markup;
	}

	function getInstInt ($event) {
		global $ROMANS;

		$intensity = $event['mmi'];
		$markup = '';

		if ($intensity != null) {
			$roman = $ROMANS[round(floatval($intensity))];
			$markup .= '<span class="roman mmi-' . $roman . '">' . $roman .
					'</span>';
		} else {
			$markup .= '<span class="none">N/A</span>';
		}

		return $markup;
	}

	function getAlertLvl ($event) {
		$alert = $event['alert'];
		$markup = '';

		if ($alert != null) {
			$markup .= '<span class="alert-level-' . $alert . '">' .
					ucfirst($alert) . '</span>';
		} else {
			$markup .= '<span class="non">N/A</span>';
		}

		return $markup;
	}
