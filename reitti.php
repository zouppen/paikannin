<?php

ini_set('display_errors', '1');
require_once 'polyline/polyline.php';

$old = unserialize(file_get_contents("sessio.txt"));

$lat=floatval($_GET['lat']);
$lon=floatval($_GET['lon']);
$alt=floatval($_GET['alt']);

// f*cking poor object-oriented design
$P = new Polyline();
$polypoint=$P->encodeOne($old[0],$old[1],$lat,$lon);  

//print ($polypoint);

$out = fopen("polyline.txt","a");
fwrite($out,$polypoint);
fclose($out);

$out = fopen("polylevels.txt","a");
fwrite($out,'B'); // FIXME some day
fclose($out);

$out = fopen("selko.txt","a");
fwrite($out, $lat." ".$lon."\n" );
fclose($out);

$out = fopen("altitude.txt","a");
fwrite($out,date('c').' '.$alt."\n");
fclose($out);

echo "ok";

$new=array($lat,$lon);
file_put_contents("sessio.txt",serialize($new));
?>
