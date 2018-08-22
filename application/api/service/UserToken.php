<?php
namespace app\api\service;

use think\Exception;
use app\lib\exception\WeChatException;
use app\api\model\User as UserModel;
use app\lib\exception\TokenException;
use app\lib\enum\ScopeEnum;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get($code)
    {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取session_key及openID时异常，微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {
                return $this->grantToken($wxResult);
            }
        }
    }

    private function processLoginError($wxResult)
    {
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }

    private function grantToken($wxResult)
    {
        //拿到openid->数据库里看一下是不是已经存在->存在不处理，不存在则新增记录->把令牌返回到客户端->key:用户携带的令牌 value:wxResult,uid,scope
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        if ($user) {
            $uid = $user->id;
        } else {
            $uid = $this->newUser($openid);
        }
        $cacheValue = $this->prepareCacheValue($wxResult, $uid);

        $token = $this->saveToCache($cacheValue);
        return $token;
    }

    private function newUser($openid)
    {
        $user = UserModel::create([
            'openid' => $openid
        ]);
        return $user->id;
    }

    private function prepareCacheValue($wxResult, $uid)
    {
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        //16代表app用户的权限数值；
        //32代表cms（管理员）的权限数值
        $cacheValue['scope'] = ScopeEnum::User;
        return $cacheValue;
    }

    private function saveToCache($cacheValue)
    {
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config('setting.token_expire_in');

        $request = cache($key, $value, $expire_in);
        if (!$result) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                "errorCode" => 10005
            ]);
        }
        return $key;
    }
}