<?php
namespace app\api\controller\v1;

use app\api\validate\AddressNew;
use app\api\model\User as UserModel;
use app\lib\exception\UserException;
use app\lib\exception\SuccessMessage;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Controller;
use app\api\controller\BaseController;

class Address extends BaseController
{
    //前置方法
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress']
    ];

    //增加或修改地址
    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();

        /**
         *  根据Token来获取uid
         * ->根据uid来查找用户数据，判断用户是否存在，如果不存在抛出异常
         * ->获取用户从客户端提交来的地址信息
         * ->根据用户地址信息是否存在，判断是添加地址还是更新地址 
         * */
        $uid = TokenService::getCurrentUid();

        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserException();
        }

        $dataArray = $validate->getDataByRule(input('post.'));

        $userAddress = $user->address;
        if ($userAddress) {
            $user->address()->save($dataArray);
        } else {
            $user->address->save($dataArray);
        }
        return json(new SuccessMessage(), 201);
    }
}