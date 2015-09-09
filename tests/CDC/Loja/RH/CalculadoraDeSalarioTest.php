<?php

namespace CDC\Loja\RH;

use CDC\Loja\Test\TestCase,
	CDC\Loja\RH\CalculadoraDeSalario,
	CDC\Loja\RH\Funcionario,
	CDC\Loja\RH\TabelaCargos;

class CalculadoraDeSalarioTest extends TestCase
{
	public function testCalculoSalarioDesenvolvedoresComSalarioAbaixoDoLimite()
	{
		$calculadora = new CalculadoraDeSalario();
		$desenvolvedor = new Funcionario('Daniel', 1500.00, 'desenvolvedor');

		$salario = $calculadora->calculaSalario($desenvolvedor);

		$this->assertEquals(1500.00 * 0.9, $salario, null, 0.00001);
	}

	public function testCalculoSalarioDesenvolvedoresComSalarioAcimaDoLimite()
	{
		$calculadora = new CalculadoraDeSalario();
		$desenvolvedor = new Funcionario('Daniel', 4000.00, 'desenvolvedor');

		$salario = $calculadora->calculaSalario($desenvolvedor);

		$this->assertEquals(4000.00 * 0.8, $salario, null, 0.00001);
	}

	public function testDeveCalcularSalarioParaDBAsComSalarioAbaixoDoLimite()
	{
		$calculadora = new CalculadoraDeSalario();
		$dba = new Funcionario('Daniel', 1500.00, 'dba');

		$salario = $calculadora->calculaSalario($dba);

		$this->assertEquals(1500.00 * 0.85, $salario, null, 0.00001);
	}

	public function testDeveCalcularSalarioParaDBAsComSalarioAcimaDoLimite()
	{
		$calculadora = new CalculadoraDeSalario();
		$dba = new Funcionario('Daniel', 4500.00, 'dba');

		$salario = $calculadora->calculaSalario($dba);

		$this->assertEquals(4500.00 * 0.75, $salario, null, 0.00001);
	}
}