<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestTeacherTaskList extends PHPUnit_Framework_TestCase
{
    static $u="i";
    static $v="2";
    static $url="http://test.gn100.com/interface/teacherTask/TaskList" ;
    static $Token;
    
    
    
    //发布作业查看列表页得到fkTask
    public static function testFkTask()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['uId']='23339';
        $postdata['params']['status']='0';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =TestUserToken::testUserStaticTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);
        $pkTask=$result['result']['data'][0]['days'][0]['pkTask'];
        return $pkTask;
    }
}