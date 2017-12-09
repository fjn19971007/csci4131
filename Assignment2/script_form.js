var $ = function(id) {
  return document.getElementById(id);
}

var errorMessage = $('errorMessage');

var validateForm = function() {

  var errorMessage = $('errorMessage');
  var eventName = $('eventName').value;
  var location = $('location').value;
  var pattern = /^[0-9a-zA-Z]{1,19}$/;

  if(!(pattern.test(eventName) && pattern.test(location))) {
      errorMessage.style.display = "block";
      return false;
  }
}

var errorButton = function() {
  var errorMessage = $('errorMessage');
  errorMessage.style.display = 'none';
  $('form').reset();
}
