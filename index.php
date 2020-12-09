<?php

	require_once 'classes/usuarios.php';
	session_start();
	if(isset($_SESSION['id_usuario'])){
		$us = new Usuario("projeto_comentarios", "localhost", "root", "");
		$informação = $us->BuscarDados($_SESSION['id_usuario']);
	}elseif(isset($_SESSION['id_master'])){
		$us = new Usuario("projeto_comentarios", "localhost", "root", "");
		$informação = $us->BuscarDados($_SESSION['id_master']);
	}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Sistema de comentarios</title>
	<meta charset="utf-8">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Charmonman:wght@700&display=swap" rel="stylesheet">
	<style type="text/css">


*{
	margin: 0px;
	padding: 0px;
}

body{
	font-family: arial;
}

h3{
	font-size: 40pt;
	padding: 70px;
}

/** menu **/

nav{
	background: rgba(123,104,238);
	height: 60px;
}

ul{
	list-style: none;
	float: right;
	margin-right: 100px;
}

li{
	display: inline-block;
	line-height: 60px;
	padding: 0px 10px;
}

li a{
	text-decoration: none;
	color: white;
}

li a:hover{
	border-bottom: 1px solid white;
	padding-bottom: 5px;
}


h2{
	font-family: 'Charmonman', cursive;
	font-size: 35pt;
	padding: 50px;
	font-weight: normal;
}

	</style>
</head>
<body>
	<nav>
		<ul>
			<?php
				if(isset($_SESSION['id_master']))
				{ ?>
					<li><a href="dados.php">Dados</a></li>
				<?php } 
			?>
			<li><a href="discussao.php">Discussão</a></li>
			<?php 
				if(isset($informação)) //tem uma sessao
				{ ?>
					<li><a href="sair.php">Sair</a></li>
				<?php } else { ?>
					<li><a href="entrar.php">Entrar</a></li>
				<?php } ?>
		</ul>
	</nav>

<?php
	
	if(isset($_SESSION['id_master']) or isset($_SESSION['id_usuario']))
	{ ?>
		<h2>
			<?php 
			echo "olá! ";
			echo $informação['nome'];
			echo " , seja bem vindo(a)!";
			?>
		</h2>
	<?php }
?>

<h3>Conteudo Qualquer</h3>

</body>
</html>