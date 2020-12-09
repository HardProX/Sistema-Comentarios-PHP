<?php
session_start();

if (!isset($_SESSION['id_master'])) {
	header('location: index.php');
}

require_once 'classes/usuarios.php';
$us = new Usuario("projeto_comentarios", "localhost", "root", "");
$dados = $us->buscarTodosUser();

?>
<!DOCTYPE html>
<html>
<head>
	<title>sistema de comentarios</title>
	<style type="text/css">

	*{
		margin: 0;
		padding: 0;
	}


body{
	font-family: arial;
}

nav{
	background: rgba(123,104,238);
	height: 60px;
	margin-bottom: 60px;
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

table{
	width: 80%;
	background-color: rgba(0,0,0,.1);
	margin: 0 auto;
	border-collapse: collapse;
}

tr#titulo{
	background: rgba(0,0,0,.8);
	color: #fff;
	text-align: center;
}

tr{
	height: 50px;
	text-align: center;
}

td{
	border: 1px solid black;
}

footer{
	height: 50px;
	background: #a6a6a6;
	padding: 10px;
	text-align: center;
	margin-top: 10px;
}

footer p{
	line-height: 50px;
}
	</style>
</head>
<body>
	<nav>
		<ul>
			<li><a href="index.php">Inicio</a></li>
			<li><a href="discussao.php">Dicussão</a></li>
			<li><a href="sair.php">Sair</a></li>
		</ul>
	</nav>
	
	<table>
		<tr id="titulo">
			<td>ID</td>
			<td>NOME</td>
			<td>EMAIL</td>
			<td>COMENTARIOS</td>
		</tr>
		<?php
			if(count($dados) > 0)
			{
				foreach ($dados as $v) {
		?>
		<tr>
			<td><?php echo $v['id']; ?></td>
			<td><?php echo $v['nome']; ?></td>
			<td><?php echo $v['email']; ?></td>
			<td><?php echo $v['quantidade']; ?></td>
		</tr>
		<?php

				}
			}else{ ?>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
		<?php	}
		?>
	</table>
	
</body>
</html>