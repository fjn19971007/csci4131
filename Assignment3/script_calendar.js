// getElementById function
var $ = function (id) {
    return document.getElementById(id);
}

var getToday = function() {
    var now = new Date();
    return now.getDay();
}

var eventToday = function() {
    var scrollText = $('scrollText');
    var day = getToday();
    var event;
    var output = 'Event for the Day: ';

    if(day === 1) {
        event = $('monday');
    }
    else if(day === 2) {
        event = $('tuesday');
    }
    else if(day === 3) {
        event = $('wednesday');
    }
    else if(day === 4) {
        event = $('thursday');
    }
    else if(day === 5) {
        event = $('friday');
    }
    else {
        return ;
    }

    var eventArray = event.getElementsByTagName('p');

    for(var item of eventArray) {
        var text = item.innerText;
        text = text.replace(/\n/g,'');
        output += '"'
        output += text;
        output += '" ; ' ;
    }
    scrollText.innerText = output;
}





window.onload = function() {
    eventToday();
}
