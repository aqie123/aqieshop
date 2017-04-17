<?php
namespace app\models;

use yii\elasticsearch\ActiveRecord;

class ProductSearch extends ActiveRecord
{
    /**
     * 存储属性
     * @return array
     */
    public function attributes()
    {
        return ["productid", "title", "description"];
    }

    /**
     * 索引名称
     * @return string
     */
    public static function index()
    {
        return "aqie_shop";
    }

    /**
     * 返回类型
     * @return string
     */
    public static function type()
    {
        return "products";
    }

}
