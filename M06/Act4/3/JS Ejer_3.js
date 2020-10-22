var num_img = 0;

const more = () => { 

    if(num_img == 9){
        num_img = 0;
    } else {
        num_img++;     
    }

   document.getElementById("myImg").src = "images\\" + num_img + ".png";   
}

const less = () => { 

    if(num_img == 0){
        num_img = 9;
    } else {
        num_img--;     
    }

    document.getElementById("myImg").src = "images\\" + num_img + ".png";
}

document.querySelector("#plus").addEventListener("click", function() {more();});
document.querySelector("#minus").addEventListener("click", function() {less();});