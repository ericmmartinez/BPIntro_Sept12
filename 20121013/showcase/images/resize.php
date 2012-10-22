<?php
	$width = intval($_GET['width']);
	$url = urldecode($_GET['url']);
	$image = null;

	if (substr($url, -3) == 'png') {
		$image = imagecreatefrompng($url);
	} else if (substr($url, -3) == 'gif') {
		$image = imagecreatefromgif($url);
	} else if (substr($url, -3) == 'jpg' || substr($url, -4) == 'jpeg') {
		$image = imagecreatefromjpeg($url);
	}


	if ($image != null) {
		$img_width = imagesx($image);
		$img_height = imagesy($image);

		$dst_width = $width;
		$dst_height = $img_height * ($dst_width / $img_width);
		$dst = imagecreatetruecolor($dst_width, $dst_height);

		imagecopyresampled($dst, $image, 0, 0, 0, 0, $dst_width, $dst_height,
			$img_width, $img_height);

		header('Content-Type: image/jpeg');
		imagejpeg($dst);
	}
?>
