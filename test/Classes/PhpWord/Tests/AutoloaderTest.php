<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2014 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace Framework\Classes\PhpWord\Tests;

use Framework\Classes\PhpWord\Autoloader;

/**
 * Test class for Framework\Classes\PhpWord\Autoloader
 *
 * @runTestsInSeparateProcesses
 */
class AutoloaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Register
     */
    public function testRegister()
    {
        Autoloader::register();
        $this->assertContains(
            array('Framework\\Classes\\PhpWord\\Autoloader', 'autoload'),
            spl_autoload_functions()
        );
    }

    /**
     * Autoload
     */
    public function testAutoload()
    {
        $declaredCount = count(get_declared_classes());
        Autoloader::autoload('Foo');
        $this->assertCount(
            $declaredCount,
            get_declared_classes(),
            'Framework\\Classes\\PhpWord\\Autoloader::autoload() is trying to load ' .
            'classes outside of the Framework\Classes\\PhpWord namespace'
        );
        // TODO change this class to the main PhpWord class when it is namespaced
        Autoloader::autoload('Framework\\Classes\\PhpWord\\Exception\\InvalidStyleException');
        $this->assertTrue(
            in_array('Framework\\Classes\\PhpWord\\Exception\\InvalidStyleException', get_declared_classes()),
            'Framework\\Classes\\PhpWord\\Autoloader::autoload() failed to autoload the ' .
            'Framework\\Classes\\PhpWord\\Exception\\InvalidStyleException class'
        );
    }
}
