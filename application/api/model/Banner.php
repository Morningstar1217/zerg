<?php
namespace app\api\model;

use think\Exception;
use think\Db;
use think\Model;

class Banner extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time'];

    public function items()
    {

        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    // 修改banner方法对应表
    public static function getBannerByID($id)
    {
        $banner = self::with(['items', 'items.img'])->find($id);
        return $banner;
    }
}