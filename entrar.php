<!DOCTYPE html>
<html>
<head>
	<title>Sistema de comentarios</title>
	<style type="text/css">
		*{
			margin: 0;
			padding: 0;
		}

		body{
			font-family: arial;
			background: url(img/fundo.jpg);
		}

		form{
			width: 350px;
			margin: 10px auto;
			background: white;
			padding: 25px;
			box-shadow: 1px 1px 10px rgba(0,0,0,.3);
		}

		img{
			width: 20px;
			float: left;
			margin-right: 10px;
			margin-top: 5px;
		}

		input{
			display: block;
			float: left;
			width: 87%;
			height: 30px;
			font-size: 11pt;
			color: rgba(0,0,0,.3);
			padding: 5px;
			margin-bottom: 15px;
			outline: none;
		}

		h1{
			font-size: 11pt;
			padding: 10px;
			font-weight: normal;
			text-align: center;
			margin-bottom: 30px;
		}

		input[type="submit"] {
			width: 100px;
			height: 40px;
			cursor: pointer;
			background: lightblue;
			color: #fff;
			border: none;
			float: right;
			box-shadow: 1px 1px 4px rgba(0,0,0,.4);
		}

		a{
			display:  block;
			text-align: left;
			clear: both;
			color: black;
			text-decoration: none;
		}

		a:hover{
			text-decoration: underline;
		}

		span{
			display: block;
			text-align: center;
			color: yellow;
			font-size: 30px;
			margin-top: 50px;
			text-shadow: 1px 1px 3px gray;
		}
	</style>
</head>
<body>

	<span>Jonatas<br>HardProX</span>

	<form method="POST">
		<h1>Acesse sua conta</h1>
		<img src="img/icone-usuario.png">
		<input type="email" name="email" autocomplete="off">
		<img src="img/icone-cadeado.png">
		<input type="password" name="senha">
		<input type="submit" name="btn-entrar" value="ENTRAR">
		<a href="cadastrar.php">Rigistrar-se agora!</a>
	</form>


</body>
</html>

<?php

	if(isset($_POST['btn-entrar'])){

	$email = addslashes($_POST['email']);
	$senha = addslashes($_POST['senha']);

	if(!empty($email) and !empty($senha)){

		require_once 'classes/usuarios.php';
		$us = new Usuario("projeto_comentarios", "localhost", "root", "");
		if($us->Logar($email,$senha)){
			header('location: index.php');
		}else{ ?>
			<script type="text/javascript">
				alert("<?php echo 'Email e/ou senha incorretos!'?>");
			</script> <?php
		}
	}else{ ?>
		<script type="text/javascript">
			alert("<?php echo 'prenchar todos os campos!'?>");
		</script> <?php
	}

}

?>