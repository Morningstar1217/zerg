<?php
namespace app\api\service;

class Order
{
    //订单的商品列表  客户端传递过来的products参数
    protected $oProducts;
    //数据库查询出来的products  真实的商品信息
    protected $products;
    //
    protected $uid;

    public function place($uid, $oProducts)
    {
    //oProducts和products做对比
        $this->oProducts = $oProducts;
        $this->getProductsByOrder($oProducts);
        $this->uid = $uid;
    }

    //根据订单信息查找真实的商品信息
    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        } 
    }
}