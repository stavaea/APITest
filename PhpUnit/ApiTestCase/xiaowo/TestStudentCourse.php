<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

/**
 * test case.
 */
class TestStudentCourse extends PHPUnit_Framework_TestCase
{
    private  $url;
    private  $http;
    private $GenToken;
    static  $u="i";
    static  $v="2";
    public  $uid;
    protected function setUp()
    {
        $this->url="test.gn100.com/interface/org/studentCourse";
        $this->http = new HttpClass();
        $this->GenToken =new TestUserToken();
        
    }
    // todo 获取个人中心报名课程数，select count(*) from t_course_user where fk_user=22410 and fk_user_owner=183;
    
    /*
    public function testStudentCourseVerifyPage($oid="116",$uid="22410")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="5";
        $postdata['params']['length']="30";
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GenToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result =$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }
  
   
    public function testStudentCourseVerifyFields($oid="116",$uid="22411")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GenToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result =$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }
      
    
    public function testStudentCourseFields($oid="116",$uid="22410")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="2";
        $postdata['params']['length']="30";
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GenToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result =$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }
    */
    
    public function testStudentCourseFields($oid="214",$uid="22410")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GenToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result =$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }
    
}

