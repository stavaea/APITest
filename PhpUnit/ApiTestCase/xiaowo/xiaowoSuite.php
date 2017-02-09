<?php
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/Autoload.php';
require_once 'TestGetAppHome.php';
require_once 'TestCourseAttachList.php';

class xiaowoSuite extends PHPUnit_Framework_TestSuite
{

    /**
     * Constructs the test suite handler.
     */
    public function __construct()
    {
        $this->setName('xiaowoSuite');
        $this->addTestSuite('TestGetAppHome');
        $this->addTestSuite('TestCourseAttachList');
    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}





