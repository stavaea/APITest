<?php
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/Autoload.php';
require_once 'TestAnnoucement.php';
require_once 'TestCourseClass.php';
require_once 'TestStudentList.php';
require_once 'TestTeacherTable.php';
require_once 'TestTeacherPublishTask.php';
require_once 'TestDeleteImage.php';
require_once 'TestDelTag.php';
require_once 'TestTeacherTaskDetail.php';
require_once 'TestPushMessage.php';
require_once 'TestQuestionType.php';

/**
 * Static test suite.
 */
class yunkeTeacherSuite extends PHPUnit_Framework_TestSuite
{

    /**
     * Constructs the test suite handler.
     */
    public function __construct()
    {
        $this->setName('yunkeTeacherSuite');
        $this->addTestSuite('TestAnnoucement');//老师发布公告
        $this->addTestSuite('TestCourseClass');//作业--课程搜索      
        $this->addTestSuite('TestStudentList');//学生列表
        $this->addTestSuite('TestTeacherTable');//老师课表
        $this->addTestSuite('TestTeacherPublishTask');//老师发布作业
        $this->addTestSuite('TestDeleteImage');//老师在修改作业页面删除图片
        $this->addTestSuite('TestDelTag');//老师在修改作业页面删除标签
        $this->addTestSuite('TestTeacherTaskDetail');//老师作业详情页
        $this->addTestSuite('TestPushMessage');//催交作业
        $this->addTestSuite('TestQuestionType');
    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}

