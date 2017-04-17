<?php 

namespace app\models;

use yii\db\ActiveRecord;
/**
* 用户详细信息
*/
class Profile extends ActiveRecord
{
  
  public static function tableName()
  {
    return "{{%profile}}";
  }
}