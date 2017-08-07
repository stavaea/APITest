<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../func/seek.php';

class TestTeacherTaskDetail extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
     
    
    protected function setUp()
    {
        //老师作业详情页
        $this->url = "http://test.gn100.com/interface/teacherTask/TaskDetail";
        $this->http = new HttpClass();
    
    }
    //数据正确,有已交未交列表,有图片有文字无附件
    public function testDataIsOK()
    {
        $db="db_tag";
        $sql = "select name from t_tag where pk_tag=(SELECT fk_tag FROM t_mapping_tag_task WHERE fk_task='1')
        ;";
        $ad=interface_func::ConnectDB($db, $sql);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkTask']= '1';
        $postdata['params']['page']='1';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $this->assertEquals('0', $result['code']);
        //班级
        $this->assertEquals('1班', $result['result']['taskInfo']['className'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        //课程名称
         $this->assertEquals('直播课', $result['result']['taskInfo']['title'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
         //发布时间
         $this->assertEquals('05-24 17:03', $result['result']['taskInfo']['createTime'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
         //截止时间
         $this->assertEquals('2017-05-27 星期六 05:03', $result['result']['taskInfo']['endTime'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        //授课老师
        $this->assertEquals('杨明娟老师', $result['result']['taskInfo']['teacherName'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        //作业文字内容
        $this->assertEquals('测试一下语音批改显示问题。。。。。',self::trimall($result['result']['publish']['desc']),'url:'.$this->url.'   Post data:'.json_encode($postdata));
        //已交作业人数
        $this->assertEquals('1', $result['result']['publish']['studentCount'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        //有图片内容
        $this->assertNotEmpty($result['result']['thumb'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        //无附件内容
        $this->assertNotEmpty($result['result']['attach'],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        //标签内容
        if($ad!=null)
        {
        $this->assertEquals('英语', $ad[0][0],'url:'.$this->url.'   Post data:'.json_encode($postdata));
        }
        //已交列表内容
        $this->assertEquals('2', $result['result']['commitList']['items'][0]['fkUserStudent']);
        
        $this->assertEquals('wwoshi majinglalalallala', $result['result']['commitList']['items'][0]['desc']);
        $this->assertEquals('5', $result['result']['commitList']['items'][0]['level']);
        $this->assertEquals('2017-05-24 17:05:59', $result['result']['commitList']['items'][0]['createTime']);
        $this->assertEquals('马静', $result['result']['commitList']['items'][0]['studentName']);
        
    }
    
    //传参正确，作业上传附件内容地址
    public function testDataAttach()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkTask']= '1';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('13', $result['result']['attach'][0]['name']);
        $this->assertEquals('jpg', $result['result']['attach'][0]['type']);
        $this->assertEquals('http://testf.gn100.com/4,d01c6fb08190', $result['result']['attach'][0]['srcAttach']);
    }
    
    
    
    //缺少参数
    public function testParamIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkTask']= '';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);
    }
    
    

    
    //删除空格和回车
    function trimall($str){
        $qian=array(" ","　","\t","\n","\r");
        return str_replace($qian, '', $str);
    }
}