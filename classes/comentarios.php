<?php 
date_default_timezone_set('America/Sao_Paulo');

class Comentario{

	private $pdo;

	//Construtor
	public function __construct($dbname, $host, $usuario, $senha){

		try{

			$this->pdo = new PDO("mysql: host=".$host.";dbname=".$dbname,$usuario,$senha);

		} catch(PDOException $e){

			echo "Erro DB: ".$e->getCode()." Mensagem: ".$e->getMessage();

		} catch(Exception $e){

			echo "Erro: ".$e->getCode()." Mensagem: ".$e->getMessage();

		}
	}


	public function buscarComentarios(){

		$cmd = $this->pdo->prepare("
			SELECT *,
			(SELECT nome FROM usuarios WHERE id = pk_id_usuario) as nome_pessoa
		 	FROM comentarios ORDER BY id DESC
		 ");
		$cmd->execute();
		$dados = $cmd->fetchALL(PDO::FETCH_ASSOC);
		return $dados;
		// todas as colunas de comentarios e tambem a colona nome de usuarios

	}

	public function excluirComentarios($id_comentario,$id_usuario){

		if($id_usuario == 1){

			$cmd = $this->pdo->prepare("DELETE FROM comentarios WHERE id = :ic");
			$cmd->bindValue(":ic", $id_comentario);
			$cmd->execute();

		}else{

			$cmd = $this->pdo->prepare("DELETE FROM comentarios WHERE id = :ic AND pk_id_usuario = :iu");
			$cmd->bindValue(":ic", $id_comentario);
			$cmd->bindValue(":iu", $id_usuario);
			$cmd->execute();

		}


	}

	public function inserirComentario($id_pessoa, $comentario)
	{
		$cmd = $this->pdo->prepare("INSERT INTO comentarios (comentario,dia,horario,pk_id_usuario)
			VALUES (:c,:d,:h,:id_u)");
		$cmd->bindValue(":c",$comentario);
		$cmd->bindValue(":d",date("Y-m-d"));
		$cmd->bindValue(":h",date("H:i"));
		$cmd->bindValue(":id_u",$id_pessoa);
		$cmd->execute();
	}

}

?>