<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/dbConfig.php';

/**
 * test case.
 */
class TestUserCheck extends PHPUnit_Framework_TestCase
{

    private $http;
    private $url;
    protected function setUp()
    {
        global $IP;
        $this->url = "http://" . $IP . "/user/auth/check";
        $this->http = new HttpClass($this->url);
    }

    public function testUserCheckHttpCodeIsOk()
    {
        $postdata["uname"] = "13011165159";
        $data = json_encode($postdata, true);
        $this->assertEquals(200, $this->http->HttpApiPostCode($this->url, $data), 'url:' . $this->url . '   Post data:' . json_encode($postdata));
    }

    public function testUserCheckRegUser()
    {
        $postdata["uname"] = "13011165159";
        $data = json_encode($postdata, true);
        $result = json_decode($this->http->HttpApiPost($this->url, $data), true);
        $this->assertEquals('0', $result['result']['code'], 'url:' . $this->url . '   Post data:' . json_encode($postdata));
    }

    public function testUserCheckUnregUser()
    {
        $postdata["uname"] = "+85253152718";
        $data = json_encode($postdata, true);
        $result = json_decode($this->http->HttpApiPost($this->url, $data), true);
        $this->assertEquals('-3', $result['result']['code'], 'url:' . $this->url . '   Post data:' . json_encode($postdata));
    }

    public function testUserCheckPhoneNumIsError()
    {
        $postdata["uname"] = "1301116515900033";
        $data = json_encode($postdata, true);
        $result = json_decode($this->http->HttpApiPost($this->url, $data), true);
        $this->assertEquals('-1', $result['result']['code'], 'url:' . $this->url . '   Post data:' . json_encode($postdata));
    }
}


