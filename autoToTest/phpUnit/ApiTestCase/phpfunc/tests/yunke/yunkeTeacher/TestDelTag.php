<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
//require_once '../yunkeTeacher/TestTeacherUpdateTaskShow.php';
//require_once '../yunkeTeacher/TestUpdateTask.php';

class TestDelTag extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
	private $postdata = array();
    static $u="i";
    static $v="2";
   
    
    protected function setUp()
    {
        //老师在修改页面删除标签
        $this->url = "http://test.gn100.com/interface/teacherTask/DelTag";
        $this->http = new HttpClass();
		$this->postdata = [
			'time' => time(),
			'u'    => 'i',
			'v'    => '2'
 		];
    }
    
    public function testDataIsOK()
    {
		//教师修改作业展示
		$this->postdata['params'] = [
			'uId'    => 2,
			'taskId' => 139
		];
		$this->postdata['key']   = interface_func::GetAppKey($this->postdata);
		$this->postdata['token'] = interfaceFunc::testUserTokenGenIsSuccess('2');
		$url    = "http://test.gn100.com/interface/teacherTask/UpdateTaskShow";
        $result = interfaceFunc::getPostData($url, $this->postdata);
		$tag    = $result['result']['tag'];
		
		//老师在修改页面删除标签
		$thits->postdata['params'] = [
			'pkTag' => !empty($tag[0]['pkTag']) ?  $tag[0]['pkTag'] : 0
		];
        
        $thits->postdata['key'] = interface_func::GetAppKey($this->postdata);
		$result = interfaceFunc::getPostData($this->url, $this->postdata);
		
		//
		$url="http://test.gn100.com/interface/teacherTask/UpdateTaskShow";
		$result = interfaceFunc::getPostData($url, $this->postdata);
        $tag2= $result['result']['tag'];
		
		//for($i=0;$i<count($tag2);$i++)
        {
            //$this->assertNotEquals($pkTag, $tag2[$i]['pkTag']);
        }
		
		//
		$postdata['time']=time();
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['pkTask']= "139";
        $postdata['params']['uId']= "2";
        $postdata['params']['desc']= "app老师发布作业啊！！！！！";
        $postdata['params']['startTime']= date('Y-m-d H:i:s',strtotime("+2 minute"));
        $postdata['params']['endTime']= date('Y-m-d H:i:s',strtotime("+3 day"));
        $postdata['params']['taskImages'] =  array(
            array(
                'thumbSmall'=>'testf.gn100.com/2,a2f53cc7bdd2',
                'thumbBig'=>'testf.gn100.com/3,a2f66cdf01ad',
                'srcMallWidth'=>'152',
                'srcMallHeight'=>'105'
            )
        );
        $postdata['params']['tags']= array(
            array(
                'name'=>"语文"
            )
        );
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
		$token = interfaceFunc::testUserTokenGenIsSuccess('2');
        $postdata['token']=$token;
		$url="http://test.gn100.com/interface/teacherTask/UpdateTask";
		$result = interfaceFunc::getPostData($url, $postdata);
	
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