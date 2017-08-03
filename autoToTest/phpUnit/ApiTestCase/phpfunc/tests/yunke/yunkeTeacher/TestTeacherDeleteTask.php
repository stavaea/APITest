<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestTeacherDeleteTask extends PHPUnit_Framework_TestCase
{
    static $u="i";
    static $v="2";
    static $url="http://test.gn100.com/interface/teacherTask/DeleteTask" ;
    static $fkTask;
    
    
    //删除作业(未发布的作业)
    public static function testDeleteTask($pkTask)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkTask']=$pkTask;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);
        self::assertEquals('0', $result['code']);
    }
}