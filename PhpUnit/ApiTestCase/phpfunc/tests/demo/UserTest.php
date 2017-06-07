<?PHP
class UserTest extends PHPUnit_Framework_TestCase{

    public function setUp(){
//         $this->interfaceResult = new interfaceFunc();
//         $this->openapiResult   = new openapiFunc();
//         $this->webResult       = new webapiFunc();
    }

    /**
     * 获取用户信息(interface接口)
     */
    public function testUserBasicInfo(){
        //构建请求参数
        $postData['time'] = time();
        $postData['u'] = 'i';
        $postData['params'] = [
            'uid' => 304 
        ]; 

        //请求链接
        $url  = 'http://zhengtianlong.gn100.com/interface/user/basicinfo';

        //执行请求
        $data = interfaceFunc::getPostData($url, $postData);
        var_dump('url:'.$url.'   Post data:'.json_encode($postData));
        //print_r($data);exit;

        //验证
        //$this->assertEquals('教师1', $data['result']['name']);
        //$this->assertArrayHasKey('name', $data['result']);
    }

    /**
     * 获取用户信息(openapie接口)
     */
    public function testUserInfo(){
        //构建请求参数
        $postData['appId']   = 201;
        $postData['appHash'] = '8ca155d8c544a82fdaa31r2d0a7eea78';
        $postData['params']  = [
            'userId' => 304
        ];

        //请求链接
        $url  = 'http://zhengtianlong.gn100.com/openapi/user/info';

        //执行请求
        $data = openapiFunc::getData($url, $postData);
        //print_r($data);
    }
    
    /**
     * 获取用户信息(api接口)get获取
     */
    public function testGetUserInfo(){
        //请求链接
        $url  = "http://zhengtianlong.api.gn100.com/user/info/get/304";

        //执行请求
        $data = webapiFunc::getCurl($url);
        //print_r($data);

    }

    public function testGetTeachers(){
        $postData = [
            'user_id' => 304
        ];

        //请求链接
        $url  = "http://zhengtianlong.api.gn100.com/user/info/getmgrteacherlist";

        //执行请求
        $data = webapiFunc::postCurl($url,$postData);
        print_r($data);


    }

}
?>
