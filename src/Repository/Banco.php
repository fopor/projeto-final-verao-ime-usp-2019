<?php
namespace App\Repository;

use App\Entity\Produto;
use App\Entity\Cliente;

class Banco {
	private function conectaBD() {
		$host = 'localhost';
		$user = 'root';
		$pass = 'senha';
		$base = 'verao-2019';
		$banco = new \mysqli($host, $user, $pass, $base);
		if (\mysqli_connect_errno()) {
			exit("Não foi possível conectar no banco de dados!");
		}

		return $banco;
	}

	private function getResultsBD($strsql) {
		$banco = $this->conectaBD();

		$statement = $banco->prepare($strsql);
		if (!$statement) {
			exit($banco->error);
		}

		if (!$statement->execute()) {
			exit($banco->error);
		}

		$resultados = $statement->get_result();

		return $resultados;
	}

	private function fetchProduto($linha) {
		$produto = new Produto();
		$produto->setId($linha->id);
		$produto->setNome($linha->nome);
		$produto->setDescricao($linha->descricao);
		$produto->setPreco($linha->preco);
		$produto->setEstoque($linha->estoque);
		$produto->setImagem($linha->imagem);

		return $produto;
	}

	private function fetchCliente($linha) {
		$cliente = new Cliente();
		$cliente->setId($linha->id);
		$cliente->setNome($linha->nome);
		$cliente->setEmail($linha->email);
		$cliente->setSenha($linha->senha);

		return $cliente;
	}

	public function getProduto($id) {
		$strsql = "select * from produtos where id = " . (int) $id;
		
		$resultados = $this->getResultsBD($strsql);

		$linha = $resultados->fetch_object();
	
		$produto = $this->fetchProduto($linha);

		return $produto;
	}

	public function getProdutosByCategoria($nome) {
		$nome = trim($nome);
		$strsql = "select p.* from produtos as p
		inner join categorias as c on c.id = p.categoria_id
		where c.nome = '$nome'";

		$resultados = $this->getResultsBD($strsql);
	
		$produtos = array();
		while ($linha = $resultados->fetch_object()) {
			$produtos[] = $this->fetchProduto($linha);
		}

		return $produtos;
	}

	public function login($email, $senha) {
		$senha = md5($senha);
		$strsql = "select * from clientes where email = '$email' and senha = '$senha'";

		$resultados = $this->getResultsBD($strsql);

		$linha = $resultados->fetch_object();
		
		if (!$linha) {
			return false;
		}

		$cliente = $this->fetchCliente($linha);

		return $cliente;
	}

	public function getQtdProdutosRegistrados(){
		$strsql = "SELECT COUNT(*) FROM produtos;";

		$qtdProdutos = $this->getResultsBD($strsql);
		$qtdProdutos = $qtdProdutos->fetch_row();
		$qtdProdutos = $qtdProdutos[0];
		return (int)$qtdProdutos;
	}

	public function getProdutoAleatorios($qtd){
		$strsql = "SELECT * FROM produtos ORDER BY RAND() LIMIT $qtd";

		$resultados = $this->getResultsBD($strsql);

		$produtos = array();
		while ($linha = $resultados->fetch_object()) {
			$produtos[] = $this->fetchProduto($linha);
		}

		return $produtos;
	}

	public function buscaProduto($termoDeBusca) {
		$strsql = "
			SELECT * FROM produtos
			WHERE nome LIKE '%$termoDeBusca%' 
			OR descricao LIKE '%$termoDeBusca%';
		";

		$resultadoQuery = $this->getResultsBD($strsql);

		$resultadoBusca = array();
		while ($linha = $resultadoQuery->fetch_object()) {
			$resultadoBusca[] = $this->fetchProduto($linha);
		}

		return $resultadoBusca;
	}

}
