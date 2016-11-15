<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';
/**
 * test case.
 */
class TestMember extends PHPUnit_Framework_TestCase
{

    protected $url;
    public    $http;
    static  $u="i";
    static  $v="2";
    public  $GetToken;
    
    
    protected function setUp()
    {
         $this->url="test.gn100.com/interface/member";
         $this->http = new HttpClass();
         $this->GetToken =new TestUserToken();
    }
    /*
    public function testMemberVerifyIsMemberNodes($oid="469",$uid="3581")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $this->assertNotEmpty($result['result']['userInfo']);
        $this->assertNotEmpty($result['result']['memberList']);
    }
    
 
    public function testMemberOrgNoSetMember($oid="842",$uid="3581")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $this->assertEquals("3002", $result['code']);
    }
   
    
    public function testMemberNomalUserNodes($oid="469",$uid="3566")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
       //todo 是个对象不是个数组，判断为空 $this->assertTrue(empty($result['result']['userInfo']));
    }
  
    
    public function testMemberVerifyAllMemberStop($oid="469",$uid="159")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $this->assertEquals("3002", $result['code']);
        //todo 是个对象不是个数组，判断为空 $this->assertTrue(empty($result['result']['userInfo']));
    }
    
    public function testMemberVerifyUserMemberIsExpired($oid="469",$uid="159")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        //todo 是个对象不是个数组，判断为空 $this->assertTrue(empty($result['result']['userInfo']));
    }
       */
    
    public function testMemberUserOneMemberIsStop($oid="116",$uid="22410")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
      
        //todo 判断返回数据里不包含停用会员
    }
    
    /*
    public function testMemberOidNotExist($oid="469000",$uid="3581")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $this->assertEquals("3002", $result['code']);
        //todo 判断返回数据里不包含停用会员
    }
    
    public function testMemberUidNotExist($oid="469",$uid="358100")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        var_dump($result);
        //todo 正常返回会员类型列表，userInfo为空
    }
    */
    
}

