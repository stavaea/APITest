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
         $this->url="test.gn100.com/interface/member/courseList";
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

    /*
    public function testMemberCourseListViewer($memberId="3",$uid="0")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
    //    $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['userId']=$uid;
        $postdata['params']['memberId']=$memberId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
      
        //todo 判断返回数据里不包含停用会员
    }
    
    
    public function testMemberCourseListMemberUser($memberId="3",$uid="269")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
   //     $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['userId']=$uid;
        $postdata['params']['memberId']=$memberId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
        //isMember应=1
    
        //todo 判断返回数据里不包含停用会员
    }
    
    //会员停用，该会员用户查看
    public function testMemberCourseListMemberStop($memberId="5",$uid="23291")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
      //  $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['userId']=$uid;
        $postdata['params']['memberId']=$memberId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //ismember=0
    }
    */
    
    //会员状态正常，会员失效
    public function testMemberCourseListUserExpired($memberId="3",$uid="281")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        //  $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['userId']=$uid;
        $postdata['params']['memberId']=$memberId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //ismember=0
    }
    
    //会员状态正常，user为非会员
    public function testMemberCourseListUserNotMember($memberId="15",$uid="281")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        //  $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='1';
        $postdata['params']['length']='20';
        $postdata['params']['userId']=$uid;
        $postdata['params']['memberId']=$memberId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //ismember=0
    }
    
    //翻页正常
    public function testMemberCourseListVerifyPage($memberId="3",$uid="281")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        //  $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='2';
        $postdata['params']['length']='4';
        $postdata['params']['userId']=$uid;
        $postdata['params']['memberId']=$memberId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //ismember=0
    }
    
    //会员类型不存在
    public function testMemberCourseMemberIdNotExist($memberId="300",$uid="281")
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        //  $postdata['oid']=$oid;
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='2';
        $postdata['params']['length']='4';
        $postdata['params']['userId']=$uid;
        $postdata['params']['memberId']=$memberId;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $token =$this->GetToken->testUserTokenGenIsSuccess($uid);
        $postdata['token']=$token;
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=$this->http->HttpPost($this->url, json_encode($postdata));
        var_dump($result);
    
        //3002
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

