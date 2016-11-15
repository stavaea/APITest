<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';

/**
 * test case.
 */
class TestGetOrgByOwner extends PHPUnit_Framework_TestCase
{

    /**
     * Prepares the environment before running a test.
     */   

    public function testRequestHttpCodeIsOk()
    {
        $url='http://api.gn100.com/user/organization/getOrgByOwner/183';
        $http = new HttpClass();
        //$result = json_decode($http ->HttpGet($url),true);
        $this->assertEquals(200, $http->HttpGetCode($url));
        $result = json_decode($http->HttpGet($url),true);
        $this->assertEquals(116, $result['data']['oid']);
        $this->assertNotEmpty($result['data']['thumb_big']);
        $this->assertNotEmpty($result['data']['hot_type']);
    }
    public function testGetOrgID()
    {
        $url='http://api.gn100.com/user/organization/getOrgByOwner/183';
        $http = new HttpClass();
        $result = json_decode($http->HttpGet($url),true);
        $this->assertEquals(116, $result['data']['oid']);
    }
    
    public function testGetOrgThumbNotEmpty()
    {
        $url='http://api.gn100.com/user/organization/getOrgByOwner/183';
        $http = new HttpClass();
        $result = json_decode($http->HttpGet($url),true);
        $this->assertNotEmpty($result['data']['thumb_big']);
    }
    
    public function testGetOrgHotTypeNotEmpty()
    {
        $url='http://api.gn100.com/user/organization/getOrgByOwner/183';
        $http = new HttpClass();
        $result = json_decode($http->HttpGet($url),true);
        $this->assertNotEmpty($result['data']['hot_type']);
    }
    
}


