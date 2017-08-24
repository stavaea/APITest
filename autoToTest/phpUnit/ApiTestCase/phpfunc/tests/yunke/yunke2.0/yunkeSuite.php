<?php
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/Autoload.php';
require_once 'TestMain.php';
require_once 'TestCourseDetail.php';
require_once 'TestLive.php';
require_once 'TestLiveListInfo.php';
require_once 'TestMainFamousTeacher.php';
//require_once 'TestNotCommitList.php';
require_once 'TestNote.php';
require_once 'TestSetFav.php';
require_once 'TestStudentTaskDetail.php';
require_once 'TestStudentTaskList.php';
require_once 'TestTaskShow.php';
require_once 'TestTeacherComment.php';
require_once 'TestTeacherInfo.php';
require_once 'TestTeacherPoint.php';
require_once 'TestTeacherSearch.php';
require_once 'TestUserInfo.php';
require_once 'TestUserSign.php';
require_once 'TestKeywordsTearchSearch.php';

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
        $this->addTestSuite('TestMain');
        $this->addTestSuite('TestCourseDetail');
        $this->addTestSuite('TestLive');
        $this->addTestSuite('TestLiveListInfo');
        $this->addTestSuite('TestMainFamousTeacher');
        //$this->addTestSuite('TestNotCommitList');
        $this->addTestSuite('TestNote');
        $this->addTestSuite('TestSetFav');
        $this->addTestSuite('TestStudentTaskDetail');
        $this->addTestSuite('TestStudentTaskList');
        $this->addTestSuite('TestTaskShow');
        $this->addTestSuite('TestTeacherComment');      
        $this->addTestSuite('TestTeacherInfo');
        $this->addTestSuite('TestTeacherPoint');
        $this->addTestSuite('TestTeacherSearch');
        $this->addTestSuite('TestKeywordsTearchSearch');
      //  $this->addTestSuite('TestUserSign');
        $this->addTestSuite('TestUserInfo');
    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}

