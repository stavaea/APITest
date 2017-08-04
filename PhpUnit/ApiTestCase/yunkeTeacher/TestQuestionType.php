<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';

class TestQuestionType extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    public $Token;
     
    
    protected function setUp()
    {
        //答题卡类型
        $this->url = "http://test.gn100.com/interface/plan/questionType";
        $this->http = new HttpClass();
        $this->Token =new TestUserToken();
    
    }
    
    //快速出题
    public function testTypeOne()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']= '1';
        $postdata['params']['type']= '1';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
//         $token =$this->Token->testUserTokenGenIsSuccess('23339');
//         $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals('8',count($result['result']['data']));
    }
    
    //互动问答
    public function testTypeSecond()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']= '1';
        $postdata['params']['type']= '2';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //         $token =$this->Token->testUserTokenGenIsSuccess('23339');
        //         $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('3',count($result['result']['data']));
    }
    
    //填空
    public function testTypeThird()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['userId']= '1';
        $postdata['params']['type']= '3';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //         $token =$this->Token->testUserTokenGenIsSuccess('23339');
        //         $postdata['token']=$token;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump($result);
        $this->assertEquals('1',count($result['result']['data']));
    }
}