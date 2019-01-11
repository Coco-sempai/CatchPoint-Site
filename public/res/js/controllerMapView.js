
var waypoints = [];

var lat = 46.22475;
var lon = 2.6669343;
var zoom = 4;


var map = null;

var selectedWaypoint = null;

var markersTable;
var mapSideBarTitle;
var waypointLatField;
var waypointLongField;
var waypointNameField;
var waypointHintField;
var waypointsInput;

var currentWaypointNumber = 0;

var pinIcon;

function initLocation() {
    if (navigator.geolocation) {
        var loc = navigator.geolocation.getCurrentPosition(init, init)
    }
}

function init(loc) {

    if (loc.coords != undefined) {
        lat = loc.coords.latitude;
        lon = loc.coords.longitude;
        zoom = 15;
    }






    markersTable = document.getElementById("markersTable");
    mapSideBarTitle = document.getElementById("mapSideBarTitle");
    waypointLatField = document.getElementById("waypointLatField");
    waypointLongField = document.getElementById("waypointLongField");
    waypointNameField = document.getElementById("waypointNameField");
    waypointHintField = document.getElementById("waypointHintField");

    waypointsInput = document.getElementById("waypointsInput");

    map = window.L.map('map').setView([lat, lon], zoom);

    pinIcon = L.Icon.extend({
        options: {
            shadowUrl: '',
            iconSize:     [35, 35],
            shadowSize:   [0, 0],
            iconAnchor:   [17, 40],
            shadowAnchor: [4, 62],
            popupAnchor:  [0, -45]
        }
    });

    // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        // Il est toujours bien de laisser le lien vers la source des données
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 1,
        maxZoom: 20

    }).addTo(map);

    json_waypoints = JSON.parse(json_waypoints);

    for (let i = 0; i < json_waypoints.length; i++) {

        let json_waypoint = json_waypoints[i];

        let newLatLng = [json_waypoint.lat, json_waypoint.lng];

        let newMarker = L.marker(newLatLng, {icon: new pinIcon({iconUrl: path + '/webmap/pins/pin.png'})}).addTo(map);

        let newWaypoint = new Waypoint(json_waypoint.name, newMarker);
        newWaypoint.hint = json_waypoint.hint;

        waypoints.push(newWaypoint);
    }

    updateTitle();
    updateLines();
    updateMarkersList();
}

var popup = L.popup();

function getNewMarkerName() {
    currentWaypointNumber += 1;
    return "Point " + (currentWaypointNumber)
}

function updateMarkersList() {

    /* Clear the table */
    var tableHeaderRowCount = 0;
    var rowCount = markersTable.rows.length;
    for (var i = tableHeaderRowCount; i < rowCount; i++) {
        markersTable.deleteRow(tableHeaderRowCount);
    }

    waypoints.forEach(function(waypoint) {
        var newRow = markersTable.insertRow(0);
        var newCell = newRow.insertCell(0);
        newCell.innerHTML = waypoint.name;
        newRow.onclick = function() {
            selectedWaypoint = waypoint;
            updateWaypointDetails();
            focusOnWaypoint(waypoint)
        }
    })
}

function focusOnWaypoint(wp) { map.flyTo(wp.getCoordinates(), 16) }

function updateLines() {

    for (var i = 0; i < polylines.length ; i++) { polylines[i].remove() }
    polylines = Array();

    if (waypoints.length <= 1) { return }

    for (var i = 0; i < (waypoints.length - 1); i++) {

        drawLine(waypoints[i], waypoints[i+1]);
    }

    for (var i = 0; i < waypoints.length ; i++) {
        waypoints[i].marker.setIcon(new pinIcon({iconUrl: path + '/webmap/pins/pin.png'}));
    }

    waypoints[0].marker.setIcon(new pinIcon({iconUrl: path + '/webmap/pins/pin_start.png'}));
    waypoints[waypoints.length-1].marker.setIcon(new pinIcon({iconUrl: path + '/webmap/pins/pin_finish.png'}));

}

function updateTitle() { mapSideBarTitle.innerHTML = waypoints.length + " Points" }

var polylines = new Array();
var polyline;
function drawLine(p1, p2) {

    var latlngs = Array();

    latlngs.push(p1.getCoordinates());
    latlngs.push(p2.getCoordinates());

    polyline = L.polyline(latlngs, {color: 'blue'}).addTo(map);
    polylines.push(polyline)
}

function updateWaypointDetails() {

    if (selectedWaypoint == null) {
        waypointLatField.innerHTML = "";
        waypointLongField.innerHTML = "";
        waypointNameField.innerHTML = "";
        waypointHintField.innerHTML = "";
    } else {
        waypointLatField.innerHTML = selectedWaypoint.getCoordinates().lat;
        waypointLongField.innerHTML = selectedWaypoint.getCoordinates().lng;
        waypointNameField.innerHTML = selectedWaypoint.name;
        waypointHintField.innerHTML = selectedWaypoint.hint;
    }
}



window.onload = function() { initLocation() };
