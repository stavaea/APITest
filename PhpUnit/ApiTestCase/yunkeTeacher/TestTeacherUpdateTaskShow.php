<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestTeacherUpdateTaskShow extends PHPUnit_Framework_TestCase
{
    static $u="i";
    static $v="2";
    static $url="http://dev.gn100.com/interface/teacherTask/UpdateTaskShow";
    
    
    
    //参数正确，返回数据结果
    public static function testUpdateListIsOK($taskId)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uId']='3596';
        $postdata['params']['taskId']=$taskId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =TestUserToken::testUserStaticTokenGenIsSuccess('3596');
        $postdata['token']=$token;
        var_dump(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)));
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);
        self::assertEquals($taskId, $result['result']['data']['pkTask']);
        self::assertEquals('app老师发布作业啊！！！！！', $result['result']['data']['desc']);
        self::assertEquals('http://devf.gn100.com/devf.gn100.com/6,d70804e3d1d6', $result['result']['thumb'][0]['srcBig']);
        self::assertEquals('语文', $result['result']['tag'][0]['name']);
    }
}