function ucfirst(str) {
    return (str[0].toUpperCase()+str.slice(1));
}
function flip(x) {
    return ((x > 1) || (x < 0)) ? 0 : (1 - x);
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
                                    arr.push(vars[vr]+'='+solt[io].replace('^','**').replace('[','').replace(']',''));
                                }
                            } else {
                                arr.push(vars[vr]+'='+sol.replace('^','**').replace('[','').replace(']',''));
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
                                arr.push(vars[vr]+'='+solt[io].replace('^','**').replace('[','').replace(']',''));
                            }
                        } else {
                            arr.push(vars[vr]+'='+sol.replace('^','**').replace('[','').replace(']',''));
                        }
                    } rer.push(finarr(arr).filter(item => (item.split('=')[1] != '')).filter(item => !(item.includes('i'))).join(','));
                } else {
                    rer.push(eval(prep[ib]));
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
                                arr.push(vars[vr]+'='+solt[io].replace('^','**').replace('[','').replace(']',''));
                            }
                        } else {
                            arr.push(vars[vr]+'='+sol.replace('^','**').replace('[','').replace(']',''));
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
                            arr.push(vars[vr]+'='+solt[io].replace('^','**').replace('[','').replace(']',''));
                        }
                    } else {
                        arr.push(vars[vr]+'='+sol.replace('^','**').replace('[','').replace(']',''));
                    }
                } res = finarr(arr).filter(item => (item.split('=')[1] != '')).filter(item => !(item.includes('i'))).join(',');
            } else {
                res = eval(expr);
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
