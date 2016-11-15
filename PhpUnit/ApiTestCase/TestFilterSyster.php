<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'func/Http.class.php';

/**
 * test case.
 */
class TestFilterSyster extends PHPUnit_Framework_TestCase
{

    /**
     * Prepares the environment before running a test.
     */
    protected $url;
    protected $http;
    protected function setUp()
    {
        $this->url ='http://api.gn100.com//seek/plan/list/';
        $this->http = new HttpClass();     
      // TODO Auto-generated TestFilterSyster::setUp()
    }

    public function testFilterSysterHasPromote()
    {
        $postdata['q']['course_id']="317";
        $postdata['f']=array("course_id","is_promote","price_promote","user_id","fee_type","price","market_price","status","title","try","class_id","section_id");
        $postdata['ob']['start_time']="desc";
        $postdata['p']="1";
        $postdata['pl']="1";
        $data = json_encode($postdata,true);
        $result =$this->http->HttpPost($this->url, $data);
        var_dump($result);
        
        
    }
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated TestFilterSyster::tearDown()
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }
}

