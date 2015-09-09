<?php

namespace CDC\Exemplos;

require './vendor/autoload.php';

use CDC\Exemplos\ConversorDeNumeroRomano;
use PHPUnit_Framework_TestCase as PHPUnit;

class ConversorDeNumeroRomanoTest extends PHPUnit
{
	public function testDeveEntenderOSimboloI()
	{
		$romano = new ConversorDeNumeroRomano();
		$numero = $romano->converte('I');
		$this->assertEquals(1, $numero);
	}

	public function testDeveEntenderOSimboloII()
	{
		$romano = new ConversorDeNumeroRomano();
		$numero = $romano->converte('II');
		$this->assertEquals(2, $numero);
	}

	public function testDeveEntenderOSimboloXXII()
	{
		$romano = new ConversorDeNumeroRomano();
		$numero = $romano->converte('XXII');
		$this->assertEquals(22, $numero);
	}

	public function testDeveEntenderOSimboloIX()
	{
		$romano = new ConversorDeNumeroRomano();
		$numero = $romano->converte('IX');
		$this->assertEquals(9, $numero);
	}

	// public function testDeveEntenderOSimboloXXIV()
	// {
	// 	$romano = new ConversorDeNumeroRomano();
	// 	$numero = $romano->converte('XXIV');
	// 	$this->assertEquals(24, $numero);
	// }
}