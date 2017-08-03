<?php

class TestUserSign extends PHPUnit_Framework_TestCase
{
 protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/user/Sign";
        $this->postData = [
            'u'=>'i',
            'v'=>'2',
            'time'=> strtotime(date('Y-m-d H:i:s'))
        ];
    }

    //参数正确，返回节点是否正确
    public function testDataIsOK()
    {
        $this->postData['params'] = [
            'uid'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code']);
        $this->assertArrayHasKey('levelName', $result['result']);
        $this->assertArrayHasKey('levelColor', $result['result']);
        $this->assertArrayHasKey('level', $result['result']);
        $this->assertArrayHasKey('continueDay', $result['result']);
        $this->assertArrayHasKey('extraEx', $result['result']);
        $this->assertArrayHasKey('status', $result['result']);
        $this->assertArrayHasKey('nextEx', $result['result']);
        $this->assertArrayHasKey('nextLevelName', $result['result']);
    }


    
    //参数正确，当天未签到
    public function testSign()
    {
        $db='db_user';
        $sql ="select * from t_user_score where fk_user='1'";
        $score=dbConnect::ConnectDB($db, $sql);
         $this->postData['params'] = [
            'uid'=>'1'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        
        $this->assertEquals($score[0][1], $result['result']['level']);
        $this->assertEquals($score[0][2], $result['result']['levelName']);
        if($result['result']['continueDay']>0)
            {
                
                $this->assertEquals($score[0][3], $result['result']['ex']);
            }else 
            {
                
                $this->assertEquals($score[0][3]+7, $result['result']['ex']);
            }
    }
 

    //参数正确，刷签到
    public function testSignCheat()
    {
        $db='db_user';
        $sql ="select * from t_user_score where fk_user='2'";
        $score=dbConnect::ConnectDB($db, $sql);//score[1]=3(level);score[2]=书生3(levelname);score[3]=300(score);
        for($i=0;$i<=2;$i++) 
        {       
             $this->postData['params'] = [
            'uid'=>'2'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        if($result['result']['continueDay']>0)
          {
                $this->assertEquals($score[0][3], $result['result']['ex']);
          }else 
          {
                $this->assertEquals($score[0][3]+7, $result['result']['ex']);
          }
          }
    }
    

    //参数正确，重复签到
    public function testSignRepeat()
    {
        $db='db_user';
        $sql ="select * from t_user_score where fk_user='2'";
        $score=dbConnect::ConnectDB($db, $sql);
         $this->postData['params'] = [
            'uid'=>'2'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals($score[0][3], $result['result']['ex']);
    }
    
    //未登陆签到
    public function testUidIsNull()
    {
         $this->postData['params'] = [
            'uid'=>'0'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1000', $result['code']);//请求参数为空   
    }
    
    //参数Uid不存在，返回值
    public function testUidIsNotExist()
    {
        $this->postData['params'] = [
            'uid'=>'9999999'
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code']); 
    }

}