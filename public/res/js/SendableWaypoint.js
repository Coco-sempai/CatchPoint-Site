class SendableWaypoint {

    /*constructor(name, lat, lng, index) {
        this.name = name;
        this.hint = "";
        this.lat = lat;
        this.lng = lng;
        this.index = index;
    }*/

    constructor(waypoint) {
        this.name = waypoint.name;
        this.hint = waypoint.hint;
        this.lat = waypoint.getCoordinates().lat;
        this.lng = waypoint.getCoordinates().lng;
        //this.index = index;
    }


}