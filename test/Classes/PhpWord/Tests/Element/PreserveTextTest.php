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

use Framework\Classes\PhpWord\Element\PreserveText;

/**
 * Test class for Framework\Classes\PhpWord\Element\PreserveText
 *
 * @runTestsInSeparateProcesses
 */
class PreserveTextTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Create new instance
     */
    public function testConstruct()
    {
        $oPreserveText = new PreserveText();

        $this->assertInstanceOf('Framework\Classes\\PhpWord\\Element\\PreserveText', $oPreserveText);
        $this->assertEquals($oPreserveText->getText(), null);
        $this->assertEquals($oPreserveText->getFontStyle(), null);
        $this->assertEquals($oPreserveText->getParagraphStyle(), null);
    }

    /**
     * Create new instance with style name
     */
    public function testConstructWithString()
    {
        $oPreserveText = new PreserveText('text', 'styleFont', 'styleParagraph');
        $this->assertEquals($oPreserveText->getText(), array('text'));
        $this->assertEquals($oPreserveText->getFontStyle(), 'styleFont');
        $this->assertEquals($oPreserveText->getParagraphStyle(), 'styleParagraph');
    }

    /**
     * Create new instance with array
     */
    public function testConstructWithArray()
    {
        $oPreserveText = new PreserveText(
            'text',
            array('align' => 'center'),
            array('marginLeft' => 600, 'marginRight' => 600, 'marginTop' => 600, 'marginBottom' => 600)
        );
        $this->assertInstanceOf('Framework\Classes\\PhpWord\\Style\\Font', $oPreserveText->getFontStyle());
        $this->assertInstanceOf(
            'Framework\Classes\\PhpWord\\Style\\Paragraph',
            $oPreserveText->getParagraphStyle()
        );
    }
}
