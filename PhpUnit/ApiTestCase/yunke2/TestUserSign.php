<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';

class TestUserSign extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    static $db="db_user";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/user/Sign";
        $this->http = new HttpClass();
    }

    //参数正确，返回节点是否正确
    public function testDataIsOK($uid='55')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']='0';
        $postdata['params']['uid']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;   
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
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
    public function testSign($uid='5312')
    {
        $db=self::$db;
        $sql ="select * from t_user_score where fk_user=$uid";
        $score=interface_func::ConnectDB($db, $sql);//score[1]=3(level);score[2]=书生3(levelname);score[3]=300(score);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']='0';
        $postdata['params']['uid']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals($score[0][1], $result['result']['level']);
        $this->assertEquals($score[0][2], $result['result']['levelName']);
        if($result['result']['continueDay']>0)
            {
                $this->assertEquals($score[0][3]+2, $result['result']['ex']);
            }else 
            {
                $this->assertEquals($score[0][3]+7, $result['result']['ex']);
            }
    }
 

    //参数正确，刷签到
    public function testSignCheat($uid='5316')
    {
        $db=self::$db;
        $sql ="select * from t_user_score where fk_user=$uid";
        $score=interface_func::ConnectDB($db, $sql);//score[1]=3(level);score[2]=书生3(levelname);score[3]=300(score);
        for($i=0;$i<=2;$i++) 
        {       
            $postdata['time']=strtotime(date('Y-m-d H:i:s',strtotime("+$i day")));
            $postdata['u']=self::$u;
            $postdata['v']=self::$v;
            $postdata['oid']='0';
            $postdata['params']['uid']=$uid;
            $key=interface_func::GetAppKey($postdata);
            $postdata['key']=$key;
            $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            if($result['result']['continueDay']>0)
            {
                $this->assertEquals($score[0][3]+2, $result['result']['ex']);
            }else 
            {
                $this->assertEquals($score[0][3]+7, $result['result']['ex']);
            }
          }
    }
    

    //参数正确，重复签到
    public function testSignRepeat($uid='5312')
    {
        $db=self::$db;
        $sql ="select * from t_user_score where fk_user=$uid";
        $score=interface_func::ConnectDB($db, $sql);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']='0';
        $postdata['params']['uid']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);        
        $this->assertEquals('0', $result['code']);
        $this->assertEquals($score[0][3], $result['result']['ex']);
    }
    
    //未登陆签到
    public function testUidIsNull($uid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']='0';
        $postdata['params']['uid']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;    
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1000', $result['code']);//请求参数为空   
    }
    
    //参数Uid不存在，返回值
    public function testUidIsNotExist($uid='8888888888')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']='0';
        $postdata['params']['uid']=$uid;
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']); 
    }

}