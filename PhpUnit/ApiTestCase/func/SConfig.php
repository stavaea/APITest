<?php
class SConfig{
    /**
     * 获取conf配置方法
     * @param string $configFile
     * @param mixed $result
     */
public static function getConfig($configFile,$zone=null){
        $config =self::parse($configFile);
        if($zone){
            if(isset($config->$zone)){
                return $config->$zone;
            }elseif (isset($config->default)){
                return $config->default;
            }
            return null;
        }
        return $config;
    }

}
    

