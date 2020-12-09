<?php

class Usuario{

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


	//cadastrar
	public function Cadastrar($nome,$email,$senha){

		//Antes de cadastrar, verificar se o email ja foi cadastrado
		$cmd = $this->pdo->prepare("SELECT id FROM usuarios WHERE email = :e");
		$cmd->bindValue(":e",$email);
		$cmd->execute();

		if($cmd->rowCount() > 0) // se veio um id
		{
			return false;
		}else{ // nao veio o id
			//cadastrar
			$cmd = $this->pdo->prepare("INSERT INTO usuarios (nome,email,senha)
										VALUES (:n,:e,:s)");
			$cmd->bindValue(":n",$nome);
			$cmd->bindValue(":e",$email);
			$cmd->bindValue(":s",md5($senha));
			$cmd->execute();

			return true;
		}
	}


	//logar
	public function Logar($email,$senha){

		$cmd = $this->pdo->prepare("SELECT * FROM usuarios WHERE
		 							email = :e AND senha = :s");
		$cmd->bindValue(":e", $email);
		$cmd->bindValue(":s", md5($senha));
		$cmd->execute();

		if($cmd->rowCount() > 0){ //se foi encontrado a pessoa

			$dados = $cmd->fetch();
			session_start();
			if($dados['id'] == 1){
				$_SESSION['id_master'] = 1;
			}else{
				$_SESSION['id_usuario'] = $dados['id'];
			}
			return true;
		}else{
			return false;
		}	

	}

	public function BuscarDados($id){
		$cmd = $this->pdo->prepare("SELECT * FROM usuarios WHERE id= :i");
		$cmd->bindValue(':i', $id);
		$cmd->execute();
		$dados = $cmd->fetch();
		return $dados;
	}

	public function buscarTodosUser(){
		$cmd = $this->pdo->prepare("
				SELECT usuarios.id,usuarios.nome,usuarios.email,
				COUNT(comentarios.id) as 'quantidade'
				FROM usuarios
				LEFT JOIN comentarios
				on usuarios.id = comentarios.pk_id_usuario
				GROUP by usuarios.id
			");
		$cmd->execute();
		$dados = $cmd->fetchALL(PDO::FETCH_ASSOC);
		return $dados;
	}


}