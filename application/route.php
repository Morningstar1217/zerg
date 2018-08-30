<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

//tp5中用.来表示层级下面的文件夹

//banner路由
Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');
//主题路由
Route::get('api/:version/theme', 'api/:version.Theme/getSimpleList');
//具体主题
Route::get('api/:version/theme/:id', 'api/:version.Theme/getComplexOne');

/* //最新产品
Route::get('api/:version/product/recent', 'api/:version.Product/getRecent');
//获取商品
Route::get('api/:version/product/by_category', 'api/:version.Product/getAllInCategory');
//商品详情
Route::get('api/:version/product/:id', 'api/:version.Product/getOne', [], ['id' => '\d+']);
 */

 //路由分组->匹配性能更高
Route::group('api/:version/product', function () {
    Route::get('/by_category', 'api/:version.Product/getAllInCategory');
    Route::get('/:id', 'api/:version.Product/getOne', [], ['id' => '\d+']);
    Route::get('recent', 'api/:version.Product/getRecent');
});


//产品分类
Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');
//获取token
Route::post('api/:version/token/user', 'api/:version.Token/getToken');
//获取地址
Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');

//订单路由
Route::post('api/:version/order', 'api/:version.Order/placrOrder');
//支付路由
Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');