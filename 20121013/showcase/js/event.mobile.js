var IMAGE_WIDTH = 300;

var initialize = function (evt) {
	if (document.getElementsByClassName) {
		var imagelinks = document.getElementsByClassName('imagelink');

		for (var i = 0, imagelink = null;  imagelink = imagelinks[i]; i++) {
			imagelink.onclick = onLinkClicked;
		}
	}
}

var onLinkClicked = function (click_event) {
	var relatedImage = this.relatedImage;

	if (!relatedImage) {
		this.relatedImage = relatedImage = createRelatedImage(this);
	}

	// Toggle display

	if (relatedImage.style.display == 'none') {
		relatedImage.style.display = 'block';
	} else {
		relatedImage.style.display = 'none';
	}
	
	if (click_event.preventDefault) {
		click_event.preventDefault();
	}

	return false;
};

var createRelatedImage = function (link) {
	var img = document.createElement('img');
	img.style.display = 'none';
	img.className = 'imagetarget';
	img.width = '' + IMAGE_WIDTH;
	img.src = 'images/resize.php?width=' + IMAGE_WIDTH + 
			'&url=' + encodeURIComponent(link.getAttribute('href'));
	
	link.parentNode.appendChild(img);
	return img;
};

window.onload = initialize;
