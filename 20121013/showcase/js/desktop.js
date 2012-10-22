var ROMANS = ['I', 'I', 'II', 'III', 'IV', 'V',
		'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

var scrollOccurred = false,
	nextLink = null,
	loadingNext = false,
	tableBody = null;

var initialize = function (evt) {
	// Scroll event listener to flag when a scroll has occurred.
	window.onscroll = onScroll;

	// Only check scrolling on an interval.
	// See: http://ejohn.org/blog/learning-from-twitter
	window.setInterval(handleScroll, 250);

	nextLink = document.getElementById('nextLink');
	tableBody = document.getElementById('eventsContent');
};

var onScroll = function (scrollEvent) {
	scrollOccurred = true;
};

var handleScroll = function () {
	if (scrollOccurred) {
		// Check page position and potentially load
		// more results

		var position = window.innerHeight + window.pageYOffset,
			complete = document.documentElement.scrollHeight;
			percent = position / complete;

		if (percent >= 0.85 && !loadingNext) {
			loadNext();
		}
	}
};

var loadNext = function () {
	if (!loadingNext) {
		loadingNext = true;


		// Request next results (JSONP)
		var script = document.createElement('script');
		script.src = 'ajax/dataminer.ajax.php' + nextLink.getAttribute('href') +
				'&callback=loadResults';
		document.body.appendChild(script);

		// Update the loading link
		nextLink.setAttribute('href', '#');
		nextLink.innerHTML = 'Loading Additional Results...'; // TODO :: spinner?
	}
};

var loadResults = function (data) {
	var markup = [];

	if (data.events.length === 0) {
		// No more results
		nextLink.innerHTML = 'No More Results';
		return;
	}

	for (var i = 0, e = null; e = data.events[i]; i++) {
		markup.push(parseEventRow(e));
	}

	try {
		tableBody.innerHTML += markup.join('');
	} catch (e) {
		// IE
		var tb = document.createElement('tbody');
		tb.innerHTML = tableBody.innerHTML + markup.join('');
		tableBody.parentNode.replaceChild(tb, tableBody);
		tableBody = tb;
	}

	// Update the loading link
	nextLink.setAttribute('href', data.next_link);
	nextLink.innerHTML = 'More Earthquakes';

	// Unflag the loading status
	loadingNext = false;
};

var parseEventRow = function (e) {
	return [
		'<tr id="event-', e.net, e.code, '" class="', getClasses(e), '">',
			'<td class="magnitude">', e.mag, '</td>',
			'<td class="region">',
				'<a href="', e.url, '">', e.place, '</a>',
				'<span class="coords">', getCoords(e), '</span>',
			'</td>',
			'<td class="time">', getTime(e), '</td>',
			'<td class="depth">', e.depth, '</td>',
			'<td class="dyfi">', getFeltInt(e), '</td>',
			'<td class="shakemap">', getInstInt(e), '</td>',
			'<td class="pager">', getAlertLvl(e), '</td>',
		'</tr>'
	].join('');
};

var getClasses = function (e) {
	var classes = [],
		mag = parseFloat(e.mag),
		sig = parseFloat(e.sig);
	
	if (mag > 6.5) {
		classes.push('bigger');
	} else if (mag > 4.5) {
		classes.push('big');
	}

	if (sig > 650) {
		classes.push('significant');
	}

	if (e.tsunami !== null) {
		classes.push('tsunami');
	}

	return classes.join(' ');
};

var getCoords = function (e) {
	var latitude = parseFloat(e.latitude),
		longitude = parseFloat(e.longitude),
		lat_extra = 'N',
		lng_extra = 'E';
	
	if (latitude < 0.0) {
		latitude *= -1.0;
		lat_extra = 'S';
	}

	if (longitude < 0.0) {
		longitude *= -1.0;
		lng_extra = 'W';
	}

	return latitude.toFixed(2) + '&deg;' + lat_extra + ' ' +
			longitude.toFixed(2) + '&deg;' + lng_extra;
};

var getTime = function (e) {
	var d = new Date(parseInt(e.time) * 1000);
	
	function pad (n) {
		return n<10 ? '0'+n : n;
	}

	return d.getUTCFullYear() + '-' + pad(d.getUTCMonth() + 1) + '-' +
			pad(d.getUTCDate()) + 'T' + pad(d.getUTCHours()) + ':' +
			pad(d.getUTCMinutes()) + ':' + pad(d.getUTCSeconds()) + '+00:00';
};

var getFeltInt = function (e) {
	var intensity = e.cdi,
		reports = e.felt,
		markup = null,
		roman = null;
	
	if (intensity !== null && reports !== null) {
		roman = ROMANS[Math.round(parseFloat(intensity))];
		markup = '<span class="roman mmi-' + roman + '">' + roman +
				'</span> <span class="reports">(based on ' + reports +
				' reports)</span>';
	} else {
		markup = '<span class="none">N/A</span>';
	}

	return markup;
};

var getInstInt = function (e) {
	var intensity = e.mmi,
		markup = null,
		roman = null;
	
	if (intensity !== null) {
		roman = ROMANS[Math.round(parseFloat(intensity))];
		markup = '<span class="roman mmi-' + roman + '">' + roman +
				'</span>';
	} else {
		markup = '<span class="none">N/A</span>';
	}

	return markup;
};

var getAlertLvl = function (e) {
	var level = e.alert,
		markup = null;

	if (level !== null) {
		markup = '<span class="alert-level-' + level + '">' +
				level.charAt(0).toUpperCase() + level.slice(1) + '</span>';
	} else {
		markup = '<span class="none">N/A</span>';
	}

	return markup;
};

window.onload = initialize;
