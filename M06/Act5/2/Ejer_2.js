if (localStorage.getItem("visites") == null){
    localStorage.setItem("visites", "0");

} else {
    number = parseInt(localStorage.getItem("visites"))+1;
    localStorage.setItem("visites", number.toString());
}

document.write("Benvingut! Aquesta es la seva visita numero " + + localStorage.getItem("visites"));