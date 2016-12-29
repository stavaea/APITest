<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/dbConfig.php';
/**
 * test case.
 */
class TestGetOrgByOwner extends PHPUnit_Framework_TestCase
{

    /**
     * Prepares the environment before running a test.
     */   
    protected function setUp()
    {
        global $IP;
        $this->url="http://".$IP."/user/organization/getOrgByOwner/183";
        $this->http =new HttpClass($this->url);
    }

    public function testRequestHttpCodeIsOk()
    {
        $http = new HttpClass();
        $result = json_decode($http->HttpApiGet($this->url),true);
        $this->assertEquals(116, $result['data']['oid']);
        $this->assertNotEmpty($result['data']['thumb_big']);
        $this->assertNotEmpty($result['data']['hot_type']);
    }
 
 
    public function testGetOrgID()
    {
        $http = new HttpClass();
        $result = json_decode($http->HttpApiGet($this->url),true);
        $this->assertEquals(116, $result['data']['oid']);
    }
    
    public function testGetOrgThumbNotEmpty()
    {
        $http = new HttpClass();
        $result = json_decode($http->HttpApiGet($this->url),true);
        $this->assertNotEmpty($result['data']['thumb_big']);
    }
    
    public function testGetOrgHotTypeNotEmpty()
    {
        $http = new HttpClass();
        $result = json_decode($http->HttpApiGet($this->url),true);
        $this->assertNotEmpty($result['data']['hot_type']);
    }

    
}


