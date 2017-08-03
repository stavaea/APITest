<?php
require_once '../func/Http.class.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/interface_func.php';

class TestPointCoverFlower extends PHPUnit_Framework_TestCase
{
    protected $url;
    private $http;
    static  $u="i";
    static  $v="2";
    
    
    protected function setUp()
    {
        //积分兑换鲜花,红名卡
        $this->url="http://test.gn100.com/interface/point/PointConvertFlower";
        $this->http = new HttpClass();
    
    }
    
    //参数正确，返回值
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['giftId']= '1';//1鲜花 2红名卡
        $postdata['params']['uId']= '23339';
        $postdata['params']['giftNum']= '1';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        $this->assertEquals('0', $result['code']);
    }
    
    //缺少必传参数，返回值
    public function testParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['giftId']= '1';//1鲜花 2红名卡
        $postdata['params']['uId']= '';
        $postdata['params']['giftNum']= '1';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        //var_dump($result);
        $this->assertEquals('1001', $result['code']);
    }
}