<?php
namespace app\api\validate;

use app\lib\exception\BaseException;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = '分类获取出错';
    public $errorCode = 50000;
}