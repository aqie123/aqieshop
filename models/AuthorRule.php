<?php
namespace app\models;

// 不再继承model继承Rule类
use yii\rbac\Rule;// execute

use Yii;

class AuthorRule extends Rule
{
    // 指定规则名称名称
    public $name = "isAuthor";

    /**
     * 点击添加  实现自动向数据库加载规则
     * @param int|string $user  (当前登录用户id)
     * @param \yii\rbac\Item $item (额外判断)
     * @param array $params         (相关参数)
     * @return bool     (返回真代表有权限)
     */
    public function execute($user, $item, $params)
    {
        // 控制器方法名称
        $action = Yii::$app->controller->action->id;

        if ($action == 'delete') {
            $cateid = Yii::$app->request->get("id");
            $cate = Category::findOne($cateid);
            return $cate->adminid == $user;
        }

        return true;

    }

}