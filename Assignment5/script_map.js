var $ = function(id) {
  return document.getElementById(id);
}

var map;
pos = {lat: 44.974686, lng: -93.232074};
var markerArr = [];
var myLocation;
var directionsService;
var directionsDisplay;
var geocoder;

var initMap = function() {

  map = new google.maps.Map($("map"), {
    center: {lat: 44.974686, lng: -93.232074},
    zoom: 14,
  });

  directionsService = new google.maps.DirectionsService;
  directionsDisplay = new google.maps.DirectionsRenderer;
  geocoder = new google.maps.Geocoder;

  setupMarkers();
}

function setupMarkers() {
  var location = document.getElementsByClassName('location');
  var address;
  for(var i=0; i<location.length; i++) {
    address = location[i].textContent;
    geocoder.geocode({'address': address}, function(results, status) {
      if (status === 'OK') {
        createMarker(results[0]);
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }
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
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent("<h3>" + place.address_components[0].long_name + "</h3>" + place.formatted_address);
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

