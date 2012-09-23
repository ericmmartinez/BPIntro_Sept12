var initialize = function (evt) {
	var el = document.documentElement,
	    classes = el.className,
	    newClasses = classes.replace('no-js', 'js'),
	    navigationButton = document.getElementById('navigation-button'),
	    content = document.getElementById('main'),
	    sidebarButton = document.getElementById('sidebar-button'),
	    fragment = window.location.hash;

	// Update className on documentElement so we know JS is enabled
	el.className = newClasses;

	// Add handlers to page navigation
	navigationButton.onclick = onNavClick;
	content.onclick = onContentClick;
	sidebarButton.onclick = onSidebarClick;

	if (fragment === '#navigation') {
		onNavClick(null);
	} else if (fragment === '#sidebar') {
		onSidebarClick(null);
	}
};

var onNavClick = function (evt) {
	setActive('active-nav');
	return false;
};

var onContentClick = function (evt) {
	setActive('active-content');
	return false;
};

var onSidebarClick = function (evt) {
	setActive('active-sidebar');
	return false;
};

var setActive = function (context) {
	var el = document.documentElement,
	    classes = el.className.split(' '),
		 currentContext = null,
		 newClasses = [];

	for (var i = 0, cls = null; cls = classes[i]; i++) {
		if (cls.indexOf('active-') < 0) {
			newClasses.push(cls);
		} else {
			currentContext = cls;
		}
	}

	if (!currentContext || currentContext !== context) {
		newClasses.push(context);
	}

	el.className = newClasses.join(' ');
};

window.onload = initialize;
