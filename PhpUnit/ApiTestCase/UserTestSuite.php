<?php
require_once 'PHPUnit/Framework/TestSuite.php';

/**
 * Static test suite.
 */
class UserTestSuite extends PHPUnit_Framework_TestSuite
{

    /**
     * Constructs the test suite handler.
     */
    public function __construct()
    {
        $this->setName('UserTestSuite');
    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}

