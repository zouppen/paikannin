// I have adapted this script from Pamela Fox: http://imagine-it.org/google/polyline.js

doDebug = 1;

function debug() {
	if (!doDebug)
		return;
	
	if (console)
		console.log(arguments);
}

// Encode a signed number in the encode format.
function encodeSignedNumber(num) {
	
debug('encodeSignedNumber()', num);
	
  var sgn_num = num << 1;

  if (num < 0) {
    sgn_num = ~(sgn_num);
  }
  
debug('	result', sgn_num);

  return(encodeNumber(sgn_num));
}

// Encode an unsigned number in the encode format.
function encodeNumber(num) {
	
debug('encodeNumber()', num);
	
  var encodeString = "";

  while (num >= 0x20) {
    encodeString += (String.fromCharCode((0x20 | (num & 0x1f)) + 63));
    num >>= 5;
  }

  encodeString += (String.fromCharCode(num + 63));
  
 debug('	result', encodeString);
  
  return encodeString;
}

// Create the encoded polyline and level strings. If moveMap is true
// move the map to the location of the first point in the polyline.
function encodePolyline(points) {
	
debug('encodePolyline()', points);

  var plat = 0;
  var plng = 0;

  var encoded_points = "";
  var encoded_levels = "";

  for(var i = 0; i < points.length; ++i) {
    var point = points[i];
    var lat = point.Latitude;
    var lng = point.Longitude;
    //var level = point.Level;

    var late5 = Math.floor(lat * 1e5);
    var lnge5 = Math.floor(lng * 1e5);

    dlat = late5 - plat;
    dlng = lnge5 - plng;

    plat = late5;
    plng = lnge5;

    encoded_points += encodeSignedNumber(dlat) + encodeSignedNumber(dlng);
    //encoded_levels += encodeNumber(level);
  }
  
  debug('	result', encoded_points);
  
  return encoded_points;
}