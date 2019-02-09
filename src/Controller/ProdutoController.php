<?php
namespace App\Controller;

use App\Entity\Produto;
use App\Repository\Banco;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ProdutoController extends AbstractController {
	/**
	* @Route("/produto/{id}")
	*/
	public function view($id) {
		$banco = new Banco();
		$produto = $banco->getProduto($id);
		
		return $this->render('produto/detalhes-produtos.html.twig', [
			'produto' => $produto		    
		]);
	}

	/**
	* @Route("/categoria/{nome}")
	*/
	public function categoria($nome) {
		$banco = new Banco();
		$produtos = $banco->getProdutosByCategoria($nome);
		$nomeFormatado = $nome;
		$nomeFormatado = trim($nomeFormatado);
		$nomeFormatado = strtolower($nomeFormatado);
		$nomeFormatado = ucfirst($nomeFormatado);

		return $this->render('produto/categoria.html.twig', [
			'produtos' => $produtos,
			'nomeDaCategoria' => $nomeFormatado
		]);
	}

	/**
	* @Route("/busca")
	*/
	public function buscar(Request $request) {
		$termoDeBusca = $request->request->get('busca', '');

		if($termoDeBusca == '') {
			return $this->render('produto/erroAoBuscar.html.twig', [
				'DescricaoErro' => "Nada foi procurado!"
			]);
		}

		$banco = new Banco();
		$produtosEncontrados = $banco->buscaProduto($termoDeBusca);

		if(count($produtosEncontrados) == 0) {
			return $this->render('produto/erroAoBuscar.html.twig', [
				'DescricaoErro' => "Nenhum item correspondente encontrado!"
			]);
		}

		return $this->render('produto/buscar.html.twig', [
			'termoDeBusca' => $termoDeBusca,
			'produtosEncontrados' => $produtosEncontrados
		]);

	}


	
}
