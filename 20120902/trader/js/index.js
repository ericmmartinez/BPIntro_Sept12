function initialize (evt) {
	var ads = document.getElementsByClassName('advertisement');
	for (var i = 0, ad = null; ad = ads[i]; i++) {
		enhance(ad);
	}
}

function enhance (ad) {
	var closeBtn = document.createElement('span');
	closeBtn.className = 'closeBtn';
	closeBtn.title = 'Close';
	closeBtn.appendChild(document.createTextNode('X'));
	closeBtn.onclick = closeAd;

	ad.appendChild(closeBtn);
}

function closeAd (evt) {
	var ad = this.parentNode;
	ad.parentNode.removeChild(ad);
}

window.onload = initialize;
