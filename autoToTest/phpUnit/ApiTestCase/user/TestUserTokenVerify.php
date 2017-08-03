<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../BussinessUseCase/TestUserToken.php';
require_once '../func/dbConfig.php';

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
    // protected $uid;
    public function __construct()
    {
        // $this->planid='517';
        // $this->uid="22414";
        global $IP;
        $this->url = "http://" . $IP . "/user/token/verify/";
        $this->tokenClass = new TestUserToken();
        $this->http = new HttpClass();
    }

    public function testTokenVerifyTryCourse($planid = "517")
    {
        $token = $this->tokenClass->testUserTokenGenIsSuccess("22415");
        $requestUrl = $this->url . $token . "/" . $planid;
        $result = json_decode($this->http->HttpApiGet($requestUrl), true);
        $this->assertEquals(1, $result['result']['ok'], 'url:' . $this->url);
        $this->assertEquals("300", $result['result']['try_seconds'], 'url:' . $this->url);
        $this->assertNotContains('reg', json_encode($result), 'url:' . $this->url);
    }

    public function testTokenVerifyRegUser($planid = "1907")
    {
        $token = $this->tokenClass->testUserTokenGenIsSuccess("22415");
        $requestUrl = $this->url . $token . "/" . $planid;
        $result = json_decode($this->http->HttpApiGet($requestUrl), true);
        $this->assertEquals(1, $result['result']['ok'], 'url:' . $this->url);
        $this->assertContains('reg', json_encode($result), 'url:' . $this->url);
        // assertContains
        // $this->assertContains("ok :1",);
    }

    public function testTokenVerifyVisitorWithTryCourse($planid = "517")
    {
        $token = $this->tokenClass->testUserTokenGenVisitor();
        $requestUrl = $this->url . $token . "/" . $planid;
        $result = json_decode($this->http->HttpApiGet($requestUrl), true);
        $this->assertEquals(1, $result['result']['ok'], 'url:' . $this->url);
        $this->assertEquals("300", $result['result']['try_seconds'], 'url:' . $this->url);
        $this->assertNotContains('is_reg', json_encode($result), 'url:' . $this->url);
    }

    public function testTokenVerifyNoTryNoReg($planid = "530")
    {
        $token = $this->tokenClass->testUserTokenGenIsSuccess("22415");
        $requestUrl = $this->url . $token . "/" . $planid;
        $result = json_decode($this->http->HttpApiGet($requestUrl), true);
        $this->assertEquals(- 1, $result['result']['code'], 'url:' . $this->url);
    }
}

