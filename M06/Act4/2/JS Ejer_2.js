//Funcion que se activa con el rat�n por encima
const hover = () => { 

    colors = ["red", "blue", "green", "yellow", "black", "brown", "purple", "pink", "orange", "grey"]

    //Fondo de color aleatorio. Basicamente hace un n�mero random asegurandose que al principio haya un # para que lo reconozca como un color
    event.target.style.background= colors[Math.floor(Math.random()*10)];    
}

//Funcion que se activa cuando el rat�n deje de estar encima
const unhover = () => { 
    event.target.style.background="white";  //Fondo blanco
}



//Funcion que mete en un array todos los cubos
let cubes = document.querySelectorAll("th");

//Un for que a�ade las funciones a cubos
for (t = 0; t < cubes.length; t++) {
    cubes[t].addEventListener("mouseover", function(event) {hover();} );
    cubes[t].addEventListener("mouseout", function(event) {unhover();} );
}

