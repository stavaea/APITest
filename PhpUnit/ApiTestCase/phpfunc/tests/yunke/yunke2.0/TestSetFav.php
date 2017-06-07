<?php
//require_once 'TestTeacherInfo.php';

class TestSetFav extends PHPUnit_Framework_TestCase
{
   
    public function  setUp()
    {
         //$this->tInfo=new TestTeacherInfo();
         $this->url="http://test.gn100.com/interface/teacher/setFav";
         $this->postData = [
             'u'=>'i',
             'v'=>'2',
             'time'=> strtotime(date('Y-m-d H:i:s'))
         ];
    }
    

    //传参正确，uid存在，收藏新老师，收藏成功
    public function testSetFavIsOk($userId='1',$teacherId='2')
    {
        $this->postData['params'] = [
            'userId'=>$userId,
            'teacherId'=>$teacherId
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('success', $result['message']);
        $this->assertEquals('操作成功', $result['errMsg']);         
    }
  

    //传参正确，uid存在，点击已收藏老师，取消收藏成功
    public function testSetUnFav($userId='1',$teacherId='2')
    {
        $this->postData['params'] = [
            'userId'=>$userId,
            'teacherId'=>$teacherId
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('0', $result['code']);
        $this->assertEquals('success', $result['message']);
        $this->assertEquals('操作成功', $result['errMsg']);          
    }

    
    //errorcode，uid为0，点击收藏老师，返回1021
    public function testVistorFav($userId='0',$teacherId='2')
 {
        $this->postData['params'] = [
            'userId'=>$userId,
            'teacherId'=>$teacherId
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1021', $result['code']);
        $this->assertEquals('no landing', $result['message']);
        $this->assertEquals('没有登陆', $result['errMsg']);        
    }
    
    //errorcode，老师收藏自己，返回1025
    public function testFavMyself($userId='1',$teacherId='1')
 {
        $this->postData['params'] = [
            'userId'=>$userId,
            'teacherId'=>$teacherId
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1025', $result['code']);
        $this->assertEquals("You can't collect yourself", $result['message']);
        $this->assertEquals('自己不能收藏自己', $result['errMsg']);        
    }
    
    //errorcode，未传必填参数
    public function testNoTeacherId($userId='0')
 {
        $this->postData['params'] = [
            'userId'=>$userId,
            'teacherId'=>''
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1021', $result['code']);
        $this->assertEquals('no landing', $result['message']);
        $this->assertEquals('没有登陆', $result['errMsg']);        
    }
    
    //errorcode，传参名错误
    public function testParamsError($userId='0',$teacherId='0')
 {
        $this->postData['params'] = [
            'userId'=>$userId,
            'teacherId'=>$teacherId
        ];
        $result = interfaceFunc::getPostData($this->url, $this->postData);
        $this->assertEquals('1021', $result['code']);
        $this->assertEquals('no landing', $result['message']);
        $this->assertEquals('没有登陆', $result['errMsg']);        
    }
    
   
    
}