<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     *  命令行执行 yii rbac/init
     * 利用正则获取到 控制器下所有方法 ; category/*  category/add
     * 将上面方法插入到数据表
     */
    public function actionInit()
    {
        // 开启事务
        $trans = Yii::$app->db->beginTransaction();
        try{
            // 后台控制器目录
            $dir = dirname(dirname(__FILE__)).'/modules/controllers';
            // 找后台控制器目录下所有文件
            $controllers = glob($dir.'/*');
             //var_dump($controllers);  //目录下所有控制器
            $permissions = [];
            foreach($controllers as $controller){
                $content = file_get_contents($controller);
                // var_dump($content);
                preg_match('/class ([a-zA-Z]+)Controller/',$content,$match); // match匹配内容
                $cName = $match[1];     // 拿到控制器名称 match[1]也是个数组
                //var_dump($cName);
                $permissions[] = strtolower($cName.'/*');
                //var_dump($permissions);
                preg_match_all('/public function action([a-zA-Z_]+)/',$content,$matches);
                // var_dump($matches);
                foreach($matches[1] as $aName) {      // 1本身就是个数组
                    //var_dump($aName);
                    $permissions[] = strtolower($cName.'/'.$aName);  // 控制器+* 和控制器所有方法
                }
            }
            // var_dump($permissions);   拿到所有权限
            $auth = Yii::$app->authManager;
            // 向数据表中插入
            foreach($permissions as $permission){
                if(!$auth->getPermission($permission)){ //如果获取不到
                    $obj = $auth->createPermission($permission);
                    $obj->description = $permission;
                    $auth->add($obj);       // 插入权限到数据表shop_auth_item
                }
            }
            $trans->commit();
            echo "import success \n";
        }catch (\Exception $e){
            $trans->rollBack();
            echo "import failed \n";
        }
    }
}