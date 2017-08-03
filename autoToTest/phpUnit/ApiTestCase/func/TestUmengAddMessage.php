<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Http.class.php';
/**
 * test case.
 */
class TestUmengAddMessage extends PHPUnit_Framework_TestCase
{

  protected function setUp()
    {
        $this->url="api.gn100.com/ymeng/message/AddMessage";
        $this->http = new HttpClass();
    }

   
}

