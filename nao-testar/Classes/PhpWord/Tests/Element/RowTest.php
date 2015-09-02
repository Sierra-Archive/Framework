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

namespace Framework\Classes\PhpWord\Tests\Element;

use Framework\Classes\PhpWord\Element\Row;

/**
 * Test class for Framework\Classes\PhpWord\Element\Row
 *
 * @coversDefaultClass \Framework\Classes\PhpWord\Element\Row
 * @runTestsInSeparateProcesses
 */
class RowTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Create new instance
     */
    public function testConstruct()
    {
        $oRow = new Row();

        $this->assertInstanceOf('Framework\Classes\\PhpWord\\Element\\Row', $oRow);
        $this->assertEquals($oRow->getHeight(), null);
        $this->assertInternalType('array', $oRow->getCells());
        $this->assertCount(0, $oRow->getCells());
        $this->assertInstanceOf('Framework\Classes\\PhpWord\\Style\\Row', $oRow->getStyle());
    }

    /**
     * Create new instance with parameters
     */
    public function testConstructWithParams()
    {
        $iVal = rand(1, 1000);
        $oRow = new Row($iVal, array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF'));

        $this->assertEquals($oRow->getHeight(), $iVal);
        $this->assertInstanceOf('Framework\Classes\\PhpWord\\Style\\Row', $oRow->getStyle());
    }

    /**
     * Add cell
     */
    public function testAddCell()
    {
        $oRow = new Row();
        $element = $oRow->addCell();

        $this->assertInstanceOf('Framework\Classes\\PhpWord\\Element\\Cell', $element);
        $this->assertCount(1, $oRow->getCells());
    }
}
