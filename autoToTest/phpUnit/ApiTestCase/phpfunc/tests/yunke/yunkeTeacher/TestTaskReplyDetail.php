<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../func/seek.php';

class TestTaskReplyDetail extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
     
    
    protected function setUp()
    {
        //老师作业详情页
        $this->url = "http://test.gn100.com/interface/teacherTask/TaskReplyDetail";
        $this->http = new HttpClass();
    
    }
    
    //数据正确，返回数据(批改详情页面)
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['taskId']= '154';
        $postdata['params']['pkTaskStudent']= '4112';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        var_dump('url:'.$this->$url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0', $result['code']);
        //var_dump($result['result']['commit']['thumb'][0]['srcMall']);
        $this->assertEquals('杨明娟', $result['result']['info']['rename']);
        $this->assertEquals('http://testf.gn100.com/5,028ed7a2ba14', $result['result']['info']['thumbMed']);
        
        //接口返回的格式化时间取了分和秒，dev已改，周一验证test
        //$this->assertEquals('02-08 星期三 16:54', $result['result']['commit']['data']['commitTime']);
        $this->assertEquals('我是杨明娟，这是我的作业哦', $result['result']['commit']['data']['desc']);
        $this->assertEquals('7', $result['result']['commit']['attach'][0]['name']);
        $this->assertEquals('jpg', $result['result']['commit']['attach'][0]['type']);
        $this->assertEquals('http://testf.gn100.com/4,a4f234506bf1', $result['result']['commit']['attach'][0]['srcAttach']);
        $this->assertEquals('http://testf.gn100.com/4,a4f0428ab2ed', $result['result']['commit']['thumb'][0]['srcMall']);
        
    }
    
    //批改页面
    public function testReplyTask()
    {
        $db="db_tag";
        $sql = "select name from t_tag where pk_tag=(SELECT fk_tag FROM t_mapping_tag_task WHERE fk_task='154')
        ;";
        $ad=interface_func::ConnectDB($db, $sql);
        
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['taskId']= '154';
        $postdata['params']['pkTaskStudent']= '4112';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
//         var_dump($result['result']['publish']['tag'][0]['name']);
//         var_dump($ad[0][0]);
        if($ad!=null)
        {
             $this->assertEquals('啊啊', $ad[0][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        }
    }
}