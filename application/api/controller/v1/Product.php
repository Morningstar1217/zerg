<?php
namespace app\api\controller\v1;

use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\ProductException;
use app\api\validate\IDMustBePostiveInt;

class Product
{
    //获取最新商品
    public function getRecent($count = 10)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);

        if ($products->isEmpty()) {
            throw new ProductException();
        }

        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getAllInCategory($id)
    {
        (new IDMustBePostiveInt())->goCheck();

        $products = ProductModel::getProductByCategoryID($id);

        if ($products->isEmpty()) {
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

    //获取详情
    public function getOne($id)
    {
        (new IDMustBePostiveInt())->goCheck();

        $product = ProductModel::getProductDetail($id);
        if (!$product) {
            throw new ProductException();
        }
        return $product;
    }

    //删除商品
    public function deleteOne($id)
    {
        
    }
}