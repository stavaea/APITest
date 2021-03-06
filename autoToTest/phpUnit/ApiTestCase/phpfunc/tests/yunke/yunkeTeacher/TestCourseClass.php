<?php
//require_once 'PHPUnit/Framework/TestCase.php';
//require_once '../func/Http.class.php';
//require_once '../func/interface_func.php';
//require_once '../BussinessUseCase/TestUserToken.php';

class TestCourseClass extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    public $Token;
    
    protected function setUp()
    {
        //课程班级列表+搜索
        $this->url = "http://test.gn100.com/interface/teacherTask/CourseClass";
        //$this->http = new HttpClass();
        //$this->Token= new TestUserToken();
    }
    
    //参数正确，返回数据（课程列表页面，不传keywords参数），最多显示50条
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uId']= "8";
        //$postdata['params']['keywords']= "";
		$time = time();
        $key=interfaceFunc::createKey($postdata, self::$u, $time);
        $postdata['key']=$key;
        //$token =$this->Token->testUserTokenGenIsSuccess('8');
		$token = interfaceFunc::testUserTokenGenIsSuccess(8);
        $postdata['token']=$token;
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
		$result=interfaceFunc::getPostData($this->url, $postdata);
        $this->assertLessThanOrEqual('50', count($result['result']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('title', $result['result'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('courseId', $result['result'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertArrayHasKey('className', $result['result'][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //搜索关键字，中文
    public function testKeywordsChinese()
    {
        $postdata['time']=time();
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uId']= "4";
        $postdata['params']['keywords']= "录播课";
        $key=interfaceFunc::createKey($postdata, self::$u, $postdata['time']);
        $postdata['key']=$key;
        //$token =$this->Token->testUserTokenGenIsSuccess('8');
		$token = interfaceFunc::testUserTokenGenIsSuccess(8);
        $postdata['token']=$token;
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
		$result=interfaceFunc::getPostData($this->url, $postdata);
		$this->assertEquals('23录播课', $result['result'][0]['title'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('230', $result['result'][0]['courseId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    //搜索关键字，英文(不支持模糊查询)
    public function testKeywordsEng()
    {
        $postdata['time']=time();
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uId']= "4";
        $postdata['params']['keywords']= "test";
		$key=interfaceFunc::createKey($postdata, self::$u, $postdata['time']);
        $postdata['key']=$key;
        //$token =$this->Token->testUserTokenGenIsSuccess('8');
		$token = interfaceFunc::testUserTokenGenIsSuccess(4);
        $postdata['token']=$token;
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
		$result=interfaceFunc::getPostData($this->url, $postdata);

        $this->assertEquals('张哈哈8月3日录播课--test', $result['result'][0]['title'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('182', $result['result'][0]['courseId'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
    }
    
    
    //必传参数为空，返回数据
    public function testParamsIsNull()
    {
        $postdata['time']=time();
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['uId']= "";
        $postdata['params']['keywords']= "ALLALALALA";
		$key=interfaceFunc::createKey($postdata, self::$u, $postdata['time']);
        $postdata['key']=$key;
        //$token =$this->Token->testUserTokenGenIsSuccess('8');
		$token = interfaceFunc::testUserTokenGenIsSuccess(8);
        $postdata['token']=$token;
        //var_dump($this->http->HttpPost($this->url, json_encode($postdata)));
        //$result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
		$result=interfaceFunc::getPostData($this->url, $postdata);
        $this->assertEquals('1000', $result['code'],'url:'.$this->url.'   Post data:'.json_encode($postdata));//请求参数为空
    }
    
    
    
}