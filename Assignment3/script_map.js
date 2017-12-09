var $ = function(id) {
  return document.getElementById(id);
}

var map;
pos = {lat: 44.974686, lng: -93.232074};
var markerArr = [];
var myLocation;
var directionsService;
var directionsDisplay;

var initMap = function() {

  map = new google.maps.Map($("map"), {
    center: {lat: 44.974686, lng: -93.232074},
    zoom: 14,
  });

  directionsService = new google.maps.DirectionsService;
  directionsDisplay = new google.maps.DirectionsRenderer;

  // Default places markers
  var keller = new google.maps.Marker({
    position: {lat: 44.97468429, lng: -93.23229439},
    animation: google.maps.Animation.BOUNCE,
    map: map,
  });
  keller.addListener("click", function() {
    var infowindow = new google.maps.InfoWindow({
      content: "<h3>Keller Hall</h3><p><b>CSCI 2041</b> 11:15 - 12:05 \
      <br><b>CSCI 4041</b> 17:45 - 18:35</p>",
    });
    infowindow.open(map, keller);
  });

  var anderson = new google.maps.Marker({
    position: {lat: 44.971984, lng: -93.24231999},
    animation: google.maps.Animation.BOUNCE,
    map: map,
  });
  anderson.addListener("click", function() {
    var infowindow = new google.maps.InfoWindow({
      content: "<h3>Anderson Hall</h3><p><b>CSCI 2021</b> 10:10 - 11:00</p>",
    });
    infowindow.open(map, anderson);
  });

  var fraser = new google.maps.Marker({
    position: {lat: 44.9756596, lng: -93.237381},
    animation: google.maps.Animation.BOUNCE,
    map: map,
  });
  fraser.addListener("click", function() {
    var infowindow = new google.maps.InfoWindow({
      content: "<h3>Fraser Hall</h3><p><b>CSCI 4131</b> 13:00 - 14:15</p>",
    });
    infowindow.open(map, fraser);
  });

  var cell = new google.maps.Marker({
    position: {lat:44.973038, lng: -93.232460599},
    animation: google.maps.Animation.BOUNCE,
    map: map,
  });
  cell.addListener("click", function() {
    var infowindow = new google.maps.InfoWindow({
      content: "<h3>Molecular and Cellular Biology</h3><p><b>CSCI 2041</b> 11:15 - 12:05</p>",
    });
    infowindow.open(map, cell);
  });

  var tate = new google.maps.Marker({
    position: {lat:44.9752886, lng: -93.234527},
    animation: google.maps.Animation.BOUNCE,
    map: map,
  });
  tate.addListener("click", function() {
    var infowindow = new google.maps.InfoWindow({
      content: "<h3>Tate Hall</h3><p><b>AST 1001</b> 09:45 - 11:00</p>",
    });
    infowindow.open(map, tate);
  });
  getCurrentLocation();
}

function getDirection() {
  clearPanel();
  directionsDisplay.setMap(map);
  directionsDisplay.setPanel($('navPanel'));

  navigation(myLocation, directionsService, directionsDisplay);
};


  // Nearby Restaurant
  function findNearbyRestaurant() {
    clearMarker();
    var radius = $('radius').value;
    var service = new google.maps.places.PlacesService(map);

    service.textSearch({
      location: pos,
      radius: radius,
      type: ['restaurant']
    }, callback);
  }

  function callback(results, status) {
    if (status === google.maps.places.PlacesServiceStatus.OK) {
      for (var i = 0; i < results.length; i++) {
        createMarker(results[i]);
      }
    }
  }

  // Google Maps Directions
  function navigation(currentLocation, directionsService, directionsDisplay) {

    var destination = $('destination').value;
    var radios = document.getElementsByName("vehicle");
    var vehicle = 'WALKING';
    for(var item of radios) {
      if(item.checked) {
        vehicle = item.value;
      }
    };

    directionsService.route({
          origin: currentLocation,
          destination: destination,
          travelMode: vehicle,
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });


  }

  // Get current location
  function getCurrentLocation() {
    var infoWindow = new google.maps.InfoWindow;
    if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            myLocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            map.setCenter(myLocation);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
      infoWindow.setPosition(pos);
      infoWindow.setContent(browserHasGeolocation ?
                            'Error: The Geolocation service failed.' :
                            'Error: Your browser doesn\'t support geolocation.');
      infoWindow.open(map);
    }





  function createMarker(place) {
        var infowindow = new google.maps.InfoWindow();
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent("<h3>" + place.name + "</h3>" + place.formatted_address);
          infowindow.open(map, this);
        });
        markerArr.push(marker);
  }

  function clearMarker() {
    for(var i=0; i<markerArr.length; i++) {
      markerArr[i].setMap(null);
    }
  }

  function clearPanel() {
    $('navPanel').style.display = "block";
    $('navPanel').innerHTML = '';
  }
