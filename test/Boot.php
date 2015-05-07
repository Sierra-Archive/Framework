<?php
// Especifique o caminho do PHPUnit
require_once '/usr/share/php/PHPUnit/Framework.php';


use PHPUnit_Framework_TestCase as PHPUnit;

use Framework\App\Boot;


// Como a classe a ser testada se chama "Classe1", a classe de teste deverá se chamar "ClasseTest" e (neste caso) irá herdar de PHPUnit_Framework_TestCase
class BootTest extends PHPUnit
{

    protected $boot;

    public function setUp(){
        
    }
    public function tearDown(){
        
    }

    // Funções de teste devem ter o prefixo "test"
    public function testSoma()
    {
            // A classe a ser testada é instanciada
            $foo = new Classe1();
            // Testamos a afirmação que "4" é o resultado de passar "2" e "2" (ou seja, 2 + 2 = 4)
            $this->assertEquals('4', $foo->somar(2, 2));
    }
   
    public function testSubtracao()
    {
            // idem (veja função acima)
            $foo = new Classe1();
            $this->assertEquals('0', $foo->subtrair(2, 2));
    }
}
?>