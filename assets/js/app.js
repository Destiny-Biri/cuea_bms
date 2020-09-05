$(document).foundation();
var travelDate;
var startPoint;
var endPoint;

window.onload = init();

function init() {
	travelDate = document.getElementById("txt_dateOfTravel").value;
	startPoint = document.getElementById("sel_source").value;
	endPoint = document.getElementById("sel_destination").value;
	showAvailableTrips();
}

function updateSelection() {
	var selectedSeat = document.getElementById("sel_selectedSeat");
	console.log(selectedSeat.length);
	if (selectedSeat.length > 0) {
		// Show the summary div
		var elem = document.querySelector('#orderSummary');
		elem.style.display = 'none';

	} else {
		//hide the summary div
		var elem = document.querySelector('#orderSummary');
		elem.style.display = 'none';
	}
}


function updateTravelDate(val) {
	travelDate = val;
	showAvailableTrips();
}

function updateStartPoint(val) {
	startPoint = val;
	showAvailableTrips();
}

function updateStopPoint(val) {
	endPoint = val;
	showAvailableTrips();
}

function fetchAvailableSeats(val) {
	var journeyId = val;
	// var journeyId = document.getElementById("rad_journeySelect").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("availableSeats").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", "getSeats.php?journeyId=" + journeyId, true);
	xmlhttp.send();
}

function showAvailableTrips() {
	if (startPoint == endPoint) {
		var elem = document.querySelector('#availableOptions');
		elem.style.display = 'block';
		// e.innerHTML = "You cant do this."
		document.getElementById("availableOptions").innerHTML = "You cant go there!";
	} else {
		// document.getElementById("availableOptions").innerHTML = "";
		var elem = document.querySelector('#availableOptions');
		elem.style.display = 'none';
	}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) {
			document.getElementById("suggested").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", "getJourney.php?dot=" + travelDate + "&sp=" + startPoint + "&dp=" + endPoint, true);
	xmlhttp.send();
}