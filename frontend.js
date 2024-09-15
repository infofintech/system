function ucfirst(str) {
    return (str[0].toUpperCase()+str.slice(1));
}
function flip(x) {
    return ((x > 1) || (x < 0)) ? 0 : (1 - x);
}
function jsexpr(source) {
    source = source.replace("^","**");
    source = source.replace("[","");
    source = source.replace("]","");
    return source;
}
function calc(expr) {
    var res = '', prep, prec, arr = [], rer = [], sol, vars, reg, solt = [];
    nerdamer.set('SOLUTIONS_AS_OBJECT', true);
    reg = /\b(?:([a-z])(?!\w))+\b/gi;
    if (expr.includes(';')) {
        prep = expr.split(';');
        for (ib in prep) {
            if (prep[ib].includes(',')) {
                prec = prep[ib].split(',');
                for (ic in prec) {
                    if (prep[ib].match(reg) !== null) {
                        vars = finarr(prep[ib].match(reg));
                        for (vr in vars) {
                            sol = nerdamer.solve(prec[ic], vars[vr]).toString();
                            if (sol.includes(',')) {
                                solt = sol.split(',');
                                for (io in solt) {
                                    arr.push(vars[vr]+'='+jsexpr(solt[io]));
                                }
                            } else {
                                arr.push(vars[vr]+'='+jsexpr(sol));
                            }
                        } rer.push(finarr(arr).filter(item => (item.split('=')[1] != '')).filter(item => !(item.includes('i'))).join(','));
                    }
                }
            } else {
                if (prep[ib].match(reg) !== null) {
                    vars = finarr(prep[ib].match(reg));
                    for (vr in vars) {
                        sol = nerdamer.solve(prep[ib], vars[vr]).toString();
                        if (sol.includes(',')) {
                            solt = sol.split(',');
                            for (io in solt) {
                                arr.push(vars[vr]+'='+jsexpr(solt[io]));
                            }
                        } else {
                            arr.push(vars[vr]+'='+jsexpr(sol));
                        }
                    } rer.push(finarr(arr).filter(item => (item.split('=')[1] != '')).filter(item => !(item.includes('i'))).join(','));
                } else {
                    with(Math) {
                        rer.push(eval(prep[ib]));
                    }
                }
            }
        } res = finarr(rer).join(';');
    } else {
        if (expr.includes(',')) {
            prec = expr.split(',');
            for (ic in prec) {
                if (expr.match(reg) !== null) {
                    vars = finarr(expr.match(reg));
                    for (vr in vars) {
                        sol = nerdamer.solve(prec[ic], vars[vr]).toString();
                        if (sol.includes(',')) {
                            solt = sol.split(',');
                            for (io in solt) {
                                arr.push(vars[vr]+'='+jsexpr(solt[io]));
                            }
                        } else {
                            arr.push(vars[vr]+'='+jsexpr(sol));
                        }
                    } res = finarr(arr).filter(item => (item.split('=')[1] != '')).filter(item => !(item.includes('i'))).join(',');
                }
            }
        } else {
            if (expr.match(reg) !== null) {
                vars = finarr(expr.match(reg));
                for (vr in vars) {
                    sol = nerdamer.solve(expr, vars[vr]).toString();
                    if (sol.includes(',')) {
                        solt = sol.split(',');
                        for (io in solt) {
                            arr.push(vars[vr]+'='+jsexpr(solt[io]));
                        }
                    } else {
                        arr.push(vars[vr]+'='+jsexpr(sol));
                    }
                } res = finarr(arr).filter(item => (item.split('=')[1] != '')).filter(item => !(item.includes('i'))).join(',');
            } else {
                with(Math) {
                    res = eval(expr);
                }
            }
        }
    } return res;
}
function arrmath(input) {
    var arr = []; var mas = []; var res = [];
    // UNION, Logical OR
    if (input.includes('|')) {
        arr = input.split('|');
        for (el in arr) {
            mas = arr[el].split(',');
            res = (el == 0) ? mas : res.concat(mas);
        }
    // INTERSECTION, Logical AND
    } else if (input.includes('&')) {
        arr = input.split('&');
        for (el in arr) {
            mas = arr[el].split(',');
            res = (el == 0) ? mas : res.filter(x => mas.includes(x));
        }
    // COMPLEMENT, Logical NOT
    } else if (input.includes('~')) {
        arr = input.split('~');
        for (el in arr) {
            mas = arr[el].split(',');
            res = (el == 0) ? mas : res.filter(x => !mas.includes(x));
        }
    // SYMMETRIC DIFFERENCE, Logical XOR
    } else if (input.includes('^')) {
        arr = input.split('^');
        for (el in arr) {
            mas = arr[el].split(',');
            res = (el == 0) ? mas : res.filter(x => !mas.includes(x)).concat(mas.filter(x => !res.includes(x)));
        }
    }
    return res;
}
function pad(num, size) {
    num = num.toString();
    while (num.length < size) num = "0" + num;
    return num;
}
function bconv(bin, alpha = '0123456789abcdef') {
    var alp = alpha.split('');
    var base = alp.length;
    var div = bin, quot = 0, rem = 0, res = '';
    while (div > 0) {
        quot = Math.floor(div / base);
        rem = Math.floor(div % base);
        res = alp[rem] + res;
        div = quot;
    } return res;
}
function hconv(hex, alpha = '0123456789abcdef') {
    var alp = alpha.split('');
    var base = alp.length;
    var hds = hex.split('').reverse();
    var res = 0;
    for (it in hds) {
        res += alp.indexOf(hds[it]) * base ** it;
    } return res;
}
function bin2hex(bin, offs = 0, alpha = '0123456789abcdef') {
    var res = ''; if (bin != '') {
        var hex = '', pos, off;
        for (i = 0; i < bin.length; i++) {
            pos = Math.abs((bin.codePointAt(i)+Math.abs(offs))%1114112);
            off = bconv(pos, alpha); hex += off+' ';
        } res = hex.slice(0, -1);
    } else {
        res = '';
    } return res;
}
function hex2bin(hex, offs = 0, alpha = '0123456789abcdef') {
    var res = ''; if (hex.includes(' ')) {
        var bytes = [], pos, off;
        var str = hex.split(' ');
        for (i = 0; i < str.length; i++) {
            pos = hconv(str[i], alpha);
            off = Math.abs((pos + 1114112 - Math.abs(offs)) % 1114112);
            bytes.push(off);
        } try {
            res = String.fromCodePoint.apply(String, bytes);
        } catch (e) {
            res = '';
        }
    } else {
        res = '';
    } return res;
}
function sumstr(str) {
    var sum = 0;
    for (i = 0; i < str.length; i++) {
        sum += str.codePointAt(i);
    } return sum;
}
function obfstr(str) {
    arr = str.toString().match(/[\s\S]{1,3}/g) || [];
    var lon = arr.length, ltr = 0, lbr = '';
    for (i = 0; i < lon; i++) {
        ltr += parseInt(arr[i], 16);
    } return ltr;
}
function gemstr(str) {
    var sum = sumstr(str);
    var word = sum.toString();
    var out = 0, tex = word.split('');
    while (tex.length > 1) {
        out = 0; for (ch in tex) {
            out += parseInt(tex[ch]);
        } tex = out.toString().split('');
    } return parseInt(tex);
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
    var minCeiled = Math.ceil(min);
    var maxFloored = Math.floor(max);
    return Math.floor(Math.random() * (maxFloored - minCeiled) + minCeiled);
}
function isInt(num) {
    return (Number.isInteger(parseInt(num)));
}
function onlyUnique(value, index, array) {
    return array.indexOf(value) === index;
}
function finarr(arr) {
    return arr.filter(onlyUnique).filter(function(e) {
        return e
    });
}
function arrsum(arr) {
    var res = 0;
    for (i = 0; i < arr.length; i++) {
        if (isInt(arr[i])) {
            res += parseInt(arr[i]);
        }
    }
    return parseInt(res);
}
function arrjob(str, y, x) {
    var arr = str.split(y);
    var arn = {};
    for (i = 0; i < arr.length; i++) {
        arf = arr[i].split(x);
        arn[arf[0]] = arf[1];
    }
    return arn;
}
function arrpack(arr, y, x) {
    var str = '';
    for (var prop in arr) {
        str += prop+x+arr[prop]+y;
    }
    return str;
}
function arrvals(str, y, x) {
    var arr = str.split(y);
    var arn = {};
    for (i = 0; i < arr.length; i++) {
        arf = arr[i].split(x);
        arn[arf[0]] = arf[1];
    }
    return Object.values(arn);
}
function arrkeys(str, y, x) {
    var arr = str.split(y);
    var arn = {};
    for (i = 0; i < arr.length; i++) {
        arf = arr[i].split(x);
        arn[arf[0]] = arf[1];
    }
    return Object.keys(arn);
}
function randomImage(list) {
    var arr = list.split(';');
    var last = arr.length - 1;
    var randNum = Math.floor(Math.random() * last);
    return arr[randNum];
}
function nextImage(list, elem) {
    var arr = list.split(';');
    var last = arr.length - 1;
    var index = arr.indexOf(elem);
    var num = 0;
    num = (index < last) ? (index + 1) : 0;
    return arr[num];
}
function miniPager(content, key) {
    var fmla = content.split(/\r?\n/)[key];
    var res = '';
    if (fmla !== undefined) {
        res = fmla;
    } else {
        res = '';
    }
    return res;
}
function pager(content, key) {
    var fmla = content.split(/\r\n\r\n/)[key];
    var res = '';
    if (fmla !== undefined) {
        res = fmla;
    } else {
        res = '';
    }
    return res;
}
function countChars(str) {
    return str.replace(/[\u0080-\u10FFFF]/g, "x").length;
}
function superRound(x, y) {
    return Math.round((x + Number.EPSILON) * (10 ** y)) / (10 ** y);
}
function superLog(x, y) {
    return Math.round(Math.log(y) / Math.log(x));
}
function superRoot(x, y) {
    return Math.round(Math.pow(y, 1/x));
}
