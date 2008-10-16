// reitti-script for getting and drawing prior route

var lastOverlay = null;

var routeTemplate = {
	color: "#3333cc",
	weight: 10,
	//points: null,
	//levels: null,
	zoomFactor: 32,
	numLevels: 4
}

function addRoute(line) {
	routeTemplate.points=line;
	fixPolyline();
}

function fixPolyline() {
	// piirtää monesti
	var encodedPolyline = new GPolyline.fromEncoded(routeTemplate);
	map.addOverlay(encodedPolyline);
	if (lastOverlay != null) map.removeOverlay(lastOverlay);
	lastOverlay = encodedPolyline;
}

function addLevels(line) {
	routeTemplate.levels=line;
	fixPolyline();
}

// hard-wired to 4 levels
// very ugly, coding like engineers do
function levelGenerator(ln, count) {
	var eka=0, toka=0, kolmas=0;
	var jono="";

	count=count-1; // endpoint and startpoint

	for (var i=0;i<count;i++) {

		if (kolmas==0) {
			eka=ln;
			toka=ln*ln;
			kolmas=ln*ln*ln;
			jono=jono+'B';
		} else if (toka==0) {
			eka=ln;
			toka=ln*ln;
			jono=jono+'A';
		} else if (eka==0) {
			eka=ln;
			jono=jono+'@';
		} else {
			jono=jono+'?';
		}
		
		eka--;
		toka--;
		kolmas--;
	}
	
	return jono+'B';
}

function getRouteAsync() {
	asyncLoad('jatkuva-polyline.php',addRoute)
	asyncLoad('jatkuva-levels.php',addLevels)
}

function asyncLoad(url, callback) {
	var req = new XMLHttpRequest();
	req.open('GET', url, true); 
	/* 3rd argument, true, marks this as async */
	
	req.onreadystatechange = function (aEvt) {
//		if (req.readyState == 4) alert("tiedosto "+url+" päättyi");
		// if loading or ready
		if (req.readyState == 4 || req.readyState == 3) {
			if(req.status == 200)
				callback(req.responseText);
			else
				alert("Virhe ladattaessa reittiä");
		}
	};
	req.send(null); 
}

    function load() {
      if (GBrowserIsCompatible()) {
	//document.getElementById("map").height = window.innerHeight;
        map = new GMap2(document.getElementById("map"));
        map.setCenter(new GLatLng(62.24163,25.75161), 13);

        var point = new GLatLng(62.231975,25.736439);
        map.addOverlay(new GMarker(point));
        map.addControl(new GLargeMapControl());
        getRouteAsync();

      }
    }

