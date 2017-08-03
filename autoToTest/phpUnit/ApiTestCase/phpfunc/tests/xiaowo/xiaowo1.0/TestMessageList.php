<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';
require_once 'func/interface_func.php';
require_once '../BussinessUseCase/TestUserToken.php';
/**
 * test case.
 */
class TestMember extends PHPUnit_Framework_TestCase
{

    protected $url;
    public    $http;
    static  $u="i";
    static  $v="2";
    public  $GetToken;


    protected function setUp()
    {
        $this->url="test.gn100.com/interface/member";
        $this->http = new HttpClass();
        $this->GetToken =new TestUserToken();
    }
    
}