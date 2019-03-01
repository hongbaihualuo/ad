<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 手机号格式验证
 * @param $mobile
 * @return bool
 */
function check_phone($mobile)
{
    if (preg_match("/^[1[34578]\d{9}]$/", $mobile)) {
        return true;
    }

    if (preg_match("/^[\d\-]*$/", $mobile)) {
        return true;
    }
    return false;
}

/**
 * 邮箱格式验证
 * @param $email
 * @return bool
 */
function check_email($email)
{
    $pattern = "/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i";
    if (preg_match($pattern, $email)) {
        return true;
    }
    return false;
}
