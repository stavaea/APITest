<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestUpdateTask extends PHPUnit_Framework_TestCase
{
    //老师修改作业
    static $u="i";
    static $v="2";
    static $url="http://test.gn100.com/interface/teacherTask/UpdateTask";
    
    //删除图片、标签之后，再添加一张图片、标签，可以一直走
    public static function testUpdate()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkTask']= "18";
        $postdata['params']['uId']= "1";
        $postdata['params']['desc']= "app老师发布作业啊！！！！！";
        $postdata['params']['startTime']= date('Y-m-d H:i:s',strtotime("+2 minute"));
        $postdata['params']['endTime']= date('Y-m-d H:i:s',strtotime("+3 day"));
        $postdata['params']['taskImages'] =  array(
            array(
                'thumbSmall'=>'testf.gn100.com/2,a2f53cc7bdd2',
                'thumbBig'=>'testf.gn100.com/3,a2f66cdf01ad',
                'srcMallWidth'=>'152',
                'srcMallHeight'=>'105'
            )
        );
        $postdata['params']['tags']= array(
            array(
                'name'=>"语文"
            )
        );
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =TestUserToken::testUserStaticTokenGenIsSuccess('1');
        $postdata['token']=$token;
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);
    }
    
}