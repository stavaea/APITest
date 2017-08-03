<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

/**
 * test case.
 */
class TestAddComment extends PHPUnit_Framework_TestCase
{
    protected $url;
    public    $http;
    static  $u="i";
    static  $v="2";
    public  $Token;

    Public function __construct()
    {
       $this->url="test.gn100.com/interface/user/addComment";
       $this->http = new HttpClass();
       $this->Token =new TestUserToken();
    }
//todo mysql 数据库存在该评论
    public function testAddCommentSuccess($planId="2629",$uid="23317")
    //public function testAddCommentSuccess($planId="2623",$uid="867")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['planId']=$planId;
        $postdata['params']['uid']=$uid;
        $postdata['params']['content']="api test comment";
        $postdata['params']['satisfaction']="1.0";
        $postdata['params']['conform']="1.0";
        $postdata['params']['expression']="1.0";
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->Token->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals("success", $result['message']);
        $this->assertEquals("0", $result['code']);
    }
    

    
    


}

