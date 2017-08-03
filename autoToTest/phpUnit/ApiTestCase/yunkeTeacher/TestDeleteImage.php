<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
require_once '../yunkeTeacher/TestTeacherUpdateTaskShow.php';
require_once '../yunkeTeacher/TestUpdateTask.php';

class TestDeleteImage extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
   
    
    protected function setUp()
    {
        //老师在修改页面删除图片
        $this->url = "http://test.gn100.com/interface/teacherTask/DeleteImage";
        $this->http = new HttpClass();
    
    }
    
    
    public function testDataIsOK()
    {
        $image=TestTeacherUpdateTaskShow::testReturnImage();
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkThumb']= $image[0]['pkThumb'];
        $pkThumb=$image[0]['pkThumb'];
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        
        $image2=TestTeacherUpdateTaskShow::testReturnImage();
        for($i=0;$i<count($image2);$i++)
        {
                $this->assertNotEquals($pkThumb, $image2[$i]['pkThumb']);
        }
        
        
        TestUpdateTask::testUpdate();
    }
    
    
    public function testParamIsNull()
    {
        
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkThumb']= '';
        
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);
     
        
    }
    
    
} 