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
       }           return "";       }


if (document.cookie.indexOf("visites=") < 0){
    visitas = setCookie("visites", 0, 365);
} else {
    document.write(setCookie("visites", parseInt(getCookie("visites")) + 1, 365));
}