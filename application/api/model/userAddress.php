<?php
namespace app\api\model;

class userAddress extends BaseModel
{
    protected $hidden = ['id', 'delete_time', 'user_id'];
}