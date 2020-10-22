//Funcion que se activa con el rat�n por encima
const hover = () => { 
    event.target.style.background="red";    //Fondo rojo
    event.target.style.color="white";   //Letras blancas
    event.target.textContent= event.target.textContent.toUpperCase(); //Letras may�sculas
}

//Funcion que se activa cuando el rat�n deje de estar encima
const unhover = () => { 
    event.target.style.background="white";  //Fondo blanco
    event.target.style.color="red";     //Letras rojas
    //La primera letra, el charAt(0), la pone en may�scula, mientras a partir de la segunda, el slice(1), las pone en min�scula
    event.target.textContent= event.target.textContent.charAt(0).toUpperCase() + event.target.textContent.slice(1).toLowerCase();
}



//Funcion que mete en un array todos los enlaces
let all_red = document.querySelectorAll("a")

//Un for que a�ade las funciones a los enlaces
for (t = 0; t < all_red.length; t++) {
    all_red[t].addEventListener("mouseover", function(event) {hover();} );
    all_red[t].addEventListener("mouseout", function(event) {unhover();} );
}

