class Waypoint {

    constructor(name, marker) {
        this.name = name;
        this.hint = "";
        this.marker = marker;
    }

    getCoordinates() { return this.marker._latlng }
}