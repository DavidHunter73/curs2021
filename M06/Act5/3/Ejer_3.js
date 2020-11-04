function setCookie(camp, valor, dies) {
   var d = new Date();
   d.setTime(d.getTime() + (dies*24*60*60*1000));
   var expires = "expires="+ d.toUTCString();
   document.cookie = camp + "=" + valor + ";" + expires; 
   return valor;
}

function getCookie(nom) {
    var name = nom + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }           
            return "";       

}

var imagenes = document.querySelectorAll("img");

if (document.cookie.indexOf("fons=") >= 0){
    document.body.style.backgroundColor = getCookie("fons");
    
    for (i = 0; i < imagenes.length; i++){ 
        imagenes[i].style.border = getCookie("amplada") + " solid black";
    }

} else {
    window.location.href = "Formu_3.html";
}