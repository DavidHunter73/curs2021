function setCookie(camp, valor, dies) {
    var d = new Date();
    d.setTime(d.getTime() + (dies*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = camp + "=" + valor + ";" + expires; 
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

function submit(){
    window.location.href = "Ejer_3.html";
}



var botones_fons =      document.querySelectorAll(".fons");
var botones_amplada =   document.querySelectorAll(".amplada");
var boton_submit =      document.querySelector(".submit");


for (b = 0; b < botones_fons.length; b++){
    botones_fons[b].addEventListener    ("click", function(event) {setCookie("fons", event.target.id, 365);});
}

for (b = 0; b < botones_amplada.length; b++){
    botones_amplada[b].addEventListener ("click", function(event) {setCookie("amplada", event.target.id, 365); 
                                                                    console.Log(event.target.id);});
}

boton_submit.addEventListener("click", function(event) {submit();});


if (document.cookie.indexOf("fons=") >= 0){
    window.location.href = "Ejer_3.html";
}