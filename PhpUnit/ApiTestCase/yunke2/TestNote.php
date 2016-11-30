<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

class TestNote extends PHPUnit_Framework_TestCase
{
    private $url1;
    private $url2;
    private $url3;
    private $url4;
    private $http1;
    private $http2;
    private $http3;
    private $http4;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        //笔记添加
        $this->url1 = "http://dev.gn100.com/interface/note/NoteAdd";
        $this->http1 = new HttpClass();
        //笔记删除
        $this->url2 = "http://dev.gn100.com/interface/note/DelNote";
        $this->http2 = new HttpClass();
        //笔记修改
        $this->url3 = "http://dev.gn100.com/interface/note/UpdateNote";
        $this->http3 = new HttpClass();
        //笔记列表
        $this->url4 = "http://dev.gn100.com/interface/note/NoteList";
        $this->http4 = new HttpClass();
    }
    
 //---------------------笔记添加功能---------------------------------------
       //参数正确，返回节点是否正确
       
         /*  public function testAddDataIsOK($oid='469')
       {
           $postdata['time']=strtotime(date('Y-m-d H:i:s'));
           $postdata['u']=self::$u;
           $postdata['v']=self::$v;
           $postdata['oid']=$oid;
           $postdata['params']['planId']='7578';
           $postdata['params']['videoStatus']='3';
           $postdata['params']['content']='啊哈哈哈哈';
           $postdata['params']['playTimeTmp']='123';//02：03
           $postdata['params']['uId']='3596';
           $key=interface_func::GetAppKey($postdata);
           $postdata['key']=$key;
           //var_dump($this->http1->HttpPost($this->url1, json_encode($postdata)));
           $result=json_decode($this->http1->HttpPost($this->url1, json_encode($postdata)),true);
            
           $this->assertEquals('0',$result['code']);
           $this->assertArrayHasKey('noteId',$result['result']);
           $this->assertArrayHasKey('playTimeFormat',$result['result']);
           $this->assertArrayHasKey('playTimeTmpHandle',$result['result']);
           
       }   */
       
       
       //参数content为空，返回值
       /* public function testContentIsNull($oid='469')
       {
           $postdata['time']=strtotime(date('Y-m-d H:i:s'));
           $postdata['u']=self::$u;
           $postdata['v']=self::$v;
           $postdata['oid']=$oid;
           $postdata['params']['planId']='7578';
           $postdata['params']['videoStatus']='3';
           $postdata['params']['content']='重点';//app会做处理，传重点两个字给接口
           $postdata['params']['playTimeTmp']='150';//02：03
           $postdata['params']['uId']='3596';
           $key=interface_func::GetAppKey($postdata);
           $postdata['key']=$key;
           var_dump($this->http1->HttpPost($this->url1, json_encode($postdata)));
           $result=json_decode($this->http1->HttpPost($this->url1, json_encode($postdata)),true);
           
           $this->assertEquals('0',$result['code']);
           
       }  */
       
       //必填参数为空，返回值
       /* public function testAddParamsIsNull($oid='469')
       {
           $postdata['time']=strtotime(date('Y-m-d H:i:s'));
           $postdata['u']=self::$u;
           $postdata['v']=self::$v;
           $postdata['oid']=$oid;
           $postdata['params']['planId']='7578';
           $postdata['params']['videoStatus']='3';
           $postdata['params']['content']='我们啊';
           $postdata['params']['playTimeTmp']='140';//02：40
           $postdata['params']['uId']='';
           $key=interface_func::GetAppKey($postdata);
           $postdata['key']=$key;
           var_dump($this->http1->HttpPost($this->url1, json_encode($postdata)));
           $result=json_decode($this->http1->HttpPost($this->url1, json_encode($postdata)),true);
            
           $this->assertEquals('1001',$result['code']);//缺少必传参数
       } */
    
    //content字数限制
    /*
    public function testContentNum($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['planId']='7578';
        $postdata['params']['videoStatus']='3';
        $postdata['params']['content']='一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一二三四五一';
        $postdata['params']['playTimeTmp']='140';//02：40
        $postdata['params']['uId']='3596';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http1->HttpPost($this->url1, json_encode($postdata)));
        $result=json_decode($this->http1->HttpPost($this->url1, json_encode($postdata)),true); 
        $this->assertEquals('2054',$result['code']);
        $this->assertEquals('笔记不能超过50汉字',$result['errMsg']);//笔记不能超过50汉字
    }
    */
    
    
    //---------------------删除笔记功能---------------------------------------
    
    //传参正确，返回节点数据是否正确
    
     /* public function testDelDataIsOK($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['planId']='7578';
        $postdata['params']['videoStatus']='3';
        $postdata['params']['noteId']='1143';
        $postdata['params']['uId']='3596';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http2->HttpPost($this->url2, json_encode($postdata)));
        $result=json_decode($this->http2->HttpPost($this->url2, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);//操作成功
         
    } */
    
    //必填参数为空，返回值
    /* public function testDelParamsIsNull($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['planId']='7578';
        $postdata['params']['videoStatus']='3';
        $postdata['params']['noteId']='';
        $postdata['params']['uId']='3596';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http2->HttpPost($this->url2, json_encode($postdata)));
        $result=json_decode($this->http2->HttpPost($this->url2, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
    } */
    
    //---------------------修改笔记功能---------------------------------------
     /* public function testUpdateDataIsNull($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['planId']='7578';
        $postdata['params']['videoStatus']='3';
        $postdata['params']['noteId']='1204';
        $postdata['params']['content']='';
        $postdata['params']['uId']='3596';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http3->HttpPost($this->url3, json_encode($postdata)));
        $result=json_decode($this->http3->HttpPost($this->url3, json_encode($postdata)),true);
        $this->assertEquals('1', $result['code']);//不修改由app做限制
    } */
    
    /*
    //必传参数为空，返回值
    public function testUpdateParamsIsNull($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['planId']='7578';
        $postdata['params']['videoStatus']='3';
        $postdata['params']['noteId']='';
        $postdata['params']['content']='啊啊啊啊啊啊啊';
        $postdata['params']['uId']='3596';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump($this->http3->HttpPost($this->url3, json_encode($postdata)));
        $result=json_decode($this->http3->HttpPost($this->url3, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);//缺少必传参数
    } */
    
    
    //---------------------笔记列表功能---------------------------------------
     public function testListDataIsOK($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['planId']='7578';
        $postdata['params']['videoStatus']='3';
        $postdata['params']['uId']='3596';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http4->HttpPost($this->url4, json_encode($postdata)));
        $result=json_decode($this->http4->HttpPost($this->url4, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertArrayHasKey('courseId', $result['result']['items'][0]);
        $this->assertArrayHasKey('planId', $result['result']['items'][0]);
        $this->assertArrayHasKey('userId', $result['result']['items'][0]);
        $this->assertArrayHasKey('status', $result['result']['items'][0]);
        $this->assertArrayHasKey('content', $result['result']['items'][0]);
        $this->assertArrayHasKey('playTime', $result['result']['items'][0]);
        
    } 
    
    //必填参数为空，返回值
    /* public function testListParamsIsNull($oid='469')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
        $postdata['params']['planId']='7578';
        $postdata['params']['videoStatus']='3';
        $postdata['params']['uId']='';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http4->HttpPost($this->url4, json_encode($postdata)));
        $result=json_decode($this->http4->HttpPost($this->url4, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);
        
    } */
}