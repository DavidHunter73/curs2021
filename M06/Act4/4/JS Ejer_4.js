let images = document.querySelectorAll("img");
let resultat = document.getElementById("resultat");
let personajes = ["planta1", "planta2", "planta3", "zombie1", "zombie2", "zombie3"];

var num_comp = 0;

const inicia = () => { 

    let repes = [];

    for (i = 0; i < images.length; i++){
        random = Math.floor(Math.random() * 6);
        document.images[i].src = "images\\" + personajes[random] + ".jpg";
        if(repes.includes( random )) {
            num_comp++;
        } else {
            repes.push(random);
        }
    }
    resultat.innerHTML= "Hi ha " + num_comp + " coincidencies";

}

document.querySelector("#BUTON").addEventListener("click", function() {inicia();});