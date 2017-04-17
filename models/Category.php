<?php 

namespace app\models;
use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;
// 分类添加更改时候对adminid字段进行插入或更新
use yii\behaviors\BlameableBehavior;

class Category extends ActiveRecord
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                // 自动添加添加分类的管理员id
                'createdByAttribute' => 'adminid',
                'updatedByAttribute' => null,
                'value' => Yii::$app->admin->id,
            ],
        ];
    }
  public static function tableName()
  {
    return "{{%category}}";
  }

  public function attributeLabels()
  {
    return [
      'parentid'=>'上级分类',
      'title' =>'分类名称',
    ];
  }

  public function rules()
  {
    return [
      ['parentid','required','message'=>'上级分类不能为空','except'=>'rename'],
      ['title','required','message'=>'分类标题不能为空'],
      ['createtime','safe'],
    ];
  }

  public function add($data)  // 传递post数据
  {
    $data['Category']['createtime'] = time();
    if($this->load($data) && $this->save()){
      return true;
    }
    return false;
  }

    /**
     * 添加分类页面，将所有分类查询出来
     * @return array|ActiveRecord[]
     */
  public function getData()
  {
    $cates = self::find()->all();     // 把所有数据拿出来
    $cates = ArrayHelper::toArray($cates);   // 转换成数组格式
    return $cates;
  }


  public function getTree($cates,$pid=0)   // 对二维数组进行级别显示 (递归)
  {
    $tree = [];
    foreach($cates as $cate) {
      if($cate['parentid']==$pid){     // 把顶级分类拿出来
        $tree[] = $cate;
        // 合并数组
        $tree = array_merge($tree,$this->getTree($cates,$cate['cateid']) );  // 把所有子类查询出来
      }
    }
    return $tree;
  }

  public function setPrefix($data,$p = "|----")   // 给数据增加前缀，并添加缩进
  {
    $tree = [];
    $num = 1;
    $prefix = [0=>1];
    while($val = current($data)) {
      $key = key($data);
      if($key>0) {
        if($data[$key-1]['parentid']!=$val['parentid']){    //级别改变后
          $num++;
        } 
      }
      if(array_key_exists($val['parentid'],$prefix)){
        $num = $prefix[$val['parentid']];
      }
      $val['title'] = str_repeat($p,$num).$val['title'];    //带前缀
      $prefix[$val['parentid']] = $num;
      $tree[] = $val;
      next($data);      // 往下面走一个指针，不然成死循环

    }
    return $tree;
      
  }

  public function getOptions()      //在下拉菜单中显示
  {
    $data = $this->getData();
    $tree = $this->getTree($data);
    $tree = $this->setPrefix($tree);
    $options = ['添加顶级分类'];
    foreach($tree as $cate) {
      $options[$cate['cateid']]= $cate['title'];
    }
    return $options;
  }

    /**
     *  获取tree中所有数据(最开始的分类列表，后面舍弃了)
     * @return array
     */
  public function getTreelist()
  {
    $data = $this->getData();
    $tree = $this->getTree($data);
    return $tree = $this->setPrefix($tree);
  }

  public static function getMenu()    // 前台显示商品分类
  {
    $top = self::find()->where('parentid = :pid',[":pid"=>0])->limit(8)->orderby('createtime asc')->asArray()->all();
    $data = [];
    foreach((array)$top as $k=>$cate) {
      $cate['children'] = self::find()->where("parentid  =:pid",[':pid' => $cate['cateid']])->limit(10)->asArray()->all();
      $data[$k] = $cate;
    }
//    var_dump($data);die;
    return $data;
  }

    /**
     * 查询所有的顶级分类
     * @return array
     */
  public function getPrimaryCate()
  {
      $data = self::find()->where("parentid = :pid",[":pid"=>0]);
      if(empty($data)){
          return [];
      }
      $pages = new \yii\data\Pagination(['totalCount' => $data->count(), 'pageSize' => '10']);
      $data = $data->orderBy('createtime')->offset($pages->offset)->limit($pages->limit)->all();
      if (empty($data)) {
          return [];
      }
      $primary = [];
      foreach ($data as $cate){
          $primary[] = [
              'id'=>$cate->cateid,
              'text'=>$cate->title,
              'children'=>$this->getChild($cate->cateid)
          ];
      }
      return ['data'=>$primary,'pages'=>$pages];

  }

    /**
     * getChild 递归查询所有子类数据
     * @param $pid
     * @return array
     */
    public function getChild($pid)
    {
        $data = self::find()->where('parentid = :pid', [":pid" => $pid])->all();
        if (empty($data)) {
            return [];
        }
        $children = [];
        foreach ($data as $child) {
            $children[] = [
                "id" => $child->cateid,
                "text" => $child->title,
                "children" => $this->getChild($child->cateid)
            ];
        }
        return $children;
    }
}



