//Al cargar la página, haz la función init
window.onload = function () { init(); };


//Función Utilizada para enviar un mensaje al servidor
function Enviar() {
	if ($('#mensaje').val() != "") {
		console.log("Esto va");
		//Pasale a la función send del controller el mensaje
		$.post("https://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/facebook/public/send", {
			mensaje: $('#mensaje').val(),
			imagen: $('#imagen').val(),
			_token: $("meta[name='csrf-token']").attr("content")
		});
		$('#mensaje').val("");
	}
}


//Cuando la página esté cargada, también crea el evento en el mensaje para que se pueda enviar con enter
$(document).ready(function () {
	$('#mensaje').keydown(function (event) {
		if (event.which === 13) {
			event.preventDefault();
			Enviar();
		}
	});

	$('.comentarioInput').keydown(function (event) {
		if (event.which === 13) {
			event.preventDefault();
			//Comentar(user_id, message.id, $("#commentInput"+mesId).val());
		}
	});
});


//Evento del botón de enviar
$('#enviar').click(function () {
	Enviar();
});



//Función para crear mensajes
function createMessage(message, user) {
	var muro = $("#muro");
	var mesId = message.id;
	var script_tag = document.getElementById('functions');
	var user_id = script_tag.getAttribute("user-id");

	muro.prepend("<div id='comments" + mesId + "'></div><hr>");
	muro.prepend("<form enctype=\"multipart/form-data\" method=\"post\"> <input type='text' id=\"commentInput" + mesId + "\" class=\"comentarioInput\"></input> <button type='button' id=\"commentButton" + mesId + "\">Comentar</button> </form>")
	muro.prepend("<label class='like_num'>" + message.likes + "</label>");
	muro.prepend("<img src=\"https://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/facebook/storage/app/like.png\" style=\"width:20px\" id=\"like" + mesId + "\"></img>");
	muro.prepend("<p><strong>" + user.name + ": " + message.messages + "</strong></p>");

	//Añade el evento de click al botón de like
	$("#like" + mesId).click(function () {
		Like(user_id, message.id);
	});

	$("#commentButton" + mesId).click(function () {
		Comentar(user_id, message.id, $("#commentInput" + mesId).val());
		$("#commentInput" + mesId).val("");
	});
}


//Función para crear mensajes
function createComment(comment) {

	var comentario = "";
	var comments;

	$.ajax({
		url: "https://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/facebook/public/get",
		type: 'GET',
	})
		.done(function (data) {
			data[0].forEach(message => {
				if (comment.message_id == message.id) {
					comments = $("#comments" + message.id);

					comentario = "";
					console.log("Estoy comentando");

					comentario += "<p>";
					data[1].forEach(commentUser => {
						if (commentUser.id == comment.user_id) {
							comentario += commentUser.name + ": ";
						}
					});
					comentario += comment.comments;
					comentario += "</p>";

					comments.prepend(comentario);
				}
			});
			//console.log($('.like_num')[i].html);
		})
		.fail(function () {
			console.log('Failed');
		});
}



//El método like, que añade o elimina tu voto en el mensaje
async function Like(user, message) {
	//console.log(message + " | " + user);

	$.post("https://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/facebook/public/like", {
		mensaje: message,
		usuario: user,
		_token: $("meta[name='csrf-token']").attr("content")
	});
}

////PONER ESTO PARA QUE SE EJECUTE CON UN EVENTO, QUE SE LLAMARÁ AL FINAL DE LA FUNCIÓN LIKE DEL MURO CONTROLLER
function ReloadLikes() {
	var script_tag = document.getElementById('functions');
	var user_id = script_tag.getAttribute("user-id");

	//Variable que mira la posición del comentario en el array
	position = $('.like_num').length - 1;
	strong = false;

	$.ajax({
		url: "https://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/facebook/public/get",
		type: 'GET',
	})
		.done(function (data) {
			document.querySelectorAll('.like_num').forEach(numero => {
				data[2].forEach(like => {
					if (like.user_id == user_id
						&&
						like.message_id == data[0][position].id) {
						strong = true;
					}
				});

				if (strong) {
					numero.innerHTML = "<strong>" + data[0][position].likes + "<\strong>";
				} else {
					numero.innerHTML = data[0][position].likes;
				}
				console.log(data[0][position].likes); //= mensaje.likes;	
				position--;
				strong = false;
				//console.log($('.like_num')[i].html);

			});
		})
		.fail(function () {
			console.log('Failed');
		});
}


