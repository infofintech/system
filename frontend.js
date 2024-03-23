function ucfirst(str) {
    return (str[0].toUpperCase() + str.slice(1));
}
function flip(x) {
    return (1 - x);
}
function pad(num, size) {
    num = num.toString();
    while (num.length < size) num = "0" + num;
    return num;
}
function bin2hex(word) {
    var arr = []; for (i = 0; i < word.length; i++) {
        arr[i] = word.charCodeAt(i).toString(16);
    } return arr.join('');
}
function hex2bin(hex) {
    var bytes = []; for (i = 0; i < hex.length - 1; i += 2) {
        bytes.push(parseInt(hex.substr(i, 2), 16));
    } return String.fromCharCode.apply(String, bytes);
}
function htmlarr(str, y, x) {
    var arr = str.split(y); var text = '';
    for (i = 0; i < arr.length; i++) {
        text += arr[i].split(x)[0]+'<br>'+arr[i].split(x)[1]+'<br>';
    } return text;
}
function arraySearch(needle, haystack) {
    for (key in haystack) {
        if (haystack.hasOwnProperty(key)) {
            if ((haystack[key] == needle) && (key != needle)) {
                return key;
            }
        }
    } return false;
}
function rand(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
function isInt(num) {
    return (Number.isInteger(parseInt(num)));
}
function arrjob(str, y, x) {
    var arr = str.split(y); var arn = {};
    for (i = 0; i < arr.length; i++) {
        arf = arr[i].split(x);
        arn[arf[0]] = arf[1];
    } return arn;
}
function arrpack(arr, y, x) {
    var str = ''; for (var prop in arr) {
        str += prop+x+arr[prop]+y;
    } return str;
}
function arrvals(str, y, x) {
    var arr = str.split(y); var arn = {};
    for (i = 0; i < arr.length; i++) {
        arf = arr[i].split(x);
        arn[arf[0]] = arf[1];
    } return Object.values(arn);
}
function arrlens(str, y, x) {
    var arr = str.split(y); var arn = {};
    for (i = 0; i < arr.length; i++) {
        arf = arr[i].split(x);
        arn[arf[0]] = arf[1];
    } return Object.keys(arn).length;
}
function randomImage(list) {
    var arr = list.split(';'); var last = arr.length - 1;
    var randNum = Math.floor(Math.random() * last);
    return arr[randNum];
}
function nextImage(list, elem) {
    var arr = list.split(';'); var last = arr.length - 1;
    var index = arr.indexOf(elem); var num = 0;
    num = (index < last) ? (index + 1) : 0;
    return arr[num];
}
function miniPager(content, key) {
    return content.split(/\r?\n/)[key];
}
function pager(content, key) {
    return content.split(/\r\n\r\n/)[key];
}
function countChars(str) {
    return str.replace(/[\u0080-\u10FFFF]/g, "x").length;
}
function nlog(x, y) {
    return Math.round(Math.log(y) / Math.log(x));
}
function nrt(x, y) {
    return Math.round(Math.pow(y, 1/x));
}
