<?php
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/Autoload.php';
require_once 'TestGetAppHome.php';
require_once 'TestCourseAttachList.php';
require_once 'TestSearchGettag.php';
require_once 'TestSearchCourse.php';

class xiaowoSuite extends PHPUnit_Framework_TestSuite
{

    /**
     * Constructs the test suite handler.
     */
    public function __construct()
    {
        $this->setName('xiaowoSuite');
        $this->addTestSuite('TestGetAppHome'); //小沃首页
        $this->addTestSuite('TestCourseAttachList');  //课程详情附件
        $this->addTestSuite('TestSearchGettag');  //定制兴趣分类
        $this->addTestSuite('TestSearchCourse');  //课程搜索
    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}





