<?php
namespace Framework\Classes;

class SierraTec_ManutencaoTest extends \PHPUnit_Framework_TestCase {
    
    
    /**
     * @var SierraTec_Manutencao
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new SierraTec_Manutencao;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /***********************************
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *                 FUNCOES DE MANUTENCAO,
     * 
     *                  SEMPRE QUE O CODIGO FOR ALTERADO MANUTENCAO RODA

                        E COLOCA AS CONFIGURACOES NECESSARIAS
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::log
     * @todo   Implement testlog().
     */
    public function testlog(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::Manutencao
     * @todo   Implement testManutencao().
     */
    public function testManutencao(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::Atualiza_Dependencia_Banco_De_Dados
     * @todo   Implement testAtualiza_Dependencia_Banco_De_Dados().
     */
    public function testAtualiza_Dependencia_Banco_De_Dados(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
    
    
    /***********************************
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *                 FUNCOES DE ALTERACAO DE CODIGO ESPECIFICAS
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::Alterar_Config
     * @todo   Implement testAlterar_Config().
     */
    public function testAlterar_Config(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
    
    
    /***********************************
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *                 FUNCOES DE VERIFICAÇÂO DE CONSISTENCIA
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::Verificar_Sis_Dao
     * @todo   Implement testVerificar_Sis_Dao().
     */
    public function testVerificar_Sis_Dao(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
    
    
    
    
    /***********************************
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *                 FUNCOES DE LIMPEZA E BACKUP
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */
    

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::BD_Limpar
     * @todo   Implement testBD_Limpar().
     */
    public function testBD_Limpar(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::BD_Backup
     * @todo   Implement testBD_Backup().
     */
    public function testBD_Backup(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
    
    
    
    
    /***********************************
     * 
     * 
     * 
     * 
     *                 FUNCOES DE TRANSFERENCIA DE DOMINIO E ATUALIZACAO   de CONTEUDO
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */
    

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::Tranferencia_DB_Servidor
     * @todo   Implement testTranferencia_DB_Servidor().
     */
    public function testTranferencia_DB_Servidor(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::Atualizacao_Version
     * @todo   Implement testAtualizacao_Version().
     */
    public function testAtualizacao_Version(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
    
    
    
    
    
    
    /***********************************
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *                 FUNCOES DE BUSCA GENERICA EM CODIGO
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::PHP_GetVariavel
     * @todo   Implement testPHP_GetVariavel().
     */
    public function testPHP_GetVariavel(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::Cod_Atualiza_Constante
     * @todo   Implement testCod_Atualiza_Constante().
     */
    public function testCod_Atualiza_Constante(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
    
    

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::PHP_GetClasses
     * @todo   Implement testPHP_GetClasses().
     */
    public function testPHP_GetClasses(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::PHP_GetClasses_Variaveis
     * @todo   Implement testPHP_GetClasses_Variaveis().
     */
    public function testPHP_GetClasses_Variaveis(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::PHP_GetClasses_Metodos
     * @todo   Implement testPHP_GetClasses_Metodos().
     */
    public function testPHP_GetClasses_Metodos(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::PHP_GetFunction
     * @todo   Implement testPHP_GetFunction().
     */
    public function testPHP_GetFunction(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
    
    

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::Cod_Busca_Classes
     * @todo   Implement testCod_Busca_Classes().
     */
    public function testCod_Busca_Classes(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::Cod_Busca_Classes_Metodos
     * @todo   Implement testCod_Busca_Classes_Metodos().
     */
    public function testCod_Busca_Classes_Metodos(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::Cod_Busca_Valor
     * @todo   Implement testCod_Busca_Valor().
     */
    public function testCod_Busca_Valor(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::Cod_Busca_ClassesUsadas
     * @todo   Implement testCod_Busca_ClassesUsadas().
     */
    public function testCod_Busca_ClassesUsadas(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\Classes\SierraTec_Manutencao::Cod_Busca_MetodosUsados
     * @todo   Implement testCod_Busca_MetodosUsados().
     */
    public function testCod_Busca_MetodosUsados(){
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
    
    
    
    
    
    
}