<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../func/Http.class.php';
require_once '../func/interface_func.php';
//require_once '../BussinessUseCase/TestUserToken.php';
//require_once dirname(__FILE__).'/TestTeacherTaskList.php';
//require_once '../yunkeTeacher/TestTeacherDeleteTask.php';
//require_once '../yunkeTeacher/TestTeacherUpdateTaskShow.php';

class TestTeacherPublishTask extends PHPUnit_Framework_TestCase
{
    private $url;
    private $http;
    static $u="i";
    static $v="2";
    public $Token;
    
    protected function setUp()
    {
        //老师发布作业
        $this->url = "http://test.gn100.com/interface/teacherTask/PublishTask";
        $this->http = new HttpClass();
        //$this->Token =new TestUserToken();
    
    }
   
    //参数正确，返回数据结果
    public function testDataIsOK()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        //$token =$this->Token->testUserTokenGenIsSuccess('23339');
		$token =interfaceFunc::testUserTokenGenIsSuccess('2');
        $postdata['token']=$token;
        $postdata['params']['fkCourse']= "1";
        $postdata['params']['fkClass']= "1";
        $postdata['params']['uId']= "2";
        $postdata['params']['desc']= "7e8658976980";
        $postdata['params']['startTime']= date('Y-m-d H:i:s',strtotime("+2 minute"));
		//$postdata['params']['startTime']= "2017-10-25 18:59:00";
        $postdata['params']['endTime']= date('Y-m-d H:i:s',strtotime("+3 day"));
		//$postdata['params']['endTime']="2017-10-28 16:58:00";
        $postdata['params']['taskImages'] =  array(
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            )
        );
        $postdata['params']['tags']= array(
            array(
                'name'=>"语文"
            )
        );
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
		

        echo date();exit;

        $this->assertEquals('0', $result['code']);
        //$fkTask=TestTeacherTaskList::testFkTask();
        //TestTeacherUpdateTaskShow::testUpdateListIsOK($fkTask);
        //TestTeacherDeleteTask::testDeleteTask($fkTask);
    }
    
    //必传参数为空，返回结果
    public function testParamsIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        //$token =$this->Token->testUserTokenGenIsSuccess('23339');
		$token =interfaceFunc::testUserTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        $postdata['params']['fkCourse']= "783";
        $postdata['params']['fkClass']= "916";
        $postdata['params']['uId']= "";
        $postdata['params']['desc']= "app老师发布作业啊！！！！！";
        $postdata['params']['startTime']= date('Y-m-d H:i:s',strtotime("+2 minute"));
        $postdata['params']['endTime']= date('Y-m-d H:i:s',strtotime("+3 day"));
        $postdata['params']['taskImages'] =  array(
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            )
        );
        $postdata['params']['tags']= array(
            array(
                'name'=>"语文"
            )
        );
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('1001', $result['code']);
    }
    
    //图片、附件(app没有附件)、内容为空，返回结果
    public function testParamsAllIsNull()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        //$token =$this->Token->testUserTokenGenIsSuccess('23339');
		$token =interfaceFunc::testUserTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        $postdata['params']['fkCourse']= "783";
        $postdata['params']['fkClass']= "916";
        $postdata['params']['uId']= "23339";
        $postdata['params']['desc']= "";
        $postdata['params']['startTime']= date('Y-m-d H:i:s',strtotime("+2 minute"));
        $postdata['params']['endTime']= date('Y-m-d H:i:s',strtotime("+3 day"));
        $postdata['params']['taskImages'] =  array(
            
        );
        $postdata['params']['tags']= array(
            array(
                'name'=>"语文"
            )
        );
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        //var_dump('url:'.$this->url.'   Post data:'.json_encode($postdata));
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('2057', $result['code']);
    }
    
    
    //发布时间小于当前时间
    public function testTimeIsError()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        //$token =$this->Token->testUserTokenGenIsSuccess('23339');
		$token =interfaceFunc::testUserTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        $postdata['params']['fkCourse']= "783";
        $postdata['params']['fkClass']= "916";
        $postdata['params']['uId']= "23339";
        $postdata['params']['desc']= "app老师发布作业啊！！！！！";
        $postdata['params']['startTime']= "2017-02-05 14:18:00";
        $postdata['params']['endTime']= "2017-02-09 14:18:00";
        $postdata['params']['taskImages'] =  array(
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            )
        );
        $postdata['params']['tags']= array(
            array(
                'name'=>"语文"
            )
        );
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('4004', $result['code']);
    }
    
    //taskImages超过10张图片，返回结果(php没有做处理,超过10张也可以发布)
    public function testTaskImagesIsMoreTen()
    {
	
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        //$token =$this->Token->testUserTokenGenIsSuccess('23339');
		$token =interfaceFunc::testUserTokenGenIsSuccess('2');
        $postdata['token']=$token;
        $postdata['params']['fkCourse']= "1";
        $postdata['params']['fkClass']= "1";
        $postdata['params']['uId']= "2";
        $postdata['params']['desc']= "7e8658976980";
        $postdata['params']['startTime']= date('Y-m-d H:i:s',strtotime("+2 minute"));
		//$postdata['params']['startTime']= "2017-10-25 18:51:20";
        $postdata['params']['endTime']= date('Y-m-d H:i:s',strtotime("+3 day"));
		//$postdata['params']['endTime']="2017-10-28 18:05:00";
        $postdata['params']['taskImages'] =  array(
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            ),
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            ),
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            ),
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            ),
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            ),
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            ),
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            ),
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            ),
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            ),
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            ),
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            )
            
        );
        $postdata['params']['tags']= array(
            array(
                'name'=>"语文"
            )
        );
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
		
		
		
        $this->assertEquals('2067', $result['code']);
    }
    
    //tag标签超过五个
    public function testTagIsMoreFive()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        //$token =$this->Token->testUserTokenGenIsSuccess('23339');
		$token =interfaceFunc::testUserTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        $postdata['params']['fkCourse']= "783";
        $postdata['params']['fkClass']= "916";
        $postdata['params']['uId']= "23339";
        $postdata['params']['desc']= "app老师发布作业啊！！！！！";
        $postdata['params']['startTime']= date('Y-m-d H:i:s',strtotime("+2 minute"));
        $postdata['params']['endTime']= date('Y-m-d H:i:s',strtotime("+3 day"));
        $postdata['params']['taskImages'] =  array(
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            )
        );
        $postdata['params']['tags']= array(
            array(
                'name'=>"语文"
            ),
            array(
                'name'=>"数学"
            ),
            array(
                'name'=>"英语"
            ),
            array(
                'name'=>"物理"
            ),
            array(
                'name'=>"政治"
            ),
            array(
                'name'=>"高数"
            )
        );
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('2061', $result['code']);
    }
    
    
    //tag最多显示10个汉字
    public function testTagChineseTen()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        //$token =$this->Token->testUserTokenGenIsSuccess('23339');
		$token =interfaceFunc::testUserTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        $postdata['params']['fkCourse']= "783";
        $postdata['params']['fkClass']= "916";
        $postdata['params']['uId']= "23339";
        $postdata['params']['desc']= "app老师发布作业啊！！！！！";
        $postdata['params']['startTime']= date('Y-m-d H:i:s',strtotime("+2 minute"));
        $postdata['params']['endTime']= date('Y-m-d H:i:s',strtotime("+3 day"));
        $postdata['params']['taskImages'] =  array(
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            )
        );
        $postdata['params']['tags']= array(
            array(
                'name'=>"语文语文语文语文语文aaaa"
            )
        );
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('2062', $result['code']);
    }
    
    
    //tag最多显示20个英文
    public function testTagEngTwenty()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        //$token =$this->Token->testUserTokenGenIsSuccess('23339');
		$token =interfaceFunc::testUserTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        $postdata['params']['fkCourse']= "783";
        $postdata['params']['fkClass']= "916";
        $postdata['params']['uId']= "23339";
        $postdata['params']['desc']= "app老师发布作业啊！！！！！";
        $postdata['params']['startTime']= date('Y-m-d H:i:s',strtotime("+2 minute"));
        $postdata['params']['endTime']= date('Y-m-d H:i:s',strtotime("+3 day"));
        $postdata['params']['taskImages'] =  array(
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            )
        );
        $postdata['params']['tags']= array(
            array(
                'name'=>"aaaaaaaaaaaaaaaaaaaaaaaa"
            )
        );
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('2062', $result['code']);
    }
    
    
    //作业内容desc大于2000字符，返回结果
    public function testDesc()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        //$token =$this->Token->testUserTokenGenIsSuccess('23339');
		$token =interfaceFunc::testUserTokenGenIsSuccess('23339');
        $postdata['token']=$token;
        $postdata['params']['fkCourse']= "783";
        $postdata['params']['fkClass']= "916";
        $postdata['params']['uId']= "23339";
        $postdata['params']['desc']= "我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们我们a";
        $postdata['params']['startTime']= date('Y-m-d H:i:s',strtotime("+2 minute"));
        $postdata['params']['endTime']= date('Y-m-d H:i:s',strtotime("+3 day"));
        $postdata['params']['taskImages'] =  array(
            array(
                'thumbSmall'=>'testf.gn100.com/3,d70720fec11a',
                'thumbBig'=>'testf.gn100.com/6,d70804e3d1d6',
                'srcMallWidth'=>'200',
                'srcMallHeight'=>'300'
            )
        );
        $postdata['params']['tags']= array(
            array(
                'name'=>"语文"
            )
        );
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
        $result=json_decode($this->http->HttpPost($this->url, json_encode($postdata)),true);
        $this->assertEquals('2063', $result['code']);
    }
    
    
    
    //待批改作业
    public function testStatusIsNotReply()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
		$postdata['u']=self::$u;
		$postdata['v']=self::$v;
		$postdata['params']['page']='1';
		$postdata['params']['uId']='2';
		$postdata['params']['status']='1';
		$key=interface_func::GetAppKey($postdata);
		$postdata['key']=$key;
		$token = interfaceFunc::testUserTokenGenIsSuccess(2);
		$postdata['token']=$token;
		//var_dump('url:'.self::$url.'   Post data:'.json_encode($postdata));
		$url="http://test.gn100.com/interface/teacherTask/TaskList";
		$result=json_decode(HttpClass::HttpStaticPost($url, json_encode($postdata)),true);
		//print_r($result);die;
		//$pkTask=$result['result']['data'][0]['days'][0]['pkTask'];
		//return $pkTask;
		return $result;
    }
    
    //作业列表
    public function testTaskList()
    {
        $postdata['time']=strtotime(date('Y-m-d H:i:s'));
        $postdata['u']=self::$u;
        $postdata['v']=self::$v;
        $postdata['params']['page']='2';
        $postdata['params']['uId']='2';
        $postdata['params']['status']='3';
        $key=interface_func::GetAppKey($postdata);
        $postdata['key']=$key;
		$token = interfaceFunc::testUserTokenGenIsSuccess(2);
        $postdata['token']=$token;
		$url="http://test.gn100.com/interface/teacherTask/TaskList";
        $result=json_decode(HttpClass::HttpStaticPost($url, json_encode($postdata)),true);
        $pkTask=$result['result']['data'][0]['days'][0]['pkTask'];
        var_dump('url:'.$url.'   Post data:'.json_encode($postdata));
        return $pkTask;
    }
}
