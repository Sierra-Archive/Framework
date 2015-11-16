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

namespace Framework\Classes\PhpWord\Writer\Word2007\Part;

use Framework\Classes\PhpWord\Exception\Exception;
use Framework\Classes\PhpWord\Shared\XMLWriter;
use Framework\Classes\PhpWord\Writer\AbstractWriter;

/**
 * Word2007 writer part abstract class
 */
abstract class AbstractPart
{
    /**
     * Parent writer
     *
     * @var \Framework\Classes\PhpWord\Writer\AbstractWriter
     */
    protected $parentWriter;

    /**
     * @var string Date format
     */
    protected $dateFormat = 'Y-m-d\TH:i:sP';

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
        if (!is_null($this->parentWriter)) {
            return $this->parentWriter;
        } else {
            throw new Exception('No parent WriterInterface assigned.');
        }
    }

    /**
     * Get XML Writer
     *
     * @return \Framework\Classes\PhpWord\Shared\XMLWriter
     */
    protected function getXmlWriter()
    {
        $useDiskCaching = FALSE;
        if (!is_null($this->parentWriter)) {
            if ($this->parentWriter->isUseDiskCaching()) {
                $useDiskCaching = TRUE;
            }
        }
        if ($useDiskCaching) {
            return new XMLWriter(XMLWriter::STORAGE_DISK, $this->parentWriter->getDiskCachingDirectory());
        } else {
            return new XMLWriter(XMLWriter::STORAGE_MEMORY);
        }
    }
}
