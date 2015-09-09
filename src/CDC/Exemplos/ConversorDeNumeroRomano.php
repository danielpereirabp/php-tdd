<?php

namespace CDC\Exemplos;

class ConversorDeNumeroRomano
{
	protected $tabela = [
		'I' => 1,
		'V' => 4,
		'X' => 10,
		'L' => 50,
		'C' => 100,
		'D' => 500,
		'M' => 1000
	];

	public function converte($numeroEmRomano)
	{
		$acumulador = 0;
		$ultimoVizinhoDaDireita = 0;
		for ($i = strlen($numeroEmRomano) - 1; $i >= 0; $i--) { 

			// pega o inteiro referente ao símbolo atual
			$atual = 0;
			$numCorrente = $numeroEmRomano[$i];
			if (array_key_exists($numCorrente, $this->tabela)) {
				$atual = $this->tabela[$numCorrente];
			}

			// se o da direita for menor, o multiplicaremos
			// por -1 para torná-lo negativo
			$multiplicador = 1;
			if ($atual < $ultimoVizinhoDaDireita) {
				$multiplicador = -1;
			}

			$acumulador += ($atual * $multiplicador);

			// atualiza o vizinho da direita
			$ultimoVizinhoDaDireita = $atual;
		}

		return $acumulador;
	}
}