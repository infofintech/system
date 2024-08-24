function get(action, host = '', pkg, repo, branch = '', user, bulk = false) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                document.location.reload();
            }
        }
    }
    xmlhttp.open("GET","get.php?action="+action+"&host="+host+"&pkg="+pkg+"&repo="+repo+"&branch="+branch+"&user="+user,false);
    xmlhttp.send();
}
function getdir(action, host = '', pkg, repo, branch = '', user, bulk = false) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                document.location.reload();
            }
        }
    }
    xmlhttp.open("GET","getdir.php?action="+action+"&host="+host+"&pkg="+pkg+"&repo="+repo+"&branch="+branch+"&user="+user,false);
    xmlhttp.send();
}
function set(name, content, bulk = false) {
    var dataString = 'name='+name+'&content='+content;
    $.ajax({
        type: "POST",
        url: "write.php",
        data: dataString,
        cache: false,
        success: function(html) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    });
    return false;
}
function change(id, to, pass, bulk = false) {
    var dataString = 'id='+id+'&to='+to+'&pass='+pass;
    $.ajax({
        type: "POST",
        url: "change.php",
        data: dataString,
        cache: false,
        success: function(html) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    });
    return false;
}
function poll(name, select, bulk) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    };
    xmlhttp.open("GET","poll.php?name="+name+"&select="+select,false);
    xmlhttp.send();
}
function playAudio(obj, name) {
    obj.src = name; obj.play();
}
function pauseAudio(obj) {
    obj.pause();
}
function playMIDI(id) {
    MIDIjs.play(id);
}
function pauseMIDI() {
    MIDIjs.pause();
}
function arr(name, oper, path = '', val = '', bulk = false) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","arr.php?name="+name+"&oper="+oper+"&path="+path+"&val="+val,false);
    xmlhttp.send();
}
function recycle(name, bulk = false) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","recycle.php?name="+name,false);
    xmlhttp.send();
}
function restore(id, bulk = false) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","restore.php?id="+id,false);
    xmlhttp.send();
}
function del(name, bulk = false) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","delete.php?name="+name,false);
    xmlhttp.send();
}
function mkdir(name, bulk = false, merge = 0) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","mkdir.php?name="+name+"&merge="+merge,false);
    xmlhttp.send();
}
function move(name, to, bulk = false, merge = 0) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","move.php?name="+name+"&to="+to+"&merge="+merge,false);
    xmlhttp.send();
}
function copy(name, to, bulk = false, merge = 0) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","copy.php?name="+name+"&to="+to+"&merge="+merge,false);
    xmlhttp.send();
}
function clear(id, bulk = false) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","clear.php?id="+id,false);
    xmlhttp.send();
}
function withdraw(amount = 0, wallet = '', bulk = false) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","withdraw.php?amount="+amount+"&wallet="+wallet,false);
    xmlhttp.send();
}
