<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';

/**
 * test case.
 */
class TestGetUserIdSubDomain extends PHPUnit_Framework_TestCase
{
private $url;
private $http;
  
    Public function testGetUserIdBySubDomain()
    {
        $url ="http://api.gn100.com/user/organization/GetUserIdBySubDomain/";
        $postData['subdomain']="hye1.gn100.com";
        $http = new HttpClass();
        $result =json_decode($http->HttpPost($url, json_encode($postData)),true);
        $resultCode =$http->HttpPostCode($url, json_encode($postData));
        $this->assertEquals("200", $resultCode);
        $this->assertEquals("22410", $result['data']['userId']);
        // TODO Auto-generated TestGetUserIdSubDomain::setUp()
    }
    
    Public function testGetUserIdBySubDomainNotExit()
    {
        $url ="http://api.gn100.com/user/organization/GetUserIdBySubDomain/";
        $postData['subdomain']="h.g100.com";
        $http = new HttpClass();
        $result =json_decode($http->HttpPost($url, json_encode($postData)),true);
        $this->assertEquals("-2", $result['result']['code']);
    }
    
    Public function testGetUserIdBySubDomainNoParams()
    {
        $url ="http://api.gn100.com/user/organization/GetUserIdBySubDomain/";
        $http = new HttpClass();
        $result =json_decode($http->HttpPost($url,''),true);
        $this->assertEquals("-1", $result['result']['code']);
    }
      
}

