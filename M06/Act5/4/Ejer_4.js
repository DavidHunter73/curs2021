var imagenes = document.querySelectorAll("img");

if (localStorage.getItem("fons") != null){
    document.body.style.backgroundColor = localStorage.getItem("fons");
    
    for (i = 0; i < imagenes.length; i++){ 
        imagenes[i].style.border = localStorage.getItem("amplada") + " solid black";
    }

} else {
    window.location.href = "Formu_4.html";
}