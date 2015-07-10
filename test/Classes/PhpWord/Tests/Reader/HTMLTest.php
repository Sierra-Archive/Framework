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

namespace Framework\Classes\PhpWord\Tests\Reader;

use Framework\Classes\PhpWord\IOFactory;

/**
 * Test class for Framework\Classes\PhpWord\Reader\HTML
 *
 * @coversDefaultClass \Framework\Classes\PhpWord\Reader\HTML
 * @runTestsInSeparateProcesses
 */
class HTMLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test load
     */
    public function testLoad()
    {
        $filename = __DIR__ . '/../_files/documents/reader.html';
        $phpWord = IOFactory::load($filename, 'HTML');
        $this->assertInstanceOf('Framework\Classes\\PhpWord\\PhpWord', $phpWord);
    }

    /**
     * Test load exception
     *
     * @expectedException \Exception
     * @expectedExceptionMessage Cannot read
     */
    public function testLoadException()
    {
        $filename = __DIR__ . '/../_files/documents/foo.html';
        IOFactory::load($filename, 'HTML');
    }
}
