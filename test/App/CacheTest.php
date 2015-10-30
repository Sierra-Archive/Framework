<?php

namespace Framework\App;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-08-24 at 16:29:45.
 */
class CacheTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Cache
     */
    protected $object;
    protected $_Registro;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->_Registro    = &\Framework\App\Registro::getInstacia();
        $this->object     = &$this->_Registro->_Cache;
        
        // Inicializa Classes caso ainda nao tenham sido
        if ($this->object===false) {
            $this->_Registro->_Cache = new Cache();
        }
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers Framework\App\Cache::Ler
     * @todo   Implement testLer().
     */
    public function testLer() {
        $datetime = time();
        $funcional = $this->_Registro->_Cache->Ler('TestLer'.$datetime,false,false);
        $this->assertFalse($funcional);
        $gravar = 'Gravar';
        $this->_Registro->_Cache->Salvar('TestLer'.$datetime,$gravar);
        $funcional = $this->_Registro->_Cache->Ler('TestLer'.$datetime,false,false);
        $this->assertEquals($funcional,$gravar);
        $this->_Registro->_Cache->Deletar('TestLer'.$datetime);
    }

    /**
     * @covers Framework\App\Cache::Salvar
     * @todo   Implement testSalvar().
     */
    public function testSalvar() {
        $datetime = time();
        $gravar = 'Gravar';
        $this->_Registro->_Cache->Salvar('TestGravar'.$datetime,$gravar);
        $funcional = $this->_Registro->_Cache->Ler('TestGravar'.$datetime,false,false);
        $this->assertEquals($funcional,$gravar);
        $this->_Registro->_Cache->Deletar('TestGravar'.$datetime);
    }

    /**
     * @covers Framework\App\Cache::Deletar
     * @todo   Implement testDeletar().
     */
    public function testDeletar() {
        $datetime = time();
        $gravar = 'Gravar';
        $this->_Registro->_Cache->Salvar('TestDeletar'.$datetime,$gravar);
        $this->_Registro->_Cache->Deletar('TestDeletar'.$datetime);
        $funcional = $this->_Registro->_Cache->Ler('TestDeletar'.$datetime,false,false);
        $this->assertFalse($funcional);
    }

}
