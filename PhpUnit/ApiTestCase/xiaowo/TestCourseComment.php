<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

/**
 * test case.
 */
class TestCourseDetail extends PHPUnit_Framework_TestCase
{
    protected $url;
    public  $http;
    static  $u="i";
    static  $v="2";
    private $Token;
    
    protected function setUp()
    {
       $this->url="test.gn100.com/interface/course/commentv2";
       $this->http = new HttpClass();
       $this->Token =new TestUserToken();
    }

    public function testCourseCommentVerifyNodes($courseid="480")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("1", $result['result']['page']);
        $this->assertEquals("1", $result['result']['totalPage']);
        $this->assertEquals("3", $result['result']['total']);
        $this->assertNotEmpty($result['result']['data']);
    }
    
    public function testCourseCommentVerifyNoComment($courseid="311")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3002", $result['code']);
    }

    public function testCourseCommentVerifyComments($courseid="283")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
     //   $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
   
    }
    
    public function testCourseCommentCourseidNotExist($courseid="2970030")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="2";
        $postdata['params']['length']="20";
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3002", $result['code']);
    }
  
    public function testCourseCommentCourseidError($courseid="2970")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="2";
        $postdata['params']['length']="100";
        //$postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
       // $result=$this->http->HttpPost($this->url, json_encode($postdata));
      //  $this->assertEquals("3002", $result['code']);
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    }

    /*
    public function testCourseCommentVerifyBasicInfo($courseid="480",$uid="868")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="1";
        $postdata['params']['length']="20";
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->Token->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("http://testf.gn100.com/3,447db337c372", $result['result']['data'][0]['planId']);
        $this->assertEquals("691", $result['result']['data'][0]['commentId']);
        $this->assertEquals("1", $result['result']['data'][0]['userId']);
        $this->assertEquals("0.01", $result['result']['data'][0]['userImage']);
        $this->assertEquals("0.01", $result['result']['data'][0]['content']);
        $this->assertEquals("0.01", $result['result']['data'][0]['score']);
        $this->assertEquals("0.01", $result['result']['data'][0]['studentScore']);
    }
    
    public function testCourseCommentVerifyPage($courseid="480",$uid="868")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']="2";
        $postdata['params']['length']="20";
        $postdata['params']['courseId']=$courseid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->Token->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("3002", $result['code']);
    
        //$this->assertEquals("http://testf.gn100.com/3,447db337c372", $result['result']['data'][0]['thumbMed']);
        //$this->assertEquals("691", $result['result']['data'][0]['courseId']);
        //$this->assertEquals("1", $result['result']['data'][0]['feeType']);
        //$this->assertEquals("0.01", $result['result']['data'][0]['price']);
    }
    */
    
}
