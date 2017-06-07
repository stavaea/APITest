<?PHP
/**
 * 对外接口
 * @conf /data/www/config/parterner.conf 对外配置文件
 * @wiki https://wiki.gn100.com/openapi
 */
class openapiFunc{

    /**
     * 获取数据
     * @param $url 请求链接
     * @param $appId 
     * @param $appHash
     * @param $postData
     * @return array
     */
    public static function getData($url, $postData){
        if(empty($postData['appHash']) || empty($postData['appId']) || empty($postData['params']) || !is_array($postData['params'])){
            return array('code'=>401,'msg'=>'必传:apphash|appid|params(数组)');
        }

        $key = md5($postData['appHash'].json_encode($postData['params'], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

        $data = json_encode(
            [
                'appid'   => $postData['appId'],
                'apphash' => $key,
                'params'  => $postData['params']
            ]
        );

        return json_decode(self::postCurl($url, $data), true);
    }

    public static function postCurl($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);

        return $output;
    }
}
?>
