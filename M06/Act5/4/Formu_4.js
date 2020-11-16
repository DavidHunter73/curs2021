function submit(){
    window.location.href = "Ejer_4.html";
}


var botones_fons =      document.querySelectorAll(".fons");
var botones_amplada =   document.querySelectorAll(".amplada");
var boton_submit =      document.querySelector(".submit");


for (b = 0; b < botones_fons.length; b++){
    botones_fons[b].addEventListener    ("click", function(event) {localStorage.setItem("fons", event.target.id);});
}

for (b = 0; b < botones_amplada.length; b++){
    botones_amplada[b].addEventListener ("click", function(event) {localStorage.setItem("amplada", event.target.id);});
}

boton_submit.addEventListener("click", function(event) {submit();});


if (localStorage.getItem("fond") != null){
    window.location.href = "Ejer_4.html";
}