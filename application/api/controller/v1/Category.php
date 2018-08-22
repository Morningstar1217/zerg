<?php
namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\api\validate\CategoryException;

class Category
{
    public function getAllCategories()
    {
        $categories = CategoryModel::all([], 'img');

        if ($categories->isEmpty()) {
            throw new CategoryException();
        }

        return $categories;
    }
}