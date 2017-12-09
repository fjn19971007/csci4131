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


var loadImage = function() {
    var image = $('image');
    var td = document.getElementsByTagName('td');
    for(var item of td) {
        item.onclick = function() {
            if(this.className === 'anderson') {
                image.src = 'images/anderson.jpg';
            }
            else if(this.className === 'fraser') {
                image.src = 'images/fraser.jpg';
            }
            else if(this.className === 'keller') {
                image.src = 'images/keller.jpg';
            }
            else if(this.className === 'molecular') {
                image.src = 'images/molecular.jpg';
            }
            else if(this.className === 'tate') {
                image.src = 'images/tate.jpg';
            }
            else {
              image.src = 'images/gopher.png';
            }
        }
    }
}


window.onload = function() {
    eventToday();
    loadImage();
}
