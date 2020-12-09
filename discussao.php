<?php
	session_start();
	require_once 'classes/comentarios.php';
	$c = new Comentario("projeto_comentarios","localhost","root","");
	$coments = $c->buscarComentarios();


	if(isset($_GET['id_exc']))
	{
		$id_exc = addslashes($_GET['id_exc']);

		if(isset($_SESSION['id_master']))
		{
			$c->excluirComentarios($id_exc, $_SESSION['id_master']);

		}elseif(isset($_SESSION['id_usuario']))
		{
			$c->excluirComentarios($id_exc, $_SESSION['id_usuario']);
		}

		header('location: discussao.php');
    }

    if(isset($_POST['btn-comentar']))
    {

    	$comentario = addslashes($_POST['texto']);
    	if(isset($_SESSION['id_master'])){
    		$c->inserirComentario($_SESSION['id_master'], $comentario);
    	}elseif(isset($_SESSION['id_usuario'])){
    		$c->inserirComentario($_SESSION['id_usuario'], $comentario);
    	}

    	
    	header('location: discussao.php');


    }	


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Sistema de comentarios</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/discussao.css">
	<style type="text/css">
		*{
	margin: 0px;
	padding: 0px;
}

body{
	font-family: arial, sans-serif;
	background-color: #f5f5f5;
}

#largura-pagina{
	width: 85%;
	margin: 0 auto;
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

/* titulo do artigo */

h1{
	padding: 70px 0 25px 0;
	font-size: 27pt;
	line-height: 40pt;
}


/* Conteudo principal */

section#conteudo1{
	width: 60%;
}

/* texto */

p.texto{
	font-size: 15pt;
	color: rgba(0,0,0,.8);
	line-height: 40px;
	margin: 20px 0;
}

/* FORMULARIO */

h2{
	font-family: inherit;
	line-height: 80px;
	margin-bottom: 10px;
}

form img{
	width: 30px;
	display: block;
	float: left;
	padding: 10px;
}

textarea{
	border: none;
	height: 100px;
	width: 85%;
	padding: 7px;
	font-size: 12pt;
	margin: 9px;
	font-family: Arial, Helvetica, sans-serif;
	outline: none;
	display: block;
	float: left;
}

input[type="submit"] {
	font-family: Arial Black, Helvetica, sans-serif;
	width: 220px;
	height: 42px;
	background: white;
	border: 2px solid lightblue;
	color: lightblue;
	cursor: pointer;
	display: block;
	float: right;
}

input[type="submit"]:hover{
	background: lightblue;
	color: #fff;
}

.area-comentario{
	box-sizing: border-box;
	border-bottom: 1px solid gray;
	clear: both;
	padding: 10px;
}

.area-comentario img{
	width: 30px;
	float: left;
	padding-right: 10px;
}

.area-comentario h3{
	float: left;
	color: #555555;
	font-size: 12pt;
	padding: 5px 10px 5px 0px;
}

.area-comentario h4{
	font-size: 10pt;
	color: rgba(0,0,0,.6);
	line-height: 30px;
}

.area-comentario h4 a{
	margin-left: 2%; 
	color: black;
	text-decoration: none;
}

.area-comentario p{
	line-height: 25px;
}






	</style>
</head>
<body>
	<nav>
		<ul>
			<li><a href="index.php">Inicio</a></li>
			<?php
				if(isset($_SESSION['id_master'])){ ?>
					<li><a href="dados.php">Dados</a></li>
				<?php }
				if(isset($_SESSION['id_usuario']) or isset($_SESSION['id_master'])){ ?>
					<li><a href="Sair.php">Sair</a></li>
			<?php }else{ ?>
				<li><a href="entrar.php">Entrar</a></li>
			<?php	}
			?>
			
		</ul>
	</nav>
	<div id="largura-pagina">
		<section id="conteudo1">
			<h1>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h1>
			<p class="texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam leo nisi, tristique lobortis ligula vitae, fermentum dignissim turpis. In ut metus tellus. Praesent malesuada non mi non tincidunt. Suspendisse sit amet elementum urna. Maecenas interdum nisl in auctor ornare. Donec dignissim nibh vitae lectus fringilla molestie. Donec finibus justo ac ante mattis, eu sodales ligula rutrum. Integer vitae mi erat. Cras rutrum turpis sed iaculis interdum. Pellentesque ultricies blandit nulla, non tincidunt est eleifend vitae.</p>

			<?php
				if(!isset($_SESSION['id_usuario']))
				{ ?>
					<h2>Comentarios</h2>

		<?php 	}else
				{ ?>
					<h2>Deixer um comentario</h2> <?php
				} 


			?>

			<?php

				if(isset($_SESSION['id_usuario']) or isset($_SESSION['id_master']))
				{ ?>
					<form action="" method="POST">
						<img src="img/icone-usuario.png" alt="">
						<textarea name="texto" placeholder="Participe da discussão"></textarea>
						<input type="submit" value="Publicar comentario" name="btn-comentar">
					</form>
			<?php } 

			?>

			<?php 
				if(count($coments) > 0) //se tive comentarios do bd
				{
					foreach ($coments as $v)
					{ ?>
						<div class="area-comentario">
							<img src="img/icone-usuario.png">
							<h3><?php echo $v['nome_pessoa']; ?></h3>
							<h4><?php 
									$data = new DateTime($v['dia']);
									echo $data->format('d/m/y');
									echo " - ";
									echo $v['horario'];
								 ?> 
								 <?php
								 if(isset($_SESSION['id_usuario']))
								 {
								 	if($_SESSION['id_usuario'] == $v['pk_id_usuario'])
								 	{ ?>
								 		<a href="discussao.php?id_exc= <?php echo $v['id']; ?>">Excluir</a></h4>
							<?php 	}
								 }elseif(isset($_SESSION['id_master']))
									{ ?>
										<a href="discussao.php?id_exc= <?php echo $v['id']; ?>">Excluir</a></h4>
							<?php	}
								 ?>
							
							<p><?php echo $v['comentario']; ?></p>
						</div>
			<?php 	}
				}else
				{
					echo "Ainda não há comentarios";
				}
			?>

			

		</section>
	</div>

	
	
</body>
</html>
