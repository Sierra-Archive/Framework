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

namespace Framework\Classes\PhpWord\Writer\HTML\Part;

use Framework\Classes\PhpWord\Exception\Exception;
use Framework\Classes\PhpWord\Writer\AbstractWriter;

/**
 * Abstract HTML part writer
 *
 * @since 0.11.0
 */
abstract class AbstractPart
{
    /**
     * Parent writer
     *
     * @var \Framework\Classes\PhpWord\Writer\AbstractWriter
     */
    private $parentWriter;

    /**
     * Write part
     *
     * @return string
     */
    abstract public function write();

    /**
     * Set parent writer.
     *
     * @param \Framework\Classes\PhpWord\Writer\AbstractWriter $writer
     * @return void
     */
    public function setParentWriter(AbstractWriter $writer = null)
    {
        $this->parentWriter = $writer;
    }

    /**
     * Get parent writer
     *
     * @return \Framework\Classes\PhpWord\Writer\AbstractWriter
     * @throws \Framework\Classes\PhpWord\Exception\Exception
     */
    public function getParentWriter()
    {
        if ($this->parentWriter !== null) {
            return $this->parentWriter;
        } else {
            throw new Exception('No parent WriterInterface assigned.');
        }
    }
}
