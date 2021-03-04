window.onload = function() { init(); };


$(document).ready(function() {
  $('input').keydown(function(event) {
    if (event.which === 13) {
      event.preventDefault();
      Enviar();
    }
  });
});


function Enviar(){
	if($('#mensaje').val() != ""){
		console.log("Esto va");
		$.post("https://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/facebook/public/send", {
			mensaje: $('#mensaje').val(), 
			_token: $("meta[name='csrf-token']").attr("content")
		});
		$('#mensaje').val("");
	}
}


$('#enviar').click(function(){
	Enviar();
});




function init(){
	var script_tag = document.getElementById('functions')
	var user_id = script_tag.getAttribute("user-id");
	var user_name = script_tag.getAttribute("user-name");
	var muro = $("#muro");
	var whisper = $("#whisper")

	$.ajax({
		url: "https://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/facebook/public/get",
		type: 'GET',
	})
	.done(function (data) {
		nombre = "";
		data[0].forEach(mensaje => {
			data[1].forEach(usuario => {
				if(mensaje.from == usuario.id) nombre = usuario.name;
			});
			muro.prepend("<p>" + nombre + ": " + mensaje.messages + "</p>");
		});
	})
	.fail(function () {
		console.log('Failed');
	});

	//Ya que el whisper me obliga a usar un canal privado, comento como sería el canal en public
	//Echo.channel('public')
	Echo.private('public')

	.listen('NewMessageNotification', (e) => {
		muro.prepend("<p>"+ e.user.name + ": " + e.message.messages +"</div>");
	}); 

	$("#mensaje").keyup(function(){
		//Ya que el whisper me obliga a usar un canal privado, comento como sería el canal en public
		//Echo.channel('public')
		Echo.private('public')

		.whisper('typing', {
			value: $('#mensaje').val(),
			name: user_name
		});
	});

	//Ya que el whisper me obliga a usar un canal privado, comento como sería el canal en public
	//Echo.channel('public')
	Echo.private('public')
    .listenForWhisper('typing', (e) => {
		//console.log($('#mensaje').val());
		if(e.value != ""){
			whisper.html(e.name + " está escribiendo...");
		} else {
			whisper.html("Nadie está escribiendo");
		}	
    });
}





