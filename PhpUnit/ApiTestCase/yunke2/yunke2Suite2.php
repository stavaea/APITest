<?php
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'TestMain.php';
/**
 * Static test suite.
 */
class yunke2Suite2 extends PHPUnit_Framework_TestSuite
{

    /**
     * Constructs the test suite handler.
     */
    public function __construct()
    {
        $this->setName('yunke2Suite2');
        $this->addTestSuite('TestMain');
    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}

