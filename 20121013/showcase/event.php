<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="ie ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en">         <!--<![endif]-->
<head>
	<?php
		$as_include_file = true;
		//
		// After this include we have
		// $eventid = net+code
		// $event = array(summary =>, products)
		// 
		include_once 'ajax/event.ajax.php';

		// Methods to help format things for the event
		include_once 'inc/format.event.php';

		if ($event == null || !isset($event['products']) ||
				count($event['products']) == 0) {
			// Indicates bad event
			print '<title>Unknown Event</title>';
		} else {
			print '<title>Event: ' . $eventid . '</title>';
		}
	?>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />

	<!-- CSS goes here -->
	<link rel="stylesheet" href="css1/event.css"/>

	<!--[if lt IE 9]><script src="/js/html5shiv.js"></script><![endif]-->
</head>
<body>
	<?php
		if ($event == null || !isset($event['products']) ||
				count($event['products']) == 0) {
			// Indicates bad event
			print '<title>Event not found.</title>';
		} else {
	?>
	<header>
		<?php print getEventHeader($event); ?>
	</header>

	<section class="impact">
		<?php print getEventImpact($event); ?>
	</section>

	<section class="commentary">
		<?php print getEventCommentary($event); ?>
	</section>

	<footer>
		<?php print getEventFooter($event); ?>
	</footer>


	<?php
			include_once 'inc/Mobile_Detect.php';
   		$detect = new Mobile_Detect();

   		if ($detect->isMobile()) {
      		print '<script src="js1/event.mobile.js"></script>';
   		}/** / else {
				print '<script src="js1/event.mobile.js"></script>';
   		}/**/
		} /* END: if ($event) */
	?>
</body>
</html>
