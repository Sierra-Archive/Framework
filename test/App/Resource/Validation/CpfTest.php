<?php
namespace Framework\App\Resource\Validation;

/**
 * @group Logic
 */
class CpfTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var Cpf
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new \Framework\App\Resource\Validation\Cpf();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers Framework\App\Resource\Validation\Cpf::Validates
     * @todo   Implement testValidates().
     */
    public function testValidates() {     
        $this->assertEquals(true, \Framework\App\Resource\Validation\Cpf::Validates('132.782.017-01'));
        $this->assertEquals(false, \Framework\App\Resource\Validation\Cpf::Validates('13278201701'));
        $this->assertEquals(false, \Framework\App\Resource\Validation\Cpf::Validates('132.782.017-02'));
        $this->assertEquals(false, \Framework\App\Resource\Validation\Cpf::Validates('13278201702')); 
    }  
    

    /**
     * @covers Framework\App\Resource\Validation\Cpf::calcDigVerif
     * @todo   Implement testcalcDigVerif().
     */
    public function testGenerate() {
        $generation = \Framework\App\Resource\Validation\Cpf::Generate();
        $this->assertEquals(true, \Framework\App\Resource\Validation\Cpf::Validates($generation),'Falha no 1 Teste: '.$generation); 
        $generation = \Framework\App\Resource\Validation\Cpf::Generate();
        $this->assertEquals(true, \Framework\App\Resource\Validation\Cpf::Validates($generation),'Falha no 2 Teste: '.$generation); 
        $generation = \Framework\App\Resource\Validation\Cpf::Generate();
        $this->assertEquals(true, \Framework\App\Resource\Validation\Cpf::Validates($generation),'Falha no 3 Teste: '.$generation); 
        $generation = \Framework\App\Resource\Validation\Cpf::Generate();
        $this->assertEquals(true, \Framework\App\Resource\Validation\Cpf::Validates($generation),'Falha no 4 Teste: '.$generation); 
    }    

}  
?>