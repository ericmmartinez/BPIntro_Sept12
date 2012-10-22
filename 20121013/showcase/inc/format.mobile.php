<?php

include_once 'functions.inc.php';

/**
 * @return {String}
 *     The markup for an event item. This includes the enclosing list-item tags.
 */
function getEventItem ($event) {

	$item = getOpeningTag($event);
	$item .= getItemContents($event);
	$item .= getClosingTag($event);

	return $item;
}

/**
 * @return {String}
 *      The opening tag for this event item.
 */
function getOpeningTag ($event) {
	return '<li id="event-' . $event['net'] . $event['code'] .
			'" class="' . getClasses($event) . '">';
}

/**
 * @return {String}
 *      The closing tag for this event item. Should match the opening tag from
 *      getOpeningTag method.
 */
function getClosingTag ($event) {
	return '</li>';
}

function getItemContents ($event) {

	$content = '<div class="quantity">';
	$content .= '<div class="magnitude"><span>' .
			number_format($event['mag'], 1) . '</span></div>';
	//$content .= '<div class="reported">' . getFeltInt($event) . '</div>';
	//$content .= '<div class="instrumental">' . getFeltInt($event) . '</div>';
	//$content .= '<div class="alertlevel">' . getFeltInt($event) . '</div>';
	$content .= '</div>';

	$content .=  '<div class="location">';
	$content .= '<a class="region" href="' . $event['url'] . '">' .
			$event['place'] . '</a>';
	$content .= '<span class="time">' . getTime($event) . '</span>';
	$content .= '<span class="coords">' . getCoords($event, true) . '</span>';
	$content .= '</div>';

	return $content;
}
