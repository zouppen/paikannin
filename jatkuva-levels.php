<?php
ini_set('display_errors', '1');

$file = fopen("polylevels.txt","r");

while (true) {
//	if (!feof($file)) {
		fpassthru($file);
		ob_flush();
		flush();
//	}
	sleep(1);
}

fclose($file);
?>
