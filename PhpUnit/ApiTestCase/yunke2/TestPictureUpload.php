<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';

class TestPictureUpload extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    
    protected function setUp()
    {
        $this->url = "http://test.gn100.com/interface/studentTask/UploadImage";
        $this->http = new HttpClass();
    }
    
    //参数正确，返回节点是否正确
    public function testDataIsOK($oid='0')
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['oid']=$oid;
//         header( "Content-type: image/png");
//         $PSize = filesize('C:/Users/Administrator/Desktop/11.png');
//         $picturedata = fread(fopen('C:/Users/Administrator/Desktop/11.png', "r"), $PSize);
        
        $postdata['params']['image']='44444444444444444444';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
       // $this->assertEquals('1,b803ca9b9016', $result['result']['big']);
       // $this->assertEquals('2,b802d78e6fce', $result['result']['small']);
    }
}