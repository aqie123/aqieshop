<?php  

namespace app\models;

use yii\db\ActiveRecord;

/**
* 返回模型操作数据表名称
*/
class Test extends ActiveRecord
{
  public static function tableName(){
    // 数据库表名{{%}}代替表前缀
    return "{{%test}}";
  }
}