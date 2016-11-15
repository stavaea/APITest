<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';

/**
 * test case.
 */
class TestAuthVerify extends PHPUnit_Framework_TestCase
{
    
    /**
     * Prepares the environment before running a test.
     */
    private $http;
    protected $url='http://api.gn100.com/user/auth/verify';
    
    protected function setUp()
    {
        $this->http =new HttpClass($this->url);
    }
    
    public function testAuthVerifyHttpCodeIsOK()
    {
        $postData['uname'] = "13011165159";
        $postData['password'] = "123456";
        $postData['login_ip']="121.69.7.6";
        $postdata=json_encode($postData,true);
        $this->assertEquals("200", $this->http->HttpPostCode($this->url, $postdata));
    }
   
    public function testAuthVerifyIsSuccess()
    {
       // $url =  'http://api.gn100.com/user/auth/verify';
        $postData['uname'] = "13011165159";
        $postData['password'] = "123456";
        $postData['login_ip']="121.69.7.6";
        $postdata=json_encode($postData,true);
       // $httpPost  = new HttpClass();
        $result = json_decode($this->http->HttpPost($this->url, $postdata),true);
        $this->assertEquals("22410", $result['data']['uid']);
    }
    
    public function testInternationalNumberIsOK()
    {
        $postData['uname'] = "13011165159";
        $postData['password'] = "123456";
        $postData['login_ip']="121.69.7.6";
        $postdata=json_encode($postData,true);
        $result = json_decode($this->http->HttpPost($this->url, $postdata),true);
        $this->assertEquals("22410", $result['data']['uid']);
        
    }
    
    /*
     * errorcode test cases
     */
    
    public function testPhoneNumIsNotExist()
    {
        $postData['uname'] = "17711165159";
        $postData['password'] = "111111";
        $postData['login_ip']="121.69.7.6";
        $postdata=json_encode($postData,true);
        $result = json_decode($this->http->HttpPost($this->url, $postdata),true);
        $this->assertEquals("-3", $result['result']['code']);   
    }
    
    public function testPhoneNumIsError()
    {
        $postData['uname'] = "1771116510000";
        $postData['password'] = "111111";
        $postData['login_ip']="121.69.7.6";
        $postdata=json_encode($postData,true);
        $result = json_decode($this->http->HttpPost($this->url, $postdata),true);
        $this->assertEquals("-1", $result['result']['code']);
    }
    
    public function testPasswordIsError()
    {
        $postData['uname'] = "13011165159";
        $postData['password'] = "100000";
        $postData['login_ip']="121.69.7.6";
        $postdata=json_encode($postData,true);
        $result = json_decode($this->http->HttpPost($this->url, $postdata),true);
        var_dump( json_decode($this->http->HttpPost($this->url, $postdata),true));
        $this->assertEquals("-2", $result['result']['code']);
    }
    

}

