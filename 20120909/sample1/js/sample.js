var theImage = null;

var updateImage = function (evt) {
	if (!theImage) { getTheImage(); }
	
	var src = theImage.src;
	var width = 0;

	if (window.innerWidth) {
		width = window.innerWidth;
	} else if (document.documentElement
			&& document.documentElement.offsetWidth) {
		width = document.documentElement.offsetWidth;
	} else if (document.body && document.body.offsetWidth) {
		width = document.body.offsetWidth;
	}


	if (width >= 320 && src.indexOf('320') < 0) {
		// Screen is wide enough, but image does not reference larger version
		theImage.src = 'images/beethoven-320.jpg';
	} else if (src.indexOf('120') < 0) {
		// Small screen is using large image. Reset.
		theImage.src = 'images/beethoven-120.jpg';
	}
};

// Not universal or clean, but the markup is well-known.
var getTheImage = function () {
	var wrapper = document.getElementById('imgwrapper1');
	theImage = wrapper.childNodes[0];
};

window.onload = updateImage;
window.onresize = updateImage;
