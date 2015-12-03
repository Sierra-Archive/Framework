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

namespace Framework\Classes\PhpWord\Writer\Word2007\Element;

use Framework\Classes\PhpWord\Element\AbstractContainer as ContainerElement;
use Framework\Classes\PhpWord\Element\AbstractElement as Element;
use Framework\Classes\PhpWord\Element\TextBreak as TextBreakElement;
use Framework\Classes\PhpWord\Shared\XMLWriter;

/**
 * Container element writer (section, textrun, header, footnote, cell, etc.)
 *
 * @since 0.11.0
 */
class Container extends AbstractElement
{
    /**
     * Namespace; Can't use __NAMESPACE__ in inherited class (ODText)
     *
     * @var string
     */
    protected $namespace = 'Framework\Classes\\PhpWord\\Writer\\Word2007\\Element';

    /**
     * Write element.
     *
     * @return void
     */
    public function write()
    {
        $container = $this->getElement();
        if (!$container instanceof ContainerElement) {
            return;
        }
        $containerClass = substr(get_class($container), strrpos(get_class($container), '\\') + 1);
        $withoutP = in_array($containerClass, array('TextRun', 'Footnote', 'Endnote', 'ListItemRun')) ? true : false;
        $xmlWriter = $this->getXmlWriter();

        // Loop through elements
        $elements = $container->getElements();
        $elementClass = '';
        foreach ($elements as $element) {
            $elementClass = $this->writeElement($xmlWriter, $element, $withoutP);
        }

        // Special case for Cell: They have to contain a w:p element at the end.
        // The $elementClass contains the last element name. If it's empty string
        // or Table, the last element is not w:p
        $writeLastTextBreak = ($containerClass == 'Cell') && ($elementClass == '' || $elementClass == 'Table');
        if ($writeLastTextBreak) {
            $writerClass = $this->namespace . '\\TextBreak';
            /** @var \Framework\Classes\PhpWord\Writer\Word2007\Element\AbstractElement $writer Type hint */
            $writer = new $writerClass($xmlWriter, new TextBreakElement(), $withoutP);
            $writer->write();
        }
    }

    /**
     * Write individual element
     *
     * @param \Framework\Classes\PhpWord\Shared\XMLWriter $xmlWriter
     * @param \Framework\Classes\PhpWord\Element\AbstractElement $element
     * @param bool $withoutP
     * @return string
     */
    private function writeElement(XMLWriter $xmlWriter, Element $element, $withoutP)
    {
        $elementClass = substr(get_class($element), strrpos(get_class($element), '\\') + 1);
        $writerClass = $this->namespace . '\\' . $elementClass;

        if (class_exists($writerClass)) {
            /** @var \Framework\Classes\PhpWord\Writer\Word2007\Element\AbstractElement $writer Type hint */
            $writer = new $writerClass($xmlWriter, $element, $withoutP);
            $writer->write();
        }

        return $elementClass;
    }
}
