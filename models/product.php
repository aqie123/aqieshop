<?php 

namespace app\models;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
* 
*/
class Product extends ActiveRecord
{

  const AK = 'eJCXWlP-XabC6N8YcPk9hOwKBss0hy8IdGLi56di';
  const SK = 'r-odgDnvHzON2r7T1R_lLVvFH6xJXkwygK9dO4o8';
  const DOMAIN = 'http://ole5vzrbd.bkt.clouddn.com/';
  const BUCKET = 'aqie-shop';

  public $cate;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                // 创建时间和更新时间属性
                'createdAtAttribute' => 'createtime',
                'updatedAtAttribute' => 'updatetime',
                'attributes' => [
                    // 自动将时间戳插入到数据库
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createtime', 'updatetime'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updatetime'],
                ]
            ]
        ];
    }

  public static function tableName()
  {
    return "{{%product}}";
  }

  public function rules()
  {
    return [
      ['title','required','message'=>'标题不能为空'],
      ['description','required','message'=>'描述不能为空'],
      ['cateid','required','message'=>'分类不能为空'],
      ['price','required','message'=>'商品原价不能为空'],
      ['saleprice','required','message'=>'促销价格不能为空'],
      [['price','saleprice'],'number','min'=>0.01,'message'=>'价格必须是数字'],
      ['num','integer','min'=>0,'message'=>'库存必须是数字'],
      ['num','required','message'=>'库存不能为空'],
      [['issale','ishot','pics','istui'],'safe'],
      [['cover'],'required','on'=>['add']],
    ];
  }

  public function attributeLabels()
  {
      return [
          'cateid' => '分类名称',
          'title'  => '商品名称',
          'description'  => '商品描述',
          'price'  => '商品价格',
          'ishot'  => '是否热卖',
          'issale' => '是否促销',
          'saleprice' => '促销价格',
          'num'    => '库存',
          'cover'  => '图片封面',
          'pics'   => '商品图片',
          'ison'   => '是否上架',
          'istui'   => '是否推荐',
      ];
  }

  /*
  public function add($data)
  {
    if($this->load($data) && $this->validate()) {
      // $this->createtime = time();   // 这个被上面方法代替了
      if($this->save(true)){
        return true;
      }
      return false;
    }
    return false;
  }
  */
    public function add($data)
    {
        $this->scenario = "add";
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }

  public function getCategory()    // 联表查询
  {
    // $this 就是product model拥有category类 product id对应分类里面id
    return $this->hasOne(Category::className(),['cateid'=>'cateid']);
  }
}


