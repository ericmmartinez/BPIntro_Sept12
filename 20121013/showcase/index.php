<?php
	session_start();
	include_once 'inc/Mobile_Detect.php';

	if (isset($_GET['view'])) {
		if ($_GET['view'] == 'default') {
			unset($_SESSION['view']);
		} else {
			$_SESSION['view'] = $_GET['view'];
		}
	}

	// User preference

	if (isset($_SESSION['view'])) {
		$view = $_SESSION['view'];

		if ($view == 'desktop') {
			include_once 'desktop.php';
			exit(0); // Exit to prevent default
		} else if ($view == 'mobile') {
			include_once 'mobile.php';
			exit(0); // Exit to prevent default
		}
		
	}

	// Default. Detect device.

	$detect = new Mobile_Detect();

	if ($detect->isMobile()) {
		include_once 'mobile.php';
	} else {
		include_once 'desktop.php';
	}
?>
