<?php

namespace CDC\Loja\FluxoDeCaixa;

use CDC\Loja\Test\TestCase,
	CDC\Loja\FluxoDeCaixa\GeradorDeNotaFiscal,
	CDC\Exemplos\RelogioDoSistema;

use Mockery;

class GeradorDeNotaFiscalTest extends TestCase
{
	// public function testDeveGerarNFComValorDeImpostoDescontado()
	// {
	// 	$dao = Mockery::mock('CDC\Loja\FluxoDeCaixa\NFDao');
	// 	$dao->shouldReceive('persiste')->andReturn(true);

	// 	$sap = Mockery::mock('CDC\Loja\FluxoDeCaixa\SAP');
	// 	$sap->shouldReceive('envia')->andReturn(true);

	// 	$gerador = new GeradorDeNotaFiscal($dao, $sap);
	// 	$pedido = new Pedido('Daniel', 1000, 1);

	// 	$nf = $gerador->gera($pedido);

	// 	$this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);
	// }

	// public function testDevePersistirNFGerada()
	// {
	// 	$dao = Mockery::mock('CDC\Loja\FluxoDeCaixa\NFDao');
	// 	$dao->shouldReceive('persiste')->andReturn(true);

	// 	$sap = Mockery::mock('CDC\Loja\FluxoDeCaixa\SAP');
	// 	$sap->shouldReceive('envia')->andReturn(true);

	// 	$gerador = new GeradorDeNotaFiscal($dao, $sap);
	// 	$pedido = new Pedido('Daniel', 1000, 1);

	// 	$nf = $gerador->gera($pedido);

	// 	$this->assertTrue($dao->persiste());
	// 	$this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);
	// }

	// public function testDeveEnviarNFGeradaParaSAP()
	// {
	// 	$dao = Mockery::mock('CDC\Loja\FluxoDeCaixa\NFDao');
	// 	$dao->shouldReceive('persiste')->andReturn(true);

	// 	$sap = Mockery::mock('CDC\Loja\FluxoDeCaixa\SAP');
	// 	$sap->shouldReceive('envia')->andReturn(true);

	// 	$gerador = new GeradorDeNotaFiscal($dao, $sap);
	// 	$pedido = new Pedido('Daniel', 1000, 1);

	// 	$nf = $gerador->gera($pedido);

	// 	$this->assertTrue($sap->envia());
	// 	$this->assertEquals(1000 * 0.94, $nf->getValor(), null, 0.00001);
	// }

	public function testDeveInvocarAcoesPosteriores()
	{
		$acao1 = Mockery::mock('CDC\Loja\FluxoDeCaixa\AcaoAposGerarNotaInterface');
		$acao1->shouldReceive('executa')->andReturn(true);

		$acao2 = Mockery::mock('CDC\Loja\FluxoDeCaixa\AcaoAposGerarNotaInterface');
		$acao2->shouldReceive('executa')->andReturn(true);

		$relogio = Mockery::mock('CDC\Exemplos\RelogioInterface');
		$relogio->shouldReceive('hoje')->andReturn(new \DateTime());

		$tabela = Mockery::mock('CDC\Loja\Tributos\TabelaInterface');
		$tabela->shouldReceive('paraValor')->with(1000.00)->andReturn(0.2);

		$gerador = new GeradorDeNotaFiscal(array($acao1, $acao2), $relogio, $tabela);
		$pedido = new Pedido('Daniel', 1000, 1);

		$nf = $gerador->gera($pedido);

		$this->assertTrue($acao1->executa($nf));
		$this->assertTrue($acao2->executa($nf));
		$this->assertNotNull($nf);
		$this->assertInstanceOf('CDC\Loja\FluxoDeCaixa\NotaFiscal', $nf);
	}

	public function testDeveConsultarATabelaParaCalcularValor()
	{
		// mockando uma tabela, que ainda nem existe
		$tabela = Mockery::mock('CDC\Loja\Tributos\TabelaInterface');

		// definindo o futuro comportamento "paraValor",
		// que deve retornar 0.2 caso seja 1000.00
		$tabela->shouldReceive('paraValor')->with(1000.00)->andReturn(0.2);

		$gerador = new GeradorDeNotaFiscal(array(), new RelogioDoSistema(), $tabela);
		$pedido = new Pedido('Daniel', 1000, 1);

		$nf = $gerador->gera($pedido);

		// garantindo que a tabela foi consultada
		$this->assertEquals(1000 * 0.8, $nf->getValor(), null, 0.00001);
	}
}