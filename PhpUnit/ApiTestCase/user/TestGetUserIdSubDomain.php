<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/dbConfig.php';

/**
 * test case.
 */
class TestGetUserIdSubDomain extends PHPUnit_Framework_TestCase
{

    private $url;

    private $http;

    protected function setUp()
    {
        global $IP;
        $this->url = "http://". $IP . "/user/organization/GetUserIdBySubDomain/";
        $this->http = new HttpClass($this->url);
    }

    Public function testGetUserIdBySubDomain()
    {
        $postData['subdomain'] = "test.gn100.com";
        $http = new HttpClass();
        $result = json_decode($http->HttpApiPost($this->url, json_encode($postData)), true);
        var_dump($result);
        $resultCode = $http->HttpApiPostCode($this->url, json_encode($postData));
        $this->assertEquals("200", $resultCode);
        $this->assertEquals("183", $result['data']['userId'], 'url:' . $this->url);
        // TODO Auto-generated TestGetUserIdSubDomain::setUp()
    }

    Public function testGetUserIdBySubDomainNotExit()
    {
        $postData['subdomain'] = "h.g100.com";
        $http = new HttpClass();
        $result = json_decode($http->HttpApiPost($this->url, json_encode($postData)), true);
        $this->assertEquals("-2", $result['result']['code'], 'url:' . $this->url);
    }

    Public function testGetUserIdBySubDomainNoParams()
    {
        $http = new HttpClass();
        $result = json_decode($http->HttpApiPost($this->url, ''), true);
        $this->assertEquals("-1", $result['result']['code'], 'url:' . $this->url);
    }
}

