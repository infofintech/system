function get(action='i',host='',pkg,repo,branch='',user,fend='') {
    if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();
    } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4&&this.status==200) {
            if (fend!='') {
                document.location.reload();
            }
        }
    }; xmlhttp.open("GET","get.php?action="+action+"&attr=&host="+host+"&pkg="+pkg+"&repo="+repo+"&branch="+branch+"&user="+user,false);
    xmlhttp.send();
}
function getdir(action='i',host='',pkg,repo,branch='',user,fend='') {
    if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();
    } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4&&this.status==200) {
            if (fend!='') {
                document.location.reload();
            }
        }
    }; xmlhttp.open("GET","get.php?action="+action+"&attr=raw&host="+host+"&pkg="+pkg+"&repo="+repo+"&branch="+branch+"&user="+user,false); xmlhttp.send();
}
function set(name,content,attr='',fend='') {
    var dataString='name='+name+'&content='+content+'&attr='+attr;
    $.ajax({
        type: "POST", url: "write.php",
        data: dataString, cache: false,
        success: function(html) {
            if (fend!='') {
                document.location.reload();
            }
        }
    }); return false;
}
function del(name,attr='',fend='') {
    if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();
    } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4&&this.status==200) {
            if (fend!='') {
                document.location.reload();
            }
        }
    }; xmlhttp.open("GET","delete.php?name="+name+"&attr="+attr,false);
    xmlhttp.send();
}
function chmod(name,mode='0777',attr='',fend='') {
    if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();
    } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4&&this.status==200) {
            if (fend!='') {
                document.location.reload();
            }
        }
    }; xmlhttp.open("GET","chmod.php?name="+name+"&mode="+mode+"&attr="+attr,false);
    xmlhttp.send();
}
function mkdir(name,attr='',fend='') {
    if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();
    } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4&&this.status==200) {
            if (fend!='') {
                document.location.reload();
            }
        }
    }; xmlhttp.open("GET","mkdir.php?name="+name+"&attr="+attr,false);
    xmlhttp.send();
}
function move(name,dest,attr='',fend='') {
    if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();
    } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4&&this.status==200) {
            if (fend!='') {
                document.location.reload();
            }
        }
    }; xmlhttp.open("GET","move.php?name="+name+"&dest="+dest+"&attr="+attr,false);
    xmlhttp.send();
}
function copy(name,dest,attr='',fend='') {
    if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();
    } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4&&this.status==200) {
            if (fend!='') {
                document.location.reload();
            }
        }
    }; xmlhttp.open("GET","copy.php?name="+name+"&dest="+dest+"&attr="+attr,false);
    xmlhttp.send();
}
function poll(name,select,fend='') {
    if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();
    } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4&&this.status==200) {
            if (fend!='') {
                document.location.reload();
            }
        }
    }; xmlhttp.open("GET","poll.php?name="+name+"&select="+select,false);
    xmlhttp.send();
}
function playAudio(obj,name) { obj.src=name; obj.play(); }
function pauseAudio(obj) { obj.pause(); }
function playMIDI(id) { MIDIjs.play(id); }
function pauseMIDI() { MIDIjs.pause(); }
function obj(name,oper,path='',val='',fend='') {
    if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();
    } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4&&this.status==200) {
            if (fend!='') {
                document.location.reload();
            }
        }
    }; xmlhttp.open("GET","obj.php?name="+name+"&oper="+oper+"&path="+encodeURIComponent(path)+"&val="+val,false);
    xmlhttp.send();
}
function recycle(name,fend='') {
    if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();
    } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4&&this.status==200) {
            if (fend!='') {
                document.location.reload();
            }
        }
    }; xmlhttp.open("GET","recycle.php?name="+name,false);
    xmlhttp.send();
}
function restore(id,fend='') {
    if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();
    } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4&&this.status==200) {
            if (fend!='') {
                document.location.reload();
            }
        }
    }; xmlhttp.open("GET","restore.php?id="+id,false);
    xmlhttp.send();
}
