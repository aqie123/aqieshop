<?php 

namespace app\models;
use yii\db\ActiveRecord;

class Picture extends ActiveRecord
{
  const AK = 'eJCXWlP-XabC6N8YcPk9hOwKBss0hy8IdGLi56di';
  const SK = 'r-odgDnvHzON2r7T1R_lLVvFH6xJXkwygK9dO4o8';
  const DOMAIN = 'http://ole5vzrbd.bkt.clouddn.com/';
  const BUCKET = 'aqie-shop';
  
  public static function tableName()
  {
    return "{{%picture}}";
  }

  public function attributeLabels()
  {
      return [
          'pictures' => '图片',
      ];
  }

  public function rules()
  {
    return [
      [['pictures'],'required'],
    ];
  }

  public function add($data)
  {
    if($this->load($data) && $this->validate()) {
      $this->createtime = time();
      if($this->save()){
        return true;
      }
      return false;
    }
    return false;
  }
}