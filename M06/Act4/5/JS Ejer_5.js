var cartas = document.querySelectorAll("img");      //Array con todas las cartas
var inicia = document.getElementById("inicia");     //El bot�n que interactua con las cartas
var esborra = document.getElementById("esborra");   //El bot�n que resetea las cartas
var numeros = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13"];   //Los n�meros de las cartas
var figura = ["cors", "diamants", "picas", "trevol"];   //Las figuras de las cartas
var innerInicia = "Inicia";     //El texto que contiene el bot�n de la variable inicia
var temps;      //El temporizador


//Funci�n que inicia el temporizador, lo para y cambia el texto dentro del bot�n inicia
const programa = () => {

    //Si el bot�n est� en modo iniciar o continuar...
    if(innerInicia == "Inicia" || innerInicia == "Continuar"){
        innerInicia = "Parar";

        //Comienza el temporizador para mostrar cartas aleatorias
        temps = setInterval( () => { 
            for(c = 0; c < cartas.length; c++){
                var num_random = Math.floor(Math.random() * 13);
                var fig_random = Math.floor(Math.random() * 4);
                cartas[c].src= "images\\" + numeros[num_random] + figura[fig_random] + ".png";
            }
        } , 100);

    //Si el bot�n est� en modo parar...
    } else {
        innerInicia = "Continuar";

        //Para el temporizador
        clearInterval(temps);
        
        //Crea un array que contendr� las cartas que ya han salido
        let repes = ["00"];
        let num_random = "0";
        let fig_random = "0";

        //Por cada carta...
        for(c = 0; c < cartas.length; c++){
            //Randomiza que carta saldr� si esa misma ha salido
            while(repes.includes(num_random + fig_random)){
                num_random = Math.floor(Math.random() * 13);
                fig_random = Math.floor(Math.random() * 4);
            }
            
            //Mete la nueva carta en el array de repes y cambia el aspecto de la carta
            repes.push(num_random + fig_random);
            cartas[c].src= "images\\" + numeros[num_random] + figura[fig_random] + ".png";
        }

    }        

    //Modifica el texto del bot�n inicia
    inicia.innerHTML= innerInicia;

}


//Funci�n que pone toda las cartas boca abajo
const reset = () => {
    //Primero, dile al bot�n inicia que est� en modo inicia
    innerInicia = "Inicia";
    inicia.innerHTML= innerInicia;
    //Para el temporizador
    clearInterval(temps);

    //Pon todas las cartas del reverso
    for(c = 0; c < cartas.length; c++){
        cartas[c].src= "images\\revers.png";
    }
}

//Los eventlistener de los botones inicia y esborra
inicia.addEventListener("click", function() {programa();});
esborra.addEventListener("click", function() {reset();});