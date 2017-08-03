<?php
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/Autoload.php';
require_once 'TestFamousList.php';
require_once 'TestHomeV3.php';
require_once 'TestInterest.php';
require_once 'TestOrgCourseList.php';
require_once 'TestOrgList.php';
require_once 'TestOrgTeacherList.php';

/**
 * Static test suite.
 */
class yunkeSuite extends PHPUnit_Framework_TestSuite
{

    /**
     * Constructs the test suite handler.
     */
    public function __construct()
    {
        $this->setName('yunkeSuite');
        $this->addTestSuite('TestFamousList');
        $this->addTestSuite('TestHomeV3');
        $this->addTestSuite('TestInterest');
        $this->addTestSuite('TestOrgCourseList');
        $this->addTestSuite('TestOrgList');
        $this->addTestSuite('TestOrgTeacherList');
        
    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}