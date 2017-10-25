<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
//require_once '../BussinessUseCase/TestUserToken.php';

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
        $postdata['params']['uId']='2';
        $postdata['params']['status']='0';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
		$token = interfaceFunc::testUserTokenGenIsSuccess(2);
        $postdata['token']=$token;
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);
        $pkTask=$result['result']['data'][0]['days'][0]['pkTask'];
        return $pkTask;
    }
    
    //待批改作业
    public static function testFkTask2()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['uId']='2';
        $postdata['params']['status']='1';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
		$token = interfaceFunc::testUserTokenGenIsSuccess(2);
        $postdata['token']=$token;
        //var_dump('url:'.self::$url.'   Post data:'.json_encode($postdata));
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);
		//print_r($result);die;
        //$pkTask=$result['result']['data'][0]['days'][0]['pkTask'];
        //return $pkTask;
        return $result;
    }
    
    public static function testFkTask3()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='2';
        $postdata['params']['uId']='2';
        $postdata['params']['status']='3';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
		$token = interfaceFunc::testUserTokenGenIsSuccess(2);
        $postdata['token']=$token;
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);
        $pkTask=$result['result']['data'][0]['days'][0]['pkTask'];
        var_dump('url:'.self::$url.'   Post data:'.json_encode($postdata));
        return $pkTask;
    }
}