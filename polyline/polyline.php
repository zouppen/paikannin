<?php
// Miguel Perez
// This is my implementation of unichr() - chr() adapted for unicode
function unichr($c) {
    if ($c <= 0x7F) {
        return chr($c);
    } else if ($c <= 0x7FF) {
        return chr(0xC0 | $c >> 6) . chr(0x80 | $c & 0x3F);
    } else if ($c <= 0xFFFF) {
        return chr(0xE0 | $c >> 12) . chr(0x80 | $c >> 6 & 0x3F)
                                    . chr(0x80 | $c & 0x3F);
    } else if ($c <= 0x10FFFF) {
        return chr(0xF0 | $c >> 18) . chr(0x80 | $c >> 12 & 0x3F)
                                    . chr(0x80 | $c >> 6 & 0x3F)
                                    . chr(0x80 | $c & 0x3F);
    } else {
        return false;
    }
}

function debug() {}

// Polyline class (beta), by Andreas Kalsch
// license: GPL
class Polyline {
	
	function __construct() {
	}
	
	protected $points;
	
	function getPoints() {
		
		return $this->points;
	}
	
	function encode($ppoint) {
		
		debug('encode()');

		// Zouppen was here
		$plat = $ppoint[0];
		$plng = $ppoint[1];
		
		$encoded_points = '';
		$encoded_levels = '';
		
		for ($i = 0; $i < count($this->points); ++$i) {
			
			$point = $this->points[$i];
			$lat = $point[0];
			$lng = $point[1];
			// $level = ... 
			
			debug('	lat', $lat);
			debug('	lng', $lng);
			
			$late5 = floor($lat * 1e5);
			$lnge5 = floor($lng * 1e5);
		
			debug('	lat5', $late5);
			debug('	lng5', $lnge5);
			
			$dlat = $late5 - $plat;
			$dlng = $lnge5 - $plng;

			print($dlat);

			
			$plat = $late5;
			$plng = $lnge5;
			
			$encoded_points .= self::encodeSignedNumber($dlat).self::encodeSignedNumber($dlng);
			//$encoded_levels += $encodeNumber(level);
		}
		
		debug('	result', $encoded_points);
		
		return $encoded_points;
	}

	function encodeOne($plat,$plng,$lat,$lng) {
		
		$late5 = floor($lat * 1e5);
		$lnge5 = floor($lng * 1e5);

		$plate5 = floor($plat * 1e5);
		$plnge5 = floor($plng * 1e5);
	
		$dlat = $late5 - $plate5;
		$dlng = $lnge5 - $plnge5;

		return self::encodeSignedNumber($dlat).self::encodeSignedNumber($dlng);
	}
		
	
		// Encode a signed number in the encode format.
	protected static function encodeSignedNumber($number) {
	
		debug('encodeSignedNumber()', $number);
		
		$signedNumber = $number << 1;
		
		if ($number < 0) {
		
			$signedNumber = ~($signedNumber);
		}
		
		debug('	result', $signedNumber);
	
		return self::encodeNumber($signedNumber);
	}

	// Encode an unsigned number in the encode format.
	protected static function encodeNumber($number) {
	
		debug('encodeNumber()', $number);
		
		$encodeString = '';
		
		while ($number >= 0x20) {
			
			$encodeString .= (unichr((0x20 | ($number & 0x1f)) + 63));
			$number >>= 5;
		}
		
		$encodeString .= (unichr($number + 63));
		
		debug('	result', $encodeString);
		
		return $encodeString;
	}
}
