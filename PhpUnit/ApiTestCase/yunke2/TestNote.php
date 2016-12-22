<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once 'TestCheckNote.php';
require_once 'TestDelNote.php';
require_once 'TestUpdateNote.php';

class TestNote extends PHPUnit_Framework_TestCase
{
    private $url;
    private   $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //笔记添加
        $this->url = "http://test.gn100.com/interface/note/NoteAdd";
        $this->http = new HttpClass();
        
    }
    
 //---------------------笔记添加功能---------------------------------------
       //参数正确，返回节点是否正确
       
           public function testAddDataIsOK()
       {
           $postdata['time']=strtotime(date('Y-m-d H:i:s'));
           $postdata['u']=self::$u;
           $postdata['v']=self::$v;
           $postdata['params']['planId']='3724';
           $postdata['params']['videoStatus']='2';
           $postdata['params']['content']='啊哈哈哈哈';
           $postdata['params']['playTimeTmp']='123';//02：03
           $postdata['params']['uId']='23339';
           $key=interface_func::GetAppKey($postdata);
           $postdata['key']=$key;
           //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
           $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true); 
           $this->assertEquals('0',$result['code']);
           $this->assertArrayHasKey('noteId',$result['result']);
           $this->assertArrayHasKey('playTimeFormat',$result['result']);
           $this->assertArrayHasKey('playTimeTmpHandle',$result['result']);
           TestCheckNote::testListDataIsOK($result['result']['noteId']);
           TestUpdateNote::testUpdateData($result['result']['noteId'], '我修改了内容哦');
           TestCheckNote::testUpdateListDataIsOK($result['result']['noteId']);
           TestDelNote::testDelDataIsOK($result['result']['noteId']);
       }   
       
       
       //参数content为空，返回值
        public function testContentIsNull()
       {
           $postdata['time']=strtotime(date('Y-m-d H:i:s'));
           $postdata['u']=self::$u;
           $postdata['v']=self::$v;
           
           $postdata['params']['planId']='3724';
           $postdata['params']['videoStatus']='2';
           $postdata['params']['content']='重点';//app会做处理，传重点两个字给接口
           $postdata['params']['playTimeTmp']='150';//02：03
           $postdata['params']['uId']='23339';
           $key=interface_func::GetAppKey($postdata);
           $postdata['key']=$key;
           //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
           $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
           
           $this->assertEquals('0',$result['code']);
           TestDelNote::testDelDataIsOK($result['result']['noteId']);
           
       }  
       
       //必填参数为空，返回值
        public function testAddParamsIsNull()
       {
           $postdata['time']=strtotime(date('Y-m-d H:i:s'));
           $postdata['u']=self::$u;
           $postdata['v']=self::$v;
           
           $postdata['params']['planId']='3724';
           $postdata['params']['videoStatus']='2';
           $postdata['params']['content']='我们啊';
           $postdata['params']['playTimeTmp']='140';//02：40
           $postdata['params']['uId']='';
           $key=interface_func::GetAppKey($postdata);
           $postdata['key']=$key;
           //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
           $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
            
           $this->assertEquals('1001',$result['code']);//缺少必传参数
           
       } 
    
    //content字数限制--汉字
    
    public function testContentChineseNum()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        
        $postdata['params']['planId']='3724';
        $postdata['params']['videoStatus']='2';
        $postdata['params']['content']='一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一';
        $postdata['params']['playTimeTmp']='140';//02：40
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true); 
        $this->assertEquals('2054',$result['code']);
        //$this->assertEquals('笔记不能超过100汉字',$result['errMsg']);//笔记不能超过100汉字
        if($result['code']!='2054'){
            
            TestDelNote::testDelDataIsOK($result['result']['noteId']);
        }
    }
    
    
    //content字数限制--字符
    
     public function testContentEngNum()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
    
        $postdata['params']['planId']='3724';
        $postdata['params']['videoStatus']='2';
        $postdata['params']['content']='aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $postdata['params']['playTimeTmp']='140';//02：40
        $postdata['params']['uId']='23339';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump($result['code']);
        $this->assertEquals('2054',$result['code']);
        if($result['code']!='2054'){
        
            TestDelNote::testDelDataIsOK($result['result']['noteId']);
        }
    } 
     
    
    
    
}