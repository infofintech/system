function ucfirst(str) {
    return (str[0].toUpperCase()+str.slice(1).toLowerCase());
}
function replaceLineBreaks(input='') {
    return (input.toString('')).replace(/[\r\n]+/g,' ');
}
function snakeToCamel(str,delim='_') {
    var arr=str.split(delim);
    var res=''; for (item in arr) {
        res+=ucfirst(arr[item]);
    } return res;
}
function jsonarr(str) {
    var res={}; try { res=JSON.parse(str);
    } catch(e) { res={}; } return res;
}
function arrjson(arr) {
    var res=''; try { res=JSON.stringify(arr);
    } catch(e) { res=''; } return res;
}
function rfc3986(str) {
    return encodeURIComponent(str).replace(/[!'()*]/g,
    (c)=>`%${c.charCodeAt(0).toString(16).toUpperCase()}`);
}
async function clip(str) {
    if (navigator.clipboard&&window.isSecureContext) {
        await navigator.clipboard.writeText(str);
    } else {
        var textArea=document.createElement("textarea");
        textArea.value=str; textArea.style.position="absolute";
        textArea.style.left="-999999px"; document.body.prepend(textArea);
        textArea.select(); try { document.execCommand('copy');
        } catch(e) { console.error(e); } finally { textArea.remove(); }
    }
}
function fixFmla(str) {
    return str.replaceAll("^","**").replaceAll("[","").replaceAll("]","");
}
function quote(arg) { return arg.replaceAll('"',''); }
function hhmmss(num,omitHours=false) {
    var hh=mm=ss=0,isHour=Math.floor(num/3600);
    hh=pad(Math.floor(num/3600),-2);
    num%=3600,mm=pad(Math.floor(num/60),-2);
    ss=pad(Math.floor(num%60),-2);
    return (omitHours)?((isHour==0)?(mm+':'+ss):(hh+':'+mm+':'+ss)):(hh+':'+mm+':'+ss);
}
function solveSystem(expr) {
    var arr=sys=[],res='';
    if (expr.includes(';')) {
        sys=expr.split(';');
        arr=sys.map((x)=>equation(x));
        res=finarr(arr).join(';');
    } else { res=equation(expr); }
    return res;
}
function equation(expr) {
    var arr=sys=[],res='';
    var varsRegex=/\b(?:([a-z])(?!\w))+\b/gi;
    if (expr.includes(',')) {
        sys=expr.split(',');
        for (i in sys) {
            if (expr.match(varsRegex)!==null) {
                if (!(arr.includes(solutions(sys[i])))) {
                    arr.push(solutions(sys[i]));
                }
            } else {
                with(Math) {
                    if (!(arr.includes(eval(sys[i])))) {
                        arr.push(eval(sys[i]));
                    }
                }
            }
        } res=finarr(arr).join(',');
    } else {
        if (expr.match(varsRegex)!==null) {
            res=solutions(expr);
        } else { with(Math) { res=eval(expr); }}
    } return res;
}
function solutions(expr) {
    var arr=vars=sols=[],sol=tesl=tesr=res='';
    nerdamer.set('SOLUTIONS_AS_OBJECT',true);
    var varsRegex=/\b(?:([a-z])(?!\w))+\b/gi;
    if (expr.match(varsRegex)!==null) {
        vars=finarr(expr.match(varsRegex));
        for (i in vars) {
            sol=nerdamer.solve(expr,vars[i]).toString();
            if (sol.includes(',')) {
                sols=sol.split(',');
                for (j in sols) {
                    tesl=vars[i],tesr=fixFmla(sols[j]);
                    if ((tesr!='')&&(!(arr.includes(tesl+'='+tesr)))) {
                        arr.push(tesl+'='+tesr);
                    }
                }
            } else {
                tesl=vars[i],tesr=fixFmla(sol);
                if ((tesr!='')&&(!(arr.includes(tesl+'='+tesr)))) {
                    arr.push(((vars.length>1)?(tesl+'='):'')+tesr);
                }
            }
        } res=finarr(arr).join(',');
    } return res;
}
function arrmath(input) {
    var arr=mas=res=[]; /* UNION, Logical OR */
    if (input.includes('|')) {
        arr=input.split('|'); for (el in arr) {
            if ((arr[el].includes(','))&&!(arr[el].includes(';'))) {
                mas=arr[el].split(',');
            } else if (!(arr[el].includes(','))&&(arr[el].includes(';'))) { mas=arr[el].split(';');
            } else if ((arr[el].includes(','))&&(arr[el].includes(';'))) { mas=arr[el].split(';');
            } else { mas=arr[el];
            } res=(el==0)?mas:res.concat(mas);
        }
    /* INTERSECTION, Logical AND */
    } else if (input.includes('&')) {
        arr=input.split('&'); for (el in arr) {
            if ((arr[el].includes(','))&&!(arr[el].includes(';'))) {
                mas=arr[el].split(',');
            } else if (!(arr[el].includes(','))&&(arr[el].includes(';'))) { mas=arr[el].split(';');
            } else if ((arr[el].includes(','))&&(arr[el].includes(';'))) { mas=arr[el].split(';');
            } else { mas=arr[el];
            } res=(el==0)?mas:res.filter(x=>mas.includes(x));
        }
    /* COMPLEMENT, Logical NOT */
    } else if (input.includes('~')) {
        arr=input.split('~'); for (el in arr) {
            if ((arr[el].includes(','))&&!(arr[el].includes(';'))) {
                mas=arr[el].split(',');
            } else if (!(arr[el].includes(','))&&(arr[el].includes(';'))) { mas=arr[el].split(';');
            } else if ((arr[el].includes(','))&&(arr[el].includes(';'))) { mas=arr[el].split(';');
            } else { mas=arr[el];
            } res=(el==0)?mas:res.filter(x=>!mas.includes(x));
        }
    /* SYMMETRIC DIFFERENCE, Logical XOR */
    } else if (input.includes('^')) {
        arr=input.split('^'); for (el in arr) {
            if ((arr[el].includes(','))&&!(arr[el].includes(';'))) {
                mas=arr[el].split(',');
            } else if (!(arr[el].includes(','))&&(arr[el].includes(';'))) { mas=arr[el].split(';');
            } else if ((arr[el].includes(','))&&(arr[el].includes(';'))) { mas=arr[el].split(';');
            } else { mas=arr[el];
            } res=(el==0)?mas:res.filter(x=>!mas.includes(x)).concat(mas.filter(x=>!res.includes(x)));
        }
    } return res;
}
function pad(num,offs) {
    /* PAD NUMBER TO LEADING OR TRAILING ZEROES */
    var alp=num.toString(),nat='',ab=Math.abs(offs);
    /* LEADING ZEROES IF NUMBER IS NEGATIVE */ if (offs<0) {
        if (alp.includes('.')) { nat=alp.split('.')[0];
            for (i=(ab-nat.length); i>0; i--) alp='0'+alp;
        } else { nat=alp; while (alp.length<ab) alp='0'+alp; }
    /* TRAILING ZEROES IF NUMBER IS POSITIVE */ } else {
        if (alp.includes('.')) { nat=alp.split('.')[0];
            while (alp.length<=(nat.length+ab))alp=alp+'0';
        } else { nat=alp; alp=alp+'.'; for (i=ab; i>0; i--) alp=alp+'0'; }
    } return alp;
}
function genFixedNum(len=4,alpha='0123456789') {
    var alp=alpha.split(''),base=alp.length;
    var res=''; for (i=0; i<len; i++) {
        res+=(alp[rand(0,base-1)]).toString();
    } return res;
}
function genSerial(len=25,alpha='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',pieces=5,delim='-') {
    var alp=alpha.split(''),base=alp.length;
    var res=prep=rest=''; if ((len>pieces)&&(len%pieces==0)) {
        for (i=0; i<len; i++) {
            res+=(alp[rand(0,base-1)]).toString();
        } prep=XRegExp.match(res,XRegExp('.{1,'+pieces+'}','g'));
        rest=prep.join(delim);
    } else {
        for (i=0; i<len; i++) {
            res+=(alp[rand(0,base-1)]).toString();
        } rest=res;
    } return rest;
}
function decbase(dec,alpha='0123456789abcdef') {
    var alps=alpha.split(''),base=alps.length;
    var div=dec,quot=rem=0,res='';
    while (div>0) {
        quot=Math.floor(div/base);
        rem=Math.floor(div%base);
        res=alps[rem]+res; div=quot;
    } return (dec<=0)?alps[0]:res;
}
function basedec(baseN,alpha='0123456789abcdef') {
    var alps=alpha.split(''),base=alps.length;
    var digits=baseN.split('').reverse(),res=0;
    for (it in digits) {
        res+=alps.indexOf(digits[it])*base**it;
    } return (baseN=='')?0:res;
}
function encode(bin,offs=0,alpha='0123456789ABCDEF') {
    var res=''; if ((bin!==undefined)&&(bin!='')) {
        var hex='',pos,off,pas; for (i=0; i<bin.length; i++) {
            pos=Math.abs((bin.codePointAt(i)+Math.abs(offs))%1114112),pas=(i>0)?bin.codePointAt(i-1):'',off=decbase(pos,alpha); if (pas.toString(16).length<=4) {
                hex+=off+' ';
            }
        } res=hex.slice(0,-1);
    } else { res=''; } return res;
}
function decode(hex,offs=0,alpha='0123456789ABCDEF') {
    var res=''; if ((hex!==undefined)&&(hex.includes(' '))) {
        var bytes=[],pos,off,str=hex.split(' ');
        for (i=0; i<str.length; i++) {
            pos=basedec(str[i],alpha);
            off=Math.abs((pos+1114112-Math.abs(offs))%1114112);
            bytes.push(off);
        } try { res=String.fromCodePoint.apply(String,bytes);
        } catch(e) { res=''; }
    } else { res=''; } return res;
}
function format_number(num,prec=0,delim='',decim=',') {
    var res=res1=res2=res3=''; if (notNull(num)) {
        if (isFloat(num)) {
            res1=parseInt(num).toString();
            res2=(num.toString().replace(res1+'.','')).toString();
            res3=(res1.replace(/\B(?=(\d{3})+(?!\d))/g,delim));
            res=(prec>0)?(res3+decim+(res2.slice(0,prec))):res1;
        } else if (isInt(num)) {
            res=num.toString().replace(/\B(?=(\d{3})+(?!\d))/g,delim);
        } else { res=num; }
    } else { res=0; } return res;
}
function sumstr(str) {
    var sum=0; for (i=0; i<str.length; i++) {
        sum+=str.codePointAt(i);
    } return sum;
}
function obfstr(str) {
    var arr=str.toString().match(/[\s\S]{1,3}/g)||[];
    var lon=arr.length,ltr=0;
    for (i=0; i<lon; i++) { ltr+=parseInt(arr[i],16); }
    return ltr;
}
function gemstr(str) {
    var sum=sumstr(str),word=sum.toString();
    var out=0,tex=word.split(''); while (tex.length>1) {
        out=0; for (ch in tex) { out+=parseInt(tex[ch]); }
        tex=out.toString().split('');
    } return parseInt(tex);
}
function leap(yr) {
    return ((yr%4==0)&&(yr%100!=0))||(yr%400==0);
}
function day(tx) { var sep=tx.split('-');
    var now=new Date(sep[0],(sep[1]-1),(sep[2]-1));
    var start=new Date(sep[0],0,0);
    var diff=(now-start),oneDay=1000*60*60*24;
    var day=Math.floor(diff/oneDay); return day;
}
function time(tx) { var sep=tx.split('-');
    var now=new Date(sep[0],(sep[1]-1),(sep[2]-1));
    return now.getTime();
}
function sec(tx) { var sep=tx.split('-');
    var now=new Date(sep[0],(sep[1]-1),(sep[2]-1));
    return Math.round(now.getTime()/1000);
}
function timefrom(str) {
    return Math.round(new Date(str).getTime()/1000);
}
function timeto(sec) {
    var td=new Date(sec*1000),yy=td.getUTCFullYear();
    var mm=td.getUTCMonth()+1,dd=td.getUTCDate();
    return pad(yy,-2)+'-'+pad(mm,-2)+'-'+pad(dd,-2);
}
function zodiac(t) {
    var f=timeto(t),d=day(f),r='';
    if ((d>355)||(d<19)) r="♑️";
    else if ((d>18)&&(d<49)) r="♒️";
    else if ((d>48)&&(d<80)) r="♓️";
    else if ((d>79)&&(d<110)) r="♈️";
    else if ((d>109)&&(d<141)) r="♉️";
    else if ((d>140)&&(d<172)) r="♊️";
    else if ((d>171)&&(d<204)) r="♋️";
    else if ((d>203)&&(d<235)) r="♌️";
    else if ((d>234)&&(d<266)) r="♍️";
    else if ((d>265)&&(d<296)) r="♎️";
    else if ((d>295)&&(d<326)) r="♏️";
    else if ((d>325)&&(d<356)) r="♐️";
    return r;
}
function today() { var n=new Date();
    var y=n.getUTCFullYear(); var m=n.getUTCMonth()+1;
    var d=n.getUTCDate(); return y+'-'+m+'-'+d;
}
function now() { var n=new Date(); return n.getTime(); }
function diffDays(df) {
    return Math.abs(Math.round(df/(24*60*60*1000)));
}
function diffYears(df) {
    return Math.abs(Math.round(df/(365.25*24*60*60*1000)));
}
function offsetNum(pos=0,all=360,off=90) {
    return Math.abs((pos+all-Math.abs(off))%all);
}
function formatDay(tx,st=59) {
    var sep=tx.split('-'),lep=+(leap(sep[0])),dia=day(tx);
    var aly=365+lep,nwy=st+lep; return offsetNum(dia,aly,nwy);
}
function romanDay(tx) { return formatDay(tx,59); }
function rusDay(tx) { return formatDay(tx,243); }
function frenchDay(tx) { return formatDay(tx,263); }
function frenchDate(tx) { var off=frenchDay(tx),clm=(Math.ceil(off/30)-1);
    var arr=["Vendémiaire","Brumaire","Frimaire","Nivôse","Pluviôse","Ventôse","Germinal","Floréal","Prairial","Messidor","Thermidor","Fructidor","Les jours complémentaires"],sda=(off<=0)?(5+lep):(((off%30)>0)?(off%30):30);
    var smo=(off<=0)?arr[arr.length-1]:arr[clm]; return sda+' '+smo;
}
function arraySearch(needle,haystack) {
    for (key in haystack) {
        if ((haystack.hasOwnProperty(key))&&(haystack[key]==needle)&&(key!=needle)) { return key; }
    } return false;
}
function isAllZero(arr) {
    for (i=0; i<arr.length; i++) {
        if ((arr[i]!=0)&&(isInt(arr[i]))) { return false; }
    } return true;
}
function rand(min,max) {
    var minCeiled=Math.ceil(min),maxFloored=Math.floor(max);
    return Math.floor(Math.random()*(maxFloored-minCeiled)+minCeiled);
}
function flip(num) {
    return ((isBit(num)))?parseInt(1-num):num;
}
function isInt(num) {
    return (Number.isInteger(parseInt(num)));
}
function isFloat(num) { return (num%1!==0); }
function isBit(num) {
    return ((isInt(num))&&(num>=0)&&(num<=1));
}
function isNum(num) { return (!isNaN(parseFloat(num))); }
function notErr(val) {
    return (typeof(val)!=='undefined');
}
function notNull(val) {
    return ((notErr(val))&&(typeof(val)!=='null'));
}
function isLine(val) {
    return ((notErr(val))&&(typeof(val)!=='object'));
}
function isObject(val) {
    return ((notErr(val))&&(typeof(val)=='object'));
}
function notEmpty(val) {
    return ((isObject(val))&&(Object.keys(val).length>0));
}
function notBlank(val) {
    return ((isLine(val))&&(val!=''));
}
function onlyUnique(value,index,array) {
    return array.indexOf(value)===index;
}
function numstart(str) {
	return (str.match(/[^\d]*(\d+)/)!==null)?str.match(/[^\d]*(\d+)/)[0]:str;
}
function numsort(a,b) {
    if (isInt(a)&&isInt(b)) {
        return (numstart(b.toString())-numstart(a.toString()));
    } else if (isInt(a)) { return -1;
    } else if (isInt(b)) { return 1;
    } else { return (a>b)?1:-1; }
}
function finarr(arr) {
    return arr.filter(onlyUnique).sort(numsort);
}
function arrsum(arr) {
    var res=0; for (i=0; i<arr.length; i++) {
        if (isNum(arr[i])) {
            res+=(arr[i]<=0)?1:parseFloat(arr[i]);
        } else { res+=1; }
    } return parseFloat(res);
}
function strarr(str,delim=';',equals=':') {
    var arr=str.split(delim),res={};
    for (i=0; i<arr.length; i++) {
        res[arr[i].split(equals)[0]]=arr[i].split(equals)[1];
    } return res;
}
function arrstr(arr,delim=';',equals=':') {
    var str=''; for (var prop in arr) {
        str+=prop+equals+arr[prop]+delim;
    } return str;
}
function randomImage(list) {
    var arr=list.split(';'),last=(arr.length-1);
    var randNum=Math.floor(Math.random()*last); return arr[randNum];
}
function nextImage(list,elem) {
    var arr=list.split(';'),last=arr.length-1;
    var index=arr.indexOf(elem),num=(index<last)?(index+1):0; return arr[num];
}
function miniPager(content,key) {
    var fmla=content.split(/\r?\n/)[key];
    return (fmla!==undefined)?fmla:'';
}
function pager(content,key) {
    var fmla=content.split(/\r\n\r\n/)[key];
    return (fmla!==undefined)?fmla:'';
}
function countChars(str) {
    return str.replace(/[\u0080-\u10FFFF]/g,"x").length;
}
function superRound(num,prec=3) {
    return Math.round((num+Number.EPSILON)*(10**prec))/(10**prec);
}
function superLog(num,base=10) {
    return Math.round(Math.log(num)/Math.log(base));
}
function superRoot(num,exp=3) { return Math.round(num**(1/exp)); }
