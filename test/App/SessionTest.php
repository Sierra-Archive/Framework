<?php

namespace Framework\App;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-08-24 at 16:29:43.
 */
class SessionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Session
     */
    protected $object;
    protected $_Registro;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->_Registro    = &\Framework\App\Registro::getInstacia();
        $this->object     = &$this->_Registro->_Session;
        
        // Inicializa Classes caso ainda nao tenham sido
        if($this->object===false){
            $this->_Registro->_Session = new Session();
        }
        $this->object = new Session;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers Framework\App\Session::init
     * @todo   Implement testInit().
     */
    public function testInit() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\App\Session::destroy
     * @todo   Implement testDestroy().
     */
    public function testDestroy() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\App\Session::set
     * @todo   Implement testSet().
     */
    public function testSet() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Framework\App\Session::get
     * @todo   Implement testGet().
     */
    public function testGet() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}