<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';

class TestCourseCommentNew extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    static  $u="i";
    static  $v="2";


    protected function setUp()
    {
        //课程评论列表
        $this->url="http://test.gn100.com/interface/course/CommentNew";
        $this->http = new HttpClass();

    }
    //参数正确，返回结果
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']= '1';
        $postdata['params']['length']= '20';
        $postdata['params']['courseId']= '1496';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('userName', $result['result']['data'][0]);
        $this->assertArrayHasKey('userThumb', $result['result']['data'][0]);
        $this->assertArrayHasKey('comment', $result['result']['data'][0]);
        $this->assertArrayHasKey('className', $result['result']['data'][0]);
        $this->assertArrayHasKey('time', $result['result']['data'][0]);
        $this->assertArrayHasKey('sectionName', $result['result']['data'][0]);
        $this->assertArrayHasKey('studentScore', $result['result']['data'][0]);
        $this->assertArrayHasKey('replay', $result['result']['data'][0]);
    }




    //必传参数为空，返回结果
    public function testParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']= '1';
        $postdata['params']['length']= '20';
        $postdata['params']['courseId']= '';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);

        $this->assertEquals('1000', $result['code']);//请求参数为空

    }
}