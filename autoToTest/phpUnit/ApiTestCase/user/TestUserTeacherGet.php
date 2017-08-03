<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/dbConfig.php';

/**
 * test case.
 */
class TestUserTeacherGet extends PHPUnit_Framework_TestCase
{

    /**
     * Prepares the environment before running a test.
     */
    private $url;

    private $uid;

    private $http;

    protected function setUp()
    {
        global $IP;
        $this->url = "http://" . $IP . "/user/teacher/get/";
        $this->http = new HttpClass();
    }

    public function testUserTeacherGetInfo($uid = "22410")
    {
        $httpurl = $this->url . $uid;
        $result = json_decode($this->http->HttpApiGet($httpurl), true);
        $this->assertEquals("junior", $result['data']['scopes']['0'], 'url:' . $this->url);
    }
    
    // 机构导入老师，需手动保存资料
    public function testUserTeacherGetOrgAddTeacherInfo($uid = "22416")
    {
        $httpurl = $this->url . $uid;
        $result = json_decode($this->http->HttpApiGet($httpurl), true);
        $this->assertEquals("-2", $result['result']['code'], 'url:' . $this->url);
        // $this->assertEquals("junior", $result['data']['scopes']);
    }

    public function testUserTeacherGetNotExist($uid = "22415")
    {
        $httpurl = $this->url . $uid;
        $result = json_decode($this->http->HttpApiGet($httpurl), true);
        $this->assertEquals("-2", $result['result']['code'], 'url:' . $this->url);
    }
}

