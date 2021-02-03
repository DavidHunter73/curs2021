<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>Formulario</title>
	</head>

	<script>
		$.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
		});
	</script>

	<body>

		<!--Menú de Login-->
		<form enctype="multipart/form-data" action="{{route('postform')}}" method="POST" id="form" name="formulario">
			@csrf

			<div>
				<p>Dades</p>
			</div>

			<div>
				<!--Espacio donde introducir el nombre-->
				<label>Nom</label> 
				<input type="text" size="30" maxlength="100" name="name" id="" />
			
				@if ($errors->has('name'))
					<span class="invalid-feedback" role="alert">
						<strong>Es requereix el Nom</strong>						
					</span>
				@endif
			</div>

			<div>
				<!--Espacio donde introducir el mail-->
				<label>Mail</label> 
				<input type="text" size="30" maxlength="100" name="mail" id="" />
				@if ($errors->has('mail'))
					<span class="invalid-feedback" role="alert">
						<strong>Es requereix el camp Mail</strong>				
					</span>
					@endif
			</div>

			<div>
				<!--Espacio donde introducir el NIF-->
				<label>NIF</label> 
				<input type="text" size="30" maxlength="100" name="nif" id="" />
				@if ($errors->has('nif'))
					<span class="invalid-feedback" role="alert">
						<strong>Es requereix el camp NIF</strong>						
					</span>
				@endif
			</div>

			<div>
				<label>Fitxer de màxim 1MB</label>
				<input type="file" id="" name="file" accept="" />
				@if ($errors->has('file'))
					<span class="invalid-feedback" role="alert">
						<strong>Es requereix un fitxer de 1MB o menys</strong>						
					</span>
				@endif
			</div>

			<div>
				<label>Imatge de mínim 1920x1080</label>
				<input type="file" id="" name="image" accept=".png, .jpg" />
				@if ($errors->has('image'))
					<span class="invalid-feedback" role="alert">
						<strong>Es requereix una imatge del tamany especificat</strong>						
					</span>
				@endif
			</div>

			<div>
				<button id="mysubmit" type="submit">Submit</button>
			</div>

		</form>
	</body>
</html>