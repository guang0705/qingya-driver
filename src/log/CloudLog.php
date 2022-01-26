<?php

namespace QingYa\Driver\log;

/**
 * 云日志 驱动，日志格式进行了专门优化调整，方便录入到日志系统，筛选，一般情况请勿调整日志格式
 * 开发注意事项：这个文件里面请勿使用缓存、数据库查询等操作，会出现死循环
 * Class CloudLog
 *
 * @package QingYa\Driver\log
 */
class CloudLog
{
    /**
     * 获取客户端IP(兼容IPV6)
     *
     * @return string|null 返回IP字符串
     */
    public function getClientIp()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }
            $ip = trim(current($arr));
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = '0.0.0.0';
        }
        // IP地址合法验证
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = '0.0.0.0';
        }
        return $ip;
    }

}
