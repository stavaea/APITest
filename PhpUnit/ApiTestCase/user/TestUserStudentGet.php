<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';

/**
 * test case.
 */
class TestUserStudentGet extends PHPUnit_Framework_TestCase
{

    /**
     * Prepares the environment before running a test.
     */
    private $url;
    private $uid;
    private $http;
    protected function setUp()
    {
        $this->url="http://api.gn100.com//user/student/get/";
        $this->http= new HttpClass();
    }
    
    public function testUserStudentGetInfo($uid="183")
    {
        $httpurl=$this->url.$uid;
        $result=json_decode($this->http->HttpGet($httpurl),true);
        var_dump($result);
        $this->assertNotEmpty($result['data']['thumb_big']);
        $this->assertEquals("majing123",$result['data']['name']);
        $this->assertEquals("0",$result['data']['school_type']);
      
    }
    
    
    public function testUserStudentGetNotExist($uid="173334")
    {
        $httpurl=$this->url.$uid;
        $result=json_decode($this->http->HttpGet($httpurl),true);
        $this->assertEquals("-2",$result['result']['code']);
    }
   

   
}

