<?php
namespace app\api\controller\v1;

use think\Controller;
use app\api\service\Token as TokenService;
use app\lib\exception\TokenException;
use app\lib\exception\ForbiddenException;
use app\lib\enum\ScopeEnum;
use app\api\controller\BaseController;
use app\api\validate\OrderPlace;

class Order extends BaseController
{
    /**
     *用户在选择商品后，向api提交包含它所选择商品的相关信息
     *API在接收到信息后，需要检查订单相关商品的库存量
     *有库存，把订单数据存入数据库中，下单成功  返回客户端消息  可以支付了
     *调用支付接口，进行支付
     *还要再次进行库存量检测
     *服务器这边调用微信的支付接口进行支付
     *微信会返回一个支付的结果
     *库存量的检测
     *成功：进行库存量的扣除 */
    protected $beforeActionList = [
        "checkExclusiveScope" => ['only' => 'placeOrder']
    ];

    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();
    }
}