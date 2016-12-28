<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../BussinessUseCase/TestUserToken.php';


/**
 * test case.
 */
class TestUserTokenVerify extends PHPUnit_Framework_TestCase
{ 
    /**
     * Prepares the environment before running a test.
     */
    protected $token;
    protected $tokenClass;
    protected $url;
    protected $http;
    protected $planid;
    //protected $uid;
    
    public function __construct()
    {    
      //  $this->planid='517';
       // $this->uid="22414";
        $url=$this->url="http://api.gn100.com/user/token/verify/";
        $this->tokenClass = new TestUserToken();
        $this->http = new HttpClass();
 
    }
    

    public function testTokenVerifyTryCourse($planid="517")
    {   
        $token =$this->tokenClass->testUserTokenGenIsSuccess("22415");
        $requestUrl=$this->url.$token."/".$planid;
        $result = json_decode($this->http->HttpGet($requestUrl),true);
        $this->assertEquals(1,$result['result']['ok']);
        $this->assertEquals("300",$result['result']['try_seconds']);
        $this->assertNotContains('reg', json_encode($result));
    }
    

    public function testTokenVerifyRegUser($planid="1907")
    {
        $token =$this->tokenClass->testUserTokenGenIsSuccess("22415");
        $requestUrl=$this->url.$token."/".$planid;
        $result = json_decode($this->http->HttpGet($requestUrl),true);
        $this->assertEquals(1,$result['result']['ok']);
        $this->assertContains('reg', json_encode($result));
        // assertContains
        //  $this->assertContains("ok :1",);
    }


   public function testTokenVerifyVisitorWithTryCourse($planid="517")
   {
       $token =$this->tokenClass->testUserTokenGenVisitor();
       $requestUrl=$this->url.$token."/".$planid;
       $result = json_decode($this->http->HttpGet($requestUrl),true);
       $this->assertEquals(1,$result['result']['ok']);
       $this->assertEquals("300",$result['result']['try_seconds']);
       $this->assertNotContains('is_reg', json_encode($result));
   }
   
   public function testTokenVerifyNoTryNoReg($planid="530")
   {
       $token =$this->tokenClass->testUserTokenGenIsSuccess("22415");
       $requestUrl=$this->url.$token."/".$planid;
       $result = json_decode($this->http->HttpGet($requestUrl),true);
       $this->assertEquals(-1,$result['result']['code']);
   }
   
}

