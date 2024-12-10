function gettheDate() {
    var todays = new Date();
    
    var theDate = (todays.getMonth() + 1) + " / " + todays.getDate() + " / " + (todays.getFullYear());
    document.getElementById("data").innerHTML = theDate;
}

var timerId = null;
var timerRunning = false; 

function stopclock() {
    if (timerRunning) {
        clearTimeout(timerId);
    }
    timerRunning = false;
}

function startclock() {
    stopclock();
    gettheDate();
    showtime();
}

function showtime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    // Fixed variable name casing
    var timeValue = "" + ((hours > 12) ? hours - 12 : hours);
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes; 
    timeValue += ((seconds < 10) ? ":0" : ":") + seconds; 
    timeValue += ((hours >= 12) ? " PM" : " AM"); 
    document.getElementById("zegarek").innerHTML = timeValue;
    timerId = setTimeout(showtime, 1000);
    timerRunning = true;
}