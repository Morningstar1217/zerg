<?php
namespace app\api\validate;

use think\Validate;

class IDMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPostiveInteger'
    ];

    protected $message = [
        'id' => 'id必须为正整数'
    ];
}