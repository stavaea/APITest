<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

/**
 * test case.
 */
class TestAddCourse extends PHPUnit_Framework_TestCase
{
    private $url;
    private $Http;

    protected function setUp()
    {
        $url='http://test.gn100.com/user/courseAjax/addCourse';
        $this->http = new HttpClass();
    }

    public function testAddCourseFreeAndFiveTeacher()
    {
       $postdata['courseAddToken']=interface_func::GetCourseAddToken();
       $postdata['type']=1;
       $postdata['title']="API免费直播课".date("Y-m-d H:i:s");
     //  $postdata['firstCate']=
    }
}




