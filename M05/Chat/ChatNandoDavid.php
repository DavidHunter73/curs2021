<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-FT8BYCJY9S"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-FT8BYCJY9S');
	</script>
</head>
<body>

	<?php
	
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if(isset($_REQUEST["borrar"])){
				$file = fopen("mensajes.txt","w");
				fwrite($file, "");
				fclose($file);
			} else {
				$file = fopen("mensajes.txt","a");
				fwrite($file, PHP_EOL . $_REQUEST["texto"]);
				fclose($file);
			}
		}

		$file = fopen("mensajes.txt","r");
		while(!feof($file)) {
			echo '<div class="texto"> <p style="margin: 10px;">'.fgets($file).'</p> </div><br>';
		}
		fclose($file);

	?>

    <div class="contenidor">        
        <div class="formulari">
            <form action="ChatNandoDavid.php" method="post"><br>
                <fieldset>
                <legend>Chat</legend>
                <label for="texto">Introduce el texto a enviar:</label> <br>   
                <input type="text" name="texto" id="texto">    
                <input type="submit" value="Enviar">
				<br><br>
				<button type="submit" name= "borrar" value=True><b>BORRAR CHAT</b></button>
                </fieldset>
            </form>
        </div>
    </div>
</body>
</html>