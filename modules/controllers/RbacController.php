<?php

namespace app\modules\controllers;

use Yii;
use \yii\data\ActiveDataProvider;  // actionRoles   gridview
use \yii\db\Query;
use app\modules\models\Rbac;

class RbacController extends CommonController
{
    public $mustlogin = ['createrule', 'createrole', 'roles', 'assignitem'];

    /**
     * 添加角色
     * @return string
     * @throws \Exception
     */
    public function actionCreaterole()
    {
        // 如果是post提交
        if(Yii::$app->request->isPost){
            $auth = Yii::$app->authManager;     // 实例化DbManager
            // var_dump($auth);die;  // 对象
            // 创建一个名称
            $role = $auth->createRole(null);
             //var_dump($role);die;       // auth_item表结构
            $post = Yii::$app->request->post();
            if(empty($post['name']) || empty($post['description'])){
                throw new \Exception('参数错误,不能为空');
            }
            $role->name = $post['name'];
            $role->description = $post['description'];
            $role->ruleName = empty($post['rule_name']) ? null : $post['rule_name'];
            $role->data = empty($post['data']) ? null : $post['data'];
            // 对象调用add方法向数据表中写入数据
            if($auth->add($role)){
                Yii::$app->session->setFlash('info','添加角色成功');
            }
        }
        return $this->render('_createitem');

    }

    /**
     * 加载角色列表
     * @return string
     */
    public function actionRoles()
    {
        $auth = Yii::$app->authManager;
        // 通过provider方式将数据传递到模板
        $data = new ActiveDataProvider([
            // 根据什么形式将数据查询出来
            'query' => (new Query)->from($auth->itemTable)->where('type = 1')->orderBy('created_at desc'),
            'pagination' => ['pageSize' => 5],
        ]);
        // var_dump($data);die;
        return $this->render('_items', ['dataProvider' => $data]);
    }

    /**
     * 给角色分配权限
     * @param $name （角色名称）
     * @return string
     */
    public function actionAssignitem($name)
    {
        $name = htmlspecialchars($name);        // 防止注入
        // 拿到auth对象
        $auth = Yii::$app->authManager;
        //  var_dump($auth->getRoles());exit;  //所有角色信息
        //  var_dump($auth->getPermissions());    //所有的权限
        $parent = $auth->getRole($name);
        // 点击提交进行判断
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            // 给这个nama分配所有childred
            if (Rbac::addChild($post['children'], $name)) {
                Yii::$app->session->setFlash('info', '分配成功');
            }
        }

        // 将已经分配权限勾选上
        $children = Rbac::getChildrenByName($name);
         // var_dump($children);die;        // 创建的角色下面所有权限  (刚开始创建roles为空)
         // 获取角色和权限信息
        $roles = Rbac::getOptions($auth->getRoles(), $parent);
        $permissions = Rbac::getOptions($auth->getPermissions(), $parent);
        // var_dump($roles);die;  // 所有角色
        // var_dump($permissions );die;     // 所有权限
        // 数据展示到页面
        return $this->render('_assignitem',['parent' => $name, 'roles' => $roles, 'permissions' => $permissions, 'children' => $children]);
    }

    /**
     * 创建规则
     * @return string
     * @throws \Exception
     */
    public function actionCreaterule()
    {
        // 有提交数据
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (empty($post['class_name'])) {
                throw new \Exception('类名称为空 参数错误');
            }
            // 一定要有命名空间
            $className = "app\\models\\". $post['class_name'];
            if (!class_exists($className)) {
                throw new \Exception('规则类不存在');
            }
            // 实例化 就是model里面新建的类AuthorRule.php
            $rule = new $className;
            if (Yii::$app->authManager->add($rule)) {
                Yii::$app->session->setFlash('info', '添加成功');
            }
        }
        return $this->render("_createrule");
    }

}