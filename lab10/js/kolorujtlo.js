var computed = false;
var decimal = 0;

function convert(entryform, from, to) {
    var convertfrom = from.selectedIndex;
    var convertto = to.selectedIndex;
    
    
    var inputValue = parseFloat(entryform.input.value);
    if (!isNaN(inputValue)) {
        entryform.display.value = (inputValue * from[convertfrom].value / to[convertto].value).toFixed(2); // 
    } else {
        entryform.display.value = "Invalid Input"; 
    }
}

function addChar(input, character) {
    if ((character == '.' && decimal == 0) || character != '.') {
        input.value = (input.value == "" || input.value == "0") ? character : input.value + character;
        convert(input.form, input.form.measure1, input.form.measure2);
        computed = true;
        if (character == '.') {
            decimal = 1;
        }
    }
}

function openvothcom() {
    window.open("", "Display window", "toolbar=no,directories=no,menubar=no");
}

function clear(form) {
    form.input.value = 0;
    form.display.value = 0;
    decimal = 0;
}

function changeBackground(hexnumber) {
    document.body.style.backgroundColor = hexnumber; 
}