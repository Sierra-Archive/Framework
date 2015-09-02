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

namespace Framework\Classes\PhpWord\Tests\Shared;

use Framework\Classes\PhpWord\Settings;
use Framework\Classes\PhpWord\Shared\XMLWriter;

/**
 * Test class for Framework\Classes\PhpWord\Shared\XMLWriter
 */
class XMLWriterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test method exception
     *
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Method 'foo' does not exists.
     */
    public function testCallException()
    {
        Settings::setCompatibility(false);
        $object = new XMLWriter();
        $object->foo();
    }
}
