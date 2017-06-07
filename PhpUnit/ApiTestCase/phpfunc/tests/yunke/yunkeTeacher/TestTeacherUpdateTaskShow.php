<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestTeacherUpdateTaskShow extends PHPUnit_Framework_TestCase
{
    static $u="i";
    static $v="2";
    static $url="http://test.gn100.com/interface/teacherTask/UpdateTaskShow";
    
    
    
    //参数正确，返回数据结果
    public static function testUpdateListIsOK($taskId)
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uId']='23339';
        $postdata['params']['taskId']=$taskId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =TestUserToken::testUserStaticTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        //var_dump(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)));
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);
        $db="db_tag";
        $sql = "select name from t_tag where pk_tag=(SELECT fk_tag FROM t_mapping_tag_task WHERE fk_task=$taskId)
        ;";
        $ad=interface_func::ConnectDB($db, $sql);
        self::assertEquals($taskId, $result['result']['data']['pkTask']);
        self::assertEquals('app老师发布作业啊！！！！！', $result['result']['data']['desc']);
        self::assertEquals('http://testf.gn100.com/testf.gn100.com/6,d70804e3d1d6', $result['result']['thumb'][0]['srcBig']);
        if($ad!=null)
        {
        self::assertEquals('语文',$ad[0][0]);
        }
    }
    
    
    //参数正确，将图片信息返回
     public static function testReturnImage()
     {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uId']='23339';
        $postdata['params']['taskId']='147';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =TestUserToken::testUserStaticTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        //var_dump(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)));
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);

        return $result['result']['thumb'];
    }
    
    
    
    //参数正确，将标签信息返回
    public static function testReturnTag()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uId']='23339';
        $postdata['params']['taskId']='147';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =TestUserToken::testUserStaticTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        //var_dump(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)));
        $result=json_decode(HttpClass::HttpStaticPost(self::$url, json_encode($postdata)),true);
        return $result['result']['tag'];
    }
}