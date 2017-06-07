<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../func/seek.php';

class TestPushMessage extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
     
    
    protected function setUp()
    {
        //老师催交作业
        $this->url = "http://test.gn100.com/interface/teacherTask/PushMessage";
        $this->http = new HttpClass();
    
    }
    
    
    //参数正确，返回数据
    public function testDataIsOK()
    {
        
        $db="db_message";
        $sql = "SELECT message_num FROM t_message_user_text_gather WHERE fk_user_to='23339' AND message_type='10022';";
        $ad=interface_func::ConnectDB($db, $sql);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkTask']= '162';
        $postdata['params']['studentId']= '23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        
        $ad2=interface_func::ConnectDB($db, $sql);
        $this->assertGreaterThan($ad[0][0], $ad2[0][0]);
    }
    
    
    //缺少参数，返回数据
    public function testParamIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkTask']= '';
        $postdata['params']['studentId']= '23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);
    }
    
    //此作业不存在
    public function testTaskIsNotExist()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkTask']= '55555555555';
        $postdata['params']['studentId']= '23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1051', $result['code']);
    }
}