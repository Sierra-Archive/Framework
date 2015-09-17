<?php
//require_once '../vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/SeleniumTestCase.php';

class NavegadorTest extends PHPUnit_Extensions_SeleniumTestCase
{
    protected function setUp()
    {
        $this->setBrowser('*firefox'); // indicando qual browser ele vai usar
        $this->setBrowserUrl('http://localhost/Framework'); // Qual é a URL que ele vai usar
    }

    public function testTitle()
    {
        $this->open('/'); // Com base no setBrowserURL
        $this->assertTitle('Isto é um teste'); // Verificando se o títuo é este
    }
}
?>