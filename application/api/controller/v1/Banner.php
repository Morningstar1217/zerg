<?php
namespace app\api\controller\v1;

use app\api\validate\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;
use think\Exception;
use app\lib\exception\BannerMissException;

class Banner
{
    /*
        @url 路径 /banner/:id
        @http GET
        @id banner的id号
     */
    public function getBanner($id)
    {

        (new IDMustBePostiveInt())->goCheck();

        $banner = BannerModel::getBannerByID($id);
        if (!$banner) {
            throw new BannerMissException();
        }
        return $banner;
    }
}