const params = new URLSearchParams(location.search);
let position = "";
let map;
let service;
let infowindow;
let marker;
let address;
const currentAddress = document.querySelector(".map-item-detail-address p");
const defaultLocation = "16.432089757827352,102.82368338565885";
const popup = document.querySelector(".map-item-detail");
const maximum_radius = document.querySelector(".maximum").getAttribute('data-maximum');
const branch_location = localStorage.getItem("branch_location") || defaultLocation;

function initMap() {
    let isGetCurrent = false;
    if (params.get("type") === "pickup") {
        position = localStorage.getItem("pickup");
    } else if (params.get("type") === "drop") {
        position = localStorage.getItem("drop");
    } else {
        // get default location from database
        position = branch_location;
        isGetCurrent = true;
    }
    position = position ? position : branch_location;
    infowindow = new google.maps.InfoWindow();
    var currentLatlng = new google.maps.LatLng(
        parseFloat(position?.split(",")[0]),
        parseFloat(position?.split(",")[1])
    );
    var branchLatlng = new google.maps.LatLng(
        parseFloat(branch_location?.split(",")[0]),
        parseFloat(branch_location?.split(",")[1])
    );
    position = currentLatlng.lat() + "," + currentLatlng.lng();
    var mapOptions = {
        zoom: 15,
        center: currentLatlng,
    };
    map = new google.maps.Map(
        document.getElementById("map-google"),
        mapOptions
    );

    const branchCircle = new google.maps.Circle({
        strokeColor: "#EDFEA2",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#EDFEA2",
        fillOpacity: 0.35,
        map,
        center: branchLatlng,
        radius: maximum_radius * 1000,
    });

    placeService = new google.maps.places.PlacesService(map);

    // Place a draggable marker on the map
    marker = new google.maps.Marker({
        position: currentLatlng,
        map: map,
        draggable: true,
    });

    if (isGetCurrent) {
        getLocation(map);
    }

    google.maps.event.addListener(marker, "dragend", function (event) {
        position = event.latLng.lat() + "," + event.latLng.lng();
        map.setCenter(event.latLng);
        // findNearby(event.latLng);

        setTimeout(function () {
            popup.style.display = "flex";
            closePopup.style.display = "flex";
            currentLocation.style.display = "flex";
        }, 100);

        const geocoder = new google.maps.Geocoder();
        geocoder.geocode(
            { location: event.latLng },
            function (results, status) {
                if (status === "OK" && params.get("type") === "pickup") {
                    localStorage.setItem(
                        "pickup_address",
                        results[0].formatted_address
                    );
                    address = results[0].formatted_address;
                    currentAddress.innerText = results[0].formatted_address;
                } else if (status === "OK" && params.get("type") === "drop") {
                    localStorage.setItem(
                        "drop_address",
                        results[0].formatted_address
                    );
                    address = results[0].formatted_address;
                    currentAddress.innerText = results[0].formatted_address;
                } else {
                    console.error("Geocoder failed due to: " + status);
                }
            }
        );
    });
    google.maps.event.addListener(map, "click", function (event) {
        placeMarker(event.latLng);
        position = event.latLng.lat() + "," + event.latLng.lng();
        map.setCenter(event.latLng);
        // findNearby(event.latLng);

        setTimeout(function () {
            popup.style.display = "flex";
            closePopup.style.display = "flex";
            currentLocation.style.display = "flex";
        }, 100);

        const geocoder = new google.maps.Geocoder();
        geocoder.geocode(
            { location: event.latLng },
            function (results, status) {
                if (status === "OK" && params.get("type") === "pickup") {
                    localStorage.setItem(
                        "pickup_address",
                        results[0].formatted_address
                    );
                    address = results[0].formatted_address;
                    currentAddress.innerText = results[0].formatted_address;
                } else if (status === "OK" && params.get("type") === "drop") {
                    localStorage.setItem(
                        "drop_address",
                        results[0].formatted_address
                    );
                    address = results[0].formatted_address;
                    currentAddress.innerText = results[0].formatted_address;
                } else {
                    console.error("Geocoder failed due to: " + status);
                }
            }
        );
    });
}

function placeMarker(location) {
    marker.setPosition(location);
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                const latlng = new google.maps.LatLng(lat, lng);
                marker.setPosition(latlng);
                findNearby(latlng);
                map.setCenter(latlng);
            },
            (failure) => {
                console.log(failure);
            }
        );
    } else {
        alert("Geolocation is not supported by this browser.");
        return false;
    }
}

function searchPlace(search) {
    const request = {
        query: search,
        fields: ["name", "geometry"],
        language: "en",
    };
    placeService.findPlaceFromQuery(request, (results, status) => {
        if (status === google.maps.places.PlacesServiceStatus.OK && results) {
            const currentPosition = results[0].geometry.location;
            position = currentPosition.lat() + "," + currentPosition.lng();
            marker.setPosition(currentPosition);
            map.setCenter(currentPosition);
            map.setZoom(17);
            // findNearby(currentPosition);

            setTimeout(function () {
                popup.style.display = "flex";
                closePopup.style.display = "flex";
                currentLocation.style.display = "flex";
            }, 100);

            const geocoder = new google.maps.Geocoder();
            geocoder.geocode(
                { location: currentPosition },
                function (results, status) {
                    if (status === "OK" && params.get("type") === "pickup") {
                        localStorage.setItem(
                            "pickup_address",
                            results[0].formatted_address
                        );
                        address = results[0].formatted_address;
                        currentAddress.innerText = results[0].formatted_address;
                    } else if (
                        status === "OK" &&
                        params.get("type") === "drop"
                    ) {
                        localStorage.setItem(
                            "drop_address",
                            results[0].formatted_address
                        );
                        address = results[0].formatted_address;
                        currentAddress.innerText = results[0].formatted_address;
                    } else {
                        console.error("Geocoder failed due to: " + status);
                    }
                }
            );
        }
    });
}

function findNearby(location) {
    var request = {
        location: location,
        fields: ["name", "geometry", "business_status"],
        radius: "500",
    };
    placeService.nearbySearch(request, (results, status) => {
        if (status === google.maps.places.PlacesServiceStatus.OK && results) {
            address = results[1].vicinity;
        }
    });
}

let search_input = document.querySelector("#input_search");
if (search_input) {
    search_input.addEventListener("keyup", (e) => {
        if (e.key === "Enter" || e.keyCode === 13) {
            searchPlace(search_input.value);
        }
    });
}

function handlerConfirm() {
    localStorage.setItem(params.get("type"), position);
    localStorage.setItem(params.get("type") + "_address", address);
    location.href = `/${params.get("page")}`;
}

window.initMap = initMap;

const closePopup = document.querySelector(".map-item-close");

closePopup.addEventListener("click", () => {
    closePopup.style.display = "none";
    popup.style.display = "none";
    currentLocation.style.display = "none";
});

const currentLocation = document.querySelector(".map-item-location");

currentLocation.addEventListener("click", () => {
    getLocation();
});