//Función Utilizada para enviar un mensaje al servidor
function Comentar(user, message, comment) {
	if (comment != "") {
		console.log("Comentando");
		//Pasale a la función send del controller el mensaje
		$.post("https://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/facebook/public/comment", {
			usuario: user,
			mensaje: message,
			comentario: comment,
			_token: $("meta[name='csrf-token']").attr("content")
		});
	}
}



/***Esta función se ejecuta al cargar la página***/
function init() {
	var script_tag = document.getElementById('functions');
	var user_id = script_tag.getAttribute("user-id");
	var user_name = script_tag.getAttribute("user-name");
	var muro = $("#muro");
	var whisper = $("#whisper");
	var userDiv = $("#userList");

	//Recoge los valores de la base de datos
	$.ajax({
		url: "https://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/facebook/public/get",
		type: 'GET',
	})
		.done(function (data) {
			user = "";
			//Por cada mensaje, mira cual es el usuario correcto
			data[0].forEach(mensaje => {
				data[1].forEach(usuario => {
					if (mensaje.from == usuario.id) user = usuario;
				});

				//Crea el mensaje
				createMessage(mensaje, user);

			});

			//Crea los comentarios y los usuarios registrados
			$.ajax({
				url: "https://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/facebook/public/get",
				type: 'GET',
			})
				.done(function (data) {
					data[3].forEach(comment => {
						createComment(comment);
					});

					data[1].forEach(user2 => {
						console.log("LOCURA");
						usuario = "<a id=" + user2.id +
							" href=\"" + "https://dawjavi.insjoaquimmir.cat/dhernandez/UF2/Larabel/facebook/public/privado" +
							"\">" + user2.name + "</a> <br>";
						userDiv.prepend(usuario);
					});
				})
				.fail(function () {
					console.log('Failed');
				});

			ReloadLikes();

		})
		.fail(function () {
			console.log('Failed');
		});

	//Ya que el whisper me obliga a usar un canal privado, comento como sería el canal en public
	//Echo.channel('public')
	Echo.private('public')
		//Listener del evento de que se ha introducido un nuevo mensaje
		.listen('NewMessageNotification', (e) => {
			createMessage(e.message, e.user);
		});


	//Ya que el whisper me obliga a usar un canal privado, comento como sería el canal en public
	//Echo.channel('public')
	Echo.private('public')
		//Listener del evento de que se ha introducido un nuevo mensaje
		.listen('NewCommentNotification', (e) => {
			createComment(e.comment);
		});


	//Evento que observa cuando se ha escrito algo en el input de mensaje
	$("#mensaje").keyup(function () {
		//Ya que el whisper me obliga a usar un canal privado, comento como sería el canal en public
		//Echo.channel('public')
		Echo.private('public')

			//En caso de que sí, crea el whisper
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
			if (e.value != "") {
				whisper.html(e.name + " está escribiendo...");
			} else {
				whisper.html("Nadie está escribiendo");
			}
		});

	Echo.private('public')
		.listen('ReloadLikes', () => {
			ReloadLikes();
		});


	Echo.join('connected')
		.here((users) => {
			users.forEach(function (user) {
				$("#" + user.name).html("<strong>" + user.name + "</strong >");
			});
		})
		.joining((user) => {
			$("#" + user.name).html("<strong>" + user.name + "</strong >");
			console.log(user.name + "joins");
		})
		.leaving((user) => {
			$("#" + user.name).html(user.name);
			console.log(user.name + "leaves");
		});


}





