<?php
//require_once '../vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/SeleniumTestCase.php';

class NavegadorTest extends PHPUnit_Framework_TestCase //PHPUnit_Extensions_SeleniumTestCase
{
    /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;
    protected $url = 'https://github.com';
    protected function setUp()
    {
        $capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
        $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
        //$this->setBrowser('*firefox'); // indicando qual browser ele vai usar
        //$this->setBrowserUrl('http://localhost/Framework'); // Qual é a URL que ele vai usar
    }

    public function testTitle()
    {
        //$this->open('/'); // Com base no setBrowserURL
        //$this->assertTitle('Isto é um teste'); // Verificando se o títuo é este
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }


    public function testGitHubHome()
    {
        $this->webDriver->get($this->url);
        // checking that page title contains word 'GitHub'
        $this->assertContains('GitHub', $this->webDriver->getTitle());
    } 
    public function tearDown()
    {
        $this->webDriver->close();
    }
}
?>