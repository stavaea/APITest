<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../yunkeTeacher/TestTeacherUpdateTaskShow.php';
require_once '../yunkeTeacher/TestUpdateTask.php';

class TestDelTag extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
   
    
    protected function setUp()
    {
        //老师在修改页面删除标签
        $this->url = "http://test.gn100.com/interface/teacherTask/DelTag";
        $this->http = new HttpClass();
    
    }
    
    
    public function testDataIsOK()
    {
        $tag=TestTeacherUpdateTaskShow::testReturnTag();
        //var_dump($tag);
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkTag']= $tag[0]['pkTag'];
        $pkTag=$tag[0]['pkTag'];
        
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        
        $tag2=TestTeacherUpdateTaskShow::testReturnTag();
        for($i=0;$i<count($tag2);$i++)
        {
                $this->assertNotEquals($pkTag, $tag2[$i]['pkTag']);
        }
        
        TestUpdateTask::testUpdate();
        
    }
    
    
    
    public function testParamsIsNull()
    {

        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkTag']= '';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);
    
    }
} 