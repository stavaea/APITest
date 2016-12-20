<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestCourseDetail extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    static $db="db_course";
    private $GetToken;
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/course/detail";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['courseId']='4101';
        $postdata['params']['uid']='3596';//3596
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals(0, $result['code']);
    }
}