<?php

namespace app\api\validate;

use think\Validate;
use think\Request;
use think\Exception;
use app\lib\exception\ParameterException;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        //获取http传入的参数
        //对这些参数做检验
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params);
        if (!$result) {
            $e = new ParameterException([
                'msg' => $this->error,
            ]);
            throw $e;
        } else {
            return true;
        }
    }
    // 校验正整数
    protected function isPostiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }
    // 不为空
    protected function isNotEmpty($value, $rule = '', $data = '', $field = '')
    {
        if (empty($value)) {
            return false;
        } else {
            return true;
        }
    }
    //
    public function getDataByRule($arrays)
    {
        if (array_key_exists('user_id', $arrays) | array_key_exists('uid', $arrays)) {
            throw new ParameterException([
                'msg' => '参数中包含有非法的参数名user_id或uid'
            ]);
        }

        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
    //手机号检验
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|6|7|8|9)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}