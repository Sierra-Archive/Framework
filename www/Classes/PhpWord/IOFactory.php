<?php
/**
 * PHPWord
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2014 PHPWord
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt LGPL
 */

namespace Framework\Classes\PhpWord;

use Framework\Classes\PhpWord\Exception\Exception;
use Framework\Classes\PhpWord\Reader\ReaderInterface;
use Framework\Classes\PhpWord\Writer\WriterInterface;

abstract class IOFactory
{
    /**
     * Create new writer
     *
     * @param PhpWord $phpWord
     * @param string $name
     * @return WriterInterface
     * @throws \Framework\Classes\PhpWord\Exception\Exception
     */
    public static function createWriter(PhpWord $phpWord, $name = 'Word2007')
    {
        if ($name !== 'WriterInterface' && !in_array($name, array('ODText', 'RTF', 'Word2007', 'HTML', 'PDF'), true)) {
            throw new Exception("\"{$name}\" is not a valid writer.");
        }

        $fqName = "Framework\Classes\\PhpWord\\Writer\\{$name}";

        return new $fqName($phpWord);
    }

    /**
     * Create new reader
     *
     * @param string $name
     * @return ReaderInterface
     * @throws Exception
     */
    public static function createReader($name = 'Word2007')
    {
        return self::createObject('Reader', $name);
    }

    /**
     * Create new object
     *
     * @param string $type
     * @param string $name
     * @param \Framework\Classes\PhpWord\PhpWord $phpWord
     * @return \Framework\Classes\PhpWord\Writer\WriterInterface|\Framework\Classes\PhpWord\Reader\ReaderInterface
     * @throws \Framework\Classes\PhpWord\Exception\Exception
     */
    private static function createObject($type, $name, $phpWord = null)
    {
        $class = "Framework\Classes\\PhpWord\\{$type}\\{$name}";
        if (class_exists($class) && self::isConcreteClass($class)) {
            return new $class($phpWord);
        } else {
            throw new Exception("\"{$name}\" is not a valid {$type}.");
        }
    }
    /**
     * Loads PhpWord from file
     *
     * @param string $filename The name of the file
     * @param string $readerName
     * @return \Framework\Classes\PhpWord\PhpWord $phpWord
     */
    public static function load($filename, $readerName = 'Word2007')
    {
        /** @var \Framework\Classes\PhpWord\Reader\ReaderInterface $reader */
        $reader = self::createReader($readerName);
        return $reader->load($filename);
    }
    /**
     * Check if it's a concrete class (not abstract nor interface)
     *
     * @param string $class
     * @return bool
     */
    private static function isConcreteClass($class)
    {
        $reflection = new \ReflectionClass($class);
        return !$reflection->isAbstract() && !$reflection->isInterface();
    }
}
