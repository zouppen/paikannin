<?php
require_once 'polyline.php';

define('debug', 0);
function debug() {
	if (!debug)
		return;
	
	$args = func_get_args();
	echo implode(' , ', $args);
	echo '<br/>';
}

$points = array(

	// point
	array(
		// lat
		49.75121628642191,
		
		// lng
		6.6281890869140625
	),
	
	array(
		49.76252796566851,
		6.633853912353516
	),
	
	array(
		49.757537844205025,
		6.649990081787109
	),
	
	array(
		49.749441665946,
		6.642951965332031
	)
);

echo '<pre>';
$P = new Polyline($points);
echo $P->encode();
echo '</pre>';