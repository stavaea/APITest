<?php
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/Autoload.php';
require_once 'TestAddAddress.php';
require_once 'TestAddPlanFlower.php';
require_once 'TestAddPoint.php';
require_once 'TestDiscountCode.php';
require_once 'TestDiscountTicket.php';
require_once 'TestExchangeCode.php';
//require_once 'TestGetCate.php';
require_once 'TestGetCourseList.php';
require_once 'TestGetDetailNoteList.php';
require_once 'TestGetFlowers.php';
require_once 'TestGetInfo.php';
require_once 'TestStudentCourse.php';
require_once 'TestStudentGift.php';
require_once 'TestTeacherComment.php';
require_once 'TestUpdateAddress.php';
require_once 'TestUserSign.php';


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
        $this->addTestSuite('TestAddAddress');
        $this->addTestSuite('TestAddPlanFlower');
        $this->addTestSuite('TestAddPoint');
        $this->addTestSuite('TestDiscountCode');
        $this->addTestSuite('TestDiscountTicket');
        $this->addTestSuite('TestExchangeCode');
        //$this->addTestSuite('TestGetCate');
        $this->addTestSuite('TestGetCourseList');
        $this->addTestSuite('TestGetDetailNoteList');
        $this->addTestSuite('TestGetFlowers');
        $this->addTestSuite('TestGetInfo');
        $this->addTestSuite('TestStudentCourse');
        $this->addTestSuite('TestStudentGift');
        $this->addTestSuite('TestTeacherComment');
        $this->addTestSuite('TestUpdateAddress');
        $this->addTestSuite('TestUserSign');
        

    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}