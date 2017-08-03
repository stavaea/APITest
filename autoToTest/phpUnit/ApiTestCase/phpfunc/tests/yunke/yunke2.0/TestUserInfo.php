<?php

/**
 * test case.
 */
class TestUserInfo extends PHPUnit_Framework_TestCase
{    
     protected function setUp()
      {
        $this->url = "http://test.gn100.com/interface/user/GetInfo";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
            ];
      }
    
    public function testUserHasRealName()
    {
        $db='db_user';
        $sql ="select name,real_name,mobile,thumb_big from t_user where pk_user='1'";
        $userInfo=dbConnect::ConnectDB($db, $sql);
        $this->postData['params'] = [
            'uid'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals($userInfo[0][0], $result['result']['nickName']);
        $this->assertEquals($userInfo[0][1], $result['result']['realName']);
         $this->assertContains($userInfo[0][2], $result['result']['mobile']);
        $this->assertContains($userInfo[0][3], $result['result']['image']);
    }

    public function testNoRealNameUser()
    {
        $db='db_user';
        $sql ="select name,real_name,mobile,thumb_big from t_user where pk_user='14'";
        $userInfo=dbConnect::ConnectDB($db, $sql);
        $this->postData['params'] = [
            'uid'=>'14'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals($userInfo[0][0], $result['result']['nickName']);
        $this->assertEmpty($result['result']['realName']);
    }
    
    
    //用户不存在应返回相应提示
    public function testUserNoExist()
    {
        $this->postData['params'] = [
            'uid'=>'999999999'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertNotEquals(0, $result['code']);
    }
}

