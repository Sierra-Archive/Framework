<?php

require_once("..".DS."www".DS."Lib".DS."autoload.php");

use \Kevintweber\PhpunitMarkupValidators\Assert\AssertHTML5;

class HtmlTest extends PHPUnit_Framework_TestCase
{
    public function testHTMLValidation()
    {
        AssertHTML5::isValidMarkup("<div>Whoa</div>", "Optional custom message.");
    }
}
?>