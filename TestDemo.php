<?php
require_once 'PHPUnit/Framework/TestCase.php';

class TestDemo extends PHPUnit_Framework_TestCase
{
    protected $url;
    public    $http;
    static  $u="i";
    static  $v="2";
  

    public function testDemoIsOk()
    {
       $arr = array("Hello" => "Word", "12" => 't');
       $arr2 = array("Word",'t');
       $key1=array_keys($arr);
       $key2 =array_keys($arr2);
        $this->assertInternalType('string',$key1[0]);
        $this->assertInternalType('int',$key2[0]);
        //$this->assertInternalType('array',$arr);
        //$postdata['key']=$key; )
       // var_dump(json_encode($postdata));
        
        
    }
}





