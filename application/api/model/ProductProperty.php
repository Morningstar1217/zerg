<?php
namespace app\api\model;

class ProductProperty extends BaseModel
{
    protected $hidden = [
        'product_id', 'selete_time', 'id'
    ];
}