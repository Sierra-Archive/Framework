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
namespace Framework\Classes\PhpWord\Tests\Writer\Word2007\Part;

use Framework\Classes\PhpWord\Writer\Word2007;
use Framework\Classes\PhpWord\Writer\Word2007\Part\Footer;

/**
 * Test class for Framework\Classes\PhpWord\Writer\Word2007\Part\Footer
 *
 * @coversDefaultClass \Framework\Classes\PhpWord\Writer\Word2007\Part\Footer
 * @runTestsInSeparateProcesses
 */
class FooterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Write footer
     */
    public function testWriteFooter()
    {
        $imageSrc = __DIR__ . "/../../../_files/images/PhpWord.png";
        $container = new \Framework\Classes\PhpWord\Element\Footer(1);
        $container->addText('');
        $container->addPreserveText('');
        $container->addTextBreak();
        $container->addTextRun();
        $container->addTable()->addRow()->addCell()->addText('');
        $container->addImage($imageSrc);

        $writer = new Word2007();
        $writer->setUseDiskCaching(true);
        $object = new Footer();
        $object->setParentWriter($writer);
        $object->setElement($container);
        $xml = simplexml_load_string($object->write());

        $this->assertInstanceOf('SimpleXMLElement', $xml);
    }
}
